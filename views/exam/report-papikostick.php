<?php
$norma = Yii::$app->params['norma'];
?>
<table border="1" cellspacing="0" cellpadding="5">
    <tr>
        <td class="nowrap heading" rowspan="2">#</td>
        <td class="nowrap heading" rowspan="2">Nama Peserta</td>
        <td class="nowrap heading" rowspan="2">Asal Sekolah</td>
        <td class="nowrap heading" colspan="40" align="center">Aspek Penilaian</td>
    </tr>
    <tr>
    <?php foreach($report[0]['score']['PapikostickAll'] as $key => $vp): ?>
    <td><?=$key?></td>
    <td>Nilai</td>
    <?php endforeach ?>
    </tr>
    <?php 
    foreach($report as $key => $value): 
        
    ?>
    <tr>
        <td><?=++$key?></td>
        <td class="nowrap"><?=$value['name']?></td>
        <td class="nowrap"><?=$value['school']?></td>
        <?php foreach($value['score']['PapikostickAll'] as $key => $vp): 
            $old_vp = $vp;
            $_norma = $norma[$key];
            foreach($_norma as $n)
            {
                if(in_array($vp, $n['in_nilai']))
                {
                    $vp = $n['nilai'];
                    break;
                }
            }
            // if(in_array($vp,[8,9]))
            //     $vp = 5;
            // elseif(in_array($vp,[6,7]))
            //     $vp = 4;
            // elseif(in_array($vp,[4,5]))
            //     $vp = 3;
            // elseif(in_array($vp,[2,3]))
            //     $vp = 2;
            // else
            //     $vp = 1;  
        ?>
        <td><?=$old_vp?></td>
        <td><?=$vp?></td>
        <?php endforeach; ?>
    </tr>
    <?php endforeach ?>
</table>