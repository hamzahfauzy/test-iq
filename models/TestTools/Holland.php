<?php
namespace app\models\TestTools;

use app\models\Post;

class Holland
{
    static function insert($no, $category, $worksheet, $post)
    {
        for($i=2;$i<=6;$i++)
        {
            $child = new Post;
            $child->post_title = "Jawaban ".$category->name." ".$no;
            $child->post_content = $worksheet->getCellByColumnAndRow($i, $row)->getValue();
            $child->post_as = "Jawaban";
            $child->post_type = $i == 2 ? 1 : 0;
            $child->save(false);
            $child->link('parents',$post);
        }
    }
}