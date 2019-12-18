<?php

namespace App\src\model;

use App\config\Parameter;

class Upload 
{

    private $_targetFile;
    private $_imageFileType;

    public function upload(string $nameFile, string $tmpNameFile, int $sizeFile)
    {
        $this->_targetFile = DIR_UPLOAD . basename($nameFile);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($this->_targetFile,PATHINFO_EXTENSION));

        move_uploaded_file($tmpNameFile, $this->_targetFile);
    }

    public function getPathImage()
    {
        if(isset($this->_targetFile)){
            return $this->_targetFile;
        } else {
            return NULL;
        }
    }
}

