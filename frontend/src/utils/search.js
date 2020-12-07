export function initSerach() {
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
            .catch((e) => console.error(`Failed to GET cache_search: ${e}`));
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
                pos < 60 ? input.slice(0, 80) : input.slice(pos - 30, pos + 30);
              let nodes = txt.split(kw).map((n) => document.createTextNode(n));
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
                createEntry("", post.link, "tag", post.title, "none", "", "")
              );
              break;
            case "category":
              categories.push(
                createEntry("", post.link, "folder", post.title, "none", "", "")
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
        if (posts.length > 0) container.appendChild(createType("文章", posts));
        if (pages.length > 0) container.appendChild(createType("页面", pages));
        if (categories.length > 0)
          container.appendChild(createType("分类", categories));
        if (tags.length > 0) container.appendChild(createType("标签", tags));
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
}
