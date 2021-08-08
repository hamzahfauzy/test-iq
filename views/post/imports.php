<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Post */
/* @var $form yii\widgets\ActiveForm */
$this->title = 'Import Posts';
$this->menu_active = "posts";
$this->params['breadcrumbs'][] = ['label' => 'Posts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-create">
    <div class="card card-custom">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <h1><?= Html::encode($this->title) ?></h1>
            </div>
        </div>
        <div class="card-body">

            <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

            <?= $form->field($model, 'category_id')->dropdownList($categories,[
                'prompt' => '- Choose Category -',
            ])->label('Category') ?>

            <?= $form->field($model, 'jurusan')->dropdownList($jurusan,[
                // 'prompt' => '- Pilih Jurusan -',
            ])->label('Jurusan') ?>

            <?= $form->field($model, 'file[]')->input('file',['multiple'=>'true']) ?>

            <div class="form-group">
                <?= Html::submitButton('Import 1', ['class' => 'btn btn-success','name'=>'ImportFile[tipe]','value'=>'questions']) ?>
                <?= Html::submitButton('Import 2', ['class' => 'btn btn-primary','name'=>'ImportFile[tipe]','value'=>'images']) ?>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>
</div>