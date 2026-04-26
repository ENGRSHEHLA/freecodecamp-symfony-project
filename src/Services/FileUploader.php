<?php

namespace App\Services;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploader
{
    private string $targetDirectory;

    public function __construct(string $targetDirectory)
    {
        $this->targetDirectory = $targetDirectory;
    }

    public function uploadFile(UploadedFile $file): string
    {
        if (!is_dir($this->targetDirectory)) {
            mkdir($this->targetDirectory, 0775, true);
        }

        $extension = $file->getClientOriginalExtension() ?: pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION) ?: 'bin';
        $filename = uniqid('', true) . '.' . $extension;

        $file->move($this->targetDirectory, $filename);

        return $filename;
    }
}
