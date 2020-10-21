<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Post */

$this->title = $model->post_title;
$this->menu_active = "posts";
$this->params['breadcrumbs'][] = ['label' => 'Posts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="post-view">
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
                    'post_title',
                    [
                        'attribute' => 'Category',
                        'value'     => $model->categoryPost ? $model->categoryPost->name : '',
                    ],
                    'post_content:ntext',
                    'post_as',
                    'post_type',
                    'post_date',
                ],
            ]) ?>
        </div>
    </div>

    <?php if($model->post_as == 'Soal'): ?>
    <br>
    <div class="card card-custom">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <h1>Answers</h1>
            </div>
            <div class="card-toolbar">
                <?= Html::a('Create Answer', ['create','as'=>'Jawaban','parent'=>$model->id], ['class' => 'btn btn-success']) ?>
            </div>
        </div>

        <div class="card-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'attribute' => 'Content',
                        'value' => 'child.post_content'
                    ],
                    [
                        'attribute' => 'Score',
                        'value' => 'child.post_type'
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'buttons' => [
                            'update' => function($url, $model){
                                return Html::a('<span class="glyphicon glyphicon-pencil"></span>',Url::to(['post/update','id'=>$model->child_id]));
                            },
                            'delete' => function($url, $model){
                                return Html::a(
                                    '<span class="glyphicon glyphicon-trash"></span>',
                                    Url::to(['post/delete','id'=>$model->child_id]),
                                    [
                                        'data-method'=>'post',
                                        'data-confirm'=>'Are you sure to delete this item ?'
                                    ]
                                );
                            },
                            'view' => function($url){
                                return '';
                            }
                        ]
                    ],
                ],
            ]); ?>
        </div>
    </div>
    <?php endif ?>
</div>
