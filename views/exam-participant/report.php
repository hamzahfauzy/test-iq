<?php

use yii\helpers\Url;
$norma = \Yii::$app->params['norma'];

$graphics = [];

$IQ = "Mentally Defective";
if($participant['score']['CFIT'] >= 130) $IQ = "Very Superior";
if($participant['score']['CFIT'] >= 116 && $participant['score']['CFIT'] <= 129) $IQ = "Superior";
if($participant['score']['CFIT'] >= 101 && $participant['score']['CFIT'] <= 115) $IQ = "High Average";
if($participant['score']['CFIT'] >= 85 && $participant['score']['CFIT'] <= 100) $IQ = "Average";
if($participant['score']['CFIT'] >= 70 && $participant['score']['CFIT'] <= 84) $IQ = "Low Average";
if($participant['score']['CFIT'] < 70) $IQ = "Under Average";

$min = 999999;
$max = 0;

$total=0; 
foreach($participant['score']['partial_cfit'] as $cfit)
{
    $total+=$cfit;
    $min = $cfit < $min ? $cfit : $min;
    $max = $cfit > $max ? $cfit : $max;
}

$skor=$participant['score']['CFIT'];
$s = 0;
$cfit_row = "<tr><td>1</td><td>Tingkat Intelektual</td><td width='380'>Tingkat potensi yang dimiliki oleh individu untuk mempelajari sesuatu lewat alat-alat berpikir</td>";
if($skor>=130)
{
    $cfit_row .= "<td></td><td></td><td style='background:#eaeaea;'></td><td></td><td style='text-align:center;'>X</td></tr>";
    $s+=5;
    $graphics[] = 5;
}
elseif($skor >= 111 && $skor <= 129)
{
    $cfit_row .= "<td></td><td></td><td style='background:#eaeaea;'></td><td style='text-align:center;'>X</td><td></td></tr>";
    $s+=4;
    $graphics[] = 4;
}
elseif($skor >= 90 && $skor <= 110)
{
    $cfit_row .= "<td></td><td></td><td style='background:#eaeaea;'>X</td><td></td><td></td></tr>";
    $s+=3;
    $graphics[] = 3;
}
elseif($skor >= 70 && $skor <= 89)
{
    $cfit_row .= "<td></td><td style='text-align:center'><span style='background-color:yellow;'>X</span></td><td style='background:#eaeaea;'></td><td></td><td></td></tr>";
    $s+=2;
    $graphics[] = 2;
}
else
{
    $cfit_row .= "<td style='text-align:center'><span style='background-color:yellow;'>X</span></td><td></td><td style='background:#eaeaea;'></td><td></td><td></td></tr>";
    $s+=1;
    $graphics[] = 1;
}

$cfit_row .= "<tr><td>2</td><td>Fleksibilitas Berpikir</td><td width='380'>Kemampuan menggunakan berbagai sudut pandang dalam menghadapi tuntutan perubahan</td>";
$skor=$max-$min;
if($skor==0)
{
    $cfit_row .= "<td></td><td></td><td style='background:#eaeaea;'></td><td></td><td style='text-align:center;'>X</td></tr>";
    $s+=5;
    $graphics[] = 5;
}
elseif($skor >= 1 && $skor <= 3)
{
    $cfit_row .= "<td></td><td></td><td style='background:#eaeaea;'></td><td style='text-align:center;'>X</td><td></td></tr>";
    $s+=4;
    $graphics[] = 4;
}
elseif($skor >= 4 && $skor <= 6)
{
    $cfit_row .= "<td></td><td></td><td style='background:#eaeaea;'>X</td><td></td><td></td></tr>";
    $s+=3;
    $graphics[] = 3;
}
elseif($skor >= 7 && $skor <= 9)
{
    $cfit_row .= "<td></td><td style='text-align:center'><span style='background-color:yellow;'>X</span></td><td style='background:#eaeaea;'></td><td></td><td></td></tr>";
    $s+=2;
    $graphics[] = 2;
}
else
{
    $cfit_row .= "<td style='text-align:center'><span style='background-color:yellow;'>X</span></td><td></td><td style='background:#eaeaea;'></td><td></td><td></td></tr>";
    $s+=1;
    $graphics[] = 1;
}

