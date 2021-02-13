<?php

/**
 * Top Features virsion 2
 * Saurce: https://github.com/gudh/ihover
 */

?>
<div class="top-feature-row">
    <h1 class="fes-title">
        <i class="fa fa-paper-plane-o" aria-hidden="true"></i> <?php echo akina_option('focus-area-title'); ?>
    </h1>
    <div class="top-feature-v2">
        <div class="the-feature square from_left_and_right">
            <a href="<?php echo akina_option('feature1_link'); ?>" target="_blank">
                <div class="img"><img src="<?php echo akina_option('feature1_img'); ?>"></div>
                <div class="info">
                    <h3><?php echo akina_option('feature1_title'); ?></h3>
                    <p><?php echo akina_option('feature1_description'); ?></p>
                </div>
            </a>
        </div>
    </div>
    <div class="top-feature-v2">
        <div class="the-feature square from_left_and_right" style="margin: 0 4.5px">
            <a href="<?php echo akina_option('feature2_link'); ?>" target="_blank">
                <div class="img"><img src="<?php echo akina_option('feature2_img'); ?>"></div>
                <div class="info">
                    <h3><?php echo akina_option('feature2_title'); ?></h3>
                    <p><?php echo akina_option('feature2_description'); ?></p>
                </div>
            </a>
        </div>
    </div>
    <div class="top-feature-v2">
        <div class="the-feature square from_left_and_right">
            <a href="<?php echo akina_option('feature3_link'); ?>" target="_blank">
                <div class="img"><img src="<?php echo akina_option('feature3_img'); ?>"></div>
                <div class="info">
                    <h3><?php echo akina_option('feature3_title'); ?></h3>
                    <p><?php echo akina_option('feature3_description'); ?></p>
                </div>
            </a>
        </div>
    </div>
</div>
