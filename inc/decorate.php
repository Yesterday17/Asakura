<?php
function customizer_css() {
    $result = ':root {' . '
  --theme-color: ' . akina_option('theme_skin') . ';
  --theme-color-matching: ' . akina_option('theme_skinm') . ';
  --home-focus-bg: rgba(' . implode(', ', array(
            akina_option('hpage-focus-bcr'),
            akina_option('hpage-focus-bcg'),
            akina_option('hpage-focus-bcb'),
            akina_option('hpage-focus-bca')
        )) . ');
  --info-bar-bg: rgba(' . implode(', ', array(
            akina_option('info-bar-bg-cr'),
            akina_option('info-bar-bg-cg'),
            akina_option('info-bar-bg-cb'),
            akina_option('info-bar-bg-ca')
        )) . ');
  --fore-menu-bg: rgba(' . implode(', ', array(
            akina_option('fore-switch-bcr'),
            akina_option('fore-switch-bcg'),
            akina_option('fore-switch-bcb'),
            akina_option('fore-switch-bca')
        )) . ');
}
';

    // Style Settings
    if (akina_option('shownav')) {
        $result .= '
.site-top .lower nav {
  display: block !important;
}
';
    }
    // theme-skin
    if (akina_option('theme_skin')) {
        $result .= '
.author-profile i, .post-like a, .post-share .show-share, .sub-text, .we-info a, span.sitename {
  color: var(--theme-color);
}

.feature i, /*.feature-title span ,*/
.download, .links ul li:before, .ar-time i, span.ar-circle, .object, .comment .comment-reply-link, .siren-checkbox-radio:checked + .siren-checkbox-radioInput:after {
  background: var(--theme-color);
}

::-webkit-scrollbar-thumb {
  background: var(--theme-color);
  border-radius: 25px;
}

.download, .link-title {
  border-color: var(--theme-color);
}

.comment h4 a, #comments-navi a.prev, #comments-navi a.next, #archives-temp h3, span.page-numbers.current, blockquote:before, blockquote:after {
  color: var(--theme-color);
}

#aplayer-float .aplayer-lrc-current {
  color: var(--theme-color) !important;
}

.linkdes {
  border-top: 1px dotted var(--theme-color) !important;
}

.the-feature.from_left_and_right .info {
  background: var(--home-focus-bg);
}

.is-active-link::before, .commentbody:not(:placeholder-shown) ~ .input-label, .commentbody:focus ~ .input-label {
  background-color: var(--theme-color) !important
}

.links ul li {
  border: 1px solid var(--theme-color);
}

.links ul li img {
  box-shadow: inset 0 0 10px var(--theme-color);
}

.commentbody:focus {
  border-color: var(--theme-color) !important;
}

.post-list-thumb i {
  color: var(--theme-color);
}

.search_close:after,
.search_close:before {
  background-color: var(--theme-color);
}

.search-form input::-webkit-input-placeholder {
  color: var(--theme-color);
}

.search-form input::-moz-placeholder {
  color: var(--theme-color);
}

.search-form input::-webkit-input-placeholder {
  color: var(--theme-color);
}

.search-form input:-ms-input-placeholder {
  color: var(--theme-color);
}

.s-search i {
  color: var(--theme-color);
}

i.iconfont.js-toggle-search.iconsearch {
  color: var(--theme-color);
}

.ins-section .fa {
  color: var(--theme-color);
}

.ins-section .ins-search-item.active .ins-slug, .ins-section .ins-search-item.active .ins-search-preview {
  color: var(--theme-color);
}

.ins-section .ins-section-header {
  color: var(--theme-color);
  border-bottom: 3px solid var(--theme-color);
  border-color: var(--theme-color);
}

.the-feature.from_left_and_right .info p {
    color: var(--theme-color);
}

.sorry li a {
  color: var(--theme-color);
}

.sorry-inner {
  border: 1px solid var(--theme-color);
}

.err-button.back a {
  border: 1px solid var(--theme-color);
  color: var(--theme-color);
}

.sorry {
  color: var(--theme-color);
}

.site-top ul li a {
  color: var(--theme-color);
}

.header-info {
  color: var(--theme-color);
  background: var(--info-bar-bg);
}

.top-social img {
  background: var(--info-bar-bg);
}

.skin-menu {
  background-color: var(--fore-menu-bg);
}

body.dark .entry-title,
body.dark .entry-census {
  text-shadow: 2px 2px 4px black;
}

.post-more i:hover, #pagination a:hover, .post-content a:hover, .float-content i:hover, .entry-content a:hover, .site-info a:hover, .comment h4 a:hover, .site-top ul li a:hover, .entry-title a:hover, .sorry li a:hover, .site-title a:hover, i.iconfont.js-toggle-search.iconsearch:hover, .comment-respond input[type=\'submit\']:hover {
  color: var(--theme-color-matching);
}

.navigator i:hover {
  background: var(--theme-color-matching);
}

.navigator i:hover, .links ul li:hover, #pagination a:hover, .comment-respond input[type=\'submit\']:hover {
  border-color: var(--theme-color-matching);
}

.insert-image-tips:hover, .insert-image-tips-hover {
  color: var(--theme-color-matching);
  border: 1px solid var(--theme-color-matching);
}

.ins-section .ins-search-item:hover .ins-slug, .ins-section .ins-search-item:hover .ins-search-preview, .ins-section .ins-search-item:hover header, .ins-section .ins-search-item:hover .iconfont {
  color: var(--theme-color-matching);
}

.sorry li a:hover {
  color: var(--theme-color-matching);
}

