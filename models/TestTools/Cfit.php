<?php
namespace app\models\TestTools;

use app\models\Post;

class Cfit
{
    static function insert($no, $category, $worksheet, $post, $row)
    {
        $alphabet = range('a', 'z');
        $num = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
        $index = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
        for($i=0;$i<$num;$i++)
        {
            $child = new Post;
            $child->post_title = "Jawaban ".$alphabet[$i]." ".$category->name." ".$no;
            $child->post_content = $alphabet[$i];
            $child->post_as = "Jawaban";
            $child->post_type = $index == ($i+1) ? 1 : 0;
            $child->save(false);
            $child->link('parents',$post);
        }
    }
}