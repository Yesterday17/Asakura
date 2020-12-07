<?php
/*
 * /wp-content/themes/Sakura/inc/dash-scheme.php?color_1=&color_2=&color_3=&color_4=
 */

header("Content-type: text/css; charset: UTF-8");
#header('Access-Control-Allow-Origin: *');

function _get($str, $default, $prefix = '') {
    $val = !empty($_GET[$str]) ? $_GET[$str] : $default;
    if (gettype($val) === 'string' && strpos($val, $prefix) !== 0) {
        $val = $prefix . $val;
    }
    return $val;
}

$color_1 = _get('color_1', '#85ABFC', '#');
$color_2 = _get('color_2', '#99B8FC', '#');
$color_3 = _get('color_3', '#F181A2', '#');
$color_4 = _get('color_4', '#F181A2', '#');
$rules = urldecode(_get('rules', ''));

?>

/*! This file is auto-generated */
body{background:#f1f1f1}a{color:#0073aa}a:active,a:focus,a:hover{color:#0096dd}#media-upload a.del-link:hover,.subsubsub a.current:hover,.subsubsub a:hover,div.dashboard-widget-submit input:hover{color:#0096dd}input[type=checkbox]:checked:before{color:<?php echo $color_2; ?>;width: 1.3125rem;}input[type=radio]:checked:before{background:<?php echo $color_2; ?>;margin: .1875rem;}.wp-core-ui input[type=reset]:active,.wp-core-ui input[type=reset]:hover{color:#0096dd}.wp-core-ui .button-primary{background:<?php echo $color_3; ?>;border-color:#b78b66 #ae7d55 #ae7d55;color:#fff;box-shadow:0 1px 0 #ae7d55;text-shadow:0 -1px 1px #ae7d55,1px 0 1px #ae7d55,0 1px 1px #ae7d55,-1px 0 1px #ae7d55}.wp-core-ui .button-primary:focus,.wp-core-ui .button-primary:hover{background:#ccad93;border-color:#ae7d55;color:#fff;box-shadow:0 1px 0 #ae7d55}.wp-core-ui .button-primary:focus{box-shadow:inset 0 1px 0 #b78b66,0 0 2px 1px #33b3db}.wp-core-ui .button-primary.active,.wp-core-ui .button-primary.active:focus,.wp-core-ui .button-primary.active:hover,.wp-core-ui .button-primary:active{background:#b78b66;border-color:#ae7d55;box-shadow:inset 0 2px 0 #ae7d55}.wp-core-ui .button-primary.button-primary-disabled,.wp-core-ui .button-primary.disabled,.wp-core-ui .button-primary:disabled,.wp-core-ui .button-primary[disabled]{color:#d1ccc7!important;background:#ba906d!important;border-color:#ae7d55!important;text-shadow:none!important}.wp-core-ui .button-primary.button-hero{box-shadow:0 2px 0 #ae7d55!important}.wp-core-ui .button-primary.button-hero:active{box-shadow:inset 0 3px 0 #ae7d55!important}.wp-core-ui .wp-ui-primary{color:#fff;background-color:<?php echo $color_2; ?>}.wp-core-ui .wp-ui-text-primary{color:<?php echo $color_2; ?>}.wp-core-ui .wp-ui-highlight{color:#fff;background-color:<?php echo $color_3; ?>}.wp-core-ui .wp-ui-text-highlight{color:<?php echo $color_3; ?>}.wp-core-ui .wp-ui-notification{color:#fff;background-color:<?php echo $color_4; ?>}.wp-core-ui .wp-ui-text-notification{color:<?php echo $color_4; ?>}.wp-core-ui .wp-ui-text-icon{color:#f3f2f1}.wrap .add-new-h2:hover,.wrap .page-title-action:hover{color:#fff;background-color:<?php echo $color_2; ?>}.view-switch a.current:before{color:<?php echo $color_2; ?>}.view-switch a:hover:before{color:<?php echo $color_4; ?>}#adminmenu,#adminmenuback,#adminmenuwrap{background:<?php echo $color_2; ?>}#adminmenu a{color:#fff}#adminmenu div.wp-menu-image:before{color:#f3f2f1}#adminmenu a:hover,#adminmenu li.menu-top:hover,#adminmenu li.opensub>a.menu-top,#adminmenu li>a.menu-top:focus{color:#fff;background-color:<?php echo $color_3; ?>}#adminmenu li.menu-top:hover div.wp-menu-image:before,#adminmenu li.opensub>a.menu-top div.wp-menu-image:before{color:#fff}.about-wrap .nav-tab-active,.nav-tab-active,.nav-tab-active:hover{background-color:#f1f1f1;border-bottom-color:#f1f1f1}#adminmenu .wp-has-current-submenu .wp-submenu,#adminmenu .wp-has-current-submenu.opensub .wp-submenu,#adminmenu .wp-submenu,#adminmenu a.wp-has-current-submenu:focus+.wp-submenu,.folded #adminmenu .wp-has-current-submenu .wp-submenu{background:<?php echo $color_1; ?>}#adminmenu li.wp-has-submenu.wp-not-current-submenu.opensub:hover:after{border-right-color:<?php echo $color_1; ?>}#adminmenu .wp-submenu .wp-submenu-head{color:#FFF}#adminmenu .wp-has-current-submenu .wp-submenu a,#adminmenu .wp-has-current-submenu.opensub .wp-submenu a,#adminmenu .wp-submenu a,#adminmenu a.wp-has-current-submenu:focus+.wp-submenu a,.folded #adminmenu .wp-has-current-submenu .wp-submenu a{color:#FFF}#adminmenu .wp-has-current-submenu .wp-submenu a:focus,#adminmenu .wp-has-current-submenu .wp-submenu a:hover,#adminmenu .wp-has-current-submenu.opensub .wp-submenu a:focus,#adminmenu .wp-has-current-submenu.opensub .wp-submenu a:hover,#adminmenu .wp-submenu a:focus,#adminmenu .wp-submenu a:hover,#adminmenu a.wp-has-current-submenu:focus+.wp-submenu a:focus,#adminmenu a.wp-has-current-submenu:focus+.wp-submenu a:hover,.folded #adminmenu .wp-has-current-submenu .wp-submenu a:focus,.folded #adminmenu .wp-has-current-submenu .wp-submenu a:hover{color:<?php echo $color_3; ?>}#adminmenu .wp-has-current-submenu.opensub .wp-submenu li.current a,#adminmenu .wp-submenu li.current a,#adminmenu a.wp-has-current-submenu:focus+.wp-submenu li.current a{color:#fff}#adminmenu .wp-has-current-submenu.opensub .wp-submenu li.current a:focus,#adminmenu .wp-has-current-submenu.opensub .wp-submenu li.current a:hover,#adminmenu .wp-submenu li.current a:focus,#adminmenu .wp-submenu li.current a:hover,#adminmenu a.wp-has-current-submenu:focus+.wp-submenu li.current a:focus,#adminmenu a.wp-has-current-submenu:focus+.wp-submenu li.current a:hover{color:<?php echo $color_3; ?>}ul#adminmenu a.wp-has-current-submenu:after,ul#adminmenu>li.current>a.current:after{border-right-color:#f1f1f1}#adminmenu li.current a.menu-top,#adminmenu li.wp-has-current-submenu .wp-submenu .wp-submenu-head,#adminmenu li.wp-has-current-submenu a.wp-has-current-submenu,.folded #adminmenu li.current.menu-top{color:#fff;background:<?php echo $color_3; ?>}#adminmenu a.current:hover div.wp-menu-image:before,#adminmenu li a:focus div.wp-menu-image:before,#adminmenu li.opensub div.wp-menu-image:before,#adminmenu li.wp-has-current-submenu a:focus div.wp-menu-image:before,#adminmenu li.wp-has-current-submenu div.wp-menu-image:before,#adminmenu li.wp-has-current-submenu.opensub div.wp-menu-image:before,#adminmenu li:hover div.wp-menu-image:before,.ie8 #adminmenu li.opensub div.wp-menu-image:before{color:#fff}#adminmenu .awaiting-mod,#adminmenu .update-plugins{color:#fff;background:<?php echo $color_4; ?>}#adminmenu li a.wp-has-current-submenu .update-plugins,#adminmenu li.current a .awaiting-mod,#adminmenu li.menu-top:hover>a .update-plugins,#adminmenu li:hover a .awaiting-mod{color:#fff;background:<?php echo $color_1; ?>}#collapse-button{color:#f3f2f1}#collapse-button:focus,#collapse-button:hover{color:<?php echo $color_3; ?>}#wpadminbar{color:#fff;background:<?php echo $color_2; ?>}#wpadminbar .ab-item,#wpadminbar a.ab-item,#wpadminbar>#wp-toolbar span.ab-label,#wpadminbar>#wp-toolbar span.noticon{color:#fff}#wpadminbar .ab-icon,#wpadminbar .ab-icon:before,#wpadminbar .ab-item:after,#wpadminbar .ab-item:before{color:#f3f2f1}#wpadminbar .ab-top-menu>li.menupop.hover>.ab-item,#wpadminbar.nojq .quicklinks .ab-top-menu>li>.ab-item:focus,#wpadminbar.nojs .ab-top-menu>li.menupop:hover>.ab-item,#wpadminbar:not(.mobile) .ab-top-menu>li:hover>.ab-item,#wpadminbar:not(.mobile) .ab-top-menu>li>.ab-item:focus{color:<?php echo $color_3; ?>;background:<?php echo $color_1; ?>}#wpadminbar:not(.mobile)>#wp-toolbar a:focus span.ab-label,#wpadminbar:not(.mobile)>#wp-toolbar li.hover span.ab-label,#wpadminbar:not(.mobile)>#wp-toolbar li:hover span.ab-label{color:<?php echo $color_3; ?>}#wpadminbar:not(.mobile) li:hover #adminbarsearch:before,#wpadminbar:not(.mobile) li:hover .ab-icon:before,#wpadminbar:not(.mobile) li:hover .ab-item:after,#wpadminbar:not(.mobile) li:hover .ab-item:before{color:#fff}#wpadminbar .menupop .ab-sub-wrapper{background:<?php echo $color_1; ?>}#wpadminbar .quicklinks .menupop ul.ab-sub-secondary,#wpadminbar .quicklinks .menupop ul.ab-sub-secondary .ab-submenu{background:#656463}#wpadminbar .ab-submenu .ab-item,#wpadminbar .quicklinks .menupop ul li a,#wpadminbar .quicklinks .menupop.hover ul li a,#wpadminbar.nojs .quicklinks .menupop:hover ul li a{color:#FFF}#wpadminbar .menupop .menupop>.ab-item:before,#wpadminbar .quicklinks li .blavatar{color:#f3f2f1}#wpadminbar .quicklinks .ab-sub-wrapper .menupop.hover>a,#wpadminbar .quicklinks .menupop ul li a:focus,#wpadminbar .quicklinks .menupop ul li a:focus strong,#wpadminbar .quicklinks .menupop ul li a:hover,#wpadminbar .quicklinks .menupop ul li a:hover strong,#wpadminbar .quicklinks .menupop.hover ul li a:focus,#wpadminbar .quicklinks .menupop.hover ul li a:hover,#wpadminbar li #adminbarsearch.adminbar-focused:before,#wpadminbar li .ab-item:focus .ab-icon:before,#wpadminbar li .ab-item:focus:before,#wpadminbar li a:focus .ab-icon:before,#wpadminbar li.hover .ab-icon:before,#wpadminbar li.hover .ab-item:before,#wpadminbar li:hover #adminbarsearch:before,#wpadminbar li:hover .ab-icon:before,#wpadminbar li:hover .ab-item:before,#wpadminbar.nojs .quicklinks .menupop:hover ul li a:focus,#wpadminbar.nojs .quicklinks .menupop:hover ul li a:hover{color:<?php echo $color_3; ?>}#wpadminbar .menupop .menupop>.ab-item:hover:before,#wpadminbar .quicklinks .ab-sub-wrapper .menupop.hover>a .blavatar,#wpadminbar .quicklinks li a:focus .blavatar,#wpadminbar .quicklinks li a:hover .blavatar,#wpadminbar.mobile .quicklinks .ab-icon:before,#wpadminbar.mobile .quicklinks .ab-item:before{color:<?php echo $color_3; ?>}#wpadminbar.mobile .quicklinks .hover .ab-icon:before,#wpadminbar.mobile .quicklinks .hover .ab-item:before{color:#f3f2f1}#wpadminbar #adminbarsearch:before{color:#f3f2f1}#wpadminbar>#wp-toolbar>#wp-admin-bar-top-secondary>#wp-admin-bar-search #adminbarsearch input.adminbar-input:focus{color:#fff;background:#6c645c}#wpadminbar #wp-admin-bar-recovery-mode{color:#fff;background-color:<?php echo $color_4; ?>}#wpadminbar #wp-admin-bar-recovery-mode .ab-item,#wpadminbar #wp-admin-bar-recovery-mode a.ab-item{color:#fff}#wpadminbar .ab-top-menu>#wp-admin-bar-recovery-mode.hover>.ab-item,#wpadminbar.nojq .quicklinks .ab-top-menu>#wp-admin-bar-recovery-mode>.ab-item:focus,#wpadminbar:not(.mobile) .ab-top-menu>#wp-admin-bar-recovery-mode:hover>.ab-item,#wpadminbar:not(.mobile) .ab-top-menu>#wp-admin-bar-recovery-mode>.ab-item:focus{color:#fff;background-color:#8e946a}#wpadminbar .quicklinks li#wp-admin-bar-my-account.with-avatar>a img{border-color:#6c645c;background-color:#6c645c}#wpadminbar #wp-admin-bar-user-info .display-name{color:#fff}#wpadminbar #wp-admin-bar-user-info a:hover .display-name{color:<?php echo $color_3; ?>}#wpadminbar #wp-admin-bar-user-info .username{color:#FFF}.wp-pointer .wp-pointer-content h3{background-color:<?php echo $color_3; ?>;border-color:#bf9878}.wp-pointer .wp-pointer-content h3:before{color:<?php echo $color_3; ?>}.wp-pointer.wp-pointer-top .wp-pointer-arrow,.wp-pointer.wp-pointer-top .wp-pointer-arrow-inner,.wp-pointer.wp-pointer-undefined .wp-pointer-arrow,.wp-pointer.wp-pointer-undefined .wp-pointer-arrow-inner{border-bottom-color:<?php echo $color_3; ?>}.media-item .bar,.media-progress-bar div{background-color:<?php echo $color_3; ?>}.details.attachment{box-shadow:inset 0 0 0 3px #fff,inset 0 0 0 7px <?php echo $color_3; ?>}.attachment.details .check{background-color:<?php echo $color_3; ?>;box-shadow:0 0 0 1px #fff,0 0 0 2px <?php echo $color_3; ?>}.media-selection .attachment.selection.details .thumbnail{box-shadow:0 0 0 1px #fff,0 0 0 3px <?php echo $color_3; ?>}.theme-browser .theme.active .theme-name,.theme-browser .theme.add-new-theme a:focus:after,.theme-browser .theme.add-new-theme a:hover:after{background:<?php echo $color_3; ?>}.theme-browser .theme.add-new-theme a:focus span:after,.theme-browser .theme.add-new-theme a:hover span:after{color:<?php echo $color_3; ?>}.theme-filter.current,.theme-section.current{border-bottom-color:<?php echo $color_2; ?>}body.more-filters-opened .more-filters{color:#fff;background-color:<?php echo $color_2; ?>}body.more-filters-opened .more-filters:before{color:#fff}body.more-filters-opened .more-filters:focus,body.more-filters-opened .more-filters:hover{background-color:<?php echo $color_3; ?>;color:#fff}body.more-filters-opened .more-filters:focus:before,body.more-filters-opened .more-filters:hover:before{color:#fff}.widgets-chooser li.widgets-chooser-selected{background-color:<?php echo $color_3; ?>;color:#fff}.widgets-chooser li.widgets-chooser-selected:before,.widgets-chooser li.widgets-chooser-selected:focus:before{color:#fff}div#wp-responsive-toggle a:before{color:#f3f2f1}.wp-responsive-open div#wp-responsive-toggle a{border-color:transparent;background:<?php echo $color_3; ?>}.wp-responsive-open #wpadminbar #wp-admin-bar-menu-toggle a{background:<?php echo $color_1; ?>}.wp-responsive-open #wpadminbar #wp-admin-bar-menu-toggle .ab-icon:before{color:#f3f2f1}.mce-container.mce-menu .mce-menu-item-normal.mce-active,.mce-container.mce-menu .mce-menu-item-preview.mce-active,.mce-container.mce-menu .mce-menu-item.mce-selected,.mce-container.mce-menu .mce-menu-item:focus,.mce-container.mce-menu .mce-menu-item:hover{background:<?php echo $color_3; ?>}<?php echo $rules; ?>


