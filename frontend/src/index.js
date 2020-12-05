import $ from "jquery";
import "jquery-pjax";

import "lightgallery.js";
import "lightgallery.js/dist/css/lightgallery.css";
import "./styles/lightgallery-fix.css";

import APlayer from "aplayer";
import "aplayer/dist/APlayer.min.css";
import "./styles/aplayer-fix.css";

import lazyload from "lazyload";
import ClipboardJS from "clipboard";
import tocbot from "tocbot";

import NProgress from "nprogress";
import "./styles/nprogress.css";

import { changeTheme, checkDarkMode } from "./darkmode";
import { web_audio } from "./webAudio";
import { loadCSS } from "./utils/loadcss";
import { get_gravatar } from "./utils/gravatar";

import "font-awesome/css/font-awesome.css";
import "font-awesome-animation/dist/font-awesome-animation.css";

import hljs from "highlight.js/lib/core";
// import hljs from "highlight.js";
import hljs_linenumber from "./utils/highlightjs-line-numbers.js";
hljs_linenumber(window, document, hljs);

import { initHls, loadHls } from "./utils/hls";

global.asakura = {
  changeTheme,
  scrollTo: aScrollTo,
};

var $body = $("body");

if (!window.mashiro_global) {
  window.mashiro_global = {
    variables: {
      has_hls: false,
      bgn: 1,
    },
    ini: {
      normalize: () => {
        // initial functions when page first load (首次加载页面时的初始化函数)
        new lazyload();
        post_list_show_animation();
        copy_code_block();
        web_audio();
        coverVideoIni();
        scrollBar();
        load_bangumi();
      },
      pjax: () => {
        // pjax reload functions (pjax 重载函数)
        pjaxInit();
        post_list_show_animation();
        copy_code_block();
        web_audio();
        coverVideoIni();
        load_bangumi();
      },
    },
    font_control: {
      change_font: () => {
        if ($body.hasClass("serif")) {
          $body.removeClass("serif");
          $(".control-btn-serif").removeClass("selected");
          $(".control-btn-sans-serif").addClass("selected");
          localStorage.setItem("font_family", "sans-serif");
        } else {
          $body.addClass("serif");
          $(".control-btn-serif").addClass("selected");
          $(".control-btn-sans-serif").removeClass("selected");
          localStorage.setItem("font_family", "serif");
        }
      },
      init: () => {
        const f = localStorage.getItem("font_family");
        if (document.body.clientWidth > 860) {
          if (!f || f === "serif") {
            $body.addClass("serif");
          }
        }
        if (f === "sans-serif") {
          $body.removeClass("sans-serif");
          $(".control-btn-serif").removeClass("selected");
          $(".control-btn-sans-serif").addClass("selected");
        }
      },
    },
  };
}

mashiro_global.font_control.init();

function post_list_show_animation() {
  if ($("article").hasClass("post-list-thumb")) {
    var options = {
      root: null,
      threshold: [0.66],
    };
    var io = new IntersectionObserver(callback, options);
    var articles = document.querySelectorAll(".post-list-thumb");

    function callback(entries) {
      entries.forEach((article) => {
        if (!window.IntersectionObserver) {
          article.target.style.willChange = "auto";
          if (article.target.classList.contains("post-list-show") === false) {
            article.target.classList.add("post-list-show");
          }
        } else {
          if (article.target.classList.contains("post-list-show")) {
            article.target.style.willChange = "auto";
            io.unobserve(article.target);
          } else {
            if (article.isIntersecting) {
              article.target.classList.add("post-list-show");
              article.target.style.willChange = "auto";
              io.unobserve(article.target);
            }
          }
        }
      });
    }

    articles.forEach((article) => {
      io.observe(article);
    });
  }
}

function social_share_limit() {
  if ($(".top-social").length > 0 || $(".top-social_v2").length > 0) {
    var a;
    $(".top-social").length > 0
      ? (a = $(".top-social li"))
      : (a = $(".top-social_v2 li"));
    for (var i = a.length - 2; i >= 11; i--) {
      a[i].remove();
    }
    if (document.body.clientWidth <= 860) {
      for (var i = a.length - 2; i >= 10; i--) {
        a[i].remove();
      }
    }
    if (document.body.clientWidth <= 425) {
      for (var i = a.length - 2; i >= 5; i--) {
        a[i].remove();
      }
    }
  }
}

// social_share_limit();

function code_highlight_style() {
  var attributes = {
    autocomplete: "off",
    autocorrect: "off",
    autocapitalize: "off",
    spellcheck: "false",
    contenteditable: "false",
    design: "by Mashiro",
  };

  function gen_top_bar(p) {
    for (const key in attributes) {
      if (attributes.hasOwnProperty(key)) {
        p.setAttribute(key, attributes[key]);
      }
    }
    p.classList.add("highlight-wrap");
    // p.querySelector("code")?.attr("data-rel", lang.toUpperCase());
  }

  $("pre code").each(function (i, block) {
    hljs.highlightBlock(block);
  });

  document
    .querySelectorAll("pre.wp-block-syntaxhighlighter-code")
    .forEach((block) => {
      block.classList.remove("wp-block-syntaxhighlighter-code");
      const code = document.createElement("code");
      code.textContent = block.textContent;
      block.textContent = "";
      block.appendChild(code);
      hljs.highlightBlock(code);
    });

  document
    .querySelectorAll("pre code")
    .forEach((c) => gen_top_bar(c.parentElement));

  hljs.initLineNumbersOnLoad({ singleLine: true });
  $("pre").on("click", function (e) {
    if (e.target !== this) return;
    $(this).toggleClass("code-block-fullscreen");
    $("html").toggleClass("code-block-fullscreen-html-scroll");
  });
}

$body.on("click", ".comment-reply-link", function () {
  addComment.moveForm(
    "comment-" + $(this).attr("data-commentid"),
    $(this).attr("data-commentid"),
    "respond",
    $(this).attr("data-postid")
  );
  return false;
});

