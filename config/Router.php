<?php

namespace App\config;
use App\src\controller\FrontController;
use App\src\controller\BackController;
use App\src\controller\ErrorController;

class Router
{

    private $_frontController;
    private $_backController;
    private $_errorController;
    private $_request;

    public function __construct()
    {
        $this->_request = new Request();//load requests GET POST
        $this->_frontController = new FrontController();
        $this->_backController = new BackController();
        $this->_errorController = new ErrorController();
    }
    public function run()
    {
        $route = $this->_request->getGet()->get('route');
        var_dump($route);

        try{
            if(isset($route))
            {
                if($route === 'chapitre'){
                    $this->_frontController->chapter($this->_request->getGet()->get('chapterId'));
                }
                elseif($route === 'addChapter'){
                    $this->_backController->addChapter($this->_request->getPost());
                }
                elseif ($route === 'editChapter'){
                    $this->_backController->editChapter($this->_request->getPost(), $this->_request->getGet()->get('chapterId'));
                }
                elseif ($route === 'deleteChapter'){
                    $this->_backController->deleteChapter($this->_request->getGet()->get('chapterId'));
                }
                elseif ($route === 'addComment'){
                    $this->_frontController->addComment($this->_request->getPost(), $this->_request->getGet()->get('chapterId'));
                }
                elseif($route === 'flagComment'){
                    $this->_frontController->flagComment($this->_request->getGet()->get('commentId'));
                }
                elseif($route === 'deleteComment'){
                    $this->_backController->deleteComment($this->_request->getGet()->get('commentId'));
                }
                else{
                    $this->_errorController->errorNotFound();
                }
            }
            else{
                $this->_frontController->home();
            }
        }
        catch (Exception $e)
        {
            $this->_errorController->errorServer();
        }
    }
}