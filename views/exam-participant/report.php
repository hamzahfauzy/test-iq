<?php

use yii\helpers\Url;

$IQ = "Mentally Defective";
if($participant['score']['CFIT'] >= 170) $IQ = "Genius";
if($participant['score']['CFIT'] >= 140 && $participant['score']['CFIT'] <= 169) $IQ = "Very Superior";
if($participant['score']['CFIT'] >= 120 && $participant['score']['CFIT'] <= 139) $IQ = "Superior";
if($participant['score']['CFIT'] >= 110 && $participant['score']['CFIT'] <= 119) $IQ = "High Average";
if($participant['score']['CFIT'] >= 90 && $participant['score']['CFIT'] <= 109) $IQ = "Average";
if($participant['score']['CFIT'] >= 80 && $participant['score']['CFIT'] <= 89) $IQ = "Low Average";
if($participant['score']['CFIT'] >= 70 && $participant['score']['CFIT'] <= 79) $IQ = "Borderline";

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
        <td class="border-cell"><?=$participant['school']?></td>
    </tr>
    <tr style="border-left:1px;border-right:1px">
        <td colspan="3" style="border-left:1px;border-right:1px">
            <br />
        </td>
    </tr>
    <tr>
        <td width="200px">Tanggal Pemeriksaan</td>
        <td width="10px">:</td>
        <td></td>
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
        <th colspan="2"><h2 align="center">IQ : <?=$IQ?></h2></th>
        <th colspan="5" style="text-align:center;"><h2 align="center">IQ : <?=$participant['score']['CFIT']?></h2><i>CFIT scale</i></th>
    </tr>
    <tr>
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
    <?php 
    $rerata1 = 0;
    $rerata2 = 0;
    $rerata3 = 0;
    $total_nilai = 0;
    $descriptions = [
        'G' => [
            'title' => 'Tingkat Intelektual',
            'description' => 'Tingkat potensi yang dimiliki oleh individu untuk mempelajari sesuatu lewat alat-alat berpikir'
        ],
        'A' => [
            'title' => 'Fleksibilitas Berpikir',
            'description' => 'Kemampuan menggunakan berbagai sudut pandang dalam menghadapi tuntutan perubahan'
        ],
        'N' => [
            'title' => 'Berpikir Analitis',
            'description' => 'Kemampuan menguraikan permasalahan berdasarkan informasi yang relevan dari berbagai sumber secara komprehensif untuk mengiden-tifikasi penyebab dan dampak terhadap organisasi'
        ],
        'F' => [
            'title' => 'Berpikir Abstraksi',
            'description' => 'kemampuan untuk memproses sebuah informasi yang berkaitan dengan objek, prinsip, dan konsep-konsep, yang secara fisik tidak dapat dimunculkan'
        ],
        'Z' => [
            'title' => 'Daya Juang',
            'description' => 'Kemampuan untuk mau bekerja keras dan tidak mudah putus asa dalam berusaha mencapai tujuan dan mampu mempertahankannya'
        ],
        'E' => [
            'title' => 'Semangat Berprestasi',
            'description' => 'Kemampuan untuk selalu meningkatkan kinerja dengan lebih baik di atas standar secara terus-menerus'
        ],
        'S' => [
            'title' => 'Tanggung Jawab',
            'description' => 'Loyalitas, integritas dan komitmen untuk  melaksanakan tugas secara tuntas dan tepat waktu'
        ],
        'O' => [
            'title' => 'Loyalitas',
            'description' => 'Kepatuhan pada aturan dan prosedur, serta rasa memiliki terhadap perusahaan'
        ],
        'L' => [
            'title' => 'Pengambilan Keputusan',
            'description' => 'Kemampuan mengambil keputusan secara cepat dan tepat'
        ],
        'P' => [
            'title' => 'Peran Sebagai Pemimpin',
            'description' => 'Kecenderungan menggunakan orang lain untuk mencapai tujuan'
        ],
        'I' => [
            'title' => 'Pengendalian Orang Lain',
            'description' => 'Kemampuan dalam menyusun perencanaan, mengawasi proses dan hasil-hasilnya, mengarahkan dan memotivasi orang lain, dan pola komunikasi yang efektif'
        ]
    ];
    foreach($participant['score']['Papikostick'] as $key => $vp): 
        // echo $key;
        if(in_array($vp,[8,9]))
            $vp = 5;
        elseif(in_array($vp,[6,7]))
            $vp = 4;
        elseif(in_array($vp,[4,5]))
            $vp = 3;
        elseif(in_array($vp,[2,3]))
            $vp = 2;
        else
            $vp = 1;
        $total_nilai += $vp;
        if(in_array($key,['G','A','N','F'])) $rerata1 += $vp;
        elseif(in_array($key,['Z','E','S','O'])) $rerata2 += $vp;
        else $rerata3 += $vp;

        $vp_value = "";
        for($i=1;$i<=5;$i++)
        {
            $bg = $i==3 ? 'style="background:#eaeaea;text-align:center;"' : 'style="text-align:center;"';
            if($vp == $i)
                $vp_value .= "<td width='10' $bg>$vp</td>";
            else
                $vp_value .= "<td width='10' $bg></td>";
        }
        
    if($key=='G'): ?>
    <tr>
        <td style="background:#eaeaea;" colspan="7"><b>KEMAMPUAN BERPIKIR</b></td>
    </tr>
    <?php elseif($key=='Z'): ?>
    <tr>
        <td style="background:#eaeaea;" colspan="7"><b>KEMAMPUAN BERPIKIR</b></td>
    </tr>
    <?php elseif($key=='L'): ?>
    <tr>
        <td style="background:#eaeaea;" colspan="7"><b>KEPEMIMPINAN</b></td>
    </tr>
    <?php endif ?>
    <tr>
        <td><?=$descriptions[$key]['title']?></td>
        <td width="400"><?=$descriptions[$key]['description']?></td>
        <?=$vp_value?>
    </tr>
    <?php endforeach ?>
    
    
</table>
<br />
<div style="text-align:center;width:100%">
    <i>Keterangan:  1: Sangat Kurang&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2: Kurang&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;3: Cukup&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;4: Baik&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;5: Sangat Baik</i>
</div>
<br />
<b>2. GRAFIK HASIL STUDENT PROFILING</b><br />
<p align="center">Coming Soon</p>
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
    Medan, April 2021<br />
    Penanggung Jawab
</div>
<p></p>
<img src="images/ttd.png" style="width:100%" />
</body>