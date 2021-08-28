<img src="images/kop.png" style="width:100%">
<p style="text-align:center;">
<b>LAPORAN HASIL TES POTENSI INDIVIDUAL</b><br />
<i>(INDIVIDUAL POTENTIAL REVIEW)</i>
</p>

<table id="customers" align="center">
    <tr>
        <td rowspan="5" class="border-cell" style="text-align:center;font-weight:bold;">
            LAPORAN HASIL TES<br />POTENSI AKADEMIK DAN <br />MINAT BAKAT
        </td>
        <td class="border-cell" width="200">Nama</td>
        <td class="border-cell" width="30">:</td>
        <td class="border-cell" width="200"><?=$worksheet->getCellByColumnAndRow(3, $row)->getValue()?></td>
    </tr>
    <tr>
        <td class="border-cell">NISN</td>
        <td class="border-cell">:</td>
        <td class="border-cell"><?=$worksheet->getCellByColumnAndRow(4, $row)->getValue()?></td>
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
        <td width="200px">Tanggal Pemeriksaan</td>
        <td width="10px">:</td>
        <td><?=$worksheet->getCellByColumnAndRow(8, $row)->getValue()?></td>
    </tr>
</table>

<br /><br />

<table id="customers" align="center">
    <tr>
        <td class="border-cell w-bold">1.</td>
        <td class="border-cell w-bold" width="250">TINGKAT POTENSI AKADEMIK</td>
        <td class="center w-bold border-cell" width="50">:</td>
        <td class="border-cell w-bold center" width="250" colspan="2"><?=$worksheet->getCellByColumnAndRow(15, $row)->getValue()?></td>
    </tr>
    <tr>
        <td class="border-cell w-bold">2.</td>
        <td class="border-cell w-bold" colspan="4">HASIL TES PEMINATAN ONLINE</td>
    </tr>
    <tr>
        <td class="border-cell" colspan="2">KELOMPOK SOAL PEMINATAN IPA</td>
        <td class="center border-cell w-bold">:</td>
        <td class="border-cell w-bold center" colspan="2"><?=$worksheet->getCellByColumnAndRow(12, $row)->getValue()?></td>
    </tr>
    <tr>
        <td class="border-cell" colspan="2">KELOMPOK SOAL PEMINATAN IPS</td>
        <td class="center border-cell w-bold">:</td>
        <td class="border-cell w-bold center" colspan="2"><?=$worksheet->getCellByColumnAndRow(11, $row)->getValue()?></td>
    </tr>
    <tr>
        <td class="border-cell" colspan="2">KELOMPOK SOAL PEMINATAN BAHASA</td>
        <td class="center border-cell w-bold">:</td>
        <td class="border-cell w-bold center" colspan="2"><?=$worksheet->getCellByColumnAndRow(10, $row)->getValue()?></td>
    </tr>
    <tr>
        <td class="border-cell w-bold">3.</td>
        <td class="border-cell w-bold">JURUSAN SMA</td>
        <td class="center border-cell w-bold">:</td>
        <td class="border-cell w-bold center" colspan="2"><?=$worksheet->getCellByColumnAndRow(13, $row)->getValue()?></td>
    </tr>
    <tr>
        <td class="border-cell w-bold"> 4. </td>
        <td class="border-cell w-bold">BAKAT DAN MINAT</td>
        <td class="center border-cell w-bold">:</td>
        <td class="border-cell w-bold center"><?=$worksheet->getCellByColumnAndRow(16, $row)->getValue()?></td>
        <td class="border-cell w-bold center"><?=$worksheet->getCellByColumnAndRow(17, $row)->getValue()?></td>
    </tr>
    <tr>
        <td class="border-cell w-bold">5.</td>
        <td class="border-cell w-bold">ALTERNATIF JURUSAN DI PERGURUAN TINGGI</td>
        <td class="center border-cell w-bold">:</td>
        <td class="border-cell w-bold center" colspan="2">- TERLAMPIR -</td>
    </tr>
</table>
<br />
<br />
<div style="width:250px;margin-left:auto;text-align:center;width:100%;display:block;">
    Medan, <?=$worksheet->getCellByColumnAndRow(9, $row)->getValue()?><br />
    <img src="images/ttd-4.jpg" style="width:250px">
</div>
<img src="images/footer.png" style="width:100%">
<img src="images/lampiran.jpg" style="width:100%">
