<?php

namespace App\config;
/**
 * Load requets parameters of super variable GET, POST or SESSION
 * Gère les paramètres en format objet des variables globales GET, POST and SESSION
 */

class Parameter
{
    private $_parameter;

    public function __construct($parameter)
    {
        $this->_parameter = $parameter;
    }

    /**
     * get a parameter of super variable
     *
     * @param  mixed $name
     *
     * @return void
     */
    public function get($name)
    {
        if(isset($this->_parameter[$name]))
        {
            return $this->_parameter[$name];
        }
    }
    
    /**
     * set a parameter of super variable
     *
     * @param  mixed $name
     * @param  mixed $value
     *
     * @return void
     */
    public function set($name, $value)
    {
        $this->_parameter[$name] = $value;
    }

    /**
     * get all parameters of super variable
     *
     * @return void
     */
    public function all()
    {
        return $this->_parameter;
    }

}