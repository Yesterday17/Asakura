<?php
/**
 * Sakura functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Sakura
 */

define('SAKURA_VERSION', wp_get_theme()->get('Version'));
define('BUILD_VERSION', '1');
define('SAKURA_DOMAIN', 'asakura');
define('SAKURA_REST_API', SAKURA_DOMAIN . '/v1');

if (!function_exists("ll")):
    function ll($key) {
        return __($key, SAKURA_DOMAIN);
    }

    function ee($key) {
        echo ll($key);
    }
endif;

if (!function_exists("asakura_rest_url")):
    function asakura_rest_url($url, $scheme = 'rest') {
        if (strpos($url, '/') !== 0) {
            $url = '/' . $url;
        }
        return rest_url(SAKURA_REST_API . $url, $scheme);
    }
endif;

if (!function_exists('akina_setup')) {
    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which
     * runs before the init hook. The init hook is too late for some features, such
     * as indicating support for post thumbnails.
     */

    if (!function_exists('optionsframework_init')) {
        define('OPTIONS_FRAMEWORK_DIRECTORY', get_template_directory_uri() . '/inc/');
        require_once dirname(__FILE__) . '/inc/options-framework.php';
    }

    function akina_setup() {
        /*
         * Make theme available for translation.
         * Translations can be filed in the /languages/ directory.
         * If you're building a theme based on Akina, use a find and replace
         * to change 'akina' to the name of your theme in all the template files.
         */
        load_theme_textdomain(SAKURA_DOMAIN, get_template_directory() . '/languages');

        /*
         * Enable support for Post Thumbnails on posts and pages.
         *
         * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
         */
        add_theme_support('post-thumbnails');
        set_post_thumbnail_size(150, 150, true);

        // This theme uses wp_nav_menu() in one location.
        register_nav_menus(array(
            'primary' => __('Nav Menus', SAKURA_DOMAIN), //导航菜单
        ));

        /*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
        add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption',));

        /*
         * Enable support for Post Formats.
         * See https://developer.wordpress.org/themes/functionality/post-formats/
         */
        add_theme_support('post-formats', array('aside', 'image', 'status',));

        // Set up the WordPress core custom background feature.
        add_theme_support('custom-background', apply_filters('akina_custom_background_args', array(
            'default-color' => 'ffffff',
            'default-image' => '',
        )));

        add_filter('pre_option_link_manager_enabled', '__return_true');

        // 优化代码
        // 去除头部冗余代码
        remove_action('wp_head', 'feed_links_extra', 3);
        remove_action('wp_head', 'rsd_link');
        remove_action('wp_head', 'wlwmanifest_link');
        remove_action('wp_head', 'index_rel_link');
        remove_action('wp_head', 'start_post_rel_link', 10);
        remove_action('wp_head', 'wp_generator'); // 隐藏wordpress版本
        remove_filter('the_content', 'wptexturize'); //取消标点符号转义

        //remove_action('rest_api_init', 'wp_oembed_register_route');
        //remove_filter('rest_pre_serve_request', '_oembed_rest_pre_serve_request', 10, 4);
        //remove_filter('oembed_dataparse', 'wp_filter_oembed_result', 10);
        //remove_filter('oembed_response_data', 'get_oembed_response_data_rich', 10, 4);
        //remove_action('wp_head', 'wp_oembed_add_discovery_links');
        //remove_action('wp_head', 'wp_oembed_add_host_js');
        remove_action('template_redirect', 'rest_output_link_header', 11);

        // 去除谷歌字体
        function coolwp_remove_open_sans_from_wp_core() {
            wp_deregister_style('open-sans');
            wp_register_style('open-sans', false);
            wp_enqueue_style('open-sans', '');
        }

        add_action('init', 'coolwp_remove_open_sans_from_wp_core');

        // 禁用 emoji
        function disable_emojis() {
            remove_action('wp_head', 'print_emoji_detection_script', 7);
            remove_action('admin_print_scripts', 'print_emoji_detection_script');
            remove_action('wp_print_styles', 'print_emoji_styles');
            remove_action('admin_print_styles', 'print_emoji_styles');
            remove_filter('the_content_feed', 'wp_staticize_emoji');
            remove_filter('comment_text_rss', 'wp_staticize_emoji');
            remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
            add_filter('tiny_mce_plugins', 'disable_emojis_tinymce');
        }

        add_action('init', 'disable_emojis');

        /**
         * Filter function used to remove the tinymce emoji plugin.
         *
         * @param array $plugins
         * @return   array             Difference betwen the two arrays
         */
        function disable_emojis_tinymce($plugins) {
            if (is_array($plugins)) {
                return array_diff($plugins, array('wpemoji'));
            } else {
                return array();
            }
        }

        // 移除菜单冗余代码
        add_filter('nav_menu_css_class', 'my_css_attributes_filter', 100, 1);
        add_filter('nav_menu_item_id', 'my_css_attributes_filter', 100, 1);
        add_filter('page_css_class', 'my_css_attributes_filter', 100, 1);
        function my_css_attributes_filter($var) {
            return is_array($var) ? array_intersect($var, array(
                'current-menu-item',
                'current-post-ancestor',
                'current-menu-ancestor',
                'current-menu-parent'
            )) : '';
        }
    }
}
add_action('after_setup_theme', 'akina_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function akina_content_width() {
    $GLOBALS['content_width'] = apply_filters('akina_content_width', 640);
}

add_action('after_setup_theme', 'akina_content_width', 0);

/**
 * Enqueue scripts and styles.
 */