.header-info p:hover {
  color: var(--theme-color-matching);
  transition: all .4s;
}

.post-tags a:hover {
  color: var(--theme-color-matching);
}

.post-share ul li a:hover {
  color: var(--theme-color-matching);
}

#pagination a:hover {
  border: 1px solid var(--theme-color-matching);
  color: var(--theme-color-matching);
}

.ex-login input.login-button:hover,
.ex-register input.register-button:hover {
  background-color: var(--theme-color-matching);
  border-color: var(--theme-color-matching);
}

.site-top ul li a:after {
  background-color: var(--theme-color-matching);
}

body,
button,
input,
select,
textarea {
  color: var(--theme-color);
}

input[type=color],
input[type=date],
input[type=datetime-local],
input[type=datetime],
input[type=email],
input[type=month],
input[type=number],
input[type=password],
input[type=range],
input[type=search],
input[type=tel],
input[type=text],
input[type=time],
input[type=url],
input[type=week],
textarea {
  border: 1px solid var(--theme-color);
}

.post-date {
  color: ' . akina_option('hpage-art-tpac') . '
}

.linkdes {
  color: var(--theme-color);
}

.link-title span.link-fix {
  border-left: 3px solid var(--theme-color);
}

.scrollbar, .butterBar-message {
  background: var(--theme-color) !important
}

h1.cat-title {
  color: var(--theme-color);
}

.comment .body .comment-at {
  color: var(--theme-color);
}

.focusinfo .header-tou img {
  box-shadow: inset 0 0 10px var(--theme-color);
}

.double-bounce1, .double-bounce2 {
  background-color: var(--theme-color);
}

#pagination .loading {
  background: url(' . akina_option('webweb_img') . '/load/ball.svg);
  background-position: center;
  background-repeat: no-repeat;
  color: #555;
  border: none;
  background-size: auto 100%
}

#pagination .loading, #bangumi-pagination .loading {
  background: url(' . akina_option('webweb_img') . '/load/ball.svg);
  background-position: center;
  background-repeat: no-repeat;
  color: #555;
  border: none;
  background-size: auto 100%
}

#nprogress .spinner-icon {
  border-top-color: var(--theme-color);
  border-left-color: var(--theme-color);
}

#nprogress .peg {
  box-shadow: 0 0 10px var(--theme-color), 0 0 5px var(--theme-color);
}

#nprogress .bar {
  background: var(--theme-color);
}

#gohome {
  background: var(--theme-color);
}

#archives-temp h2 {
  color: var(--theme-color);
}

#archives-temp h3 {
  color: var(--theme-color);
}

#mobileGoTop {
  color: var(--theme-color);
}

#changeSkin {
  color: var(--theme-color);
}

#show-nav .line {
  background: var(--theme-color);
}

#nprogress .spinner-icon {
  border-top-color: var(--theme-color);
  border-left-color: var(--theme-color);
}

#nprogress .bar {
  background: var(--theme-color);
}

#aplayer-float .aplayer-lrc-current {
  color: var(--theme-color);
}

@media (max-width: 860px) {
  .links ul li:hover .sitename {
    color: var(--theme-color-matching);
  }

  .openNav .icon {
    background-color: var(--theme-color);
  }

  .openNav .icon:after,
  .openNav .icon:before {
    background-color: var(--theme-color);
  }

  #mo-nav ul li a {
    color: var(--theme-color);
  }

  #mo-nav ul li a:hover {
    color: var(--theme-color-matching);
  }

  ::-webkit-scrollbar-thumb {
    background-color: var(--theme-color);
    border-radius: 25px;
  }
}

.herder-user-name {
  color: var(--theme-color);
}

.header-user-menu a {
  color: var(--theme-color);
}

.no-logged a {
  color: var(--theme-color);
}
';

        /*Logo 特效*/
        if (akina_option('logocss', '1')):
            $result .= '
.logolink .sakuraso {
  background-color: rgba(255, 255, 255, .5);
  border-radius: 5px;
  color: var(--theme-color);
  height: auto;
  line-height: 25px;
  margin-right: 0;
  padding-bottom: 0px;
  padding-top: 1px;
  text-size-adjust: 100%;
  width: auto
}

.logolink a:hover .sakuraso {
  background-color: var(--theme-color-matching);
  color: #fff;
}

.logolink a:hover .shironeko,
.logolink a:hover .no,
.logolink a:hover rt {
  color: var(--theme-color-matching);
}

.logolink.moe-mashiro a {
  color: var(--theme-color);
  float: left;
  font-size: 25px;
  font-weight: 800;
  height: 56px;
  line-height: 56px;
  padding-left: 6px;
  padding-right: 15px;
  padding-top: 11px;
  text-decoration-line: none;
}

.logolink.moe-mashiro .sakuraso, .logolink.moe-mashiro .no {
  font-size: 25px;
  border-radius: 9px;
  padding-bottom: 2px;
  padding-top: 5px;
}

.logolink.moe-mashiro .no {
  font-size: 20px;
  display: inline-block;
  margin-left: 5px;
}

.logolink a:hover .no {
  -webkit-animation: spin 1.5s linear infinite;
  animation: spin 1.5s linear infinite;
}

.logolink ruby {
  ruby-position: under;
  -webkit-ruby-position: after;
}

.logolink ruby rt {
  font-size: 10px;
  letter-spacing: 2px;
  transform: translateY(-15px);
  opacity: 0;
  transiton-property: opacity;
  transition-duration: 0.5s, 0.5s;
}

