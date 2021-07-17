<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ExamSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Exams';
$this->tab_active = "exams";
$this->menu_active = "all exams";
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="exam-index">
    <div class="card card-custom">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <h1><?= Html::encode($this->title) ?></h1>
            </div>
            <div class="card-toolbar">
                <?= Html::a('Create Exam', ['create'], ['class' => 'btn btn-success']) ?>
            </div>
        </div>
        <div class="card-body">    
            <form action="">
                <div class="form-group">
                    <input type="text" name="ExamSearch[name]" class="form-control" placeholder="Search..." value="<?=$searchModel->name?>">
                </div>
            </form>
            <div class="table-responsive">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                // 'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    'name',
                    [
                        'attribute' => 'Test Group',
                        'format'    => 'raw',
                        'value'     => function ($model) {
                            return $model->groupName();
                        }
                    ],
                    'start_time',
                    'end_time',
                    [
                        'attribute' => 'Report',
                        'format' => 'raw',
                        'value' => function($model){
                            $test_group = Yii::$app->params['test_group'];
                            $tools = $test_group[$model->test_group]['tools'];
                            $report = '';
                            if(count($tools) > 1)
                            foreach($tools as $tool)
                            {
                                $report .= Html::a('<i class="fa fa-download fa-fw"></i> Download '.$tool, ['exam/new-download', 'id' => $model->id, 'tool' => $tool]) . '<br>';
                            }

                            return $report . Html::a('<i class="fa fa-download fa-fw"></i> Report', ['exam/download', 'id' => $model->id]) . '<br>';;
                        }
                    ],
                    [
                        'attribute' => 'Berita Acara',
                        'format' => 'raw',
                        'value' => function($model){
                            return Html::a('<i class="fa fa-download fa-fw"></i> Download', ['exam/download-ba', 'id' => $model->id],['class'=>'btn btn-success']);
                        }
                    ],

                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
            </div>
        </div>
    </div>
</div>
