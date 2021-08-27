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
        <td class="border-cell" width="250">Nama</td>
        <td class="border-cell" width="30">:</td>
        <td class="border-cell" width="250"><?=$worksheet->getCellByColumnAndRow(3, $row)->getValue()?></td>
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
        <td class="border-cell">1.</td>
        <td class="border-cell">TINGKAT POTENSI AKADEMIK</td>
        <td class="border-cell">:</td>
        <td><?=$worksheet->getCellByColumnAndRow(15, $row)->getValue()?></td>
    </tr>
    <tr>
        <td class="border-cell">2.</td>
        <td class="border-cell" colspan="4">HASIL TES PEMINATAN ONLINE</td>
    </tr>
    <tr>
        <td class="border-cell" colspan="2">KELOMPOK SOAL PEMINATAN IPA</td>
        <td class="border-cell">:</td>
        <td class="border-cell" colspan="2"><?=$worksheet->getCellByColumnAndRow(12, $row)->getValue()?></td>
    </tr>
    <tr>
        <td class="border-cell" colspan="2">KELOMPOK SOAL PEMINATAN IPS</td>
        <td class="border-cell">:</td>
        <td class="border-cell" colspan="2"><?=$worksheet->getCellByColumnAndRow(11, $row)->getValue()?></td>
    </tr>
    <tr>
        <td class="border-cell" colspan="2">KELOMPOK SOAL PEMINATAN BAHASA</td>
        <td class="border-cell">:</td>
        <td class="border-cell" colspan="2"><?=$worksheet->getCellByColumnAndRow(10, $row)->getValue()?></td>
    </tr>
    <tr>
        <td class="border-cell">3.</td>
        <td class="border-cell">JURUSAN SMA</td>
        <td class="border-cell">:</td>
        <td class="border-cell" colspan="2"><?=$worksheet->getCellByColumnAndRow(13, $row)->getValue()?></td>
    </tr>
    <tr>
        <td class="border-cell">4.</td>
        <td class="border-cell">BAKAT DAN MINAT</td>
        <td class="border-cell">:</td>
        <td class="border-cell"><?=$worksheet->getCellByColumnAndRow(16, $row)->getValue()?></td>
        <td class="border-cell"><?=$worksheet->getCellByColumnAndRow(17, $row)->getValue()?></td>
    </tr>
    <tr>
        <td class="border-cell">5.</td>
        <td class="border-cell">ALTERNATIF JURUSAN DI PERGURUAN TINGGI</td>
        <td class="border-cell">:</td>
        <td class="border-cell" colspan="2">- TERLAMPIR -</td>
    </tr>
</table>

<div style="width:250px;margin-left:auto;text-align:center;width:100%;display:block;">
    Medan, <?=$worksheet->getCellByColumnAndRow(9, $row)->getValue()?><br />
    Penanggung Jawab Kegiatan,<br />
    Direktur Psikologi<br />
    <br />
    <br />
    <br />
    <br />
    <br />
    <br />
    <br />
    <b>MRA. Puspitasari, M.Psi., Psikolog</b><br />
    SIPP :  0528-18-2-1
</div>
<img src="images/footer.png" style="width:100%">
