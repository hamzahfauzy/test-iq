<?php
namespace app\models\TestGroup;

use app\models\Exam;
use app\models\Post;

class Group2
{   
    public static $report_columns = [
        'Nama',
        'Username',
        'Tempat Lahir',
        'Tanggal Lahir',
        'Jenis Kelamin',
        'Tanggal Pemeriksaan',
        'Pilihan Jurusan',
        '1',
        '2',
        '3',
        '4',
        '5',
        '6',
        '7',
        '8',
        'TOTAL',
        'POTENSI AKADEMIK',
        'BHS',
        'IPS',
        'TOTAL',
        'IPA',
        'JURUSAN',
        'R',
        'I',
        'A',
        'S',
        'E',
        'C',
        'HASIL',
    ];

    public static $categories = [
        'IPS'=>[
            'TPA 1',
            'TPA 2'
        ],
        'BAHASA' => [
            'TPA 3',
            'TPA 4'
        ],
        'IPA' => [
            'TPA 5',
            'TPA 6',
            'TPA 7',
            'TPA 8',
        ],
        'R' => [
            'Soal Holland R1',
            'Soal Holland R2',
            'Soal Holland R3',
        ],
        'I' => [
            'Soal Holland I1',
            'Soal Holland I2',
            'Soal Holland I3',
        ],
        'A' => [
            'Soal Holland A1',
            'Soal Holland A2',
            'Soal Holland A3',
        ],
        'S' => [
            'Soal Holland S1',
            'Soal Holland S2',
            'Soal Holland S3',
        ],
        'E' => [
            'Soal Holland E1',
            'Soal Holland E2',
            'Soal Holland E3',
        ],
        'C' => [
            'Soal Holland C1',
            'Soal Holland C2',
            'Soal Holland C3',
        ],
    ];

    public static $_report = [];

    static function report($model)
    {
        ini_set('memory_limit',-1);
        $report = [];
        foreach($model->participants as $participant)
        {
            $skor = [
                'IPS'=>0,
                'BAHASA'=>0,
                'IPA'=>0,
                'TPA' => [
                    'S1'=>0,
                    'S2'=>0,
                    'S3'=>0,
                    'S4'=>0,
                    'S5'=>0,
                    'S6'=>0,
                    'S7'=>0,
                    'S8'=>0,
                ],
                'R'=>0,
                'I'=>0,
                'A'=>0,
                'S'=>0,
                'E'=>0,
                'C'=>0
            ];
            foreach($participant->examAnswers as $answer)
            {
                if(!in_array($answer->question->categoryPost->test_tool,['TPA','HOLLAND'])) continue;
                foreach(self::$categories as $key => $value)
                {
                    if(in_array($answer->question->categoryPost->name,$value) && $answer->answer)
                    {
                        $skor[$key] += (int) $answer->answer->post_type;
                        if($answer->question->categoryPost->name == 'TPA 1')
                            $skor['TPA']['S1']+=(int) $answer->answer->post_type;
                        if($answer->question->categoryPost->name == 'TPA 2')
                            $skor['TPA']['S2']+=(int) $answer->answer->post_type;
                        if($answer->question->categoryPost->name == 'TPA 3')
                            $skor['TPA']['S3']+=(int) $answer->answer->post_type;
                        if($answer->question->categoryPost->name == 'TPA 4')
                            $skor['TPA']['S4']+=(int) $answer->answer->post_type;
                        if($answer->question->categoryPost->name == 'TPA 5')
                            $skor['TPA']['S5']+=(int) $answer->answer->post_type;
                        if($answer->question->categoryPost->name == 'TPA 6')
                            $skor['TPA']['S6']+=(int) $answer->answer->post_type;
                        if($answer->question->categoryPost->name == 'TPA 7')
                            $skor['TPA']['S7']+=(int) $answer->answer->post_type;
                        if($answer->question->categoryPost->name == 'TPA 8')
                            $skor['TPA']['S8']+=(int) $answer->answer->post_type;
                    }
                    
                }
            }
            $skor['TOTAL'] = $skor['IPS']+$skor['BAHASA']+$skor['IPA'];
            $holland = [
                'R' => $skor['R'],
                'I' => $skor['I'],
                'A' => $skor['A'],
                'S' => $skor['S'],
                'E' => $skor['E'],
                'C' => $skor['C'],
            ];

            arsort($holland);
            $holland_skor = "";
            foreach($holland as $key => $value)
                $holland_skor .= $key.'-';
            
            $holland_skor = substr($holland_skor, 0, -1);
            // $key_holland = array_keys($holland);

            $skor['HOLLAND'] = $holland_skor; //implode('',$key_holland);

            $report[] = [
                'participant' => $participant,
                'skor' => $skor
            ];
        }

        self::$_report = $report;
        return new static;
        // return [
        //     'columns' => self::$report_columns,
        //     'data' => $report
        // ];
    }