$cfit_row .= "<tr><td>3</td><td>Berpikir Analitis</td><td width='380'>Kemampuan menguraikan permasalahan berdasarkan informasi yang relevan dari berbagai sumber secara komprehensif untuk mengiden-tifikasi penyebab dan dampak terhadap organisasi</td>";
$skor=$total;
if($skor>=41)
{
    $cfit_row .= "<td></td><td></td><td style='background:#eaeaea;'></td><td></td><td style='text-align:center;'>X</td></tr>";
    $s+=5;
    $graphics[] = 5;
}
elseif($skor >= 31 && $skor <= 40)
{
    $cfit_row .= "<td></td><td></td><td style='background:#eaeaea;'></td><td style='text-align:center;'>X</td><td></td></tr>";
    $s+=4;
    $graphics[] = 4;
}
elseif($skor >= 21 && $skor <= 30)
{
    $cfit_row .= "<td></td><td></td><td style='background:#eaeaea;'>X</td><td></td><td></td></tr>";
    $s+=3;
    $graphics[] = 3;
}
elseif($skor >= 11 && $skor <= 20)
{
    $cfit_row .= "<td></td><td style='text-align:center'><span style='background-color:yellow;'>X</span></td><td style='background:#eaeaea;'></td><td></td><td></td></tr>";
    $s+=2;
    $graphics[] = 2;
}
else
{
    $cfit_row .= "<td style='text-align:center'><span style='background-color:yellow;'>X</span></td><td></td><td style='background:#eaeaea;'></td><td></td><td></td></tr>";
    $s+=1;
    $graphics[] = 1;
}

$cfit_row .= "<tr><td>4</td><td>Berpikir Abstraksi</td><td width='380'>Kemampuan untuk memproses sebuah informasi yang berkaitan dengan objek, prinsip, dan konsep-konsep, yang secara fisik tidak dapat dimunculkan</td>";
$skor=$participant['score']['partial_cfit']['CFIT 4'];
if($skor>=9)
{
    $cfit_row .= "<td></td><td></td><td style='background:#eaeaea;'></td><td></td><td style='text-align:center;'>X</td></tr>";
    $s+=5;
    $graphics[] = 5;
}
elseif($skor >= 7 && $skor <= 8)
{
    $cfit_row .= "<td></td><td></td><td style='background:#eaeaea;'></td><td style='text-align:center;'>X</td><td></td></tr>";
    $s+=4;
    $graphics[] = 4;
}
elseif($skor >= 5 && $skor <= 6)
{
    $cfit_row .= "<td></td><td></td><td style='background:#eaeaea;'>X</td><td></td><td></td></tr>";
    $s+=3;
    $graphics[] = 3;
}
elseif($skor >= 3 && $skor <= 4)
{
    $cfit_row .= "<td></td><td style='text-align:center'><span style='background-color:yellow;'>X</span></td><td style='background:#eaeaea;'></td><td></td><td></td></tr>";
    $s+=2;
    $graphics[] = 2;
}
else
{
    $cfit_row .= "<td style='text-align:center'><span style='background-color:yellow;'>X</span></td><td></td><td style='background:#eaeaea;'></td><td></td><td></td></tr>";
    $s+=1;
    $graphics[] = 1;
}

?>
<style>
body, h2 {
    margin:0;padding:0
}
#customers {
  border-collapse: collapse;
}

#customers td, #customers th {
  border: 1px solid #000;
  padding: 5px;
}

/* #customers tr:nth-child(even){background-color: #f2f2f2;}

#customers tr:hover {background-color: #ddd;} */

#customers th {
  padding-top: 12px;
  padding-bottom: 12px;
  background-color: #eaeaea;
}

