<?php
namespace app\models\TestTools;

use app\models\Post;

class Holland
{
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
}