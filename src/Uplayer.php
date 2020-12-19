<?php

namespace Uplayer;

use Uplayer\Exception\Exception;
use Uplayer\Exception\NotFoundException;

class Uplayer
{
    /**
     * directory
     *
     * @var string
     */
    private $directory;

    /**
     * name
     *
     * @var mixed
     */
    private $name;

    /**
     * newName
     *
     * @var mixed
     */
    private $newName;

    /**
     * __construct
     *
     * @param string $directory
     * @return void
     */
    public function __construct(string $directory)
    {
        if (!$directory) {
            NotFoundException::fileNotFound("File not found", "Directory not found");
        }

        $this->directory = $directory;
    }

    /**
     * uploadFile
     *
     * @param string $name
     * @param array $format
     * @param bool $unique
     * @return null|bool
     */
    public function uploadFile(string $name, array $format = null, bool $unique = false): ?bool
    {
        if (isset($_FILES[$name]) && !empty($_FILES[$name]['name'])) {

            $file = $_FILES[$name];
            $this->name = $file['name'];

            $ext = explode(".", $this->name);
            $extFile = $ext[1];

            if (isset($format)) {
                if (!in_array($extFile, $format)) {
                    Exception::fileError("File format is different from the one informed");
                    return null;
                }
            }

            if ($unique == true) {
                $this->rename();

                if (!move_uploaded_file($file['tmp_name'], $this->directory . "/" . $this->newName)) {
                    Exception::fileError("File could not be uploaded");
                    return null;
                }
            } else {
                if (!move_uploaded_file($file['tmp_name'], $this->directory . "/" . $this->name)) {
                    Exception::fileError("File could not be uploaded");
                    return null;
                }
            }
        } else {
            NotFoundException::fileNotFound("File not found", "No files were sent");
            return null;
        }

        return true;
    }

    /**
     * uploadMultipleFiles
     *
     * @param string $name
     * @param array $format
     * @param bool $unique
     * @return null|bool
     */
    public function uploadMultipleFiles(string $name, array $format = null, bool $unique = false): ?bool
    {
        if (isset($_FILES[$name]) && !empty($_FILES[$name]['name'])) {

            $file = $_FILES[$name];
            $this->name = $file['name'];
            $countFiles = count($this->name);

            for ($i = 0; $i < $countFiles; $i++) {

                $ext = explode(".", $this->name[$i]);
                $extFile = $ext[1];

                if (isset($format)) {
                    if (!in_array($extFile, $format)) {
                        Exception::fileError("File format is different from the one informed");
                        return null;
                    }
                }

                if ($unique == true) {
                    $this->rename(true);

                    if (!move_uploaded_file($file['tmp_name'][$i], $this->directory . "/" . $this->newName)) {
                        Exception::fileError("Files could not be uploaded");
                        return null;
                    }
                } else {
                    if (!move_uploaded_file($file['tmp_name'][$i], $this->directory . "/" . $this->name[$i])) {
                        Exception::fileError("Files could not be uploaded");
                        return null;
                    }
                }
            }
        } else {
            NotFoundException::fileNotFound("File not found", "No files were sent");
            return null;
        }

        return true;
    }

    /**
     * rename
     *
     * @return Uplayer
     */
    private function rename(bool $i = false): Uplayer
    {
        if ($i = true) {
            $ext = explode('.', $this->name[$i]);
        } else {
            $ext = explode('.', $this->name);
        }

        $ext = end($ext);
        $this->newName = "IMG-" . date('dmY') . uniqid() . '.' . $ext;

        return $this;
    }
}
