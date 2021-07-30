<?php

namespace app\controllers;

use Yii;
use app\models\Post;
use app\models\User;
use yii\helpers\Url;
use yii\filters\Cors;
use yii\web\Response;
use app\models\Category;
use app\models\UserMetas;
use app\models\ExamAnswer;
use app\models\Participant;
use app\models\ExamCategory;
use Spipu\Html2Pdf\Html2Pdf;
use app\models\ImportExamFile;
use app\models\ExamParticipant;

class ApiController extends \yii\web\Controller
{
    private $format = 'json';

    public $user;

    public function actionData()
    {
        $detail = $this->actionDetail(1);
        $exam = $detail['firstExam'];
        $model = ImportExamFile::find()->where(['exam_id'=>$exam['id']]);
        $tutorial = [
            'group_1' => 'http://video.ujiantmc.online/vmb1',
            'group_2' => 'http://video.ujiantmc.online/vmb2',
            'group_3' => 'http://video.ujiantmc.online/vmb3',
        ];
        return [
            'tutorial' => $tutorial[$exam['test_group']],
            'download' => $model->exists() ? Url::base(true) . '/api/download-laporan?id='.$exam['id'].'&nisn='.$this->user->username : '',
        ];
    }

    public function beforeAction($action)
    {
        header('Access-Control-Allow-Origin: *');

        Yii::$app->response->format = Response::FORMAT_JSON;

        $headers = Yii::$app->request->headers;

    
        $this->enableCsrfValidation = false;

        if($action->id == 'login' || $action->id == 'logout' || $action->id == 'generate' || $action->id == 'generate-demo' || $action->id == 'patch_peserta' || $action->id == 'download-laporan'){
            return parent::beforeAction($action);
        }

        if(!isset($headers['Authorization']))
        {
            echo json_encode(['msg'=>'token not found!']);
            die();
        }

        $bearer  = explode(" ",$headers['Authorization']);
        $token   = $bearer[1];
        
        if(!$token){
            echo json_encode(['msg'=>'token not valid!']);
            die();
        }

        $this->user = User::findIdentityByAccessToken($token);

        if(!$this->user){
            echo json_encode(['msg'=>'unauthorized']);
            die();
        }

        return parent::beforeAction($action);
    }

    public function actionDownloadLaporan($id, $nisn)
    {
        $model = ImportExamFile::find()->where(['exam_id'=>$id])->one();
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
        for ($row = 3; $row <= $highestRow; $row++) { 
            $value = $worksheet->getCellByColumnAndRow(3, $row)->getFormattedValue();
            $_nisn = $worksheet->getCellByColumnAndRow(4, $row)->getFormattedValue();
            if($value == '' || $_nisn != $nisn) continue;
        //     echo $worksheet->getCellByColumnAndRow(3, $row)->getValue() . '<br>';
            $content .= $this->renderPartial('cetak',[
                'worksheet' => $worksheet,
                'row'       => $row
            ]);
            $exists = true;
            break;
        }

        if(!$exists) return "<h2>Not Found</h2>";

        $content .= "<body>";

        $participant = Participant::find()->where(['id_number'=>$nisn])->one();

        $html2pdf = new Html2Pdf();
        $html2pdf->writeHTML($content);
        $html2pdf->output($participant->name.'.pdf');
        // $html2pdf->output('laporan.pdf', 'D');
        return;
    }

    public function actionGenerate($group_id,$status=false)
    {
        $test_group = Yii::$app->params['test_group'];
        $test_group = $test_group[$group_id];
        $tools = $test_group['tools'];
        if(file_exists($group_id.'.json') && $status==false)
            return json_decode(file_get_contents($group_id.'.json'));
        // return [
        //     'tutorial' => $tutorial[$exam['test_group']],
        $categories = Category::find()
                    ->where([
                        'in', 'test_tool', $tools
                    ])
                    ->with(['posts','posts.items'])
                    ->asArray()
                    ->orderBy(['sequenced_number'=>'asc'])->all();

        $cats = [];
        foreach($categories as $cat)
        {
            $posts = [];
            foreach($cat['posts'] as $post)
            {
                if(isset($post['items']) && $cat['test_tool'] == 'TPA')
                    shuffle($post['items']);

                $posts[] = $post;
            }
            $cat['posts'] =  $posts;
            $cats[] = $cat;
        }
        file_put_contents($group_id.'.json',json_encode($cats));
        return $cats;
    }

    public function actionGenerateDemo($group_id,$status=false)
    {
        $test_group = Yii::$app->params['test_group'];
        $test_group = $test_group[$group_id];
        $tools = $test_group['tools'];
        if(file_exists($group_id.'-demo.json') && $status == false)
            return json_decode(file_get_contents($group_id.'-demo.json'));
        // return [
        //     'tutorial' => $tutorial[$exam['test_group']],
        $categories = Category::find()
                    ->where([
                        'in', 'test_tool', $tools
                    ])
                    ->with(['posts','posts.items'])
                    ->asArray()
                    ->orderBy(['sequenced_number'=>'asc'])->all();

        $cats = [];
        foreach($categories as $cat)
        {
            $posts = [];
            foreach($cat['posts'] as $key => $post)
            {
                if(isset($post['items']) && $cat['test_tool'] == 'TPA')
                    shuffle($post['items']);

                $posts[] = $post;
                if(in_array($cat['test_tool'],['TPA','HOLLAND']))
                {
                    // 1 soal
                    break;
                }

                if($cat['test_tool'] == 'PAPIKOSTICK' && $key == 3)
                {
                    // 3 soal
                    break;
                }

            }
            $cat['posts'] =  $posts;
            $cats[] = $cat;
        }
        file_put_contents($group_id.'-demo.json',json_encode($cats));
        return $cats;
    }

