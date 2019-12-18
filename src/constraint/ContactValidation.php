<?php

namespace App\src\constraint;
use App\config\Parameter;

class ContactValidation extends Validation
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
        if($name === 'name') {
            $error = $this->checkPseudo($name, $value);
            $this->addError($name, $error);
        }
        elseif ($name === 'title') {
            $error = $this->checkTitle($name, $value);
            $this->addError($name, $error);
        }
        elseif ($name === 'content') {
            $error = $this->checkContent($name, $value);
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
     * @param  string $name
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
            return $this->_constraint->notBlank('nom', $value);
        }
        if($this->_constraint->minLength($name, $value, 2)) {
            return $this->_constraint->minLength('nom', $value, 2);
        }
        if($this->_constraint->maxLength($name, $value, 255)) {
            return $this->_constraint->maxLength('nom', $value, 255);
        }
    }

    private function checkTitle($name, $value)
    {
        if($this->_constraint->notBlank($name, $value)) {
            return $this->_constraint->notBlank('titre', $value);
        }
        if($this->_constraint->minLength($name, $value, 2)) {
            return $this->_constraint->minLength('titre', $value, 2);
        }
        if($this->_constraint->maxLength($name, $value, 255)) {
            return $this->_constraint->maxLength('titre', $value, 255);
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
    private function checkContent($name, $value)
    {
        if($this->_constraint->notBlank($name, $value)) {
            return $this->_constraint->notBlank('contenu', $value);
        }
        if($this->_constraint->minLength($name, $value, 2)) {
            return $this->_constraint->minLength('contenu', $value, 2);
        }
    }

    /**
     * checkEmail
     *
     * @param  string $name
     * @param  mixed $value
     *
     * @return void
     */
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