<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Exam */

$this->title = $model->name;
$this->tab_active = "exams";
$this->menu_active = "all exams";
$this->params['breadcrumbs'][] = ['label' => 'Exams', 'url' => ['index']];
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
                <?= Html::a('<i class="fa fa-eye fa-fw"></i> Penilaian', ['exam/penilaian', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
                &nbsp;
                <?= Html::a('<i class="fa fa-download fa-fw"></i> Download', ['exam/download', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
                &nbsp;
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
                    'name',
                    [
                        'attribute' => 'Test Group',
                        'format'    => 'raw',
                        'value'     => function ($model) {
                            return $model->group?$model->group->name:'-';
                        }
                    ],
                    'start_time',
                    'end_time',
                ],
            ]) ?>
        </div>
    </div>

    <br>
    <div class="card card-custom">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <h1>Participants</h1>
            </div>
            <div class="card-toolbar">
                <?= Html::a('Add Participants', ['exam-participant/create','exam_id'=>$model->id], ['class' => 'btn btn-success']) ?>
                &nbsp;
                <?= Html::a('Import', ['participant/imports','exam_id'=>$model->id], ['class' => 'btn btn-success']) ?>
            </div>
        </div>

        <div class="card-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    [
                        'attribute' => '#',
                        'format'    => 'raw',
                        'value'     => function($model){
                            return '<input type="checkbox" class="bulk_print" name="bulk_print[]" value="'.$model->participant_id.'">';
                        }
                    ],
                    'participant.id_number',
                    'participant.name',
                    [
                        'attribute' => 'Status',
                        'format' => 'raw',
                        'value' => function($model){
                            $status = $model->status?$model->status:'-';
                            if($status != '-')
                            {
                                $status .= ' - <a href="'.Url::to(['exam-participant/reset','id'=>$model->id]).'">Reset Semua</a>';
                                $status .= ' - <a href="'.Url::to(['exam-participant/reset-session','id'=>$model->id]).'">Reset Sesi</a>';
                            }
                            return $status;
                        }
                    ],
                    [
                        'attribute' => 'Jurusan',
                        'format' => 'raw',
                        'value' => function($model){
                            $status = $model->participant->study?$model->participant->study:'-';
                            return $status;
                        }
                    ],
                    [
                        'attribute' => 'Download',
                        'format' => 'raw',
                        'value' => function($model){
                            return $model->status?'<a href="'.Url::to(['exam-participant/download','id'=>$model->id]).'" target="_blank">Download</a>':'-';
                        }
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'buttons' => [
                            'delete' => function($url, $model){
                                return Html::a(
                                    '<span class="glyphicon glyphicon-trash"></span>',
                                    Url::to(['exam-participant/delete','id'=>$model->id]),
                                    [
                                        'data-method'=>'post',
                                        'confirm' => 'Are you sure to delete this data ?'
                                    ]
                                );
                            },
                            'update' => function($url){
                                return '';
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
</div>