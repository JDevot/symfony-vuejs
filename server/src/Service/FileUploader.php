<?php
// src/Service/FileUploader.php
namespace App\Service;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploader
{
    private $targetDirectory;

    public function __construct($targetDirectory)
    {
        $this->targetDirectory = $targetDirectory;
    }


    public function uploadBase64($base64)
    {
        $allowedMimeTypes = ['image/png', 'image/jpeg'];
        
        if(in_array(mime_content_type($base64), $allowedMimeTypes)){
            $fileExtension = explode('/', mime_content_type($base64))[1];
            $fileName = uniqid();
            $image = explode(',', $base64);
            $data = base64_decode($image[1]);
            file_put_contents($this->getTargetDirectory()."/".$fileName.".".$fileExtension, $data);
            return $fileName;
        }
    }

    public function getTargetDirectory()
    {
        return $this->targetDirectory;
    }
}