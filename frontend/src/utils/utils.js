export function doAfterDOMLoaded(cb) {
  if (document.readyState === "complete" || document.readyState === "loaded") {
    cb();
  } else if (mashiro_option.instantclick) {
    import(
      /* webpackChunkName: "instantclick" */
      "instantclick"
    ).then(({ default: _ }) => {
      _.init();
      _.on("change", () => {
        cb();
      });
    });
  } else {
    window.addEventListener("DOMContentLoaded", cb, false);
  }
}