function sakura_scripts() {
    if (akina_option('app_no_jsdelivr_cdn')) {
        wp_enqueue_style('sakura_css', get_stylesheet_uri(), array(), SAKURA_VERSION);
        wp_enqueue_script('app', get_template_directory_uri() . '/frontend/dist/asakura-app.js', array(), SAKURA_VERSION, true);
    } else {
        wp_enqueue_style('sakura_css', 'https://cdn.jsdelivr.net/gh/Yesterday17/Asakura@' . SAKURA_VERSION . '/style.min.css', array(), SAKURA_VERSION);
        wp_enqueue_script('app', 'https://cdn.jsdelivr.net/gh/Yesterday17/Asakura@' . SAKURA_VERSION . '/js/sakura-app.min.js', array(), SAKURA_VERSION, true);
    }

    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }

    //拦截移动端
    // if (wp_is_mobile()) {
    //     $auto_height = 'fixed';
    // }
    wp_add_inline_script('app', 'var mashiro_option = ' . json_encode(get_asakura_option()) . ';', 'before');
}

add_action('wp_enqueue_scripts', 'sakura_scripts');

/**
 * load .php.
 */
require get_template_directory() . '/inc/decorate.php';
require get_template_directory() . '/inc/switcher.php';
require get_template_directory() . '/inc/api.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * function update
 */
require get_template_directory() . '/inc/theme_plus.php';
require get_template_directory() . '/inc/categories-images.php';

/**
 * COMMENT FORMATTING
 *
 * 标准的 lazyload 输出头像
 * <?php echo str_replace( 'src=', 'src="https://cdn.jsdelivr.net/gh/moezx/cdn@3.0.1/img/svg/loader/index.ajax-spinner-preloader.svg" onerror="imgError(this,1)" data-src=', get_avatar( $comment->comment_author_email, '80', '', get_comment_author(), array( 'class' => array( 'lazyload' ) ) ) ); ?>
 *
 * 如果不延时是这样的
 * <?php echo get_avatar( $comment->comment_author_email, '80', '', get_comment_author() ); ?>
 *
 */
if (!function_exists('akina_comment_format')) {
    function akina_comment_format($comment, $args, $depth) {
        $GLOBALS['comment'] = $comment;
        ?>
        <li <?php comment_class(); ?> id="comment-<?php echo esc_attr(get_comment_ID()); ?>">
        <div class="contents">
            <div class="comment-arrow">
                <div class="main shadow">
                    <div class="profile">
                        <a href="<?php comment_author_url(); ?>" target="_blank"
                           rel="nofollow"><?php echo str_replace('src=', 'src="' . akina_option('webweb_img') . '/load/inload.svg" onerror="imgError(this,1)" data-src=', get_avatar($comment->comment_author_email, '80', '', get_comment_author(), array('class' => array('lazyload')))); ?></a>
                    </div>
                    <div class="commentinfo">
                        <section class="commeta">
                            <div class="left">
                                <h4 class="author"><a href="<?php comment_author_url(); ?>" target="_blank"
                                                      rel="nofollow"><?php echo get_avatar($comment->comment_author_email, '24', '', get_comment_author()); ?>
                                        <span class="bb-comment isauthor"
                                              title="<?php ee('Author'); ?>"><?php ee('Author'); ?></span> <?php comment_author(); ?> <?php get_author_class($comment->comment_author_email, $comment->user_id); ?>
                                    </a></h4>
                            </div>
                            <?php comment_reply_link(array_merge($args, array(
                                'depth'     => $depth,
                                'max_depth' => $args['max_depth']
                            ))); ?>
                            <div class="right">
                                <div class="info">
                                    <time datetime="<?php comment_date('Y-m-d'); ?>"><?php echo poi_time_since(strtotime($comment->comment_date_gmt), true); //comment_date(get_option('date_format'));
                                        ?></time><?php echo siren_get_useragent($comment->comment_agent); ?><?php echo mobile_get_useragent_icon($comment->comment_agent); ?>
                                    <?php if (current_user_can('manage_options') and (wp_is_mobile() == false)) {
                                        $comment_ID = $comment->comment_ID;
                                        $i_private = get_comment_meta($comment_ID, '_private', true);
                                        $flag = ' <i class="fa fa-snowflake-o" aria-hidden="true"></i> <a href="javascript:;" data-actionp="set_private" data-idp="' . get_comment_id() . '" id="sp" class="sm" style="color:rgba(0,0,0,.35)">' . __("Private", SAKURA_DOMAIN) . ': <span class="has_set_private">';
                                        if (!empty($i_private)) {
                                            $flag .= ll("Yes") . ' <i class="fa fa-lock" aria-hidden="true"></i>';
                                        } else {
                                            $flag .= ll("No") . ' <i class="fa fa-unlock" aria-hidden="true"></i>';
                                        }
                                        $flag .= '</span></a>';
                                        $flag .= edit_comment_link('<i class="fa fa-pencil-square-o" aria-hidden="true"></i> ' . __("Edit", "mashiro"), ' <span style="color:rgba(0,0,0,.35)">', '</span>');
                                        echo $flag;
                                    } ?></div>
                            </div>
                        </section>
                    </div>
                    <div class="body">
                        <?php comment_text(); ?>
                    </div>
                </div>
                <div class="arrow-left"></div>
            </div>
        </div>
        <hr>
        <?php
    }
}

/**
 * 获取访客VIP样式
 * @param $comment_author_email
 * @param $user_id
 */