function attach_image() {
  var cached = $(".insert-image-tips");
  $("#upload-img-file").change(function () {
    if (this.files.length > 10) {
      addComment.createButterbar(
        "每次上传上限为10张.<br>10 files max per request."
      );
      return 0;
    }
    for (i = 0; i < this.files.length; i++) {
      if (this.files[i].size >= 5242880) {
        alert(
          "图片上传大小限制为5 MB.\n5 MB max per file.\n\n「" +
            this.files[i].name +
            "」\n\n这张图太大啦~\nThis image is too large~"
        );
      }
    }
    for (var i = 0; i < this.files.length; i++) {
      var f = this.files[i];
      var formData = new FormData();
      formData.append("cmt_img_file", f);
      $.ajax({
        url:
          mashiro_option.api +
          "asakura/v1/image/upload?_wpnonce=" +
          mashiro_option.nonce,
        type: "POST",
        processData: false,
        contentType: false,
        data: formData,
        beforeSend: function (xhr) {
          cached.html(
            '<i class="fa fa-spinner rotating" aria-hidden="true"></i>'
          );
          addComment.createButterbar("上传中...<br>Uploading...");
        },
        success: function (res) {
          cached.html('<i class="fa fa-check" aria-hidden="true"></i>');
          setTimeout(function () {
            cached.html('<i class="fa fa-picture-o" aria-hidden="true"></i>');
          }, 1000);
          if (res.status === 200) {
            var get_the_url = res.proxy;
            $("#upload-img-show").append(
              '<img class="lazyload upload-image-preview" src="https://cdn.jsdelivr.net/gh/Fuukei/Public_Repository@latest/vision/theme/sakura/load/inload.svg" data-src="' +
                get_the_url +
                '" onclick="window.open(\'' +
                get_the_url +
                '\')" onerror="imgError(this)" />'
            );
            new lazyload();
            addComment.createButterbar(
              "图片上传成功~<br>Uploaded successfully~"
            );
            grin(get_the_url, "Img");
          } else {
            addComment.createButterbar(
              "上传失败！<br>Uploaded failed!<br> 文件名/Filename: " +
                f.name +
                "<br>code: " +
                res.status +
                "<br>" +
                res.message,
              3000
            );
          }
        },
        error: function (jqXHR, textStatus, errorThrown) {
          cached.html(
            '<i class="fa fa-times" aria-hidden="true" style="color:red"></i>'
          );
          alert("上传失败，请重试.\nUpload failed, please try again.");
          setTimeout(function () {
            cached.html('<i class="fa fa-picture-o" aria-hidden="true"></i>');
          }, 1000);
          // console.info(jqXHR.responseText);
          // console.info(jqXHR.status);
          // console.info(jqXHR.readyState);
          // console.info(jqXHR.statusText);
          // console.info(textStatus);
          // console.info(errorThrown);
        },
      });
    }
  });
}

function clean_upload_images() {
  $("#upload-img-show").html("");
}

function add_upload_tips() {
  $(
    '<div class="insert-image-tips popup"><i class="fa fa-picture-o" aria-hidden="true"></i><span class="insert-img-popuptext" id="uploadTipPopup">上传图片</span></div><input id="upload-img-file" type="file" accept="image/*" multiple="multiple" class="insert-image-button">'
  ).insertAfter($(".form-submit #submit"));
  attach_image();
  $("#upload-img-file").hover(
    function () {
      $(".insert-image-tips").addClass("insert-image-tips-hover");
      $("#uploadTipPopup").addClass("show");
    },
    function () {
      $(".insert-image-tips").removeClass("insert-image-tips-hover");
      $("#uploadTipPopup").removeClass("show");
    }
  );
}

function click_to_view_image() {
  $(".comment_inline_img").click(function () {
    var temp_url = this.src;
    window.open(temp_url);
  });
}

click_to_view_image();

function showPopup(ele) {
  var popup = ele.querySelector("#thePopup");
  popup.classList.toggle("show");
}

function cmt_showPopup(ele) {
  var popup = $(ele).find("#thePopup");
  popup.addClass("show");
  $(ele)
    .find("input")
    .blur(function () {
      popup.removeClass("show");
    });
}

function scrollBar() {
  if (document.body.clientWidth > 860) {
    $(window).scroll(function () {
      var s = $(window).scrollTop(),
        a = $(document).height(),
        b = $(window).height(),
        result = parseInt((s / (a - b)) * 100),
        cached = $("#bar");
      cached.css("width", result + "%");
      if (false) {
        if (result >= 0 && result <= 19) cached.css("background", "#cccccc");
        if (result >= 20 && result <= 39) cached.css("background", "#50bcb6");
        if (result >= 40 && result <= 59) cached.css("background", "#85c440");
        if (result >= 60 && result <= 79) cached.css("background", "#f2b63c");
        if (result >= 80 && result <= 99) cached.css("background", "#FF0000");
        if (result == 100) cached.css("background", "#5aaadb");
      } else {
        cached.css("background", "orange");
      }
      $(".toc-container").css("height", $(".site-content").outerHeight());
      $(".skin-menu").removeClass("show");
    });
  }
}

checkDarkMode();

function no_right_click() {
  $(".post-thumb img").bind("contextmenu", function (e) {
    return false;
  });
}

no_right_click();

$(document).ready(function () {
  function cover_bg() {
    if (document.body.clientWidth < 860 && mashiro_option.cover_beta) {
      $(".centerbg").css(
        "background-image",
        "url(" + mashiro_option.cover_api + "?type=mobile" + ")"
      );
    } else {
      $(".centerbg").css(
        "background-image",
        "url(" + mashiro_option.cover_api + ")"
      );
    }
  }

  cover_bg();

  function closeSkinMenu() {
    $(".skin-menu").removeClass("show");
    setTimeout(function () {
      $(".changeSkin-gear").css("visibility", "visible");
    }, 300);
  }

  $("#changeSkin").click(function () {
    $(".skin-menu").toggleClass("show");
  });
  $(".skin-menu #close-skinMenu").click(function () {
    closeSkinMenu();
  });
  add_upload_tips();
});

function bg_update() {
  if (document.body.clientWidth < 860 && mashiro_option.cover_beta) {
    $(".centerbg").css(
      "background-image",
      "url(" +
        mashiro_option.cover_api +
        "?type=mobile&" +
        mashiro_global.variables.bgn +
        ")"
    );
  } else {
    $(".centerbg").css(
      "background-image",
      "url(" +
        mashiro_option.cover_api +
        "?" +
        mashiro_global.variables.bgn +
        ")"
    );
  }
}

function nextBG() {
  bg_update();
  mashiro_global.variables.bgn++;
}

function preBG() {
  mashiro_global.variables.bgn--;
  bg_update();
}

$(document).ready(function () {
  $("#bg-next").click(function () {
    nextBG();
  });
  $("#bg-pre").click(function () {
    preBG();
  });
});

function aScrollTo(top) {
  window.scrollTo({ top, behavior: "smooth" });
}

function timeSeriesReload(flag) {
  const cached = $("#archives");
  if (flag) {
    cached.find("span.al_mon").click(function () {
      $(this).next().slideToggle(400);
      return false;
    });
    new lazyload();
  } else {
    (function () {
      $("#al_expand_collapse,#archives span.al_mon").css({
        cursor: "s-resize",
      });
      cached.find("span.al_mon").each(function () {
        var num = $(this).next().children("li").length;
        $(this).children("#post-num").text(num);
      });
      var $al_post_list = cached.find("ul.al_post_list"),
        $al_post_list_f = cached.find("ul.al_post_list:first");
      $al_post_list.hide(1, function () {
        $al_post_list_f.show();
      });
      cached.find("span.al_mon").click(function () {
        $(this).next().slideToggle(400);
        return false;
      });
      if (document.body.clientWidth > 860) {
        cached.find("li.al_li").mouseover(function () {
          $(this).children(".al_post_list").show(400);
          return false;
        });
      }
      let al_expand_collapse_click = 0;
      $("#al_expand_collapse").click(function () {
        if (al_expand_collapse_click === 0) {
          $al_post_list.each(function (index) {
            var $this = $(this),
              s = setTimeout(function () {
                $this.show(400);
              }, 50 * index);
          });
          al_expand_collapse_click++;
        } else if (al_expand_collapse_click === 1) {
          $al_post_list.each(function (index) {
            var $this = $(this),
              h = setTimeout(function () {
                $this.hide(400);
              }, 50 * index);
          });
          al_expand_collapse_click--;
        }
      });
    })();
  }
}

