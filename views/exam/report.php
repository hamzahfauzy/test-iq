<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ExamSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Exam Report';
$this->tab_active = "exams";
$this->menu_active = "all exams";
$this->params['breadcrumbs'][] = ['label' => 'Exams', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
.nowrap {
    white-space: nowrap;
}
.heading {
    font-weight:bold;
    text-align:center;
    vertical-align:middle!important;
}
</style>
<div class="exam-index">
    <div class="card card-custom">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <h1><?= Html::encode($this->title) ?></h1>
            </div>
            <div class="card-toolbar">
            </div>
        </div>
        <div class="card-body">   
            <div class="table-responsive">
                <table class="table table-bordered">
                    <tr>
                        <td class="nowrap heading" rowspan="2">#</td>
                        <td class="nowrap heading" rowspan="2">Nama Peserta</td>
                        <td class="nowrap heading" rowspan="2">Asal Sekolah</td>
                        <td class="nowrap heading" rowspan="2">Bidang Studi</td>
                        <td class="nowrap heading" rowspan="2">Usia</td>
                        <td class="nowrap heading" rowspan="2">Lama Bekerja</td>
                        <td class="nowrap heading" rowspan="2">Kategori IQ</td>
                        <td class="nowrap heading" rowspan="2">IQ</td>
                        <td class="nowrap heading" colspan="3">Kemampuan Intelektual</td>
                        <td class="nowrap heading" colspan="4">Motivasi Kerja</td>
                        <td class="nowrap heading" colspan="4">Sosiabilitas dan Pengendalian Diri</td>
                        <td class="heading" rowspan="2">Tipe Kepemimpinan</td>
                        <td class="heading" rowspan="2">Total Nilai</td>
                        <td class="heading" rowspan="2">Job Person Match (%)</td>
                        <td class="nowrap heading" rowspan="2">Keterangan</td>
                    </tr>
                    <tr>
                        <td class="heading">Fleksibilitas Berpikir</td>
                        <td class="heading">Berpikir Analitis</td>
                        <td class="heading">Berpikir Konseptual</td>
                        <td class="heading">Daya Juang (G)</td>
                        <td class="heading">Semangat Berprestasi (A)</td>
                        <td class="heading">Tanggung Jawab (N)</td>
                        <td class="heading">Loyalitas (F)</td>
                        <td class="heading">Penyesuaian Diri (Z)</td>
                        <td class="heading">Pengendalian Diri (E)</td>
                        <td class="heading">Kerjasama Dalam Tim (S)</td>
                        <td class="heading">Kepercayaan Diri (O)</td>
                    </tr>
                    <?php 
                    foreach($report as $key => $value): 
                        $total_nilai = $value['score']['CFIT'];
                        $total_nilai += $value['score']['MSDT']['msdt_final_value'];

                        $IQ = "Mentally Defective";
                        $IQ_VALUE = "<td>2</td><td>2</td><td>2</td>";
                        $IQ_VALUE_ALL = 6;
                        if($value['score']['CFIT'] >= 170) $IQ = "Genius";
                        if($value['score']['CFIT'] >= 140 && $value['score']['CFIT'] <= 169) $IQ = "Very Superior";
                        if($value['score']['CFIT'] >= 120 && $value['score']['CFIT'] <= 139) $IQ = "Superior";
                        if($value['score']['CFIT'] >= 110 && $value['score']['CFIT'] <= 119) $IQ = "High Average";
                        if($value['score']['CFIT'] >= 90 && $value['score']['CFIT'] <= 109) $IQ = "Average";
                        if($value['score']['CFIT'] >= 80 && $value['score']['CFIT'] <= 89) $IQ = "Low Average";
                        if($value['score']['CFIT'] >= 70 && $value['score']['CFIT'] <= 79) $IQ = "Borderline";

                        if($value['score']['CFIT'] >= 170) $IQ_VALUE = "<td>5</td><td>5</td><td>5</td>";
                        if($value['score']['CFIT'] >= 140 && $value['score']['CFIT'] <= 169) $IQ_VALUE = "<td>5</td><td>5</td><td>5</td>";
                        if($value['score']['CFIT'] >= 120 && $value['score']['CFIT'] <= 139) $IQ_VALUE = "<td>5</td><td>4</td><td>4</td>";
                        if($value['score']['CFIT'] >= 110 && $value['score']['CFIT'] <= 119) $IQ_VALUE = "<td>4</td><td>4</td><td>4</td>";
                        if($value['score']['CFIT'] >= 90 && $value['score']['CFIT'] <= 109) $IQ_VALUE = "<td>3</td><td>3</td><td>3</td>";
                        if($value['score']['CFIT'] >= 80 && $value['score']['CFIT'] <= 89) $IQ_VALUE = "<td>2</td><td>3</td><td>3</td>";

                        if($value['score']['CFIT'] >= 170) $IQ_VALUE_ALL = 15;
                        if($value['score']['CFIT'] >= 140 && $value['score']['CFIT'] <= 169) $IQ_VALUE_ALL = 15;
                        if($value['score']['CFIT'] >= 120 && $value['score']['CFIT'] <= 139) $IQ_VALUE_ALL = 13;
                        if($value['score']['CFIT'] >= 110 && $value['score']['CFIT'] <= 119) $IQ_VALUE_ALL = 12;
                        if($value['score']['CFIT'] >= 90 && $value['score']['CFIT'] <= 109) $IQ_VALUE_ALL = 9;
                        if($value['score']['CFIT'] >= 80 && $value['score']['CFIT'] <= 89) $IQ_VALUE_ALL = 8;
                        
                        $total_nilai += $IQ_VALUE_ALL;
                    ?>
                    <tr>
                        <td><?=++$key?></td>
                        <td class="nowrap"><?=$value['name']?></td>
                        <td class="nowrap"><?=$value['school']?></td>
                        <td class="nowrap"><?=$value['study']?></td>
                        <td class="nowrap"><?=$value['age']?> Tahun</td>
                        <td><?=$value['work_time']?></td>
                        <td><?=$value['score']['CFIT']?></td>
                        <td class="nowrap"><?=$IQ?></td>
                        <?=$IQ_VALUE?>
                        <?php 
                        foreach($value['score']['Papikostick'] as $vp): 
                            if($vp >= 8 && $vp <= 9)
                                $vp = 5;
                            elseif($vp >= 6 && $vp <= 7)
                                $vp = 4;
                            elseif($vp >= 4 && $vp <= 5)
                                $vp = 3;
                            elseif($vp >= 2 && $vp <= 3)
                                $vp = 2;
                            else
                                $vp = 1;
                            $total_nilai += $vp;
                        ?>
                        <td><?=$vp?></td>
                        <?php 
                        endforeach;
                        $jpm = number_format($total_nilai/36)*100;
                        $keterangan = "Sangat Tidak Memenuhi Syarat";
                        if($jpm >= 100) $keterangan = "Sangat Memenuhi Syarat";
                        if($jpm >= 86 && $jpm <= 99) $keterangan = "Memenuhi Syarat";
                        if($jpm >= 71 && $jpm <= 85) $keterangan = "Cukup Memenuhi Syarat";
                        if($jpm >= 56 && $jpm <= 70) $keterangan = "Tidak Memenuhi Syarat";
                        ?>
                        <td><?=$value['score']['MSDT']['msdt_final_value']?></td>
                        <td><?=$total_nilai?></td>
                        <td><?=$jpm?>%</td>
                        <td class="nowrap"><?=$keterangan?></td>
                    </tr>
                    <?php endforeach ?>
                </table>
            </div>
        </div>
    </div>
</div>
