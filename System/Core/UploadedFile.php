<?php

namespace Core;

class UploadedFile
{
    private $file = [];

    private $fileName;

    private $nameOnly;

    private $extension;

    private $mimeType;

    private $tempFile;

    private $size;

    private $error;

    private $imageExtensions = ['gif', 'jpeg', 'png', 'jpg'];

    private $filesExtensions = ['pdf'];

    /**
     * UploadedFile constructor.
     *
     * @param $input
     */
    public function __construct($input)
    {
        $this->getFileInfo($input);
    }

    private function getFileInfo($input)
    {
        if (empty($_FILES[$input])) {
            return;
        }

        $file = $_FILES[$input];
        $this->error = $file['error'];

        if ($this->error != UPLOAD_ERR_OK) {
            return;
        }

        $this->file = $file;
        $this->fileName = $this->file['name'];
        $fileNameInfo = pathinfo($this->fileName);
        $this->nameOnly = $fileNameInfo['basename'];
        $this->extension = strtolower($fileNameInfo['extension']);
        $this->mimeType = $this->file['type'];
        $this->tempFile = $this->file['tmp_name'];
        $this->size = $this->file['size'];
    }

    public function exists()
    {
        return ! empty($this->file);
    }

    public function checkErrors()
    {
        switch ($this->error) {
            case UPLOAD_ERR_INI_SIZE:
                $message = "حجم الملف اكبر من حجم الرفع المسموح به ";
                break;
            case UPLOAD_ERR_FORM_SIZE:
                $message = "حجم الملف اكبر من الحجم المسموح به في";
                break;
            case UPLOAD_ERR_PARTIAL:
                $message = "تم رفع الملف بشكل جزئي";
                break;
            case UPLOAD_ERR_NO_FILE:
                $message = "لم يتم رفع أي ملف";
                break;
            case UPLOAD_ERR_NO_TMP_DIR:
                $message = "المجلد المؤقت غير متوفر";
                break;
            case UPLOAD_ERR_CANT_WRITE:
                $message = "خطأ في كتابة الملف";
                break;
            case UPLOAD_ERR_EXTENSION:
                $message = "توقف رفع الملف بسبب خطأ";
                break;

            default:
                $message = "خطأ غير معروف";
                break;
        }

        return $message;
    }

    public function getFileName()
    {
        return $this->fileName;
    }

    public function getNameOnly()
    {
        return $this->nameOnly;
    }

    public function getExtension()
    {
        return $this->extension;
    }

    public function getMimeType()
    {
        return $this->mimeType;
    }

    public function isImage()
    {
        return strpos($this->mimeType, 'image/') === 0 && in_array($this->extension, $this->imageExtensions);
    }

    public function isPDF()
    {
        return strpos($this->mimeType, 'application/') === 0 && in_array($this->extension, $this->filesExtensions);
    }

    public function moveTo($target, $newFileName = null)
    {
        $filename = $newFileName ?: mt_rand();
        $filename .= '.'.$this->extension;
        if (! is_dir($target)) {
            mkdir($target, 0777, true);
        }
        $uploadFilePath = rtrim($target, '/').DIRECTORY_SEPARATOR.$filename;
        move_uploaded_file($this->tempFile, $uploadFilePath);

        return $filename;
    }
}