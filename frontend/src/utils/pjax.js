import Pjax from "pjax";
import { initSerach } from "./search";

import NProgress from "nprogress";
import "../styles/nprogress.css";

function pjaxInit() {
  if (typeof window.EnlighterJSINIT === "function") {
    EnlighterJSINIT();
  }

  add_upload_tips();
  no_right_click();
  $("p").remove(".head-copyright");
  highlightCode();
  try {
    getqqinfo();
  } catch (e) {}
  new lazyload();
  $("#to-load-aplayer").click(function () {
    try {
      reloadHermit();
    } catch (e) {}
    $("div").remove(".load-aplayer");
  });
  if ($("div").hasClass("aplayer")) {
    try {
      reloadHermit();
    } catch (e) {}
  }
  $(".iconflat").css("width", "50px").css("height", "50px");
  $(".openNav").css("height", "50px");
  timeSeriesReload();
  tableOfContentScroll();
}

export function InitPJAX() {
  new Pjax({
    selectors: ["#page"],
    elements: [
      "a:not([target='_top']):not(.comment-reply-link)",
      ".search-form",
      ".s-search",
    ],
    timeout: 8000,
  });

  document.addEventListener("pjax:send", () => {
    //离开页面停止播放
    $(".normal-cover-video").each(function () {
      this.pause();
      this.src = "";
      this.load = "";
    });

    document.getElementById("bar").style.width = "0%";
    if (mashiro_option.nprogress_on) NProgress.start();

    if (document.body.classList.contains("navOpen")) {
      document.body.classList.toggle("navOpen");
      $("#main-container,#mo-nav,.openNav").toggleClass("open");
    }
  });

  document.addEventListener("pjax:complete", () => {
    Siren.AH();
    Siren.PE();
    initSerach();
    if (mashiro_option.nprogress_on) NProgress.done();
    pjaxInit();
    global.asakura.init_page(false);
    $("#loading").fadeOut(500);

    if (window.gtag) {
      gtag("config", mashiro_option.google_analytics_id, {
        page_path: window.location.pathname,
      });
    }

    if ($(".js-search.is-visible").length > 0) {
      $(".js-toggle-search").toggleClass("is-active");
      $(".js-search").toggleClass("is-visible");
      $("html").css("overflow-y", "unset");
    }
  });

  window.addEventListener(
    "popstate",
    () => {
      Siren.AH();
      Siren.PE();
      initSerach();
      timeSeriesReload(true);
      post_list_show_animation();
    },
    false
  );
}
