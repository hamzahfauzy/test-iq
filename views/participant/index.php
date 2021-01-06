<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ParticipantSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Participants';
$this->menu_active = "participants";
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="participant-index">
    <div class="card card-custom">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <h1><?= Html::encode($this->title) ?></h1>
            </div>
            <div class="card-toolbar">
                <?= Html::a('Import Participant', ['imports'], ['class' => 'btn btn-primary']) ?>
                &nbsp;
                <?= Html::a('Create Participant', ['create'], ['class' => 'btn btn-success']) ?>
            </div>
        </div>
        <div class="card-body">    
            <form action="">
                <div class="form-group">
                    <input type="text" name="ParticipantSearch[name]" class="form-control" placeholder="Search..." value="<?=$searchModel->name?>">
                </div>
            </form>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                // 'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'id_number',
                    'name',
                    // 'address:ntext',
                    // 'phone',
                    // 'birthdate',

                    [
                        'class' => 'yii\grid\ActionColumn',
                        'buttons' => [
                            'view' => function($url)
                            {
                                return '';
                            }
                        ]
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>
