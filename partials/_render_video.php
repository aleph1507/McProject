<div class="video-wrapper">
    <div class="info">
        File ID: <?= $file->id; ?>
        <br> File webViewLink: <?= $file->webViewLink; ?>
        <br> Thumbnail: <?= $file->thumbnailLink ?>
    </div>
    <div class="preview">
        <video width="40%" src="<?= $file->webContentLink; ?>" controls></video>
    </div>
</div>
