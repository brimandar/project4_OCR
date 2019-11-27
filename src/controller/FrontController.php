<?php

namespace App\src\controller;

use App\src\DAO\ChapterDAO;
use App\src\DAO\CommentDAO;

class FrontController
{
    private $_chapterDAO;
    private $_commentDAO;

    public function __construct()
    {
        $this->_chapterDAO = new ChapterDAO();
        $this->_commentDAO = new CommentDAO();
    }

    public function home()
    {
        $chapters = $this->_chapterDAO->getChapters();
        require '../templates/home.php';
    }

    public function chapter($chapterId)
    {
        $chapter = $this->_chapterDAO->getChapter($chapterId);
        $comments = $this->_commentDAO->getCommentsFromChapter($chapterId);
        require '../templates/single.php';
    }

}