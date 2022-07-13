<?php
namespace app\modules\answering\commands;

use Yii;
use app\models\Exam;
use app\models\Post;
use yii\db\Expression;
use app\models\Category;
use yii\helpers\Console;
use app\models\ExamAnswer;
use yii\console\Controller;
use app\models\ExamParticipant;
use app\models\TestGroup\Group2;

class RunController extends Controller
{
    public function actionCheck($id)
    {
        $file = 'web/answers/'.$id.'.json';
        echo 'finding '.$file ."\n";
        if(file_exists($file))
        {
            echo 'file '.$file.' found and execute'."\n";
            $data = file_get_contents($file);
            if(empty($data) || $data == null || $data == "") return;
            $data = json_decode($data,1);
            print_r($data);
        }
    }

    public function actionIndex($id)
    {
        $examParticipant = ExamParticipant::find()->where([
            'exam_id' => $id,
            'status'  => 'finish',
            'queue_status' => 0
        ])->all();
        foreach($examParticipant as $examPart)
        {
            $file = 'web/answers/'.$id.'-'.$examPart->participant->id_number.'.json';
            echo 'finding '.$file ."\n";
            if(file_exists($file))
            {
                echo 'file '.$file.' found and execute'."\n";
                $data = file_get_contents($file);
                if(empty($data) || $data == null || $data == "") continue;
                $data = json_decode($data,1);
                if(!is_array($data)) continue;
                foreach($data as $key => $jawaban)
                {
                    if($jawaban == null) continue;
                    $ml_label = '';
                    if(strpos($key,'-') !== false)
                    {
                        $jwb_arr = explode('-',$key);
                        $key = $jwb_arr[0];
                        $ml_label = $jwb_arr[1];
                    }
                    $clause = [
                        'exam_id'=>$id,
                        'question_id'=>$key,
                        'participant_id'=>$examPart->participant_id,
                    ];
                    if($ml_label != '')
                        $clause['answer_content'] = $ml_label;
                    $exam_answer = ExamAnswer::find()->where($clause);
                    $post = Post::find()->where(['id'=>$jawaban])->one();
                    $answer = new ExamAnswer();
                    if($exam_answer->exists()){
                        $answer = $exam_answer->one();
                    }

                    $answer->exam_id = $id;
                    $answer->question_id = $key;
                    $answer->participant_id = $examPart->participant_id;
                    $answer->answer_id = $jawaban;
                    $answer->answer_content = $ml_label == '' ? $post->post_content : $ml_label;
                    $answer->score = $post->post_type;

                    $answer->save(false);

                }
            }

            $examPart->queue_status = 1;
            $examPart->save(false);
        }
        echo "Success\n";
    }

    public function actionReindex($id)
    {
        $examParticipant = ExamParticipant::find()->where([
            'exam_id' => $id,
            'status'  => 'finish',
            // 'queue_status' => 0
        ])->all();
        foreach($examParticipant as $examPart)
        {
            $file = 'web/answers/'.$id.'-'.$examPart->participant->id_number.'.json';
            echo 'finding '.$file ."\n";
            if(file_exists($file))
            {
                echo 'file '.$file.' found and execute'."\n";
                $data = file_get_contents($file);
                if(empty($data) || $data == null || $data == "") continue;
                $data = json_decode($data,1);
                if(!is_array($data)) continue;
                foreach($data as $key => $jawaban)
                {
                    if($jawaban == null) continue;
                    $exam_answer = ExamAnswer::find()->where([
                        'exam_id'=>$id,
                        'question_id'=>$key,
                        'participant_id'=>$examPart->participant_id,
                    ]);
                    $post = Post::find()->where(['id'=>$jawaban])->one();
                    $answer = new ExamAnswer();
                    if($exam_answer->exists()){
                        $answer = $exam_answer->one();
                    }

                    $answer->exam_id = $id;
                    $answer->question_id = $key;
                    $answer->participant_id = $examPart->participant_id;
                    $answer->answer_id = $jawaban;
                    $answer->answer_content = $post->post_content;
                    $answer->score = $post->post_type;

                    $answer->save(false);

                }
            }

            $examPart->queue_status = 1;
            $examPart->save(false);
        }
        echo "Success\n";
    }

    public function actionNew($id)
    {
        $examParticipant = ExamParticipant::find()->where([
            'exam_id' => $id,
            'status'  => 'finish',
            // 'queue_status' => 0
        ])->all();
        foreach($examParticipant as $examPart)
        {
            $file = 'web/answers/'.$id.'-'.$examPart->participant->id_number.'.json';
            echo 'finding '.$file ."\n";
            if(file_exists($file))
            {
                echo 'file '.$file.' found and execute'."\n";
                $data = file_get_contents($file);
                if(empty($data) || $data == null || $data == "") continue;
                // $data = json_decode($data,1);
                $data = str_split($data,4);
                foreach($data as $jawaban)
                {
                    $post = Post::find()->where(['id'=>$jawaban])->one();
                    $exam_answer = ExamAnswer::find()->where([
                        'exam_id'=>$id,
                        'question_id'=>$post->parent->id,
                        'participant_id'=>$examPart->participant_id,
                    ]);
                    $answer = new ExamAnswer();
                    if($exam_answer->exists()){
                        $answer = $exam_answer->one();
                    }

                    $answer->exam_id = $id;
                    $answer->question_id = $post->parent->id;
                    $answer->participant_id = $examPart->participant_id;
                    $answer->answer_id = $jawaban;
                    $answer->answer_content = $post->post_content;
                    $answer->score = $post->post_type;

                    $answer->save(false);

                }
            }

            $examPart->queue_status = 1;
            $examPart->save(false);
        }
        echo "Success\n";
    }

