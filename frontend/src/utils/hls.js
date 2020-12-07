let has_hls = false;

export function initHls(cb) {
  if (!has_hls) {
    import(
      /* webpackChunkName: "hls" */
      "hls.js"
    ).then(({ default: _ }) => {
      has_hls = true;
      window.asakura.Hls = _;
      cb();
    });
  }
}

export function loadHls(id = "coverVideo") {
  const { Hls } = asakura;
  const video = document.getElementById(id);
  const video_src = video.getAttribute("data-src");
  if (Hls.isSupported()) {
    const hls = new Hls();
    hls.loadSource(video_src);
    hls.attachMedia(video);
    hls.on(Hls.Events.MANIFEST_PARSED, function () {
      video.play();
    });
  } else if (video.canPlayType("application/vnd.apple.mpegurl")) {
    video.src = video_src;
    video.addEventListener("loadedmetadata", function () {
      video.play();
    });
  }
}
