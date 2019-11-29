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
        $this->_request = new Request();//load requests GET POST and SESSION
        $this->_frontController = new FrontController();
        $this->_backController = new BackController();
        $this->_errorController = new ErrorController();
    }
    public function run()
    {
        $route = $this->_request->getGet()->get('route');

        try{
            if(isset($route))
            {
                if($route === 'chapitre'){
                    $this->_frontController->chapter($this->_request->getGet()->get('chapterId'));
                }
                elseif($route === 'addChapter'){
                    $this->_backController->addChapter($this->_request->getPost());
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