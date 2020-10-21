<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PostItems */

$this->title = 'Update Post Items: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Post Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="post-items-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