.logolink a:hover ruby rt {
  opacity: 1
}
';
        endif;

        $result .= '
.logolink a {
  color: var(--theme-color);
}

.art .art-content .al_mon_list .al_post_list > li:after {
  background: var(--theme-color);
}

@media (min-width: 861px) {
  .hide-live2d {
    background-color: var(--theme-color);
  }
}

.art-content #archives .al_mon_list .al_mon:after {
  background: var(--theme-color);
}

.art-content #archives .al_mon_list:before {
  background: var(--theme-color);
}

.changeSkin-gear {
  color: var(--theme-color);
}

.art .art-content .al_mon_list .al_post_list > li:after,
.art-content #archives .al_mon_list .al_mon:after {
  background: var(--theme-color);
}

.is-active-link::before {
  background-color: var(--theme-color); /*!important*/ /*mark*/
}

.float-content i {
  color: var(--theme-color);
}

.scrollbar {
  background: var(--theme-color);
}

.insert-image-tips:hover {
  color: var(--theme-color-matching);
  border: 1px solid var(--theme-color-matching);
}

.insert-image-tips-hover {
  color: var(--theme-color-matching);
  border: 1px solid var(--theme-color-matching);
}

.the-feature a {
  color: var(--theme-color);
}

#mobileGoTop:hover,
#changeSkin:hover {
  color: var(--theme-color-matching);
  background-color: #fff;
  opacity: .8;
}

.menu-list li:hover {
  background-color: var(--theme-color-matching);
}

.art .art-content #archives a:hover {
  color: var(--theme-color-matching);
}

.art .art-content .al_mon_list .al_post_list > li,
.art-content #archives .al_mon_list .al_mon {
  color: var(--theme-color);
}

.font-family-controls button.selected {
  background-color: var(--theme-color);
}

.font-family-controls button:hover {
  background-color: var(--theme-color-matching);
}

.art-content #archives .al_mon_list .al_mon,
.art-content #archives .al_mon_list span {
  color: var(--theme-color);
}

h1.fes-title,
h1.main-title {
  color: var(--theme-color);
}

.font-family-controls button {
  color: var(--theme-color);
}
';

        if (akina_option('light-cmanage') == "sep") {
            $result .= '
/*淡色彩管理*/
.menu-list li {
  background-color: ' . akina_option('fore-switch-sele-bc') . ';
}

.font-family-controls button {
  background-color: ' . akina_option('fore-switch-sele-bc') . ';
}

    h1.fes-title,
    h1.main-title {
    border-bottom: 6px dotted ' . akina_option('hpage-art-sc') . ';
    }

    .post-date {
    background-color: ' . akina_option('hpage-art-tpebc') . ';
    }

    .post-list-thumb {
    box-shadow: 0 1px 30px -4px ' . akina_option('hpage-art-bsc') . ';
    }

    .center-text {
    color: ' . akina_option('hpage-ket-tfc') . ';
    }
';
        }

        if (akina_option('light-cmanage') == "mer") {
            $result .= '
.menu-list li {
  background-color: ' . akina_option('light-color') . ';
}

.font-family-controls button {
  background-color: ' . akina_option('light-color') . ';
}

h1.fes-title,
h1.main-title {
  border-bottom: 6px dotted ' . akina_option('light-color') . ';
}

.post-date {
  background-color: ' . akina_option('light-color') . ';
}

.post-list-thumb {
  box-shadow: 0 1px 30px -4px ' . akina_option('light-color') . ';
}

.center-text {
  color: ' . akina_option('light-color') . ';
}
';
        }

        if (akina_option('entry_content_theme') == SAKURA_DOMAIN) {
            $result .= '
.entry-content th {
  background-color: var(--theme-color);
}
';
        }

        if (akina_option('live_search')) {
            $result .= '
.search-form--modal .search-form__inner {
  bottom: unset !important;
  top: 10% !important;
}
';
        }

        $result .= '
.post-list-thumb {
  opacity: 0;
}

.post-list-show {
  opacity: 1;
}
';
    }

    // Custom style
    if (akina_option('site_custom_style')) {
        $result .= akina_option('site_custom_style');
    }

    // liststyle
    if (akina_option('list_type') == 'square') {
        $result .= '
.feature img {
  border-radius: 0px;
  !important;
}

.feature i {
  border-radius: 0px;
  !important;
}
';
    }

    // comments
    if (akina_option('toggle-menu') == 'no') {
        $result .= '
.comments .comments-main {
  display: block !important;
}

.comments .comments-hidden {
  display: none !important;
}
';
    }
    //$image_api = 'background-image: url("'.asakura_rest_url('image/cover').'");';
    $bg_style = akina_option('focus_height') ? '  background-position: center center;
  background-attachment: inherit;' : '';

    $result .= "
.centerbg {
$bg_style
  background-position: center center;
  background-attachment: inherit;
}

.rotating {
  -webkit-animation: rotating 6s linear infinite;
  -moz-animation: rotating 6s linear infinite;
  -ms-animation: rotating 6s linear infinite;
  -o-animation: rotating 6s linear infinite;
  animation: rotating 6s linear infinite;
}
";

    if (akina_option('preload_animation', '1')):
        $result .= '
/*预加载部分*/
#preload {
  position: absolute;
  width: 100%;
  height: 100%;
  top: 0;
  left: 0;
  background: #ffffff;
  z-index: 99999;
}

#preload li.active {
  position: absolute;
  top: 49%;
  left: 49%;
  list-style: none;
}

html {
  overflow-y: hidden;
}

#preloader_3 {
  position: relative;
}

