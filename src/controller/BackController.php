<?php

namespace App\src\controller;

use App\config\Parameter;

class BackController extends Controller
{
    /**
     * if the user is not connected, it is returned to the login page with a message telling him to connect
     * used by checkadmin()
     * 
     * @return void
     */
    private function checkLoggedIn()
    {
        if(!$this->_session->get('username')) {
            $this->_session->set('need_login', 'Vous devez vous connecter pour accéder à cette page');
            header('Location: ../public/index.php?route=login');
        } else {
            return true;
        }
    }

    /**
     * if the user is logged in, we will check his role: if he is not an administrator and 
     * tries to access a page that requests an administration role, a message will be displayed telling him 
     * that he has not the right to access this page.
     *
     * @return void
     */
    private function checkAdmin()
    {
        $this->checkLoggedIn();
        if(!($this->_session->get('role') === 'admin')) {
            $this->_session->set('not_admin', 'Vous n\'avez pas le droit d\'accéder à cette page');
            header('Location: ../public/index.php?route=profile');
        } else {
            return true;
        }
    }
    
    /**
     * access to administration view (administrator only)
     *
     * @return void
     */
    public function administration()
    {
        if($this->checkAdmin()) 
        {
            $chapters = $this->_chapterDAO->getChapters();
            $comments = $this->_commentDAO->getFlagComments();
            $users = $this->_userDAO->getUsers();
            
            return $this->_view->render('administration', [
                'chapters' => $chapters,
                'comments' => $comments,
                'users' => $users
            ], 'Administration');
        }
    }
    
    /**
     * Add chapter (administrator only)
     *
     * @param  array $post
     *
     * @return void
     */
    public function addChapter(Parameter $post)
    {
        if($this->checkAdmin()) 
        {
            if ($post->get('submit')) 
            {
                $errors = $this->_validation->validate($post, 'chapter');

                if(!$errors) 
                {
                    $this->_chapterDAO->addChapter($post, $this->_session->get('id'));
                    $this->_session->set('add_chapter', 'Le nouveau chapitre a bien été ajouté');
                    header('Location: ../public/index.php?route=administration');
                }

                return $this->_view->render('add_chapter', [
                    'post' => $post,
                    'errors' => $errors
                ],'Ajouter un chapitre');
            }
            return $this->_view->render('add_chapter',[],'Ajouter un chapitre');
        }
    }

    /**
     * Edit chapter (administrator only)
     *
     * @param  array $post
     * @param  int $chapterId
     *
     * @return void
     */
    public function editChapter(Parameter $post, $chapterId, $userId)
    {
        if($this->checkAdmin()) 
        {
            $chapter = $this->_chapterDAO->getChapter($chapterId);

            if($post->get('submit')) 
            {
                $errors = $this->_validation->validate($post, 'chapter');

                if(!$errors) 
                {
                $this->_chapterDAO->editChapter($post, $chapterId, $userId);
                $this->_session->set('edit_chapter', 'Le chapitre a bien été modifié');
                header('Location: ../public/index.php?route=administration');
                }

                return $this->_view->render('edit_chapter', [
                    'post' => $post,
                    'errors' => $errors
                ], 'Editer un chapitre');

            }

            return $this->_view->render('edit_chapter', [
                'chapter' => $chapter
            ], 'Editer un chapitre');
        }
    }

    /**
     * delete Chapter (administrator only)
     *
     * @param  int $chapterId
     *
     * @return void
     */
    public function deleteChapter($chapterId)
    {
        if($this->checkAdmin()) 
        {
            $this->_chapterDAO->deleteArticle($chapterId);
            $this->_session->set('delete_chapter', 'Le chapitre a bien été supprimé');
            header('Location: ../public/index.php?route=administration');
        }
    }

    /**
     * Delete a comment (administrator only)
     *
     * @param  int $commentId
     *
     * @return void
     */
    public function deleteComment($commentId)
    {
        if($this->checkLoggedIn()) 
        {
            $this->_commentDAO->deleteComment($commentId);
            $this->_session->set('delete_comment', 'Le commentaire a bien été supprimé');
            header('Location: ../public/index.php');
        }
    }

    /**
     * unflag a comment (administrator only)
     *
     * @param  int $commentId
     *
     * @return void
     */
    public function unflagComment($commentId)
    {
        if($this->checkAdmin()) 
        {
            $this->_commentDAO->unflagComment($commentId);
            $this->_session->set('unflag_comment', 'Le commentaire a bien été désignalé');
            header('Location: ../public/index.php?route=administration');
        }
    }

    /**
     * view profile
     *
     * @return void
     */
    public function profile()
    {
        if($this->checkLoggedIn()) 
        {
            return $this->_view->render('profile',[],"Mon compte");
        }
    }

    /**
     * update Password
     *
     * @param  array $post
     *
     * @return void
     */
    public function updatePassword(Parameter $post)
    {
        if($this->checkLoggedIn()) 
        {
            if($post->get('submit')) {
                $this->_userDAO->updatePassword($post, $this->_session->get('username'));
                $this->_session->set('update_password', 'Le mot de passe a été mis à jour');
                header('Location: ../public/index.php?route=profile');
            }
            return $this->_view->render('update_password',[],'Modifier mon mot de passe');
        }
    }

    /**
     * logout
     *
     * @return void
     */
    public function logout()
    {
        if($this->checkLoggedIn()) 
        {
            $this->logoutOrDelete('logout');
        }
    }

    /**
     * delete an account
     *
     * @return void
     */
    public function deleteAccount()
    {
        if($this->checkLoggedIn()) 
        {
            $this->_userDAO->deleteAccount($this->_session->get('username'));
            $this->logoutOrDelete('delete_account');
        }
    }

    /**
     * Used by logout() and deteAccount()
     *
     * @param  mixed $param
     *
     * @return void
     */
    private function logoutOrDelete($param)
    {
        $this->_session->stop();
        $this->_session->start();
        if($param === 'logout') {
            $this->_session->set($param, 'À bientôt');
        } else {
            $this->_session->set($param, 'Votre compte a bien été supprimé');
        }
        header('Location: ../public/index.php');
    }

    /**
     * delete an User (administrator only)
     *
     * @param  int $userId
     *
     * @return void
     */
    public function deleteUser($userId)
    {
        if($this->checkAdmin()) 
        {
            $this->_userDAO->deleteUser($userId);
            $this->_session->set('delete_user', 'L\'utilisateur a bien été supprimé');
            header('Location: ../public/index.php?route=administration');
        }
    }


}