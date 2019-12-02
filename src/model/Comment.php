<?php

namespace App\src\model;

class Comment
{
    private $_id;
    private $_content;
    private $_chapter_id;
    private $_username;
    private $_created_at;
    private $_updated_at;
    private $_flag;


    public function __construct(array $donnees)
    {
        $this->hydrate($donnees);
    }

    public function hydrate(array $donnees)
    {
        foreach ($donnees as $key => $value)
        {
        // On récupère le nom du setter correspondant à l'attribut.
            $method = 'set'.ucfirst($key);
        
        // Si le setter correspondant existe.
            if (method_exists($this, $method))
            {
                // On appelle le setter.
                $this->$method($value);
            }
        }
    }

    //setters
    public function setId(int $id)
    {
        $this->_id = $id;
    }

    public function setContent(string $content)
    {
        $this->_content = $content;
    }

    public function setChapter_id(int $chapter_id)
    {
        $this->_chapter_id = $chapter_id;
    }

    public function setUsername(string $username)
    {
        $this->_username = $username;
    }

    public function setCreated_at($created_at)
    {
        $this->_created_at = $created_at;
    }

    public function setUpdated_at($updated_at)
    {
        $this->_updated_at = $updated_at;
    }

    public function setFlag($flag)
    {
        $this->_flag = $flag;
    }

    //getters
    public function getId() { return $this->_id; }
    public function getChapter_id() { return $this->_chapter_id; }
    public function getUsername() { return $this->_username; }
    public function getContent() { return $this->_content; }
    public function getCreated_at() { return $this->_created_at; }
    public function getUpdated_at() { return $this->_updated_at; }
    public function isFlag() { return $this->_flag; }

}