<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Exam */

$this->title = $model->name;
$this->menu_active = "all groups";
$this->params['breadcrumbs'][] = ['label' => 'Groups', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="exam-view">
    <div class="card card-custom">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <h1><?= Html::encode($this->title) ?></h1>
            </div>
            <div class="card-toolbar">
                <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                &nbsp;
                <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => 'Are you sure you want to delete this item?',
                        'method' => 'post',
                    ],
                ]) ?>
            </div>
        </div>
        <div class="card-body">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    'name'
                ],
            ]) ?>
        </div>
    </div>

    <br>
    <div class="card card-custom">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <h1>Items</h1>
            </div>
            <div class="card-toolbar">
                <?= Html::a('Set Items', ['group/set-items','id'=>$model->id], ['class' => 'btn btn-success']) ?>
            </div>
        </div>

        <div class="card-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    'id',
                    [
                        'attribute' => 'Kategori',
                        'format'    => 'raw',
                        'value'     => function ($model) {
                            return $model->category->name;
                        }
                    ],
                    'sequenced_number'
                ],
            ]); ?>
        </div>
    </div>
</div>