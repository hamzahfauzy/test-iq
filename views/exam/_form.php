<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Exam */
/* @var $form yii\widgets\ActiveForm */
$model->start_time = $model->start_time ? date('Y-m-d\TH:i',strtotime($model->start_time)) : date('Y-m-d\TH:i');
$model->end_time = $model->end_time ? date('Y-m-d\TH:i',strtotime($model->end_time)) : date('Y-m-d\TH:i');
$test_group = Yii::$app->params['test_group'];
$test_group = ArrayHelper::map($test_group,'id','name');
?>

<div class="exam-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'test_group')->dropdownList($test_group) ?>

    <?= $form->field($model, 'start_time')->input('datetime-local') ?>

    <?= $form->field($model, 'end_time')->input('datetime-local') ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
