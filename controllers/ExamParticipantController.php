<?php

namespace app\controllers;

use Yii;
use app\models\Exam;
use app\models\Participant;
use app\models\ExamParticipant;
use app\models\ExamParticipantSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

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
}
