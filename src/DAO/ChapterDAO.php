<?php

namespace App\src\DAO;
use App\src\model\Chapter;
use App\config\Parameter;
use App\src\DAO\Pagination;

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
        //Pagination
        $this->_limit = 5;//max chapters per page
        $current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $this->_start = 0;//offset limit
        if($current_page > 1){
            $this->_start = ($current_page * $this->_limit) - $this->_limit;
        }
        //Query
        $sql = "SELECT chapters.id, chapters.title, chapters.content, users.username, chapters.created_at, chapters.updated_at 
                FROM chapters
                INNER JOIN users ON chapters.user_id = users.id
                ORDER BY id DESC
                LIMIT $this->_start, $this->_limit
        ";
        $result = $this->createQuery($sql);
        $chapters = [];
        foreach ($result as $row){
            $chapterId = $row['id'];
            $chapters[$chapterId] = new Chapter($row);
        }
        $result->closeCursor();
        //Pagination
        $this->_total = count($chapters);
        $stmt   = $this->createQuery("SELECT id FROM chapters");
        $this->_total = $stmt->rowCount();

        return $chapters;
 
    }

    public function getNbPages(){
        return ceil($this->_total / $this->_limit);//ceil function = return an integer
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