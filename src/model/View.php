<?php

namespace App\src\model;

class View
{
    private $_file;
    private $_title;
    
    /**
     * Returns a page constructed from the base view
     *
     * @param  mixed template of the page
     * @param  mixed data used to feed the page
     *
     * @return page
     */
    public function render($template, $data = [])
    {
        $this->_file = '../templates/'.$template.'.php';
        $content  = $this->renderFile($this->_file, $data);
        $view = $this->renderFile('../templates/base.php', [
            'title' => $this->_title,
            'content' => $content
        ]);
        echo $view;
    }

    private function renderFile($file, $data)
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