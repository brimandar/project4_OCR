<?php

namespace App\config;
/**
 * Load requets parameters of GET, POST and SESSION
 * Gère les paramètres en format objet des variables globales GET, POST et SESSION
 */

class Parameter
{
    private $parameter;

    public function __construct($parameter)
    {
        $this->parameter = $parameter;
    }

    public function get($name)
    {
        if(isset($this->parameter[$name]))
        {
            return $this->parameter[$name];
        }
    }
    
    public function set($name, $value)
    {
        $this->parameter[$name] = $value;
    }

}