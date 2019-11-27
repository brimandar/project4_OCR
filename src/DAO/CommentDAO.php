<?php

namespace App\src\DAO;

use App\src\model\Comment;
use PDO;

class CommentDAO extends DAO
{
    /**
     * Returns the comments of a chapter
     *
     * @param  mixed $chapterId
     *
     * @return void
     */
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
            $comment[] = new Comment($row);
        }
        if(isset($comment)) { return $comment; };//test if the variable $comment is not null

        $result->closeCursor();
    }
}
?>