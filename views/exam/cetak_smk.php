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
    <tr>
        <td class="border-cell">Jurusan</td>
        <td class="border-cell">:</td>
        <td class="border-cell"><?=$worksheet->getCellByColumnAndRow(8, $row)->getValue()?></td>
    </tr>
    <tr style="border-left:1px;border-right:1px">
        <td colspan="3" style="border-left:1px;border-right:1px">
            <br />
        </td>
    </tr>
    <tr>
        <td width="200px">Tanggal Pemeriksaan</td>
        <td width="10px">:</td>
        <td><?=$worksheet->getCellByColumnAndRow(9, $row)->getValue()?></td>
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
<img src="images/footer.png" style="width:100%">
<div style="page-break-before: always"></div>
<table id="customers" align="center">
    <tr>
        <th colspan="2"><h4 align="center" style="margin:0px;">POTENSI AKADEMIK</h4></th>
        <th colspan="5" style="text-align:center;"><h4 align="center" style="margin:0px;"><?=$worksheet->getCellByColumnAndRow(14, $row)->getValue()?></h4></th>
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
        $_value = $worksheet->getCellByColumnAndRow(34, $row)->getValue();
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
        $_value = $worksheet->getCellByColumnAndRow(35, $row)->getValue();
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
        $_value = $worksheet->getCellByColumnAndRow(36, $row)->getValue();
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
            37 => [
                'Kepercayaan Diri',
                'Keyakinan yang kuat akan kemampuan diri'
            ],
            38 => [
                'Penyesuaian Diri',
                'Kemampuan menyesuaikan diri serta mampu mengambil sikap yang tepat sesuai tuntutan lingkungan saat itu'
            ],
            39 => [
                'Hasrat Berprestasi',
                'Kemampuan untuk mendorong diri sendiri untuk mencapai hasil yang terbaik'
            ],
            40 => [
                'Stabilitas Emosi',
                'Kemampuan untuk mengendalikan diri, tetap bersikap tenang dan tidak terpengaruh dengan  situasi di sekelilingnya'
            ],
            41 => [
                'Kontak Sosial',
                'Kesediaan untuk memulai interaksi dan membina hubungan baik dengan orang lain'
            ],
            42 => [
                'Sistematika Belajar',
                'Kemampuan menyusun perencanaan dan mempertahankan keteraturan dalam menyelesaikan tugas'
            ],
            43 => [
                'Daya Juang',
                'Kemauan untuk menyelesaikan tugas hingga tuntas dan kemampuan dalam mempertahankan semangat meskipun menghadapi tugas-tugas yang sulit'
            ],
            44 => [
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
<br>
<table id="customers" align="center">
    <tr>
        <th colspan="3"><h4 align="center" style="margin:0px;">KECOCOKAN POTENSI ANAK DENGAN JURUSAN YANG DIPILIH</h4></th>
    </tr>
    <tr>
        <td width="200">DUKUNGAN POTENSI AKADEMIK</td>
        <td width="200"><?=$worksheet->getCellByColumnAndRow(11, $row)->getValue()?></td>
        <td width="200"><?=$worksheet->getCellByColumnAndRow(12, $row)->getValue()?></td>
    </tr>
    <tr>
        <td>DUKUNGAN BAKAT</td>
        <td><?=$worksheet->getCellByColumnAndRow(14, $row)->getValue()?></td>
        <td><?=$worksheet->getCellByColumnAndRow(15, $row)->getValue()?></td>
    </tr>
    <tr>
        <td>DUKUNGAN MINAT</td>
        <td><?=$worksheet->getCellByColumnAndRow(24, $row)->getValue()?></td>
        <td><?=$worksheet->getCellByColumnAndRow(25, $row)->getValue()?></td>
    </tr>
    <tr>
        <td><b>KECOCOKAN DENGAN JURUSAN</b></td>
        <td><?=$worksheet->getCellByColumnAndRow(31, $row)->getValue()?></td>
        <td><?=$worksheet->getCellByColumnAndRow(32, $row)->getValue()?></td>
    </tr>
</table>
<br>
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
        ],
        'BAHASA' => [
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
        ],
        'BAHASA' => [
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
        ],
        'BAHASA' => [
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
        ],
        'BAHASA' => [
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
        ],
        'BAHASA' => [
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
        ],
        'BAHASA' => [
            'Akuntansi',
            'Manajemen Administrasi',
            'Perbankan',
        ]
    ],
];

