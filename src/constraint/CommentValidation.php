<?php

namespace App\src\constraint;

use App\config\Parameter;

class CommentValidation extends Validation
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
     * @param  object $post
     *
     * @return void
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
     * @param  mixed $name
     * @param  mixed $value
     *
     * @return void
     */
    private function checkField($name, $value)
    {
        if($name === 'pseudo') {
            $error = $this->checkPseudo($name, $value);
            $this->addError($name, $error);
        }
        elseif ($name === 'content') {
            $error = $this->checkContent($name, $value);
            $this->addError($name, $error);
        }
    }

    /**
     * add Error to the var _error
     *
     * @param  mixed $name
     * @param  mixed $error
     *
     * @return array
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
     * @param  mixed $name
     * @param  mixed $value
     *
     * @return object
     */
    private function checkPseudo($name, $value)
    {
        if($this->_constraint->notBlank($name, $value)) {
            return $this->_constraint->notBlank('pseudo', $value);
        }
        if($this->_constraint->minLength($name, $value, 2)) {
            return $this->_constraint->minLength('pseudo', $value, 2);
        }
        if($this->_constraint->maxLength($name, $value, 255)) {
            return $this->_constraint->maxLength('pseudo', $value, 255);
        }
    }

    /**
     * check validation constraints for content (method used by checkField())
     *
     * @param  mixed $name
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
}