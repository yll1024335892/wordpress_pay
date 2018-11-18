<?php
/**
 * User: yinliangliang
 * Date: 2018/11/18
 * Time: 23:25
 * file: function.php
 * email:yll1024335892@163.com
 */
add_theme_support('automatic-feed-links');
show_admin_bar(false);
define('version', '2018.10.10');
add_action('after_setup_theme', 'efhl_theme_setup');
function efhl_theme_setup()
{
    load_theme_textdomain('begin', get_template_directory() . '/languages');
}

require get_template_directory() . '/inc/options/includes/options.php';//与设置相关的操作
require get_template_directory() . '/inc/meta-boxes.php';
require get_template_directory() . '/inc/meta-delete.php';



function loadCustomTemplate($template)
{
    global $wp_query;
    if (!file_exists($template)) {
        return;
    }
    $wp_query->is_page = true;
    $wp_query->is_single = false;
    $wp_query->is_home = false;
    $wp_query->comments = false;
    // if we have a 404 status
    if ($wp_query->is_404) {
        // set status of 404 to false
        unset($wp_query->query["error"]);
        $wp_query->query_vars["error"] = "";
        $wp_query->is_404 = false;
    }
    // change the header to 200 OK
    header("HTTP/1.1 200 OK");
    //load our template
    include($template);
    exit;
}

function templateRedirect()
{
    $basename = basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING']);
    loadCustomTemplate(TEMPLATEPATH . '/efhl/' . "/$basename.php");
}

add_action('template_redirect', 'templateRedirect');


?>