ul.index {
    list-style-type:none;
    margin:0px;
    padding:0px;
    padding-left:-15px;
    padding-bottom:-25px;
}
ul.index li {
    height:25px;
}
.box {
    background-color:red;
}
</style>
<body>
<img src="images/kop.png" style="width:100%">
<p style="text-align:center;">
<b>LAPORAN HASIL ASSESMEN GURU</b><br />
<i>TEACHER ASSESMENT REPORT</i>
</p>

<table id="customers" align="center">
    <tr>
        <td class="border-cell" width="250">Nama</td>
        <td class="border-cell" width="30">:</td>
        <td class="border-cell" width="250"><?=$peserta->getMeta('nama_lengkap');?></td>
    </tr>
    <tr>
        <td class="border-cell">Jenis Kelamin</td>
        <td class="border-cell">:</td>
        <td class="border-cell"><?=$peserta->getMeta('jenis_kelamin');?></td>
    </tr>
    <tr>
        <td class="border-cell">Tempat, Tanggal Lahir</td>
        <td class="border-cell">:</td>
        <td class="border-cell"><?=$peserta->getMeta('tempat_tanggal_lahir');?></td>
    </tr>
    <tr>
        <td class="border-cell">Pendidikan Terakhir</td>
        <td class="border-cell">:</td>
        <td class="border-cell"><?=$peserta->getMeta('pendidikan_terakhir');?></td>
    </tr>
    <tr>
        <td class="border-cell">Bidang Studi</td>
        <td class="border-cell">:</td>
        <td class="border-cell"><?=$peserta->getMeta('pelajaran');?></td>
    </tr>
    <tr>
        <td class="border-cell">Asal Sekolah</td>
        <td class="border-cell">:</td>
        <td class="border-cell"><?=$examParticipant->exam->name?></td>
    </tr>
    <tr style="border-left:1px;border-right:1px">
        <td colspan="3" style="border-left:1px;border-right:1px">
            <br />
        </td>
    </tr>
    <tr>
        <td width="200px">Tanggal Pemeriksaan</td>
        <td width="10px">:</td>
        <td><?=$examParticipant->updated_at?></td>
    </tr>
    <tr>
        <td>Tujuan Pemeriksaan</td>
        <td>:</td>
        <td>Individual Assesment Review</td>
    </tr>
    <tr>
        <td>Sifat Dokumen</td>
        <td>:</td>
        <td>RAHASIA</td>
    </tr>
