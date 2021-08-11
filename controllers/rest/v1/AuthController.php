<?php

namespace app\controllers\rest\v1;

use Yii;
use app\models\User;
use yii\rest\Controller;
use yii\filters\auth\HttpBearerAuth;

class AuthController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        // remove authentication filter
        $auth = $behaviors['authenticator'];
        unset($behaviors['authenticator']);
        
        // add CORS filter
        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::class,
        ];
        
        $behaviors['authenticator'] = [
            'class' =>  HttpBearerAuth::className(),
            'except' => ['options','login'],
        ];

        return $behaviors;
    }

    public function actionLogin()
    {
        $request = Yii::$app->request;
        $auth_key = null;
        if($request->post())
        {
            $auth_key = \Yii::$app->security->generateRandomString();
            $user = User::find()->where(['username'=>$request->post('username')])->one();
            $user->auth_key = $auth_key;
            $user->save();

            $auth_key = ['auth_key'=>$auth_key];
        }
        return $auth_key;
    }
}