timeSeriesReload();

/*视频feature*/
function coverVideo() {
  var video = document.getElementById("coverVideo");
  var btn = document.getElementById("coverVideo-btn");

  if (video.paused) {
    video.play();
    try {
      btn.innerHTML = '<i class="fa fa-pause" aria-hidden="true"></i>';
    } catch (e) {}
    //console.info('play:coverVideo()');
  } else {
    video.pause();
    try {
      btn.innerHTML = '<i class="fa fa-play" aria-hidden="true"></i>';
    } catch (e) {}
    //console.info('pause:coverVideo()');
  }
}

function coverVideoIni() {
  if ($("video").hasClass("hls")) {
    initHls(() => loadHls());
  }
}

function copy_code_block() {
  $("pre code").each(function (i, block) {
    $(block).attr({
      id: "hljs-" + i,
    });
    $(this).after(
      '<a class="copy-code" href="javascript:" data-clipboard-target="#hljs-' +
        i +
        '" title="拷贝代码"><i class="fa fa-clipboard" aria-hidden="true"></i></a>'
    );
  });
  var clipboard = new ClipboardJS(".copy-code");
}

function tableOfContentScroll() {
  if (document.querySelector(".have-toc")) {
    let id = 1,
      heading_fix;
    if (mashiro_option.entry_content_theme === "sakura") {
      if ($("article").hasClass("type-post")) {
        if ($("div").hasClass("pattern-attachment-img")) {
          heading_fix = -75;
        } else {
          heading_fix = 200;
        }
      } else {
        heading_fix = 375;
      }
      heading_fix += 80;
      heading_fix -= window.innerHeight / 2;
    }

    document.querySelectorAll(".entry-content, .links").forEach((el) => {
      el.querySelectorAll("h1, h2, h3, h4, h5, h6").forEach(
        (e) => (e.id = `toc-head-${id++}`)
      );
    });

    tocbot.init({
      tocSelector: ".toc",
      contentSelector: [".entry-content", ".links"],
      headingSelector: "h1, h2, h3, h4, h5, h6",
      headingsOffset: heading_fix,
    });
  } else {
    document.querySelector(".toc-container")?.remove();
  }
}

tableOfContentScroll();

var pjaxInit = function () {
  add_upload_tips();
  no_right_click();
  click_to_view_image();
  mashiro_global.font_control.init();
  $("p").remove(".head-copyright");
  try {
    code_highlight_style();
  } catch (e) {}
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
  $("#bg-next").click(function () {
    nextBG();
  });
  $("#bg-pre").click(function () {
    preBG();
  });
  timeSeriesReload();
  add_copyright();
  tableOfContentScroll();
};
$(document).on("click", ".sm", function () {
  var msg = "您真的要设为私密吗？";
  if (confirm(msg) == true) {
    $(this).commentPrivate();
  } else {
    alert("已取消");
  }
});
$.fn.commentPrivate = function () {
  if ($(this).hasClass("private_now")) {
    alert("您之前已设过私密评论");
    return false;
  } else {
    $(this).addClass("private_now");
    var idp = $(this).data("idp"),
      actionp = $(this).data("actionp"),
      rateHolderp = $(this).children(".has_set_private");
    var ajax_data = {
      action: "siren_private",
      p_id: idp,
      p_action: actionp,
    };
    $.post("/wp-admin/admin-ajax.php", ajax_data, function (data) {
      $(rateHolderp).html(data);
    });
    return false;
  }
};

$(".comt-addsmilies").click(function () {
  $(".comt-smilies").toggle();
});
$(".comt-smilies a").click(function () {
  $(this).parent().hide();
});

function grin(tag, type, before, after) {
  var myField;
  if (type === "custom") {
    tag = before + tag + after;
  } else if (type === "Img") {
    tag = "[img]" + tag + "[/img]";
  } else if (type === "Math") {
    tag = " {{" + tag + "}} ";
  } else if (type === "tieba") {
    tag = " ::" + tag + ":: ";
  } else {
    tag = " :" + tag + ": ";
  }
  if (
    document.getElementById("comment") &&
    document.getElementById("comment").type == "textarea"
  ) {
    myField = document.getElementById("comment");
  } else {
    return false;
  }
  if (document.selection) {
    myField.focus();
    var sel = document.selection.createRange();
    sel.text = tag;
    myField.focus();
  } else if (myField.selectionStart || myField.selectionStart == "0") {
    var startPos = myField.selectionStart;
    var endPos = myField.selectionEnd;
    var cursorPos = endPos;
    myField.value =
      myField.value.substring(0, startPos) +
      tag +
      myField.value.substring(endPos, myField.value.length);
    cursorPos += tag.length;
    myField.focus();
    myField.selectionStart = cursorPos;
    myField.selectionEnd = cursorPos;
  } else {
    myField.value += tag;
    myField.focus();
  }
}

function add_copyright() {
  document.body.addEventListener("copy", function (e) {
    if (
      window.getSelection().toString().length > 30 &&
      mashiro_option.clipboard_copyright
    ) {
      setClipboardText(e);
    }
    addComment.createButterbar(
      "复制成功！<br>Copied to clipboard successfully!",
      1000
    );
  });

  function setClipboardText(event) {
    event.preventDefault();
    var htmlData =
      "# 商业转载请联系作者获得授权，非商业转载请注明出处。<br>" +
      "# For commercial use, please contact the author for authorization. For non-commercial use, please indicate the source.<br>" +
      "# 协议(License)：署名-非商业性使用-相同方式共享 4.0 国际 (CC BY-NC-SA 4.0)<br>" +
      "# 作者(Author)：" +
      mashiro_option.author_name +
      "<br>" +
      "# 链接(URL)：" +
      window.location.href +
      "<br>" +
      "# 来源(Source)：" +
      mashiro_option.site_name +
      "<br><br>" +
      window.getSelection().toString().replace(/\r\n/g, "<br>");
    var textData =
      "# 商业转载请联系作者获得授权，非商业转载请注明出处。\n" +
      "# For commercial use, please contact the author for authorization. For non-commercial use, please indicate the source.\n" +
      "# 协议(License)：署名-非商业性使用-相同方式共享 4.0 国际 (CC BY-NC-SA 4.0)\n" +
      "# 作者(Author)：" +
      mashiro_option.author_name +
      "\n" +
      "# 链接(URL)：" +
      window.location.href +
      "\n" +
      "# 来源(Source)：" +
      mashiro_option.site_name +
      "\n\n" +
      window.getSelection().toString().replace(/\r\n/g, "\n");
    if (event.clipboardData) {
      event.clipboardData.setData("text/html", htmlData);
      event.clipboardData.setData("text/plain", textData);
    } else if (window.clipboardData) {
      return window.clipboardData.setData("text", textData);
    }
  }
}

