<?php

namespace app\controllers\api;

use yii\web\Response;
use app\models\User;

class AuthController extends \yii\web\Controller
{

    public function beforeAction($action)
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        return parent::beforeAction($action);
    }
    
    public function actionLogin($username)
    {
        $user = User::find()->where(['username'=>$username])->one();
        $user->auth_key = \Yii::$app->security->generateRandomString();
        $user->save();
        return $user;
    }

    public function actionLogout($username)
    {
        $user = User::find()->where(['username'=>$username])->one();
        $user->auth_key = "";
        $user->save();
        return $user;
    }

}
