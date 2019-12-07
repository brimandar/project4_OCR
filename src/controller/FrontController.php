<?php

namespace App\src\controller;

use App\config\Parameter;

class FrontController extends Controller
{
    /**
     * Returns the home page with the list of the chapters
     *
     * @return object
     */
    public function home()
    {
        $chapters = $this->_chapterDAO->getChapters();
        return $this->_view->render('home', ['chapters' => $chapters] );//Generate view with dynamics datas
    }

    /**
     * Returns the single page containing an article
     *
     * @param  mixed $chapterId
     *
     * @return object
     */
    public function chapter($chapterId)
    {
        $chapter = $this->_chapterDAO->getChapter($chapterId);
        $comments = $this->_commentDAO->getCommentsFromChapter($chapterId);
        return $this->_view->render('single', [
            'chapter' => $chapter,
            'comments' => $comments
            ]);
            // Return variables chapter et comments to the page
    }


    /**
     * add a comment to an chapter
     *
     * @param  array $post
     * @param  int $chapterId
     *
     * @return object
     */
    public function addComment(Parameter $post, $chapterId, $user_id)
    {
        $errors = $this->_validation->validate($post, 'Comment');

            if(!$errors) {
                $this->_commentDAO->addComment($post, $chapterId, $user_id);
                $this->_session->set('add_comment', 'Le nouveau commentaire a bien été ajouté');
                header('Location: ../public/index.php');
            }

            $chapter = $this->_chapterDAO->getChapter($chapterId);
            $comments = $this->_commentDAO->getCommentsFromChapter($chapterId);

            return $this->_view->render('single', [
                'chapter' => $chapter,
                'comments' => $comments,
                'post' => $post,
                'errors' => $errors
            ]);
    }


    /**
     * Report an inappropriate comment
     *
     * @param  int $commentId
     *
     * @return void
     */
    public function flagComment($commentId)
    {
        $this->_commentDAO->flagComment($commentId);
        $this->_session->set('flag_comment', 'Le commentaire a bien été signalé');
        header('Location: ../public/index.php');
    }


    /**
     * register an user
     *
     * @param  array $post
     *
     * @return void
     */
    public function register(Parameter $post)
    {
        // If we are on register view and submit the form
        if($post->get('submit')) {

            $errors = $this->_validation->validate($post, 'User');
            // check if pseudo is already used. If TRUE, return an error
            if($this->_userDAO->checkUser($post)) {
                $errors['username'] = $this->_userDAO->checkUser($post);
            }
            //  If errors is TRUE
            if(!$errors) {
                $this->_userDAO->register($post);
                $this->_session->set('register', 'Votre inscription a bien été effectuée');
                header('Location: ../public/index.php');
            }
            //  Else, return the page
            return $this->_view->render('register', [
                'post' => $post,
                'errors' => $errors
            ]);

        }
        // If form not completed, Go to the register view
        return $this->_view->render('register');
    }


    /**
     * login
     *
     * @param  array $post
     *
     * @return void
     */
    public function login(Parameter $post)
    {
        if($post->get('submit')) 
        {
            $result = $this->_userDAO->login($post);
            // Either the username and the password are valid, and we connect the user using the session system.
            if($result && $result['isPasswordValid']) 
            {
                $this->_session->set('login', 'Content de vous revoir');
                $this->_session->set('id', $result['result']['id']);
                $this->_session->set('role', $result['result']['role']);
                $this->_session->set('username', $post->get('username'));
                header('Location: ../public/index.php');
            // Either at least one of this information is incorrect, and we return to the login page with the associated message.
            } else {
                $this->_session->set('error_login', 'Le pseudo ou le mot de passe sont incorrects');
                return $this->_view->render('login', [
                    'post'=> $post
                ]);
            }
        }
        return $this->_view->render('login');
    }

}