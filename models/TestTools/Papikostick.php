<?php
namespace app\models\TestTools;

use app\models\Post;
use app\models\Category;

class Papikostick
{
    public static $single_report_columns = [
        'Nama',
        'Username',
        'Jurusan',
        'G',
        'L',
        'I',
        'T',
        'V',
        'S',
        'R',
        'D',
        'C',
        'E',
        'N',
        'A',
        'P',
        'X',
        'B',
        'O',
        'Z',
        'K',
        'F',
        'W',
    ];

    public static $categories = [
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
        $cats = Category::find()->where(['test_tool'=>'PAPIKOSTICK'])->with(['posts'])->all();
        $post_id = [];
        foreach($cats as $cat)
            foreach($cat->posts as $post)
                $post_id[] = $post->id;
        $report = [];
        if(isset($_GET['page']))
            $participants = $model->getParticipants()->limit(50)->offset($_GET['page'])->all();
        else
            $participants = $model->participants;
        foreach($participants as $participant)
        {
            $skor = [
                'Papikostick' => []
            ];
            foreach($participant->getExamAnswers()->where(['in','question_id',$post_id])->all() as $answer)
            {
                if(!in_array($answer->question->categoryPost->test_tool,['TPA','HOLLAND','PAPIKOSTICK'])) continue;
                foreach(self::$categories as $key => $value)
                {
                    if(in_array($answer->question->categoryPost->name,$value) && $answer->answer)
                    {
                        // papikostick
                        if(isset($skor['Papikostick'][$answer->answer->post_type]))
                            $skor['Papikostick'][$answer->answer->post_type]++;
                        else
                            $skor['Papikostick'][$answer->answer->post_type] = 1;
                    }
                }
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
        // save A
        $child = new Post;
        $child->post_title = "Jawaban A ".$category->name." ".$no;
        $child->post_content = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
        $child->post_as = "Jawaban";
        $child->post_type = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
        $child->save(false);
        $child->link('parents',$post);

        // save B
        $child = new Post;
        $child->post_title = "Jawaban B ".$category->name." ".$no;
        $child->post_content = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
        $child->post_as = "Jawaban";
        $child->post_type = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
        $child->save(false);
        $child->link('parents',$post);
    }

    function renderSingleReport()
    {
        $html = '<table border="1" cellpadding="5" cellspacing="0"><tr><th>NO</th>';
        foreach(self::$single_report_columns as $n => $column)
        {
            $html .= '<th>'.$column.'</th>';
            if($n > 2) $html .= '<th>Norma</th>';
        }
        
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
            foreach(self::$single_report_columns as $n => $column)
            {
                if($n <= 2) continue;
                $rows .= '<td>'.(isset($re['skor']['Papikostick'][$column])?$re['skor']['Papikostick'][$column]:0).'</td>';
                $rows .= '<td>'.(isset($skor_papi[$column])?$skor_papi[$column]:0).'</td>';
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