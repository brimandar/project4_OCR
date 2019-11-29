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

    public function __construct()
    {
        $this->_get = new Parameter($_GET);
        $this->_post = new Parameter($_POST);
        $this->_session = new Session($_SESSION);
    }

    /**
     * @return Parameter
     */
    public function getGet()
    {
        return $this->_get;
    }

    /**
     * @return mixed
     */
    public function getPost()
    {
        return $this->_post;
    }

    /**
     * @return mixed
     */
    public function getSession()
    {
        return $this->_session;
    }
}