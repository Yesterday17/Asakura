<?php

function get_asakura_option() {
    return array(
        'nprogress_on'            => (bool)akina_option('nprogress_on'),
        'audio'                   => (bool)akina_option('audio'),
        'dark_mode'               => (bool)akina_option('dark_mode'),
        'email_domain'            => akina_option('email_domain', ''),
        'email_name'              => akina_option('email_name', ''),
        'cookie_version_control'  => akina_option('cookie_version', ''),
        'qzone_autocomplete'      => False,
        'site_name'               => akina_option('site_name', ''),
        'author_name'             => akina_option('author_name', ''),
        'template_url'            => get_template_directory_uri(),
        'site_url'                => site_url(),
        'qq_api_url'              => asakura_rest_url('qqinfo/json'),
        'live_search'             => (bool)akina_option('live_search'),
        'skin_bg'                => akina_option('sakura_skin_bg') ?: "none",
        'land_at_home'            => is_home(),
        'baguette_box_on'         => akina_option('image_viewer') == 0,
        'clipboard_copyright'     => akina_option('clipboard_copyright') == 0,
        'entry_content_theme'     => akina_option('entry_content_theme'),
        'entry_content_theme_src' => get_template_directory_uri() . '/cdn/theme/' . akina_option('entry_content_theme') . '.css?' . SAKURA_VERSION . akina_option('cookie_version', ''),
        'jsdelivr_css_src'        => akina_option('jsdelivr_cdn_test') ? get_template_directory_uri() . '/cdn/css/lib.css?' . SAKURA_VERSION . akina_option('cookie_version', '') : 'https://cdn.jsdelivr.net/gh/Yesterday17/Asakura@' . SAKURA_VERSION . '/cdn/css/lib.min.css',
        'float_player_on'         => True,
        'meting_api_url'          => asakura_rest_url('meting/aplayer'),
        'cover_api'               => asakura_rest_url('image/cover'),
        'cover_beta'              => (bool)akina_option('cover_beta'),
    );
}
