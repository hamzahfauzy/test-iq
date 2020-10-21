<?php

namespace app\controllers\api;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\auth\HttpBearerAuth;
use app\models\User;

class ExamController extends Controller
{
    public $user;
    public function beforeAction($action)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $headers = Yii::$app->request->headers;
        if(!isset($headers['authorization']))
        {
            echo json_encode(['msg'=>'action authorized']);
            die();
        }
        $bearer  = explode(" ",$headers['authorization']);
        $token   = $bearer[1];
        $this->user = User::findIdentityByAccessToken($token);
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        return ['msg'=>'exam','user'=>$this->user];
    }

}
