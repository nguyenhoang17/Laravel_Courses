var video = document.getElementById("video");
let live_key = document.getElementById("live_key").value;
console.log(live_key)
var videoSrc = "http://localhost:8088/hls/"+live_key+".m3u8";
if (Hls.isSupported()) {
    var hls = new Hls();
    hls.loadSource(videoSrc);
    hls.attachMedia(video);
}
else if (video.canPlayType("application/vnd.apple.mpegurl")) {
    video.src = videoSrc;
}