add_copyright();
$(function () {
  getqqinfo();
});

if (mashiro_option.float_player_on) {
  function aplayerF() {
    "use strict";
    var aplayers = [],
      loadMeting = function () {
        function a(a, b) {
          var c = {
            container: a,
            audio: b,
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
          if (b.length) {
            b[0].lrc || (c.lrcType = 0);
            var d = {};
            for (var e in c) {
              var f = e.toLowerCase();
              (a.dataset.hasOwnProperty(f) ||
                a.dataset.hasOwnProperty(e) ||
                null !== c[e]) &&
                ((d[e] = a.dataset[f] || a.dataset[e] || c[e]),
                ("true" === d[e] || "false" === d[e]) &&
                  (d[e] = "true" == d[e]));
            }
            aplayers.push(new APlayer(d));
          }
          for (var f = 0; f < aplayers.length; f++)
            try {
              aplayers[f].lrc.hide();
            } catch (a) {
              console.log(a);
            }
          var lrcTag = 1;
          $(".aplayer.aplayer-fixed").click(function () {
            if (lrcTag == 1) {
              for (var f = 0; f < aplayers.length; f++)
                try {
                  aplayers[f].lrc.show();
                } catch (a) {
                  console.log(a);
                }
            }
            lrcTag = 2;
          });
          var apSwitchTag = 0;
          $(".aplayer.aplayer-fixed .aplayer-body").addClass("ap-hover");
          $(".aplayer-miniswitcher").click(function () {
            if (apSwitchTag == 0) {
              $(".aplayer.aplayer-fixed .aplayer-body").removeClass("ap-hover");
              $("#secondary").addClass("active");
              apSwitchTag = 1;
            } else {
              $(".aplayer.aplayer-fixed .aplayer-body").addClass("ap-hover");
              $("#secondary").removeClass("active");
              apSwitchTag = 0;
            }
          });
        }

        var b =
          mashiro_option.meting_api_url +
          "?server=:server&type=:type&id=:id&_wpnonce=" +
          mashiro_option.nonce;
        "undefined" != typeof meting_api && (b = meting_api);
        for (var f = 0; f < aplayers.length; f++)
          try {
            aplayers[f].destroy();
          } catch (a) {
            console.log(a);
          }
        aplayers = [];
        for (
          var c = document.querySelectorAll(".aplayer"),
            d = function () {
              var d = c[e],
                f = d.dataset.id;
              if (f) {
                var g = d.dataset.api || b;
                (g = g.replace(":server", d.dataset.server)),
                  (g = g.replace(":type", d.dataset.type)),
                  (g = g.replace(":id", d.dataset.id));
                var h = new XMLHttpRequest();
                (h.onreadystatechange = function () {
                  if (
                    4 === h.readyState &&
                    ((200 <= h.status && 300 > h.status) || 304 === h.status)
                  ) {
                    var b = JSON.parse(h.responseText);
                    a(d, b);
                  }
                }),
                  h.open("get", g, !0),
                  h.send(null);
              } else if (d.dataset.url) {
                var i = [
                  {
                    name: d.dataset.name || d.dataset.title || "Audio name",
                    artist:
                      d.dataset.artist || d.dataset.author || "Audio artist",
                    url: d.dataset.url,
                    cover: d.dataset.cover || d.dataset.pic,
                    lrc: d.dataset.lrc,
                    type: d.dataset.type || "auto",
                  },
                ];
                a(d, i);
              }
            },
            e = 0;
          e < c.length;
          e++
        )
          d();
      };
    document.addEventListener("DOMContentLoaded", loadMeting, !1);
  }

  if (document.body.clientWidth > 860) {
    aplayerF();
  }
}

function getqqinfo() {
  var is_get_by_qq = false,
    cached = $("input");
  if (
    !localStorage.getItem("user_qq") &&
    !localStorage.getItem("user_qq_email") &&
    !localStorage.getItem("user_author")
  ) {
    cached.filter("#qq,#author,#email,#url").val("");
  }
  if (
    localStorage.getItem("user_avatar") &&
    localStorage.getItem("user_qq") &&
    localStorage.getItem("user_qq_email")
  ) {
    $("div.comment-user-avatar img").attr(
      "src",
      localStorage.getItem("user_avatar")
    );
    cached.filter("#author").val(localStorage.getItem("user_author"));
    cached.filter("#email").val(localStorage.getItem("user_qq") + "@qq.com");
    cached.filter("#qq").val(localStorage.getItem("user_qq"));
    if (mashiro_option.qzone_autocomplete) {
      cached
        .filter("#url")
        .val("https://user.qzone.qq.com/" + localStorage.getItem("user_qq"));
    }
    if (cached.filter("#qq").val()) {
      $(".qq-check").css("display", "block");
      $(".gravatar-check").css("display", "none");
    }
  }
  var emailAddressFlag = cached.filter("#email").val();
  cached.filter("#author").on("blur", function () {
    var qq = cached.filter("#author").val(),
      $reg = /^[1-9]\d{4,9}$/;
    if ($reg.test(qq)) {
      $.ajax({
        type: "get",
        url:
          mashiro_option.qq_api_url +
          "?qq=" +
          qq +
          "&_wpnonce=" +
          mashiro_option.nonce,
        dataType: "json",
        success: function (data) {
          cached.filter("#author").val(data.name);
          cached.filter("#email").val($.trim(qq) + "@qq.com");
          if (mashiro_option.qzone_autocomplete) {
            cached
              .filter("#url")
              .val("https://user.qzone.qq.com/" + $.trim(qq));
          }
          $("div.comment-user-avatar img").attr(
            "src",
            "https://q2.qlogo.cn/headimg_dl?dst_uin=" + qq + "&spec=100"
          );
          is_get_by_qq = true;
          cached.filter("#qq").val($.trim(qq));
          if (cached.filter("#qq").val()) {
            $(".qq-check").css("display", "block");
            $(".gravatar-check").css("display", "none");
          }
          localStorage.setItem("user_author", data.name);
          localStorage.setItem("user_qq", qq);
          localStorage.setItem("is_user_qq", "yes");
          localStorage.setItem("user_qq_email", qq + "@qq.com");
          localStorage.setItem("user_email", qq + "@qq.com");
          emailAddressFlag = cached.filter("#email").val();
          /***/
          $("div.comment-user-avatar img").attr("src", data.avatar);
          localStorage.setItem("user_avatar", data.avatar);
        },
        error: function () {
          cached.filter("#qq").val("");
          $(".qq-check").css("display", "none");
          $(".gravatar-check").css("display", "block");
          $("div.comment-user-avatar img").attr(
            "src",
            get_gravatar(cached.filter("#email").val())
          );
          localStorage.setItem("user_qq", "");
          localStorage.setItem("user_email", cached.filter("#email").val());
          localStorage.setItem(
            "user_avatar",
            get_gravatar(cached.filter("#email").val())
          );
          /***/
          cached.filter("#qq,#email,#url").val("");
          if (!cached.filter("#qq").val()) {
            $(".qq-check").css("display", "none");
            $(".gravatar-check").css("display", "block");
            localStorage.setItem("user_qq", "");
            $("div.comment-user-avatar img").attr(
              "src",
              get_gravatar(cached.filter("#email").val())
            );
            localStorage.setItem(
              "user_avatar",
              get_gravatar(cached.filter("#email").val())
            );
          }
        },
      });
    }
  });
  if (
    localStorage.getItem("user_avatar") &&
    localStorage.getItem("user_email") &&
    localStorage.getItem("is_user_qq") == "no" &&
    !localStorage.getItem("user_qq_email")
  ) {
    $("div.comment-user-avatar img").attr(
      "src",
      localStorage.getItem("user_avatar")
    );
    cached.filter("#email").val(localStorage.getItem("user_email"));
    cached.filter("#qq").val("");
    if (!cached.filter("#qq").val()) {
      $(".qq-check").css("display", "none");
      $(".gravatar-check").css("display", "block");
    }
  }
  cached.filter("#email").on("blur", function () {
    var emailAddress = cached.filter("#email").val();
    if (is_get_by_qq === false || emailAddressFlag !== emailAddress) {
      $("div.comment-user-avatar img").attr("src", get_gravatar(emailAddress));
      localStorage.setItem("user_author", get_gravatar(emailAddress));
      localStorage.setItem("user_email", emailAddress);
      localStorage.setItem("user_qq_email", "");
      localStorage.setItem("is_user_qq", "no");
      cached.filter("#qq").val("");
      if (!cached.filter("#qq").val()) {
        $(".qq-check").css("display", "none");
        $(".gravatar-check").css("display", "block");
      }
    }
  });
  if (localStorage.getItem("user_url")) {
    cached.filter("#url").val(localStorage.getItem("user_url"));
  }
  cached.filter("#url").on("blur", function () {
    var URL_Address = cached.filter("#url").val();
    cached.filter("#url").val(URL_Address);
    localStorage.setItem("user_url", URL_Address);
  });
  if (localStorage.getItem("user_author")) {
    cached.filter("#author").val(localStorage.getItem("user_author"));
  }
  cached.filter("#author").on("blur", function () {
    var user_name = cached.filter("#author").val();
    cached.filter("#author").val(user_name);
    localStorage.setItem("user_author", user_name);
  });
}

function mail_me() {
  var mail =
    "mailto:" + mashiro_option.email_name + "@" + mashiro_option.email_domain;
  window.open(mail);
}

function activate_widget() {
  if (document.body.clientWidth > 860) {
    $(".show-hide").on("click", function () {
      $("#secondary").toggleClass("active");
    });
  } else {
    $("#secondary").remove();
  }
}

setTimeout(function () {
  activate_widget();
}, 100);

function load_bangumi() {
  if ($("section").hasClass("bangumi")) {
    $body.on("click", "#bangumi-pagination a", function () {
      $("#bangumi-pagination a").addClass("loading").text("");
      var xhr = new XMLHttpRequest();
      xhr.open("POST", this.href + "&_wpnonce=" + mashiro_option.nonce, true);
      xhr.onreadystatechange = function () {
        if (xhr.readyState == 4) {
          if (xhr.status == 200) {
            var html = JSON.parse(xhr.responseText);
            $("#bangumi-pagination").remove();
            $(".row").append(html);
          } else {
            $("#bangumi-pagination a")
              .removeClass("loading")
              .html(
                '<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ERROR '
              );
          }
        }
      };
      xhr.send();
      return false;
    });
  }
}

mashiro_global.ini.normalize();
loadCSS(mashiro_option.entry_content_theme_src);
loadCSS("https://at.alicdn.com/t/font_679578_qyt5qzzavdo39pb9.css");

var s = $("#bgvideo")[0],
  Siren = {
    MN: function () {
      $(".iconflat").on("click", function () {
        $body.toggleClass("navOpen");
        $("#main-container,#mo-nav,.openNav").toggleClass("open");
      });
    },
    MNH: function () {
      if ($body.hasClass("navOpen")) {
        $body.toggleClass("navOpen");
        $("#main-container,#mo-nav,.openNav").toggleClass("open");
      }
    },
    splay: function () {
      $("#video-btn").addClass("video-pause").removeClass("video-play").show();
      $(".video-stu").css({
        bottom: "-100px",
      });
      $(".focusinfo").css({
        top: "-999px",
      });
      try {
        for (var i = 0; i < ap.length; i++) {
          try {
            ap[i].destroy();
          } catch (e) {}
        }
      } catch (e) {}
      try {
        hermitInit();
      } catch (e) {}
      s.play();
    },
    spause: function () {
      $("#video-btn").addClass("video-play").removeClass("video-pause");
      $(".focusinfo").css({
        top: "49.3%",
      });
      s.pause();
    },
    liveplay: function () {
      if (s.oncanplay != undefined && $(".haslive").length > 0) {
        if ($(".videolive").length > 0) {
          Siren.splay();
        }
      }
    },
    livepause: function () {
      if (s.oncanplay != undefined && $(".haslive").length > 0) {
        Siren.spause();
        $(".video-stu")
          .css({
            bottom: "0px",
          })
          .html("已暂停 ...");
      }
    },
    addsource: function () {
      $(".video-stu").html("正在载入视频 ...").css({
        bottom: "0px",
      });
      var t = mashiro_option.movies.name.split(","),
        _t = t[Math.floor(Math.random() * t.length)],
        l = mashiro_option.movies.url + "/" + _t,
        v = $("#bgvideo");
      v.attr("video-name", _t);
      if (_t.endsWith(".m3u8")) {
        // hls
        v.attr("data-src", l);
        initHls(() => loadHls("bgvideo"));
      } else {
        v.attr("src", l);
      }
    },
    LV: function () {
      var _btn = $("#video-btn");
      _btn.on("click", function () {
        if ($(this).hasClass("loadvideo")) {
          $(this).addClass("video-pause").removeClass("loadvideo").hide();
          Siren.addsource();
          s.oncanplay = function () {
            Siren.splay();
            $("#video-add").show();
            _btn.addClass("videolive").addClass("haslive");
          };
        } else {
          if ($(this).hasClass("video-pause")) {
            Siren.spause();
            _btn.removeClass("videolive");
            $(".video-stu")
              .css({
                bottom: "0px",
              })
              .html("已暂停 ...");
          } else {
            Siren.splay();
            _btn.addClass("videolive");
          }
        }
        s.onended = function () {
          $("#bgvideo").attr("src", "");
          $("#video-add").hide();
          _btn
            .addClass("loadvideo")
            .removeClass("video-pause")
            .removeClass("videolive")
            .removeClass("haslive");
          $(".focusinfo").css({
            top: "49.3%",
          });
        };
      });
      $("#video-add").on("click", function () {
        Siren.addsource();
      });
    },
    AH: function () {
      if (mashiro_option.window_height == "auto") {
        if ($("h1.main-title").length > 0) {
          var _height = $(window).height() + "px";
          $("#centerbg").css({
            height: "100vh",
          });
          $("#bgvideo").css({
            "min-height": "100vh",
          });
        }
      } else {
        $(".headertop").addClass("headertop-bar");
      }
    },
    PE: function () {
      if ($(".headertop").length > 0) {
        if ($("h1.main-title").length > 0) {
          $(".blank").css({
            "padding-top": "0px",
          });
          $(".headertop")
            .css({
              height: "auto",
            })
            .show();
          if (mashiro_option.movies.live == "open") Siren.liveplay();
        } else {
          $(".blank").css({
            "padding-top": "75px",
          });
          $(".headertop")
            .css({
              height: "0px",
            })
            .hide();
          Siren.livepause();
        }
      }
    },
    CE: function () {
      $(".comments-hidden").show();
      $(".comments-main").hide();
      $(".comments-hidden").click(function () {
        $(".comments-main").slideDown(500);
        $(".comments-hidden").hide();
      });
      $(".archives").hide();
      $(".archives:first").show();
      $("#archives-temp h3").click(function () {
        $(this).next().slideToggle("fast");
        return false;
      });
      lightGallery(document.querySelector(".entry-content"), {
        selector: "img",
      });
      $(".js-toggle-search").on("click", function () {
        $(".js-toggle-search").toggleClass("is-active");
        $(".js-search").toggleClass("is-visible");
        $("html").css("overflow-y", "hidden");
        if (mashiro_option.live_search) {
          let QueryStorage = [];
          const searchInput = document.querySelector("#search-input");

          do_update_search(
            mashiro_option.api +
              "asakura/v1/cache_search/json?_wpnonce=" +
              mashiro_option.nonce
          );

          let searchFlag = null;
          searchInput.oninput = function () {
            if (searchFlag === null) {
              clearTimeout(searchFlag);
            }
            searchFlag = setTimeout(
              () => query(QueryStorage, searchInput.value),
              250
            );
          };

          function do_update_search(val) {
            function update_search(j) {
              if (typeof j === "object") {
                QueryStorage = j;
                sessionStorage.setItem("search", JSON.stringify(j));
              } else {
                QueryStorage = JSON.parse(sessionStorage.getItem("search"));
              }
              query(QueryStorage, $("#search-input").val());
            }

            if (sessionStorage.getItem("search") === null) {
              // fetch search cache
              fetch(val)
                .then((r) => r.json())
                .then((j) => update_search(j))
                .catch((e) =>
                  console.error(`Failed to GET cache_search: ${e}`)
                );
            } else {
              update_search();
            }
          }

          if (!Object.values)
            Object.values = function (obj) {
              if (obj !== Object(obj))
                throw new TypeError("Object.values called on a non-object");
              var val = [],
                key;
              for (key in obj) {
                if (Object.prototype.hasOwnProperty.call(obj, key)) {
                  val.push(obj[key]);
                }
              }
              return val;
            };

          function Cx(arr, q) {
            q = q.replace(q, "^(?=.*?" + q + ").+$").replace(/\s/g, ")(?=.*?");
            var i = arr.filter((v) =>
              Object.values(v).some((v) => new RegExp(q + "").test(v))
            );
            return i;
          }

          function query(storage, value) {
            function createSection() {
              const sec = document.createElement("section");
              sec.classList.add("ins-section");
              return sec;
            }

            function createHeader(name) {
              const hea = document.createElement("header");
              hea.classList.add("ins-section-header");
              hea.textContent = name;
              return hea;
            }

            function createMark(text) {
              const m = document.createElement("mark");
              m.classList.add("search-keyword");
              m.textContent = text;
              return m;
            }

            function arrayJoin(arr, spl) {
              const newArray = [];
              arr.forEach((item, i) => {
                newArray.push(item);
                if (i !== arr.length - 1) {
                  newArray.push(spl);
                }
              });
              return newArray;
            }

            function createEntry(
              keyword,
              link,
              fa,
              title,
              iconfont,
              comments,
              text
            ) {
              if (keyword) {
                function rr(input, kw) {
                  const pos = input.indexOf(kw);
                  const txt =
                    pos < 60
                      ? input.slice(0, 80)
                      : input.slice(pos - 30, pos + 30);
                  let nodes = txt
                    .split(kw)
                    .map((n) => document.createTextNode(n));
                  return arrayJoin(nodes, createMark(s));
                }

                const keywords = keyword.trim().split(" ");
                const s = keywords[keywords.length - 1];
                title = rr(title, s);
                text = rr(text, s);
              } else {
                title = [document.createTextNode(title)];
                text = [document.createTextNode(text)];
              }
              const div = document.createElement("div");
              div.classList.add("ins-selectable", "ins-search-item");

              const fakeLink = document.createElement("a");
              fakeLink.href = link;
              div.appendChild(fakeLink);

              div.onclick = function () {
                fakeLink.click();
                $(".search_close").click();
              };

              const header = document.createElement("header");
              const iFa = document.createElement("i");
              iFa.classList.add("fa", `fa-${fa}`);
              iFa.setAttribute("aria-hidden", "true");
              header.appendChild(iFa);

              title.forEach((t) => header.appendChild(t));

              const iIcon = document.createElement("i");
              iIcon.classList.add("iconfont", `icon-${iconfont}`);
              iIcon.appendChild(document.createTextNode(" " + comments));
              header.appendChild(iIcon);
              div.appendChild(header);

              const p = document.createElement("p");
              p.classList.add("ins-search-preview");
              text.forEach((t) => p.appendChild(t));
              div.appendChild(p);
              return div;
            }

            function createType(name, children) {
              const sec = createSection();
              sec.appendChild(createHeader(name));
              children.forEach((c) => sec.appendChild(c));
              return sec;
            }

            const posts = [],
              pages = [],
              categories = [],
              tags = [],
              comments = [],
              C = Cx(storage, value.trim());
            for (let key = 0; key < Object.keys(C).length; key++) {
              const post = C[key];
              switch (post.type) {
                case "post":
                  posts.push(
                    createEntry(
                      value,
                      post.link,
                      "file",
                      post.title,
                      "mark",
                      post.comments,
                      post.text
                    )
                  );
                  break;
                case "tag":
                  tags.push(
                    createEntry(
                      "",
                      post.link,
                      "tag",
                      post.title,
                      "none",
                      "",
                      ""
                    )
                  );
                  break;
                case "category":
                  categories.push(
                    createEntry(
                      "",
                      post.link,
                      "folder",
                      post.title,
                      "none",
                      "",
                      ""
                    )
                  );
                  break;
                case "page":
                  pages.push(
                    createEntry(
                      value,
                      post.link,
                      "file",
                      post.title,
                      "mark",
                      post.comments,
                      post.text
                    )
                  );
                  break;
                case "comment":
                  comments.push(
                    createEntry(
                      value,
                      post.link,
                      "comment",
                      post.title,
                      "none",
                      "",
                      post.text
                    )
                  );
                  break;
              }
            }
            const container = document.querySelector("#post-list-box");
            container.innerHTML = "";
            if (posts.length > 0)
              container.appendChild(createType("文章", posts));
            if (pages.length > 0)
              container.appendChild(createType("页面", pages));
            if (categories.length > 0)
              container.appendChild(createType("分类", categories));
            if (tags.length > 0)
              container.appendChild(createType("标签", tags));
            if (comments.length > 0)
              container.appendChild(createType("评论", comments));
          }
        }
      });
      $(".search_close").on("click", function () {
        if ($(".js-search").hasClass("is-visible")) {
          $(".js-toggle-search").toggleClass("is-active");
          $(".js-search").toggleClass("is-visible");
          $("html").css("overflow-y", "unset");
        }
      });
      $("#show-nav").on("click", function () {
        if ($("#show-nav").hasClass("showNav")) {
          $("#show-nav").removeClass("showNav").addClass("hideNav");
          $(".site-top .lower nav").addClass("navbar");
        } else {
          $("#show-nav").removeClass("hideNav").addClass("showNav");
          $(".site-top .lower nav").removeClass("navbar");
        }
      });
      $("#loading").click(function () {
        $("#loading").fadeOut(500);
      });
    },
    NH: function () {
      if (document.body.clientWidth > 860) {
        var h1 = 0;
        $(window).scroll(function () {
          var s = $(document).scrollTop(),
            cached = $(".site-header");
          if (s === h1) {
            cached.removeClass("yya");
          }
          if (s > h1) {
            cached.addClass("yya");
          }
        });
      }
    },
    XLS: function () {
      var load_post_timer;
      var intersectionObserver = new IntersectionObserver(function (entries) {
        if (entries[0].intersectionRatio <= 0) return;
        var page_next = $("#pagination a").attr("href");
        var load_key = document.getElementById("add_post_time");
        if (page_next !== undefined && load_key) {
          var load_time = document.getElementById("add_post_time").title;
          if (load_time !== "233") {
            if (load_time !== "0")
              console.log(
                "%c 自动加载时倒计时 %c",
                "background:#9a9da2; color:#ffffff; border-radius:4px;",
                "",
                "",
                load_time
              );
            load_post_timer = setTimeout(function () {
              load_post();
            }, load_time * 1000);
          }
        }
      });
      intersectionObserver.observe(
        document.querySelector("#pagination") ||
          document.querySelector(".footer-device")
      );
      $body.on("click", "#pagination a", function () {
        clearTimeout(load_post_timer);
        load_post();
        return false;
      });

      function load_post() {
        $("#pagination a").addClass("loading").text("");
        $.ajax({
          type: "POST",
          url: $("#pagination a").attr("href") + "#main",
          success: function (data) {
            var result = $(data).find("#main .post");
            var nextHref = $(data).find("#pagination a").attr("href");
            $("#main").append(result.fadeIn(500));
            $("#pagination a").removeClass("loading").text("Previous");
            $("#add_post span").removeClass("loading").text("");
            new lazyload();
            post_list_show_animation();
            if (nextHref !== undefined) {
              $("#pagination a").attr("href", nextHref);
              //加载完成上滑
              var tempScrollTop = $(window).scrollTop();
              $(window).scrollTop(tempScrollTop);
              $body.animate(
                {
                  scrollTop: tempScrollTop + 300,
                },
                666
              );
            } else {
              $("#pagination").html(
                "<span>很高兴你翻到这里，但是真的没有了...</span>"
              );
            }
          },
        });
        return false;
      }
    },
    XCS: function () {
      var __cancel = $("#cancel-comment-reply-link"),
        __cancel_text = __cancel.text(),
        __list = "commentwrap";
      $(document).on("submit", "#commentform", function () {
        $.ajax({
          url: mashiro_option.ajax_url,
          data: $(this).serialize() + "&action=ajax_comment",
          type: $(this).attr("method"),
          beforeSend: addComment.createButterbar("提交中(Commiting)...."),
          error: function (request) {
            var t = addComment;
            t.createButterbar(request.responseText);
          },
          success: function (data) {
            $("textarea").each(function () {
              this.value = "";
            });
            var t = addComment,
              cancel = t.I("cancel-comment-reply-link"),
              temp = t.I("wp-temp-form-div"),
              respond = t.I(t.respondId),
              post = t.I("comment_post_ID").value,
              parent = t.I("comment_parent").value;
            if (parent !== "0") {
              $("#respond").before('<ol class="children">' + data + "</ol>");
            } else if (!$("." + __list).length) {
              if (mashiro_option.form_position === "bottom") {
                $("#respond").before(
                  '<ol class="' + __list + '">' + data + "</ol>"
                );
              } else {
                $("#respond").after(
                  '<ol class="' + __list + '">' + data + "</ol>"
                );
              }
            } else {
              if (mashiro_option.comment_order === "asc") {
                $("." + __list).append(data);
              } else {
                $("." + __list).prepend(data);
              }
            }
            t.createButterbar("提交成功(Succeed)");
            new lazyload();
            code_highlight_style();
            click_to_view_image();
            clean_upload_images();
            cancel.style.display = "none";
            cancel.onclick = null;
            t.I("comment_parent").value = "0";
            if (temp && respond) {
              temp.parentNode.insertBefore(respond, temp);
              temp.parentNode.removeChild(temp);
            }
          },
        });
        return false;
      });
      window.addComment = {
        moveForm: function (commId, parentId, respondId) {
          var t = this,
            div,
            comm = t.I(commId),
            respond = t.I(respondId),
            cancel = t.I("cancel-comment-reply-link"),
            parent = t.I("comment_parent"),
            post = t.I("comment_post_ID");
          __cancel.text(__cancel_text);
          t.respondId = respondId;
          if (!t.I("wp-temp-form-div")) {
            div = document.createElement("div");
            div.id = "wp-temp-form-div";
            div.style.display = "none";
            respond.parentNode.insertBefore(div, respond);
          }
          var temp;
          !comm
            ? ((temp = t.I("wp-temp-form-div")),
              (t.I("comment_parent").value = "0"),
              temp.parentNode.insertBefore(respond, temp),
              temp.parentNode.removeChild(temp))
            : comm.parentNode.insertBefore(respond, comm.nextSibling);
          $("body").animate(
            {
              scrollTop: $("#respond").offset().top - 180,
            },
            400
          );
          parent.value = parentId;
          cancel.style.display = "";
          cancel.onclick = function () {
            var t = addComment,
              temp = t.I("wp-temp-form-div"),
              respond = t.I(t.respondId);
            t.I("comment_parent").value = "0";
            if (temp && respond) {
              temp.parentNode.insertBefore(respond, temp);
              temp.parentNode.removeChild(temp);
            }
            this.style.display = "none";
            this.onclick = null;
            return false;
          };
          try {
            t.I("comment").focus();
          } catch (e) {}
          return false;
        },
        clearButterbar: function () {
          document.querySelectorAll(".butterBar").forEach((b) => b.remove());
        },
        createButterbar: function (message, showtime = 6000) {
          this.clearButterbar();

          const bar = document.createElement("div");
          bar.classList.add("butterBar", "butterBar--center");
          const bp = document.createElement("p");
          bp.classList.add("butterBar-message");
          bp.innerHTML = message;
          bar.appendChild(bp);
          document.body.appendChild(bar);
          setTimeout(() => bar.remove(), showtime);
        },
      };
    },
    XCP: function () {
      $body.on("click", "#comments-navi a", function (e) {
        e.preventDefault();
        var path = $(this)[0].pathname;
        $.ajax({
          type: "GET",
          url: $(this).attr("href"),
          beforeSend: function () {
            $("#comments-navi").remove();
            $("ul.commentwrap").remove();
            $("#loading-comments").slideDown();
            $body.animate(
              {
                scrollTop: $("#comments-list-title").offset().top - 65,
              },
              800
            );
          },
          dataType: "html",
          success: function (out) {
            var result = $(out).find("ul.commentwrap");
            var nextlink = $(out).find("#comments-navi");
            $("#loading-comments").slideUp("fast");
            $("#loading-comments").after(result.fadeIn(500));
            $("ul.commentwrap").after(nextlink);
            new lazyload();
            if (window.gtag) {
              gtag("config", mashiro_option.google_analytics_id, {
                page_path: path,
              });
            }
            code_highlight_style();
            click_to_view_image();
          },
        });
      });
    },
    GT: function () {
      const mb_to_top = document.querySelector("#mobileGoTop");

      $(window).scroll(function () {
        if ($(this).scrollTop() > 20) {
          mb_to_top.style.transform = "scale(1)";
        } else {
          mb_to_top.style.transform = "scale(0)";
        }
      });
      mb_to_top.onclick = () => aScrollTo(0);
    },
  };
$(function () {
  Siren.AH();
  Siren.PE();
  Siren.NH();
  Siren.GT();
  Siren.XLS();
  Siren.XCS();
  Siren.XCP();
  Siren.CE();
  Siren.MN();
  Siren.LV();
  if (mashiro_option.pjax) {
    $(document)
      .pjax("a[target!=_top]", "#page", {
        fragment: "#page",
        timeout: 8000,
      })
      .on("pjax:beforeSend", () => {
        //离开页面停止播放
        $(".normal-cover-video").each(function () {
          this.pause();
          this.src = "";
          this.load = "";
        });
      })
      .on("pjax:send", function () {
        $("#bar").css("width", "0%");
        if (mashiro_option.nprogress_on) NProgress.start();
        Siren.MNH();
      })
      .on("pjax:complete", function () {
        Siren.AH();
        Siren.PE();
        Siren.CE();
        if (mashiro_option.nprogress_on) NProgress.done();
        mashiro_global.ini.pjax();
        $("#loading").fadeOut(500);
        if (mashiro_option.code_lamp === "open") {
          self.Prism.highlightAll(event);
        }
      })
      .on("pjax:end", function () {
        if (window.gtag) {
          gtag("config", mashiro_option.google_analytics_id, {
            page_path: window.location.pathname,
          });
        }
      })
      .on("submit", ".search-form,.s-search", function (event) {
        event.preventDefault();
        $.pjax.submit(event, "#page", {
          fragment: "#page",
          timeout: 8000,
        });
        if ($(".js-search.is-visible").length > 0) {
          $(".js-toggle-search").toggleClass("is-active");
          $(".js-search").toggleClass("is-visible");
          $("html").css("overflow-y", "unset");
        }
      });
    window.addEventListener(
      "popstate",
      function (e) {
        Siren.AH();
        Siren.PE();
        Siren.CE();
        timeSeriesReload(true);
        post_list_show_animation();
      },
      false
    );
  }
  $.fn.postLike = function () {
    if ($(this).hasClass("done")) {
      return false;
    } else {
      $(this).addClass("done");
      var id = $(this).data("id"),
        action = $(this).data("action"),
        rateHolder = $(this).children(".count");
      var ajax_data = {
        action: "specs_zan",
        um_id: id,
        um_action: action,
      };
      $.post(mashiro_option.ajax_url, ajax_data, function (data) {
        $(rateHolder).html(data);
      });
      return false;
    }
  };
  $(document).on("click", ".specsZan", function () {
    $(this).postLike();
  });
  console.log(
    "%c Mashiro %c",
    "background:#24272A; color:#ffffff",
    "",
    "https://2heng.xin/"
  );
  console.log(
    "%c Github %c",
    "background:#24272A; color:#ffffff",
    "",
    "https://github.com/mashirozx"
  );
});

var isWebkit = navigator.userAgent.toLowerCase().indexOf("webkit") > -1,
  isOpera = navigator.userAgent.toLowerCase().indexOf("opera") > -1,
  isIe = navigator.userAgent.toLowerCase().indexOf("msie") > -1;
if (
  (isWebkit || isOpera || isIe) &&
  document.getElementById &&
  window.addEventListener
) {
  window.addEventListener(
    "hashchange",
    function () {
      var id = location.hash.substring(1),
        element;
      if (!/^[A-z0-9_-]+$/.test(id)) {
        return;
      }
      element = document.getElementById(id);
      if (element) {
        if (!/^(?:a|select|input|button|textarea)$/i.test(element.tagName)) {
          element.tabIndex = -1;
        }
        element.focus();
      }
    },
    false
  );
}

window.onload = function () {
  function load() {
    $("html").css("overflow-y", "unset");
    code_highlight_style();
    checkDarkMode(false);
    $("#preload").fadeOut();
  }

  if (mashiro_option.instantclick) {
    import(
      /* webpackChunkName: "instantclick" */
      "instantclick"
    ).then(({ default: _ }) => {
      _.init();
      _.on("change", () => {
        load();
        delete window.$;
        delete window.jQuery;
        if (window.SyntaxHighlighter) {
          SyntaxHighlighter.highlight();
        }
        if (window.EnlighterJSINIT) {
          EnlighterJSINIT();
        }
      });
    });
  }

  load();
};

$(document).ready(function () {
  $(".collapseButton").click(function () {
    $(this).parent().parent().find(".xContent").slideToggle("slow");
  });
});
