import tocbot from "tocbot";

export function initTOC() {
  if (document.querySelector(".have-toc")) {
    let id = 1,
      heading_fix;
    if (mashiro_option.entry_content_theme === "sakura") {
      if (document.querySelector('article.type-post')) {
        if (document.querySelector('div.pattern-attachment-img')) {
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