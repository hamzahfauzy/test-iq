<img src="images/kop.png" style="width:100%">
<p style="text-align:center;">
<b>LAPORAN HASIL TES POTENSI INDIVIDUAL</b><br />
<i>(INDIVIDUAL POTENTIAL REVIEW)</i>
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
        <td class="border-cell"><?=$worksheet->getCellByColumnAndRow(6, $row)->getValue()?></td>
    </tr>
    <tr>
        <td class="border-cell">Tempat, Tanggal Lahir</td>
        <td class="border-cell">:</td>
        <td class="border-cell"><?=$worksheet->getCellByColumnAndRow(5, $row)->getValue()?></td>
    </tr>
    <tr>
        <td class="border-cell">Asal Sekolah</td>
        <td class="border-cell">:</td>
        <td class="border-cell"><?=$worksheet->getCellByColumnAndRow(7, $row)->getValue()?></td>
    </tr>
    <tr style="border-left:1px;border-right:1px">
        <td colspan="3" style="border-left:1px;border-right:1px">
            <br />
        </td>
    </tr>
    <tr>
        <td width="200px">Tanggal Pemeriksaan</td>
        <td width="10px">:</td>
        <td><?=$worksheet->getCellByColumnAndRow(8, $row)->getValue()?></td>
    </tr>
    <tr>
        <td>Tujuan Pemeriksaan</td>
        <td>:</td>
        <td>Individual Potential Review</td>
    </tr>
    <tr>
        <td>Sifat Dokumen</td>
        <td>:</td>
        <td>RAHASIA</td>
    </tr>
