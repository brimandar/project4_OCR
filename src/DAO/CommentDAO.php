<?php

namespace App\src\DAO;

class CommentDAO extends DAO
{
    public function getCommentsFromChapter($chapterId)
    {
        $sql = 'SELECT com.content, com.created_at, us.username
                FROM comments com
                INNER JOIN user_chapter uc ON com.id = uc.chapter_id
                INNER JOIN users us ON us.id = uc.user_id
                WHERE com.chapter_id = ? 
                ORDER BY created_at DESC';
        return $this->createQuery($sql, [$chapterId]);
    }
}