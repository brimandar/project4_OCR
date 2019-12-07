<?php

namespace App\src\model;

class User
{
    private $_id;
    private $_pseudo;
    private $_username;
    private $_created_at;
    private $_role;

    public function __construct(array $donnees)
    {
        $this->hydrate($donnees);
    }

    /**
     * upload data (with UserDAO class)
     *
     * @param  array $donnees
     *
     * @return void
     */
    public function hydrate(array $donnees)
    {
        foreach ($donnees as $key => $value)
        {
            $method = 'set'.ucfirst($key);
        
            if (method_exists($this, $method))
            {
                $this->$method($value);
            }
        }
    }


// GETTERS

    public function getId() { return $this->_id; }
    public function getUsername() { return $this->_username; }
    public function getPassword() { return $this->_password; }
    public function getCreated_at() { return $this->_created_at; }
    public function getRole() { return $this->_role; }



// SETTERS

    public function setId(int $id)
    { 
        $this->_id = $id; 
    }

    public function setUsername(string $username)
    {
        $this->_username = $username;
    }

    public function setPassword($password)
    {
        $this->_password = $password;
    }

    public function setCreated_at($created_at)
    {
        $this->_created_at = $created_at;
    }

    public function setRole($role)
    {
        $this->_role = $role;
    }
}