</table>
<div style="page-break-after: always"></div>
<br />
<b>1. TABEL HASIL STUDENT PROFILING</b><br />
<p></p>
<table id="customers" align="center">
    <tr>
        <th colspan="3"><h2 align="center">IQ : <?=$IQ?></h2></th>
        <th colspan="5" style="text-align:center;"><h2 align="center">IQ : <?=$participant['score']['CFIT']?></h2><i>CFIT scale</i></th>
    </tr>
    <tr>
        <td style="text-align:center;background:#eaeaea;" rowspan="2">NO</td>
        <td style="text-align:center;background:#eaeaea;" rowspan="2">ASPEK</td>
        <td style="text-align:center;background:#eaeaea;" rowspan="2">PENJELASAN</td>
        <td style="text-align:center;background:#eaeaea;" colspan="5">SKALA</td>
    </tr>
    <tr>
        <td style="text-align:center;background:#eaeaea;">1</td>
        <td style="text-align:center;background:#eaeaea;">2</td>
        <td style="text-align:center;background:#eaeaea;">3</td>
        <td style="text-align:center;background:#eaeaea;">4</td>
        <td style="text-align:center;background:#eaeaea;">5</td>
    </tr>
    <tr>
        <td style="background:#eaeaea;" colspan="8"><b>KEMAMPUAN BERFIKIR</b></td>
    </tr>
    <?php
    echo $cfit_row; 
    $total_nilai = $s;
    $descriptions = [
        'N' => [
            'title' => 'Tanggung Jawab',
            'description' => 'Loyalitas, integritas dan komitmen untuk  melaksanakan tugas secara tuntas dan tepat waktu '
        ],
        'F' => [
            'title' => 'Loyalitas',
            'description' => 'Kepatuhan pada aturan dan prosedur, serta rasa memiliki terhadap organisasi'
        ],
        'G' => [
            'title' => 'Daya Juang',
            'description' => 'Kemampuan untuk mau bekerja keras dan tidak mudah putus asa dalam berusaha mencapai tujuan dan mampu mempertahankannya'
        ],
        'A' => [
            'title' => 'Semangat Berprestasi',
            'description' => 'Kemampuan untuk selalu meningkatkan kinerja dengan lebih baik di atas standar secara terus-menerus'
        ],
        'O' => [
            'title' => 'Kepercayaan Diri',
            'description' => 'Keyakinan yang kuat akan kemampuan dalam melaksanakan pekerjaan, berhubungan dan berkompetisi dengan orang lain'
        ],
        'Z' => [
            'title' => 'Penyesuaian Diri',
            'description' => 'Kemampuan untuk merespon perubahan, kemauan belajar dengan mendengarkan dan memahami pikiran, perasaan orang lain'
        ],
        'E' => [
            'title' => 'Pengendalian Diri',
            'description' => 'Kemampuan untuk mengendalikan diri pada saat menghadapi masalah yang sulit, kritik dari orang lain atau pada saat bekerja di bawah tekanan dengan sikap yang positif'
        ],
        'S' => [
            'title' => 'Kerja Sama Dalam Tim',
            'description' => 'Tingkat relasi dan kemampuan menyelesaikan pekerjaan secara bersama-sama dengan menjadi bagian dari suatu kelompok untuk mencapai tujuan unit / organisasi'
        ],
        'I' => [
            'title' => 'Pengambilan Keputusan',
            'description' => 'Kemampuan mengambil keputusan secara cepat dan tepat'
        ],
        'L' => [
            'title' => 'Peran Sebagai Pemimpin',
            'description' => 'Kecenderungan menggunakan orang lain untuk mencapai tujuan'
        ],
        'P' => [
            'title' => 'Pengendalian Orang Lain',
            'description' => 'Kemampuan dalam menyusun perencanaan, mengawasi proses dan hasil-hasilnya, mengarahkan dan memotivasi orang lain, dan pola komunikasi yang efektif'
        ],
    ];
    $no=5;
    foreach($participant['score']['Papikostick'] as $key => $vp): 
        // echo $key;
        $_norma = $norma[$key];
        foreach($_norma as $n)
        {
            if(in_array($vp, $n['in_nilai']))
            {
                $vp = $n['nilai'];
                break;
            }
        }
        $graphics[] = $vp;
        $total_nilai += $vp;

        $vp_value = "";
        for($i=1;$i<=5;$i++)
        {
            $bg = $i==3 ? 'style="background:#eaeaea;text-align:center;"' : 'style="text-align:center;"';
            $span = $i<=2 ? '<span style="background-color:yellow;">X</span>' : 'X';
            if($vp == $i)
                $vp_value .= "<td width='10' $bg>$span</td>";
            else
                $vp_value .= "<td width='10' $bg></td>";
        }
        
    if($key=='N'): ?>
    <tr>
        <td style="background:#eaeaea;" colspan="8"><b>TANGGUNG JAWAB DAN LOYALITAS</b></td>
    </tr>
    <?php elseif($key=='G'): ?>
    <tr>
        <td style="background:#eaeaea;" colspan="8"><b>KEHANDALAN DALAM BEKERJA</b></td>
    </tr>
    <?php elseif($key=='Z'): ?>
    <tr>
        <td style="background:#eaeaea;" colspan="8"><b>RASA MEMILIKI TERHADAP ORGANISASI</b></td>
    </tr>
    <?php elseif($key=='I'): ?>
    <tr>
        <td style="background:#eaeaea;" colspan="8"><b>KEPEMIMPINAN</b></td>
    </tr>
    <?php endif ?>
    <tr>
        <td><?=$no++?></td>
        <td><?=$descriptions[$key]['title']?></td>
        <td width="380"><?=$descriptions[$key]['description']?></td>
        <?=$vp_value?>
    </tr>
    <?php endforeach ?>
