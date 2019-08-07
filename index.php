<?php
require_once 'vendor/autoload.php';
require_once 'GoogleController.php';

$gc = new GoogleController();

$files = $gc->list_files();
$nextPageToken = $files['nextPageToken'];
$files = $files['files'];
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>McVideo</title>
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>

<form action="upload/File_Upload.php" method="POST" enctype="multipart/form-data">
    <input type="file" name="video_file" value="Upload" accept="video/*,.3gp,.webm,.mov,.ogg,.flv,.mp4"><br>
    <input type="submit">
</form>
<br><hr><br>
<?php
foreach ($files as $file)
{
//    echo '<br>File ID: ' . $file->id . ' <br> File webViewLink: ' . $file->webViewLink . '<br> Thumbnail: ' . $file->thumbnailLink . '<hr>';
//    print_r($file);
    include 'partials/_render_video.php';
}
?>

<script src="js/script.js"></script>

</body>
</html>