#preloader_3:before {
  width: 20px;
  height: 20px;
  border-radius: 20px;
  background: ' . akina_option('preload-ani-c1') . ';
  content: \'\';
  position: absolute;
  background: ' . akina_option('preload-ani-c2') . ';
  -webkit-animation: preloader_3_before 1.5s infinite ease-in-out;
  -moz-animation: preloader_3_before 1.5s infinite ease-in-out;
  -ms-animation: preloader_3_before 1.5s infinite ease-in-out;
  animation: preloader_3_before 1.5s infinite ease-in-out;
}

#preloader_3:after {
  width: 20px;
  height: 20px;
  border-radius: 20px;
  background: ' . akina_option('preload-ani-c1') . ';
  content: \'\';
  position: absolute;
  background: ' . akina_option('preload-ani-c1') . ';
  left: 22px;
  -webkit-animation: preloader_3_after 1.5s infinite ease-in-out;
  -moz-animation: preloader_3_after 1.5s infinite ease-in-out;
  -ms-animation: preloader_3_after 1.5s infinite ease-in-out;
  animation: preloader_3_after 1.5s infinite ease-in-out;
}

@-webkit-keyframes preloader_3_before {
  0% {
    -webkit-transform: translateX(0px) rotate(0deg)
  }
  50% {
    -webkit-transform: translateX(50px) scale(1.2) rotate(260deg);
    background: ' . akina_option('preload-ani-c1') . ';
    border-radius: 0px;
  }
  100% {
    -webkit-transform: translateX(0px) rotate(0deg)
  }
}

@-webkit-keyframes preloader_3_after {
  0% {
    -webkit-transform: translateX(0px)
  }
  50% {
    -webkit-transform: translateX(-50px) scale(1.2) rotate(-260deg);
    background: ' . akina_option('preload-ani-c2') . ';
    border-radius: 0px;
  }
  100% {
    -webkit-transform: translateX(0px)
  }
}

@-moz-keyframes preloader_3_before {
  0% {
    -moz-transform: translateX(0px) rotate(0deg)
  }
  50% {
    -moz-transform: translateX(50px) scale(1.2) rotate(260deg);
    background: ' . akina_option('preload-ani-c1') . ';
    border-radius: 0px;
  }
  100% {
    -moz-transform: translateX(0px) rotate(0deg)
  }
}

@-moz-keyframes preloader_3_after {
  0% {
    -moz-transform: translateX(0px)
  }
  50% {
    -moz-transform: translateX(-50px) scale(1.2) rotate(-260deg);
    background: ' . akina_option('preload-ani-c2') . ';
    border-radius: 0px;
  }
  100% {
    -moz-transform: translateX(0px)
  }
}

@-ms-keyframes preloader_3_before {
  0% {
    -ms-transform: translateX(0px) rotate(0deg)
  }
  50% {
    -ms-transform: translateX(50px) scale(1.2) rotate(260deg);
    background: ' . akina_option('preload-ani-c1') . ';
    border-radius: 0px;
  }
  100% {
    -ms-transform: translateX(0px) rotate(0deg)
  }
}

@-ms-keyframes preloader_3_after {
  0% {
    -ms-transform: translateX(0px)
  }
  50% {
    -ms-transform: translateX(-50px) scale(1.2) rotate(-260deg);
    background: ' . akina_option('preload-ani-c2') . ';
    border-radius: 0px;
  }
  100% {
    -ms-transform: translateX(0px)
  }
}

@keyframes preloader_3_before {
  0% {
    transform: translateX(0px) rotate(0deg)
  }
  50% {
    transform: translateX(50px) scale(1.2) rotate(260deg);
    background: ' . akina_option('preload-ani-c1') . ';
    border-radius: 0px;
  }
  100% {
    transform: translateX(0px) rotate(0deg)
  }
}

@keyframes preloader_3_after {
  0% {
    transform: translateX(0px)
  }
  50% {
    transform: translateX(-50px) scale(1.2) rotate(-260deg);
    background: ' . akina_option('preload-ani-c2') . ';
    border-radius: 0px;
  }
  100% {
    transform: translateX(0px)
  }
}
';

    endif;
    $result .= '
/*深色模式*/

/*固定项目*/
body.dark #main-container,
body.dark #mo-nav,
body.dark .comments,
body.dark .site-footer,
body.dark .wrapper,
body.dark .post-list-show,
body.dark .post-list hr,
body.dark .lower li ul,
body.dark .header-user-menu,
body.dark .headertop-bar::after {
  background: #31363b !important;
}

body.dark .pattern-center-blank,
body.dark .yya,
body.dark .blank,
body.dark .toc,
body.dark .search-form input {
  background: rgba(49, 54, 59, 0.85);
}

body.dark .single-reward .reward-row,
body.dark input.m-search-input {
  background: #bebebe;
}

body.dark .ins-section .ins-search-item.active,
body.dark .ins-section .ins-search-item.active .ins-slug,
body.dark .ins-section .ins-search-item.active .ins-search-preview,
body.dark .herder-user-name-u,
body.dark .herder-user-name,
body.dark .header-user-menu .user-menu-option {
  color: #fff;
  background: #31363b;
}

body.dark .single-reward .reward-row:before {
  border-bottom: 13px solid #bebebe;
}

body.dark .search-form--modal,
body.dark .ins-section .ins-section-header {
border-bottom: none;
  background: rgba(49, 54, 59, 0.95);
}

body.dark .search_close:after,
body.dark .search_close:before,
body.dark .openNav .icon,
body.dark .openNav .icon:before {
  background-color: #eee;
}

