<?php

class FileUploadService
{
    private string $uploadPath;
    private int $maxFileSize;
    private array $allowedTypes;

    public function __construct()
    {
        $this->uploadPath = UPLOAD_PATH;
        $this->maxFileSize = MAX_FILE_SIZE;
        $this->allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
    }

    public function upload(array $file): ?string
    {
        // Si aucun fichier n'a été sélectionné, retourne null. Le Validator gérera la vérification 'required'.
        if (!isset($file['tmp_name']) || empty($file['tmp_name'])) {
            return null;
        }

        if ($file['error'] !== UPLOAD_ERR_OK) {
            throw new Exception(MessageEnum::ERROR_UPLOAD_GENERIC);
        }

        if ($file['size'] > $this->maxFileSize) {
            throw new Exception(MessageEnum::ERROR_UPLOAD_SIZE);
        }

        if (!in_array($file['type'], $this->allowedTypes)) {
            throw new Exception(MessageEnum::ERROR_UPLOAD_TYPE);
        }

        $fileName = uniqid() . '_' . $file['name'];
        $destination = $this->uploadPath . $fileName;

        if (!is_dir($this->uploadPath)) {
            mkdir($this->uploadPath, 0755, true);
        }

        if (move_uploaded_file($file['tmp_name'], $destination)) {
            return $fileName;
        }

        throw new Exception(MessageEnum::ERROR_UPLOAD_SAVE);
    }
}
