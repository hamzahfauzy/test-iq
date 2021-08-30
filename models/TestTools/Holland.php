<?php
namespace app\models\TestTools;

use app\models\Post;

class Holland
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
        'Jurusan 2'
    ];

    public static $single_report_columns = [
        'Nama',
        'Username',
        'Jurusan',
        'R',
        'I',
        'A',
        'S',
        'E',
        'C',
        'HASIL',
        'UTAMA',
        'PENDUKUNG'
    ];

    public static $categories = [
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
                'R'=>0,
                'I'=>0,
                'A'=>0,
                'S'=>0,
                'E'=>0,
                'C'=>0
            ];
            foreach($participant->examAnswers as $answer)
            {
                if(!in_array($answer->question->categoryPost->test_tool,['HOLLAND'])) continue;
                foreach(self::$categories as $key => $value)
                {
                    if(in_array($answer->question->categoryPost->name,$value) && $answer->answer)
                    {
                        $skor[$key] += (int) $answer->answer->post_type;
                    }
                    
                }
            }
            $skor['TOTAL'] = 0;
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

    static function insert($no, $category, $worksheet, $post, $row)
    {
        for($i=1;$i<=5;$i++)
        {
            $child = new Post;
            $child->post_title = "Jawaban ".$post->post_title." ".$i;
            $child->post_content = $worksheet->getCellByColumnAndRow($i+1, $row)->getValue();
            $child->post_as = "Jawaban";
            $child->post_type = $i;
            $child->save(false);
            $child->link('parents',$post);
        }
    }


    function renderSingleReport()
    {
        $html = '<table border="1" cellpadding="5" cellspacing="0"><tr><th>NO</th>';
        foreach(self::$single_report_columns as $column)
            $html .= '<th>'.$column.'</th>';
        
        $html .= '</tr>';

        $report = self::$_report;

        foreach($report as $key => $re)
        {
            $holland = explode('-',$re['skor']['HOLLAND']);
            $rows = '<tr>';
            $rows .= '<td>'.++$key.'</td>';
            $rows .= '<td>'.$re['participant']->name.'</td>';
            $rows .= '<td>\''.$re['participant']->user->username.'</td>';
            $rows .= '<td>'.$re['participant']->getMeta('jurusan').'</td>';
            $rows .= '<td>'.$re['skor']['R'].'</td>';
            $rows .= '<td>'.$re['skor']['I'].'</td>';
            $rows .= '<td>'.$re['skor']['A'].'</td>';
            $rows .= '<td>'.$re['skor']['S'].'</td>';
            $rows .= '<td>'.$re['skor']['E'].'</td>';
            $rows .= '<td>'.$re['skor']['C'].'</td>';
            $rows .= '<td>'.$re['skor']['HOLLAND'].'</td>';
            $rows .= '<td>'.$holland[0].'</td>';
            $rows .= '<td>'.$holland[1].'</td>';
            $html .= $rows;
        }
        return $html;
    }
}