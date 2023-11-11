<?php

namespace Uplayer;

use Uplayer\Exception\UplayerException;

class Uplayer
{
    /**
     * @var string
     */
    private string $name;

    /**
     * @var array
     */
    private array $names = [];

    /**
     * @var array
     */
    private array $formats = [];

    /**
     * @param string $directory
     * 
     * @return void
     * @throws UplayerException
     */
    public function __construct(
        private string $directory
    ) {
        if (!$directory) {
            throw new UplayerException("Directory not found");
        }
    }

    /**
     * @param string $name
     * @param array $formats
     * 
     * @return true
     * @throws UplayerException
     */
    public function uploadFile(string $name, array $formats = null): true
    {
        if (isset($_FILES[$name]) && !empty($_FILES[$name]['name'])) {
            $this->formats = $formats;
            $file = $_FILES[$name];
            $this->name = $file['name'];

            $this->rename($this->name);
            $this->moveUploadFile($file);

            return true;
        }

        throw new UplayerException("No files were sent");
    }

    /**
     * @param string $name
     * @param array $formats
     * 
     * @return true
     * @throws UplayerException
     */
    public function uploadMultipleFiles(string $name, array $formats = null): true
    {
        if (isset($_FILES[$name]) && !empty($_FILES[$name]['name'])) {

            $this->formats = $formats;

            foreach ($_FILES as $files) {
                $this->rename($files['full_path']);
                $this->moveUploadFile($files['tmp_name']);
            }

            return true;
        }

        throw new UplayerException("No files were sent");
    }

    /**
     * @param string|array $name
     * 
     * @return Uplayer
     */
    private function rename(string|array $name): Uplayer
    {
        if (is_array($name)) {
            foreach ($name as $name) {
                $ext = pathinfo($name, PATHINFO_EXTENSION);
                $this->validadeFormats($ext);

                $this->names[] = "FILE-" . date('Y-m-d') . "-" . uniqid() . '.' . $ext;
            }

            return $this;
        }

        $ext = pathinfo($name, PATHINFO_EXTENSION);
        $this->validadeFormats($ext);
        $this->name = "FILE-" . date('Y-m-d') . "-" . uniqid() . '.' . $ext;

        return $this;
    }

    /**
     * @param string|array $file
     * 
     * @return Uplayer
     * @throws UplayerException
     */
    private function moveUploadFile(string|array $file): Uplayer
    {
        if (!empty($this->names)) {
            foreach ($file as $key => $file_unique) {
                if (!move_uploaded_file($file_unique, $this->directory . DIRECTORY_SEPARATOR . $this->names[$key])) {
                    throw new UplayerException("File '" . $this->names[$key] . "' could not be uploaded");
                }
            }

            return $this;
        }

        if (!move_uploaded_file($file['tmp_name'], $this->directory . DIRECTORY_SEPARATOR . $this->name)) {
            throw new UplayerException("File '" . $this->name . "' could not be uploaded");
        }

        return $this;
    }

    /**
     * @param string $extension
     * 
     * @return Uplayer
     * @throws UplayerException
     */
    private function validadeFormats(string $extension): void
    {
        if (!in_array($extension, $this->formats)) {
            throw new UplayerException("Extension '" . $extension . "' not allowed for upload");
        }
    }
}
