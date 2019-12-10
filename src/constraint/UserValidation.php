<?php

namespace App\src\constraint;
use App\config\Parameter;

class UserValidation extends Validation
{
    private $_errors = [];
    private $_constraint;

    public function __construct()
    {
        $this->_constraint = new Constraint();
    }

    /**
     * check all field of form
     *
     * @param  array $post
     *
     * @return array
     */
    public function check(Parameter $post)
    {
        foreach ($post->all() as $key => $value) {
            $this->checkField($key, $value);
        }
        return $this->_errors;
    }

    /**
     * check each Field (method used by check())
     *
     * @param  string $name
     * @param  mixed $value
     *
     * @return void
     */
    private function checkField($name, $value)
    {
        if($name === 'username') {
            $error = $this->checkPseudo($name, $value);
            $this->addError($name, $error);
        }
        elseif ($name === 'password') {
            $error = $this->checkPassword($name, $value);
            $this->addError($name, $error);
        }
        elseif ($name === 'email') {
            $error = $this->checkEmail($name, $value);
            $this->addError($name, $error);
        }
    }

    /**
     * add Error to the var _error
     *
     * @param  mixed $name
     * @param  mixed $error
     *
     * @return void
     */
    private function addError($name, $error) {
        if($error) {
            $this->_errors += [
                $name => $error
            ];
        }
    }

    /**
     * check validation constraints for Pseudo (method used by checkField())
     *
     * @param  string $name
     * @param  mixed $value
     *
     * @return void
     */
    private function checkPseudo($name, $value)
    {
        if($this->_constraint->notBlank($name, $value)) {
            return $this->_constraint->notBlank('username', $value);
        }
        if($this->_constraint->minLength($name, $value, 2)) {
            return $this->_constraint->minLength('username', $value, 2);
        }
        if($this->_constraint->maxLength($name, $value, 255)) {
            return $this->_constraint->maxLength('username', $value, 255);
        }
    }

    /**
     * check validation constraints for content (method used by checkField())
     *
     * @param  string $name
     * @param  mixed $value
     *
     * @return void
     */
    private function checkPassword($name, $value)
    {
        if($this->_constraint->notBlank($name, $value)) {
            return $this->_constraint->notBlank('password', $value);
        }
        if($this->_constraint->minLength($name, $value, 2)) {
            return $this->_constraint->minLength('password', $value, 2);
        }
        if($this->_constraint->maxLength($name, $value, 255)) {
            return $this->_constraint->maxLength('password', $value, 255);
        }
    }

    private function checkEmail($name, $value)
    {
        if($this->_constraint->notBlank($name, $value)) {
            return $this->_constraint->notBlank('email', $value);
        }
        if($this->_constraint->emailValidate($name, $value)) {
            return $this->_constraint->emailValidate('email', $value);
        }
    }
}