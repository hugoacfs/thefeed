define([
    'jquery',
    'lodash',
    'bootstrap',
    'toggle'
], function ($, _) {
    $("body").tooltip({
        selector: '[data-toggle=tooltip]'
    });
    $('.carousel').carousel('pause');
    // prevents form re-submission
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
    //video
    function playVisibleVideos() {
        document.querySelectorAll("video").forEach(video => elementIsVisible(video) ? video.play() : video.pause());
    }
    function elementIsVisible(el) {
        let rect = el.getBoundingClientRect();
        return (rect.bottom >= 0 && rect.right >= 0 && rect.top <= (window.innerHeight || document.documentElement.clientHeight) && rect.left <= (window.innerWidth || document.documentElement.clientWidth));
    }
    let playVisibleVideosTimeout;
    window.addEventListener("scroll", () => {
        clearTimeout(playVisibleVideosTimeout);
        playVisibleVideosTimeout = setTimeout(playVisibleVideos, 100);
    });

    window.addEventListener("resize", playVisibleVideos);
    window.addEventListener("DOMContentLoaded", playVisibleVideos);
});