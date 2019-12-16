<?php

namespace App\src\model;

use App\config\Request;

class View
{
    private $_file;
    private $_request;
    private $_session;

    public function __construct()
    {
        $this->_request = new Request();
        $this->_session = $this->_request->getSession();
    }
    
    /**
     * Returns a page constructed from the base view
     *
     * @param  mixed template of the page
     * @param  mixed data used to feed the page
     *
     * @return page
     */
    public function render($template, $data = [], $title, int $nb_pages=NULL)
    {
        $this->_file = '../templates/'.$template.'.php';
        $content  = $this->renderFile($this->_file, $data, $nb_pages);
        $view = $this->renderFile('../templates/base.php', [
            'title' => $title,
            'content' => $content,
            'session' => $this->_session
        ], $nb_pages);
        echo $view;
    }

    private function renderFile($file, $data, $nb_pages=NULL)
    {
        if(file_exists($file)){
            extract($data);
            ob_start();
            require $file;
            return ob_get_clean();
        }
        header('Location: index.php?route=notFound');
    }
}