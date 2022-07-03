<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Category */
/* @var $form yii\widgets\ActiveForm */
$test_tools = Yii::$app->params['test_tools'];
$test_tools = array_merge(['Tidak Ada'=>'Tidak Ada'], $test_tools);
?>

<div class="category-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'test_tool')->dropdownList($test_tools) ?>

    <?= $form->field($model, 'has_timer')->dropdownList([
        'Countdown'=>'Countdown',
        'Ticker'=>'Ticker',
        'No'=>'No'
        ]) ?>

    <?= $form->field($model, 'countdown')->textInput()->label('Countdown (ex: 00:10:00 for 10 Minutes)') ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
