<?php

require_once '../vendor/autoload.php';
require_once '../GoogleController.php';
require_once '../CloudConvertController.php';
require_once '../models/File.php';

class File_Upload
{
    private $googleCtrl;
    private $CCCtrl;
    private $file;

    public function __construct()
    {
        $this->googleCtrl = new GoogleController();
        $this->CCCtrl = new CloudConvertController();
        $this->file = new File($_FILES['video_file']['name'], $_FILES['video_file']['type'], $_FILES['video_file']['tmp_name'], $_FILES['video_file']['size']);
    }

    public function upload_file_to_cloudconvert()
    {
        $this->file = $this->CCCtrl->convert($this->file);
    }

    public function upload_file_to_drive()
    {
        return $this->googleCtrl->upload_file($this->file);
//        return isset($_FILES['video_file']) ?
//            $this->googleCtrl->upload_file($this->file) : null;
    }
}

$fu = new File_Upload();
//$fu->upload_file_to_cloudconvert();
//print_r($fu->upload_file_to_drive());
$thumbnail = 'https://drive.google.com/thumbnail?authuser=0&sz=w320&id=' . $fu->upload_file_to_drive()->id;
echo $thumbnail;
echo '<img src=\"' . $thumbnail . '\">';
////print_r($fu->upload_file_to_drive());

// https://drive.google.com/thumbnail?authuser=0&sz=w320&id=<GOOGLE_DRIVE_FILE_ID>
