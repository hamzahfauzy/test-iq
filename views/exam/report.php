<table id="table-export" border="1" cellspacing="0" cellpadding="5">
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
<script>
var tableToExcel = (function () {
    var uri = 'data:application/vnd.ms-excel;base64,'
    var template = `<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>`
    var base64 = function (s) { return window.btoa(unescape(encodeURIComponent(s))) }
    var format = function (s, c) { return s.replace(/{(\w+)}/g, function (m, p) { return c[p]; }) }
    return function (table, name) {
        if (!table.nodeType) table = document.getElementById(table)
        var ctx = { worksheet: name || 'Worksheet', table: table.innerHTML }
        // console.log(uri + base64(format(template, ctx)))
        // window.location.href = uri + base64(format(template, ctx))
        var link = document.createElement("a");
            link.download = name + ".xls";
            link.href = uri + base64(format(template, ctx));
            link.click();
    }
})()

tableToExcel('table-export', 'export-<?=$name?>')
</script>