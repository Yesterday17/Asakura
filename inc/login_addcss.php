<style type="text/css">
    .forgetmenot input:checked + label {
        background: var(--theme-color);
    }

    #labelTip {
        background-color: var(--theme-color);
    }

    #label {
        color: var(--theme-color);
    }

    #login .submit .button {
        background: var(--theme-color);
    }

    #login {
        font: 14px/1.4 "Helvetica Neue", "HelveticaNeue", Helvetica, Arial, sans-serif;
        position: absolute;
        border-radius: 12px;
        top: 50%;
        left: 50%;
        width: 350px;
        /*height: 500px;*/
        padding: 0 !important;
        margin: -235px 0 0 -175px !important;
        background: rgba(255, 255, 255, 0.40) center 48%;
    }

    <?php if (akina_option('login_pf', '1')): ?>
    #login {
        font: 14px/1.4 "Helvetica Neue", "HelveticaNeue", Helvetica, Arial, sans-serif;
        position: absolute;
        background: rgba(255, 255, 255, 0.40);
        border-radius: 12px;
        top: 50%;
        left: 50%;
        width: 350px;
        /* height: 500px; */
        padding: 0px !important;
        margin: -265px 0px 0px -175px !important;
        background-position: center 48%;
    }

    <?php endif; ?>

    <?php if (akina_option('login_blur', '0')): ?>
    #bg {
        -webkit-filter: blur(2px); /* Chrome, Opera */
        -moz-filter: blur(2px);
        -ms-filter: blur(2px);
        filter: blur(2px);
    }

    <?php endif; ?>

</style>
