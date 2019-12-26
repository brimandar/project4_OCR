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
        if ($datesArchive){
        $monthsChapter = array_unique($dateArchive); //remove duplicate dates
        } else {$monthsChapter='';}
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
            if($result && $result['isPasswordValid'] && $result['status'] == 1) 
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

    /**
     * Home page : news By Month (article on the right of the screen )
     *
     * @param  mixed $year
     * @param  mixed $month
     *
     * @return void
     */
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