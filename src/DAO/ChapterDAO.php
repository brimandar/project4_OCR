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
        $sql = 'SELECT chapters.id, chapters.title, chapters.content, users.username, chapters.created_at, chapters.updated_at 
                FROM chapters
                INNER JOIN users ON chapters.user_id = users.id
                ORDER BY id DESC';
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
        $sql = 'SELECT chapters.id, chapters.title, chapters.content, users.username, chapters.created_at, chapters.updated_at, chapters.user_id 
                FROM chapters
                INNER JOIN users ON chapters.user_id = users.id
                WHERE chapters.id = ?';
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
    public function addChapter(Parameter $post, $userId)
    {
        /*
        * Permet de récupérer les variables $title, $content et $author de la class Parameter 
        * utilisée dans BackController
        */
        $sql = 'INSERT INTO chapters (title, content, created_at, user_id) VALUES (?, ?, NOW(), ?)';
        $this->createQuery($sql, [$post->get('title'), $post->get('content'), $userId ]);
    }


    public function editChapter(Parameter $post, $chapterId, $userId)
    {
        $sql = 'UPDATE chapters SET title=:title, content=:content, user_id=:user_id, updated_at=NOW() WHERE id=:chapterId';
        $this->createQuery($sql, [
            'title' => $post->get('title'),
            'content' => $post->get('content'),
            'user_id' => $userId,
            'chapterId' => $chapterId
        ]);
    }


    /**
     * delete Article
     *
     * @param  mixed $articleId
     *
     * @return void
     */
    public function deleteArticle($chapterId)
    {
        $sql = 'DELETE FROM comments WHERE chapter_id = ?';
        $this->createQuery($sql, [$chapterId]);
        $sql = 'DELETE FROM chapters WHERE id = ?';
        $this->createQuery($sql, [$chapterId]);

    }
}
?>