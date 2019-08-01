<?php
require_once 'vendor/autoload.php';

class GoogleController
{
    private $client;
    private $drive_service;

    public function __construct()
    {
        $this->client = new \Google_Client();
        $this->client->setApplicationName('McTube');
        putenv('GOOGLE_APPLICATION_CREDENTIALS=' . $this->getOAuthCredentialsFile());
        $this->client->useApplicationDefaultCredentials();
        $value = "hristo@digital-orange.com";
        $this->client->setSubject($value);
        $this->client->addScope("https://www.googleapis.com/auth/drive");
        $this->drive_service = new Google_Service_Drive($this->client);
    }

    public function getService()
    {
        return $this->drive_service;
    }

    function getOAuthCredentialsFile()
    {
        if (!file_exists('../gwcworld/ADC.json'))
            return null;

        return '../ADC.json';
    }

    public function add_domain_permissions($driveService, $fileId = 'root') {
        $domain_permission = new \Google_Service_Drive_Permission([
            'type' => 'domain',
            'role' => 'writer',
            'domain' => 'gwcworld.com'
        ]);
        try {
            $driveService->permissions->create($fileId, $domain_permission);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        return $domain_permission;
    }

    public function upload_file($name, $path, $service, $folder = 'root')
    {
        $service = $this->drive_service;
//        dd($folder);
        $fileMetadata = new \Google_Service_Drive_DriveFile(array(
            'name' => $name,
            'parents' => $folder
        ));
        $content = file_get_contents($path . $name);
        $file = $service->files->create($fileMetadata, array(
            'data' => $content,
            'mimeType' => 'video/*',
            'uploadType' => 'multipart',
            'fields' => 'id'
        ));
        return $file;
    }
}

$gc = new GoogleController();
$gc->add_domain_permissions($gc->getService(), 'root');
$gc->upload_file('orange.mp4', '../', $gc->getService());

