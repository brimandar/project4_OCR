<?php

namespace App\src\controller;

use App\config\Parameter;

class FrontController extends Controller
{
    /**
     * Returns the chapters page with the list of the chapters
     *
     * @return object
     */
    public function allChapters()
    {
        $chapters = $this->_chapterDAO->getChapters();
        return $this->_view->render(
            'allChapters', 
            ['chapters' => $chapters], 
            "Les chapitres"
        );//Generate view with dynamics datas
    }

    /**
     * The last chapter for home page
     *
     * @return void
     */
    public function home()
    {
        $chapter = $this->_chapterDAO->lastChapter();
        $news = $this->_newsletterDAO->getNews();
        //Select month archives
        $datesArchive = [];
        foreach ($news as $new) {
            $dateArchive[] = date('M, Y',strtotime ($new->getCreated_at()));
        }
        $monthsChapter = array_unique($dateArchive); //remove duplicate dates

        return $this->_view->render('home', [
            'chapter' => $chapter,
            'news' => $news,
            'monthsChapter' => $monthsChapter
        ], "Accueil" );//Generate view with dynamics datas
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
            'comments' => $comments,
        ], 'Chapitre');
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
            ], '');
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
            if(!$errors) {
                $this->_userDAO->register($post);
                $this->_session->set('register', 'Votre inscription a bien été effectuée');
                header('Location: ../public/index.php');
            }
            return $this->_view->render('register', [
                'post' => $post,
                'errors' => $errors
            ], 'Inscription');

        }
        // If form not completed, Go to the register view
        return $this->_view->render('register', [], 'Inscription');
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
                ], "Connection");
            }
        }
        return $this->_view->render('login',[],"Connection");
    }

    public function contact(Parameter $post)
    {
        if($post->get('submit')) 
        {
            $errors = $this->_validation->validate($post, 'contact');
            if(!$errors) 
            {           
                // Build POST request recaptcha:
                $recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
                $recaptcha_secret = '6LeDLcgUAAAAAM4OP_McMZpDo8z-WLIHU-bovJOE';
                $recaptcha_response = $post->get('recaptcha_response');
                // Make and decode POST request recaptcha:
                $recaptcha = file_get_contents($recaptcha_url . '?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response);
                $recaptcha = json_decode($recaptcha);
                var_dump($recaptcha);
                // Take action based on the score returned:
                if ($recaptcha->score >= 0.5) 
                {
                    // Pour envoyer un mail HTML, l'en-tête Content-type doit être défini
                    $headers[] = 'MIME-Version: 1.0';
                    $headers[] = 'Content-type: text/html; charset=iso-8859-1';
                    $headers[] = "From: " . $post->get('name') . "<" . $post->get('email') . ">\r\n";
                    $toEmail = "rudy.steffler@gmail.com";
                    $mailSubject = $post->get('title');
                    $mailBody = $post->get('content');
                    mail($toEmail, $mailSubject, $mailBody, implode("\r\n", $headers));
                }
            } else {
                return $this->_view->render('contact', [
                    'post' => $post,
                    'errors' => $errors
                ], 'Formulaire de contact');
            }
        }
        return $this->_view->render('contact', [], 'Formulaire de contact');
    }

    public function newsByMonth($year, $month)
    {
        $news = $this->_newsletterDAO->getNewsByMonth($year, $month);
        return $this->_view->render(
            'newsArchives', 
            ['news' => $news], 
            "Archives Newsletters"
        );//Generate view with dynamics datas
    }
}