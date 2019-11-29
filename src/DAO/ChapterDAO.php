<?php

namespace App\src\DAO;

use App\src\model\Chapter;
use App\config\Parameter;

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

    /**
     * add chapter in DB chapters
     *
     * @param  object data class Parameter
     *
     * @return void
     */
    public function addChapter(Parameter $post)
    {
        /*
        * Permet de récupérer les variables $title, $content et $author de la class Parameter 
        * utilisée dans BackController
        */
        $sql = 'INSERT INTO chapters (title, content, created_at) VALUES (?, ?, NOW())';
        $this->createQuery($sql, [$post->get('title'), $post->get('content') ]);
    }

    public function editChapter(Parameter $post, $chapterId)
    {
        $sql = 'UPDATE chapters SET title=:title, content=:content WHERE id=:chapterId';
        $this->createQuery($sql, [
            'title' => $post->get('title'),
            'content' => $post->get('content'),
            'chapterId' => $chapterId
        ]);
    }
}
?>