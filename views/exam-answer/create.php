<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ExamAnswer */

$this->title = 'Create Exam Answer';
$this->params['breadcrumbs'][] = ['label' => 'Exam Answers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="exam-answer-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
