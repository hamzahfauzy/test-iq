<?php

namespace app\modules\answering\controllers;

use yii\web\Controller;

/**
 * Default controller for the `answering` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return 'hello world';
        return $this->render('index');
    }
}
