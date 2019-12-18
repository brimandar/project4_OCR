<?php

namespace App\src\constraint;
use App\config\Parameter;

class ImageValidation extends Validation
{

    public function check($data)
    {
        if($data["size"] != "")
        {
            $nameFile = $data['name'];
            $tmpNameFile = $data["tmp_name"];
            $sizeFile = $data["size"];

            $targetFile = DIR_UPLOAD . basename($nameFile);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($targetFile,PATHINFO_EXTENSION));

            // Check if image file is a actual image or fake image
        
            $check = getimagesize($tmpNameFile);
            if($check === false) {
                return '<p>"Le fichier n\'est pas une image. Seul le chargement d\'une image est autorisé"</p>';
            }

            // Check if file already exists
            if (file_exists($targetFile)) {
                return '<p>"Une image portant le même nom existe déjà."</p>';
            }

            // Check file size
            if ($sizeFile > IMG_SIZE_MAX) {
                $sizeMo = IMG_SIZE_MAX / 1000000;
                $sizeKo = IMG_SIZE_MAX / 1000;
                return '<p>La taille d\'une image est limitée à ' . $sizeMo . ' Mo (ou ' . $sizeKo . ' Ko)</p>';
            }

            // Allow certain file formats
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif" ) {
                return '<p>"Sorry, only JPG, JPEG, PNG & GIF files are allowed."</p>';
            }
        }
    }
}