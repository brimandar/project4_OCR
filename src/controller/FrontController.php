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
     * @param  mixed $post
     * @param  int $chapterId
     *
     * @return object
     */
    public function addComment(Parameter $post, $chapterId)
    {
        $errors = $this->_validation->validate($post, 'Comment');

            if(!$errors) {
                $this->_commentDAO->addComment($post, $chapterId);
                $this->_session->set('add_comment', 'Le nouveau commentaire a bien été ajouté');
                header('Location: ../public/index.php');
            }

            $article = $this->_chapterDAO->getArticle($chapterId);
            $comments = $this->_commentDAO->getCommentsFromArticle($chapterId);

            return $this->view->render('single', [
                'article' => $article,
                'comments' => $comments,
                'post' => $post,
                'errors' => $errors
            ]);
    }

}