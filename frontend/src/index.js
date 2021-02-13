import $ from "jquery";

import "lightgallery.js";
import "lightgallery.js/dist/css/lightgallery.css";
import "./styles/lightgallery-fix.css";

import lazyload from "lazyload";

import { changeTheme, checkDarkMode } from "./darkmode";
import { web_audio } from "./webAudio";
import { loadCSS, getGravatar } from "./utils/utils";
import { highlightCode } from "./utils/highlight";
import { initHls, loadHls } from "./utils/hls";
import { initSerach } from "./utils/search";
import { createButterbar } from "./utils/butterBar";

import "font-awesome/css/font-awesome.css";
import "font-awesome-animation/dist/font-awesome-animation.css";

// import "smoothscroll-for-websites";
import { scrollBar } from "./utils/dom";
import { initTOC } from "./utils/toc";

global.asakura = {
  changeTheme,
  scrollTo: aScrollTo,
  showPopup,
  cmt_showPopup,
  bg_update,
  init_page,
  mail_me,
  coverVideo,
  get_comment_avatar,
};

window.timeSeriesReload = timeSeriesReload;
window.post_list_show_animation = post_list_show_animation;

var $body = $("body");

function init_page(normal = true) {
  if (normal) {
    // initial functions when page first load (首次加载页面时的初始化函数)
    new lazyload();
    scrollBar();
  }

  post_list_show_animation();
  web_audio();
  coverVideoIni();
  load_bangumi();
}

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

document.querySelectorAll(".comment-reply-link").forEach((r) =>
  r.addEventListener("click", function () {
    addComment.moveForm(
      `comment-${$(this).attr("data-commentid")}`,
      $(this).attr("data-commentid"),
      "respond",
      $(this).attr("data-postid")
    );
    return false;
  })
);

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

checkDarkMode();

$(document).ready(function () {
  bg_update();

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
});

function bg_update() {
  $("#center-bg").css(
    "background-image",
    `url(${mashiro_option.cover_api}?${
      document.body.clientWidth < 860 && mashiro_option.cover_beta
        ? "type=mobile&"
        : ""
    }${Date.now()})`
  );
}

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

initTOC();

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

if (mashiro_option.float_player_on && document.body.clientWidth > 860) {
  import(
    /* webpackChunkName: "aplayer" */
    "./utils/aplayer"
  ).then(({ loadAPlayer }) => loadAPlayer());
}