body.dark .centerbg {
background-blend-mode: hard-light;
  background-color: #31363b;
}

body.dark input[type=color]:focus,
body.dark input[type=date]:focus,
body.dark input[type=datetime-local]:focus,
body.dark input[type=datetime]:focus,
body.dark input[type=email]:focus,
body.dark input[type=month]:focus,
body.dark input[type=number]:focus,
body.dark input[type=password]:focus,
body.dark input[type=range]:focus,
body.dark input[type=search]:focus,
body.dark input[type=tel]:focus,
body.dark input[type=text]:focus,
body.dark input[type=time]:focus,
body.dark input[type=url]:focus,
body.dark input[type=week]:focus,
body.dark textarea:focus,
body.dark .post-date,
body.dark #mo-nav .m-search form {
  color: #eee;
  background-color: #31363b;
}

body.dark .header-user-menu::before,
body.dark .lower li ul::before {
  border-color: transparent transparent #31363b transparent;
}

body.dark .post-date,
body.dark .header-user-menu .user-menu-option,
body.dark .post-list-thumb a {
  color: #424952;
}

body.dark .entry-content p,
body.dark .entry-content ul,
body.dark .entry-content ol,
body.dark .comments .body p,
body.dark .float-content,
body.dark .post-list p,
body.dark .link-title {
  color: #bebebe !important;
}

body.dark .entry-title a,
body.dark .post-list-thumb .post-title,
body.dark .art-content #archives .al_mon_list .al_mon,
body.dark .art-content #archives .al_mon_list span,
body.dark .art .art-content #archives a,
body.dark .ex-login-username,
body.dark .admin-login-check p,
body.dark .user-login-check p,
body.dark .ex-logout a,
body.dark .ex-new-account a {
  color: #bebebe;
}

body.dark .site-top ul li a,
body.dark .header-user-menu a,
body.dark #mo-nav ul li a,
body.dark .site-title a,
body.dark header.page-header,
body.dark h1.cat-title,
body.dark .art .art-content #archives .al_year,
body.dark .comment-respond input,
body.dark .comment-respond textarea,
body.dark .siren-checkbox-label,
body.dark .aplayer .aplayer-list ol li .aplayer-list-author,
body.dark,
body.dark button,
body.dark input,
body.dark select,
body.dark textarea,
body.dark i.iconfont.js-toggle-search.iconsearch,
body.dark .skin-menu {
  color: #eee;
}

body.dark .post-date,
body.dark .post-list-thumb a,
body.dark .post-list-thumb i,
body.dark .post-meta,
body.dark .info-meta a,
body.dark .info-meta span {
  color: #888;
}

body.dark .post-list-thumb {
  box-shadow: 0 1px 35px -8px rgba(0, 0, 0, 0.8);
}

body.dark .notice {
  color: #EFF0F1;
  background: #232629;
  border: none;
}

body.dark h1.fes-title,
body.dark h1.main-title {
border-bottom: 6px dotted #535a63;
  color: #888;
}

body.dark .widget-area .heading,
body.dark .widget-area .show-hide svg,
body.dark #aplayer-float,
body.dark .aplayer.aplayer-fixed .aplayer-body,
body.dark .aplayer .aplayer-miniswitcher,
body.dark .aplayer .aplayer-pic {
  color: #eee;
  background-color: #232629 !important;
}

body.dark #aplayer-float .aplayer-lrc-current {
  color: transparent !important;
}

body.dark .aplayer.aplayer-fixed .aplayer-lrc {
  text-shadow: -1px -1px 0 #989898;
}

body.dark .aplayer.aplayer-fixed .aplayer-list {
  border: none !important;
}

body.dark .aplayer.aplayer-fixed .aplayer-info,
body.dark .aplayer .aplayer-list ol li {
  border-top: none !important;
}

body.dark .yya {
  box-shadow: 0 1px 40px -8px #21252b;
}

body.dark .font-family-controls button,
body.dark .menu-list li {
  background-color: #31363b;
}

body.dark .s-content, body.dark .font-family-controls button.selected {
  background-color: #535a63;
}

body.dark #banner_wave_1,
body.dark #banner_wave_2,
body.dark .skin-menu::after {
  display: none;
}

body.dark .widget-area .show-hide svg path {
  fill: #fafafa;
}

body.dark button,
body.dark input[type=button],
body.dark input[type=reset],
body.dark input[type=submit] {
  box-shadow: none;
}

body.dark .widget-area,
body.dark input[type=submit] {
  background-color: rgba(35, 38, 41, 0.8);
}

body.dark .comment .info,
body.dark .comment-respond .logged-in-as,
body.dark .notification,
body.dark .comment-respond .logged-in-as a {
  color: #9499a8;
}

body.dark .header-user-avatar:hover,
body.dark .aplayer .aplayer-list ol li.aplayer-list-light,
body.dark .site-header:hover {
  background: #31363b;
}

body.dark #mobileGoTop,
body.dark #changeSkin {
  background-color: #232629;
}

body.dark #show-nav .line {
  background: #eee;
}

/*可变项目*/

/*深色模式控件透明度*/
body.dark .header-info,
body.dark .top-social img {
  color: #fff;
  background: rgba(0, 0, 0, ' . akina_option('dark-widget-tmd') . ');
}

body.dark .notification,
body.dark .the-feature.from_left_and_right .info {
  background-color: rgba(0, 0, 0, ' . akina_option('dark-widget-tmd') . ');
}

