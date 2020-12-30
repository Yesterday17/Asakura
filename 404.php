<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Akina
 */

?>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title itemprop="name"><?php global $page, $paged;
        wp_title('-', true, 'right');
        bloginfo('name');
        $site_description = get_bloginfo('description', 'display');
        if ($site_description && (is_home() || is_front_page()))
            echo " - $site_description";
        if ($paged >= 2 || $page >= 2)
            echo ' - ' . sprintf(ll('page %s'), max($paged, $page));/*第 %s 页*/ ?>
    </title>
    <?php wp_head(); ?>
    <style>
        .error-img {
            text-align: center;
            height: 66%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12em;
        }

        #not-found-go-home {
            color: white;
        }
    </style>
</head>
<body <?php body_class(); ?>>
<section class="error-404 not-found">
    <div class="error-img">
        <h1>?</h1>
    </div>
    <div class="err-button back">
        <a href=javascript:history.go(-1);><?php ee('return to previous page');/*返回上一页*/ ?></a>
        <a id="not-found-go-home" href="<?php bloginfo('url'); ?>"><?php ee('return to home page');/*返回主页*/ ?></a>
    </div>
    <div style="display:block; width:284px;margin: auto;">
        <p style="margin-bottom: 1em;margin-top: 1.5em;text-align: center;font-size: 15px;"><?php ee('Don\'t worry, search in site?');/*别急，试试站内搜索？*/ ?></p>
        <form class="s-search" method="get" action="/" role="search">
            <i class="iconfont icon-search" style="bottom: 9px;left: 15px;"></i>
            <input class="text-input" style="padding: 8px 20px 8px 46px;" type="search" name="s"
                   placeholder="<?php ee('Search...') ?>" required>
        </form>
    </div>
</section>
</body>
