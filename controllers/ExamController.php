<?php

namespace app\controllers;

use Yii;
use app\models\Exam;
use app\models\ExamSearch;
use app\models\ExamParticipantSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ExamController implements the CRUD actions for Exam model.
 */
class ExamController extends Controller
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
     * Lists all Exam models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ExamSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Exam model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $searchModel = new ExamParticipantSearch();
        $queryParams = Yii::$app->request->queryParams;
        $queryParams['ExamParticipantSearch']['exam_id'] = $id;
        $dataProvider = $searchModel->search($queryParams);
        return $this->render('view', [
            'model' => $this->findModel($id),
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionParticipants()
    {
        $searchModel = new ExamParticipantSearch();
        $queryParams = Yii::$app->request->queryParams;
        $dataProvider = $searchModel->search($queryParams);
        return $this->render('participants', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Exam model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Exam();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Exam model.
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

    function actionDownload($id)
    {
        // \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model = Exam::find()->where([
                    'exams.id'=>$id
                ])
                ->joinWith([
                    'participants',
                    'participants.examAnswers',
                    'participants.examAnswers.answer',
                    'participants.examAnswers.question',
                    'participants.examAnswers.question.items',
                    'participants.examAnswers.question.categoryPost'
                ])->asArray()->one();
        // return $model;
        $report = [];
        foreach($model['participants'] as $participant)
        {
            $score = ['CFIT'=>0,'Papikostick'=>"",'MSDT'=>""];
            foreach($participant['examAnswers'] as $answer)
            {
                // CFIT -> score add 
                // PAPICOSTIC
                // MSDT
                $cfit = ['CFIT 1','CFIT 2','CFIT 3','CFIT 4'];
                if(in_array($answer['question']['categoryPost']['name'],$cfit))
                {
                    if($answer['answer'])
                        $score['CFIT'] += (int) $answer['answer']['post_type'];
                    else
                    {
                        $question_answer = $answer['question']['items'][0];
                        $score['CFIT'] += $answer['answer_content'] == $question_answer['post_content'] ? 1 : 0;
                    }
                }
                else
                    $score[$answer['question']['categoryPost']['name']] .= $answer['answer']['post_type'];
            }
            unset($participant['examAnswers']);
            $papikosticks = $score['Papikostick'];
            $papikosticks = str_split($papikosticks);
            $p_v = [
                "G"=>0,
                "A"=>0,
                "N"=>0,
                "F"=>0,
                "Z"=>0,
                "E"=>0,
                "S"=>0,
                "O"=>0
            ];
            foreach($papikosticks as $p)
                if(isset($p_v[$p])) $p_v[$p]++;

            $score['Papikostick'] = $p_v;

            // MSDT
            $msdt = $score['MSDT'];
            $msdt_value = str_split($msdt);
            $msdt_val = array_chunk($msdt_value,8);
            $A = [0,0,0,0,0,0,0,0];
            $B = [0,0,0,0,0,0,0,0];
            // norma msdt
            $norma_koreksi_msdt = [1,2,1,0,3,-1,0,-4];
            $jumlah = [];
            $msdt_section = ["TO"=>0,"RO"=>0,"E"=>0,"O"=>0];
            $msdt_result_value = [0,0.6,1.2,1.8,2.4,3.0,3.6,4.0];
            $msdt_result_range = [
                [0,29],
                [30,31],
                [32,32],
                [33,33],
                [34,34],
                [35,35],
                [36,37],
                [38,100],
            ];
            $msdt_final_result = [];

            foreach($msdt_val as $key => $val)
            {
                foreach($val as $v)
                {
                    if(isset($A[$key]) && $v == 'A') $A[$key]++;
                    elseif($v == 'A') $A[$key] = 1;
                    else $A[$key] = 0;
                }
            }

            foreach($msdt_val as $val)
            {
                foreach($val as $key => $v)
                {
                    if(isset($B[$key]) && $v == 'B') $B[$key]++;
                    elseif($v == 'B') $B[$key] = 1;
                    else $B[$key] = 0;
                }
            }

            for($i=0;$i<8;$i++)
            {
                $jlh = $A[$i]+$B[$i]+$norma_koreksi_msdt[$i];
                $jumlah[$i] = $jlh;
                $n = $i+1;
                if(in_array($n,[3,4,7,8])) $msdt_section['TO'] += $jlh;
                if(in_array($n,[2,4,6,8])) $msdt_section['RO'] += $jlh;
                if(in_array($n,[5,6,7,8])) $msdt_section['E'] += $jlh;
                if(in_array($n,[1])) $msdt_section['O'] += $jlh;
            }

            foreach($msdt_section as $section_key => $section_value)
            {
                $value_key = 0;
                foreach($msdt_result_range as $key_range => $value_range)
                {
                    if($section_value >= $value_range[0] && $section_value <= $value_range[0])
                    {
                        $value_key = $key_range;
                        break;
                    }
                }
                $msdt_final_result[$section_key] = $msdt_result_value[$value_key];
            }

            $result = "";
            $msdt_final_value = 0;
            if($msdt_final_result['TO'] > 2)
            {
                if($msdt_final_result['RO'] > 2)
                {
                    if($msdt_final_result['E'] > 2)
                    {
                        $result = "Executive";
                    }
                    else
                    {
                        $result = "Compromiser";
                    }
                    $msdt_final_value = 5;
                }
                else
                {
                    if($msdt_final_result['E'] > 2)
                    {
                        $result = "Benevolent Autocratic";
                    }
                    else
                    {
                        $result = "Autocratic";
                    }
                    $msdt_final_value = 4;
                }
            }
            else
            {
                if($msdt_final_result['RO'] > 2)
                {
                    if($msdt_final_result['E'] > 2)
                    {
                        $result = "Developer";
                    }
                    else
                    {
                        $result = "Missionary";
                    }
                    $msdt_final_value = 2;
                }
                else
                {
                    if($msdt_final_result['E'] > 2)
                    {
                        $result = "Bureaucratic";
                    }
                    else
                    {
                        $result = "Deserter";
                    }
                    $msdt_final_value = 2;
                }
            }

            $score['MSDT'] = [
                'A'=>$A,
                'B'=>$B,
                'jumlah'=>$jumlah,
                'msdt_section'=>$msdt_section,
                'msdt_final_result'=>$msdt_final_result,
                'msdt_final_value'=>$msdt_final_value,
                'result' => $result
            ];

            $participant['score'] = $score;
            $report[] = $participant;
        }

        return $this->render('report', [
            'report' => $report,
        ]);
    }

    /**
     * Deletes an existing Exam model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Exam model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Exam the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Exam::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
