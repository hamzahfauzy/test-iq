<?php

namespace app\controllers;

use Yii;
use app\models\Exam;
use app\models\User;
use app\models\Group;
use app\models\Report;
use yii\web\Controller;
use app\models\ExamSearch;
use app\models\Participant;
use yii\filters\VerbFilter;
use Spipu\Html2Pdf\Html2Pdf;
use yii\helpers\ArrayHelper;
use app\models\ImportExamFile;
use app\models\TestGroup\Group2;
use yii\web\NotFoundHttpException;
use app\models\ExamParticipantSearch;

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

    public function actionPenilaian($id)
    {
        $model = Exam::findOne($id);
        $upload_model = ImportExamFile::find()->where(['exam_id'=>$id]);
        $worksheet = [];
        if(!$upload_model->exists())
            $upload_model = new ImportExamFile;
        else
        {
            $upload_model = $upload_model->one();
            $extension = pathinfo($upload_model->file_path, PATHINFO_EXTENSION);

            if($extension=='xlsx'){
                $inputFileType = 'Xlsx';
            }else{
                $inputFileType = 'Xls';
            }
            $reader     = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
             
            $spreadsheet = $reader->load($upload_model->file_path);
            $worksheet   = $spreadsheet->getActiveSheet();
        }
        $upload_model->exam_id = $id;
        if ($upload_model->load(Yii::$app->request->post())){
            $path = 'uploads/'.$_FILES['ImportExamFile']['name']['file_path'];
            copy($_FILES['ImportExamFile']['tmp_name']['file_path'],$path);
            $upload_model->file_path = $path;
            $upload_model->save(false);
            Yii::$app->session->setFlash('success','File Berhasil di Upload');
            return $this->redirect(['penilaian','id'=>$id]);
        }
        return $this->render('penilaian',[
            'model' => $model,
            'upload_model' => $upload_model,
            'worksheet' => $worksheet,
        ]);
    }

    public function actionCetak($id)
    {
        $model = ImportExamFile::find()->where(['exam_id'=>$id])->one();
        $exam  = Exam::findOne($id);
        $extension = pathinfo($model->file_path, PATHINFO_EXTENSION);

        if($extension=='xlsx'){
            $inputFileType = 'Xlsx';
        }else{
            $inputFileType = 'Xls';
        }
        $reader     = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
            
        $spreadsheet = $reader->load($model->file_path);
        $worksheet   = $spreadsheet->getActiveSheet();
        $content     = "
        <style>
        body, h2 {
            margin:0;padding:0
        }
        #customers {
        border-collapse: collapse;
        }

        #customers td, #customers th {
        border: 1px solid #000;
        padding: 5px;
        }

        /* #customers tr:nth-child(even){background-color: #f2f2f2;}

        #customers tr:hover {background-color: #ddd;} */

        #customers th {
        padding-top: 12px;
        padding-bottom: 12px;
        background-color: #eaeaea;
        }

        ul.index {
            list-style-type:none;
            margin:0px;
            padding:0px;
            padding-left:-15px;
            padding-bottom:-25px;
        }
        ul.index li {
            height:25px;
        }
        .box {
            background-color:red;
        }
        </style>
        <body>
        ";

        $highestRow  = $worksheet->getHighestRow();
        $highestColumn = $worksheet->getHighestColumn();
        $highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn);
        $num_rows = ($highestRow + 3);
        $limit = 30;
        $count_partial = ceil($num_rows / $limit);
        $part = $_GET['part'];
        $max_row = ($part * $limit) + 3;
        $first_row = (($part-1) * $limit) + 3;
        if($max_row > $num_rows)
            $max_row = $num_rows;

        if($exam->test_group == 'group_4')
        {
            for ($row = $first_row; $row <= $max_row; $row++) { 
                $value = $worksheet->getCellByColumnAndRow(3, $row)->getFormattedValue();
                if($value == '') continue;
            //     echo $worksheet->getCellByColumnAndRow(3, $row)->getValue() . '<br>';
                $content .= $this->renderPartial('cetak_smk',[
                    'worksheet' => $worksheet,
                    'row'       => $row
                ]);
            }
        }
        else
        {
            if($worksheet->getCellByColumnAndRow(10, 2)->getFormattedValue() == 'BHS')
            {
                for ($row = $first_row; $row <= $max_row; $row++) { 
                    $value = $worksheet->getCellByColumnAndRow(3, $row)->getFormattedValue();
                    if($value == '') continue;
                //     echo $worksheet->getCellByColumnAndRow(3, $row)->getValue() . '<br>';
                    $content .= $this->renderPartial('cetak_bhs',[
                        'worksheet' => $worksheet,
                        'row'       => $row
                    ]);
                }
            }
            else
            {
                for ($row = $first_row; $row <= $max_row; $row++) { 
                    $value = $worksheet->getCellByColumnAndRow(3, $row)->getFormattedValue();
                    if($value == '') continue;
                //     echo $worksheet->getCellByColumnAndRow(3, $row)->getValue() . '<br>';
                    $content .= $this->renderPartial('cetak',[
                        'worksheet' => $worksheet,
                        'row'       => $row
                    ]);
                }
            }
        }


        $content .= "<body>";

        $html2pdf = new Html2Pdf();
        $html2pdf->writeHTML($content);
        $html2pdf->output();
        // $html2pdf->output('laporan.pdf', 'D');
        return;
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
        
        $groups = Group::find()->all();
        $groups = ArrayHelper::map($groups,'id','name');
        return $this->render('create', [
            'model' => $model,
            'groups' => $groups,
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

        $groups = Group::find()->all();
        $groups = ArrayHelper::map($groups,'id','name');

        return $this->render('update', [
            'model' => $model,
            'groups' => $groups,
        ]);
    }

    function actionOldDownload2($id)
    {
        // \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $test_group = [
            'group_1' => 'app\models\TestGroup\Group1',
            'group_2' => 'app\models\TestGroup\Group2',
            'group_3' => 'app\models\TestGroup\Group3',
            'group_4' => 'app\models\TestGroup\Group4',
            'group_5' => 'app\models\TestGroup\Group5',
        ];

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

    function actionDownload($id)
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
                'group.items' => function($q){
                    $q->orderby(['group_items.sequenced_number'=>'asc']);
                },
                'group.items.category' => function($q){
                    $q->where(['not like','categories.name','%Instruksi%',false]);
                },
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
                'group.items' => function($q){
                    $q->orderby(['group_items.sequenced_number'=>'asc']);
                },
                'group.items.category' => function($q){
                    $q->where(['not like','categories.name','%Instruksi%',false]);
                },
            ])
            // ->asArray()
            ->one();
        }

        $content = new Report($model);
        $content = $content->render();

        if(!isset($_GET['debug']))
        {
            header("Content-type: application/vnd-ms-excel");
            header("Content-Disposition: attachment; filename=Report-".$model->name.".xls");
        }

        return $content;
    }

    function actionDownloadBa($id)
    {
        $model = Exam::find()->where(['id'=>$id])->with(['examParticipants'])->one();
        $html = "<table border='1' cellpadding='5' cellspacing='0'>";

        $html .= "<tr>";
        $html .= "<td></td>";
        $html .= "<td>Asal Sekolah</td>";
        $html .= "<td colspan='4'>".$model->name."</td>";
        $html .= "</tr>";

        $html .= "<tr>";
        $html .= "<td></td>";
        $html .= "<td>Jumlah Peserta</td>";
        $html .= "<td colspan='4'>".$model->getExamParticipants()->count()."</td>";
        $html .= "</tr>";

        $html .= "<tr>";
        $html .= "<td></td>";
        $html .= "<td>Mulai</td>";
        $html .= "<td colspan='4'>".$model->getExamParticipants()->where(['status'=>'start'])->count()."</td>";
        $html .= "</tr>";

        $html .= "<tr>";
        $html .= "<td></td>";
        $html .= "<td>Selesai</td>";
        $html .= "<td colspan='4'>".$model->getExamParticipants()->where(['status'=>'finish'])->count()."</td>";
        $html .= "</tr>";

        $html .= "<tr>";
        $html .= "<td></td>";
        $html .= "<td>Tidak Mengikuti</td>";
        $html .= "<td colspan='4'>".($model->getExamParticipants()->count()-($model->getExamParticipants()->where(['status'=>'start'])->count()+$model->getExamParticipants()->where(['status'=>'finish'])->count()))."</td>";
        $html .= "</tr>";

        $html .= "<tr>";
        $html .= "<td colspan='6'></td>";
        $html .= "</tr>";

        $html .= "<tr>";
        $html .= "<td>#</td>";
        $html .= "<td>ID Number</td>";
        $html .= "<td>Name</td>";
        $html .= "<td>Status</td>";
        $html .= "<td>Mulai</td>";
        $html .= "<td>Selesai</td>";
        $html .= "</tr>";
        foreach($model->examParticipants as $key => $ep)
        {
            $row = "<tr>";
            $row .= "<td>".++$key."</td>";
            $row .= "<td>".$ep->participant->id_number."</td>";
            $row .= "<td>".$ep->participant->name."</td>";
            $row .= "<td>".$ep->status."</td>";
            $row .= "<td>".$ep->started_at."</td>";
            $row .= "<td>".$ep->finished_at."</td>";
            $row .= "</tr>";
            $html .= $row;
        }
        $html .= "</table>";

        header("Content-type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=BA-".$model->name.".xls");

        return $html;
    }

    function actionNewDownload($id,$tool)
    {
        // \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $testTools = [
            'TPA' => 'app\models\TestTools\Tpa',
            'HOLLAND' => 'app\models\TestTools\Holland',
            'PAPIKOSTICK' => 'app\models\TestTools\Papikostick',
            'CFIT2' => 'app\models\TestTools\Cfit2',
            'IMJ' => 'app\models\TestTools\Imj',
            'DISC' => 'app\models\TestTools\Disc',
        ];

        if(isset($_GET['bulk_print']))
        {
            $model = Exam::find()->where([
                'exams.id'=>$id,
            ])
            ->joinWith([
                'participants' => function($query){
                    $query->where(['in','participants.id',$_GET['bulk_print']]);
                }
            ])
            // ->asArray()
            ->one();
        }
        else
        {
            $model = Exam::findOne($id);
        }

        $report = (new $testTools[$tool])->report($model);
        $content = $report->renderSingleReport();

        if(!isset($_GET['debug']))
        {
            header("Content-type: application/vnd-ms-excel");
            header("Content-Disposition: attachment; filename=Report-".$model->name."-".$tool.".xls");
        }

        return $content;
    }

    function actionOldDownload($id,$laporan=false)
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
            $part = Participant::findOne($participant['id']);
            $participant['name'] = $part->name; // ->getMeta('nama_lengkap');
            $participant['age'] = $part->getAge(); // ->getMeta('nama_lengkap');
            $participant['school'] = $model['name'];
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
            $report[] = $participant;
        }

        

        $file_report = $laporan == 'CFIT' ? 'report-cfit' : ($laporan == 'Papikostick'?'report-papikostick':'report');

        header("Content-type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=Report-".$model['name']."-".$file_report.".xls");

        $content = $this->renderPartial($file_report, [
            'report' => $report,
            'name'   => $model['name'],
        ]);

        return $content;
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
        $exam = $this->findModel($id);
        $users = [];
        foreach($exam->participants as $participant)
            $users[] = $participant->user_id;
        
        $exam->delete();
        User::deleteAll(['in', 'id', $users]);

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

    public function actionDownloadAll($id)
    {
        
        $test_group = [
            'group_1' => [
                'bhs' => 'cetak_bhs',
                'default' => 'cetak',
            ],
            'group_2' => [
                'bhs' => 'cetak_group_2',
                'default' => 'cetak_group_2',
            ],
            'group_3' => [
                'bhs' => 'cetak_bhs',
                'default' => 'cetak',
            ],
            'group_4' => [
                'bhs' => 'cetak_smk',
                'default' => 'cetak_smk',
            ],
            'group_5' => [
                'bhs' => 'cetak_group_2',
                'default' => 'cetak_group_2',
            ],
        ];
        $model = ImportExamFile::find()->where(['exam_id'=>$id])->one();
        $exam  = $model->exam;
        $test  = $test_group[$exam->test_group];
        $extension = pathinfo($model->file_path, PATHINFO_EXTENSION);

        if($extension=='xlsx'){
            $inputFileType = 'Xlsx';
        }else{
            $inputFileType = 'Xls';
        }
        $reader     = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
            
        $spreadsheet = $reader->load($model->file_path);
        $worksheet   = $spreadsheet->getActiveSheet();
        $content     = "
        <style>
        body, h2 {
            margin:0;padding:0
        }
        #customers {
        border-collapse: collapse;
        }

        .center {
            text-align:center;
        }

        .w-bold {
            font-weight:bold;
        }

        #customers td, #customers th {
        border: 1px solid #000;
        padding: 5px;
        }

        /* #customers tr:nth-child(even){background-color: #f2f2f2;}

        #customers tr:hover {background-color: #ddd;} */

        #customers th {
        padding-top: 12px;
        padding-bottom: 12px;
        background-color: #eaeaea;
        }

        ul {
            margin:0px;
            padding:0px;
            padding-left:-15px;
            padding-bottom:-25px;
        }
        .box {
            background-color:red;
        }
        </style>
        <body>
        ";

        $highestRow  = $worksheet->getHighestRow();
        $highestColumn = $worksheet->getHighestColumn();
        $highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn);
        $exists = false;
        if($worksheet->getCellByColumnAndRow(10, 2)->getFormattedValue() == 'BHS')
        {
            for ($row = 3; $row <= $highestRow; $row++) { 
                if($worksheet->getCellByColumnAndRow(2, $row)->getFormattedValue() == '') break;
                $value = $worksheet->getCellByColumnAndRow(3, $row)->getFormattedValue();
                $_nisn = $worksheet->getCellByColumnAndRow(4, $row)->getFormattedValue();
                // if($value == '' || $_nisn != $nisn) continue;
            //     echo $worksheet->getCellByColumnAndRow(3, $row)->getValue() . '<br>';
                $add_content = $content. $this->renderPartial($test['bhs'],[
                    'worksheet' => $worksheet,
                    'row'       => $row
                ]);

                $html2pdf = new Html2Pdf();
                $html2pdf->writeHTML($add_content);
                $html2pdf->output(__DIR__ . '/../web/pdf/'.$worksheet->getCellByColumnAndRow(3, $row)->getFormattedValue().'.pdf','F');
            }
        }
        else
        {
            for ($row = 3; $row <= $highestRow; $row++) { 
                if($worksheet->getCellByColumnAndRow(2, $row)->getFormattedValue() == '') break;
                $value = $worksheet->getCellByColumnAndRow(3, $row)->getFormattedValue();
                $_nisn = $worksheet->getCellByColumnAndRow(4, $row)->getFormattedValue();
                // if($value == '' || $_nisn != $nisn) continue;
            //     echo $worksheet->getCellByColumnAndRow(3, $row)->getValue() . '<br>';
                $add_content = $content. $this->renderPartial($test['default'],[
                    'worksheet' => $worksheet,
                    'row'       => $row
                ]);

                $html2pdf = new Html2Pdf();
                $html2pdf->writeHTML($add_content);
                $html2pdf->output(__DIR__ . '/../web/pdf/'.$worksheet->getCellByColumnAndRow(3, $row)->getFormattedValue().'.pdf','F');
            }
        }

        $zip = new \ZipArchive;
        $tmp_file = 'zip/'.$exam->name.'.zip';
        if(file_exists($tmp_file)) unlink($tmp_file);
        if ($zip->open($tmp_file,  \ZipArchive::CREATE)) {
            $folder = 'pdf';
            for ($row = 3; $row <= $highestRow; $row++) { 
                $filename = $worksheet->getCellByColumnAndRow(3, $row)->getFormattedValue().'.pdf';
                $zip->addFile($folder.'/'.$filename,$filename);
            }
            $zip->close();
            echo '{"filename":"'.$tmp_file.'"}';
            return;
        } else {
            echo 'Failed!';
        }

        // if(!$exists) return "<h2>Not Found</h2>";

        // $content .= "<body>";

        // $participant = Participant::find()->where(['id_number'=>$nisn])->one();

        // $html2pdf = new Html2Pdf();
        // $html2pdf->writeHTML($content);
        // $html2pdf->output('pdf/'.$participant->name.'.pdf','F');
        // $html2pdf->output('laporan.pdf', 'D');
        return;
    }
}
