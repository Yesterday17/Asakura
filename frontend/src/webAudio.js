export function web_audio() {
  if (mashiro_option.audio) {
    (window.AudioContext = window.AudioContext || window.webkitAudioContext),
      (function () {
        if (window.AudioContext) {
          var e = new AudioContext(),
            t = "880 987 1046 987 1046 1318 987 659 659 880 784 880 1046 784 659 659 698 659 698 1046 659 1046 1046 1046 987 698 698 987 987 880 987 1046 987 1046 1318 987 659 659 880 784 880 1046 784 659 698 1046 987 1046 1174 1174 1174 1046 1046 880 987 784 880 1046 1174 1318 1174 1318 1567 1046 987 1046 1318 1318 1174 784 784 880 1046 987 1174 1046 784 784 1396 1318 1174 659 1318 1046 1318 1760 1567 1567 1318 1174 1046 1046 1174 1046 1174 1567 1318 1318 1760 1567 1318 1174 1046 1046 1174 1046 1174 987 880 880 987 880".split(
              " "
            ), //天空之城
            i = 0,
            o = 1,
            a = "♪ ♩ ♫ ♬ ♭ € § ¶ ♯".split(" "),
            n = !1;
          $(
            "site-title, #mobileGoTop, .site-branding, .searchbox, .changeSkin-gear, .menu-list>li#star-bg"
          ).mouseenter(function (s) {
            var r = t[i];
            r || ((i = 0), (r = t[i])), (i += o);
            var c = e.createOscillator(),
              l = e.createGain();
            if (
              (c.connect(l),
              l.connect(e.destination),
              (c.type = "sine"),
              (c.frequency.value = r),
              l.gain.setValueAtTime(0, e.currentTime),
              l.gain.linearRampToValueAtTime(1, e.currentTime + 0.01),
              c.start(e.currentTime),
              l.gain.exponentialRampToValueAtTime(0.001, e.currentTime + 1),
              c.stop(e.currentTime + 1),
              (n = !0))
            ) {
              var d = Math.round(7 * Math.random()),
                u = $("<b/>").text(a[d]),
                h = s.pageX,
                p = s.pageY - 5;
              u.css({
                "z-index": 99999,
                top: p - 20,
                left: h,
                position: "absolute",
                color: "#FF6EB4",
              }),
                $body.append(u),
                u.animate(
                  {
                    top: p - 180,
                    opacity: 0,
                  },
                  1500,
                  function () {
                    u.remove();
                  }
                ),
                s.stopPropagation();
            }
            n = !1;
          });
        }
      })();
  }
}
