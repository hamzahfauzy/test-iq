<?php

namespace app\controllers;

use Yii;
use app\models\Exam;
use yii\web\Controller;
use app\models\ExamAnswer;
use app\models\Participant;
use yii\filters\VerbFilter;
use app\models\ExamCategory;
use Spipu\Html2Pdf\Html2Pdf;
use yii\helpers\ArrayHelper;
use app\models\ExamParticipant;
use yii\web\NotFoundHttpException;
use app\models\ExamParticipantSearch;

/**
 * ExamParticipantController implements the CRUD actions for ExamParticipant model.
 */
class ExamParticipantController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all ExamParticipant models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ExamParticipantSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    function actionDownload($id)
    {
        // \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $examParticipant = $this->findModel($id);
        $peserta = $examParticipant->participant;
        $participant = Participant::find()->where([
                    'participants.id'=>$examParticipant->participant_id,
                ])
                ->joinWith([
                    'examAnswers' => function($q) use ($examParticipant){
                        $q->andWhere(['exam_id' => $examParticipant->exam_id]);
                    },
                    'examAnswers.answer',
                    'examAnswers.question',
                    'examAnswers.question.items',
                    'examAnswers.question.categoryPost'
                ])->asArray()->one();
        // return $model;
        $report = [];
        $part = Participant::findOne($participant['id']);
        $participant['name'] = $part->name; // ->getMeta('nama_lengkap');
        $participant['school'] = $examParticipant->exam->name;
        $participant['study'] = $part->getMeta('pelajaran');
        $participant['work_time'] = $part->getMeta('lama_bekerja');
        $score = ['CFIT'=>0,'Papikostick'=>""];
        $partial_cfit = [
            'CFIT 1'=>0,'CFIT 2'=>0,'CFIT 3'=>0,'CFIT 4'=>0
        ];
        foreach($participant['examAnswers'] as $answer)
        {
            // CFIT -> score add 
            // PAPICOSTIC
            $cfit = ['CFIT 1','CFIT 2','CFIT 3','CFIT 4'];

            $_papikosticks = ['Soal Papikostik (Halaman 1)','Soal Papikostik (Halaman 2)','Soal Papikostik (Halaman 3)'];
            if(in_array($answer['question']['categoryPost']['name'],$cfit))
            {
                if($answer['answer'])
                {
                    $score['CFIT'] += (int) $answer['answer']['post_type'];
                    $partial_cfit[$answer['question']['categoryPost']['name']] += (int) $answer['answer']['post_type'];
                }
                else
                {
                    $question_answer = $answer['question']['items'][0];
                    $score['CFIT'] += $answer['answer_content'] == $question_answer['post_content'] ? 1 : 0;
                    $partial_cfit[$answer['question']['categoryPost']['name']] += $answer['answer_content'] == $question_answer['post_content'] ? 1 : 0;
                }
            }
            elseif(in_array($answer['question']['categoryPost']['name'],$_papikosticks))
                $score['Papikostick'] .= $answer['answer']['post_type'];
            elseif(isset($score[$answer['question']['categoryPost']['name']]))
                $score[$answer['question']['categoryPost']['name']] .= $answer['answer']['post_type'];
        }
        $score['partial_cfit'] = $partial_cfit;
        $cfit_maps = [];
        $cfit_maps[0] = 38;
        $cfit_maps[1] = 40;
        $cfit_maps[2] = 43;
        $cfit_maps[3] = 45;
        $cfit_maps[4] = 47;
        $cfit_maps[5] = 48;
        $cfit_maps[6] = 52;
        $cfit_maps[7] = 55;
        $cfit_maps[8] = 57;
        $cfit_maps[9] = 60;
        $cfit_maps[10] = 63;
        $cfit_maps[11] = 67;
        $cfit_maps[12] = 70;
        $cfit_maps[13] = 72;
        $cfit_maps[14] = 75;
        $cfit_maps[15] = 78;
        $cfit_maps[16] = 81;
        $cfit_maps[17] = 84;
        $cfit_maps[18] = 88;
        $cfit_maps[19] = 91;
        $cfit_maps[20] = 94;
        $cfit_maps[21] = 96;
        $cfit_maps[22] = 100;
        $cfit_maps[23] = 103;
        $cfit_maps[24] = 106;
        $cfit_maps[25] = 109;
        $cfit_maps[26] = 113;
        $cfit_maps[27] = 116;
        $cfit_maps[28] = 119;
        $cfit_maps[29] = 121;
        $cfit_maps[30] = 124;
        $cfit_maps[31] = 128;
        $cfit_maps[32] = 131;
        $cfit_maps[33] = 133;
        $cfit_maps[34] = 137;
        $cfit_maps[35] = 140;
        $cfit_maps[36] = 142;
        $cfit_maps[37] = 145;
        $cfit_maps[38] = 149;
        $cfit_maps[39] = 152;
        $cfit_maps[40] = 155;
        $cfit_maps[41] = 157;
        $cfit_maps[42] = 161;
        $cfit_maps[43] = 165;
        $cfit_maps[44] = 167;
        $cfit_maps[45] = 169;
        $cfit_maps[46] = 173;
        $cfit_maps[47] = 176;
        $cfit_maps[48] = 179;
        $cfit_maps[49] = 183;
        $cfit_maps[50] = 183;
        $score['CFIT'] = $cfit_maps[$score['CFIT']];
        unset($participant['examAnswers']);
        $papikosticks = $score['Papikostick'];
        $papikosticks = str_split($papikosticks);
        $p_v = [
            "N"=>0,
            "F"=>0,
            "G"=>0,
            "A"=>0,
            "O"=>0,
            "Z"=>0,
            "E"=>0,
            "S"=>0,
            "I"=>0,
            "L"=>0,
            "P"=>0,
        ];
        $p_v_all = [
            "G"=>0,
            "L"=>0,
            "I"=>0,
            "T"=>0,
            "V"=>0,
            "S"=>0,
            "R"=>0,
            "D"=>0,
            "C"=>0,
            "E"=>0,
            "N"=>0,
            "A"=>0,
            "P"=>0,
            "X"=>0,
            "B"=>0,
            "O"=>0,
            "Z"=>0,
            "K"=>0,
            "F"=>0,
            "W"=>0,
        ];
        foreach($papikosticks as $p)
        {
            if(isset($p_v[$p])) $p_v[$p]++;
            if(isset($p_v_all[$p])) $p_v_all[$p]++;
        }
            
        $score['Papikostick'] = $p_v;
        $score['PapikostickAll'] = $p_v_all;

        $participant['score'] = $score;

        // header("Content-type: application/vnd-ms-excel");
        // header("Content-Disposition: attachment; filename=Report-".$model['name'].".xls");

        $content = $this->renderPartial('report', [
            'participant' => $participant,
            'peserta' => $peserta,
            'examParticipant' => $examParticipant,
        ]);

        // return $content;
        $html2pdf = new Html2Pdf();
        $html2pdf->writeHTML($content);
        $html2pdf->output();
        return;
    }

    /**
     * Displays a single ExamParticipant model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new ExamParticipant model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($exam_id)
    {
        $model = new ExamParticipant();
        $model->exam_id = $exam_id;
       
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['exam/view', 'id' => $model->exam_id]);
        }

        $exam = Exam::findOne($exam_id);
        $current_participants = ArrayHelper::map($exam->participants,'id','id');
        $participants = Participant::find()->where(['not in','id',$current_participants])->all();
        $participants = ArrayHelper::map($participants,'id','name');

        return $this->render('create', [
            'model' => $model,
            'participants' => $participants,
        ]);
    }

    /**
     * Updates an existing ExamParticipant model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing ExamParticipant model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $exam_id = $model->exam_id;
        $model->delete();

        return $this->redirect(['exam/view','id'=>$exam_id]);
    }

    /**
     * Finds the ExamParticipant model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ExamParticipant the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ExamParticipant::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionReset($id)
    {
        $model = $this->findModel($id);

        // ExamAnswer::deleteAll(['exam_id'=>$model->exam_id,'participant_id'=>$model->participant_id]);
        ExamCategory::deleteAll(['exam_id'=>$model->exam_id,'participant_id'=>$model->participant_id]);

        $model->status = "";
        $model->finished_at = NULL;
        $model->save();
        
        return $this->redirect(['exam/view','id'=>$model->exam_id]);
    }
}
