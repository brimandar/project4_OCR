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
            header('Location: index.php?route=login');
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
            header('Location: index.php?route=profile');
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
            $news = $this->_newsletterDAO->getNews();
            
            return $this->_view->render('administration', [
                'chapters' => $chapters,
                'comments' => $comments,
                'users' => $users,
                'news' => $news
            ], 'Administration');
        }
    }
    
    /**
     * Add chapter (administrator only) with upload image
     *
     * @param  array $post
     *
     * @return void
     */
    public function addChapter(Parameter $post, Parameter $file)
    {
        if($this->checkAdmin()) 
        {
            if ($post->get('submit')) 
            {
                $errors = $this->_validation->validate($post, 'chapter');
                $errorImage = $this->_validation->validate($file->get('fileToUpload'), 'image');//manage image errors
                if(!$errors && !$errorImage) 
                {
                    if($file->get('fileToUpload')["name"] != ""){//if image load
                        $this->_upload->upload($file->get('fileToUpload')["name"], $file->get('fileToUpload')["tmp_name"], $file->get('fileToUpload')["size"]);
                    }
                    $this->_chapterDAO->addChapter($post, $this->_session->get('id'), $this->_upload->getPathImage());
                    $this->_session->set('add_chapter', 'Le nouveau chapitre a bien été ajouté');
                    header('Location: index.php?route=administration');
                }

                return $this->_view->render('add_chapter', [
                    'post' => $post,
                    'errors' => $errors,
                    'errorImage' => $errorImage,
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
    public function editChapter(Parameter $post, $chapterId, $userId, Parameter $file)
    {
        if($this->checkAdmin()) 
        {
            $chapter = $this->_chapterDAO->getChapter($chapterId);

            if($post->get('submit')) 
            {
                $errors = $this->_validation->validate($post, 'chapter');
                $errorImage = $this->_validation->validate($file->get('fileToUpload'), 'image');//manage image errors

                if(!$errors && !$errorImage) 
                {
                    if($file->get('fileToUpload')["name"] != ""){//if image load, save new image
                        $this->_upload->upload($file->get('fileToUpload')["name"], $file->get('fileToUpload')["tmp_name"], $file->get('fileToUpload')["size"]);
                        unlink($post->get('imageURL'));//Delete old image
                    }
                $this->_chapterDAO->editChapter($post, $chapterId, $userId, $this->_upload->getPathImage());
                header('Location: index.php?route=administration');
                }

                return $this->_view->render('edit_chapter', [
                    'post' => $post,
                    'errors' => $errors,
                    'errorImage' => $errorImage,
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
            $chapter = $this->_chapterDAO->getChapter($chapterId);
            unlink($chapter->getImage());//Delete image
            $this->_chapterDAO->deleteArticle($chapterId);
            header('Location: index.php?route=administration');
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
            header('Location: index.php');
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
            header('Location: index.php?route=administration');
        }
    }

    /**
     * view profile
     *
     * @return void
     */
    public function profile($user)
    {
        if($this->checkLoggedIn()) 
        {
            $comments = $this->_commentDAO->getMyComments($user);
            return $this->_view->render('profile',[
                'comments' => $comments,
            ],"Mon compte");
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
            if($post->get('submit')) 
            {
                $errors = $this->_validation->validate($post, 'User');
                if(!$errors) 
                {
                    // Update in database
                    $activationcode = $this->_userDAO->updatePassword($post, $this->_session->get('username'));
                    // Send email
                    $to = $post->get('email');
                    $subject ="Modification de votre mot de passe - blog Jean FORTEROCHE";
                    $headers = "MIME-Version: 1.0"."\r\n";
                            $headers .= 'Content-type: text/html; charset=UTF-8'."\r\n";
                            $headers .= 'From:Jean FORTEROCHE <' . EMAIL_FORM . '>'."\r\n";
                            
                    $ms ="
                    <html>
                    <body>
                        <div>
                            <p>Bonjour " . $post->get('username') . ",
                            </p><br>";
                    $ms.=
                            "<p>
                            Vous avez demandé la modification de votre mot de passe. Pour confirmer et réactiver votre inscription, merci de cliquer sur le lien suivant.
                            </p>
                            <p><a href='index.php?route=confirmation&code=" .$activationcode. "'>Cliquez pour réactiver votre compte</a>
                            </p>
                            <br>
                            <p> 
                            A très bientôt sur mon blog.<br>Jean FORTEROCHE
                            </p>
                        </div>
                    </body>
                    </html>";
                    mail($to,$subject,$ms,$headers);
                    // Deconnect
                    $this->_session->stop();
                    $this->_session->start();
                    $this->_session->set('update_password', 'Veuillez confirmer à nouveau votre identité en cliquant sur le lien dans le message qui vient d\'être envoyé');
                    // Return home page
                    header('Location: index.php');
                }
                return $this->_view->render('update_password', [
                    'post' => $post,
                    'errors' => $errors
                ], 'Modifier mon mot de passe');
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
        header('Location: index.php');
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
            header('Location: index.php?route=administration');
        }
    }

    /**
     * addNews
     *
     * @param  array $post
     *
     * @return void
     */
    public function addNews(Parameter $post)
    {
        if($this->checkAdmin()) 
        {
            if ($post->get('submit')) 
            {
                $errors = $this->_validation->validate($post, 'news');

                if(!$errors) 
                {
                    $this->_newsletterDAO->addNew($post, $this->_session->get('id'));
                    header('Location: index.php?route=administration');
                }

                return $this->_view->render('add_news', [
                    'post' => $post,
                    'errors' => $errors
                ],'Ajouter une newsletter');
            }
            return $this->_view->render('add_news',[],'Ajouter une newsletter');
        }
    }

    /**
     * editNew
     *
     * @param  array $post
     * @param  int $newsId
     *
     * @return void
     */
    public function editNew(Parameter $post, $newsId)
    {
        if($this->checkAdmin()) 
        {
            $news = $this->_newsletterDAO->getNew($newsId);
            if($post->get('submit')) 
            {
                $errors = $this->_validation->validate($post, 'news');
                if(!$errors) 
                {
                $this->_newsletterDAO->editNew($post, $newsId);
                header('Location: index.php?route=administration');
                }
                return $this->_view->render('edit_news', [
                    'post' => $post,
                    'errors' => $errors
                ], 'Editer une newsletter');
            }
            return $this->_view->render('edit_news', [
                'news' => $news
            ], 'Editer une newsletter');
        }
    }

    /**
     * deleteChapter
     *
     * @param  int $chapterId
     *
     * @return void
     */
    public function deleteNew($newsId)
    {
        if($this->checkAdmin()) 
        {
            $this->_newsletterDAO->deleteNew($newsId);
            header('Location: index.php?route=administration');
        }
    }


}