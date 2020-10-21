<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Category */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="category-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sequenced_number')->textInput() ?>

    <?= $form->field($model, 'has_timer')->dropdownList([
        'Countdown'=>'Countdown',
        'Ticker'=>'Ticker',
        'No'=>'No'
        ]) ?>

<?= $form->field($model, 'countdown')->input('time') ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