    public function actionLogin()
    {
        $request = Yii::$app->request;
        if($request->post()){
            $user = User::find()->where(['username'=>$request->post('username')])->with(['participant']); //->one();
            if($user->exists())
            {
                $user = $user->one();

                $detail = $user->getParticipant()->with(['exam','firstExam','examParticipant'])->asArray()->one();
                $exam = $detail['firstExam'];
                $test_group = Yii::$app->params['test_group'];
                $test_group = $test_group[$exam['test_group']];
                $tools = $test_group['tools'];
                $id = $test_group['id'];

                $this->user = $user;
                $user->auth_key = \Yii::$app->security->generateRandomString();
                $user->save();
                
                return [
                    'user'=>$user,
                    'detail'=>$detail,
                    'test_group'=>$id,
                    // 'categories'=>$this->actionGenerate($id),
                    'answered'=>$this->actionAnswered(),
                    // 'last_category'=>isset($detail['exam']['id'])?$this->actionLastCategory($detail['exam']['id']):[],
                ];
            }
            return [];
        }
    }

    public function actionDetail($tipe = false)
    {
        $detail = Participant::find()->with(['exam','examParticipant'])->asArray()->where(['user_id'=>$this->user->id])->one();
        if($tipe)
            $detail = Participant::find()->with(['firstExam','examParticipant'])->asArray()->where(['user_id'=>$this->user->id])->one();
        return $detail;
    }

    public function actionLogout()
    {
        $request = Yii::$app->request;
        if($request->post()){
            $user = User::find()->where(['username'=>$request->post('username')])->one();
            $user->auth_key = "";
            $user->save();
            return $user;
        }
        
    }

    public function actionNext(){
        $request = Yii::$app->request;
        $category = new ExamCategory();

        if($request->post()){

            $category->exam_id = intval($request->post('exam_id'));
            $category->category_id = intval($request->post('category_id'));
            $category->participant_id = $this->user->participant->id;

            $exam_category = ExamCategory::find()->where([
                'exam_id'=>$category->exam_id,
                'category_id'=>$category->category_id,
                'participant_id'=>$category->participant_id,
            ])->one();

            if($exam_category){
                $category = $exam_category;
            }

            $category->time_left = $request->post('time_left');

            if($category->save()){
                return ['msg'=>'success','user'=>$this->user,'category'=>$category];
            }

        }

        return ['msg'=>'failed','user'=>$this->user];
        
    }

    public function actionStart(){
        $request = Yii::$app->request;
        $data = $request->post();
        foreach($data as $key => $value)
        {
            $userMetas = new UserMetas;
            $userMetas->user_id = $this->user->id;
            $userMetas->meta_key = $key;
            $userMetas->meta_value = $value;
            $userMetas->save();
        }

        $participant = Participant::find()->where(['user_id'=>$this->user->id])->one();
        if(isset($data['tanggal_lahir']))
        {
            $participant->birthdate = $data['tanggal_lahir'];
            $participant->save(false);
        }
        $exam_participant = ExamParticipant::find()->where(['participant_id'=>$participant->id,'exam_id'=>$participant->exam->id])->one();
        $exam_participant->status = 'start';
        $exam_participant->started_at = date('Y-m-d H:i:s');
        if($exam_participant->save()){
            $detail = Participant::find()->with(['exam','examParticipant'])->asArray()->where(['user_id'=>$this->user->id])->one();
            return ['msg'=>'success','user'=>$this->user,'detail'=>$detail];
        }
        return ['msg'=>'success','user'=>$this->user];
    }


    public function actionFinish(){
        $participant = Participant::find()->where(['user_id'=>$this->user->id])->one();
        if($participant->exam)
        {
            $exam_participant = ExamParticipant::find()->where(['participant_id'=>$participant->id,'exam_id'=>$participant->exam->id])->one();
            $exam_participant->status = 'finish';
            $exam_participant->finished_at = date('Y-m-d H:i:s');
            if($exam_participant->save()){
                $detail = Participant::find()->with(['exam','examParticipant'])->asArray()->where(['user_id'=>$this->user->id])->one();
                return ['msg'=>'success','user'=>$this->user,'detail'=>$detail];
            }
            return ['msg'=>'success','user'=>$this->user];
        }
        return ['msg'=>'fail','user'=>$this->user,'data'=>'exam not found'];
    }

