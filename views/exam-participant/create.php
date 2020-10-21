<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ExamParticipant */

$this->title = 'Add Participant';
$this->tab_active = "exams";
$this->menu_active = "all exams";
$this->params['breadcrumbs'][] = ['label' => 'Exam', 'url' => ['exam/index']];
$this->params['breadcrumbs'][] = ['label' => $model->exam->name, 'url' => ['exam/view','id'=>$model->exam_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="exam-participant-create">
    <div class="card card-custom">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <h1><?= Html::encode($this->title) ?></h1>
            </div>
        </div>
        <div class="card-body">
            <?= $this->render('_form', [
                'model' => $model,
                'participants' => $participants,
            ]) ?>
        </div>
    </div>
</div>
