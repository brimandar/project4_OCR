<?php

namespace App\src\DAO;

use App\config\Parameter;
use App\src\model\Comment;

class CommentDAO extends DAO
{
    /**
     * Returns the last comments of a chapter (first load)
     *
     * @param  int $chapterId
     *
     * @return array
     */
    public function getCommentsFromChapter($chapterId)
    {
        $sql = "SELECT com.id, com.content, com.created_at, com.updated_at, com.flag, us.username
                FROM comments com
                INNER JOIN users us ON com.user_id = us.id
                WHERE com.chapter_id = ?
                ORDER BY com.id DESC
                LIMIT 0, 5
                ";

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
     * getAjaxComments
     *
     * @param  int $chapterId
     * @param  int $lastId
     *
     * @return void
     */
    public function getAjaxComments($chapterId, $lastId)
    {
        $sql = "SELECT com.id, com.content, com.created_at, com.updated_at, com.flag, us.username
                FROM comments com
                INNER JOIN users us ON com.user_id = us.id
                WHERE com.chapter_id = ? AND com.id < ?
                ORDER BY com.id DESC
                LIMIT 0, 5
                ";

        $result = $this->createQuery($sql, [$chapterId, $lastId]);
        $default = 'Aucun commentaire';
        while ($row = $result->fetch())
        {
            $comment[] = new Comment($row);
        }
        if(isset($comment)) { return $comment; };//test if the variable $comment is not null

        $result->closeCursor();
    }

    public function getMyComments($user)
    {
        $sql = "SELECT com.id, com.content, com.created_at, com.updated_at, com.flag, us.username, chap.title, com.chapter_id
                FROM comments com
                INNER JOIN chapters chap ON chap.id = com.chapter_id
                INNER JOIN users us ON us.id = com.user_id
                WHERE us.id = ?
                ORDER BY com.id DESC
                ";

        $result = $this->createQuery($sql, [$user]);
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
    public function addComment(Parameter $post, $chapterId, $user_id)
    {
        $sql = 'INSERT INTO comments (user_id, content, created_at, chapter_id, flag) VALUES (?, ?, NOW(), ?, 0)';
        $this->createQuery($sql, [$user_id, $post->get('content'), $chapterId]);
    }

    /**
     * Report an inappropriate comment
     *
     * @param  int $commentId
     *
     * @return object
     */
    public function flagComment($commentId)
    {
        $sql = 'UPDATE comments SET flag = ? WHERE id = ?';
        $this->createQuery($sql, [1, $commentId]);
    }

    /**
     * an administrator can remove the flag
     *
     * @param  mixed $commentId
     *
     * @return void
     */
    public function unflagComment($commentId)
    {
        $sql = 'UPDATE comments SET flag = ? WHERE id = ?';
        $this->createQuery($sql, [0, $commentId]);
    }

    /**
     * deleteComment
     *
     * @param  int $commentId
     *
     * @return object
     */
    public function deleteComment($commentId)
    {
        $sql = 'DELETE FROM comments WHERE id = ?';
        $this->createQuery($sql, [$commentId]);
    }


    /**
     * get Flag Comments (for admin view)
     *
     * @return object
     */
    public function getFlagComments()
    {
        $sql = 'SELECT comments.id, comments.user_id, users.username, comments.content, comments.created_at, comments.flag 
                FROM comments
                INNER JOIN users ON comments.user_id = users.id 
                WHERE flag = ? ORDER BY created_at DESC';
        $result = $this->createQuery($sql, [1]);
        $comments = [];
        foreach ($result as $row) {
            $commentId = $row['id'];
            $comments[$commentId] = new Comment($row);
        }
        $result->closeCursor();
        return $comments;
    }
    
}
?>