import APlayer from "aplayer";
import "aplayer/dist/APlayer.min.css";
import "../styles/aplayer-fix.css";

import { doAfterDOMLoaded } from "./utils";

const aplayers = [];

function initPlayer(container, songs) {
  const options = {
    container: container,
    audio: songs,
    mini: null,
    fixed: null,
    autoplay: !1,
    mutex: !0,
    lrcType: 3,
    listFolded: 1,
    preload: "auto",
    theme: "#2980b9",
    loop: "all",
    order: "list",
    volume: null,
    listMaxHeight: null,
    customAudioType: null,
    storageName: "metingjs",
  };
  if (songs.length) {
    if (songs[0].lrc) {
      options.lrcType = 0;
    }

    const initOptions = {};
    for (const key in options) {
      const keyLower = key.toLowerCase();
      if (
        container.dataset.hasOwnProperty(key) ||
        container.dataset.hasOwnProperty(keyLower) ||
        options[key] !== null
      ) {
        initOptions[key] =
          container.dataset[keyLower] || container.dataset[key] || options[key];
        if (initOptions[key] === "true" || initOptions[key] === "false") {
          initOptions[key] = initOptions[key] == "true";
        }
      }
    }

    const player = new APlayer(initOptions);
    // try hide lrc
    player.lrc?.hide();

    let lrcTag = false;
    if (container.classList.contains("aplayer-fixed")) {
      container.addEventListener("click", () => {
        if (!lrcTag) {
          player.lrc?.show();
          lrcTag = true;
        }
      });

      container.querySelector(".aplayer-body")?.classList.add("ap-hover");
    }

    aplayers.push(player);
  }
}

function loadAllPlayers() {
  const defaultUrl = `${mashiro_option.meting_api_url}?server=:server&type=:type&id=:id&_wpnonce=${mashiro_option.nonce}`;

  // destroy players
  aplayers.forEach((p) => {
    try {
      p.destroy();
    } catch (e) {
      console.log(e);
    }
  });

  // remove all previous players
  aplayers.splice(0, aplayers.length);

  Promise.all(
    Array.from(document.querySelectorAll(".aplayer")).map(async (player) => {
      if (player.dataset.id) {
        const api = (player.dataset.api || defaultUrl)
          .replace(":server", player.dataset.server)
          .replace(":type", player.dataset.type)
          .replace(":id", player.dataset.id);
        const r = await fetch(api);
        const i = await r.json();
        initPlayer(player, i);
      } else if (player.dataset.url) {
        const songs = [
          {
            name: player.dataset.name || player.dataset.title || "Audio name",
            artist:
              player.dataset.artist || player.dataset.author || "Audio artist",
            url: player.dataset.url,
            cover: player.dataset.cover || player.dataset.pic,
            lrc: player.dataset.lrc,
            type: player.dataset.type || "auto",
          },
        ];
        initPlayer(player, songs);
      }
    })
  ).then(() => {
    document.querySelectorAll(".aplayer-miniswitcher").forEach((p) => {
      p.addEventListener("click", () => {
        // .aplayer.aplayer-fixed
        if (p.parentElement.parentElement.classList.contains("aplayer-fixed")) {
          // .aplayer-body
          p.parentElement.classList.toggle("ap-hover");
        }

        // toggle widgets
        document.querySelector("#secondary")?.classList.toggle("active");
      });
    });
  });
}

export function loadAPlayer() {
  doAfterDOMLoaded(() => loadAllPlayers());
}
