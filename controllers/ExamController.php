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
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
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
            $participant['score'] = $score;
            $report[] = $participant;
        }

        return $report;
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
