<div class="video-wrapper">
    <div class="info">
        File ID: <?= $file->id; ?>
        <br> File webViewLink: <?= $file->webViewLink; ?>
        <br> Thumbnail: <?= $file->thumbnailLink ?>
    </div>
<!--    <div class="preview" data-src=" str_replace('/view', '/preview', $file->webContentLink); ?>">-->
    <div class="preview" data-src="<?= $file->webContentLink; ?>">
<!--        <video width="40%" src="< $file->webContentLink; ?>" controls></video>-->
<!--        <iframe target="_parent" class="video-embed" data-src="<//= $file->webViewLink; ?>" src="<//= str_replace('/view', '/preview', $file->webViewLink); ?>" frameborder="0"></iframe>-->
	<!--<iframe src="<= $file->webViewLink; ?>" frameborder="0"></iframe> -->
    </div>
</div>
