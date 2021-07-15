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
        'BHS',
        'IPS',
        'IPA',
        'Skor',
        'Kategori',
        'Jurusan 1',
        'Jurusan 2',
        'Kemampuan Verbal',
        'Kemampuan Spasial',
        'Kemampuan Numerikal',
        'Kepercayaan Diri (O)',
        'Penyesuaian Diri (Z)',
        'Hasrat Berprestasi (A)',
        'Stabilitas Emosi (E)',
        'Kontak Sosial (S)',
        'Sistematika Belajar (C)',
        'Daya Juang (G)',
        'Daya Tahan Terhadap Stress (K)',
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
        'PAPIKOSTICK' => [
            'Soal Papikostik (Halaman 1)',
            'Soal Papikostik (Halaman 2)',
            'Soal Papikostik (Halaman 3)',
        ]
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
                'Papikostick' => [],
                'R'=>0,
                'I'=>0,
                'A'=>0,
                'S'=>0,
                'E'=>0,
                'C'=>0
            ];
            foreach($participant->examAnswers as $answer)
            {
                if(!in_array($answer->question->categoryPost->test_tool,['TPA','HOLLAND','PAPIKOSTICK'])) continue;
                foreach(self::$categories as $key => $value)
                {
                    if(in_array($answer->question->categoryPost->name,$value) && $answer->answer)
                    {
                        if(!in_array($answer->question->categoryPost->test_tool,['TPA','HOLLAND']))
                            $skor[$key] += (int) $answer->answer->post_type;
                        else
                        {
                            // papikostick
                            if(isset($skor['Papikostick'][$answer->answer->post_type]))
                                $skor['Papikostick'][$answer->answer->post_type]++;
                            else
                                $skor['Papikostick'][$answer->answer->post_type] = 1;
                        }
                        
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

            ksort($holland);
            $key_holland = array_keys($holland);

            $skor['HOLLAND'] = implode('',$key_holland);

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
            $rows .= '<td>'.$re['skor']['BAHASA'].'</td>';
            $rows .= '<td>'.$re['skor']['IPS'].'</td>';
            $rows .= '<td>'.$re['skor']['IPA'].'</td>';
            $rows .= '<td>'.$re['skor']['TOTAL'].'</td>';
            $rows .= '<td>'.self::category($re['skor']['TOTAL']).'</td>';
            $rows .= '<td>'.self::jurusan1($re['skor']).'</td>';
            $rows .= '<td>'.self::jurusan2($re['skor']).'</td>';
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
}