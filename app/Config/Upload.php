<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Upload extends BaseConfig
{
    public $uploadsPath = WRITEPATH . 'uploads/';
    public $maxSize = 2048; // Maximum file size in kilobytes
    public $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
    public $fileChmod = 0644;
    public $directoryChmod = 0755;
}
