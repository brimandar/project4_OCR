<?php

namespace App\src\model;

class Chapter
{
    private $_id;
    private $_title;
    private $_content;
    private $_created_at;
    private $_updated_at;
    private $_username;

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

    public function settitle(string $title)
    {
        $this->_title = $title;
    }

    public function setcontent(string $content)
    {
        $this->_content = $content;
    }

    public function setCreated_at($created_at)
    {
        $this->_created_at = $created_at;
    }

    public function setUpdated_at($updated_at)
    {
        $this->_updated_at = $updated_at;
    }

    public function setUsername($author)
    {
        $this->_author = $author;
    }

    //getters
    public function getId()
    {
        return $this->_id;
    }
    public function getTitle()
    {
        return $this->_title;
    }

    public function getContent()
    {
        return $this->_content;
    }

    public function getCreated_at()
    {
        return $this->_created_at;
    }

    public function getUpdated_at()
    {
        return $this->_updated_at;
    }

    public function getUsername()
    {
        return $this->_author;
    }

}