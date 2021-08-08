<?php

namespace app\controllers;

use Yii;
use app\models\Exam;
use app\models\User;
use yii\web\Controller;
use app\models\ImportDob;
use app\models\Participant;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use app\models\ImportParticipant;
use app\models\ParticipantSearch;
use yii\web\NotFoundHttpException;

/**
 * ParticipantController implements the CRUD actions for Participant model.
 */
class ParticipantController extends Controller
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
     * Lists all Participant models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ParticipantSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Participant model.
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
     * Creates a new Participant model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Participant();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $transaction = \Yii::$app->db->beginTransaction();
            try {
                $user = new User;
                $user->username = $model->id_number;
                $user->password_hash = "123";
                $user->email = $model->id_number."@mail.com";
                $user->save();

                $model->user_id = $user->id;
                $model->save();
                $transaction->commit();
                Yii::$app->session->addFlash("success", "Insert Participant Success");
            } catch (\Throwable $th) {
                //throw $th;
                $transaction->rollback();
            }
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionImports($exam_id = false)
    {
        $model = new ImportParticipant;
        $model->exam_id = $exam_id;
        $exams = Exam::find()->all();
        $exams = ArrayHelper::map($exams,'id','name');
        if ($model->load(Yii::$app->request->post())){
            $uploadedFile = \yii\web\UploadedFile::getInstance($model,'file');
            $extension    = $uploadedFile->extension;
            if($extension=='xlsx'){
                $inputFileType = 'Xlsx';
            }else{
                $inputFileType = 'Xls';
            }
            $reader     = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
             
            $spreadsheet = $reader->load($uploadedFile->tempName);
            $worksheet   = $spreadsheet->getActiveSheet();
            $highestRow  = $worksheet->getHighestRow();
            $highestColumn = $worksheet->getHighestColumn();
            $highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn);
             
            //inilah looping untuk membaca cell dalam file excel,perkolom
              
            $transaction = \Yii::$app->db->beginTransaction();
            try {
                for ($row = 2; $row <= $highestRow; $row++) { //$row = 2 artinya baris kedua yang dibaca dulu(header kolom diskip disesuaikan saja)
                    $check_user = User::find()->where(['username'=>$worksheet->getCellByColumnAndRow(2, $row)->getValue()]);
                    $participant = [];
                    if(!$check_user->exists())
                    {
                        $user = new User;
                        $user->username = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                        $user->password_hash = "123";
                        $user->email = $worksheet->getCellByColumnAndRow(2, $row)->getValue()."@mail.com";
                        $user->save();

                        $participant = new Participant;
                        $participant->name = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                        $participant->id_number = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                        $participant->birthdate = date('Y-m-d');
                        $participant->study = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                        $participant->user_id = $user->id;
                        $participant->save(false);
                    }
                    else
                    {
                        $participant = $check_user->one()->participant;
                    }

                    $exam = Exam::findOne($model->exam_id);
                    $exam->link('participants',$participant);
                }
                $transaction->commit();
                Yii::$app->session->addFlash("success", "Import Participant Success");
            } catch (\Throwable $th) {
                throw $th;
                $transaction->rollback();
                Yii::$app->session->addFlash("error", "Import Participant Failed");
            }
            return $this->redirect(['exam/view','id'=>$exam_id]);
        }

        return $this->render('imports', [
            'model' => $model,
            'exams' => $exams,
        ]);
    }

    public function actionImportsDob()
    {
        $model = new ImportDob;
        $model->mode = 'Import Dob';
        if ($model->load(Yii::$app->request->post())){
            $uploadedFile = \yii\web\UploadedFile::getInstance($model,'file');
            $extension    = $uploadedFile->extension;
            if($extension=='xlsx'){
                $inputFileType = 'Xlsx';
            }else{
                $inputFileType = 'Xls';
            }
            $reader     = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
             
            $spreadsheet = $reader->load($uploadedFile->tempName);
            $worksheet   = $spreadsheet->getActiveSheet();
            $highestRow  = $worksheet->getHighestRow();
            $highestColumn = $worksheet->getHighestColumn();
            $highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn);
             
            //inilah looping untuk membaca cell dalam file excel,perkolom
            $transaction = \Yii::$app->db->beginTransaction();
            try {
                for ($row = 1; $row <= $highestRow; $row++) { //$row = 2 artinya baris kedua yang dibaca dulu(header kolom diskip disesuaikan saja)
                    $date = \DateTime::createFromFormat('d-m-Y', $worksheet->getCellByColumnAndRow(2, $row)->getValue());
                    $dob =  $date->format('Y-m-d');
                    $participant = Participant::find()->where(['id_number'=>$worksheet->getCellByColumnAndRow(1, $row)->getValue()]);
                    if($participant->exists())
                    {
                        $participant = $participant->one();
                        $participant->birthdate = $dob;
                        $participant->save(false);
                    }
                }
                $transaction->commit();
                Yii::$app->session->addFlash("success", "Import DOB Success");
            } catch (\Throwable $th) {
                throw $th;
                $transaction->rollback();
                Yii::$app->session->addFlash("error", "Import DOB Failed");
            }
            return $this->redirect(['index']);
            
        }

        return $this->render('imports-dob', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Participant model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->addFlash("success", "Update Participant Success");
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Participant model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        Yii::$app->session->addFlash("success", "Delete Participant Success");
        return $this->redirect(['index']);
    }

    /**
     * Finds the Participant model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Participant the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Participant::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
