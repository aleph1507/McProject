createDriveIframe = function(dataSrc) {
    let iframe = document.createElement('iframe');
    iframe.setAttribute('src', dataSrc);
    iframe.setAttribute('target', '_parent');
    iframe.setAttribute('frameborder', '0');
    iframe.setAttribute('class', 'video-embed');
    iframe.appendChild(document.createTextNode('Your browser does not support iframes.'));

    return iframe;
};

setIframesOnLoad = function(previewDivs) {
    // let previewDivs = document.getElementsByClassName('preview');

    console.log('setIframesOnLoad');
    console.log('previewDivs: ', previewDivs);
    for(let i = 0; i<previewDivs.length; i++) {
        console.log('previewDivs[i]: ', previewDivs[i], ' i: ' + i);
        previewDivs[i].appendChild(createDriveIframe(previewDivs[i].getAttribute('data-src')));
    }
    console.log('~setIframesOnLoad');
};

setTimeout(function() {
    setIframesOnLoad(document.getElementsByClassName('preview'));
}, 100);