</table>
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<img src="images/footer.png" style="width:100%">
<div style="page-break-before: always"></div>
<br />
<br />
<br />
<br />
<br />
<table id="customers" align="center">
    <tr>
        <th colspan="2"><h2 align="center">POTENSI AKADEMIK</h2></th>
        <th colspan="5" style="text-align:center;"><h2 align="center"><?=$worksheet->getCellByColumnAndRow(14, $row)->getValue()?></h2></th>
    </tr>
    <tr>
        <td style="text-align:center;background:#eaeaea;" rowspan="2">ASPEK</td>
        <td style="text-align:center;background:#eaeaea;" rowspan="2">PENJELASAN</td>
        <td style="text-align:center;background:#eaeaea;" colspan="5">SKALA</td>
    </tr>
    <tr>
        <td>1</td>
        <td>2</td>
        <td>3</td>
        <td>4</td>
        <td>5</td>
    </tr>
    <tr>
        <td>Kemampuan Verbal</td>
        <td width="340">Kemampuan mempersepsi adanya suatu hubungan di antara benda, bentuk atau persoalan</td>
        <?php 
        $_value = $worksheet->getCellByColumnAndRow(15, $row)->getValue();
        for($i=1;$i<=5;$i++): 
            $bg = $i==3 ? 'style="background:#eaeaea;text-align:center;"' : 'style="text-align:center;"';
            $span = $i<=2 ? '<span style="background-color:yellow;">X</span>' : 'X';
        ?>
        <td <?=$bg ?>><?=$_value==$i?$span:''?></td>
        <?php endfor ?>
    </tr>
    <tr>
        <td>Kemampuan Spasial</td>
        <td width="340">Kemampuan untuk terbuka dengan informasi atau instruksi yang berbeda-beda dan menyelesaikan beragam persoalan dengan baik</td>
        <?php 
        $_value = $worksheet->getCellByColumnAndRow(16, $row)->getValue();
        for($i=1;$i<=5;$i++): 
            $bg = $i==3 ? 'style="background:#eaeaea;text-align:center;"' : 'style="text-align:center;"';
            $span = $i<=2 ? '<span style="background-color:yellow;">X</span>' : 'X';
        ?>
        <td <?=$bg ?>><?=$_value==$i?$span:''?></td>
        <?php endfor ?>
    </tr>
    <tr>
        <td>Kemampuan Numerikal</td>
        <td width="300">Kemampuan untuk memecahkan persoalan secara efektif dengan cara-cara yang kreatif di luar kebiasaan</td>
        <?php 
        $_value = $worksheet->getCellByColumnAndRow(17, $row)->getValue();
        for($i=1;$i<=5;$i++): 
            $bg = $i==3 ? 'style="background:#eaeaea;text-align:center;"' : 'style="text-align:center;"';
            $span = $i<=2 ? '<span style="background-color:yellow;">X</span>' : 'X';
        ?>
        <td <?=$bg ?>><?=$_value==$i?$span:''?></td>
        <?php endfor ?>
    </tr>
    <?php
    $data = [
        'KEPRIBADIAN' => [
            18 => [
                'Kepercayaan Diri',
                'Keyakinan yang kuat akan kemampuan diri'
            ],
            19 => [
                'Penyesuaian Diri',
                'Kemampuan menyesuaikan diri serta mampu mengambil sikap yang tepat sesuai tuntutan lingkungan saat itu'
            ],
            20 => [
                'Hasrat Berprestasi',
                'Kemampuan untuk mendorong diri sendiri untuk mencapai hasil yang terbaik'
            ],
            21 => [
                'Stabilitas Emosi',
                'Kemampuan untuk mengendalikan diri, tetap bersikap tenang dan tidak terpengaruh dengan  situasi di sekelilingnya'
            ],
            22 => [
                'Kontak Sosial',
                'Kesediaan untuk memulai interaksi dan membina hubungan baik dengan orang lain'
            ],
            23 => [
                'Sistematika Belajar',
                'Kemampuan menyusun perencanaan dan mempertahankan keteraturan dalam menyelesaikan tugas'
            ],
            24 => [
                'Daya Juang',
                'Kemauan untuk menyelesaikan tugas hingga tuntas dan kemampuan dalam mempertahankan semangat meskipun menghadapi tugas-tugas yang sulit'
            ],
            25 => [
                'Daya Tahan Terhadap Stress',
                'Kemampuan untuk mengatasi semua hambatan dan tekanan dalam mengerjakan tugas'
            ]
        ]
    ];
    $no = 1;
    foreach($data as $key => $value) { ?>
    <tr>
        <td style="background:#eaeaea;" colspan="7" style="text-align:center"><b><?=$key?></b></td>
    </tr>
    <?php foreach($value as $k => $v){ ?>
    <tr>
        <td><?=$v[0]?></td>
        <td width="340"><?=$v[1]?></td>
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
    <i>Keterangan:  1: Kurang Sekali&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2: Kurang&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;3: Rata Rata&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;4: Baik&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;5: Baik Sekali</i>
</div>
<br />
<br />
<br />
<br />
<br />
<?php
$d = [
    'INVESTIGATIVE' => [
        'jenis_minat' => 'INVESTIGATIVE/PENELITIAN',
        'penjelasan' => [
            'Pekerjaan yang menuntut prestasi akademik yang tinggi',
            'Menggunakan kemampuan teknis untuk menyelesaikan tugas',
            'Melibatkan kegiatan penelitian ilmiah'
        ],
        'IPA' => [
            'Kedokteran/Biologi Genetika/Farmasi',
            'Teknik Lingkungan/ Teknik Kimia',
            'Astronomi dan Geofisika',
            'Pemrograman Komputer'
        ],
        'IPS' => [
            'Sosiologi',
            'Ilmu Politik',
            'Ilmu Budaya'
        ]
    ],
    'ARTISTIC' => [
        'jenis_minat' => 'ARTISTIC/SENI/DESAIN',
        'penjelasan' => [
            'Pekerjaan yang tidak terstruktur',
            'Terbuka pada keberagaman',
            'Menghargai orisinalitas',
            'Memerlukan kreativitas'
        ],
        'IPA' => [
            'Arsitektur/Landscape',
            'Desain Interior',
            'Desain 3D',
            'Desain Grafis'
        ],
        'IPS' => [
            'Sastra',
            'Seni Lukis/Musik/Suara',
            'Desain Grafis'
        ]
    ],
    'SOCIAL' => [
        'jenis_minat' => 'SOCIAL/KEMANUSIAAN',
        'penjelasan' => [
            'Bekerjasama dengan orang lain',
            'Berinteraksi dengan orang lain',
            'Melayani orang lain',
            'Menghargai perkembangan pribadi orang lain'
        ],
        'IPA' => [
            'Psikologi',
            'Kesehatan Masyarakat',
            'Bimbingan Konseling',
            'Manajemen SDM',
            'Kesejahteraan/Pekerjaan Sosial',
        ],
        'IPS' => [
            'Psikologi',
            'Bimbingan Konseling',
            'Manajemen SDM',
            'Kesejahteraan/Pekerjaan Sosial',
        ]
    ],
    'REALISTIC' => [
        'jenis_minat' => 'REALISTIC/KEKUATAN TUBUH DAN PERALATAN',
        'penjelasan' => [
            'Bekerja pada kegiatan outdoor / lapangan',
            'Memerlukan keterampilan teknis',
            'Tugas tugas bersifat langsung'
        ],
        'IPA' => [
            'Teknik Sipil/Geodesi/Perminyakan/Elektro',
            'Akademi Penerbangan',
            'Akademi Kepolisian/Akademi Militer',
            'Pertanian/Perkebunan',
        ],
        'IPS' => [
            'Akademi Kepolisian/Akademi Militer',
            'Manajemen Pertanian/Perkebunan',
            'Pendidikan Olahraga',
        ]
    ],
    'ENTREPRENUER' => [
        'jenis_minat' => 'ENTREPRENUER/USAHA/KERJA MANDIRI',
        'penjelasan' => [
            'Menghargai pencapaian dan tujuan ekonomi',
            'Penuh target yang menantang',
            'Mengelola unit kerja untuk merealisasikan capaian bisnis',
            'Memimpin dengan strategi untuk memenangkan kompetisi',
        ],
        'IPA' => [
            'Kewirausahaan/ Manajemen Pemasaran',
            'Kedokteran',
            'Akuntansi/Perpajakan',
            'Teknik Sipil/Arsitektur/Elektro',
        ],
        'IPS' => [
            'Kewirausahaan/Bisnis',
            'Manajemen Pemasaran',
            'Manajemen Perkantoran ',
        ]
    ],
    'CONVENTIONAL' => [
        'jenis_minat' => 'CONVENTIONAL/PEMELIHARA',
        'penjelasan' => [
            'Memerlukan perhatian terhadap detail',
            'Berhubungan dengan data',
            'Menghargai keseragaman dan keteraturan',
        ],
        'IPA' => [
            'Akuntansi',
            'Manajemen Administrasi',
            'Perbankan',
        ],
        'IPS' => [
            'Akuntansi',
            'Manajemen Administrasi',
            'Perbankan',
        ]
    ],
]
?>
<table id="customers" align="center">
    <tr>
        <th colspan="3"><h2 align="center">BAKAT MINAT DAN PILIHAN JURUSAN</h2></th>
    </tr>
    <tr>
        <td width="150"><b>BAKAT DAN MINAT</b></td>
        <td width="180" style="vertical-align:top;padding-right:20px">
            <b>UTAMA :</b><br>
            <b><?=$d[$worksheet->getCellByColumnAndRow(26, $row)->getValue()]['jenis_minat']?></b><br>
            <ul>
                <li>
                    <?=implode('</li><li>',$d[$worksheet->getCellByColumnAndRow(26, $row)->getValue()]['penjelasan'])?><br>
                </li>
            </ul>
        </td>
        <td width="180" style="vertical-align:top;padding-right:20px">
            <b>PENDUKUNG :</b><br>
            <b><?=$d[$worksheet->getCellByColumnAndRow(27, $row)->getValue()]['jenis_minat']?></b><br>
            <ul>
                <li>
                <?=implode('</li><li>',$d[$worksheet->getCellByColumnAndRow(27, $row)->getValue()]['penjelasan'])?><br>
                </li>
            </ul>
        </td>
    </tr>
    <tr>
        <td width="150"><b>JURUSAN DI SMA</b></td>
        <td colspan="2" width="400"><?=$worksheet->getCellByColumnAndRow(12, $row)->getValue()?></td>
    </tr>
    <tr>
        <td width="150"><b>ALTERNATIF JURUSAN DI PERGURUAN TINGGI</b></td>
        <td colspan="2" width="400">
        <ul>
            <li>
            <?=implode('</li><li>',$d[$worksheet->getCellByColumnAndRow(26, $row)->getValue()][$worksheet->getCellByColumnAndRow(12, $row)->getValue()])?><br>
            </li>
        </ul>
        </td>
    </tr>
</table>
<br /><br /><br />
<div style="text-align:center;width:100%">
    Medan, <?=$worksheet->getCellByColumnAndRow(8, $row)->getValue()?><br />
    <img src="images/ttd-3.png" style="width:320px" />
</div>