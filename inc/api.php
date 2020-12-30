<?php

/**
 * Classes
 */
include_once('classes/Aplayer.php');
include_once('classes/Bilibili.php');
include_once('classes/Cache.php');
include_once('classes/Images.php');

use Sakura\API\Aplayer;
use Sakura\API\Bilibili;
use Sakura\API\Images;
use Sakura\API\Cache;

/**
 * Router
 */
add_action('rest_api_init', function () {
    register_rest_route(SAKURA_REST_API, '/cache_search/json', array(
        'methods'             => 'GET',
        'callback'            => 'cache_search_json',
        'permission_callback' => '__return_true',
    ));
    register_rest_route(SAKURA_REST_API, '/image/cover', array(
        'methods'             => 'GET',
        'callback'            => 'cover_gallery',
        'permission_callback' => '__return_true',
    ));
    register_rest_route(SAKURA_REST_API, '/image/feature', array(
        'methods'             => 'GET',
        'callback'            => 'feature_gallery',
        'permission_callback' => '__return_true',
    ));
    register_rest_route(SAKURA_REST_API, '/bangumi/bilibili', array(
        'methods'             => 'POST',
        'callback'            => 'bgm_bilibili',
        'permission_callback' => '__return_true',
    ));
    register_rest_route(SAKURA_REST_API, '/meting/aplayer', array(
        'methods'             => 'GET',
        'callback'            => 'meting_aplayer',
        'permission_callback' => '__return_true',
    ));
    register_rest_route(SAKURA_REST_API, '/style/custom', array(
        'methods'             => 'GET',
        'callback'            => 'get_customizer_css',
        'permission_callback' => '__return_true',
    ));
});

function check_nonce() {
    if (!check_ajax_referer('wp_rest', '_wpnonce', false)) {
        $output = array(
            'status'  => 403,
            'success' => false,
            'message' => 'Unauthorized client.',
            'link'    => "https://view.moezx.cc/images/2019/11/14/step04.md.png",
            'proxy'   => akina_option('cmt_image_proxy') . "https://view.moezx.cc/images/2019/11/14/step04.md.png",
        );
        $result = new WP_REST_Response($output, 403);
        $result->set_headers(array('Content-Type' => 'application/json'));
        return $result;
    }
}

/*
 * 随机封面图 rest api
 * @rest api接口路径：SAKURA_REST_API/image/cover
 */
function cover_gallery(): WP_REST_Response {
    $type = $_GET['type'];
    if ($type === 'mobile' && akina_option('cover_beta')) {
        $imgurl = Images::mobile_cover_gallery();
    } else {
        $imgurl = Images::cover_gallery();
    }
    $data = array('cover image');
    $response = new WP_REST_Response($data);
    $response->set_status(302);
    $response->header('Location', $imgurl);
    return $response;
}

/*
 * 随机文章特色图 rest api
 * @rest api接口路径：SAKURA_REST_API/image/feature
 */
function feature_gallery(): WP_REST_Response {
    $img_url = Images::feature_gallery();
    $data = array('feature image');
    $response = new WP_REST_Response($data);
    $response->set_status(302);
    $response->header('Location', $img_url);
    return $response;
}

/*
 * 定制实时搜索 rest api
 * @rest api接口路径：SAKURA_REST_API/cache_search/json
 * @可在cache_search_json()函数末尾通过设置 HTTP header 控制 json 缓存时间
 */
function cache_search_json(): WP_REST_Response {
    if (!check_ajax_referer('wp_rest', '_wpnonce', false)) {
        $output = array('status' => 403, 'success' => false, 'message' => 'Unauthorized client.');
        $result = new WP_REST_Response($output, 403);
    } else {
        $output = Cache::search_json();
        $result = new WP_REST_Response($output, 200);
    }
    $result->set_headers(array(
        'Content-Type'  => 'application/json',
        'Cache-Control' => 'max-age=3600', // json 缓存控制
    ));
    return $result;
}

function bgm_bilibili(): WP_REST_Response {
    if (!check_ajax_referer('wp_rest', '_wpnonce', false)) {
        $output = array('status' => 403, 'success' => false, 'message' => 'Unauthorized client.');
        $response = new WP_REST_Response($output, 403);
    } else {
        $page = $_GET["page"] ?: 2;
        $bgm = new Bilibili();
        $html = preg_replace("/\s+|\n+|\r/", ' ', $bgm->get_bgm_items($page));
        $response = new WP_REST_Response($html, 200);
    }
    return $response;
}

function meting_aplayer(): WP_REST_Response {
    $type = $_GET['type'];
    $id = $_GET['id'];
    $wpnonce = $_GET['_wpnonce'];
    //$meting_pnonce = $_GET['meting_pnonce'];
    if ((isset($wpnonce) && !check_ajax_referer('wp_rest', $wpnonce, false)) || (isset($nonce) && !wp_verify_nonce($nonce, $type . '#:' . $id))) {
        $output = array('status' => 403, 'success' => false, 'message' => 'Unauthorized client.');
        $response = new WP_REST_Response($output, 403);
    } else {
        $Meting_API = new Aplayer();
        $data = $Meting_API->get_data($type, $id);
        if ($type === 'playlist') {
            $response = new WP_REST_Response($data, 200);
            $response->set_headers(array('cache-control' => 'max-age=3600'));
        } elseif ($type === 'lyric') {
            $response = new WP_REST_Response();
            $response->set_headers(array('cache-control' => 'max-age=3600'));
            echo $data;
        } else {
            $response = new WP_REST_Response();
            $response->set_status(301);
            $response->header('Location', $data);
        }
    }
    return $response;
}

function get_customizer_css() {
    $data = customizer_css();
    header("Content-Type: text/css");
    echo $data;
}