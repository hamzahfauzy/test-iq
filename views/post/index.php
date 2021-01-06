<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Posts';
$this->menu_active = "posts";
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-index">
    <div class="card card-custom">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <h1><?= Html::encode($this->title) ?></h1>
            </div>
            <div class="card-toolbar">
                <?= Html::a('Create Post', ['create'], ['class' => 'btn btn-success']) ?>
            </div>
        </div>
        <div class="card-body">
            <form action="">
                <div class="form-group">
                    <input type="text" name="PostSearch[post_title]" class="form-control" placeholder="Search..." value="<?=$searchModel->post_title?>">
                </div>
            </form>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                // 'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    'post_title',
                    [
                        'attribute' => 'category',
                        'value'     => 'categoryPost.name',
                    ],
                    // 'post_as',
                    'post_date',

                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
        </div>
    </div>
</div>
