<?php

namespace app\controllers;

class ApiController extends \yii\web\Controller
{
    private $format = 'json';

    public function actionIndex()
    {
        return ['msg'=>'hello world'];
    }

    function actionHello()
    {
        echo "Hello";
    }

}
