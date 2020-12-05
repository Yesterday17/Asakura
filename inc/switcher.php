<?php

function get_asakura_option(): array {
    return array(
        // mashiro_option
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
        'skin_bg'                 => akina_option('sakura_skin_bg') ?: "none",
        'land_at_home'            => is_home(),
        'clipboard_copyright'     => akina_option('clipboard_copyright') == 0,
        'entry_content_theme'     => akina_option('entry_content_theme'),
        'entry_content_theme_src' => get_template_directory_uri() . '/cdn/theme/' . akina_option('entry_content_theme') . '.css?' . SAKURA_VERSION . akina_option('cookie_version', ''),
        'float_player_on'         => True,
        'meting_api_url'          => asakura_rest_url('meting/aplayer'),
        'cover_api'               => asakura_rest_url('image/cover'),
        'cover_beta'              => (bool)akina_option('cover_beta'),
        // Poi
        'pjax'                    => (bool)akina_option('poi_pjax'),
        'movies'                  => akina_option('focus_amv') ? array(
            'url'  => akina_option('amv_url'),
            'name' => akina_option('amv_title'),
            'live' => akina_option('focus_mvlive') ? 'open' : 'close',
        ) : 'close',
        'window_height'           => akina_option('focus_height') ? 'fixed' : 'auto',
        'code_lamp'               => 'close',
        'ajax_url'                => admin_url('admin-ajax.php'),
        'comment_order'           => get_option('comment_order'),
        'form_position'           => 'bottom', // ajax comments 默认为bottom，如果你的表单在顶部则设置为top
        'api'                     => esc_url_raw(rest_url()),
        'nonce'                   => wp_create_nonce('wp_rest'),
        'google_analytics_id'     => akina_option('google_analytics_id', ''),
        'gravatar_url'            => akina_option('gravatar_proxy') ?: 'secure.gravatar.com/avatar',
        // Asakura
        'instantclick'            => True,
    );
}