body.dark .skin-menu {
  background-color: rgba(0, 0, 0, ' . akina_option('dark-widget-tmd') . ') !important;
}

body.dark .headertop-down i {
  color: rgba(255, 255, 255, ' . akina_option('dark-widget-tmd') . ');
  background: rgba(0, 0, 0, ' . akina_option('dark-widget-tmd') . ');
  border-radius: 5px;
  padding: 2px 2px 5px 2px;
}

/*深色模式图像亮度*/
body.dark img,
body.dark .highlight-wrap,
body.dark iframe,
body.dark .entry-content .aplayer,
body.dark .headertop-down i {
  filter: brightness(' . akina_option('dark_imgbri') . ');
}

/*深色模式主题色*/
body.dark .scrollbar,
body.dark .butterBar-message,
body.dark .aplayer .aplayer-list ol li:hover,
body.dark .pattern-center:after {
  background: ' . akina_option('theme_dark') . ' !important;
}

body.dark .aplayer .aplayer-list ol li.aplayer-list-light .aplayer-list-cur,
body.dark .user-menu-option a:hover,
body.dark .menu-list li:hover,
body.dark .font-family-controls button:hover,
body.dark .openNav .icon,
body.dark .openNav .icon:before,
body.dark .openNav .icon:after,
body.dark .openNav .icon:after,
body.dark .site-top ul li a:after {
  background-color: ' . akina_option('theme_dark') . ';
}

body.dark #mobileGoTop,
body.dark #changeSkin,
body.dark .the-feature.from_left_and_right a:hover .info p,
body.dark .the-feature.from_left_and_right .info,
body.dark .ins-section .ins-search-item:hover,
body.dark .ins-section .ins-search-item:hover .ins-slug,
body.dark .ins-section .ins-search-item:hover .ins-search-preview,
body.dark .ins-section .ins-search-item:hover .iconfont,
body.dark .float-content i:hover,
body.dark .menhera-container .emoji-item:hover,
body.dark .comment-respond .logged-in-as a:hover,
body.dark .site-top ul li a:hover,
body.dark i.iconfont.js-toggle-search.iconsearch:hover {
  color: ' . akina_option('theme_dark') . ';
}

body.dark .aplayer .aplayer-info .aplayer-controller .aplayer-time .aplayer-icon:hover path {
  fill: ' . akina_option('theme_dark') . ';
}

body.dark #mobileGoTop:hover,
body.dark #changeSkin:hover {
  color: ' . akina_option('theme_dark') . ';
  opacity: .8;
}

body.dark .focusinfo .header-tou img {
  box-shadow: inset 0 0 10px ' . akina_option('theme_dark') . ';
}

@media (max-width: 1200px) {
  body.dark .site-top .lower nav.navbar ul {
    background: rgba(255, 255, 255, 0);
  }
}

/*切换动画*/
html, #main-container, .pattern-center:after, #mo-nav, .headertop-bar::after, .comments, .site-footer, .pattern-center-blank, .yya, .blank, .toc, .search-form input, .wrapper, .site-footer, .site-wrapper, #mobileGoTop:hover, #changeSkin:hover, .post-list-show, .post-list hr, .post-date, .float-content i:hover {
  transition: background 1s;
}

.entry-content p, .entry-content ul, .entry-content ol, .comments .body p, .float-content, .post-list p, .link-title {
  transition: color 1s;
}

h1.fes-title, h1.main-title {
  transition: color 1s;
  transition: border 1s;
}

.header-info, .focusinfo .header-tou img, .top-social img, .center-text {
  transition: color 1s;
  transition: background 1s;
}

.header-info p {
  transition: color .4s;
}

/*字重*/
h1, small, sub, sup, code, kbd, pre, samp, body, button, input, select, textarea, blockquote:before, blockquote:after, code, kbd, tt, var, big, button, input[type=button], input[type=reset], input[type=submit], .video-stu, .pattern-center h1.cat-title, .pattern-center h1.entry-title, .pattern-center .cat-des, .single-center .single-header h1.entry-title, .single-center .entry-census, .single-center .single-header h1.entry-title, .single-center .entry-census, .site-top .lower, .site-top .menu-item-has-children li a, .feature i, .p-time, .p-time i, i.iconfont.hotpost, .post-list p, .post-more i, .info-meta span, .post-list-thumb i, .post-date, .post-meta, .post-meta a, .float-content .post-text, .float-content i, .s-time, .s-time i, .navigator i, .site-info, .entry-census, h1.page-title, .post-lincenses, .post-tags, .post-like a, .post-like i, .post-share ul li i, .post-squares .category, .post-squares h3, .post-squares .label, .author-profile .meta h3 a, .author-profile p, .author-profile i, .mashiro-profile .box a, #comments-list-title span, .butterBar-message, h1.works-title, .works-p-time, .works-p-time i, .works-meta i, .works-meta span, #archives-temp h3, h1.cat-title, span.sitename, span.linkss-title, .comment .commeta, .comment .comment-reply-link, .comment .info, .comment .info .useragent-info-m, .comment h4, .comment h4 a, .comment-respond #cancel-comment-reply-link, .comment-respond input, .comment-respond textarea, .comment-respond .logged-in-as i, .notification i, .notification span, .siren-checkbox-label, h1.fes-title, h1.main-title, .foverlay-bg, .feature-title .foverlay, .notice i, .bio-text, .header-info, .site-header.iconsearch, i.iconfont.js-toggle-search.iconsearch, .search-form i, .search-form input, .s-search input, .s-search i, .ins-section, .ins-section .iconfont.icon-mark, .ins-section .fa, .ins-section.ins-search-item .search-keyword, .ins-section .ins-search-item .ins-search-preview, i.iconfont.down, #pagination span, #bangumi-pagination span, .ex-login-title, .ex-register-title h3, .ex-login input, .ex-register input, .admin-login-check, .user-login-check, .ex-login-username, .ex-new-account a, .ex-register .user-error, .register-close, .herder-user-name, .header-user-menu a, .no-logged, .no-logged a, .single-reward .reward-open, .reward-row li::after, .botui-container, button.botui-actions-buttons-button, input.botui-actions-text-input, .load-button span, .prpr, .mashiro-tips, .live2d-tool, .center-text, .bb-comment, .finish-icon-container, .skill div, #footer-sponsor, .comment-user-avatar .socila-check, .insert-image-tips, .the-feature.from_left_and_right .info h3, .the-feature.from_left_and_right .info p, .highlight-wrap .copy-code, #bangumi-pagination {
  font-weight: ' . akina_option('fontweight') . ' !important
}

