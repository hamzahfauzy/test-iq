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
        return [
            'uji_coba' => 'https://google.com',
            'tutorial' => 'https://google.com',
        ];
    }

    public function beforeAction($action)
    {
        header('Access-Control-Allow-Origin: *');

        Yii::$app->response->format = Response::FORMAT_JSON;

        $headers = Yii::$app->request->headers;

    
        $this->enableCsrfValidation = false;

        if($action->id == 'login' || $action->id == 'logout' || $action->id == 'data'){
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
            $user = User::find()->where(['username'=>$request->post('username')])->one();
            $user->auth_key = \Yii::$app->security->generateRandomString();
            $user->save();
            return $user;
        }
    }

    public function actionDetail()
    {
        $detail = Participant::find()->with(['exam','examParticipant'])->asArray()->where(['user_id'=>$this->user->id])->one();
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
        $exam_participant = ExamParticipant::find()->where(['participant_id'=>$participant->id,'exam_id'=>$participant->exam->id])->one();
        $exam_participant->status = 'start';
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
        $categories = Category::find()->joinWith(['posts'])->asArray()->orderBy(['sequenced_number'=>'asc'])->all();
        return $categories;
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
