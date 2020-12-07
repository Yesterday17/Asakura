// import hljs from "highlight.js";
import hljs from "highlight.js/lib/core";
import hl_javascript from "highlight.js/lib/languages/javascript";
import hl_typescript from "highlight.js/lib/languages/typescript";
import hl_lua from "highlight.js/lib/languages/lua";
import hl_go from "highlight.js/lib/languages/go";
import hl_rust from "highlight.js/lib/languages/rust";
import hl_c from "highlight.js/lib/languages/c";
hljs.registerLanguage("javascript", hl_javascript);
hljs.registerLanguage("typescript", hl_typescript);
hljs.registerLanguage("lua", hl_lua);
hljs.registerLanguage("go", hl_go);
hljs.registerLanguage("rust", hl_rust);
hljs.registerLanguage("c", hl_c);
import hljs_linenumber from "./highlightjs-line-numbers.js";
hljs_linenumber(window, document, hljs);

function copyToClipboard(str) {
  const el = document.createElement("textarea");
  el.value = str;
  el.setAttribute("readonly", "");
  el.style.position = "absolute";
  el.style.left = "-9999px";
  document.body.appendChild(el);
  el.select();
  document.execCommand("copy");
  document.body.removeChild(el);
}

function getCopyButton(code) {
  const a = document.createElement("span");
  a.classList.add("copy-code");
  a.setAttribute("data-src", code);

  const i = document.createElement("i");
  i.classList.add("fa", "fa-clipboard");
  a.appendChild(i);
  a.addEventListener("click", function () {
    copyToClipboard(this.getAttribute("data-src"));
    addComment.createButterbar(
      "复制成功！<br>Copied to clipboard successfully!",
      1000
    );
  });
  return a;
}

export function highlightCode() {
  function gen_top_bar(p) {
    p.classList.add("highlight-wrap");
  }
  hljs.initLineNumbersOnLoad({ singleLine: true });

  document.querySelectorAll("pre:not(.initialized) code").forEach((code) => {
    const pre = code.parentElement;
    pre.classList.add("initialized");
    pre.appendChild(getCopyButton(code.textContent));

    hljs.highlightBlock(code);
    gen_top_bar(pre);
    pre.addEventListener("click", (e) => {
      if (e.target !== pre) return;
      pre.classList.toggle("code-block-fullscreen");
      document.body.classList.toggle("code-block-fullscreen-html-scroll");
    });
  });
}