/*字体*/';
    if (akina_option('refer-ext-font', '1')) {
        $result .= '
@font-face {
  font-family: \'' . akina_option('ext-font-name') . '\';
  src: url(\'' . akina_option('ext-font-address') . '\');
}';
    }

    $result .= '
.serif {
  font-family: ' . akina_option('global-default-font') . ' !important ;
  font-size: ' . akina_option('global-fontsize') . 'px !important;
}

body {
  font-family: ' . akina_option('global-font2') . ' !important;
  font-size: ' . akina_option('global-fontsize') . 'px !important;
}

h1.main-title, h1.fes-title {
  font-family: ' . akina_option('font-title') . ' !important;
}

.header-info p {
  font-family: ' . akina_option('font-oneword') . ' !important;
  font-size: ' . akina_option('font-oneword') . 'px !important;
}

.post-list-thumb .post-title h3 {
  font-size: ' . akina_option('article-title-size') . 'px !important;
}

.post-meta, .post-meta a {
  font-size: ' . akina_option('article-tips-size') . 'px !important;
}

h1.entry-title {
  font-size: ' . akina_option('article-paget') . 'px !important;
}

.Ubuntu-font, .center-text {
  font-family: ' . akina_option('keytitlefont') . ';
}

.center-text {
  font-size: ' . akina_option('keytitle_size') . 'px;
}

/*鼠标*/
body {
  cursor: url(' . akina_option('cursor-nor') . '), auto;
}

.botui-actions-buttons-button,
.headertop-down i,
.faa-parent.animated-hover:hover > .faa-spin,
.faa-spin.animated,
.faa-spin.animated-hover:hover,
i.iconfont.js-toggle-search.iconsearch,
#waifu #live2d,
.aplayer svg,
.aplayer.aplayer-narrow .aplayer-body,
.aplayer.aplayer-narrow .aplayer-pic,
button.botui-actions-buttons-button,
.on-hover,
#mobileGoTop,
#changeSkin {
  cursor: url(' . akina_option('cursor-no') . '), auto;
}

a,
.ins-section .ins-section-header,
.font-family-controls button,
.menu-list li, .ins-section .ins-search-item,
.ins-section .ins-search-item .ins-search-preview {
  cursor: url(' . akina_option('cursor-ayu') . '), auto;
}

p,
.highlight-wrap code,
.highlight-wrap,
.hljs-ln-code .hljs-ln-line {
  cursor: url(' . akina_option('cursor-text') . '), auto;
}

a:active {
  cursor: url(' . akina_option('cursor-work') . '), alias;
}

/*背景类*/
.comment-respond textarea {
  background-image: url(' . akina_option('cursor-image') . ');
}

.search-form.is-visible {
  background-image: url(' . akina_option('search-image') . ');
}

.wrapper,
.site-footer {
  background-color: rgba(255, 255, 255, ' . akina_option('homepagebgtmd') . ');
}

/*首页圆角设置*/
.header-info {
  border-radius: ' . akina_option('info-radius') . 'px;
}

.focusinfo img {
  border-radius: ' . akina_option('img-radius') . 'px;
}

.focusinfo .header-tou img {
  border-radius: ' . akina_option('head-radius') . 'px;
}

/*标题横线动画*/
';
    if (akina_option('title-line', '1')):
        $result .= '
.single-center header.single-header .toppic-line {
  position: relative;
  bottom: 0;
  left: 0;
  display: block;
  width: 100%;
  height: 2px;
  background-color: #fff;
  animation: lineWidth 2.5s;
  animation-fill-mode: forwards;
}

@keyframes lineWidth {
  0% {
    width: 0;
  }
  100% {
    width: 100%;
  }
}
';
    endif;

    /*标题动画*/
    if (akina_option('title-ani', '1')) {
        $result .= '
.entry-title, .single-center .entry-census a, .entry-census, .post-list p, .post-more i, .p-time, .feature {
  -moz-animation: fadeInUp ' . akina_option('title-ani-t') . 's;
  -webkit-animation: fadeInUp ' . akina_option('title-ani-t') . 's;
  animation: fadeInUp ' . akina_option('title-ani-t') . 's;
}
';
    }

    /*首页动画*/
    if (akina_option('homepage-ani', '1')) {
        $result .= '
h1.main-title, h1.fes-title, .the-feature.from_left_and_right .info, .header-info p, .header-info, .focusinfo .header-tou img, .top-social img, .center-text {
  -moz-animation: fadeInDown ' . akina_option('hp-ani-t') . 's;
  -webkit-animation: fadeInDown ' . akina_option('hp-ani-t') . 's;
  animation: fadeInDown ' . akina_option('hp-ani-t') . 's;
}
';
    }

    $result .= '