$bakat_dan_minat_1 = $worksheet->getCellByColumnAndRow(18, $row)->getValue();
$bakat_dan_minat_1 = strtoupper($bakat_dan_minat_1);

// $bakat_dan_minat_2 = $worksheet->getCellByColumnAndRow(28, $row)->getValue();
// $bakat_dan_minat_2 = strtoupper($bakat_dan_minat_2);
?>
<table id="customers" align="center">
    <tr>
        <th colspan="3"><h4 align="center" style="margin:0px;">MINAT DAN JURUSAN YANG SESUAI</h4></th>
    </tr>
    <tr>
        <td width="200">Minat</td>
        <td colspan="2" width="425">
            <b><?=$d[$bakat_dan_minat_1]['jenis_minat']?></b><br>
            <ul>
                <li>
                    <?=implode('</li><li>',$d[$bakat_dan_minat_1]['penjelasan'])?><br>
                </li>
            </ul>
        </td>
    </tr>
    <tr>
        <td>Alternatif Jurusan di Perguruan Tinggi</td>
        <td></td>
        <td></td>
    </tr>
</table>
<br>
<?php
$dev = [
    37 => [
        'Kemampuan Verbal',
        'Agar kemampuan berbahasanya dapat semakin meningkat, ananda perlu lebih banyak  membaca buku dan mengikuti acara talkshow, diskusi dan debat di televisi/radio/media on line, dan langsung mempraktekkannya dalam bahasa lisan dan tulisan, dan aktifitas sehari-hari.'
    ],
    38 => [
        'Kemampuan Spasial',
        'Agar kemampuan spasial Ananda dapat semakin meningkat, Ananda perlu belajar secara sungguh-sungguh dan tekun dengan memecahkan soal-soal matematika ruang (geometri).  '
    ],
    39 => [
        'Kemampuan Numerikal',
        'Agar kemampuan numerical Ananda dapat semakin meningkat, Ananda perlu belajar secara sungguh-sungguh dan tekun dengan memecahkan soal-soal aritmatika secara cepat dan teliti.   '
    ],
    40 => [
        'Kepercayaan Diri',
        'Untuk meningkatkan kepercayaan dirinya, Ananda perlu melibatkan diri dalam banyak kegiatan-kegiatan kompetisi, banyak berlatih dengan mengikuti try out sebelum menghadapi ujian, dan  sering terlibat dalam berbagai kegiatan komunitas, terutama yang mampu menunjang masa depan, sesuai bakat dan minat.'
    ],
    41 => [
        'Penyesuaian Diri',
        'Untuk meningkatkan kemampuan untuk cepat berubah sesuai tuntutan lingkungan, Ananda perlu berlatih untuk lebih banyak mendengar, menghayati harapan dan kebutuhan orang lain. Melibatkan diri dalam banyak komunitas sesuai bakat minat dan mengambil peran di dalamnya, akan banyak mendorong dan mengasah kemampuan Ananda dalam memahami berbagai karakter orang dan mengetahui kiat-kiat memenuhi dan menyenangkan orang lain.'
    ],
    42 => [
        'Hasrat Berprestasi',
        'Untuk meningkatkan hasrat berprestasi, ananda perlu menyusun target-target pribadi yang SMART (spesific, measurable, attainable, realistic, timebound). Apa yang ingin dicapai dalam tahun ini, tahun mendatang, bahkan lima tahun lagi, sudah harus dirumuskan saat ini. target tersebut kemudian duraikan menjadi rencana pelaksanaan dan rencana detail kegiatan. Dengan adanya target yang demikian, ananda akan lebih fokus, dan termotivasi secara internal untuk bergerak maju kedepan.'
    ],
    43 => [
        'Stabilitas Emosi',
        'Agar rasa cemas yang  terkadang  muncul apabila Ananda berada dalam situasi yang menekan dapat diminimalisir, Ananda harus senantiasa mempersiapkan diri dengan baik dan dalam waktu yang cukup sehingga tidak tergesa-gesa,  banyak berlatih dengan mengikuti try out sebelum menghadapi ujian, dan  sering terlibat dalam berbagai kegiatan perlombaan,  terutama yang mampu menunjang masa depan  sesuai bakat dan minat. Di samping itu, Ananda perlu berlatih untuk menjadikan target dalam belajar sebagai motivasi, bukan sebagai beban.'
    ],
    44 => [
        'Kontak Sosial',
        'Untuk meningkatkan kemampuan berinteraksi dengan orang lain, Ananda perlu berlatih untuk melibatkan diri dalam banyak kegiatan/komunitas sesuai bakat minat dan mengambil peran di dalamnya, akan banyak mendorong dan mengasah kemampuan Ananda dalam memahami berbagai karakter orang dan mengetahui kiat-kiat memenuhi dan menyenangkan orang lain. '
    ],
    45 => [
        'Sistematika Belajar',
        'Untuk meningkatkan sistematika belajar,  Ananda perlu berlatih menjadi pribadi yang terorganisir (well organized), memiliki perencanaan yang lebih baik (well planned),  menggunakan waktu secara lebih efektif, sesuai perencanaan. Di samping itu, Ananda  perlu menyusun target-target pribadi yang jelas dan terukur.'
    ],
    46 => [
        'Daya Juang',
        'Untuk menumbuh-kembangkan daya juangnya, Ananda  perlu menyusun target-target pribadi yang jelas dan terukur, Belajar lebih disiplin, lebih lama, lebih keras dan lebih cerdas. Ananda harus berlatih untuk tidak mudah menyerah. Ananda harus melatih diri untuk bekerja keras mencapai target yang ditetapkan, seperti mencari jawaban yang benar terhadap soal-soal yang sulit sampai dapat, tidak mudah berganti-ganti tempat les dsb.  '
    ],
    47 => [
        'Daya Tahan Terhadap Stress',
        'Untuk meningkatkan daya tahan terhadap stress, Ananda harus sering melatih pengelolaan terhadap stress dengan cara membiasakan diri fokus pada pencapaian hasil, menemukan metode penyelesaian tugas yang nyaman, tidak cepat bosan dengan rutinitas pekerjaan, dan mengembangkan kemampuan mendedikasikan waktu dalam menyelesaikan tugas'
    ]
];
?>
<table id="customers" align="center">
    <tr>
        <th colspan="2"><h4 align="center" style="margin:0px;">ASPEK YANG PERLU DIKEMBANGKAN</h4></th>
    </tr>
    <tr>
        <th width="200">ASPEK</th>
        <th width="425">SARAN PENGEMBANGAN</th>
    </tr>
    <?php 
    for($i=37;$i<=47;$i++):
        $_value = $worksheet->getCellByColumnAndRow($i, $row)->getValue();
        if($_value >= 3) continue;
    ?>
    <tr>
        <td width="200"><?=$dev[$i][0]?></td>
        <td width="425"><?=$dev[$i][1]?></td>
    </tr>
    <?php endfor ?>
</table>
<br />
<div style="text-align:center;width:100%;display:block;">
    Medan, <?=$worksheet->getCellByColumnAndRow(9, $row)->getValue()?><br />
    <img src="images/ttd-3.png" style="width:320px" />
</div>
<div style="page-break-before: always"></div>