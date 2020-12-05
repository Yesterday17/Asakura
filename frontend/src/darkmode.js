export function changeTheme(dark, save) {
  const sc = document.querySelector(".site-content");
  const pl = document.querySelector("#preload");
  if (dark) {
    document.body.style.background = "#31363b";
    sc && (sc.style.backgroundColor = "#fff");
    pl && (pl.style.backgroundColor = "#31363b");
    document.body.classList.add("dark");
    if (save) {
      localStorage.setItem("dark", "1");
    }
  } else {
    document.body.style.background = "unset";
    sc && (sc.style.backgroundColor = "rgba(255, 255, 255, .8)");
    pl && (pl.style.backgroundColor = "#fff");
    document.body.classList.remove("dark");
    document.body.style.backgroundImage =
      mashiro_option.skin_bg === "none" ? "" : `url(${mashiro_option.skin_bg})`;
    if (save) {
      localStorage.setItem("dark", "0");
    }
  }
}

export function checkDarkMode(setTimer = true) {
  let dark = localStorage.getItem("dark");

  // no dark session
  if (!dark && mashiro_option.dark_mode) {
    // default auto
    dark = "auto";
    localStorage.setItem("dark", dark);
  }

  if (dark === "1") {
    // dark mode
    changeTheme(true, true);
  } else if (dark === "0") {
    // light mode
    changeTheme(false, true);
  } else if (dark === "auto") {
    // auto mode
    function auto_switch_theme() {
      // recheck dark
      if (localStorage.getItem("dark") !== "auto") return;

      const now = new Date();
      changeTheme(now.getHours() > 21 || now.getHours() < 7, false);

      if (setTimer) {
        setTimeout(auto_switch_theme, 5 * 60 * 1000); // check every 5 minutes
      }
    }

    auto_switch_theme();
  }
}