function get_author_class($comment_author_email, $user_id) {
    global $wpdb;
    $author_count = count($wpdb->get_results("SELECT comment_ID as author_count FROM $wpdb->comments WHERE comment_author_email = '$comment_author_email' "));
    if ($author_count >= 1 && $author_count < 5) //数字可自行修改，代表评论次数。
    {
        echo '<span class="showGrade0" title="Lv0"><img src="https://cdn.jsdelivr.net/gh/Fuukei/Public_Repository@latest/vision/comment/level/level_0.svg" style="height: 1.5em; max-height: 1.5em; display: inline-block;"></span>';
    } else if ($author_count >= 6 && $author_count < 10) {
        echo '<span class="showGrade1" title="Lv1"><img src="https://cdn.jsdelivr.net/gh/Fuukei/Public_Repository@latest/vision/comment/level/level_1.svg" style="height: 1.5em; max-height: 1.5em; display: inline-block;"></span>';
    } else if ($author_count >= 10 && $author_count < 20) {
        echo '<span class="showGrade2" title="Lv2"><img src="https://cdn.jsdelivr.net/gh/Fuukei/Public_Repository@latest/vision/comment/level/level_2.svg" style="height: 1.5em; max-height: 1.5em; display: inline-block;"></span>';
    } else if ($author_count >= 20 && $author_count < 40) {
        echo '<span class="showGrade3" title="Lv3"><img src="https://cdn.jsdelivr.net/gh/Fuukei/Public_Repository@latest/vision/comment/level/level_3.svg" style="height: 1.5em; max-height: 1.5em; display: inline-block;"></span>';
    } else if ($author_count >= 40 && $author_count < 80) {
        echo '<span class="showGrade4" title="Lv4"><img src="https://cdn.jsdelivr.net/gh/Fuukei/Public_Repository@latest/vision/comment/level/level_4.svg" style="height: 1.5em; max-height: 1.5em; display: inline-block;"></span>';
    } else if ($author_count >= 80 && $author_count < 160) {
        echo '<span class="showGrade5" title="Lv5"><img src="https://cdn.jsdelivr.net/gh/Fuukei/Public_Repository@latest/vision/comment/level/level_5.svg" style="height: 1.5em; max-height: 1.5em; display: inline-block;"></span>';
    } else if ($author_count >= 160) {
        echo '<span class="showGrade6" title="Lv6"><img src="https://cdn.jsdelivr.net/gh/Fuukei/Public_Repository@latest/vision/comment/level/level_6.svg" style="height: 1.5em; max-height: 1.5em; display: inline-block;"></span>';
    }

}

/**
 * post views
 * @param $number
 * @return string
 */
function restyle_text($number) {
    switch (akina_option('statistics_format')) {
        case "type_2": //23,333 次访问
            return number_format($number);
        case "type_3": //23 333 次访问
            return number_format($number, 0, '.', ' ');
        case "type_4": //23k 次访问
            if ($number >= 1000) {
                return round($number / 1000, 2) . 'k';
            } else {
                return $number;
            }
        default:
            return $number;
    }
}

function set_post_views() {
    if (is_singular()) {
        global $post;
        $post_id = intval($post->ID);
        if ($post_id) {
            $views = (int)get_post_meta($post_id, 'views', true);
            if (!update_post_meta($post_id, 'views', ($views + 1))) {
                add_post_meta($post_id, 'views', 1, true);
            }
        }
    }
}

add_action('get_header', 'set_post_views');

function get_post_views($post_id) {
    if (akina_option('statistics_api') == 'wp_statistics') {
        if (!function_exists('wp_statistics_pages')) {
            return ll('Please install plugin <a href="https://wordpress.org/plugins/wp-statistics/" target="_blank">WP-Statistics</a>');
        } else {
            return restyle_text(wp_statistics_pages('total', 'uri', $post_id));
        }
    } else {
        $views = get_post_meta($post_id, 'views', true);
        if ($views == '') {
            return 0;
        } else {
            return restyle_text($views);
        }
    }
}

function is_webp() {
    $webp = strpos($_SERVER['HTTP_ACCEPT'], 'image/webp');
    $webp === false ? $webp = 0 : $webp = 1;
    return $webp;
}

/*
 * 友情链接
 */
function get_the_link_items($id = null) {
    $bookmarks = get_bookmarks('orderby=date&category=' . $id);
    $output = '';
    if (!empty($bookmarks)) {
        $output .= '<ul class="link-items fontSmooth">';
        foreach ($bookmarks as $bookmark) {
            if (empty($bookmark->link_description)) {
                $bookmark->link_description = __('This guy is so lazy ╮(╯▽╰)╭', SAKURA_DOMAIN);
            }

            if (empty($bookmark->link_image)) {
                $bookmark->link_image = 'https://view.moezx.cc/images/2017/12/30/Transparent_Akkarin.th.jpg';
            }

            $output .= '<li class="link-item"><a class="link-item-inner effect-apollo" href="' . $bookmark->link_url . '" title="' . $bookmark->link_description . '" target="_blank" rel="friend"><img class="lazyload" onerror="imgError(this,1)" data-src="' . $bookmark->link_image . '" src="' . akina_option('webweb_img') . '/load/inload.svg"><span class="sitename">' . $bookmark->link_name . '</span><div class="linkdes">' . $bookmark->link_description . '</div></a></li>';
        }
        $output .= '</ul>';
    }
    return $output;
}

function get_link_items() {
    $linkcats = get_terms('link_category');
    if (!empty($linkcats)) {
        foreach ($linkcats as $linkcat) {
            $result .= '<h3 class="link-title"><span class="link-fix">' . $linkcat->name . '</span></h3>';
            if ($linkcat->description) {
                $result .= '<div class="link-description">' . $linkcat->description . '</div>';
            }

            $result .= get_the_link_items($linkcat->term_id);
        }
    } else {
        $result = get_the_link_items();
    }
    return $result;
}

/*
 * Gravatar头像使用中国服务器
 */
