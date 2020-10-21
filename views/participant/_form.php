<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Participant */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="participant-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php if($is_new): ?>

    <?= $form->field($model, 'id_number')->textInput() ?>

    <?php else: ?>

    <?= $form->field($model, 'id_number')->textInput(['readonly'=>true]) ?>

    <?php endif ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'address')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'birthdate')->input('date') ?>

    <?= $form->field($model, 'age')->textInput() ?>

    <?= $form->field($model, 'school')->textInput() ?>

    <?= $form->field($model, 'study')->textInput() ?>

    <?= $form->field($model, 'work_time')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
