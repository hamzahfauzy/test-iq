<?php

namespace app\modules\answering;

/**
 * answering module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\answering\commands';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }

    // public function bootstrap($app)
    // {
    //     if ($app instanceof \yii\console\Application) {
    //     	$this->controllerNamespace = 'app\modules\answering\commands';
    //     }
    // }
}
