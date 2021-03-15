<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\UserMetas */

$this->title = 'Create User Metas';
$this->params['breadcrumbs'][] = ['label' => 'User Metas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-metas-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
