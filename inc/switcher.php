<?php

function get_frontend_js_control() {
    $asakura_option = array(
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
        'skin_bg0'                => akina_option('sakura_skin_bg1') ?: "none",
        'skin_bg1'                => akina_option('sakura_skin_bg2') ?: "https://cdn.jsdelivr.net/gh/Fuukei/Public_Repository@latest/vision/background/foreground/bg1.png",
        'skin_bg2'                => akina_option('sakura_skin_bg3') ?: "https://cdn.jsdelivr.net/gh/Fuukei/Public_Repository@latest/vision/background/foreground/bg2.png",
        'skin_bg3'                => akina_option('sakura_skin_bg4') ?: "https://cdn.jsdelivr.net/gh/Fuukei/Public_Repository@latest/vision/background/foreground/bg3.png",
        'skin_bg4'                => akina_option('sakura_skin_bg5') ?: "https://cdn.jsdelivr.net/gh/Fuukei/Public_Repository@latest/vision/background/foreground/bg4.png",
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
        'window_height'           => 'auto',
    );
    return json_encode($asakura_option);
}

function frontend_js_control() { ?>
    <script>
        /*Initial Variables*/
        const mashiro_option = {};
        mashiro_option.NProgressON = <?= akina_option('nprogress_on') ? 'true' : 'false'; ?>;
        mashiro_option.audio = <?= akina_option('audio') ? 'true' : 'false'; ?>;
        mashiro_option.darkmode = <?= akina_option('darkmode') ? 'true' : 'false'; ?>;
        mashiro_option.email_domain = "<?php echo akina_option('email_domain', ''); ?>";
        mashiro_option.email_name = "<?php echo akina_option('email_name', ''); ?>";
        mashiro_option.cookie_version_control = "<?php echo akina_option('cookie_version', ''); ?>";
        mashiro_option.qzone_autocomplete = false;
        mashiro_option.site_name = "<?php echo akina_option('site_name', ''); ?>";
        mashiro_option.author_name = "<?php echo akina_option('author_name', ''); ?>";
        mashiro_option.template_url = "<?php echo get_template_directory_uri(); ?>";
        mashiro_option.site_url = "<?php echo site_url(); ?>";
        mashiro_option.qq_api_url = "<?php echo asakura_rest_url('qqinfo/json'); ?>";
        mashiro_option.live_search = <?= akina_option('live_search') ? 'true' : 'false'; ?>;

        <?php if( akina_option('sakura_skin_bg1')){ $bg_arry = explode(",", akina_option('sakura_skin_bg1'));?>
        mashiro_option.skin_bg0 = "<?php echo $bg_arry[0] ?>";
        <?php }else {?>
        mashiro_option.skin_bg0 = "none";
        <?php } ?>

        <?php if( akina_option('sakura_skin_bg2')){ $bg_arry = explode(",", akina_option('sakura_skin_bg2'));?>
        mashiro_option.skin_bg1 = "<?php echo $bg_arry[0] ?>";
        <?php }else {?>
        mashiro_option.skin_bg1 = "https://cdn.jsdelivr.net/gh/Fuukei/Public_Repository@latest/vision/background/foreground/bg1.png";
        <?php } ?>

        <?php if( akina_option('sakura_skin_bg3')){ $bg_arry = explode(",", akina_option('sakura_skin_bg3'));?>
        mashiro_option.skin_bg2 = "<?php echo $bg_arry[0] ?>";
        <?php }else {?>
        mashiro_option.skin_bg2 = "https://cdn.jsdelivr.net/gh/Fuukei/Public_Repository@latest/vision/background/foreground/bg2.png";
        <?php } ?>

        <?php if( akina_option('sakura_skin_bg4')){ $bg_arry = explode(",", akina_option('sakura_skin_bg4'));?>
        mashiro_option.skin_bg3 = "<?php echo $bg_arry[0] ?>";
        <?php }else {?>
        mashiro_option.skin_bg3 = "https://cdn.jsdelivr.net/gh/Fuukei/Public_Repository@latest/vision/background/foreground/bg3.png";
        <?php } ?>

        <?php if( akina_option('sakura_skin_bg5')){ $bg_arry = explode(",", akina_option('sakura_skin_bg5'));?>
        mashiro_option.skin_bg4 = "<?php echo $bg_arry[0] ?>";
        <?php }else {?>
        mashiro_option.skin_bg4 = "https://cdn.jsdelivr.net/gh/Fuukei/Public_Repository@latest/vision/background/foreground/bg4.png";
        <?php } ?>

        <?php if( is_home() ){ ?>
        mashiro_option.land_at_home = true;
        <?php }else {?>
        mashiro_option.land_at_home = false;
        <?php } ?>

        <?php if(akina_option('image_viewer') == 0){ ?>
        mashiro_option.baguetteBoxON = false;
        <?php }else {?>
        mashiro_option.baguetteBoxON = true;
        <?php } ?>

        <?php if(akina_option('clipboard_copyright') == 0){ ?>
        mashiro_option.clipboardCopyright = false;
        <?php }else {?>
        mashiro_option.clipboardCopyright = true;
        <?php } ?>

        <?php if(akina_option('entry_content_theme') == SAKURA_DOMAIN){ ?>
        mashiro_option.entry_content_theme_src = "<?php echo get_template_directory_uri() ?>/cdn/theme/sakura.css?<?php echo SAKURA_VERSION . akina_option('cookie_version', ''); ?>";
        <?php }elseif(akina_option('entry_content_theme') == "github") {?>
        mashiro_option.entry_content_theme_src = "<?php echo get_template_directory_uri() ?>/cdn/theme/github.css?<?php echo SAKURA_VERSION . akina_option('cookie_version', ''); ?>";
        <?php } ?>
        mashiro_option.entry_content_theme = "<?php echo akina_option('entry_content_theme'); ?>";

        <?php if(akina_option('jsdelivr_cdn_test')){ ?>
        mashiro_option.jsdelivr_css_src = "<?php echo get_template_directory_uri() ?>/cdn/css/lib.css?<?php echo SAKURA_VERSION . akina_option('cookie_version', ''); ?>";
        <?php } else { ?>
        mashiro_option.jsdelivr_css_src = "https://cdn.jsdelivr.net/gh/Yesterday17/Asakura@<?php echo SAKURA_VERSION; ?>/cdn/css/lib.min.css";
        <?php } ?>
        <?php if (akina_option('aplayer_server') != 'off'): ?>
        mashiro_option.float_player_on = true;
        mashiro_option.meting_api_url = "<?php echo asakura_rest_url('meting/aplayer'); ?>";
        <?php endif; ?>

        mashiro_option.cover_api = "<?php echo asakura_rest_url('image/cover'); ?>";
        <?php if(akina_option('cover_beta')){?>
        mashiro_option.cover_beta = true;
        <?php }else {?>
        mashiro_option.cover_beta = false;
        <?php } ?>
        mashiro_option.windowheight = 'auto';
        /*End of Initial Variables*/
    </script>
<?php }

add_action('wp_head', 'frontend_js_control');
