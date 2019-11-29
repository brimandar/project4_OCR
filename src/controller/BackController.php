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
        if ($post->get('submit')) 
        {
            $errors = $this->_validation->validate($post, 'chapter');

            if(!$errors) 
            {
                $this->_chapterDAO->addChapter($post);
                $this->_session->set('add_chapter', 'Le nouveau chapitre a bien été ajouté');
                header('Location: ../public/index.php');
            }

            return $this->_view->render('add_chapter', [
                'post' => $post,
                'errors' => $errors
            ]);
        }

        return $this->_view->render('add_chapter');
    }

    /**
     * Edit chapter (administrator only)
     *
     * @param  mixed $post
     * @param  mixed $chapterId
     *
     * @return void
     */
    public function editChapter(Parameter $post, $chapterId)
    {
        $chapter = $this->_chapterDAO->getChapter($chapterId);

        if($post->get('submit')) 
        {
            $errors = $this->_validation->validate($post, 'chapter');

            if(!$errors) 
            {
            $this->_chapterDAO->editChapter($post, $chapterId);
            $this->_session->set('edit_chapter', 'Le chapitre a bien été modifié');
            header('Location: ../public/index.php');
            }

            return $this->_view->render('edit_chapter', [
                'post' => $post,
                'errors' => $errors
            ]);

        }

        return $this->_view->render('edit_chapter', [
            'chapter' => $chapter
        ]);

    }
}