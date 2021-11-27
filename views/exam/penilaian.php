<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Exam */

$this->title = 'Penilaian';
$this->tab_active = "exams";
$this->menu_active = "all exams";
$this->params['breadcrumbs'][] = ['label' => 'Exams', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view','id'=>$model->id]];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="exam-view">
    <div class="card card-custom">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <h1>Upload File Penilaian</h1>
            </div>
        </div>
        <div class="card-body">
            <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

            <?= $form->field($upload_model, 'exam_id')->hiddenInput()->label(false) ?>

            <?= $form->field($upload_model, 'file_path')->input('file') ?>

            <div class="form-group">
                <?= Html::submitButton('Import', ['class' => 'btn btn-success']) ?>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>
    <br>

    <?php if($worksheet): ?>
    <?php
        $highestRow  = $worksheet->getHighestRow();
        $highestColumn = $worksheet->getHighestColumn();
        $highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn);
        $num_rows = ($highestRow - 6);
        $count_partial = ceil($num_rows / 30);
        // for ($row = 4; $row <= $highestRow; $row++) { 
        //     echo $worksheet->getCellByColumnAndRow(3, $row)->getValue() . '<br>';
        // }
    ?>
    <div class="card card-custom">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <h1><?= Html::encode($this->title) ?></h1>
            </div>
            <div class="card-toolbar">
            <?= Html::a('Download PDF', ['download-all','id'=>$model->id], ['class' => 'btn btn-primary']) ?>&nbsp;
            <?php for($i=1;$i<=$count_partial;$i++): ?>
                <?= Html::a('Cetak '.$i, ['cetak','id'=>$model->id,'part'=>$i], ['class' => 'btn btn-success']) ?>
                &nbsp;
            <?php endfor; ?>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <tbody>
                        <?php /*
                        <tr>
                            <?php 
                            for ($col = 2; $col <= 31; $col++) { 
                                $add_attr = " rowspan='2' ";
                                $_col = $col;
                                if($col==14)
                                {
                                    $add_attr =  " colspan='4' ";
                                    $col = 17;
                                }
                                
                                if($col==18)
                                {
                                    $add_attr =  " colspan='2' ";
                                    $col = 19;
                                }
                                
                                if($col==20)
                                {
                                    $add_attr =  " colspan='3' ";
                                    $col = 22;
                                }

                                if($col==23)
                                {
                                    $add_attr =  " colspan='3' ";
                                    $col = 25;
                                }

                                if($col==26)
                                {
                                    $add_attr =  " colspan='3' ";
                                    $col = 28;
                                }
                            ?>
                            <td style="white-space:nowrap;text-align:center;vertical-align:middle;" <?=$add_attr?>><?=$worksheet->getCellByColumnAndRow($_col, 2)->getValue()?></td>
                            <?php } ?>
                        </tr>
                        <tr>
                            <?php for ($col = 14; $col <= 28; $col++) { ?>
                            <td style="text-align:center;vertical-align:middle;"><?=$worksheet->getCellByColumnAndRow($col, 3)->getValue()?></td>
                            <?php } ?>
                        </tr>
                        */ ?>
                        <?php 
                        for ($row = 3; $row <= $highestRow; $row++) { 
                            $no = $row-2; 
                            if($worksheet->getCellByColumnAndRow(2, $row)->getFormattedValue() == '') break;
                        ?>
                        <tr>
                            <td><?=$no?></td>
                            <?php 
                            for ($col = 3; $col <= 27; $col++) {
                                $value = $worksheet->getCellByColumnAndRow($col, $row)->getFormattedValue();
                                if($value == '' || $value == 'Job Profile') break;
                            ?>
                            <td><?= $value ?></td>
                            <?php } ?>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            
        </div>
    </div>
    <?php endif ?>
</div>
