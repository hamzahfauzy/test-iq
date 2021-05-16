<table border="1" cellspacing="0" cellpadding="5">
    <tr>
        <td class="nowrap heading" rowspan="2">#</td>
        <td class="nowrap heading" rowspan="2">Nama Peserta</td>
        <td class="nowrap heading" rowspan="2">Asal Sekolah</td>
        <td class="nowrap heading" rowspan="2">Bidang Studi</td>
        <td class="nowrap heading" colspan="5">Hasil Tes</td>
        <td class="nowrap heading" colspan="2">IQ</td>
        <td class="nowrap heading" colspan="4">Nilai</td>
    </tr>
    <tr>
        <td class="heading">1</td>
        <td class="heading">2</td>
        <td class="heading">3</td>
        <td class="heading">4</td>
        <td class="heading">TTL</td>
        <td class="heading">Skor</td>
        <td class="heading">Kategori</td>
        <td class="heading">1</td>
        <td class="heading">2</td>
        <td class="heading">3</td>
        <td class="heading">4</td>
    </tr>
    <?php 
    foreach($report as $key => $value): 
        $total_nilai = $value['score']['CFIT'];
        // $total_nilai += $value['score']['MSDT']['msdt_final_value'];

        $IQ = "Mentally Defective";
        $IQ_VALUE = "<td>2</td><td>2</td><td>2</td><td>0</td>";
        $IQ_VALUE_ALL = 6;
        if($value['score']['CFIT'] >= 130) $IQ = "Very Superior";
        if($value['score']['CFIT'] >= 116 && $value['score']['CFIT'] <= 129) $IQ = "Superior";
        if($value['score']['CFIT'] >= 101 && $value['score']['CFIT'] <= 115) $IQ = "High Average";
        if($value['score']['CFIT'] >= 85 && $value['score']['CFIT'] <= 100) $IQ = "Average";
        if($value['score']['CFIT'] >= 70 && $value['score']['CFIT'] <= 84) $IQ = "Low Average";
        if($value['score']['CFIT'] < 70) $IQ = "Under Average";

        if($value['score']['CFIT'] >= 170) $IQ_VALUE = "<td>5</td><td>5</td><td>5</td><td>0</td>";
        if($value['score']['CFIT'] >= 140 && $value['score']['CFIT'] <= 169) $IQ_VALUE = "<td>5</td><td>5</td><td>5</td><td>0</td>";
        if($value['score']['CFIT'] >= 120 && $value['score']['CFIT'] <= 139) $IQ_VALUE = "<td>5</td><td>4</td><td>4</td><td>0</td>";
        if($value['score']['CFIT'] >= 110 && $value['score']['CFIT'] <= 119) $IQ_VALUE = "<td>4</td><td>4</td><td>4</td><td>0</td>";
        if($value['score']['CFIT'] >= 90 && $value['score']['CFIT'] <= 109) $IQ_VALUE = "<td>3</td><td>3</td><td>3</td><td>0</td>";
        if($value['score']['CFIT'] >= 80 && $value['score']['CFIT'] <= 89) $IQ_VALUE = "<td>2</td><td>3</td><td>3</td><td>0</td>";

        if($value['score']['CFIT'] >= 170) $IQ_VALUE_ALL = 15;
        if($value['score']['CFIT'] >= 140 && $value['score']['CFIT'] <= 169) $IQ_VALUE_ALL = 15;
        if($value['score']['CFIT'] >= 120 && $value['score']['CFIT'] <= 139) $IQ_VALUE_ALL = 13;
        if($value['score']['CFIT'] >= 110 && $value['score']['CFIT'] <= 119) $IQ_VALUE_ALL = 12;
        if($value['score']['CFIT'] >= 90 && $value['score']['CFIT'] <= 109) $IQ_VALUE_ALL = 9;
        if($value['score']['CFIT'] >= 80 && $value['score']['CFIT'] <= 89) $IQ_VALUE_ALL = 8;
        
        $total_nilai += $IQ_VALUE_ALL;
        $min = 999999;
        $max = 0;
    ?>
    <tr>
        <td><?=++$key?></td>
        <td class="nowrap"><?=$value['name']?></td>
        <td class="nowrap"><?=$value['school']?></td>
        <td class="nowrap"><?=$value['study']?></td>
        <?php 
        $total=0; 
        foreach($value['score']['partial_cfit'] as $cfit): 
        $total+=$cfit;
        $min = $cfit < $min ? $cfit : $min;
        $max = $cfit > $max ? $cfit : $max;
        ?>
        <td class="nowrap"><?=$cfit?></td>
        <?php endforeach ?>
        <td><?=$total?></td>
        <td><?=$value['score']['CFIT']?></td>
        <td class="nowrap"><?=$IQ?></td>
        <td class="nowrap">
            <?php
            $skor=$value['score']['CFIT'];
            if($skor>=130)
                echo 5;
            elseif($skor >= 111 && $skor <= 129)
                echo 4;
            elseif($skor >= 90 && $skor <= 110)
                echo 3;
            elseif($skor >= 70 && $skor <= 89)
                echo 2;
            else
                echo 1;
            ?>
        </td>
        <td class="nowrap">
            <?php
            $skor=$max-$min;
            if($skor==0)
                echo 5;
            elseif($skor >= 1 && $skor <= 3)
                echo 4;
            elseif($skor >= 4 && $skor <= 6)
                echo 3;
            elseif($skor >= 7 && $skor <= 9)
                echo 2;
            else
                echo 1;
            ?>
        </td>
        <td class="nowrap">
            <?php
            $skor=$total;
            if($skor>=41)
                echo 5;
            elseif($skor >= 31 && $skor <= 40)
                echo 4;
            elseif($skor >= 21 && $skor <= 30)
                echo 3;
            elseif($skor >= 11 && $skor <= 20)
                echo 2;
            else
                echo 1;
            ?>
        </td>
        <td class="nowrap">
            <?php
            $skor=$value['score']['partial_cfit']['CFIT 4'];
            if($skor>=9)
                echo 5;
            elseif($skor >= 7 && $skor <= 8)
                echo 4;
            elseif($skor >= 5 && $skor <= 6)
                echo 3;
            elseif($skor >= 3 && $skor <= 4)
                echo 2;
            else
                echo 1;
            ?>
        </td>
    </tr>
    <?php endforeach ?>
</table>