function gravatar_cn($url) {
    $gravatar_url = array(
        '0.gravatar.com/avatar',
        '1.gravatar.com/avatar',
        '2.gravatar.com/avatar',
        'secure.gravatar.com/avatar'
    );
    return str_replace($gravatar_url, akina_option('gravatar_proxy'), $url);
}

if (akina_option('gravatar_proxy')) {
    add_filter('get_avatar_url', 'gravatar_cn', 4);
}

/*
 * 自定义默认头像
 */
add_filter('avatar_defaults', 'mytheme_default_avatar');

function mytheme_default_avatar($avatar_defaults) {
    //$new_avatar_url = get_template_directory_uri() . '/images/default_avatar.png';
    $new_avatar_url = 'https://cn.gravatar.com/avatar/b745710ae6b0ce9dfb13f5b7c0956be1';
    $avatar_defaults[$new_avatar_url] = 'Default Avatar';
    return $avatar_defaults;
}

/*
 * 阻止站内文章互相Pingback
 */
function theme_noself_ping(&$links) {
    $home = get_option('home');
    foreach ($links as $l => $link) {
        if (0 === strpos($link, $home)) {
            unset($links[$l]);
        }
    }
}

add_action('pre_ping', 'theme_noself_ping');

/*
 * 定制body类
 */
function akina_body_classes($classes) {
    // Adds a class of group-blog to blogs with more than 1 published author.
    if (is_multi_author()) {
        $classes[] = 'group-blog';
    }
    // Adds a class of hfeed to non-singular pages.
    if (!is_singular()) {
        $classes[] = 'hfeed';
    }
    // 定制中文字体class
    $classes[] = 'chinese-font';
    return $classes;
}

add_filter('body_class', 'akina_body_classes');

/*
 * 图片CDN
 */
add_filter('upload_dir', 'wpjam_custom_upload_dir');
function wpjam_custom_upload_dir($uploads) {
    $upload_path = '';
    $upload_url_path = akina_option('image_cdn');

    if (empty($upload_path) || 'wp-content/uploads' == $upload_path) {
        $uploads['basedir'] = WP_CONTENT_DIR . '/uploads';
    } elseif (0 !== strpos($upload_path, ABSPATH)) {
        $uploads['basedir'] = path_join(ABSPATH, $upload_path);
    } else {
        $uploads['basedir'] = $upload_path;
    }

    $uploads['path'] = $uploads['basedir'] . $uploads['subdir'];

    if ($upload_url_path) {
        $uploads['baseurl'] = $upload_url_path;
        $uploads['url'] = $uploads['baseurl'] . $uploads['subdir'];
    }
    return $uploads;
}

/*
 * 删除自带小工具
 */
function unregister_default_widgets() {
    unregister_widget("WP_Widget_Pages");
    unregister_widget("WP_Widget_Calendar");
    unregister_widget("WP_Widget_Archives");
    unregister_widget("WP_Widget_Links");
    unregister_widget("WP_Widget_Meta");
    unregister_widget("WP_Widget_Search");
    //unregister_widget("WP_Widget_Text");
    unregister_widget("WP_Widget_Categories");
    unregister_widget("WP_Widget_Recent_Posts");
    //unregister_widget("WP_Widget_Recent_Comments");
    //unregister_widget("WP_Widget_RSS");
    //unregister_widget("WP_Widget_Tag_Cloud");
    unregister_widget("WP_Nav_Menu_Widget");
}

add_action("widgets_init", "unregister_default_widgets", 11);

/**
 * Jetpack setup function.
 *
 * See: https://jetpack.com/support/infinite-scroll/
 * See: https://jetpack.com/support/responsive-videos/
 */
function akina_jetpack_setup() {
    // Add theme support for Infinite Scroll.
    add_theme_support('infinite-scroll', array(
        'container' => 'main',
        'render'    => 'akina_infinite_scroll_render',
        'footer'    => 'page',
    ));

    // Add theme support for Responsive Videos.
    add_theme_support('jetpack-responsive-videos');
}

add_action('after_setup_theme', 'akina_jetpack_setup');

/**
 * Custom render function for Infinite Scroll.
 */
function akina_infinite_scroll_render() {
    while (have_posts()) {
        the_post();
        if (is_search()):
            get_template_part('tpl/content', 'search');
        else:
            get_template_part('tpl/content', get_post_format());
        endif;
    }
}

/*
 * 编辑器增强
 */
function enable_more_buttons($buttons) {
    $buttons[] = 'hr';
    $buttons[] = 'del';
    $buttons[] = 'sub';
    $buttons[] = 'sup';
    $buttons[] = 'fontselect';
    $buttons[] = 'fontsizeselect';
    $buttons[] = 'cleanup';
    $buttons[] = 'styleselect';
    $buttons[] = 'wp_page';
    $buttons[] = 'anchor';
    $buttons[] = 'backcolor';
    return $buttons;
}

add_filter("mce_buttons_3", "enable_more_buttons");

add_action('after_wp_tiny_mce', 'bolo_after_wp_tiny_mce');
function bolo_after_wp_tiny_mce($mce_settings) {
    ?>
    <script type="text/javascript">
        QTags.addButton('download', '下载按钮', "[download]下载地址[/download]");

        function bolo_QTnextpage_arg1() {
        }
    </script>
<?php }

/*
 * 后台登录页
 * @M.J
 */