function get_comment_avatar() {
  var cached = $("input");
  var emailAddressFlag = cached.filter("#email").val();
  if (
    localStorage.getItem("user_avatar") &&
    localStorage.getItem("user_email")
  ) {
    $("div.comment-user-avatar img").attr(
      "src",
      localStorage.getItem("user_avatar")
    );
    cached.filter("#email").val(localStorage.getItem("user_email"));
    $(".gravatar-check").css("display", "block");
  }
  cached.filter("#email").on("blur", function () {
    var emailAddress = cached.filter("#email").val();
    if (emailAddressFlag !== emailAddress) {
      $("div.comment-user-avatar img").attr("src", getGravatar(emailAddress));
      localStorage.setItem("user_author", getGravatar(emailAddress));
      localStorage.setItem("user_email", emailAddress);
      $(".gravatar-check").css("display", "block");
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

init_page();
loadCSS(mashiro_option.entry_content_theme_src);
loadCSS("https://at.alicdn.com/t/font_679578_qyt5qzzavdo39pb9.css");

var s = $("#bgvideo")[0];
window.Siren = {
  MN: function () {
    $(".iconflat").on("click", function () {
      $body.toggleClass("navOpen");
      $("#main-container,#mo-nav,.openNav").toggleClass("open");
    });
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
  XCS: function () {
    var __cancel = $("#cancel-comment-reply-link"),
      __cancel_text = __cancel.text(),
      __list = "comment-wrap";
    $(document).on("submit", "#commentform", function () {
      $.ajax({
        url: mashiro_option.ajax_url,
        data: $(this).serialize() + "&action=ajax_comment",
        type: $(this).attr("method"),
        beforeSend: createButterbar("提交中(Commiting)...."),
        error: function (request) {
          createButterbar(request.responseText);
        },
        success: function (data) {
          $("textarea").each(function () {
            this.value = "";
          });
          var cancel = document.getElementById("cancel-comment-reply-link"),
            temp = document.getElementById("wp-temp-form-div"),
            respond = document.getElementById(addComment.respondId),
            post = document.getElementById("comment_post_ID").value,
            parent = document.getElementById("comment_parent").value;
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
          createButterbar("提交成功(Succeed)");
          new lazyload();
          highlightCode();
          cancel.style.display = "none";
          cancel.onclick = null;
          document.getElementById("comment_parent").value = "0";
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
        var div,
          comm = document.getElementById(commId),
          respond = document.getElementById(respondId),
          cancel = document.getElementById("cancel-comment-reply-link"),
          parent = document.getElementById("comment_parent"),
          post = document.getElementById("comment_post_ID");
        __cancel.text(__cancel_text);
        addComment.respondId = respondId;
        if (!document.getElementById("wp-temp-form-div")) {
          div = document.createElement("div");
          div.id = "wp-temp-form-div";
          div.style.display = "none";
          respond.parentNode.insertBefore(div, respond);
        }
        var temp;
        !comm
          ? ((temp = document.getElementById("wp-temp-form-div")),
            (document.getElementById("comment_parent").value = "0"),
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
          var temp = document.getElementById("wp-temp-form-div"),
            respond = document.getElementById(addComment.respondId);
          document.getElementById("comment_parent").value = "0";
          if (temp && respond) {
            temp.parentNode.insertBefore(respond, temp);
            temp.parentNode.removeChild(temp);
          }
          this.style.display = "none";
          this.onclick = null;
          return false;
        };
        try {
          document.getElementById("comment").focus();
        } catch (e) {}
        return false;
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
          $("ul.comment-wrap").remove();
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
          var result = $(out).find("ul.comment-wrap");
          var nextlink = $(out).find("#comments-navi");
          $("#loading-comments").slideUp("fast");
          $("#loading-comments").after(result.fadeIn(500));
          $("ul.comment-wrap").after(nextlink);
          new lazyload();
          highlightCode();
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

function prepare_next_page_load() {
  let load_post_timer;
  const pg = document.querySelector("#pagination a");
  const intersectionObserver = new IntersectionObserver(function (entries) {
    if (entries[0].intersectionRatio <= 0) return;

    const nextPage = pg?.getAttribute("href");
    if (nextPage) {
      const load_time = Number(mashiro_option.auto_load_post);
      if (load_time >= 0) {
        pg.classList.add("loading");
        pg.textContent = "";
        load_post_timer = setTimeout(
          () => load_post(nextPage),
          load_time * 1000
        );
      }
    } else {
      document.getElementById("pagination").innerHTML =
        "<span>很高兴你翻到这里，但是真的没有了...</span>";
    }
  });
  intersectionObserver.observe(
    document.querySelector("#pagination") ||
      document.querySelector(".footer-device")
  );
  pg?.addEventListener("click", () => {
    clearTimeout(load_post_timer);
    load_post(pg?.getAttribute("href"));
    return false;
  });

  function load_post(next) {
    fetch(next)
      .then((resp) => resp.text())
      .then((html) => {
        const parser = new DOMParser();
        const doc = parser.parseFromString(html, "text/html");
        const result = doc.querySelectorAll("#main .post");
        const nextHref = doc
          .querySelector("#pagination a")
          ?.getAttribute("href");

        document.getElementById("main").append(...result);
        pg.classList.remove("loading");
        pg.textContent = "Previous";
        new lazyload();
        post_list_show_animation();
        if (nextHref) {
          pg.setAttribute("href", nextHref);
          //加载完成上滑
          asakura.scrollTo(window.scrollY + 300);
        } else {
          pg.removeAttribute("href");
          document.getElementById("pagination").innerHTML =
            "<span>很高兴你翻到这里，但是真的没有了...</span>";
        }
      });
    return false;
  }
}

$(function () {
  get_comment_avatar();
  Siren.PE();
  Siren.NH();
  Siren.GT();
  prepare_next_page_load();
  Siren.XCS();
  Siren.XCP();
  initSerach();
  Siren.MN();
  Siren.LV();
  if (mashiro_option.pjax) {
    import(
      /* webpackChunkName: "pjax" */
      "./utils/pjax"
    ).then(({ InitPJAX }) => InitPJAX());
  }

  $("html").css("overflow-y", "unset");
  highlightCode();
  checkDarkMode(false);
  $("#preload").fadeOut();

  $(".collapseButton").click(function () {
    $(this).parent().parent().find(".xContent").slideToggle("slow");
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
