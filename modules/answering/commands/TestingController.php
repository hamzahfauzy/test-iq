<?php
namespace app\modules\answering\commands;

use yii\console\Controller;
use yii\helpers\Console;

class TestingController extends Controller
{
    public function actionIndex($message = 'hello world from module')
    {
        echo $message . "\n";
    }
}