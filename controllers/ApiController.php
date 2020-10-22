<?php

namespace app\controllers;

use app\models\Category;
use app\models\ExamAnswer;
use app\models\Participant;
use app\models\User;
use Yii;
use yii\filters\Cors;
use yii\web\Response;

class ApiController extends \yii\web\Controller
{
    private $format = 'json';

    public $user;

    public function behaviors()
    {
        return array_merge(parent::behaviors(), [

            // For cross-domain AJAX request
            'corsFilter'  => [
                'class' => \yii\filters\Cors::className(),
                'cors'  => [
                    // restrict access to domains:
                    'Access-Control-Allow-Origin'      => ['*'],
                    'Access-Control-Request-Method'    => ['*'],
                    'Access-Control-Allow-Credentials' => false,
                    'Access-Control-Max-Age'           => 3600,                 // Cache (seconds)
                ],
            ],

        ]);
    }

    public function beforeAction($action)
    {
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
            $user = User::find()->where(['username'=>$request->post('username')])->one();
            $user->auth_key = \Yii::$app->security->generateRandomString();
            $user->save();
            return $user;
        }
    }

    public function actionDetail()
    {
        $detail = Participant::find()->where(['user_id'=>$this->user->id])->one();
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

    public function actionCategories()
    {
        $categories = Category::find()->joinWith(['posts'])->asArray()->orderBy(['sequenced_number'=>'asc'])->all();
        return $categories;
    }

    public function actionAnswer(){

        $request = Yii::$app->request;
        $answer = new ExamAnswer();

        if($request->post()){
            $answer->exam_id = $request->post('exam_id');
            $answer->question_id = $request->post('question_id');
            $answer->answer_id = $request->post('answer_id');
            $answer->score = $request->post('score');
            $answer->participant_id = $this->user->participant->id;

            if($answer->save()){
                return ['msg'=>'success','user'=>$this->user,'answer'=>$answer];
            }

        }

        return ['msg'=>'failed','user'=>$this->user];
    }

}
