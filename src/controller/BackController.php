<?php

namespace App\src\controller;

use App\config\Parameter;

class BackController extends Controller
{
    /**
     * Add chapter (administrator only)
     *
     * @param  mixed data forms
     *
     * @return mixed
     */
    public function addChapter(Parameter $post)
    {
        if ($post->get('submit')) {
            $this->_chapterDAO->addChapter($post);
            $this->_session->set('add_article', 'Le nouvel article a bien été ajouté');
            header('Location: ../public/index.php');
        }
        return $this->_view->render('add_chapter', [
            'post' => $post
        ]);
    }
}