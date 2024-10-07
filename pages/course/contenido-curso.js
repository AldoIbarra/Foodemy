document.addEventListener('DOMContentLoaded', function () {
    const videoPlayer = document.getElementById('videoPlayer');
    const videoTitle = document.getElementById('videoTitle');
    const videoItems = document.querySelectorAll('.video-item');

    videoItems.forEach(item => {
        item.addEventListener('click', function () {
            const videoSrc = this.getAttribute('data-video');
            const videoName = this.getAttribute('data-title');
            
            videoPlayer.src = videoSrc;
            videoPlayer.play();
            videoTitle.textContent = videoName;
        });
    });
});
