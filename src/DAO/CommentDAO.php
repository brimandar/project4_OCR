<?php

namespace App\src\DAO;

use App\config\Parameter;
use App\src\model\Comment;

class CommentDAO extends DAO
{
    /**
     * Returns the comments of a chapter
     *
     * @param  mixed $chapterId
     *
     * @return array
     */
    public function getCommentsFromChapter($chapterId)
    {
        $sql = 'SELECT com.id, com.content, com.created_at, com.updated_at, us.username
                FROM comments com
                INNER JOIN users us ON com.user_id = us.id
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


    /**
     * add a comment to an chapter
     *
     * @param  mixed $post
     * @param  mixed $chapterId
     *
     * @return void
     */
    public function addComment(Parameter $post, $chapterId)
    {
        $sql = 'INSERT INTO comments (user_id, content, created_at, chapter_id) VALUES (?, ?, NOW(), ?)';
        $this->createQuery($sql, [2, $post->get('content'), $chapterId]);
    }
}
?>