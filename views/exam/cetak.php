<img src="images/kop.png" style="width:100%">
<p style="text-align:center;">
<b>LAPORAN HASIL ASSESMEN GURU</b><br />
<i>TEACHER ASSESMENT REPORT</i>
</p>

<table id="customers" align="center">
    <tr>
        <td class="border-cell" width="250">Nama</td>
        <td class="border-cell" width="30">:</td>
        <td class="border-cell" width="250"><?=$worksheet->getCellByColumnAndRow(3, $row)->getValue()?></td>
    </tr>
    <tr>
        <td class="border-cell">Jenis Kelamin</td>
        <td class="border-cell">:</td>
        <td class="border-cell"><?=$worksheet->getCellByColumnAndRow(5, $row)->getValue()?></td>
    </tr>
    <tr>
        <td class="border-cell">Tempat, Tanggal Lahir</td>
        <td class="border-cell">:</td>
        <td class="border-cell"><?=$worksheet->getCellByColumnAndRow(4, $row)->getValue()?></td>
    </tr>
    <tr>
        <td class="border-cell">Pendidikan Terakhir / Bidang Studi</td>
        <td class="border-cell">:</td>
        <td class="border-cell" style="text-transform:capitalize;"><?=$worksheet->getCellByColumnAndRow(6, $row)->getValue()?></td>
    </tr>
    <tr>
        <td class="border-cell">Asal Sekolah</td>
        <td class="border-cell">:</td>
        <td class="border-cell"><?=$worksheet->getCellByColumnAndRow(9, $row)->getValue()?></td>
    </tr>
    <tr style="border-left:1px;border-right:1px">
        <td colspan="3" style="border-left:1px;border-right:1px">
            <br />
        </td>
    </tr>
    <tr>
        <td width="200px">Tanggal Pemeriksaan</td>
        <td width="10px">:</td>
        <td><?=$worksheet->getCellByColumnAndRow(7, $row)->getValue()?></td>
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
<b>1. TABEL HASIL PROFIL GURU</b><br />
<p></p>
<table id="customers" align="center">
    <tr>
        <th colspan="3"><h2 align="center">IQ : <?=$worksheet->getCellByColumnAndRow(12, $row)->getValue()?></h2></th>
        <th colspan="5" style="text-align:center;"><h2 align="center">IQ : <?=$worksheet->getCellByColumnAndRow(13, $row)->getValue()?></h2><i>CFIT scale</i></th>
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
    <?php
    $data = [
        'Kemampuan Intelektual' => [
            14 => [
                'Tingkat Intelektual',
                'Tingkat potensi yang dimiliki oleh individu untuk mempelajari sesuatu lewat alat-alat berpikir'
            ],
            15 => [
                'Berfikir Fleksibilitas',
                'Kemampuan menggunakan berbagai sudut pandang dalam menghadapi tuntutan perubahan'
            ],
            16 => [
                'Berfikir Analitis',
                'Kemampuan menguraikan permasalahan berdasarkan informasi yang relevan dari berbagai sumber secara komprehensif untuk mengiden-tifikasi penyebab dan dampak terhadap organisasi'
            ],
            17 => [
                'Berfikir Abstraksi',
                'Kemampuan untuk memproses sebuah informasi yang berkaitan dengan objek, prinsip, dan konsep-konsep, yang secara fisik tidak dapat dimunculkan'
            ]
        ],
        'Tanggung Jawab dan Loyalitas' => [
            18 => [
                'Tanggung Jawab',
                'Loyalitas, integritas dan komitmen untuk melaksanakan tugas secara tuntas dan tepat waktu'
            ],
            19 => [
                'Loyalitas',
                'Kepatuhan pada aturan dan prosedur, serta rasa memiliki terhadap organisasi'
            ]
        ],
        'Kehandalan Dalam Bekerja' => [
            20 => [
                'Daya Juang',
                'Kemampuan untuk mau bekerja keras dan tidak mudah putus asa dalam berusaha mencapai tujuan dan mampu mempertahankannya'
            ],
            21 => [
                'Semangat Berprestasi',
                'Kemampuan untuk selalu meningkatkan kinerja dengan lebih baik di atas standar secara terus-menerus'
            ],
            22 => [
                'Kepercayaan Diri',
                'Keyakinan yang kuat akan kemampuan dalam melaksanakan pekerjaan, berhubungan dan berkompetisi dengan orang lain'
            ],
        ],
        'Rasa Memiliki Terhadap Organisasi' => [
            23 => [
                'Penyesuaian Diri',
                'Kemampuan untuk merespon perubahan, kemauan belajar dengan mendengarkan dan memahami pikiran, perasaan orang lain'
            ],
            24 => [
                'Pengendalian Diri',
                'Kemampuan untuk mengendalikan diri pada saat menghadapi masalah yang sulit, kritik dari orang lain atau pada saat bekerja di bawah tekanan dengan sikap yang positif'
            ],
            25 => [
                'Kerja Sama Dalam Tim',
                'Tingkat relasi dan kemampuan menyelesaikan pekerjaan secara bersama-sama dengan menjadi bagian dari suatu kelompok untuk mencapai tujuan unit / organisasi'
            ]
        ],
        'Kepemimpinan' => [
            26 => [
                'Pengambilan Keputusan',
                'Tingkat relasi dan kemampuan menyelesaikan pekerjaan secara bersama-sama dengan menjadi bagian dari suatu kelompok untuk mencapai tujuan unit / organisasi',
            ],
            27 => [
                'Peran Sebagai Pemimpin',
                'Kecenderungan menggunakan orang lain untuk mencapai tujuan'
            ],
            28 => [
                'Pengendalian Orang Lain',
                'Kemampuan dalam menyusun perencanaan, mengawasi proses dan hasil-hasilnya, mengarahkan dan memotivasi orang lain, dan pola komunikasi yang efektif'
            ]
        ]
    ];
    $no = 1;
    foreach($data as $key => $value) { ?>
    <tr>
        <td style="background:#eaeaea;" colspan="8"><b><?=$key?></b></td>
    </tr>
    <?php foreach($value as $k => $v){ ?>
    <tr>
        <td><?=$no++?></td>
        <td><?=$v[0]?></td>
        <td width="380"><?=$v[1]?></td>
        <?php 
        $_value = $worksheet->getCellByColumnAndRow($k, $row)->getValue();
        for($i=1;$i<=5;$i++): 
            $bg = $i==3 ? 'style="background:#eaeaea;text-align:center;"' : 'style="text-align:center;"';
            $span = $i<=2 ? '<span style="background-color:yellow;">X</span>' : 'X';
        ?>
        <td <?=$bg ?>><?=$_value==$i?$span:''?></td>
        <?php endfor ?>
    </tr>
    <?php } } ?>
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
            <?php foreach($data as $key => $value) { ?>
                <?php foreach($value as $k => $v){ $g = $worksheet->getCellByColumnAndRow($k, $row)->getValue(); ?>
            <td style="width:15px;vertical-align:bottom;"><div class="box" style="height:<?=$g*25?>px"></div></td>
            <?php } } ?>
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
            <h2 style="align:center"><?=$worksheet->getCellByColumnAndRow(30, $row)->getFormattedValue()?>%</h2>
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
    Medan, <?=$worksheet->getCellByColumnAndRow(8, $row)->getValue()?><br />
    Penanggung Jawab
</div>
<p></p>
<img src="images/ttd.png" style="width:100%" />
<div style="page-break-after: always"></div>