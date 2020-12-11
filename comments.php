<?php

/**
 * COMMENTS TEMPLATE
 */

/*if('comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
    die(__('Please do not load this page directly.', 'akina'));*/

if (post_password_required()) {
    return;
}

?>

<?php if (comments_open()): ?>
    <section id="comments" class="comments">
        <div class="commentwrap comments-hidden">
            <div class="notification">
                <i class="iconfont icon-mark"></i><?php ee('view comments'); /*查看评论*/ ?> -
                <span class="noticom"><?php comments_number('0', '1', '%'); ?> </span>
            </div>
        </div>

        <div class="comments-main">
            <h3 id="comments-list-title">Comments | <span
                        class="noticom"><?php comments_number('0', '1', '%'); ?> </span>
            </h3>
            <div id="loading-comments"><span></span></div>
            <?php if (have_comments()): ?>
                <ul class="commentwrap">
                    <?php wp_list_comments('type=comment&callback=akina_comment_format'); ?>
                </ul>

                <nav id="comments-navi">
                    <?php paginate_comments_links('prev_text=« Older&next_text=Newer »'); ?>
                </nav>
            <?php elseif (comments_open()): ?>
                <div class="commentwrap">
                    <div class="notification-hidden"><i
                                class="iconfont icon-mark"></i> <?php _e('no comment', SAKURA_DOMAIN); /*暂无评论*/ ?>
                    </div>
                </div>
            <?php endif; ?>

            <?php
            if (comments_open()) {
                if (akina_option('norobot'))
                    $robot_comments = '<label class="siren-checkbox-label"><input class="siren-checkbox-radio" type="checkbox" name="no-robot"><span class="siren-no-robot-checkbox siren-checkbox-radioInput"></span>' . __('I\'m not a robot', SAKURA_DOMAIN) . '</label>';
                $private_ms = akina_option('open_private_message') ? '<label class="siren-checkbox-label"><input class="siren-checkbox-radio" type="checkbox" name="is-private"><span class="siren-is-private-checkbox siren-checkbox-radioInput"></span>' . __('Comment in private', SAKURA_DOMAIN) . '</label>' : '';
                $mail_notify = akina_option('mail_notify') ? '<label class="siren-checkbox-label"><input class="siren-checkbox-radio" type="checkbox" name="mail-notify"><span class="siren-mail-notify-checkbox siren-checkbox-radioInput"></span>' . __('Comment reply notify', SAKURA_DOMAIN) . '</label>' : '';
                $args = array(
                    'id_form'              => 'commentform',
                    'id_submit'            => 'submit',
                    'title_reply'          => '',
                    'title_reply_to'       => '<div class="graybar"><i class="fa fa-comments-o"></i>' . ll('Leave a Reply to') . ' %s' . '</div>',
                    'cancel_reply_link'    => ll('Cancel Reply'),
                    'label_submit'         => ll('BiuBiuBiu~'),
                    'comment_field'        => '<p style="font-style:italic"><a href="https://segmentfault.com/markdown" target="_blank"><i class="iconfont icon-markdown" style="color:#000"></i></a> Markdown Supported while <i class="fa fa-code" aria-hidden="true"></i> Forbidden</p><div class="comment-textarea"><textarea placeholder="' . __("You are a surprise that I will only meet once in my life", SAKURA_DOMAIN) . ' ..." name="comment" class="commentbody" id="comment" rows="5" tabindex="4"></textarea><label class="input-label">' . __("You are a surprise that I will only meet once in my life", SAKURA_DOMAIN) . ' ...</label></div>
                        <div id="upload-img-show"></div>',
                    'comment_notes_after'  => '',
                    'comment_notes_before' => '',
                    'fields'               => apply_filters('comment_form_default_fields', array(
                        'avatar' => '<div class="cmt-info-container">
    <div class="comment-user-avatar">
        <img src="https://cdn.jsdelivr.net/gh/Fuukei/Public_Repository@latest/vision/basic/avatar.jpeg">
        <div class="social-check qq-check">
            <i class="fa fa-qq" aria-hidden="true"></i>
        </div>
        <div class="social-check gravatar-check">
            <i class="fa fa-google" aria-hidden="true"></i>
        </div>
    </div>',
                        'author' => '<div class="popup cmt-popup cmt-author" onclick="asakura.cmt_showPopup(this)">
<span class="popuptext" id="thePopup" style="margin-left: -115px;width: 230px;">' . ll("Auto pull nickname and avatar with a QQ num. entered")/*输入QQ号将自动拉取昵称和头像*/ . '</span>
<input type="text" placeholder="' . ll("Nickname or QQ number") /*昵称或QQ号*/ . ' (' . ll("Name* ") . ')" name="author" id="author" value="' . esc_attr(get_comment_author()) . '" size="22" autocomplete="off" tabindex="1" aria-required="true" />
</div>',
                        'email'  => '<div class="popup cmt-popup" onclick="asakura.cmt_showPopup(this)">
<span class="popuptext" id="thePopup" style="margin-left: -65px;width: 130px;">' . ll("You will receive notification by email")/*你将收到回复通知*/ . '</span>
<input type="text" placeholder="' . ll("email") . ' (' . ll("Must* ") . ')" name="email" id="email" value="' . esc_attr(get_comment_author_email()) . '" size="22" tabindex="1" autocomplete="off" aria-required="true" /></div>',
                        'url'    => '<div class="popup cmt-popup" onclick="asakura.cmt_showPopup(this)">
<span class="popuptext" id="thePopup" style="margin-left: -55px;width: 110px;">' . ll("Advertisement is forbidden 😀")/*禁止小广告😀*/ . '</span>
<input type="text" placeholder="' . ll("Site") . '" name="url" id="url" value="' . esc_attr(get_comment_author_url()) . '" size="22" autocomplete="off" tabindex="1" /></div></div>' . $robot_comments . $private_ms . $mail_notify,
                        'qq'     => '<input type="text" placeholder="QQ" name="new_field_qq" id="qq" value="' . esc_attr(get_comment_author_url()) . '" style="display:none" autocomplete="off"/><!--此栏不可见-->'
                    ))
                );
                comment_form($args);
            }
            ?>
        </div>
    </section>
<?php endif; ?>
