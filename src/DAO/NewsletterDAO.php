<?php

namespace App\src\DAO;

use App\config\Parameter;
use App\src\model\Newsletter;

class NewsletterDAO extends DAO
{
    /**
     * Returns a table containing the list of news
     *
     * @return array
     */
    public function getNews()
    {
        $sql = 'SELECT * FROM news ORDER BY id DESC';
        $result = $this->createQuery($sql);
        $news = [];
        foreach ($result as $row){
            $newsId = $row['id'];
            $news[$newsId] = new Newsletter($row);
        }
        $result->closeCursor();
        return $news;
    }

    public function getNew($newsId)
    {
        $sql = 'SELECT * FROM news WHERE id = ?';
        $return = $this->createQuery($sql, [$newsId]);
        $data = $return->fetch();
        $news = new Newsletter($data);
        $return->closeCursor();
        return $news;
    }

    /**
     * add new
     *
     * @param  object data class Parameter
     *
     * @return void
     */
    public function addNew(Parameter $post)
    {
        $sql = 'INSERT INTO news (title, content, created_at) VALUES (?, ?, NOW())';
        $this->createQuery($sql, [$post->get('title'), $post->get('content')]);
    }


    /**
     * editNew
     *
     * @param  array $post
     * @param  int $newId
     *
     * @return void
     */
    public function editNew(Parameter $post, $newsId)
    {
        $sql = 'UPDATE news 
                SET title=:title, content=:content
                WHERE id=:newsId';
        $this->createQuery($sql, [
            'title' => $post->get('title'),
            'content' => $post->get('content'),
            'newsId' => $newsId
        ]);
    }

    /**
     * delete New
     *
     * @param  int $newId
     *
     * @return void
     */
    public function deleteNew($newsId)
    {
        $sql = 'DELETE FROM news WHERE id = ?';
        $this->createQuery($sql, [$newsId]);

    }

    public function getNewsByMonth(int $year, int $month)
    {
        // Query
        $sql = "SELECT * 
                FROM news
                WHERE YEAR(created_at) = ? and MONTH(created_at) = ?
                ORDER BY created_at DESC
                ";
        $result = $this->createQuery($sql, [$year, $month]);
        $chapters = [];
        foreach ($result as $row){
            $newId = $row['id'];
            $news[$newId] = new Newsletter($row);
        }
        $result->closeCursor();

        return $news;
    }
}

?>