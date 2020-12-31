<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Sakura
 */

?>
</div><!-- #content -->
<?php
comments_template('', true);
?>
</div><!-- #page Pjax container-->
<footer id="colophon" class="site-footer" role="contentinfo">
    <div class="site-info" theme-info="Asakura v<?php echo SAKURA_VERSION; ?>">
        <div class="footertext">
            <div class="img-preload">
                <img src="<?php echo akina_option('webweb_img'); ?>/load/ball.svg"><!-- 加载下一部分圈圈 -->
            </div>
            <i class="iconfont icon-sakura rotating"
               style="color:var(--theme-color);display:inline-block;font-size:26px"></i></p>
            <p style="color: #666666;"><?php echo akina_option('footer_info'); ?></p>
        </div>
        <div class="footer-device">
            <p style="font-family: 'Ubuntu', sans-serif;">
					<span style="color: #b9b9b9;">
                        <?php if (akina_option('oneword')): ?>
                            <script type="text/javascript"
                                    src="https://api.btstu.cn/yan/api.php?charset=utf-8&encode=js"></script>
                            <div id="yan"><script>text()</script></div>
                        <?php endif; ?>
                        <?php if (akina_option('loadoq')): // TODO: i18n                ?>
                            <?php printf(' 耗时 %.3f 秒 | 查询 %d 次 | 内存 %.2f MB', timer_stop(0, 3), get_num_queries(), memory_get_peak_usage() / 1024 / 1024); ?>
                        <?php endif; ?>
            Theme <a href="https://blog.mmf.moe/post/theme-asakura/" target="_blank" id="site-info">Asakura (o・∇・o)</a>
            by <a href="https://mmf.moe/" target="_blank" id="site-info">Yesterday17</a>
            </span>
            </p>
        </div>
    </div><!-- .site-info -->
</footer><!-- #colophon -->
<div class="openNav no-select">
    <div class="iconflat no-select">
        <div class="icon"></div>
    </div>
    <div class="site-branding">
        <?php if (akina_option('akina_logo')) { ?>
            <div class="site-title">
                <a href="<?php bloginfo('url'); ?>">
                    <img src="<?php echo akina_option('akina_logo'); ?>">
                </a>
            </div>
        <?php } else { ?>
            <h1 class="site-title"><a href="<?php bloginfo('url'); ?>"><?php bloginfo('name'); ?></a></h1>
        <?php } ?>
    </div>
</div><!-- m-nav-bar -->
</section><!-- #section -->
<!-- m-nav-center -->
<div id="mo-nav">
    <div class="m-avatar">
        <img src="<?= get_avatar_profile_url(); ?>">
    </div>
    <div class="m-search">
        <form class="m-search-form" method="get" action="<?php echo home_url(); ?>" role="search">
            <input class="m-search-input" type="search" name="s"
                   placeholder="<?php ee('Search...') /*搜索...*/ ?>" required>
        </form>
    </div>
    <?php wp_nav_menu(array('depth' => 2, 'theme_location' => 'primary', 'container' => false)); ?>
</div><!-- m-nav-center end -->
<a class="cd-top faa-float animated "></a>
<button id="mobileGoTop" title="Go to top"><i class="fa fa-chevron-up" aria-hidden="true"></i></button>
<button id="changeSkin" style="bottom: 15px;"><i class="iconfont icon-gear inline-block rotating"></i></button>
<!-- search start -->
<form class="js-search search-form search-form--modal" method="get" action="<?php echo home_url(); ?>"
      role="search">
    <div class="search-form__inner">
        <?php if (akina_option('live_search')) { ?>
            <div class="micro">
                <i class="iconfont icon-search"></i>
                <input id="search-input" class="text-input" type="search" name="s"
                       placeholder="<?php ee('Want to find something?') /*想要找点什么呢*/ ?>" required>
            </div>
            <div class="ins-section-wrapper">
                <a id="Ty" href="#"></a>
                <div class="ins-section-container" id="post-list-box"></div>
            </div>
        <?php } else { ?>
            <div class="micro">
                <p class="micro mb-"><?php ee('Want to find something?') /*想要找点什么呢*/ ?></p>
                <i class="iconfont icon-search"></i>
                <input class="text-input" type="search" name="s" placeholder="<?php ee('Search') ?>"
                       required>
            </div>
        <?php } ?>
    </div>
    <div class="search_close"></div>
</form>
<!-- search end -->
<?php wp_footer(); ?>
<div class="skin-menu no-select">
    Style
    <div class="theme-controls row-container">
        <ul class="menu-list">
            <li id="white-bg" onclick="asakura.changeTheme(false,true)">
                <i class="fa fa-television" aria-hidden="true"></i>
            </li><!--Default-->
            <li id="dark-bg" onclick="asakura.changeTheme(true,true)">
                <i class="fa fa-moon-o" aria-hidden="true"></i>
            </li><!--Night-->
        </ul>
    </div>
</div>
<?php if (akina_option('sakura_widget')) : ?>
    <aside id="secondary" class="widget-area" role="complementary" style="left: -400px;">
        <div class="heading"><?php _e('Widgets') /*小工具*/ ?></div>
        <div class="sakura_widget">
            <?php if (function_exists('dynamic_sidebar') && dynamic_sidebar('sakura_widget')) : endif; ?>
        </div>
        <div class="show-hide-wrap">
            <button class="show-hide" onclick="this.parentElement.parentElement.classList.toggle('active')">
                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 32 32">
                    <path d="M22 16l-10.105-10.6-1.895 1.987 8.211 8.613-8.211 8.612 1.895 1.988 8.211-8.613z"></path>
                </svg>
            </button>
        </div>
    </aside>
<?php endif; ?>
<?php if (akina_option('aplayer_server') != 'off'): ?>
    <div id="aplayer-float" style="z-index: 100;"
         class="aplayer"
         data-id="<?php echo akina_option('aplayer_playlistid'); ?>"
         data-server="<?php echo akina_option('aplayer_server'); ?>"
         data-type="playlist"
         data-fixed="true"
         data-volume="<?php echo akina_option('playlist_mryl'); ?>"
         data-theme="<?php echo akina_option('theme_skin'); ?>">
    </div>
<?php endif; ?>

<?php if (akina_option('sakurajs')): ?>
    <!-- 樱花飘落动效 -->
    <script type="text/javascript"
            src="https://cdn.jsdelivr.net/gh/Fuukei/Public_Repository@latest/static/js/sakura-<?php echo akina_option('sakura-falling-quantity'); ?>.js"></script>
<?php endif; ?>

<?php if (akina_option('bolangcss')): ?>
    <!-- 首页波浪特效 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/Fuukei/Public_Repository@latest/static/css/bolang.css">
<?php endif; ?>

<?php if (akina_option('live2djs')): ?>
    <!-- Live2D看板娘 -->
    <script type="text/javascript"
            src="https://cdn.jsdelivr.net/gh/<?php echo akina_option('live2d-custom'); ?>/live2d-widget@<?php echo akina_option('live2d-custom-ver'); ?>/autoload.js"></script>
<?php endif; ?>

<!-- logo字体部分 -->
<link rel="stylesheet" href="<?php echo akina_option('logo_zt'); ?>" media="all">

</body>
</html>
