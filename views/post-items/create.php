<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PostItems */

$this->title = 'Create Post Items';
$this->params['breadcrumbs'][] = ['label' => 'Post Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-items-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
