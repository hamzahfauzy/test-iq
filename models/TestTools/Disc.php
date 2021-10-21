<?php
namespace app\models\TestTools;

use app\models\Post;
use app\models\Category;

class Disc
{
    public static $single_report_columns = [
        'Nama',
        'Username',
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
        '16',
        '17',
        '18',
        '19',
        '20',
        '21',
        '22',
        '23',
        '24',
    ];

    public static $categories = [
        'DISC' => [
            'Soal Papikostik (Halaman 1)',
            'Soal Papikostik (Halaman 2)',
            'Soal Papikostik (Halaman 3)',
        ]
    ];

    public static $_report = [];

    static function report($model)
    {
        ini_set('memory_limit',-1);
        $cats = Category::find()->where(['test_tool'=>'DISC'])->with(['posts'])->all();
        $post_id = [];
        foreach($cats as $cat)
            foreach($cat->posts as $post)
                $post_id[] = $post->id;
        $report = [];
        if(isset($_GET['page']))
        {
            $page = $_GET['page'];
            $limit = 50;
            $offset = $limit*($page-1);
            $participants = $model->getParticipants()->limit($limit)->offset($offset)->all();
        }
        else
            $participants = $model->participants;
        foreach($participants as $participant)
        {
            $skor = [
                'DISC' => []
            ];
            foreach($participant->getExamAnswers()->where(['in','question_id',$post_id])->all() as $answer)
            {
                if(!in_array($answer->question->categoryPost->test_tool,['DISC'])) continue;
                foreach(self::$categories as $key => $value)
                    $skor['DISC'][$answer->question->id][$answer->answer_content] = $answer->answer->post_type;
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

    function renderSingleReport()
    {
        $html = '<table border="1" cellpadding="5" cellspacing="0"><tr><th rowspan="2">NO</th>';
        foreach(self::$single_report_columns as $n => $column)
        {
            if($n <= 1)
                $html .= '<th rowspan="2">'.$column.'</th>';
            else
                $html .= '<th colspan="2">'.$column.'</th>';
        }
        
        $html .= '</tr><tr>';

        foreach(self::$single_report_columns as $n => $column)
        {
            if($n <= 1)
                continue;
            else
            {
                $html .= '<td>M</td>';
                $html .= '<td>L</td>';
            }
        }

        $html .= '</tr>';

        $report = self::$_report;

        foreach($report as $key => $re)
        {
            $rows = '<tr>';
            $rows .= '<td>'.++$key.'</td>';
            $rows .= '<td>'.$re['participant']->name.'</td>';
            $rows .= '<td>\''.$re['participant']->user->username.'</td>';
            foreach($re['skor']['DISC'] as $q_id => $answer)
            {
                // if(isset($answer['M']))
                //     print_r($answer['M']);
                $rows .= '<td>'.(isset($answer['M'])?$answer['M']:1).'</td>';
                $rows .= '<td>'.(isset($answer['L'])?$answer['L']:1).'</td>';
            }
            $html .= $rows;
        }
        return $html;
    }

    function papi_norma($papi)
    {
        foreach($papi as $key => $value)
        {
            if($key == 'G')
            {
                if($value >= 0 && $value <= 4)
                    $papi['G'] = 2;
                if($value >= 5 && $value <= 9)
                    $papi['G'] = 4;
            }

            if(in_array($key, ['L','P']))
            {
                if($value >= 0 && $value <= 4)
                    $papi[$key] = 2;
                if($value >= 5 && $value <= 8)
                    $papi[$key] = 3;
                if($value == 9)
                    $papi[$key] = 4;
            }

            if($key == 'I')
            {
                if($value >= 0 && $value <= 4)
                    $papi['I'] = 2;
                if($value >= 5 && $value <= 7)
                    $papi['I'] = 3;
                if($value >= 8)
                    $papi['I'] = 4;
            }

            if(in_array($key, ['T','V','R','D','X','B','W']))
            {
                if($value >= 0 && $value <= 3)
                    $papi[$key] = 2;
                if($value >= 4 && $value <= 6)
                    $papi[$key] = 3;
                if($value >= 7)
                    $papi[$key] = 4;
            }

            if($key == 'S')
            {
                if($value >= 0 && $value <= 5)
                    $papi['S'] = 2;
                if($value >= 6 && $value <= 9)
                    $papi['S'] = 4;
            }

            if($key == 'C')
            {
                if($value >= 0 && $value <= 3)
                    $papi['C'] = 2;
                if($value >= 4 && $value <= 6)
                    $papi['C'] = 3;
                if($value >= 7 && $value <= 9)
                    $papi['C'] = 4;
            }

            if($key == 'E')
            {
                if($value >= 0 && $value <= 3)
                    $papi['E'] = 2;
                if($value >= 4 && $value <= 6)
                    $papi['E'] = 4;
                if($value >= 7 && $value <= 9)
                    $papi['E'] = 3;
            }

            if($key == 'A')
            {
                if($value >= 0 && $value <= 4)
                    $papi['A'] = 2;
                if($value >= 5 && $value <= 9)
                    $papi['A'] = 4;
            }

            if($key == 'O')
            {
                if(($value >= 0 && $value <= 2) || ($value >= 5 && $value <= 7))
                    $papi['O'] = 2;
                if($value >= 3 && $value <= 4)
                    $papi['O'] = 3;
                if($value >= 8 && $value <= 9)
                    $papi['O'] = 4;
            }

            if($key == 'Z')
            {
                if(($value >= 0 && $value <= 4) || ($value == 9))
                    $papi['Z'] = 2;
                if($value >= 7 && $value <= 8)
                    $papi['Z'] = 3;
                if($value >= 5 && $value <= 6)
                    $papi['Z'] = 4;
            }

            if($key == 'K')
            {
                if(($value >= 0 && $value <= 2) || ($value == 5))
                    $papi['K'] = 2;
                if(($value >= 3 && $value <= 4) || ($value >= 8 && $value <= 9))
                    $papi['K'] = 3;
                if($value >= 6 && $value <= 7)
                    $papi['K'] = 4;
            }

            if($key == 'N')
            {
                if($value >= 0 && $value <= 4)
                    $papi['N'] = 2;
                if($value >= 5 && $value <= 6)
                    $papi['N'] = 3;
                if($value >= 7)
                    $papi['N'] = 4;
            }

            if($key == 'F')
            {
                if($value >= 0 && $value <= 3)
                    $papi['F'] = 2;
                if($value >= 6 && $value <= 9)
                    $papi['F'] = 3;
                if($value >= 4 && $value <= 5)
                    $papi['F'] = 4;
            }
        }

        return $papi;
    }
}