/*浮起动画*/
/*向上*/
@-moz-keyframes fadeInUp {
  0% {
    -moz-transform: translateY(200%);
    transform: translateY(200%);
    opacity: 0
  }

  50% {
    -moz-transform: translateY(200%);
    transform: translateY(200%);
    opacity: 0
  }

  100% {
    -moz-transform: translateY(0%);
    transform: translateY(0%);
    opacity: 1
  }
}

@-webkit-keyframes fadeInUp {
  0% {
    -webkit-transform: translateY(200%);
    transform: translateY(200%);
    opacity: 0
  }

  50% {
    -webkit-transform: translateY(200%);
    transform: translateY(200%);
    opacity: 0
  }

  100% {
    -webkit-transform: translateY(0%);
    transform: translateY(0%);
    opacity: 1
  }
}

@keyframes fadeInUp {
  0% {
    -moz-transform: translateY(200%);
    -ms-transform: translateY(200%);
    -webkit-transform: translateY(200%);
    transform: translateY(200%);
    opacity: 0
  }

  50% {
    -moz-transform: translateY(200%);
    -ms-transform: translateY(200%);
    -webkit-transform: translateY(200%);
    transform: translateY(200%);
    opacity: 0
  }

  100% {
    -moz-transform: translateY(0%);
    -ms-transform: translateY(0%);
    -webkit-transform: translateY(0%);
    transform: translateY(0%);
    opacity: 1
  }
}

/*向下*/
@-moz-keyframes fadeInDown {
  0% {
    -moz-transform: translateY(-100%);
    transform: translateY(-100%);
    opacity: 0
  }

  50% {
    -moz-transform: translateY(-100%);
    transform: translateY(-100%);
    opacity: 0
  }

  100% {
    -moz-transform: translateY(0%);
    transform: translateY(0%);
    opacity: 1
  }
}

@-webkit-keyframes fadeInDown {
  0% {
    -webkit-transform: translateY(-100%);
    transform: translateY(-100%);
    opacity: 0
  }

  50% {
    -webkit-transform: translateY(-100%);
    transform: translateY(-100%);
    opacity: 0
  }

  100% {
    -webkit-transform: translateY(0%);
    transform: translateY(0%);
    opacity: 1
  }
}

@keyframes fadeInDown {
  0% {
    -moz-transform: translateY(-100%);
    -ms-transform: translateY(-100%);
    -webkit-transform: translateY(-100%);
    transform: translateY(-100%);
    opacity: 0
  }

  50% {
    -moz-transform: translateY(-100%);
    -ms-transform: translateY(-100%);
    -webkit-transform: translateY(-100%);
    transform: translateY(-100%);
    opacity: 0
  }

  100% {
    -moz-transform: translateY(0%);
    -ms-transform: translateY(0%);
    -webkit-transform: translateY(0%);
    transform: translateY(0%);
    opacity: 1
  }
}

/*其他*/
';

    if (akina_option('post-lincenses', '1')) {
        $result .= '
.post-lincenses a {
  display: none;
}

.post-footer {
  border-bottom: 0px;
  border-top: 0px;
}
';
    }

    if (akina_option('user-avatar', '1')) {
        $result .= '
.header-user-avatar {
  display: none;
}
';
    }

    if (akina_option('godown-mb', '1')) {
        $result .= '
@media (max-width: 860px) {
  .headertop-down {
    display: none
  }
}
';
    }

    $result .= '
.widget-area .sakura_widget {
  background-image: url(' . akina_option('sakura_widget_bg', '') . ');
}
';

    if (akina_option('hpage-art-dis', '1')) {
        $result .= '
.float-content i {
  display: none;
}
';
    }

    if (akina_option('social-card', '1')) {
        $result .= '
.top-social_v2, .top-social {
  display: none;
}
';
    }

    if (akina_option('search-ico', '1')) {
        $result .= '
i.iconfont.js-toggle-search.iconsearch {
  font-size: 25px;
}
';
    }

    if (akina_option('friend_center', '0')) {
        $result .= '
/*友链居中 */
span.sitename {
  margin: 0px;
}

.linkdes {
  margin: 0px;
}

li.link-item {
  text-align: center;
}

.links ul li img {
  float: none;
}
';
    }

    if (akina_option('feature_align') == 'left') {
        $result .= '
.post-list-thumb .post-content-wrap {
  float: left;
  padding-left: 30px;
  padding-right: 0;
  text-align: right;
  margin: 20px 10px 10px 0
}

.post-list-thumb .post-thumb {
  float: left
}

.post-list-thumb .post-thumb a {
  border-radius: 10px 0 0 10px
}
';
    }

    if (akina_option('feature_align') == 'alternate') {
        $result .= '
.post-list-thumb:nth-child(2n) .post-content-wrap {
  float: left;
  padding-left: 30px;
  padding-right: 0;
  text-align: right;
  margin: 20px 10px 10px 0
}

.post-list-thumb:nth-child(2n) .post-thumb {
  float: left
}

.post-list-thumb:nth-child(2n) .post-thumb a {
  border-radius: 10px 0 0 10px
}';
    }

    return $result;
}

function add_customizer_css_head() { ?>
    <link rel="stylesheet" href="/wp-json/<?= SAKURA_REST_API ?>/style/custom">
    <?php
}

add_action('wp_head', 'add_customizer_css_head');
