<?php

require_once 'models/File.php';

class GoogleController
{
    private $client;
    private $drive_service;
    private $token;
    private $pageToken;

    public function __construct()
    {
        try {
            putenv('GOOGLE_APPLICATION_CREDENTIALS=' . $this->getOAuthCredentialsFile());
            $this->setup_google_drive_client();
        } catch(Exception $e) {
            echo 'There has been an error: ' . $e->getMessage();
        }
    }

    private function setup_google_drive_client(string $impersonate = 'hristo@digital-orange.com')
    {
        $this->client = new \Google_Client();
        $this->client->setApplicationName('McTube');
        $this->client->useApplicationDefaultCredentials();
        $this->client->setSubject($impersonate);
        $this->client->addScope("https://www.googleapis.com/auth/drive");
        $this->drive_service = new Google_Service_Drive($this->client);
    }

    public function getService()
    {
        return $this->drive_service;
    }

    function getOAuthCredentialsFile(string $filepath = __DIR__ . '/../gwcworld/ADC.json')
    {
        if (!file_exists($filepath))
            throw new \Exception('no file: ' . $filepath);

        return $filepath;
    }

    public function add_domain_permissions($driveService, $fileId = 'root') {
        $domain_permission = new \Google_Service_Drive_Permission([
            'type' => 'anyone',
            'role' => 'reader',
//            'domain' => 'gwcworld.com'
        ]);
        try {
            $driveService->permissions->create($fileId, $domain_permission);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        return $domain_permission;
    }

//    public function upload_file($name, $path, $service, $folder, $name_on_drive = '')
    public function upload_file(File $file, $folder = '1T2rgFxsIOfCZnsH_eIwudMcNfWrC059i')
    {
//        if ($file->name === '') $name_on_drive = date("d/m/Y H:i:s") . '_' . $name;
//        $this->drive_service = $this->drive_service;
        $fileMetadata = new \Google_Service_Drive_DriveFile(array(
            'name' => date("d/m/Y H:i:s") . '_' . $file->getName(),
            'parents' => array($folder)
        ));
        $content = file_get_contents($file->getPath());
        $file = $this->drive_service->files->create($fileMetadata, array(
            'data' => $content,
            'mimeType' => 'video/*',
            'uploadType' => 'multipart',
            'fields' => 'id, webViewLink, thumbnailLink, thumbnailVersion'
        ));
        $this->add_domain_permissions($this->getService(), $file->id);
        return $file;
    }

//    public function list_files(string $folder = '1T2rgFxsIOfCZnsH_eIwudMcNfWrC059i', $pageToken = null)
    public function list_files(array $opts = ['folder' => '1T2rgFxsIOfCZnsH_eIwudMcNfWrC059i', 'pageToken' => null])
    {
        $optParams = array(
            'pageSize' => 10,
//            'fields' => "nextPageToken, files(contentHints/thumbnail,fileExtension,iconLink,id,name,size,thumbnailLink,webContentLink,webViewLink,mimeType,parents)",
            'fields' => "nextPageToken, files(contentHints/thumbnail,fileExtension,iconLink,id,name,size,thumbnailLink,webContentLink,webViewLink,mimeType,parents)",
            'pageToken' => $opts['pageToken'],
            'q' => "'". $opts['folder'] ."' in parents"
        );

        $files = null;

        try {
            $files = $this->drive_service->files->listFiles($optParams);
            $this->pageToken = $files['nextPageToken'];
        } catch(Google_Exception $goog_e) {
            echo 'List Files Exception: ' . $goog_e->getMessage();
        } catch(Exception $e) {
            echo 'List Files Regular Exception: ' . $e->getMessage();
        }

        return $files;
    }
}