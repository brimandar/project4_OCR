<?php

namespace App\src\constraint;

use App\config\Parameter;

class ChapterValidation extends Validation
{
    private $_errors = [];
    private $_constraint;

    public function __construct()
    {
        $this->_constraint = new Constraint();
    }

    /**
     * retrieve all data of the Parameter class (method : all) and use the checkField method
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
     * check each field of form
     *
     * @param  mixed $name
     * @param  mixed $value
     *
     * @return void
     */
    private function checkField($name, $value)
    {
        if($name === 'title') {
            $error = $this->checkTitle($name, $value);
            $this->addError($name, $error);
        }
        elseif ($name === 'content') {
            $error = $this->checkContent($name, $value);
            $this->addError($name, $error);
        }
    }

    private function addError($name, $error) {
        if($error) {
            $this->_errors += [
                $name => $error
            ];
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