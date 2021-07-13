<?php

namespace app\controllers;

use app\models\Category;
use app\models\ExamAnswer;
use app\models\ExamCategory;
use app\models\ExamParticipant;
use app\models\Participant;
use app\models\Post;
use app\models\User;
use app\models\UserMetas;
use Yii;
use yii\filters\Cors;
use yii\web\Response;

class ApiController extends \yii\web\Controller
{
    private $format = 'json';

    public $user;

    public function actionData()
    {
        $detail = $this->actionDetail(1);
        $exam = $detail['firstExam'];
        $tutorial = [
            'group_1' => 'http://video.ujiantmc.online/vmb1',
            'group_2' => 'http://video.ujiantmc.online/vmb2',
            'group_3' => 'http://video.ujiantmc.online/vmb3',
        ];
        return [
            'tutorial' => $tutorial[$exam['test_group']],
            'download' => '',
        ];
    }

    public function beforeAction($action)
    {
        header('Access-Control-Allow-Origin: *');

        Yii::$app->response->format = Response::FORMAT_JSON;

        $headers = Yii::$app->request->headers;

    
        $this->enableCsrfValidation = false;

        if($action->id == 'login' || $action->id == 'logout'){
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

    public function actionLogin()
    {
        $request = Yii::$app->request;
        if($request->post()){
            $user = User::find()->where(['username'=>$request->post('username')]); //->one();
            if($user->exists())
            {
                $user = $user->one();
                $this->user = $user;
                $user->auth_key = \Yii::$app->security->generateRandomString();
                $user->save();
                $detail = $this->actionDetail();
                return [
                    'user'=>$user,
                    'detail'=>$detail,
                    'categories'=>$this->actionCategories(),
                    'answered'=>$this->actionAnswered(),
                    'last_category'=>isset($detail['exam']['id'])?$this->actionLastCategory($detail['exam']['id']):[],
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
        return $cats;
    }

    public function actionLastCategory($exam_id)
    {
        $category = $this->user->participant->getExamCategories()->asArray()->where(['exam_id'=>$exam_id])->orderBy(['categories.sequenced_number'=>SORT_DESC])->one();
        return $category;
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
