<?php

namespace App\src\controller;



class FrontController extends Controller
{
    /**
     * Returns the home page with the list of the chapters
     *
     * @return void
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
     * @return void
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

}