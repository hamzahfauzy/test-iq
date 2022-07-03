<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Exam */

$this->title = 'Create Exam';
$this->tab_active = 'exams';
$this->menu_active = 'add new exam';
$this->params['breadcrumbs'][] = ['label' => 'Exams', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="exam-create">
    <div class="card card-custom">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <h1><?= Html::encode($this->title) ?></h1>
            </div>
        </div>
        <div class="card-body">
            <?= $this->render('_form', [
                'model' => $model,
                'groups' => $groups,
            ]) ?>
        </div>
    </div>
</div>