//Login Page style
function custom_login() {
    require get_template_directory() . '/inc/login_addcss.php';
    //echo '<link rel="stylesheet" type="text/css" href="' . get_bloginfo('template_directory') . '/inc/login.css" />'."\n";
    echo '<link rel="stylesheet" type="text/css" href="' . get_template_directory_uri() . '/inc/login.css?' . SAKURA_VERSION . '" />' . "\n";
    //echo '<script type="text/javascript" src="'.get_bloginfo('template_directory').'/js/jquery.min.js"></script>'."\n";
    echo '<script type="text/javascript" src="https://cdn.jsdelivr.net/gh/jquery/jquery@1.9.0/jquery.min.js"></script>' . "\n";
}

add_action('login_head', 'custom_login');

//Login Page Title
function custom_headertitle($title) {
    return get_bloginfo('name');
}

add_filter('login_headertitle', 'custom_headertitle');

//Login Page Link
function custom_loginlogo_url($url) {
    return esc_url(home_url('/'));
}

add_filter('login_headerurl', 'custom_loginlogo_url');

//Login Page Footer
function custom_html() {
    if (akina_option('login_bg')) {
        $loginbg = akina_option('login_bg');
    } else {
        $loginbg = 'https://cdn.jsdelivr.net/gh/Fuukei/Public_Repository@latest/vision/background/backstage/login-bg.png';
    }
    echo '<script type="text/javascript" src="' . get_template_directory_uri() . '/js/login.js"></script>' . "\n";
    echo '<script type="text/javascript">' . "\n";
    echo 'jQuery("body").prepend("<div class=\"loading\"><img src=\"https://cdn.jsdelivr.net/gh/Fuukei/Public_Repository@latest/vision/basic/login_loading.gif\" width=\"58\" height=\"10\"></div><div id=\"bg\"><img /></div>");' . "\n";
    echo 'jQuery(\'#bg\').children(\'img\').attr(\'src\', \'' . $loginbg . '\').load(function(){' . "\n";
    echo '	resizeImage(\'bg\');' . "\n";
    echo '	jQuery(window).bind("resize", function() { resizeImage(\'bg\'); });' . "\n";
    echo '	jQuery(\'.loading\').fadeOut();' . "\n";
    echo '});';
    echo '</script>' . "\n";
    echo '<script>
    $(document).ready(function(){
        $(\'h1 a\').attr(\'style\',\'background-image: url(' . akina_option('logo_img') . '); \');
		$(".forgetmenot").replaceWith(\'<p class="forgetmenot">' . ll('Remember_Me') . '<input name="rememberme" id="rememberme" value="forever" type="checkbox"><label for="rememberme" style="float: right;margin-top: 5px;transform: scale(2);margin-right: -10px;"></label></p>\');
	});
    </script>';
}

add_action('login_footer', 'custom_html');

//Login message
//* Add custom message to WordPress login page
function smallenvelop_login_message($message) {
    if (empty($message)) {
        return '<p class="message"><strong>You may try 3 times for every 5 minutes!</strong></p>';
    } else {
        return $message;
    }
}

//add_filter( 'login_message', 'smallenvelop_login_message' );

//Fix password reset bug </>
function resetpassword_message_fix($message) {
    $message = str_replace("<", "", $message);
    $message = str_replace(">", "", $message);
    return $message;
}

add_filter('retrieve_password_message', 'resetpassword_message_fix');

//Fix register email bug </>
function new_user_message_fix($message) {
    $show_register_ip = "注册IP | Registration IP: " . get_the_user_ip() . " \r\n\r\n如非本人操作请忽略此邮件 | Please ignore this email if this was not your operation.\r\n\r\n";
    $message = str_replace("To set your password, visit the following address:", $show_register_ip . "在此设置密码 | To set your password, visit the following address:", $message);
    $message = str_replace("<", "", $message);
    $message = str_replace(">", "\r\n\r\n设置密码后在此登录 | Login here after setting password: ", $message);
    return $message;
}

add_filter('wp_new_user_notification_email', 'new_user_message_fix');

/*
 * 链接新窗口打开
 */
function rt_add_link_target($content) {
    $content = str_replace('<a', '<a rel="nofollow"', $content);
    // use the <a> tag to split into segments
    $bits = explode('<a ', $content);
    // loop though the segments
    foreach ($bits as $key => $bit) {
        // fix the target="_blank" bug after the link
        if (strpos($bit, 'href') === false) {
            continue;
        }

        // fix the target="_blank" bug in the codeblock
        if (strpos(preg_replace('/code([\s\S]*?)\/code[\s]*/m', 'temp', $content), $bit) === false) {
            continue;
        }

        // find the end of each link
        $pos = strpos($bit, '>');
        // check if there is an end (only fails with malformed markup)
        if ($pos !== false) {
            // get a string with just the link's attibutes
            $part = substr($bit, 0, $pos);
            // for comparison, get the current site/network url
            $siteurl = network_site_url();
            // if the site url is in the attributes, assume it's in the href and skip, also if a target is present
            if (strpos($part, $siteurl) === false && strpos($part, 'target=') === false) {
                // add the target attribute
                $bits[$key] = 'target="_blank" ' . $bits[$key];
            }
        }
    }
    // re-assemble the content, and return it
    return implode('<a ', $bits);
}

add_filter('comment_text', 'rt_add_link_target');

function featuredtoRSS($content) {
    global $post;
    if (has_post_thumbnail($post->ID)) {
        $content = '<div>' . get_the_post_thumbnail($post->ID, 'medium', array('style' => 'margin-bottom: 15px;')) . '</div>' . $content;
    }
    return $content;
}

add_filter('the_excerpt_rss', 'featuredtoRSS');
add_filter('the_content_feed', 'featuredtoRSS');

function toc_support($content) {
    $content = str_replace('[toc]', '<div class="have-toc"></div>', $content); // TOC 支持
    return $content;
}

add_filter('the_content', 'toc_support');
add_filter('the_excerpt_rss', 'toc_support');
add_filter('the_content_feed', 'toc_support');

// 显示访客当前 IP
function get_the_user_ip() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        //check ip from share internet
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        //to check ip is pass from proxy
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return apply_filters('wpb_get_ip', $ip);
}

add_shortcode('show_ip', 'get_the_user_ip');

/*歌词*/
function hero_get_lyric() {
    /** These are the lyrics to Hero */
    $lyrics = "";

    // Here we split it into lines
    $lyrics = explode("\n", $lyrics);

    // And then randomly choose a line
    return wptexturize($lyrics[mt_rand(0, count($lyrics) - 1)]);
}

// This just echoes the chosen line, we'll position it later
function hello_hero() {
    $chosen = hero_get_lyric();
    echo $chosen;
}

/*私密评论*/
add_action('wp_ajax_nopriv_siren_private', 'siren_private');
add_action('wp_ajax_siren_private', 'siren_private');
function siren_private() {
    $comment_id = $_POST["p_id"];
    $action = $_POST["p_action"];
    if ($action == 'set_private') {
        update_comment_meta($comment_id, '_private', 'true');
        $i_private = get_comment_meta($comment_id, '_private', true);
        if (!empty($i_private)) {
            echo '否';
        } else {
            echo '是';
        }
    }
    die;
}

//时间序列
function memory_archives_list() {
    if (true) {
        $output = '<div id="archives"><p style="text-align:right;">[<span id="al_expand_collapse">' . __("All expand/collapse", SAKURA_DOMAIN) /*全部展开/收缩*/ . '</span>]<!-- (注: 点击月份可以展开)--></p>';
        $the_query = new WP_Query('posts_per_page=-1&ignore_sticky_posts=1&post_type=post'); //update: 加上忽略置顶文章
        $year = 0;
        $mon = 0;
        $i = 0;
        $j = 0;
        while ($the_query->have_posts()): $the_query->the_post();
            $year_tmp = get_the_time('Y');
            $mon_tmp = get_the_time('m');
            $y = $year;
            $m = $mon;
            if ($mon != $mon_tmp && $mon > 0) {
                $output .= '</ul></li>';
            }

            if ($year != $year_tmp && $year > 0) {
                $output .= '</ul>';
            }

            if ($year != $year_tmp) {
                $year = $year_tmp;
                $output .= '<h3 class="al_year">' . $year . __(" ", "year", SAKURA_DOMAIN) . /*年*/
                    ' </h3><ul class="al_mon_list">'; //输出年份
            }
            if ($mon != $mon_tmp) {
                $mon = $mon_tmp;
                $output .= '<li class="al_li"><span class="al_mon"><span style="color:' . akina_option('theme_skin') . ';">' . get_the_time('M') . '</span> (<span id="post-num"></span>' . __(" post(s)", SAKURA_DOMAIN) /*篇文章*/ . ')</span><ul class="al_post_list">'; //输出月份
            }
            $output .= '<li>' . '<a href="' . get_permalink() . '"><span style="color:' . akina_option('theme_skin') . ';">' /*get_the_time('d'.__(" ",SAKURA_DOMAIN)) 日*/ . '</span>' . get_the_title() . ' <span>(' . get_post_views(get_the_ID()) . ' <span class="fa fa-fire" aria-hidden="true"></span> / ' . get_comments_number('0', '1', '%') . ' <span class="fa fa-commenting" aria-hidden="true"></span>)</span></a></li>'; //输出文章日期和标题
        endwhile;
        wp_reset_postdata();
        $output .= '</ul></li></ul> <!--<ul class="al_mon_list"><li><ul class="al_post_list" style="display: block;"><li>博客已经萌萌哒运行了<span id="monitorday"></span>天</li></ul></li></ul>--></div>';
        #update_option('memory_archives_list', $output);
    }
    echo $output;
}

/*
 * 隐藏 Dashboard
 */
/* Remove the "Dashboard" from the admin menu for non-admin users */
function remove_dashboard() {
    global $current_user, $menu, $submenu;
    wp_get_current_user();

    if (!in_array('administrator', $current_user->roles)) {
        reset($menu);
        $page = key($menu);
        while ((__('Dashboard') != $menu[$page][0]) && next($menu)) {
            $page = key($menu);
        }
        if (__('Dashboard') == $menu[$page][0]) {
            unset($menu[$page]);
        }
        reset($menu);
        $page = key($menu);
        while (!$current_user->has_cap($menu[$page][1]) && next($menu)) {
            $page = key($menu);
        }
        if (preg_match('#wp-admin/?(index.php)?$#', $_SERVER['REQUEST_URI']) && ('index.php' != $menu[$page][2])) {
            wp_redirect(get_option('siteurl') . '/wp-admin/profile.php');
        }
    }
}

add_action('admin_menu', 'remove_dashboard');

/**
 * Filter the except length to 20 words. 限制摘要长度
 *
 * @param int $length Excerpt length.
 * @return int (Maybe) modified excerpt length.
 */

function GBsubstr($string, $start, $length) {
    if (strlen($string) > $length) {
        $str = null;
        $len = 0;
        $i = $start;
        while ($len < $length) {
            if (ord(substr($string, $i, 1)) > 0xc0) {
                $str .= substr($string, $i, 3);
                $i += 3;
            } elseif (ord(substr($string, $i, 1)) > 0xa0) {
                $str .= substr($string, $i, 2);
                $i += 2;
            } else {
                $str .= substr($string, $i, 1);
                $i++;
            }
            $len++;
        }
        return $str;
    } else {
        return $string;
    }
}

function excerpt_length($exp) {
    if (!function_exists('mb_substr')) {
        $exp = GBsubstr($exp, 0, 80);
    } else {
        /*
         * To use mb_substr() function, you should uncomment "extension=php_mbstring.dll" in php.ini
         */
        $exp = mb_substr($exp, 0, 80);
    }
    return $exp;
}

add_filter('the_excerpt', 'excerpt_length');

/*
 * 后台路径
 */
/*
add_filter('site_url',  'wpadmin_filter', 10, 3);
function wpadmin_filter( $url, $path, $orig_scheme ) {
$old  = array( "/(wp-admin)/");
$admin_dir = WP_ADMIN_DIR;
$new  = array($admin_dir);
return preg_replace( $old, $new, $url, 1);
}
 */

function admin_ini() {
    wp_enqueue_style('admin-styles-fix-icon', get_site_url() . '/wp-includes/css/dashicons.css');
    wp_enqueue_script('lazyload', 'https://cdn.jsdelivr.net/npm/lazyload@2.0.0-beta.2/lazyload.min.js');
}

add_action('admin_enqueue_scripts', 'admin_ini');

function custom_admin_js() {
    echo '<script>
    window.onload=function(){
        lazyload();

        try{
            document.querySelector("#scheme-tip .notice-dismiss").addEventListener("click", function(){
                location.href="?scheme-tip-dismissed' . BUILD_VERSION . '";
            });
        } catch(e){}
    }
    </script>';
}

add_action('admin_footer', 'custom_admin_js');

//dashboard scheme
function dash_scheme($key, $name, $col1, $col2, $col3, $col4, $base, $focus, $current, $rules = "") {
    $hash = "color_1=" . str_replace("#", "", $col1) . "&color_2=" . str_replace("#", "", $col2) . "&color_3=" . str_replace("#", "", $col3) . "&color_4=" . str_replace("#", "", $col4) . "&rules=" . urlencode($rules);

    wp_admin_css_color($key, $name, get_template_directory_uri() . "/inc/dash-scheme.php?" . $hash, array(
        $col1,
        $col2,
        $col3,
        $col4
    ), array('base' => $base, 'focus' => $focus, 'current' => $current));
}

//Asakura
dash_scheme($key = SAKURA_DOMAIN, $name = "「アサクラ」", $col1 = akina_option('admin_mcs'), $col2 = akina_option('admin_mcp'), $col3 = akina_option('admin_acc'), $col4 = akina_option('admin_acc'), $base = "#FFF", $focus = "#FFF", $current = "#FFF", $rules = '#adminmenu .wp-has-current-submenu .wp-submenu a,#adminmenu .wp-has-current-submenu.opensub .wp-submenu a,#adminmenu .wp-submenu a,#adminmenu a.wp-has-current-submenu:focus+.wp-submenu a,#wpadminbar .ab-submenu .ab-item,#wpadminbar .quicklinks .menupop ul li a,#wpadminbar .quicklinks .menupop.hover ul li a,#wpadminbar.nojs .quicklinks .menupop:hover ul li a,.folded #adminmenu .wp-has-current-submenu .wp-submenu a{color:' . akina_option('admin_font_skin') . '}body{background-image:url(' . akina_option('admin_menu_bg') . ');background-attachment:fixed;}#wpcontent{background:rgba(255,255,255,.0)}.wp-core-ui .button-primary{background:' . akina_option('admin_pb_skin') . '!important;border-color:' . akina_option('admin_pb_skin') . '!important;color:' . akina_option('admin_font_skin') . '!important;box-shadow:0 1px 0 ' . akina_option('admin_pb_skin') . '!important;text-shadow:0 -1px 1px ' . akina_option('admin_pb_skin') . ',1px 0 1px ' . akina_option('admin_pb_skin') . ',0 1px 1px ' . akina_option('admin_pb_skin') . ',-1px 0 1px ' . akina_option('admin_pb_skin') . '!important}');

//Set Default Admin Color Scheme for New Users
function set_default_admin_color($user_id) {
    $args = array('ID' => $user_id, 'admin_color' => 'sunrise',);
    wp_update_user($args);
}

//add_action('user_register', 'set_default_admin_color');

//Stop Users From Switching Admin Color Schemes
//if ( !current_user_can('manage_options') ) remove_action( 'admin_color_scheme_picker', 'admin_color_scheme_picker' );

// WordPress Custom Font @ Admin
function custom_admin_open_sans_font() {
    echo '<link href="https://fonts.googleapis.com/css?family=Merriweather+Sans&display=swap" rel="stylesheet">' . PHP_EOL;
    echo '<style>body, #wpadminbar *:not([class="ab-icon"]), .wp-core-ui, .media-menu, .media-frame *, .media-modal *{font-family:"Noto Serif SC","Source Han Serif SC","Source Han Serif","source-han-serif-sc","PT Serif","SongTi SC","MicroSoft Yahei",Georgia,serif !important;}</style>' . PHP_EOL;
}

add_action('admin_head', 'custom_admin_open_sans_font');

// WordPress Custom Font @ Admin Frontend Toolbar
function custom_admin_open_sans_font_frontend_toolbar() {
    if (current_user_can('administrator')) {
        echo '<link href="https://fonts.googleapis.com/css?family=Merriweather+Sans&display=swap" rel="stylesheet">' . PHP_EOL;
        echo '<style>#wpadminbar *:not([class="ab-icon"]){font-family:"Noto Serif SC","Source Han Serif SC","Source Han Serif","source-han-serif-sc","PT Serif","SongTi SC","MicroSoft Yahei",Georgia,serif !important;}</style>' . PHP_EOL;
    }
}

add_action('wp_head', 'custom_admin_open_sans_font_frontend_toolbar');

// WordPress Custom Font @ Admin Login
function custom_admin_open_sans_font_login_page() {
    if (stripos($_SERVER["SCRIPT_NAME"], strrchr(wp_login_url(), '/')) !== false) {
        echo '<link href="https://fonts.googleapis.com/css?family=Noto+Serif+SC&display=swap" rel="stylesheet">' . PHP_EOL;
        echo '<style>body{font-family:"Noto Serif SC","Source Han Serif SC","Source Han Serif","source-han-serif-sc","PT Serif","SongTi SC","MicroSoft Yahei",Georgia,serif !important;}</style>' . PHP_EOL;
    }
}

add_action('login_head', 'custom_admin_open_sans_font_login_page');

// 阻止垃圾注册
add_action('register_post', 'codecheese_register_post', 10, 3);

function codecheese_register_post($sanitized_user_login, $user_email, $errors) {
    // Blocked domains
    $domains = array('net.buzzcluby.com', 'buzzcluby.com', 'mail.ru', 'h.captchaeu.info', 'edge.codyting.com');

    // Get visitor email domain
    $email = explode('@', $user_email);

    // Check and display error message for the registration form if exists
    if (in_array($email[1], $domains)) {
        $errors->add('invalid_email', __('<b>ERROR</b>: This email domain (<b>@' . $email[1] . '</b>) has been blocked. Please use another email.'));
    }
}

// html 标签处理器
function html_tag_parser($content) {
    if (!is_feed()) {
        if (akina_option('lazyload') && akina_option('lazyload_spinner')) {
            $content = preg_replace('/<img(.+)src=[\'"]([^\'"]+)[\'"](.*?)?>/i', "<img $1 class=\"lazyload\" data-src=\"$2\" src=\"" . akina_option('lazyload_spinner') . "\" onerror=\"imgError(this)\" $3>\n<noscript>$0</noscript>", $content);
        }
    }
    return $content;
}

add_filter('the_content', 'html_tag_parser'); //替换文章关键词

// default feature image
function default_feature_image(): string {
    return asakura_rest_url('image/feature') . '?' . rand(1, 1000);
}

//侧栏小工具
if (akina_option('sakura_widget')) {
    if (function_exists('register_sidebar')) {
        register_sidebar(array(
            'name'          => __('Sidebar'), //侧栏
            'id'            => 'sakura_widget',
            'before_widget' => '<div class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<div class="title"><h2>',
            'after_title'   => '</h2></div>',
        ));
    }
}

remove_filter('comment_text', 'make_clickable', 9);

//rest api支持
function permalink_tip() {
    if (!get_option('permalink_structure')) {
        $msg = __('<b> For a better experience, please do not set <a href="/wp-admin/options-permalink.php"> permalink </a> as plain. To do this, you may need to configure <a href="https://www.wpdaxue.com/wordpress-rewriterule.html" target="_blank"> pseudo-static </a>. </b>', SAKURA_DOMAIN); /*<b>为了更好的使用体验，请不要将<a href="/wp-admin/options-permalink.php">固定链接</a>设置为朴素。为此，您可能需要配置<a href="https://www.wpdaxue.com/wordpress-rewriterule.html" target="_blank">伪静态</a>。</b>*/
        echo '<div class="notice notice-success is-dismissible" id="scheme-tip"><p><b>' . $msg . '</b></p></div>';
    }
}

add_action('admin_notices', 'permalink_tip');
//code end

//解析短代码  
add_shortcode('task', 'task_shortcode');
function task_shortcode($attr, $content = '') {
    $out = '<div class="task shortcodestyle"><i class="fa fa-tasks"></i>' . $content . '</div>';
    return $out;
}

add_shortcode('warning', 'warning_shortcode');
function warning_shortcode($attr, $content = '') {
    $out = '<div class="warning shortcodestyle"><i class="fa fa fa-exclamation-triangle"></i>' . $content . '</div>';
    return $out;
}

add_shortcode('noway', 'noway_shortcode');
function noway_shortcode($attr, $content = '') {
    $out = '<div class="noway shortcodestyle"><i class="fa fa-times-rectangle"></i>' . $content . '</div>';
    return $out;
}

add_shortcode('buy', 'buy_shortcode');
function buy_shortcode($attr, $content = '') {
    $out = '<div class="buy shortcodestyle"><i class="fa fa-check-square"></i>' . $content . '</div>';
    return $out;
}

//code end

//WEBP支持
function mimvp_filter_mime_types($array) {
    $array['webp'] = 'image/webp';
    return $array;
}

add_filter('mime_types', 'mimvp_filter_mime_types', 10, 1);
function mimvp_file_is_displayable_image($result, $path) {
    $info = @getimagesize($path);
    if ($info['mime'] == 'image/webp') {
        $result = true;
    }
    return $result;
}

add_filter('file_is_displayable_image', 'mimvp_file_is_displayable_image', 10, 2);

//code end

//展开收缩功能
function x_collapse($atts, $content = null): string {
    $attrs = shortcode_atts(array("title" => ""), $atts);
    return '<div style="margin: 0.5em 0;">
    <div class="xControl">
    <i class="fa fa-arrow-down" style="color: #9F6F26;"></i> &nbsp;&nbsp;
    <span class="xTitle">' . $attrs['title'] . '</span>&nbsp;&nbsp;==>&nbsp;&nbsp;<a href="javascript:void(0)" class="collapseButton xButton"><span class="xbtn02">展开 / 收缩</span></a>
    <div style="clear: both;"></div>
    </div>
    <div class="xContent" style="display: none;">' . $attrs['content'] ?: $content . '</div>
    </div>';
}

add_shortcode('collapse', 'x_collapse');

//code end
