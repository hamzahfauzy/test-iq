<?php
namespace app\modules\answering\commands;

use app\models\Exam;
use app\models\Post;
use app\models\Category;
use yii\helpers\Console;
use app\models\ExamAnswer;
use yii\console\Controller;
use app\models\ExamParticipant;

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
                if(!$data) continue;
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
}