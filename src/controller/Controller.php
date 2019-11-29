<?php

namespace App\src\controller;

use App\config\Request;
use App\src\DAO\ChapterDAO;
use App\src\DAO\CommentDAO;
use App\src\model\View;

abstract class Controller
{
    protected $_chapterDAO;
    protected $_commentDAO;
    protected $_view;
    private $_request;
    protected $_get;
    protected $_post;
    protected $_session;

    public function __construct()
    {
        $this->_chapterDAO = new ChapterDAO();
        $this->_commentDAO = new CommentDAO();
        $this->_view = new View();
        $this->_request = new Request();
        $this->_get = $this->_request->getGet();
        $this->_post = $this->_request->getPost();
        $this->_session = $this->_request->getSession();
    }
    
}