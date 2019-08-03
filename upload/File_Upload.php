<?php

require_once '../vendor/autoload.php';
require_once '../GoogleController.php';
require_once '../models/File.php';

class File_Upload
{
    private $googleCtrl;

    public function __construct()
    {
        $this->googleCtrl = new GoogleController();
    }

    public function upload_file_to_drive()
    {
        return isset($_FILES['video_file']) ?
            $this->googleCtrl->upload_file(
                new File($_FILES['video_file']['name'], $_FILES['video_file']['type'], $_FILES['video_file']['tmp_name'], $_FILES['video_file']['size']))
            : null;
    }
}

$fu = new File_Upload();
$fu->upload_file_to_drive();