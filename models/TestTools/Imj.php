<?php
namespace app\models\TestTools;

use app\models\Post;

class Imj
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

    static function report($id)
    {
        $model = Exam::find()->where([
                    'exams.id'=>$id,
                ])
                ->joinWith([
                    'participants',
                    'participants.user',
                    'participants.user.metas',
                    'participants.examAnswers',
                    'participants.examAnswers.answer',
                    'participants.examAnswers.question',
                    'participants.examAnswers.question.items',
                    'participants.examAnswers.question.categoryPost' => function($q) {
                        return $q->andOnCondition(['=', 'categories.test_tool', 'TPA']);
                    }
                ])
                // ->asArray()
                ->one();
        $report = [];
        foreach($model->participants as $participant)
        {
            $skor = ['IPS'=>0,'BAHASA'=>0,'IPA'=>0];
            foreach($participant->examAnswers as $answer)
            {
                if($answer->question->categoryPost == NULL) continue;
                foreach(self::$categories as $key => $value)
                {
                    if(in_array($answer->question->categoryPost->name,$value) && $answer->answer)
                        $skor[$key] += (int) $answer->answer->post_type;
                }
            }
            $skor['TOTAL'] = $skor['IPS']+$skor['BAHASA']+$skor['IPA'];

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
}