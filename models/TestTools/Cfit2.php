<?php
namespace app\models\TestTools;

use app\models\Post;

class Cfit2
{
    static function insert($no, $category, $worksheet, $post, $row)
    {
        // save true answer
        $child = new Post;
        $child->post_title = "Jawaban ".$category->name." ".$no;
        $child->post_content = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
        $child->post_as = "Jawaban";
        $child->post_type = "1";
        $child->save(false);
        $child->link('parents',$post);
    }
}