    function actionAnswered(){
        if(file_exists('answers/'.$this->user->username.'.json'))
        {
            $data = file_get_contents('answers/'.$this->user->username.'.json');
            $data = json_decode($data);
            return $data->answers;
        }
        return [];
        $participant = Participant::find()->where(['user_id'=>$this->user->id])->one();
        $exam_answered = [];
        foreach($participant->examAnswers as $answer){
            if($answer->question->categoryPost->sequenced_number == 4)
                $exam_answered[$answer->question_id] = "$answer->answer_content";
            else
                $exam_answered[$answer->question_id] = "$answer->answer_id";
        }

        return $exam_answered;
    }

    public function actionCategories()
    {
        $detail = $this->actionDetail();
        $exam = $detail['exam'];
        $test_group = Yii::$app->params['test_group'];
        $test_group = $test_group[$exam['test_group']];
        $tools = $test_group['tools'];
        $id = $test_group['id'];
        if(file_exists($id.'.json'))
            return json_decode(file_get_contents($id.'.json'));
        // return [
        //     'tutorial' => $tutorial[$exam['test_group']],
        $categories = Category::find()
                    ->where([
                        'in', 'test_tool', $tools
                    ])
                    ->with(['posts','posts.items'])
                    ->asArray()
                    ->orderBy(['sequenced_number'=>'asc'])->all();

        $cats = [];
        foreach($categories as $cat)
        {
            $posts = [];
            foreach($cat['posts'] as $post)
            {
                if(isset($post['items']) && $cat['test_tool'] == 'TPA')
                    shuffle($post['items']);

                $posts[] = $post;
            }
            $cat['posts'] =  $posts;
            $cats[] = $cat;
        }
        file_put_contents($id.'.json',json_encode($cats));
        return $cats;
    }
    
    public function actionDemoCategories()
    {
        $detail = $this->actionDetail(1);
        $exam = $detail['firstExam'];
        $test_group = Yii::$app->params['test_group'];
        $test_group = $test_group[$exam['test_group']];
        $tools = $test_group['tools'];
        $id = $test_group['id'];
        if(file_exists($id.'-demo.json'))
            return json_decode(file_get_contents($id.'-demo.json'));
        // return [
        //     'tutorial' => $tutorial[$exam['test_group']],
        $categories = Category::find()
                    ->where([
                        'in', 'test_tool', $tools
                    ])
                    ->with(['posts'=>function($q){
                        return $q->limit(3);
                    },'posts.items'])
                    ->asArray()
                    ->orderBy(['sequenced_number'=>'asc'])->all();

        $cats = [];
        foreach($categories as $cat)
        {
            $posts = [];
            foreach($cat['posts'] as $key => $post)
            {
                if(isset($post['items']) && $cat['test_tool'] == 'TPA')
                    shuffle($post['items']);

                $posts[] = $post;
                if(in_array($cat['test_tool'],['TPA','HOLLAND']))
                {
                    // 1 soal
                    break;
                }

                if($cat['test_tool'] == 'PAPIKOSTICK' && $key == 3)
                {
                    // 3 soal
                    break;
                }

            }
            $cat['posts'] =  $posts;
            $cats[] = $cat;
        }
        file_put_contents($id.'-demo.json',json_encode($cats));
        return $cats;
    }

    public function actionLastCategory($exam_id)
    {
        $category = $this->user->participant->getExamCategories()->asArray()->where(['exam_id'=>$exam_id])->orderBy(['categories.sequenced_number'=>SORT_DESC])->one();
        return $category;
    }

    function actionSendAnswer()
    {
        $request = file_get_contents('php://input');
        $data = json_decode($request);
        file_put_contents("answers/".$this->user->username.'.json',$request);
        return $data;
    }

    public function actionAnswer(){

        $request = Yii::$app->request;
        $answer = new ExamAnswer();

        if($request->post()){

            $answer->exam_id = $request->post('exam_id');
            $answer->question_id = $request->post('question_id');
            $answer->participant_id = $this->user->participant->id;

            $exam_answer = ExamAnswer::find()->where([
                'exam_id'=>$answer->exam_id,
                'question_id'=>$answer->question_id,
                'participant_id'=>$answer->participant_id,
            ])->one();

            if($exam_answer){
                $answer = $exam_answer;
            }

            $post = Post::find()->where(['id'=>$request->post('answer_id')])->one();

            if($post){ 
                $answer->answer_id = $post->id;
                $answer->score = $post->post_type;
            }else{

                $question = Post::find()->where(['id'=>$request->post('question_id')])->one();
                $checkAnswer = $question->getItems()->where(['post_content'=>strtolower($request->post('answer_id'))])->one();

                $answer->answer_content = strtolower($request->post('answer_id'));

                if($checkAnswer){
                    $answer->answer_id = $checkAnswer->id;
                    $answer->score = $checkAnswer->post_type;
                }else{
                    $answer->answer_id = null;
                    $answer->score = 0;
                }
            }

            if($answer->save())
                return ['msg'=>'success','user'=>$this->user,'answer'=>$answer];
            return ['msg'=>'answer save fail','user'=>$this->user,'answer'=>$answer,'error_msg'=>$answer->getErrors()];

        }

        return ['msg'=>'failed','user'=>$this->user];
    }

}
