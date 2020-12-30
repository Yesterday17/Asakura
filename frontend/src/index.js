import $ from "jquery";

import "lightgallery.js";
import "lightgallery.js/dist/css/lightgallery.css";
import "./styles/lightgallery-fix.css";

import lazyload from "lazyload";
import tocbot from "tocbot";

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

global.asakura = {
  changeTheme,
  scrollTo: aScrollTo,
  showPopup,
  cmt_showPopup,
  bg_update,
  init_page,
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

function attach_image() {
  var cached = $(".insert-image-tips");
  $("#upload-img-file").change(function () {
    if (this.files.length > 10) {
      createButterbar("每次上传上限为10张.<br>10 files max per request.");
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
          createButterbar("上传中...<br>Uploading...");
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
            createButterbar("图片上传成功~<br>Uploaded successfully~");
            grin(get_the_url, "Img");
          } else {
            createButterbar(
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

function no_right_click() {
  $(".post-thumb img").bind("contextmenu", function (e) {
    return false;
  });
}

no_right_click();

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
  add_upload_tips();
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
  AH: function () {
    if (mashiro_option.window_height === "auto") {
      if ($("h1.main-title").length > 0) {
        var _height = $(window).height() + "px";
        $("#center-bg").css({
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
          clean_upload_images();
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
$(function () {
  get_comment_avatar();
  Siren.AH();
  Siren.PE();
  Siren.NH();
  Siren.GT();
  Siren.XLS();
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
