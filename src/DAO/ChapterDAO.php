<?php

namespace App\src\DAO;
use App\src\model\Chapter;
use App\config\Parameter;
use App\src\model\Pagination;

class ChapterDAO extends DAO
{
    private $_start;
    private $_limit;
    private $_total;
    /**
     * Returns a table containing the list of chapters
     *
     * @return array
     */
    public function getChapters()
    {
        // Query
        $sql = "SELECT chapters.id, chapters.title, chapters.content, users.username, chapters.created_at, chapters.updated_at 
                FROM chapters
                INNER JOIN users ON chapters.user_id = users.id
                ORDER BY id DESC
        ";
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

    public function lastChapter()
    {
        $sql = 'SELECT *  
                FROM chapters
                ORDER BY id DESC
                LIMIT 1';

        $return = $this->createQuery($sql);
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
    public function addChapter(Parameter $post, $userId, $pathImage)
    {
        /*
        * Permet de récupérer les variables $title, $content et $author de la class Parameter 
        * utilisée dans BackController
        */
        $sql = 'INSERT INTO chapters (title, content, created_at, user_id, image) 
                VALUES (?, ?, NOW(), ?, ?)';
        $this->createQuery($sql, [$post->get('title'), $post->get('content'), $userId, $pathImage ]);
    }


    public function editChapter(Parameter $post, $chapterId, $userId, $pathImage)
    {
        $sql = 'UPDATE chapters 
                SET title=:title, content=:content, user_id=:user_id, updated_at=NOW(), image=:pathImage 
                WHERE id=:chapterId';
        $this->createQuery($sql, [
            'title' => $post->get('title'),
            'content' => $post->get('content'),
            'user_id' => $userId,
            'chapterId' => $chapterId,
            'pathImage' => $pathImage
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