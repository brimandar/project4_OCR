<?php

namespace App\config;
/**
 * Load requets GET, POST and SESSION in object format
 * Classe Request pour gérer la requête utilisateur au format objet.
 */
class Request
{
    private $_get;
    private $_post;
    private $_session;
    private $_file;

    public function __construct()
    {
        $this->_get = new Parameter($_GET);
        $this->_post = new Parameter($_POST);
        $this->_session = new Session($_SESSION);
        $this->_file = new Parameter($_FILES);
    }


    /**
     * get super variable $_GET
     *
     * @return string
     */
    public function getGet()
    {
        return $this->_get;
    }

    /**
     * get super variable $_POST
     * 
     * @return string
     */
    public function getPost()
    {
        return $this->_post;
    }

    /**
     * get super variable $_SESSION
     * 
     * @return string
     */
    public function getSession()
    {
        return $this->_session;
    }

    /**
     * getFile
     *
     * @return array
     */
    public function getFile()
    {
        return $this->_file;
    }
}