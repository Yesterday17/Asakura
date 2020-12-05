export function loadCSS(src, node, media = "all") {
  let insertPos, toInsert;
  const link = document.createElement("link");
  if (node) toInsert = insertPos = node;
  else {
    const children = (document.body || document.getElementsByTagName("head")[0])
      .childNodes;
    toInsert = children[children.length - 1];
    insertPos = toInsert.nextSibling;
  }
  link.rel = "stylesheet";
  link.href = src;
  link.media = "only x";
  toInsert.parentNode.insertBefore(link, insertPos);
  const ondefined = function (callback) {
    for (let href = link.href, i = document.styleSheets.length; i--; ) {
      if (document.styleSheets[i].href === href) {
        return callback();
      }
    }
    setTimeout(function () {
      ondefined(callback);
    });
  };
  link.onloadcssdefined = ondefined;
  ondefined(() => (link.media = media));
  return link;
}
