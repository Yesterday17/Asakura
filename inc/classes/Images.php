<?php

namespace Sakura\API;

class Images {
    public static function cover_gallery(): string {
        return akina_option('cover_cdn');
    }

    public static function mobile_cover_gallery(): string {
        return akina_option('cover_cdn_mobile');
    }

    public static function feature_gallery(): string {
        if (akina_option('post_cover_options') == "type_2") {
            $imgurl = akina_option('post_cover');
        } else {
            $imgurl = self::cover_gallery();
        }
        return $imgurl;
    }

}