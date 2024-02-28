<?php 

/** remove_admin_topbar function (Only Admin) */
add_action("wp_head", "remove_admin_topbar");

function remove_admin_topbar() {
    show_admin_bar(false);
}

/** remove admin_topbar (Only User) */
// if(!current_user_can('manage_options')) {
//     add_filter('show_admin_bar', '__return_false');
// }

$wp_project1001_last_version = get_option("wp_project1001_last_version");

if($wp_project1001_last_version == "") {
    $$wp_project1001_last_version = "0.0";
}

# Theme Support
## Title Tag
function th_support_title_tag() {
    add_theme_support('title-tag');
}

## Custom Logo
function th_support_custom_logo() {
    add_theme_support('custom-logo');
}

function th_support_custom_background() {
    $default_custom = array(
        'default-image'          => '',
        'default-preset'         => 'default',
        'default-position-x'     => 'left',
        'default-position-y'     => 'top',
        'default-size'           => 'auto',
        'default-repeat'         => 'repeat',
        'default-attachment'     => 'scroll',
        'default-color'          => '',
        'wp-head-callback'       => '_custom_background_cb',
        'admin-head-callback'    => '',
        'admin-preview-callback' => '',
    );

    add_theme_support('custom-background', $default_custom);
}

function th_support_automatic_feed_links() {
    add_theme_support('automatic-feed-links');
}

function th_support_post_thumbnails() {
    add_theme_support('post_thumbnails');
}

function th_support_html5() {
    $default_custom_html5 = array(
        'comment-list', 
        'comment-form', 
        'search-form', 
        'gallery', 
        'caption', 
        'style', 
        'script'
    );

    add_theme_support('html5', $default_custom_html5);
}

add_action("after_setup_theme", "th_support_title_tag");
add_action("after_setup_theme", "th_support_custom_logo");
add_action("after_setup_theme", "th_support_custom_background");
add_action("after_setup_theme", "th_support_automatic_feed_links");
add_action("after_setup_theme", "th_support_post_thumbnails");
add_action("after_setup_theme", "th_support_html5");

# Menu Navigation
function menu_nav() {
    $default_custom_locations = array(
        'primary' => __('primary menu', 'primary domain'),
        // 'secondary' => __('secondary menu', 'secondary domain')
    );

    register_nav_menus($default_custom_locations);
}

add_action("init", "menu_nav");

# Google Fonts
function google_fonts() {
    wp_register_style('Poppins', 'https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
    wp_enqueue_style('Poppins');
}

add_action('wp_print_styles', 'google_fonts');

# add action script | link (javascript | css | scss | bootstrap | jquery)

add_action('wp_enqueue_scripts', 'custom_user_css');
add_action('wp_enqueue_scripts', 'custom_user_js');

## css
function custom_user_css() {

    # version style.css theme folder
    $version = wp_get_theme()->get( 'Version' );
    
    # cdn boxicons
    wp_enqueue_style('boxicons-main', 'https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css', array(), '', 'all');
    # swiper css
    wp_enqueue_style('swiper-css', 'https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css', array(), '', 'all');
    # bootstrap
    wp_enqueue_style('bootstrap4-main', 'https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css', array(), '4.0.0', 'all');
    // wp_enqueue_style('bootstrap4-main', get_template_directory_uri() . '/assets/css/bootstrap.css', array(), '', 'all');
    # style
    wp_enqueue_style('style-main', get_template_directory_uri() . '/assets/css/style.css', array(), $version, 'all');
    # style folder setup
    wp_enqueue_style('style-main-theme', get_template_directory_uri() . '/style.css', array( 'bootstrap4-main' ), $version, 'all');
}

## javascript
function custom_user_js() {
    # jquery
    wp_enqueue_script('jquery-main', 'https://code.jquery.com/jquery-3.2.1.min.js', array(), '3.2.1', true);
    # swiper js
    wp_enqueue_script('swiper-js', 'https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js', array(), false, true);
    # app
    wp_enqueue_script('app', get_template_directory_uri() . '/assets/js/App.js', array('jquery'), "v1.0", true);
}