    function actionPatchscore()
    {
        $categories = Category::find()->where(['test_tool'=>'PAPIKOSTICK'])->all();
        foreach($categories as $cat)
        {
            foreach($cat->questions as $question)
            {
                $exam_answers = ExamAnswer::find()->where(['question_id'=>$question->id])->all();
                foreach($exam_answers as $answer)
                {
                    $post_answer = Post::findOne($answer->answer_id);
                    $answer->score = $post_answer->post_type;
                    $answer->save(false);
                }
            }
        }

        echo "Success\n";
    }

    public function actionScore($id)
    {
        $examParticipant = ExamParticipant::find()->where([
            'exam_id' => $id,
            'status'  => 'finish',
            // 'queue_status' => 0
        ])->all();
        foreach($examParticipant as $examPart)
        {
            echo "Set Score for ".$examPart->participant->id_number."\n";
            $exam   = $examPart->exam;
            $test_group = \Yii::$app->params['test_group'];
            $test_group = $test_group[$exam->test_group];
            $tools = $test_group['tools'];
            $categories = Category::find()->where(['in','test_tool',$tools])->all();
            foreach($categories as $cat)
            {
                // ambil pertanyaan
                foreach($cat->questions as $question)
                {
                    // get jawaban berdasarkan soal dan peserta
                    $exam_answer = ExamAnswer::find()->where(['question_id'=>$question->id,'participant_id'=>$examPart->participant_id]); // ->all();

                    // cek apakah soal sudah di jawab
                    if($exam_answer->exists()) continue;

                    $jawaban = $question->getItems()
                    ->orderBy(new Expression('rand()'))
                    ->asArray()->one();

                    // jika soal belum di jawab
                    $answer = new ExamAnswer();
                    $answer->exam_id = $id;
                    $answer->question_id = $question->id;
                    $answer->participant_id = $examPart->participant_id;
                    $answer->answer_id = $jawaban['id'];
                    $answer->answer_content = $jawaban['post_content'];
                    $answer->score = $jawaban['post_type'];

                    $answer->save(false);
                }
            }
        }
        echo "Success\n";
    }

    public function actionImjScore($id)
    {
        $examParticipant = ExamParticipant::find()->where([
            'exam_id' => $id,
            'status'  => 'finish',
            // 'queue_status' => 0
        ])->all();
        $id_number = [
            '0059007631',
            '0067024783',
            '0067783664'
        ];
        foreach($examParticipant as $examPart)
        {
            if(!in_array($examPart->participant->id_number, $id_number)) continue;
            echo "Set Score for ".$examPart->participant->id_number."\n";
            $exam   = $examPart->exam;
            $test_group = \Yii::$app->params['test_group'];
            $test_group = $test_group[$exam->test_group];
            $tools = ['IMJ']; // $test_group['tools'];
            $categories = Category::find()->where(['in','test_tool',$tools])->all();
            foreach($categories as $cat)
            {
                // ambil pertanyaan
                foreach($cat->questions as $question)
                {
                    // get jawaban berdasarkan soal dan peserta
                    $exam_answer = ExamAnswer::find()->where(['question_id'=>$question->id,'participant_id'=>$examPart->participant_id]); // ->all();

                    // cek apakah soal sudah di jawab
                    if($exam_answer->exists()) continue;

                    $jawaban = $question->getItems()
                    ->orderBy(new Expression('rand()'))
                    ->asArray()->one();

                    // jika soal belum di jawab
                    $answer = new ExamAnswer();
                    $answer->exam_id = $id;
                    $answer->question_id = $question->id;
                    $answer->participant_id = $examPart->participant_id;
                    $answer->answer_id = $jawaban['id'];
                    $answer->answer_content = $jawaban['post_content'];
                    $answer->score = $jawaban['post_type'];

                    $answer->save(false);
                }
            }
        }
        echo "Success\n";
    }

