export function scrollBar() {
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
