<?php
namespace app\models\TestTools;

use app\models\Post;

class Imj
{
    public static $report_columns = [
        'Nama',
        'Username',
        'Jurusan',
        '1',
        '2',
        '3',
        '4',
        '5',
        '6',
        '7',
        '8',
        '9',
        '10',
        '11',
        '12',
        '13',
        '14',
        '15',
    ];

    public static $categories = [
        'IMJ'=>[
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
        ]
    ];

    public static $_report = [];

    static function insert($no, $category, $worksheet, $post, $row)
    {
        for($i=1;$i<=4;$i++)
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

    static function report($model)
    {
        $report = [];
        foreach($model->participants as $participant)
        {
            $cats = Category::find()->where(['test_tool'=>'IMJ'])->all();
            $post_id = [];
            foreach($cats as $cat)
                foreach($cat->getPosts()->where(['jurusan'=>$participant->study])->all() as $post)
                    $post_id[] = $post->id;
            $skor = ['N'=>[],'TOTAL'=>0];
            $answers = $participant->getExamAnswers()->where(['in','question_id',$post_id])->all();
            foreach($answers as $answer)
            {
                $skor['N'][] += (int) $answer->answer->post_type;
                $skor['TOTAL'] += (int) $answer->answer->post_type;
            }

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
        {
            if($skor['BAHASA'] > $skor['IPS'])
                return 'BAHASA';
            return 'IPS';
        }

        return '-';
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
            $skor_papi = $this->papi_norma($re['skor']['Papikostick']);
            $rows = '<tr>';
            $rows .= '<td>'.++$key.'</td>';
            $rows .= '<td>'.$re['participant']->name.'</td>';
            $rows .= '<td>\''.$re['participant']->user->username.'</td>';
            $rows .= '<td>'.$re['participant']->getMeta('jurusan').'</td>';
            foreach($re['skor']['N'] as $key => $value)
                $rows .= '<td>'.$value.'</td>';
            $rows .= '<td>'.$re['skor']['TOTAL'].'</td>';
            $html .= $rows;
        }
        return $html;
    }
}