    public function actionCorrection1()
    {
        // except cfit 2
        $connection = Yii::$app->getDb();
        $command = $connection->createCommand("
        UPDATE exam_answers ea,
            posts p
        SET    ea.score = p.post_type
        WHERE  ea.score IS NULL 
            AND p.id = ea.answer_id 
            AND ea.answer_id IS NOT NULL 
            AND ea.exam_id > 2");

        $command->queryAll();

    }
    
    public function actionCorrection3()
    {
        // updated and please using this
        $connection = Yii::$app->getDb();
        $command = $connection->createCommand("
        UPDATE exam_answers ea,
            posts p
        SET    ea.score = p.post_type
        WHERE  ea.score IS NULL 
            AND ea.answer_content REGEXP '^[0-9]+$'
            AND p.id = ea.answer_content
            AND ea.exam_id > 2");

        $command->queryAll();

    }
    
    public function actionCorrectioncfit1()
    {
        // for cfit true
        $connection = Yii::$app->getDb();
        $command = $connection->createCommand("
        UPDATE exam_answers ea,
            posts p, posts a, post_items pi
        SET    ea.score = 1
        WHERE  ea.score IS NULL 
            AND p.id = ea.question_id
            AND pi.parent_id = p.id
            AND a.id = pi.child_id
            AND ea.answer_content = a.post_content
            AND ea.exam_id > 2");

        $command->queryAll();

    }
    
    public function actionCorrectioncfit2()
    {
        // for cfit false
        $connection = Yii::$app->getDb();
        $command = $connection->createCommand("
        UPDATE exam_answers ea,
            posts p, posts a, post_items pi
        SET    ea.score = 0
        WHERE  ea.score IS NULL 
            AND p.id = ea.question_id
            AND pi.parent_id = p.id
            AND a.id = pi.child_id
            AND ea.answer_content != a.post_content
            AND ea.exam_id > 2");

        $command->queryAll();

    }

    public function actionDeletecfit2()
    {
        // except cfit 2
        $connection = Yii::$app->getDb();
        $command = $connection->createCommand("
        DELETE FROM exam_answers
        WHERE  answer_id IS NULL");

        $command->queryAll();

    }

    public function actionCorrection2()
    {
        // for cfit 2
        $examAnswers = ExamAnswer::find()
                ->where([
                    'score' => null,
                    'answer_id' => null
                ])
                ->joinWith(['question.items'])
                ->all();
        foreach($examAnswers as $examAnswer)
        {
            echo "Do ID : ".$examAnswer->id." Jawaban ".$examAnswer->answer_content."\n";
            $item = $examAnswer->question->items[0];
            $examAnswer->score = $item->post_content == $examAnswer->answer_content ? 1 : 0;
            $examAnswer->save();
            echo "Finish ID : ".$examAnswer->id."\n";
        }
    }

    public function actionCfit2()
    {
        $post = Post::find()
                ->where(['like','post_title','%CFIT 2%',false])
                ->andWhere(['post_as' => 'Jawaban'])
                ->andWhere(['post_date' => null])
                ->joinWith(['postItem'])
                ->asArray()
                ->one();

        $examParticipants = ExamParticipant::find()
                ->where(['>', 'exam_id', 2])
                // ->andWhere(['>', 'participant_id', 1911])
                ->andWhere(['not',['status' => null]])
                ->asArray()
                ->all();

        foreach($examParticipants as $examParticipant)
        {

            echo "Start ID : ".$examParticipant['participant_id']."\n";
            $max = rand(3,9);
            // $_posts = array_slice($posts, 0, $max);
            // foreach($_posts as $post)
            // {
            //     $ExamAnswer = new ExamAnswer;
            //     $ExamAnswer->exam_id = $examParticipant['exam_id'];
            //     $ExamAnswer->participant_id = $examParticipant['participant_id'];
            //     $ExamAnswer->question_id = $post['postItem']['parent_id'];
            //     $ExamAnswer->answer_content = $post['post_content'];
            //     $ExamAnswer->score = 1;
            //     $ExamAnswer->save();
            // }
            $ExamAnswer = new ExamAnswer;
            $ExamAnswer->exam_id = $examParticipant['exam_id'];
            $ExamAnswer->participant_id = $examParticipant['participant_id'];
            $ExamAnswer->question_id = $post['postItem']['parent_id'];
            $ExamAnswer->answer_content = $post['post_content'];
            $ExamAnswer->score = $max;
            $ExamAnswer->save();
            echo "End ID : ".$examParticipant['participant_id']."\n";
        }
    }

    public function actionGenerateReport($id)
    {
        // \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        if(isset($_GET['bulk_print']))
        {
            $model = Exam::find()->where([
                'exams.id'=>$id,
            ])
            ->joinWith([
                'participants' => function($query){
                    $query->where(['in','participants.id',$_GET['bulk_print']]);
                },
                'participants.user',
                'participants.user.metas',
                'participants.examAnswers',
                'participants.examAnswers.answer',
                'participants.examAnswers.question',
                'participants.examAnswers.question.items',
                'participants.examAnswers.question.categoryPost'
            ])
            // ->asArray()
            ->one();
        }
        else
        {
            $model = Exam::find()->where([
                'exams.id'=>$id,
            ])
            ->joinWith([
                'participants',
                'participants.user',
                'participants.user.metas',
                'participants.examAnswers',
                'participants.examAnswers.answer',
                'participants.examAnswers.question',
                'participants.examAnswers.question.items',
                'participants.examAnswers.question.categoryPost'
            ])
            // ->asArray()
            ->one();
        }


        $report = (new Group2)->report($model);
        $content = $report->render();

        if(!isset($_GET['debug']))
        {
            header("Content-type: application/vnd-ms-excel");
            header("Content-Disposition: attachment; filename=Report-".$model->name.".xls");
        }

        return $content;
    }
}