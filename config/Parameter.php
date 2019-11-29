<?php

namespace App\config;
/**
 * Load requets parameters of GET and POST
 * Gère les paramètres en format objet des variables globales GET et POST
 */

class Parameter
{
    private $_parameter;

    public function __construct($parameter)
    {
        $this->_parameter = $parameter;
    }

    public function get($name)
    {
        if(isset($this->_parameter[$name]))
        {
            return $this->_parameter[$name];
        }
    }
    
    public function set($name, $value)
    {
        $this->_parameter[$name] = $value;
    }

    public function all()
    {
        return $this->_parameter;
    }

}