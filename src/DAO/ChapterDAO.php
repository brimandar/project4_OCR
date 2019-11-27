<?php

namespace App\src\DAO;

use App\src\model\Chapter;

class ChapterDAO extends DAO
{

    /**
     * Returns a table containing the list of chapters
     *
     * @return array
     */
    public function getChapters()
    {
        $sql = 'SELECT id, title, content, created_at, updated_at FROM chapters ORDER BY id DESC';
        $result = $this->createQuery($sql);
        $chapters = [];
        foreach ($result as $row){
            $chapterId = $row['id'];
            $chapters[$chapterId] = new Chapter($row);
        }
        $result->closeCursor();
        return $chapters;
    }

    /**
     * Returns a chapter based on the ID chapter (GET)
     *
     * @param  int $chapterId
     *
     * @return string
     */
    public function getChapter($chapterId)
    {
        $sql = 'SELECT id, title, content, created_at, updated_at FROM chapters WHERE id = ?';
        $return = $this->createQuery($sql, [$chapterId]);
        $data = $return->fetch();
        $chapter = new Chapter($data);
        $return->closeCursor();
        return $chapter;
    }
}
?>