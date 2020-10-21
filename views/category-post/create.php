<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\CategoryPost */

$this->title = 'Create Category Post';
$this->params['breadcrumbs'][] = ['label' => 'Category Posts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-post-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
