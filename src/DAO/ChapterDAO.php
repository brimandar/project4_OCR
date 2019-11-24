<?php

namespace App\src\DAO;

class ChapterDAO extends DAO
{
    public function getChapters()
    {
        $sql = 'SELECT id, title, content, created_at FROM chapters ORDER BY id DESC';
        return $this->createQuery($sql);
    }

    public function getChapter($chapterId)
    {
        $sql = 'SELECT id, title, content, created_at FROM chapters WHERE id = ?';
        return $this->createQuery($sql, [$chapterId]);
    }
}