</table>
<br />
<div style="text-align:center;width:100%">
    <i>Keterangan:  1: Sangat Kurang&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2: Kurang&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;3: Cukup&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;4: Baik&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;5: Sangat Baik</i>
</div>
<div style="page-break-after: always"></div>
<br />
<b>2. GRAFIK INDEKS PROFIL GURU</b><br /><br />
<div style="width:100%;border:1px solid #000;min-height:100px;">
    <p style="text-align:center;font-weight:bold;">GRAFIK INDEKS PROFIL GURU (IPG)</p>
    <br />
    <table id="customers" align="center" style="width:260px">
        <tr>
            <td style="width:15px">
                <ul class="index">
                    <li>5</li>
                    <li>4</li>
                    <li>3</li>
                    <li>2</li>
                    <li>1</li>
                    <li>0</li>
                </ul>
            </td>
            <?php foreach($graphics as $g): ?>
            <td style="width:15px;vertical-align:bottom;"><div class="box" style="height:<?=$g*25?>px"></div></td>
            <?php endforeach ?>
        </tr> 
        <tr>
            <td style="text-align:center;"></td>
            <td style="text-align:center;">1</td>
            <td style="text-align:center;">2</td>
            <td style="text-align:center;">3</td>
            <td style="text-align:center;">4</td>
            <td style="text-align:center;">5</td>
            <td style="text-align:center;">6</td>
            <td style="text-align:center;">7</td>
            <td style="text-align:center;">8</td>
            <td style="text-align:center;">9</td>
            <td style="text-align:center;">10</td>
            <td style="text-align:center;">11</td>
            <td style="text-align:center;">12</td>
            <td style="text-align:center;">13</td>
            <td style="text-align:center;">14</td>
            <td style="text-align:center;">15</td>
        </tr>
        <?php /*
        <tr>
            <td></td>
            <td style="text-align:center;font-weight:bold" colspan="4">KEMAMPUAN<br />INTELEKTUAL</td>
            <td style="text-align:center;font-weight:bold" colspan="2">TANGGUNG<br />JAWAB<br />DAN LOYALITAS</td>
            <td style="text-align:center;font-weight:bold" colspan="3">KEHANDALAN<br />DALAM<br />BEKERJA</td>
            <td style="text-align:center;font-weight:bold" colspan="3">RASA MEMILIKI<br />TERHADAP<br />ORGANISASI</td>
            <td style="text-align:center;font-weight:bold" colspan="3">KEPEMIMPINAN</td>
        </tr> */ ?>
    </table>
    <br />
</div>
<br />
<b>3. TINGKAT INDEKS PROFIL GURU (IPG)</b><br />
<p></p>
<table id="customers" align="center">
    <tr>
        <td colspan="3" width="400">Tingkat Indeks Profil Guru Berdasarkan Hasil adalah : </td>
        <td width="300" style="background:green;color:#FFF" colspan="2">
            <h2 style="align:center"><?=number_format($total_nilai/45*100);?>%</h2>
        </td>
    </tr>
    <tr>
        <td>Di bawah 55%</td>
        <td>56 - 70 %</td>
        <td>71 - 85 %</td>
        <td>86 - 100 %</td>
        <td>Di atas 100 %</td>
    </tr>
    <tr>
        <td><i>Sangat Rendah</i></td>
        <td><i>Rendah</i></td>
        <td><i>Sedang</i></td>
        <td><i>Tinggi</i></td>
        <td><i>Sangat Tinggi</i></td>
    </tr>
</table>
<br /><br /><br />
<div style="text-align:center;width:100%">
    Medan, <?= date('d') ?> <?= Yii::$app->params['bulan'][(int) date('m')] ?> <?= date('Y')?><br />
    Penanggung Jawab
</div>
<p></p>
<img src="images/ttd.png" style="width:100%" />
</body>