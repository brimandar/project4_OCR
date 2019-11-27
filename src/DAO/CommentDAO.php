<?php

namespace App\src\DAO;

use App\src\model\Comment;
use PDO;

class CommentDAO extends DAO
{
    public function getCommentsFromChapter($chapterId)
    {
        $sql = 'SELECT com.id, com.content, com.created_at, com.updated_at, us.username
                FROM comments com
                INNER JOIN users us ON com.id = us.id
                WHERE com.chapter_id = ? ';

        $result = $this->createQuery($sql, [$chapterId]);
        $default = 'Aucun commentaire';
        while ($row = $result->fetch())
        {
            ?><pre><?php var_dump($row);?></pre><?php
            $comment[] = new Comment($row);
        }
        if(isset($comment)) { return $comment; };//test if the variable $comment is not null

        $result->closeCursor();
    }
}
?>