    function render()
    {
        $html = '<table border="1" cellpadding="5" cellspacing="0"><tr><th>NO</th>';
        foreach(self::$report_columns as $column)
            $html .= '<th>'.$column.'</th>';
        
        $html .= '</tr>';

        $report = self::$_report;

        foreach($report as $key => $re)
        {
            $rows = '<tr>';
            $rows .= '<td>'.++$key.'</td>';
            $rows .= '<td>'.$re['participant']->name.'</td>';
            $rows .= '<td>\''.$re['participant']->user->username.'</td>';
            $rows .= '<td>'.$re['participant']->getMeta('tempat_lahir').'</td>';
            $rows .= '<td>'.$re['participant']->getMeta('tanggal_lahir').'</td>';
            $rows .= '<td>'.$re['participant']->getMeta('jenis_kelamin').'</td>';
            $rows .= '<td>'.$re['participant']->examParticipant->finished_at.'</td>';
            $rows .= '<td>'.$re['participant']->getMeta('jurusan').'</td>';
            $rows .= '<td>'.$re['skor']['TPA']['S1'].'</td>';
            $rows .= '<td>'.$re['skor']['TPA']['S2'].'</td>';
            $rows .= '<td>'.$re['skor']['TPA']['S3'].'</td>';
            $rows .= '<td>'.$re['skor']['TPA']['S4'].'</td>';
            $rows .= '<td>'.$re['skor']['TPA']['S5'].'</td>';
            $rows .= '<td>'.$re['skor']['TPA']['S6'].'</td>';
            $rows .= '<td>'.$re['skor']['TPA']['S7'].'</td>';
            $rows .= '<td>'.$re['skor']['TPA']['S8'].'</td>';
            $rows .= '<td>'.$re['skor']['TOTAL'].'</td>';
            $rows .= '<td>'.self::category($re['skor']['TOTAL']).'</td>';
            $rows .= '<td>'.$re['skor']['BAHASA'].'</td>';
            $rows .= '<td>'.$re['skor']['IPS'].'</td>';
            $rows .= '<td>'.($re['skor']['IPS']+$re['skor']['BAHASA']).'</td>';
            $rows .= '<td>'.$re['skor']['IPA'].'</td>';
            $rows .= '<td>'.self::jurusan1($re['skor']).'</td>';
            $rows .= '<td>'.$re['skor']['R'].'</td>';
            $rows .= '<td>'.$re['skor']['I'].'</td>';
            $rows .= '<td>'.$re['skor']['A'].'</td>';
            $rows .= '<td>'.$re['skor']['S'].'</td>';
            $rows .= '<td>'.$re['skor']['E'].'</td>';
            $rows .= '<td>'.$re['skor']['C'].'</td>';
            $rows .= '<td>'.$re['skor']['HOLLAND'].'</td>';

            $html .= $rows;
        }
        return $html;
    }

    static function category($value)
    {
        if($value >= 100)
            return 'Sangat Tinggi';
        
        if($value >= 80 && $value <= 99)
            return 'Tinggi';

        if($value >= 60 && $value <= 79)
            return 'Sedang';

        if($value >= 40 && $value <= 59)
            return 'Sedang';
        
        return 'Sangat Kurang';
    }

    static function jurusan1($skor)
    {
        if($skor['TOTAL'] == 0) return '';
        if($skor['BAHASA']+$skor['IPS'] > $skor['IPA'])
            return 'IPS';
        
        return 'IPA';
    }

    static function jurusan2($skor)
    {
        if($skor['TOTAL'] == 0) return '';
        if(self::jurusan1($skor) == 'IPS')
            return 'BAHASA';

        return 'IPS';
    }

    function single_report($worksheet)
    {
        $content     = "
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

        ul {
            margin:0px;
            padding:0px;
            padding-left:-15px;
            padding-bottom:-25px;
        }
        .box {
            background-color:red;
        }
        </style>
        <body>
        ";

        $highestRow  = $worksheet->getHighestRow();
        $highestColumn = $worksheet->getHighestColumn();
        $highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn);
        $exists = false;
        if($worksheet->getCellByColumnAndRow(10, 2)->getFormattedValue() == 'BHS')
        {
            for ($row = 3; $row <= $highestRow; $row++) { 
                $value = $worksheet->getCellByColumnAndRow(3, $row)->getFormattedValue();
                $_nisn = $worksheet->getCellByColumnAndRow(4, $row)->getFormattedValue();
                if($value == '' || $_nisn != $nisn) continue;
            //     echo $worksheet->getCellByColumnAndRow(3, $row)->getValue() . '<br>';
                $content .= $this->renderPartial('cetak_bhs_group_2',[
                    'worksheet' => $worksheet,
                    'row'       => $row
                ]);
                $exists = true;
                break;
            }
        }
        else
        {
            for ($row = 3; $row <= $highestRow; $row++) { 
                $value = $worksheet->getCellByColumnAndRow(3, $row)->getFormattedValue();
                $_nisn = $worksheet->getCellByColumnAndRow(4, $row)->getFormattedValue();
                if($value == '' || $_nisn != $nisn) continue;
            //     echo $worksheet->getCellByColumnAndRow(3, $row)->getValue() . '<br>';
                $content .= $this->renderPartial('cetak_group_2',[
                    'worksheet' => $worksheet,
                    'row'       => $row
                ]);
                $exists = true;
                break;
            }
        }

        if(!$exists) return false;

        $content .= "<body>";

        $participant = Participant::find()->where(['id_number'=>$nisn])->one();

        return ['content'=>$content,'name'=>$participant->name];
    }
}