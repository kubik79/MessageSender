<?php

declare(strict_types=1);

namespace Controller;

use Exception\FileNotFoundException;
use Exception\FileUploadErrorException;
use Repository\UsersRepository;

class UploadClientsController
{
    private UsersRepository $usersRepository;

    public function __invoke(): void
    {
        $this->usersRepository = new UsersRepository();

        $file = $this->file_upload();
        $this->insertFileToDb($file);
    }

    private function file_upload(): string
    {
        $files = $_FILES;
        $uploadFolder = __DIR__ . '/../public/upload';

        $originalFilename = $files['file']['name'];
        $fileExtension = pathinfo($originalFilename, PATHINFO_EXTENSION);
        $fileNameWithoutExtension = pathinfo($originalFilename, PATHINFO_FILENAME);

        $uploadFilename = $fileNameWithoutExtension . '_' . time() . '.' . $fileExtension;

        if (!move_uploaded_file($files['file']['tmp_name'], $uploadFolder . '/' . $uploadFilename)) {
            throw new FileUploadErrorException();
        }

        return $uploadFolder . '/' . $uploadFilename;
    }

    private function insertFileToDb(string $file): void
    {
        if (!file_exists($file)) {
            throw new FileNotFoundException();
        }

        $fp = fopen($file, 'r');
        if ($fp !== false) {
            while (($data = fgetcsv($fp)) !== false) {
                if(is_string($data[0]) && is_string($data[1])) {
                    $number = trim($data[0]); #TODO Здесь должна быть проверка: номера телефона или какого-то другого
                    $name = trim($data[1]);

                    $this->usersRepository->addUser($number, $name);
                }
            }
        }
    }
}
