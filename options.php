<?php
/**
 * A unique identifier is defined to store the options in the database and reference them from the theme.
 * By default it uses the theme name, in lowercase and without spaces, but this can be changed if needed.
 * If the identifier changes, it'll appear as if the options have been reset.
 */

function optionsframework_option_name() {
    // 从样式表获取主题名称
    $theme_name = wp_get_theme();
    $theme_name = preg_replace("/\W/", "_", strtolower($theme_name));

    $optionsframework_settings = get_option('optionsframework');
    $optionsframework_settings['id'] = $theme_name;
    update_option('optionsframework', $optionsframework_settings);
}

/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the 'id' fields, make sure to use all lowercase and no spaces.
 *
 * If you are making your theme translatable, you should replace SAKURA_DOMAIN
 * with the actual text domain for your theme.
 *
 * Frame from: https://github.com/devinsays/options-framework-plugin/
 */

function optionsframework_options() {
    $options = array();

    //基本设置
    $options[] = array('name' => ll('Basic'), 'type' => 'heading');

    $options[] = array(
        'name' => ll('Site Title'),
        'desc' => ll('options.basic.site_title.desc'),
        'id'   => 'site_name',
        'std'  => '',
        'type' => 'text'
    );

    $options[] = array(
        'name' => ll('Author'),
        'desc' => ll('options.basic.author.desc'),
        'id'   => 'author_name',
        'std'  => '',
        'type' => 'text'
    );

    $options[] = array(
        'name' => ll('Personal Avatar'),
        'desc' => ll('The best size is 130px*130px.'),
        'id'   => 'focus_logo',
        'type' => 'upload'
    );

    $options[] = array(
        'name' => ll('Text LOGO'),
        'desc' => ll('The home page does not display the avatar above, but displays a paragraph of text (use the avatar above if left blank).The text is recommended not to be too long, about 16 bytes is appropriate.'),
        'id'   => 'focus_logo_text',
        'std'  => '',
        'type' => 'text'
    );

    $options[] = array(
        'name' => ll('Logo'),
        'desc' => ll('The best height size is 40px。'),
        'id'   => 'akina_logo',
        'type' => 'upload'
    );

    $options[] = array(
        'name' => ll('Favicon'),
        'desc' => ll('It is the small logo on the browser tab, fill in the url'),
        'id'   => 'favicon_link',
        'std'  => 'https://cdn.jsdelivr.net/gh/Fuukei/Public_Repository@latest/vision/basic/favicon.ico',
        'type' => 'text'
    );

    $options[] = array(
        'name' => ll('Custom Keywords and Descriptions '),
        'desc' => ll('Customize keywords and descriptions after opening'),
        'id'   => 'akina_meta',
        'std'  => '0',
        'type' => 'checkbox'
    );

    $options[] = array(
        'name' => ll('Site Keywords'),
        'desc' => ll('Each keyword is divided by a comma "," and the number is within 5.'),
        'id'   => 'akina_meta_keywords',
        'std'  => '',
        'type' => 'text'
    );

    $options[] = array(
        'name' => ll('Site Descriptions'),
        'desc' => ll('Describe the site in concise text, with a maximum of 120 words.'),
        'id'   => 'akina_meta_description',
        'std'  => '',
        'type' => 'text'
    );

    $options[] = array(
        'name' => ll('Expand The Nav Menu'),
        'desc' => ll('By default, it is enabled (checked), and the check and collapse are cancelled.'),
        'id'   => 'shownav',
        'std'  => '1',
        'type' => 'checkbox'
    );

    $options[] = array(
        'name' => ll('Head Decoration'),
        'desc' => ll('Enable by default, check off, display on the article page, separate page and category page'),
        'id'   => 'patternimg',
        'std'  => '0',
        'type' => 'checkbox'
    );

    $options[] = array(
        'name'    => ll('Search Button'),
        'id'      => 'top_search',
        'std'     => "yes",
        'type'    => "radio",
        'options' => array('yes' => ll('Open'), 'no' => ll('Close'),)
    );

    $options[] = array(
        'name'    => ll('Home Article Style'),
        'id'      => 'post_list_style',
        'std'     => "imageflow",
        'type'    => "radio",
        'options' => array(
            'standard'  => ll('Standard'),
            'imageflow' => ll('Graphic'),
        )
    );

    $options[] = array(
        'name'    => ll('Home Article Feature Images (Only Valid for Standard Mode)'),
        'id'      => 'list_type',
        'std'     => "round",
        'type'    => "radio",
        'options' => array(
            'round'  => ll('Round'),
            'square' => ll('Square'),
        )
    );

    $options[] = array(
        'name'    => ll('Home Article Feature Images Alignment (Only for Graphic Mode, Default Left and Right Alternate)'),
        'id'      => 'feature_align',
        'std'     => "alternate",
        'type'    => "radio",
        'options' => array(
            'left'      => ll('Left'),
            'right'     => ll('Right'),
            'alternate' => ll('Alternate'),
        )
    );

    $options[] = array(
        'name'    => ll('Paging Mode'),
        'id'      => 'pagenav_style',
        'std'     => "ajax",
        'type'    => "radio",
        'options' => array(
            'ajax' => ll('Ajax load'),
            'np'   => ll('Previous and next page'),
        )
    );

    $options[] = array(
        'name'    => ll('Automatically Load The Next Page'),
        'desc'    => ll('(seconds) Set to automatically load the next page time, the default is not automatically loaded'),
        'id'      => 'auto_load_post',
        'std'     => '1',
        'type'    => 'select',
        'options' => array(
            '0'   => ll('0'),
            '1'   => ll('1'),
            '2'   => ll('2'),
            '3'   => ll('3'),
            '4'   => ll('4'),
            '5'   => ll('5'),
            '6'   => ll('6'),
            '7'   => ll('7'),
            '8'   => ll('8'),
            '9'   => ll('9'),
            '10'  => ll('10'),
            '233' => ll('Do not load automatically'),
        )
    );

    $options[] = array(
        'name' => ll('Footer Info'),
        'desc' => ll('Footer description, support for HTML code'),
        'id'   => 'footer_info',
        'std'  => 'Copyright &copy; by Yesterday17 All Rights Reserved.',
        'type' => 'textarea'
    );

    $options[] = array(
        'name' => ll('About'),
        'desc' => sprintf(ll('Asakura v %s  |  <a href="https://blog.mmf.moe/post/theme-asakura/">Theme document</a>  |  <a href="https://github.com/Yesterday17/Asakura">Source code</a><a href="https://github.com/Yesterday17/Asakura/releases/latest"><img src="https://img.shields.io/github/v/release/Yesterday17/Asakura.svg?style=flat-square" alt="GitHub release"></a>'), SAKURA_VERSION),
        'id'   => 'theme_intro',
        'std'  => '',
        'type' => 'typography '
    );

    $options[] = array(
        'name'    => ll('Check for Updates'),
        'desc'    => '<a href="https://github.com/Yesterday17/Asakura/releases/latest">Download the latest version</a>',
        'id'      => "release_info",
        'std'     => "tag",
        'type'    => "images",
        'options' => array(
            'tag'  => 'https://img.shields.io/github/v/release/Yesterday17/Asakura.svg?style=flat-square',
            'tag2' => 'https://img.shields.io/github/release-date/Yesterday17/Asakura?style=flat-square',
            'tag3' => 'https://data.jsdelivr.com/v1/package/gh/Fuukei/Public_Repository/badge',
        ),
    );

    //首页设置
    $options[] = array('name' => ll('HomePage'), 'type' => 'heading');

    $options[] = array(
        'name' => ll('Main Switch'),
        'desc' => ll('Default on, check off'),
        'id'   => 'main-switch',
        'std'  => '0',
        'type' => 'checkbox'
    );

    $options[] = array(
        'name' => ll('Information Bar'),
        'desc' => ll('It is on by default and checked off to display the avatar / text logo, signature bar and social card.'),
        'id'   => 'info-bar',
        'std'  => '0',
        'type' => 'checkbox'
    );

    $options[] = array(
        'name' => ll('Social Card'),
        'desc' => ll('On by default, check off. When the social card is turned off, the switch button of background random graph and social network icon will not be displayed'),
        'id'   => 'social-card',
        'std'  => '0',
        'type' => 'checkbox'
    );

    $options[] = array(
        'name' => __('Background Random Graphs Switch', SAKURA_DOMAIN),
        'desc' => __('Default on (check), cancel check to turn off display. If the check is not checked, the switch button of background random graph will be turned off', SAKURA_DOMAIN),
        'id'   => 'background-rgs',
        'std'  => '1',
        'type' => 'checkbox'
    );

    $options[] = array(
        'name'    => __('Information Bar Style', SAKURA_DOMAIN),
        'id'      => 'info-bar-style',
        'std'     => "v1",
        'type'    => "radio",
        'options' => array(
            'v2' => __('Social card and signature merge', SAKURA_DOMAIN),
            'v1' => __('Social card and signature independent', SAKURA_DOMAIN),
        )
    );

    $options[] = array(
        'name'  => __('Signature Bar Fillet', SAKURA_DOMAIN),
        'desc'  => __('Fill in the number, the recommended value is 10 to 20', SAKURA_DOMAIN),
        'id'    => 'info-radius',
        'std'   => '15',
        'class' => 'mini',
        'type'  => 'text'
    );

    $options[] = array(
        'name'  => __('Social Card Fillet', SAKURA_DOMAIN),
        'desc'  => __('Fill in the number, the recommended value is 10 to 20', SAKURA_DOMAIN),
        'id'    => 'img-radius',
        'std'   => '15',
        'class' => 'mini',
        'type'  => 'text'
    );

    $options[] = array(
        'name'  => __('Information Bar Avatar Fillet', SAKURA_DOMAIN),
        'desc'  => __('Fill in the number, the recommended value is 90 to 110', SAKURA_DOMAIN),
        'id'    => 'head-radius',
        'std'   => '100',
        'class' => 'mini',
        'type'  => 'text'
    );

    $options[] = array(
        'name'    => __('Cover Random Graphs Option', SAKURA_DOMAIN),
        'desc'    => __('Select how to call the cover random image', SAKURA_DOMAIN),
        'id'      => 'cover_cdn_options',
        'std'     => "type_3",
        'type'    => "select",
        'options' => array(
            'type_1' => __('Webp Optimized Random Graphs', SAKURA_DOMAIN),
            'type_2' => __('Local Random Graphs', SAKURA_DOMAIN),
            'type_3' => __('External API Random Graphs', SAKURA_DOMAIN),
        )
    );

    $options[] = array(
        'name' => __('Multi Terminal Separation of Home Random Graphs', SAKURA_DOMAIN),
        'desc' => __('It is off by default and enabled by check', SAKURA_DOMAIN),
        'id'   => 'cover_beta',
        'std'  => '0',
        'type' => 'checkbox'
    );

    $options[] = array(
        'name' => __('Webp Optimization / External API PC Random Graphs Url', SAKURA_DOMAIN),
        'desc' => sprintf(__('Fill in the manifest path for random picture display, please refer to <a href="https://github.com/mashirozx/Sakura/wiki/options">Wiki </a>. If you select webp images above, click <a href="%s">here</a> to update manifest', SAKURA_DOMAIN), asakura_rest_url('database/update')),
        'id'   => 'cover_cdn',
        'std'  => 'https://api.btstu.cn/sjbz/api.php?lx=dongman&format=images',
        'type' => 'text'
    );

    $options[] = array(
        'name' => __('External API Mobile Random Graphs Url', SAKURA_DOMAIN),
        'desc' => __('When you use the external API random graph and check the multi terminal separation option, please fill in the random graph API mobile terminal address here, otherwise the mobile terminal random graph will be blank', SAKURA_DOMAIN),
        'id'   => 'cover_cdn_mobile',
        'std'  => 'https://api.uomg.com/api/rand.img2?sort=二次元&format=images',
        'type' => 'text'
    );

    $options[] = array(
        'name' => __('Full-Screen Display', SAKURA_DOMAIN),
        'desc' => __('Default on, check off', SAKURA_DOMAIN),
        'id'   => 'focus_height',
        'std'  => '0',
        'type' => 'checkbox'
    );

    $options[] = array(
        'name' => __('Cover Video', SAKURA_DOMAIN),
        'desc' => __('Check on', SAKURA_DOMAIN),
        'id'   => 'focus_amv',
        'std'  => '0',
        'type' => 'checkbox'
    );

    $options[] = array(
        'name' => __('Cover Video Loop', SAKURA_DOMAIN),
        'desc' => __('Check to enable, the video will continue to play automatically, you need to enable Pjax', SAKURA_DOMAIN),
        'id'   => 'focus_mvlive',
        'std'  => '0',
        'type' => 'checkbox'
    );

    $options[] = array(
        'name' => __('Video Url', SAKURA_DOMAIN),
        'desc' => __('The source address of the video, the address is spliced below the video name, the slash is not required at the end of the address', SAKURA_DOMAIN),
        'id'   => 'amv_url',
        'std'  => '',
        'type' => 'text'
    );

    $options[] = array(
        'name' => __('Video Name', SAKURA_DOMAIN),
        'desc' => __('abc.mp4, just fill in the video file name abc, multiple videos separated by commas such as abc, efg, do not care about the order, because the loading is random extraction', SAKURA_DOMAIN),
        'id'   => 'amv_title',
        'std'  => '',
        'type' => 'text'
    );

    $options[] = array(
        'name'    => __('Cover Random Graphs Filter', SAKURA_DOMAIN),
        'id'      => 'focus_img_filter',
        'std'     => "filter-nothing",
        'type'    => "radio",
        'options' => array(
            'filter-nothing'   => __('Nothing', SAKURA_DOMAIN),
            'filter-undertint' => __('Undertint', SAKURA_DOMAIN),
            'filter-dim'       => __('Dim', SAKURA_DOMAIN),
            'filter-grid'      => __('Grid', SAKURA_DOMAIN),
            'filter-dot'       => __('Dot', SAKURA_DOMAIN),
        )
    );

    $options[] = array(
        'name' => __('Announcement', SAKURA_DOMAIN),
        'desc' => __('Default off, check on', SAKURA_DOMAIN),
        'id'   => 'head_notice',
        'std'  => '0',
        'type' => 'checkbox'
    );

    $options[] = array(
        'name' => __('Announcement Content', SAKURA_DOMAIN),
        'desc' => __('Announcement content, the text exceeds 142 bytes will be scrolled display (mobile device is invalid)', SAKURA_DOMAIN),
        'id'   => 'notice_title',
        'std'  => '',
        'type' => 'text'
    );

    $options[] = array(
        'name'    => __('Home Page Post Feature Image Options', SAKURA_DOMAIN),
        'desc'    => __('Select how to call the post featue image, only for the post without feature image', SAKURA_DOMAIN),
        'id'      => 'post_cover_options',
        'std'     => "type_1",
        'type'    => "select",
        'options' => array(
            'type_1' => __('same as the cover of the first screen (default)', SAKURA_DOMAIN),
            'type_2' => __('custom api (advanced)', SAKURA_DOMAIN),
        )
    );

    $options[] = array(
        'name' => __('Post Feature Images Url', SAKURA_DOMAIN),
        'desc' => __('Fill in the custom image api url.', SAKURA_DOMAIN),
        'id'   => 'post_cover',
        'std'  => '',
        'type' => 'text'
    );

    $options[] = array(
        'name' => ll('Home Page Article Details Icon Switch', SAKURA_DOMAIN),
        'desc' => ll('Default on, check off', SAKURA_DOMAIN),
        'id'   => 'hpage-art-dis',
        'std'  => '0',
        'type' => 'checkbox'
    );

    $options[] = array(
        'name' => ll('Focus Area'),
        'desc' => ll('Default off'),
        'id'   => 'focus-area',
        'std'  => '0',
        'type' => 'checkbox'
    );

    $options[] = array(
        'name'    => __('Focus Area Style', SAKURA_DOMAIN),
        'id'      => 'focus-area-style',
        'std'     => "left_and_right",
        'type'    => "radio",
        'options' => array(
            'left_and_right' => __('Alternate left and right', SAKURA_DOMAIN),
            'bottom_to_top'  => __('From bottom to top', SAKURA_DOMAIN),
        )
    );

    $options[] = array(
        'name'  => __('Focus Area Title', SAKURA_DOMAIN),
        'desc'  => __('Default is 聚焦, you can also change it to other, of course you can\'t use it as an advertisement!Not allowed!!', SAKURA_DOMAIN),
        'id'    => 'focus-area-title',
        'std'   => '聚焦',
        'class' => 'mini',
        'type'  => 'text'
    );

    $options[] = array(
        'name' => __('Focus Area First Image', SAKURA_DOMAIN),
        'desc' => __('size 257px*160px', SAKURA_DOMAIN),
        'id'   => 'feature1_img',
        'std'  => "https://cdn.jsdelivr.net/gh/Fuukei/Public_Repository@latest/vision/background/foreground/focus.png",
        'type' => 'upload'
    );

    $options[] = array(
        'name' => __('Focus Area First Title', SAKURA_DOMAIN),
        'desc' => __('Focus Area First Title', SAKURA_DOMAIN),
        'id'   => 'feature1_title',
        'std'  => 'First Focus',
        'type' => 'text'
    );

    $options[] = array(
        'name' => __('Focus Area First Description', SAKURA_DOMAIN),
        'desc' => __('Focus Area First Description', SAKURA_DOMAIN),
        'id'   => 'feature1_description',
        'std'  => 'This is a brief introduction of the focus area',
        'type' => 'text'
    );

    $options[] = array(
        'name' => __('Focus Area First Link', SAKURA_DOMAIN),
        'desc' => __('Focus Area First Link', SAKURA_DOMAIN),
        'id'   => 'feature1_link',
        'std'  => '#',
        'type' => 'text'
    );

    $options[] = array(
        'name' => __('Focus Area Second Image', SAKURA_DOMAIN),
        'desc' => __('size 257px*160px', SAKURA_DOMAIN),
        'id'   => 'feature2_img',
        'std'  => "https://cdn.jsdelivr.net/gh/Fuukei/Public_Repository@latest/vision/background/foreground/focus.png",
        'type' => 'upload'
    );

    $options[] = array(
        'name' => __('Focus Area Second Title', SAKURA_DOMAIN),
        'desc' => __('Focus Area Second Title', SAKURA_DOMAIN),
        'id'   => 'feature2_title',
        'std'  => 'Second Focus',
        'type' => 'text'
    );

    $options[] = array(
        'name' => __('Focus Area Second Description', SAKURA_DOMAIN),
        'desc' => __('Focus Area Second Description', SAKURA_DOMAIN),
        'id'   => 'feature2_description',
        'std'  => 'This is a brief introduction of the focus area',
        'type' => 'text'
    );

    $options[] = array(
        'name' => __('Focus Area Second Link', SAKURA_DOMAIN),
        'desc' => __('Focus Area Second Link', SAKURA_DOMAIN),
        'id'   => 'feature2_link',
        'std'  => '#',
        'type' => 'text'
    );

    $options[] = array(
        'name' => __('Focus Area Third Image', SAKURA_DOMAIN),
        'desc' => __('size 257px*160px', SAKURA_DOMAIN),
        'id'   => 'feature3_img',
        'std'  => "https://cdn.jsdelivr.net/gh/Fuukei/Public_Repository@latest/vision/background/foreground/focus.png",
        'type' => 'upload'
    );

    $options[] = array(
        'name' => __('Focus Area Third Title', SAKURA_DOMAIN),
        'desc' => __('Focus Area Third Title', SAKURA_DOMAIN),
        'id'   => 'feature3_title',
        'std'  => 'Third Focus',
        'type' => 'text'
    );

    $options[] = array(
        'name' => __('Focus Area Third Description', SAKURA_DOMAIN),
        'desc' => __('Focus Area Third Description', SAKURA_DOMAIN),
        'id'   => 'feature3_description',
        'std'  => 'This is a brief introduction of the focus area',
        'type' => 'text'
    );

    $options[] = array(
        'name' => __('Focus Area Third Link', SAKURA_DOMAIN),
        'desc' => __('Focus Area Third Link', SAKURA_DOMAIN),
        'id'   => 'feature3_link',
        'std'  => '#',
        'type' => 'text'
    );

    $options[] = array(
        'name'  => __('Main Page Article Title', SAKURA_DOMAIN),
        'desc'  => __('Default is 記事, you can also change it to other, of course you can\'t use it as an advertisement!Not allowed!!', SAKURA_DOMAIN),
        'id'    => 'homepage_title',
        'std'   => '記事',
        'class' => 'mini',
        'type'  => 'text'
    );

    //文章页
    $options[] = array('name' => ll('Post'), 'type' => 'heading');

    $options[] = array(
        'name'    => __('Post Style', SAKURA_DOMAIN),
        'id'      => 'entry_content_theme',
        'std'     => 'sakura',
        'type'    => "radio",
        'options' => array(
            'sakura' => __('Default Style', SAKURA_DOMAIN),
            'github' => __('GitHub Style', SAKURA_DOMAIN),
        )
    );

    $options[] = array(
        'name'    => __('Previous and Next', SAKURA_DOMAIN),
        'id'      => 'post_nepre',
        'std'     => "yes",
        'type'    => "radio",
        'options' => array('yes' => __('Open', SAKURA_DOMAIN), 'no' => __('Close', SAKURA_DOMAIN),)
    );

    $options[] = array(
        'name' => ll('options.post.toc_always_on.name'),
        'desc' => ll('options.post.toc_always_on.desc'),
        'id'   => 'toc_always_on',
        'std'  => "1",
        'type' => "checkbox",
    );

    $options[] = array(
        'name'    => __('Author Profile', SAKURA_DOMAIN),
        'id'      => 'author_profile',
        'std'     => "yes",
        'type'    => "radio",
        'options' => array('yes' => __('Open', SAKURA_DOMAIN), 'no' => __('Close', SAKURA_DOMAIN),)
    );

    $options[] = array(
        'name'    => __('Comment Shrink', SAKURA_DOMAIN),
        'id'      => 'toggle-menu',
        'std'     => "yes",
        'type'    => "radio",
        'options' => array('yes' => __('Open', SAKURA_DOMAIN), 'no' => __('Close', SAKURA_DOMAIN),)
    );

    $options[] = array(
        'name' => __('Comment Textarea Image', SAKURA_DOMAIN),
        'desc' => __('NO image if left this blank', SAKURA_DOMAIN),
        'id'   => 'comment-image',
        'type' => 'upload'
    );

    $options[] = array(
        'name' => __('Author information at The End of The Paper', SAKURA_DOMAIN),
        'desc' => __('Check to enable', SAKURA_DOMAIN),
        'id'   => 'show_authorprofile',
        'std'  => '1',
        'type' => 'checkbox'
    );

    $options[] = array(
        'name' => __('Post Lincenses', SAKURA_DOMAIN),
        'desc' => __('Check close', SAKURA_DOMAIN),
        'id'   => 'post-lincenses',
        'std'  => '0',
        'type' => 'checkbox'
    );

    $options[] = array(
        'name' => __('Alipay Reward', SAKURA_DOMAIN),
        'desc' => __('Alipay qrcode', SAKURA_DOMAIN),
        'id'   => 'alipay_code',
        'type' => 'upload'
    );

    $options[] = array(
        'name' => __('Wechat Reward', SAKURA_DOMAIN),
        'desc' => __('Wechat qrcode ', SAKURA_DOMAIN),
        'id'   => 'wechat_code',
        'type' => 'upload'
    );

    //社交选项
    $options[] = array('name' => __('Social', SAKURA_DOMAIN), 'type' => 'heading');

    $options[] = array(
        'name' => __('Wechat', SAKURA_DOMAIN),
        'desc' => __('Wechat qrcode', SAKURA_DOMAIN),
        'id'   => 'wechat',
        'type' => 'upload'
    );

    $options[] = array(
        'name' => __('Sina Weibo', SAKURA_DOMAIN),
        'desc' => __('Sina Weibo address', SAKURA_DOMAIN),
        'id'   => 'sina',
        'std'  => '',
        'type' => 'text'
    );

    $options[] = array(
        'name' => __('Tencent QQ', SAKURA_DOMAIN),
        'desc' => __('tencent://message/?uin={{QQ number}}. for example, tencent://message/?uin=123456', SAKURA_DOMAIN),
        'id'   => 'qq',
        'std'  => '',
        'type' => 'text'
    );

    $options[] = array(
        'name' => __('Telegram', SAKURA_DOMAIN),
        'desc' => __('Telegram link', SAKURA_DOMAIN),
        'id'   => 'telegram',
        'std'  => '',
        'type' => 'text'
    );

    $options[] = array(
        'name' => __('Qzone', SAKURA_DOMAIN),
        'desc' => __('Qzone address', SAKURA_DOMAIN),
        'id'   => 'qzone',
        'std'  => '',
        'type' => 'text'
    );

    $options[] = array(
        'name' => __('GitHub', SAKURA_DOMAIN),
        'desc' => __('GitHub address', SAKURA_DOMAIN),
        'id'   => 'github',
        'std'  => '',
        'type' => 'text'
    );

    $options[] = array(
        'name' => __('Lofter', SAKURA_DOMAIN),
        'desc' => __('Lofter address', SAKURA_DOMAIN),
        'id'   => 'lofter',
        'std'  => '',
        'type' => 'text'
    );

    $options[] = array(
        'name' => __('BiliBili', SAKURA_DOMAIN),
        'desc' => __('BiliBili address', SAKURA_DOMAIN),
        'id'   => 'bili',
        'std'  => '',
        'type' => 'text'
    );

    $options[] = array(
        'name' => __('Youku video', SAKURA_DOMAIN),
        'desc' => __('Youku video address', SAKURA_DOMAIN),
        'id'   => 'youku',
        'std'  => '',
        'type' => 'text'
    );

    $options[] = array(
        'name' => __('Netease Cloud Music', SAKURA_DOMAIN),
        'desc' => __('Netease Cloud Music address', SAKURA_DOMAIN),
        'id'   => 'wangyiyun',
        'std'  => '',
        'type' => 'text'
    );

    $options[] = array(
        'name' => __('Twitter', SAKURA_DOMAIN),
        'desc' => __('Twitter address', SAKURA_DOMAIN),
        'id'   => 'twitter',
        'std'  => '',
        'type' => 'text'
    );

    $options[] = array(
        'name' => __('Facebook', SAKURA_DOMAIN),
        'desc' => __('Facebook address', SAKURA_DOMAIN),
        'id'   => 'facebook',
        'std'  => '',
        'type' => 'text'
    );

    $options[] = array(
        'name' => __('Jianshu', SAKURA_DOMAIN),
        'desc' => __('Jianshu address', SAKURA_DOMAIN),
        'id'   => 'jianshu',
        'std'  => '',
        'type' => 'text'
    );

    $options[] = array(
        'name' => __('CSDN', SAKURA_DOMAIN),
        'desc' => __('CSND community address', SAKURA_DOMAIN),
        'id'   => 'csdn',
        'std'  => '',
        'type' => 'text'
    );

    $options[] = array(
        'name' => __('Zhihu', SAKURA_DOMAIN),
        'desc' => __('Zhihu address', SAKURA_DOMAIN),
        'id'   => 'zhihu',
        'std'  => '',
        'type' => 'text'
    );

    $options[] = array(
        'name' => __('Email-Name', SAKURA_DOMAIN),
        'desc' => __('The name part of name@domain.com, only the frontend has js runtime environment can get the full address, you can rest assured to fill in', SAKURA_DOMAIN),
        'id'   => 'email_name',
        'std'  => '',
        'type' => 'text'
    );

    $options[] = array(
        'name' => __('Email-Domain', SAKURA_DOMAIN),
        'desc' => __('The domain.com part of name@domain.com', SAKURA_DOMAIN),
        'id'   => 'email_domain',
        'std'  => '',
        'type' => 'text'
    );

    //前台设置
    $options[] = array('name' => __('Foreground', SAKURA_DOMAIN), 'type' => 'heading');

    $options[] = array(
        'name' => ll('Default Foreground Background'),
        'desc' => ll('Default Foreground Background, Fill in URL'),
        'id'   => 'sakura_skin_bg',
        'std'  => 'none',
        'type' => 'text'
    );

    $options[] = array(
        'name' => __('Homepage Animation', SAKURA_DOMAIN),
        'desc' => __('Check open', SAKURA_DOMAIN),
        'id'   => 'homepage-ani',
        'std'  => '1',
        'type' => 'checkbox'
    );

    $options[] = array(
        'name' => __('Article Title Line Animation', SAKURA_DOMAIN),
        'desc' => __('Check open', SAKURA_DOMAIN),
        'id'   => 'title-line',
        'std'  => '0',
        'type' => 'checkbox'
    );

    $options[] = array(
        'name' => __('Article Title Animation', SAKURA_DOMAIN),
        'desc' => __('Check open', SAKURA_DOMAIN),
        'id'   => 'title-ani',
        'std'  => '1',
        'type' => 'checkbox'
    );

    $options[] = array(
        'name'  => ll('Homepage Animation Time'),
        'desc'  => ll('Fill in Number'),
        'id'    => 'hp-ani-t',
        'std'   => '0.5',
        'class' => 'mini',
        'type'  => 'text'
    );

    $options[] = array(
        'name'  => __('Article Title Animation Time', SAKURA_DOMAIN),
        'desc'  => __('Fill in Number', SAKURA_DOMAIN),
        'id'    => 'title-ani-t',
        'std'   => '2',
        'class' => 'mini',
        'type'  => 'text'
    );

    $options[] = array(
        'name'  => __('Foreground Transparency', SAKURA_DOMAIN),
        'desc'  => __('Fill in numbers between 0.1 and 1', SAKURA_DOMAIN),
        'id'    => 'homepagebgtmd',
        'std'   => '0.8',
        'class' => 'mini',
        'type'  => 'text'
    );

    $options[] = array(
        'name' => __('Close Foreground Login Entry', SAKURA_DOMAIN),
        'desc' => __('Check off by default', SAKURA_DOMAIN),
        'id'   => 'user-avatar',
        'std'  => '0',
        'type' => 'checkbox'
    );

    $options[] = array(
        'name' => __('Search Icon Normal Size', SAKURA_DOMAIN),
        'desc' => __('Check off by default', SAKURA_DOMAIN),
        'id'   => 'search-ico',
        'std'  => '0',
        'type' => 'checkbox'
    );

    $options[] = array(
        'name'    => __('Footer Float Music Player', SAKURA_DOMAIN),
        'desc'    => __('Choose which platform you\'ll use.', SAKURA_DOMAIN),
        'id'      => 'aplayer_server',
        'std'     => "netease",
        'type'    => "select",
        'options' => array(
            'netease' => __('Netease Cloud Music (default)', SAKURA_DOMAIN),
            'xiami'   => __('Xiami Music', SAKURA_DOMAIN),
            'kugou'   => __('KuGou Music (may fail)', SAKURA_DOMAIN),
            'baidu'   => __('Baidu Music（Overseas server does not support）', SAKURA_DOMAIN),
            'tencent' => __('QQ Music (may fail) ', SAKURA_DOMAIN),
            'off'     => __('Off', SAKURA_DOMAIN),
        )
    );

    $options[] = array(
        'name' => __('Song List ID', SAKURA_DOMAIN),
        'desc' => __('Fill in the "song list" ID, eg: https://music.163.com/#/playlist?id=3124382377 The ID is 3124382377', SAKURA_DOMAIN),
        'id'   => 'aplayer_playlistid',
        'std'  => '3124382377',
        'type' => 'text'
    );

    $options[] = array(
        'name' => __('Netease Cloud Music Cookie', SAKURA_DOMAIN),
        'desc' => __('For Netease Cloud Music, fill in your vip account\'s cookies if you want to play special tracks.<b>If you don\'t know what does mean, left it blank.</b>', SAKURA_DOMAIN),
        'id'   => 'aplayer_cookie',
        'std'  => '',
        'type' => 'textarea'
    );

    $options[] = array(
        'name' => __('Pjax Refresh', SAKURA_DOMAIN),
        'desc' => __('Check on, and the principle is the same as Ajax.', SAKURA_DOMAIN),
        'id'   => 'poi_pjax',
        'std'  => '0',
        'type' => 'checkbox'
    );

    $options[] = array(
        'name' => __('NProgress Progress Bar', SAKURA_DOMAIN),
        'desc' => __('Check on by default', SAKURA_DOMAIN),
        'id'   => 'nprogress_on',
        'std'  => '1',
        'type' => 'checkbox'
    );

    $options[] = array(
        'name' => __('Sidebar Widget', SAKURA_DOMAIN),
        'desc' => __('Default off, check on', SAKURA_DOMAIN),
        'id'   => 'sakura_widget',
        'std'  => '0',
        'type' => 'checkbox'
    );

    $options[] = array(
        'name' => __('Sidebar Widget Background Image', SAKURA_DOMAIN),
        'desc' => __('Fill in the URL', SAKURA_DOMAIN),
        'id'   => 'sakura_widget_bg',
        'std'  => '',
        'type' => 'text'
    );

    //后台设置
    $options[] = array('name' => __('Backstage', SAKURA_DOMAIN), 'type' => 'heading');

    $options[] = array(
        'name' => __('Backstage Background Image', SAKURA_DOMAIN),
        'desc' => __('Backstage Background Image', SAKURA_DOMAIN),
        'id'   => 'admin_menu_bg',
        'std'  => "https://cdn.jsdelivr.net/gh/Fuukei/Public_Repository@latest/vision/background/backstage/admin-bg.jpg",
        'type' => 'upload'
    );

    $options[] = array(
        'name' => __('Login Interface Background Image', SAKURA_DOMAIN),
        'desc' => __('Use the default image if left this blank', SAKURA_DOMAIN),
        'id'   => 'login_bg',
        'type' => 'upload'
    );

    $options[] = array(
        'name' => __('Background Virtualization of Login Interface', SAKURA_DOMAIN),
        'desc' => __('It is off by default and enabled by check', SAKURA_DOMAIN),
        'id'   => 'login_blur',
        'std'  => '0',
        'type' => 'checkbox'
    );

    $options[] = array(
        'name' => __('Login Interface Logo', SAKURA_DOMAIN),
        'desc' => __('Used for login interface display', SAKURA_DOMAIN),
        'id'   => 'logo_img',
        'std'  => "https://cdn.jsdelivr.net/gh/Fuukei/Public_Repository@latest/vision/basic/logo-login.png",
        'type' => 'upload'
    );

    $options[] = array(
        'name' => __('Login/Registration Related Settings', SAKURA_DOMAIN),
        'desc' => __(' ', 'space', SAKURA_DOMAIN),
        'id'   => 'login_tip',
        'std'  => '',
        'type' => 'typography '
    );

    $options[] = array(
        'name' => __('Specify Login Address', SAKURA_DOMAIN),
        'desc' => __('Forcibly do not use the background address to log in, fill in the new landing page address, such as http://www.xxx.com/login [Note] Before you fill out, test your new page can be opened normally, so as not to enter the background or other problems happening', SAKURA_DOMAIN),
        /*强制不使用后台地址登录，填写新建的登录页面地址，比如 http://www.xxx.com/login【注意】填写前先测试下你新建的页面是可以正常打开的，以免造成无法进入后台等情况*/
        'id'   => 'exlogin_url',
        'std'  => '',
        'type' => 'text'
    );

    $options[] = array(
        'name' => __('Automatically Redirect After Login', SAKURA_DOMAIN),
        'desc' => __('After checken, the administrator redirects to the background and the user redirects to the home page.', SAKURA_DOMAIN),
        'id'   => 'login_urlskip',
        'std'  => '0',
        'type' => 'checkbox'
    );

    //进阶
    $options[] = array('name' => __('Advanced', SAKURA_DOMAIN), 'type' => 'heading');

    $options[] = array(
        'name' => __('Use JS and CSS File of The Theme (sakura-app.js、style.css) locally', SAKURA_DOMAIN),
        'desc' => __('The js and css files of the theme do not load from jsDelivr, please open when DIY', SAKURA_DOMAIN),
        'id'   => 'app_no_jsdelivr_cdn',
        'std'  => '1',
        'type' => 'checkbox'
    );

    $options[] = array(
        'name' => __('Gravatar Avatar Proxy', SAKURA_DOMAIN),
        'desc' => __('A front-ed proxy for Gravatar, eg. sdn.geekzu.org/avatar . Leave it blank if you do not need.', SAKURA_DOMAIN),
        'id'   => 'gravatar_proxy',
        'std'  => "sdn.geekzu.org/avatar",
        'type' => "text"
    );

    $options[] = array(
        'name' => __('Images CDN', SAKURA_DOMAIN),
        'desc' => __('Note: Fill in the format http(s)://your CDN domain name/. <br>In other words, the original path is http://your.domain/wp-content/uploads/2018/05/xx.png and the picture will load from http://your CDN domain/2018/05/xx.png', SAKURA_DOMAIN),
        'id'   => 'image_cdn',
        'std'  => '',
        'type' => 'text'
    );

    $options[] = array(
        'name' => __('Google Analytics', SAKURA_DOMAIN),
        'desc' => __('UA-xxxxx-x', SAKURA_DOMAIN),
        'id'   => 'google_analytics_id',
        'std'  => '',
        'type' => 'text'
    );

    $options[] = array(
        'name' => __('CNZZ Statistics (Not Recommand)', SAKURA_DOMAIN),
        'desc' => __('Statistics code, which will be invisible in web page.', SAKURA_DOMAIN),
        'id'   => 'site_statistics',
        'std'  => '',
        'type' => 'textarea'
    );

    $options[] = array(
        'name' => __('Customize CSS Styles', SAKURA_DOMAIN),
        'desc' => __('Fill in the CSS code directly, no need to write style tags', SAKURA_DOMAIN),
        'id'   => 'site_custom_style',
        'std'  => '',
        'type' => 'textarea'
    );

    $options[] = array(
        'name' => __('The Categories of Articles that don\'t not show on homepage', SAKURA_DOMAIN),
        'desc' => __('Fill in category ID, multiple IDs are divided by a comma ","', SAKURA_DOMAIN),
        'id'   => 'classify_display',
        'std'  => '',
        'type' => 'text'
    );

    $options[] = array(
        'name' => __('Images Category', SAKURA_DOMAIN),
        'desc' => __('Fill in category ID, multiple IDs are divided by a comma ","', SAKURA_DOMAIN),
        'id'   => 'image_category',
        'std'  => '',
        'type' => 'text'
    );

    $options[] = array(
        'name' => __('Version Control', SAKURA_DOMAIN),
        'desc' => __('Used to update frontend cookies and browser caches, any string can be used', SAKURA_DOMAIN),
        'id'   => 'cookie_version',
        'std'  => '',
        'type' => 'text'
    );

    $options[] = array(
        'name'  => __('Time Zone Adjustment', SAKURA_DOMAIN),
        'desc'  => __('If the comment has a time difference problem adjust here, fill in an integer, the calculation method: actual_time = display_error_time - the_integer_you_entered (unit: hour)', SAKURA_DOMAIN),
        'id'    => 'time_zone_fix',
        'std'   => '0',
        'class' => 'mini',
        'type'  => 'text'
    );

    //功能
    $options[] = array('name' => __('Function', SAKURA_DOMAIN), 'type' => 'heading');

    $options[] = array(
        'name' => __('Bilibili UID', SAKURA_DOMAIN),
        'desc' => __('Fill in your UID, eg.https://space.bilibili.com/13972644/, only fill in with the number part.', SAKURA_DOMAIN),
        'id'   => 'bilibili_id',
        'std'  => '13972644',
        'type' => 'text'
    );

    $options[] = array(
        'name' => __('Bilibili Cookie', SAKURA_DOMAIN),
        'desc' => __('Fill in your Cookies, go to your bilibili homepage, you can get cookies in brownser network pannel with pressing F12. If left this blank, you\'ll not get the progress.', SAKURA_DOMAIN),
        'id'   => 'bilibili_cookie',
        'std'  => 'LIVE_BUVID=',
        'type' => 'textarea'
    );

    $options[] = array(
        'name' => __('Comment UA Infomation', SAKURA_DOMAIN),
        'desc' => __('Check to enable, display the user\'s browser, operating system information', SAKURA_DOMAIN),
        'id'   => 'open_useragent',
        'std'  => '0',
        'type' => 'checkbox'
    );

    $options[] = array(
        'name' => __('Comment Location Infomation', SAKURA_DOMAIN),
        'desc' => __('Check to enable, display the user\'s location info', SAKURA_DOMAIN),
        'id'   => 'open_location',
        'std'  => '0',
        'type' => 'checkbox'
    );

    $options[] = array(
        'name'    => __('Comment Image Upload API', SAKURA_DOMAIN),
        'id'      => 'img_upload_api',
        'std'     => "imgur",
        'type'    => "radio",
        'options' => array(
            'imgur'     => __('Imgur (https://imgur.com)', SAKURA_DOMAIN),
            'smms'      => __('SM.MS (https://sm.ms)', SAKURA_DOMAIN),
            'chevereto' => __('Chevereto (https://chevereto.com)', SAKURA_DOMAIN),
        )
    );

    $options[] = array(
        'name' => __('Imgur Client ID', SAKURA_DOMAIN),
        'desc' => __('Register your application <a href="https://api.imgur.com/oauth2/addclient">here</a>, note we only need the Client ID here.', SAKURA_DOMAIN),
        'id'   => 'imgur_client_id',
        'std'  => '',
        'type' => 'text'
    );

    $options[] = array(
        'name' => __('SM.MS Secret Token', SAKURA_DOMAIN),
        'desc' => __('Register your application <a href="https://sm.ms/home/apitoken">here</a>.', SAKURA_DOMAIN),
        'id'   => 'smms_client_id',
        'std'  => '',
        'type' => 'text'
    );

    $options[] = array(
        'name' => __('Chevereto API v1 key', SAKURA_DOMAIN),
        'desc' => __('Get your API key here: ' . akina_option('cheverto_url') . '/dashboard/settings/api', SAKURA_DOMAIN),
        'id'   => 'chevereto_api_key',
        'std'  => '',
        'type' => 'text'
    );

    $options[] = array(
        'name' => __('Chevereto URL', SAKURA_DOMAIN),
        'desc' => __('Your Chevereto homepage url, no slash in the end, eg. https://your.cherverto.com', SAKURA_DOMAIN),
        'id'   => 'cheverto_url',
        'std'  => 'https://your.cherverto.com',
        'type' => 'text'
    );

    $options[] = array(
        'name' => __('Comment Images Proxy', SAKURA_DOMAIN),
        'desc' => __('A front-ed proxy for the uploaded images. Leave it blank if you do not need.', SAKURA_DOMAIN),
        'id'   => 'cmt_image_proxy',
        'std'  => 'https://images.weserv.nl/?url=',
        'type' => 'text'
    );

    $options[] = array(
        'name' => __('Imgur Upload Proxy', SAKURA_DOMAIN),
        'desc' => __('A back-ed proxy to upload images. You may set a self hosted proxy with Nginx, following my <a href="https://2heng.xin/2018/06/06/javascript-upload-images-with-imgur-api/">turtal</a>. This feature is mainly for Chinese who cannot access to Imgur due to the GFW. The default and official setting is 【<a href="https://api.imgur.com/3/image/">https://api.imgur.com/3/image/</a>】', SAKURA_DOMAIN),
        'id'   => 'imgur_upload_image_proxy',
        'std'  => 'https://api.imgur.com/3/image/',
        'type' => 'text'
    );

    $options[] = array(
        'name'    => __('Statistics Interface', SAKURA_DOMAIN),
        'id'      => 'statistics_api',
        'std'     => "theme_build_in",
        'type'    => "radio",
        'options' => array(
            'wp_statistics'  => __('WP-Statistics plugin (Professional statistics, can exclude invalid access)', SAKURA_DOMAIN),
            'theme_build_in' => __('Theme built-in (simple statistics, calculate each page access request)', SAKURA_DOMAIN),
        )
    );

    $options[] = array(
        'name'    => __('Statistical Data Display Format', SAKURA_DOMAIN),
        'id'      => 'statistics_format',
        'std'     => "type_1",
        'type'    => "radio",
        'options' => array(
            'type_1' => __('23333 Views (default)', SAKURA_DOMAIN),
            'type_2' => __('23,333 Views (britain)', SAKURA_DOMAIN),
            'type_3' => __('23 333 Views (french)', SAKURA_DOMAIN),
            'type_4' => __('23k Views (chinese)', SAKURA_DOMAIN),
        )
    );

    $options[] = array(
        'name' => __('Private Comment Function', SAKURA_DOMAIN),
        'desc' => __('It is not checked by default. It is checked to enable. This feature allows users to set their own comments invisible to others', SAKURA_DOMAIN),
        'id'   => 'open_private_message',
        'std'  => '0',
        'type' => 'checkbox'
    );

    $options[] = array(
        'name'    => __('QQ Avatar Link Encryption', SAKURA_DOMAIN),
        'desc'    => __('Do not display the user\'s qq avatar links directly.', SAKURA_DOMAIN),
        'id'      => 'qq_avatar_link',
        'std'     => "off",
        'type'    => "select",
        'options' => array(
            'off'    => __('Off (default)', SAKURA_DOMAIN),
            'type_1' => __('use redirect (general security)', SAKURA_DOMAIN),
            'type_2' => __('fetch data at backend (high security)', SAKURA_DOMAIN),
            'type_3' => __('fetch data at backend (high security，slow)', SAKURA_DOMAIN),
        )
    );

    $options[] = array(
        'name' => __('Search Background Customization', SAKURA_DOMAIN),
        'desc' => __('It is the cute one that opens the search interface', SAKURA_DOMAIN),
        'id'   => 'search-image',
        'std'  => "https://cdn.jsdelivr.net/gh/Fuukei/Public_Repository@latest/vision/basic/iloli.gif",
        'type' => 'upload'
    );

    $options[] = array(
        'name' => __('Real Time Search Function', SAKURA_DOMAIN),
        'desc' => __('Real-time search in the foreground, call the Rest API to update the cache every hour, you can manually set the cache time in api.php', SAKURA_DOMAIN),
        'id'   => 'live_search',
        'std'  => '0',
        'type' => 'checkbox'
    );

    $options[] = array(
        'name' => __('Include Comments in Real Time Search', SAKURA_DOMAIN),
        'desc' => __('Search for comments in real-time search (not recommended if there are too many comments on the site)', SAKURA_DOMAIN),
        'id'   => 'live_search_comment',
        'std'  => '0',
        'type' => 'checkbox'
    );

    $options[] = array(
        'name' => __('Friend Link Information Layout', SAKURA_DOMAIN),
        'desc' => __('The default alignment is left, check it will center alignment', SAKURA_DOMAIN),
        'id'   => 'friend_center',
        'std'  => '0',
        'type' => 'checkbox'
    );

    $options[] = array(
        'name' => __('Article Page Lazyload Function', SAKURA_DOMAIN),
        'desc' => __('Default on', SAKURA_DOMAIN),
        'id'   => 'lazyload',
        'std'  => '1',
        'type' => 'checkbox'
    );

    $options[] = array(
        'name' => __('Lazyload Spinner', SAKURA_DOMAIN),
        'desc' => __('The placeholder to display when the image loads, fill in the image url', SAKURA_DOMAIN),
        'id'   => 'lazyload_spinner',
        'std'  => 'https://cdn.jsdelivr.net/gh/Fuukei/Public_Repository@latest/vision/theme/sakura/load/inload.svg',
        'type' => 'text'
    );

    $options[] = array(
        'name' => __('Mail Template Header', SAKURA_DOMAIN),
        'desc' => __('Set the background picture above your message', SAKURA_DOMAIN),
        'id'   => 'mail_img',
        'std'  => 'https://cdn.jsdelivr.net/gh/Fuukei/Public_Repository@latest/vision/basic/mail-head.jpg',
        'type' => 'upload'
    );

    $options[] = array(
        'name' => __('Email Address Prefix', SAKURA_DOMAIN),
        'desc' => __('For sending system mail, the sender address displayed in the user\'s mailbox, do not use Chinese, the default system email address is bibi@your_domain_name', SAKURA_DOMAIN),
        'id'   => 'mail_user_name',
        'std'  => 'bibi',
        'type' => 'text'
    );

    $options[] = array(
        'name' => __('Comments Reply Notification', SAKURA_DOMAIN),
        'desc' => __('WordPress will use email to notify users when their comments receive a reply by default. Tick this item allows users to set their own comments reply notification', SAKURA_DOMAIN),
        'id'   => 'mail_notify',
        'std'  => '0',
        'type' => 'checkbox'
    );

    $options[] = array(
        'name' => __('Administrator Comment Notification', SAKURA_DOMAIN),
        'desc' => __('Whether to use email notification when the administrator\'s comments receive a reply', SAKURA_DOMAIN),
        'id'   => 'admin_notify',
        'std'  => '0',
        'type' => 'checkbox'
    );

    //增强功能
    $options[] = array('name' => __('Enhanced', SAKURA_DOMAIN), 'type' => 'heading');

    $options[] = array(
        'name' => __('Preload Animation', SAKURA_DOMAIN),
        'desc' => __('Check open', SAKURA_DOMAIN),
        'id'   => 'preload_animation',
        'std'  => '0',
        'type' => 'checkbox'
    );

    $options[] = array(
        'name' => __('Cherry Blossom Falling Effect', SAKURA_DOMAIN),
        'desc' => __('Check open', SAKURA_DOMAIN),
        'id'   => 'sakurajs',
        'std'  => '0',
        'type' => 'checkbox'
    );

    $options[] = array(
        'name'    => __('Cherry Blossom Falling Quantity', SAKURA_DOMAIN),
        'desc'    => __('Four kinds of quantity, default native quantity', SAKURA_DOMAIN),
        'id'      => 'sakura-falling-quantity',
        'std'     => 'native',
        'type'    => 'select',
        'options' => array(
            'native'  => __('native', SAKURA_DOMAIN),
            'quarter' => __('quarter', SAKURA_DOMAIN),
            'half'    => __('half', SAKURA_DOMAIN),
            'less'    => __('less', SAKURA_DOMAIN),
        )
    );

    $options[] = array(
        'name' => __('Wave Effects', SAKURA_DOMAIN),
        'desc' => __('Check open', SAKURA_DOMAIN),
        'id'   => 'bolangcss',
        'std'  => '0',
        'type' => 'checkbox'
    );

    $options[] = array(
        'name'  => __('Footer Suspension Player Default Volume', SAKURA_DOMAIN),
        'desc'  => __('Maximum 1 minimum 0', SAKURA_DOMAIN),
        'id'    => 'playlist_mryl',
        'std'   => '0.5',
        'class' => 'mini',
        'type'  => 'text'
    );

    $options[] = array(
        'name' => __('live2D', SAKURA_DOMAIN),
        'desc' => __('Check open', SAKURA_DOMAIN),
        'id'   => 'live2djs',
        'std'  => '0',
        'type' => 'checkbox'
    );

    $options[] = array(
        'name' => __('Live2D Custom Resource Address', SAKURA_DOMAIN),
        'desc' => __('Fill in Live2D Custom Resource Address', SAKURA_DOMAIN),
        'id'   => 'live2d-custom',
        'std'  => 'mirai-mamori',
        'type' => 'text'
    );

    $options[] = array(
        'name'  => __('Live2D Custom Resource Version', SAKURA_DOMAIN),
        'desc'  => __('Fill in Live2D Custom Resource Version', SAKURA_DOMAIN),
        'id'    => 'live2d-custom-ver',
        'std'   => 'latest',
        'class' => 'mini',
        'type'  => 'text'
    );

    $options[] = array(
        'name' => __('Drop-down Arrow', SAKURA_DOMAIN),
        'desc' => __('Check open', SAKURA_DOMAIN),
        'id'   => 'godown',
        'std'  => '1',
        'type' => 'checkbox'
    );

    $options[] = array(
        'name' => __('Turn off Drop-down Arrow Mobile Display', SAKURA_DOMAIN),
        'desc' => __('Check by default, cancel opening', SAKURA_DOMAIN),
        'id'   => 'godown-mb',
        'std'  => '1',
        'type' => 'checkbox'
    );

    $options[] = array(
        'name' => __('A Brief Remark', SAKURA_DOMAIN),
        'desc' => __('Check open', SAKURA_DOMAIN),
        'id'   => 'oneword',
        'std'  => '0',
        'type' => 'checkbox'
    );

    $options[] = array(
        'name' => __('Load Occupancy Query', SAKURA_DOMAIN),
        'desc' => __('Check open', SAKURA_DOMAIN),
        'id'   => 'loadoq',
        'std'  => '0',
        'type' => 'checkbox'
    );

    $options[] = array(
        'name' => __('One Word Typing Effect of Home Page', SAKURA_DOMAIN),
        'desc' => __('Check open', SAKURA_DOMAIN),
        'id'   => 'dazi',
        'std'  => '0',
        'type' => 'checkbox'
    );

    $options[] = array(
        'name' => __('Double Quotation Marks for Typing Effect', SAKURA_DOMAIN),
        'desc' => __('Check open', SAKURA_DOMAIN),
        'id'   => 'dazi_yh',
        'std'  => '0',
        'type' => 'checkbox'
    );

    $options[] = array(
        'name' => __('Typewriting Effect Text', SAKURA_DOMAIN),
        'desc' => __('Fill in the text part of the typing effect (double quotation marks must be used outside the text, and English commas shall be used to separate the two sentences. Support for HTML tags)', SAKURA_DOMAIN),
        'id'   => 'dazi_a',
        'std'  => '"寒蝉黎明之时,便是重生之日。"',
        'type' => 'text'
    );

    $options[] = array(
        'name' => __('Homepage One Word Blogger Description', SAKURA_DOMAIN),
        'desc' => __('A self description', SAKURA_DOMAIN),
        'id'   => 'admin_des',
        'std'  => '粉色的花瓣，美丽地缠绕在身上。依在风里。',
        'type' => 'textarea'
    );

    $options[] = array(
        'name' => __('Blog Description at the end of The Article', SAKURA_DOMAIN),
        'desc' => __('A self description', SAKURA_DOMAIN),
        'id'   => 'admin_destwo',
        'std'  => '粉色的花瓣，美丽地缠绕在身上。依在风里。',
        'type' => 'textarea'
    );

    $options[] = array(
        'name' => __('Note Effects', SAKURA_DOMAIN),
        'desc' => __('Check open', SAKURA_DOMAIN),
        'id'   => 'audio',
        'std'  => '0',
        'type' => 'checkbox'
    );

    $options[] = array(
        'name' => __('Logo Special Effects', SAKURA_DOMAIN),
        'desc' => __('Check open', SAKURA_DOMAIN),
        'id'   => 'logocss',
        'std'  => '0',
        'type' => 'checkbox'
    );

    $options[] = array(
        'name' => __('Logo Text A', SAKURA_DOMAIN),
        'desc' => __('Fill in the front part of your logo text', SAKURA_DOMAIN),
        'id'   => 'logo_a',
        'std'  => ' ',
        'type' => 'text'
    );

    $options[] = array(
        'name' => __('Logo Text B', SAKURA_DOMAIN),
        'desc' => __('Fill in the middle part of your logo text', SAKURA_DOMAIN),
        'id'   => 'logo_b',
        'std'  => ' ',
        'type' => 'text'
    );

    $options[] = array(
        'name' => __('Logo Text C', SAKURA_DOMAIN),
        'desc' => __('Fill in the back of your logo', SAKURA_DOMAIN),
        'id'   => 'logo_c',
        'std'  => ' ',
        'type' => 'text'
    );

    $options[] = array(
        'name' => __('Logo Secondary Text', SAKURA_DOMAIN),
        'desc' => __('Fill in the secondary text of your logo.', SAKURA_DOMAIN),
        'id'   => 'logo_two',
        'std'  => '',
        'type' => 'text'
    );

    $options[] = array(
        'name' => __('Custom Mouse Style - Standard', SAKURA_DOMAIN),
        'desc' => __('Apply to global, fill in link.', SAKURA_DOMAIN),
        'id'   => 'cursor-nor',
        'std'  => 'https://cdn.jsdelivr.net/gh/Fuukei/Public_Repository@latest/vision/cursor/normal.cur',
        'type' => 'text'
    );

    $options[] = array(
        'name' => __('Custom Mouse Style - Selected', SAKURA_DOMAIN),
        'desc' => __('Return to the above for PC', SAKURA_DOMAIN),
        'id'   => 'cursor-no',
        'std'  => 'https://cdn.jsdelivr.net/gh/Fuukei/Public_Repository@latest/vision/cursor/No_Disponible.cur',
        'type' => 'text'
    );

    $options[] = array(
        'name' => __('Custom Mouse Style - Selected Elements', SAKURA_DOMAIN),
        'desc' => __('Used to select a place', SAKURA_DOMAIN),
        'id'   => 'cursor-ayu',
        'std'  => 'https://cdn.jsdelivr.net/gh/Fuukei/Public_Repository@latest/vision/cursor/ayuda.cur',
        'type' => 'text'
    );

    $options[] = array(
        'name' => __('Custom Mouse Style - Selected Text', SAKURA_DOMAIN),
        'desc' => __('Used to select a Text', SAKURA_DOMAIN),
        'id'   => 'cursor-text',
        'std'  => 'https://cdn.jsdelivr.net/gh/Fuukei/Public_Repository@latest/vision/cursor/texto.cur',
        'type' => 'text'
    );

    $options[] = array(
        'name' => __('Custom Mouse Style - Working State', SAKURA_DOMAIN),
        'desc' => __('Used to working condition', SAKURA_DOMAIN),
        'id'   => 'cursor-work',
        'std'  => 'https://cdn.jsdelivr.net/gh/Fuukei/Public_Repository@latest/vision/cursor/work.cur',
        'type' => 'text'
    );

    //字体
    $options[] = array('name' => __('Fonts', SAKURA_DOMAIN), 'type' => 'heading');

    $options[] = array(
        'name'  => __('Fontweight', SAKURA_DOMAIN),
        'desc'  => __('Fill in a number, maximum 900, minimum 100. Between 300 and 500 is recommended.', SAKURA_DOMAIN),
        'id'    => 'fontweight',
        'std'   => '',
        'class' => 'mini',
        'type'  => 'text'
    );

    $options[] = array(
        'name' => __('Reference External Font', SAKURA_DOMAIN),
        'desc' => __('Check open', SAKURA_DOMAIN),
        'id'   => 'refer-ext-font',
        'std'  => '0',
        'type' => 'checkbox'
    );

    $options[] = array(
        'name' => __('External Font Address', SAKURA_DOMAIN),
        'desc' => __('Fill in font address.', SAKURA_DOMAIN),
        'id'   => 'ext-font-address',
        'std'  => '',
        'type' => 'text'
    );

    $options[] = array(
        'name' => __('External Font Name', SAKURA_DOMAIN),
        'desc' => __('Fill in the font name.', SAKURA_DOMAIN),
        'id'   => 'ext-font-name',
        'std'  => '',
        'type' => 'text'
    );

    $options[] = array(
        'name' => __('Google Fonts Api Address', SAKURA_DOMAIN),
        'desc' => __('Fill in Google Fonts API Address', SAKURA_DOMAIN),
        'id'   => 'gfontsapi',
        'std'  => 'fonts.googleapis.com',
        'type' => 'text'
    );

    $options[] = array(
        'name' => __('Google Fonts Name', SAKURA_DOMAIN),
        'desc' => __('Please make sure that the fonts you add can be referenced in Google font library. Fill in the font name. If multiple fonts are referenced, please use "|" as the separator.', SAKURA_DOMAIN),
        'id'   => 'addfonts',
        'std'  => '',
        'type' => 'text'
    );

    $options[] = array(
        'name' => __('Global Default Font', SAKURA_DOMAIN),
        'desc' => __('Fill in font name', SAKURA_DOMAIN),
        'id'   => 'global-default-font',
        'std'  => '',
        'type' => 'text'
    );

    $options[] = array(
        'name' => __('Global Font 2', SAKURA_DOMAIN),
        'desc' => __('Fill in font name', SAKURA_DOMAIN),
        'id'   => 'global-font2',
        'std'  => '',
        'type' => 'text'
    );

    $options[] = array(
        'name' => __('Front Page Title Font', SAKURA_DOMAIN),
        'desc' => __('Fill in font name', SAKURA_DOMAIN),
        'id'   => 'font-title',
        'std'  => '',
        'type' => 'text'
    );

    $options[] = array(
        'name' => __('Front Page One Word Font', SAKURA_DOMAIN),
        'desc' => __('Fill in font name', SAKURA_DOMAIN),
        'id'   => 'font-oneword',
        'std'  => '',
        'type' => 'text'
    );

    $options[] = array(
        'name' => __('Front Page Key Title Font', SAKURA_DOMAIN),
        'desc' => __('Fill in font name', SAKURA_DOMAIN),
        'id'   => 'keytitlefont',
        'std'  => '',
        'type' => 'text'
    );

    $options[] = array(
        'name'  => __('Global Fontsize', SAKURA_DOMAIN),
        'desc'  => __('Fill in Number. Between 10 and 20 is recommended', SAKURA_DOMAIN),
        'id'    => 'global-fontsize',
        'std'   => '',
        'class' => 'mini',
        'type'  => 'text'
    );

    $options[] = array(
        'name'  => __('Article Title Size', SAKURA_DOMAIN),
        'desc'  => __('Fill in Number. Between 15 and 20 is recommended', SAKURA_DOMAIN),
        'id'    => 'article-title-size',
        'std'   => '',
        'class' => 'mini',
        'type'  => 'text'
    );

    $options[] = array(
        'name'  => __('Article Tips Size', SAKURA_DOMAIN),
        'desc'  => __('Fill in Number. Between 10 and 15 is recommended', SAKURA_DOMAIN),
        'id'    => 'article-tips-size',
        'std'   => '',
        'class' => 'mini',
        'type'  => 'text'
    );

    $options[] = array(
        'name'  => __('Front Page One Word FontSize', SAKURA_DOMAIN),
        'desc'  => __('Fill in Number. Between 10 and 20 is recommended', SAKURA_DOMAIN),
        'id'    => 'fontsize-oneword',
        'std'   => '',
        'class' => 'mini',
        'type'  => 'text'
    );

    $options[] = array(
        'name'  => __('Font Size of The First Key Title', SAKURA_DOMAIN),
        'desc'  => __('Fill in Number. Between 70 and 90 is recommended', SAKURA_DOMAIN),
        'id'    => 'keytitle_size',
        'std'   => '80',
        'class' => 'mini',
        'type'  => 'text'
    );

    $options[] = array(
        'name'  => __('Article Page Title Size', SAKURA_DOMAIN),
        'desc'  => __('Fill in Number. Between 25 and 30 is recommended', SAKURA_DOMAIN),
        'id'    => 'article-paget',
        'std'   => '',
        'class' => 'mini',
        'type'  => 'text'
    );

    $options[] = array(
        'name' => __('Logo Font Link', SAKURA_DOMAIN),
        'desc' => __('When the font is ready, do this again <a href="https://www.fontke.com/tool/fontface/">@font-face生成器</a>It can generate a bunch of files, which are all useful. It can be placed on a accessible server, OOS, CDN, etc. here, you only need to fill in the CSS style sheet file link <a href="https://blog.ukenn.top/sakura6/#toc-head-4">Detailed tutorial</a>', SAKURA_DOMAIN),
        'id'   => 'logo_zt',
        'std'  => 'https://cdn.jsdelivr.net/gh/acai66/mydl/fonts/wenyihei/wenyihei-subfont.css',
        'type' => 'text'
    );

    $options[] = array(
        'name' => __('Logo Font Name', SAKURA_DOMAIN),
        'desc' => __('Fill in the font name of your logo, write the name directly without the format suffix', SAKURA_DOMAIN),
        'id'   => 'logo_ztmc',
        'std'  => 'wenyihei-subfont',
        'type' => 'text'
    );

    //主题
    $options[] = array('name' => ll('Theme'), 'type' => 'heading');

    $options[] = array(
        'name'    => ll('Display Icon Selection'),
        'desc'    => ll('Choose icon color'),
        'id'      => 'webweb_img',
        'std'     => 'https://cdn.jsdelivr.net/gh/Fuukei/Public_Repository@latest/vision/theme/sakura',
        'type'    => 'select',
        'options' => array(
            'https://cdn.jsdelivr.net/gh/Fuukei/Public_Repository@latest/vision/theme/sakura'        => __('「Default Color」Sakura（FB98C0+87B6FA）', SAKURA_DOMAIN),
            'https://cdn.jsdelivr.net/gh/Fuukei/Public_Repository@latest/vision/theme/pink'          => __('「Common Colors」Pink（EE9CA7）', SAKURA_DOMAIN),
            'https://cdn.jsdelivr.net/gh/Fuukei/Public_Repository@latest/vision/theme/orange'        => __('「Common Colors」Orange（FF8000）', SAKURA_DOMAIN),
            'https://cdn.jsdelivr.net/gh/Fuukei/Public_Repository@latest/vision/theme/blue'          => __('「Nippon Colors」Hanaasagi（1E88A8）', SAKURA_DOMAIN),
            'https://cdn.jsdelivr.net/gh/Fuukei/Public_Repository@latest/vision/theme/yellow'        => __('「Nippon Colors」Beniukon（E98B2A）', SAKURA_DOMAIN),
            'https://cdn.jsdelivr.net/gh/Fuukei/Public_Repository@latest/vision/theme/sangosyu'      => __('「Nippon Colors」Sangosyu（F17C67）', SAKURA_DOMAIN),
            'https://cdn.jsdelivr.net/gh/Fuukei/Public_Repository@latest/vision/theme/sora'          => __('「Nippon Colors」Sora（58B2DC）', SAKURA_DOMAIN),
            'https://cdn.jsdelivr.net/gh/Fuukei/Public_Repository@latest/vision/theme/nae'           => __('「Nippon Colors」Nae（86C166）', SAKURA_DOMAIN),
            'https://cdn.jsdelivr.net/gh/Fuukei/Public_Repository@latest/vision/theme/macaronblue'   => __('「Macaron Colors」Blue（B8F1ED）', SAKURA_DOMAIN),
            'https://cdn.jsdelivr.net/gh/Fuukei/Public_Repository@latest/vision/theme/macarongreen'  => __('「Macaron Colors」Green（B8F1CC）', SAKURA_DOMAIN),
            'https://cdn.jsdelivr.net/gh/Fuukei/Public_Repository@latest/vision/theme/macaronpurple' => __('「Macaron Colors」Purple（D9B8F1）', SAKURA_DOMAIN),
            'https://cdn.jsdelivr.net/gh/Fuukei/Public_Repository@latest/vision/theme/colorful'      => __('「Others」ColorFul', SAKURA_DOMAIN),
        )
    );

    $options[] = array(
        'name' => ll('Theme Color'),
        'id'   => 'theme_skin',
        'std'  => "#FB98C0",
        'desc' => ll('Custom theme color'),
        'type' => "color",
    );

    $options[] = array(
        'name' => ll('Theme Color Matching Color'),
        'id'   => 'theme_skinm',
        'std'  => "#87B6FA",
        'desc' => ll('Custom theme color'),
        'type' => "color",
    );

    $options[] = array(
        'name'    => __('Theme Light Color Management', SAKURA_DOMAIN),
        'id'      => 'light-cmanage',
        'std'     => "sep",
        'type'    => "radio",
        'options' => array(
            'mer' => __('Merge Options', SAKURA_DOMAIN),
            'sep' => __('Separation Options', SAKURA_DOMAIN),
        )
    );

    $options[] = array(
        'name' => __('Theme Color (Light)', SAKURA_DOMAIN),
        'id'   => 'light-color',
        'std'  => "#FFE1ED",
        'desc' => __('Custom theme color', SAKURA_DOMAIN),
        'type' => "color",
    );

    $options[] = array(
        'name' => __('Theme Color (Dark mode)', SAKURA_DOMAIN),
        'id'   => 'theme_dark',
        'std'  => "#BD144A",
        'desc' => __('Custom theme color', SAKURA_DOMAIN),
        'type' => "color",
    );

    $options[] = array(
        'name' => __('Automatic Switching Dark Mode (22:00-7:00)', SAKURA_DOMAIN),
        'desc' => __('Check open', SAKURA_DOMAIN),
        'id'   => 'dark_mode',
        'std'  => '1',
        'type' => 'checkbox'
    );

    $options[] = array(
        'name'  => __('Image Brightness in Dark Mode', SAKURA_DOMAIN),
        'desc'  => __('Fill in Number', SAKURA_DOMAIN),
        'id'    => 'dark_imgbri',
        'std'   => '0.8',
        'class' => 'mini',
        'type'  => 'text'
    );

    $options[] = array(
        'name'  => __('Dark Mode Widget Transparency', SAKURA_DOMAIN),
        'id'    => 'dark-widget-tmd',
        'std'   => "0.7",
        'desc'  => __('Fill in the alpha value from 0 to 1 here', SAKURA_DOMAIN),
        'type'  => "text",
        'class' => 'mini',
    );

    $options[] = array(
        'name'  => __('Information Bar Background Color (RGBA) Red', SAKURA_DOMAIN),
        'id'    => 'info-bar-bg-cr',
        'std'   => "255",
        'desc'  => __('Fill in the red value from 0 to 255 here', SAKURA_DOMAIN),
        'type'  => "text",
        'class' => 'mini',
    );

    $options[] = array(
        'name'  => __('Information Bar Background Color (RGBA) Green', SAKURA_DOMAIN),
        'id'    => 'info-bar-bg-cg',
        'std'   => "255",
        'desc'  => __('Fill in the green value from 0 to 255 here', SAKURA_DOMAIN),
        'type'  => "text",
        'class' => 'mini',
    );

    $options[] = array(
        'name'  => __('Information Bar Background Color (RGBA) Blue', SAKURA_DOMAIN),
        'id'    => 'info-bar-bg-cb',
        'std'   => "255",
        'desc'  => __('Fill in the blue value from 0 to 255 here', SAKURA_DOMAIN),
        'type'  => "text",
        'class' => 'mini',
    );

    $options[] = array(
        'name'  => __('Information Bar Background Color (RGBA) Alpha', SAKURA_DOMAIN),
        'id'    => 'info-bar-bg-ca',
        'std'   => "0.8",
        'desc'  => __('Fill in the alpha value from 0 to 1 here', SAKURA_DOMAIN),
        'type'  => "text",
        'class' => 'mini',
    );

    $options[] = array(
        'name'  => __('Foreground Menu background Color (RGBA) Red', SAKURA_DOMAIN),
        'id'    => 'fore-switch-bcr',
        'std'   => "255",
        'desc'  => __('Fill in the red value from 0 to 255 here', SAKURA_DOMAIN),
        'type'  => "text",
        'class' => 'mini',
    );

    $options[] = array(
        'name'  => __('Foreground Menu background Color (RGBA) Green', SAKURA_DOMAIN),
        'id'    => 'fore-switch-bcg',
        'std'   => "255",
        'desc'  => __('Fill in the green value from 0 to 255 here', SAKURA_DOMAIN),
        'type'  => "text",
        'class' => 'mini',
    );

    $options[] = array(
        'name'  => __('Foreground Menu background Color (RGBA) Blue', SAKURA_DOMAIN),
        'id'    => 'fore-switch-bcb',
        'std'   => "255",
        'desc'  => __('Fill in the blue value from 0 to 255 here', SAKURA_DOMAIN),
        'type'  => "text",
        'class' => 'mini',
    );

    $options[] = array(
        'name'  => __('Foreground Menu background Color (RGBA) Alpha', SAKURA_DOMAIN),
        'id'    => 'fore-switch-bca',
        'std'   => "0.8",
        'desc'  => __('Fill in the alpha value from 0 to 1 here', SAKURA_DOMAIN),
        'type'  => "text",
        'class' => 'mini',
    );

    $options[] = array(
        'name' => __('Foreground Selection Menu Background Color (Light colors are recommended)', SAKURA_DOMAIN),
        'id'   => 'fore-switch-sele-bc',
        'std'  => "#FFE1ED",
        'desc' => __('Custom colors', SAKURA_DOMAIN),
        'type' => "color",
    );

    $options[] = array(
        'name' => __('Home Page Article Separator (Light colors are recommended)', SAKURA_DOMAIN),
        'id'   => 'hpage-art-sc',
        'std'  => "#FFE1ED",
        'desc' => __('Custom colors', SAKURA_DOMAIN),
        'type' => "color",
    );

    $options[] = array(
        'name' => __('Home Page Article Time Prompt Emphasize Background (Light colors are recommended)', SAKURA_DOMAIN),
        'id'   => 'hpage-art-tpebc',
        'std'  => "#FFE1ED",
        'desc' => __('Custom colors', SAKURA_DOMAIN),
        'type' => "color",
    );

    $options[] = array(
        'name' => __('Home Page Article Border Shadow (Light colors are recommended)', SAKURA_DOMAIN),
        'id'   => 'hpage-art-bsc',
        'std'  => "#FFE1ED",
        'desc' => __('Custom colors', SAKURA_DOMAIN),
        'type' => "color",
    );

    $options[] = array(
        'name' => __('Drop Down Arrow Color (Light colors are recommended)', SAKURA_DOMAIN),
        'id'   => 'godown_skin',
        'std'  => "#FFF",
        'desc' => __('Custom colors', SAKURA_DOMAIN),
        'type' => "color",
    );

    $options[] = array(
        'name' => ll('Home Page Article Time Prompt Accent (Theme colors are recommended)'),
        'id'   => 'hpage-art-tpac',
        'std'  => "#FB98C0",
        'desc' => ll('Custom colors'),
        'type' => "color",
    );

    $options[] = array(
        'name' => ll('Home Page Article Prompt Icon Color (Theme colors are recommended)'),
        'id'   => 'hpage-art-pic',
        'std'  => "#FB98C0",
        'desc' => ll('Custom colors'),
        'type' => "color",
    );

    $options[] = array(
        'name'  => __('Home Page Focus Background Color (RGBA) Red', SAKURA_DOMAIN),
        'id'    => 'hpage-focus-bcr',
        'std'   => "255",
        'desc'  => __('Fill in the red value from 0 to 255 here', SAKURA_DOMAIN),
        'type'  => "text",
        'class' => 'mini',
    );

    $options[] = array(
        'name'  => __('Home Page Focus Background Color (RGBA) Green', SAKURA_DOMAIN),
        'id'    => 'hpage-focus-bcg',
        'std'   => "225",
        'desc'  => __('Fill in the green value from 0 to 255 here', SAKURA_DOMAIN),
        'type'  => "text",
        'class' => 'mini',
    );

    $options[] = array(
        'name'  => __('Home Page Focus Background Color (RGBA) Blue', SAKURA_DOMAIN),
        'id'    => 'hpage-focus-bcb',
        'std'   => "237",
        'desc'  => __('Fill in the blue value from 0 to 255 here', SAKURA_DOMAIN),
        'type'  => "text",
        'class' => 'mini',
    );

    $options[] = array(
        'name'  => __('Home Page Focus Background Color (RGBA) Alpha', SAKURA_DOMAIN),
        'id'    => 'hpage-focus-bca',
        'std'   => "0.7",
        'desc'  => __('Fill in the alpha value from 0 to 1 here', SAKURA_DOMAIN),
        'type'  => "text",
        'class' => 'mini',
    );

    $options[] = array(
        'name' => __('Home Page Key Title Font Color', SAKURA_DOMAIN),
        'id'   => 'hpage-ket-tfc',
        'std'  => "#FFF",
        'desc' => __('Custom theme color', SAKURA_DOMAIN),
        'type' => "color",
    );

    $options[] = array(
        'name' => __('Preload Animation Color A', SAKURA_DOMAIN),
        'id'   => 'preload-ani-c1',
        'std'  => "#FFE1ED",
        'desc' => __('Custom colors', SAKURA_DOMAIN),
        'type' => "color",
    );

    $options[] = array(
        'name' => __('Preload Animation Color B', SAKURA_DOMAIN),
        'id'   => 'preload-ani-c2',
        'std'  => "#FB98C0",
        'desc' => __('Custom colors', SAKURA_DOMAIN),
        'type' => "color",
    );

    $options[] = array(
        'name' => __('Backstage Main Color (Primary menu)', SAKURA_DOMAIN),
        'id'   => 'admin_mcp',
        'std'  => "#99B8FC",
        'desc' => __('Custom color', SAKURA_DOMAIN),
        'type' => "color",
    );

    $options[] = array(
        'name' => __('Backstage Main Color (Secondary menu)', SAKURA_DOMAIN),
        'id'   => 'admin_mcs',
        'std'  => "#85ABFC",
        'desc' => __('Custom color', SAKURA_DOMAIN),
        'type' => "color",
    );

    $options[] = array(
        'name' => __('Backstage Accent Color (For Example, The Prompt Color is Included in This Option)', SAKURA_DOMAIN),
        'id'   => 'admin_acc',
        'std'  => "#F181A2",
        'desc' => __('Custom color', SAKURA_DOMAIN),
        'type' => "color",
    );

    $options[] = array(
        'name' => __('Backstage Button Color', SAKURA_DOMAIN),
        'id'   => 'admin_pb_skin',
        'std'  => "#85ABFC",
        'desc' => __('Custom color', SAKURA_DOMAIN),
        'type' => "color",
    );

    $options[] = array(
        'name' => __('Backstage Font Color', SAKURA_DOMAIN),
        'id'   => 'admin_font_skin',
        'std'  => "#FFF",
        'desc' => __('Custom color', SAKURA_DOMAIN),
        'type' => "color",
    );

    return $options;
}
