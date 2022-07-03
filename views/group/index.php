<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ExamSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Groups';
$this->tab_active = "groups";
$this->menu_active = "all groups";
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="exam-index">
    <div class="card card-custom">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <h1><?= Html::encode($this->title) ?></h1>
            </div>
            <div class="card-toolbar">
                <?= Html::a('Create Group', ['create'], ['class' => 'btn btn-success']) ?>
            </div>
        </div>
        <div class="card-body">    
            <form action="">
                <div class="form-group">
                    <input type="text" name="GroupSearch[name]" class="form-control" placeholder="Search..." value="<?=$searchModel->name?>">
                </div>
            </form>
            <div class="table-responsive">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                // 'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'name',
                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
            </div>
        </div>
    </div>
</div>
