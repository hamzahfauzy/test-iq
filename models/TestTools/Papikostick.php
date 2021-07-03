<?php
namespace app\models\TestTools;

use app\models\Post;

class Papikostick
{
    static function insert($no, $category, $worksheet, $post)
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
}