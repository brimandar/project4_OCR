<?php

namespace App\config;
use App\src\controller\FrontController;
use App\src\controller\BackController;
use App\src\controller\ContactController;
use App\src\controller\RegisterController;
use App\src\controller\ErrorController;

class Router
{

    private $_frontController;
    private $_backController;
    private $_contactController;
    private $_registerController;
    private $_errorController;
    private $_request;

    public function __construct()
    {
        $this->_request = new Request();//load requests GET POST
        $this->_frontController = new FrontController();
        $this->_backController = new BackController();
        $this->_contactController = new ContactController();
        $this->_registerController = new RegisterController();
        $this->_errorController = new ErrorController();
    }
    public function run()
    {
        $route = $this->_request->getGet()->get('route');
        $user_id = $this->_request->getSession('username')->get('id');

        try{
            if(isset($route))
            {
                if($route === 'chapitre'){
                    $this->_frontController->chapter($this->_request->getGet()->get('chapterId'));
                }
                if($route === 'commentaires'){
                    $this->_frontController->comments($this->_request->getGet()->get('chapterId'), $this->_request->getGet()->get('lastId'));
                }
                elseif($route === 'allChapters'){
                    $this->_frontController->allChapters();
                }
                elseif($route === 'addChapter'){
                    $this->_backController->addChapter($this->_request->getPost(), $this->_request->getFile());
                }
                elseif ($route === 'editChapter'){
                    $this->_backController->editChapter($this->_request->getPost(), $this->_request->getGet()->get('chapterId'), $user_id,  $this->_request->getFile());
                }
                elseif ($route === 'deleteChapter'){
                    $this->_backController->deleteChapter($this->_request->getGet()->get('chapterId'));
                }
                elseif ($route === 'addComment'){
                    $this->_frontController->addComment($this->_request->getPost(), $this->_request->getGet()->get('chapterId'), $user_id);
                }
                elseif($route === 'flagComment'){
                    $this->_frontController->flagComment($this->_request->getGet()->get('commentId'));
                }
                elseif($route === 'unflagComment'){
                    $this->_backController->unflagComment($this->_request->getGet()->get('commentId'));
                }
                elseif($route === 'deleteComment'){
                    $this->_backController->deleteComment($this->_request->getGet()->get('commentId'));
                }
                elseif($route === 'addNews'){
                    $this->_backController->addNews($this->_request->getPost());
                }
                elseif ($route === 'editNews'){
                    $this->_backController->editNew($this->_request->getPost(), $this->_request->getGet()->get('newsId'));
                }
                elseif($route === 'deleteNews'){
                    $this->_backController->deleteNew($this->_request->getGet()->get('newsId'));
                }
                elseif($route === 'archives'){
                    $this->_frontController->newsByMonth($this->_request->getGet()->get('year'),$this->_request->getGet()->get('month'));
                }
                elseif($route === 'register'){
                    $this->_registerController->register($this->_request->getPost());
                }
                elseif($route === 'confirmation'){
                    $this->_registerController->confirmationEmail($this->_request->getGet()->get('code'));
                }
                elseif($route === 'login'){
                    $this->_frontController->login($this->_request->getPost());
                }
                elseif($route === 'profile'){
                    $this->_backController->profile($user_id);
                }
                elseif($route === 'updatePassword'){
                    $this->_backController->updatePassword($this->_request->getPost());
                }
                elseif($route === 'logout'){
                    $this->_backController->logout();
                }
                elseif($route === 'deleteAccount'){
                    $this->_backController->deleteAccount();
                }
                elseif($route === 'deleteUser'){
                    $this->_backController->deleteUser($this->_request->getGet()->get('userId'));
                }
                elseif($route === 'contact'){
                    $this->_contactController->contact($this->_request->getPost());
                }
                elseif($route === 'administration'){
                    $this->_backController->administration();
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