<?php

namespace App\config;
use App\src\controller\FrontController;
use App\src\controller\ErrorController;

class Router
{

    private $_frontController;

    public function __construct()
    {
        $this->_frontController = new FrontController();
        $this->_errorController = new ErrorController();
    }
    public function run()
    {
        try{
            if(isset($_GET['route']))
            {
                if($_GET['route'] === 'chapitre'){
                    $this->_frontController->chapter($_GET['chapterId']);
                }
                else{
                    echo 'page inconnue';
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