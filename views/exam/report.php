<table border="1" cellspacing="0" cellpadding="5">
    <tr>
        <td class="nowrap heading" rowspan="2">#</td>
        <td class="nowrap heading" rowspan="2">Nama Peserta</td>
        <td class="nowrap heading" rowspan="2">Asal Sekolah</td>
        <td class="nowrap heading" rowspan="2">Bidang Studi</td>
        <td class="nowrap heading" rowspan="2">Usia</td>
        <td class="nowrap heading" rowspan="2">Lama Bekerja</td>
        <td class="nowrap heading" rowspan="2">Kategori IQ</td>
        <td class="nowrap heading" rowspan="2">IQ</td>
        <td class="nowrap heading" colspan="4">Kemampuan Intelektual</td>
        <td class="nowrap heading" colspan="4">Motivasi Kerja</td>
        <td class="heading" rowspan="2">RERATA</td>
        <td class="nowrap heading" colspan="4">Sosiabilitas dan Pengendalian Diri</td>
        <td class="heading" rowspan="2">RERATA</td>
        <td class="heading" colspan="3">Kepemimpinan</td>
        <td class="heading" rowspan="2">RERATA</td>
        <td class="heading" rowspan="2">Total Nilai</td>
        <td class="heading" rowspan="2">Job Person Match (%)</td>
        <td class="nowrap heading" rowspan="2">Keterangan</td>
    </tr>
    <tr>
        <td class="heading">Tingkat Intelektual</td>
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
        <td class="heading">Peran Sebagai Pemimpin (L)</td>
        <td class="heading">Pengendalian Orang Lain (P)</td>
        <td class="heading">Pengambilan Keputusan (I)</td>
    </tr>
    <?php 
    foreach($report as $key => $value): 
        $total_nilai = $value['score']['CFIT'];
        // $total_nilai += $value['score']['MSDT']['msdt_final_value'];

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

        $min = 999999;
        $max = 0;

        foreach($value['score']['partial_cfit'] as $cfit)
        {
            $min = $cfit < $min ? $cfit : $min;
            $max = $cfit > $max ? $cfit : $max;
        }
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
        <td class="nowrap">
            <?php
            $skor=$value['score']['CFIT'];
            $s = 0;
            if($skor>=130)
            {
                echo 5;
                $s+=5;
            }
            elseif($skor >= 111 && $skor <= 129)
            {
                echo 4;
                $s+=4;
            }
            elseif($skor >= 90 && $skor <= 110)
            {
                echo 3;
                $s+=3;
            }
            elseif($skor >= 70 && $skor <= 89)
            {
                echo 2;
                $s+=2;
            }
            else
            {
                echo 1;
                $s+=1;
            }
            ?>
        </td>
        <td class="nowrap">
            <?php
            $skor=$max-$min;
            if($skor==0)
            {
                echo 5;
                $s+=5;
            }
            elseif($skor >= 1 && $skor <= 3)
            {
                echo 4;
                $s+=4;
            }
            elseif($skor >= 4 && $skor <= 6)
            {
                echo 3;
                $s+=3;
            }
            elseif($skor >= 7 && $skor <= 9)
            {
                echo 2;
                $s+=2;
            }
            else
            {
                echo 1;
                $s+=1;
            }
            ?>
        </td>
        <td class="nowrap">
            <?php
            $skor=$total;
            if($skor>=41)
            {
                echo 5;
                $s+=5;
            }
            elseif($skor >= 31 && $skor <= 40)
            {
                echo 4;
                $s+=4;
            }
            elseif($skor >= 21 && $skor <= 30)
            {
                echo 3;
                $s+=3;
            }
            elseif($skor >= 11 && $skor <= 20)
            {
                echo 2;
                $s+=2;
            }
            else
            {
                echo 1;
                $s+=1;
            }
            ?>
        </td>
        <td class="nowrap">
            <?php
            $skor=$value['score']['partial_cfit']['CFIT 4'];
            if($skor>=9)
            {
                echo 5;
                $s+=5;
            }
            elseif($skor >= 7 && $skor <= 8)
            {
                echo 4;
                $s+=4;
            }
            elseif($skor >= 5 && $skor <= 6)
            {
                echo 3;
                $s+=3;
            }
            elseif($skor >= 3 && $skor <= 4)
            {
                echo 2;
                $s+=2;
            }
            else
            {
                echo 1;
                $s+=1;
            }
            ?>
        </td>
        <?php 
        $total_nilai += $s;
        $rerata1 = 0;
        $rerata2 = 0;
        $rerata3 = 0;
        foreach($value['score']['Papikostick'] as $key => $vp): 
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
            
        ?>
        <td><?=$vp?></td>
        <?php if($key == 'F'): ?>
        <td><?=number_format($rerata1/4,2)?></td>
        <?php elseif($key == 'O'): ?>
        <td><?=number_format($rerata2/4,2)?></td>
        <?php elseif($key=='I'): ?>
        <td><?=number_format($rerata3/3,2)?></td>
        <?php endif ?>
        <?php 
        endforeach;
        $jpm = number_format($total_nilai/45*100,2);
        $keterangan = "Sangat Tidak Memenuhi Syarat";
        if($jpm >= 100) $keterangan = "Sangat Memenuhi Syarat";
        if($jpm >= 86 && $jpm <= 99) $keterangan = "Memenuhi Syarat";
        if($jpm >= 71 && $jpm <= 85) $keterangan = "Cukup Memenuhi Syarat";
        if($jpm >= 56 && $jpm <= 70) $keterangan = "Tidak Memenuhi Syarat";
        ?>
        <td><?=$total_nilai?></td>
        <td><?=$jpm?>%</td>
        <td class="nowrap"><?=$keterangan?></td>
    </tr>
    <?php endforeach ?>
</table>