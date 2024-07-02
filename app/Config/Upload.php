<?php
namespace Config;

use CodeIgniter\Config\BaseConfig;

class Upload extends BaseConfig
{
    // Maximum file size (in kilobytes)
    public $maxSize = 10240; // 10MB

    // Allowed file types
    public $allowedTypes = 'gif|jpg|jpeg|png';

    // Allowed file extensions to check against
    public $fileExtAllowed = ['gif', 'jpg', 'jpeg', 'png'];

    // Upload directory path
    public $uploadPath = WRITEPATH . 'uploads/';
    public $encryptName = true;
    public $maxWidth = 0;

    // Maximum height of uploaded images (for image files)
    public $maxHeight = 0;

    // Allowed MIME types (for stricter file type validation)
    public $allowedMimeTypes = [];

    // Whether to overwrite existing files with the same name
    public $overwrite = false;

    // Whether to enable file name randomization
    public $useRandomName = false;

}
