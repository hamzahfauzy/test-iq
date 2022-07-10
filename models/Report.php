<?php

namespace app\models;

class Report
{
    public $report_columns = [
        'Nama',
        'Username',
        'SUBTEST 1',
        'SUBTEST 2',
        'SUBTEST 3',
        'SUBTEST 4',
        'Jumlah',
        'IQ',
        'Verbal',
        'Aritmatika',
        'R',
        'I',
        'A',
        'S',
        'E',
        'C',
        'RIASEC'
    ];

    public $range_iq = [
        38,
        40,
        43,
        45,
        47,
        48,
        52,
        55,
        57,
        60,
        63,
        67,
        70,
        72,
        75,
        78,
        81,
        85,
        88,
        91,
        94,
        96,
        100,
        103,
        106,
        109,
        113,
        116,
        119,
        121,
        124,
        128,
        131,
        133,
        137,
        140,
        142,
        145,
        149,
        152,
        155,
        157,
        161,
        165,
        167,
        169,
        173,
        176,
        179,
        183,
        183,
    ];

    public $data = [];

    public function __construct($data)
    {
        $this->data = $data;
    }

    function render()
    {
        $html = '<table border="1" cellpadding="5" cellspacing="0"><tr><th>NO</th>';
        foreach($this->report_columns as $column)
            $html .= '<th>'.$column.'</th>';
        
        $html .= '</tr>';

        foreach($this->data['participants'] as $key => $participant)
        {
            $test_tool_score = [
                'CFIT' => [
                    'CFIT 1' => 0,
                    'CFIT 2' => 0,
                    'CFIT 3' => 0,
                    'CFIT 4' => 0,
                ],
                'TPA'  => [
                    'Soal TPA 2' => 0,
                    'Soal TPA 5' => 0,
                ],
                'HOLLAND' => [
                    'R' => 0,
                    'I' => 0,
                    'A' => 0,
                    'S' => 0,
                    'E' => 0,
                    'C' => 0
                ]
            ];
            $rows = '<tr>';
            $rows .= '<td>'.++$key.'</td>';
            $rows .= '<td>'.$participant['name'].'</td>';
            $rows .= '<td>\''.$participant['id_number'].'</td>';

            foreach($this->data['group']['items'] as $column)
            {
                if($column['category'] == null) continue;
                $score = $participant->scores($this->data->id, $column['category']['id']);
                if($column['category']['test_tool'] == 'HOLLAND')
                {
                    if(strpos($column['category']['name'],"Soal Holland - R") > -1)
                        $test_tool_score['HOLLAND']['R'] += $score;
                    if(strpos($column['category']['name'],"Soal Holland - I") > -1)
                        $test_tool_score['HOLLAND']['I'] += $score;
                    if(strpos($column['category']['name'],"Soal Holland - A") > -1)
                        $test_tool_score['HOLLAND']['A'] += $score;
                    if(strpos($column['category']['name'],"Soal Holland - S") > -1)
                        $test_tool_score['HOLLAND']['S'] += $score;
                    if(strpos($column['category']['name'],"Soal Holland - E") > -1)
                        $test_tool_score['HOLLAND']['E'] += $score;
                    if(strpos($column['category']['name'],"Soal Holland - C") > -1)
                        $test_tool_score['HOLLAND']['C'] += $score;
                }
                else
                {
                    $test_tool_score[$column['category']['test_tool']][$column['category']['name']] = $score;
                }
                // $rows .= '<td>'.$score.'</td>';
            }

            foreach($test_tool_score as $columns => $values)
            {
                $jumlah = 0;
                foreach($values as $score)
                {
                    $jumlah += $score;
                    $rows .= '<td>'.$score.'</td>';
                }
                if($columns == 'CFIT')
                {
                    $rows .= '<td>'.$jumlah.'</td>';
                    $rows .= '<td>'.$this->iq($jumlah).'</td>';
                }

                if($columns == 'HOLLAND')
                {
                    arsort($values);
                    $rows .= '<td>'.implode('-',array_keys($values)).'</td>';
                }
            }

            $rows .= '</tr>';

            $html .= $rows;
        }
        return $html;
    }

    function iq($jumlah)
    {
        $rs = $this->range_iq[$jumlah];
        return $rs;
        if($rs<=69) return "Mentally Retardation";
        if($rs<=79) return "Borderline Defective";
        if($rs<=89) return "Low Average";
        if($rs<=109) return "Average";
        if($rs<=119) return "High Average";
        if($rs<=139) return "Superior";
        if($rs<=169) return "Very Superior";
        return "Genius";
    }
}