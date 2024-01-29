<?php 

/**
 * Plugin Name: wp-project1001-plugins
 * Plugin URI: wp-project1001-plugins/plugin.php
 * Description: Kích Thoạt Bảng Cho Trang Website Về Đặt Vé Đầm Sen
 * Author: unsersea
 * Plugin Version: v1.0
 */

// Check Defined ABSPATH
if(!defined('ABSPATH')) exit;

// Set Define Root
define("ROOT_PLUGIN_URI", plugin_dir_url(__FILE__));
define("ROOT_PLUGIN_PATH", plugin_dir_path(__FILE__));
define("ROOT_PLUGIN_FILE", __FILE__);
define("ROOT_PLUGIN_VERSION", "1.0.0");
define("ROOT_PLUGIN_CLASS", "Plugin_Project1001");

class Plugin_Project1001 {
    
    # create_table function
    public static function create_table() {
        global $wpdb;
        $charset_collate = $wpdb->get_charset_collate();
        $set_name_pj = "pj1001_";

        // Set Table Name with prefix . $set_name_pj
        $tb_contact = $wpdb->prefix.$set_name_pj."contact";
        $tb_category = $wpdb->prefix.$set_name_pj."category";
        $tb_event = $wpdb->prefix.$set_name_pj."event";
        $tb_category_event = $wpdb->prefix.$set_name_pj."category_event";
        $tb_package = $wpdb->prefix.$set_name_pj."package";
        $tb_ticket = $wpdb->prefix.$set_name_pj."ticket";
        $tb_bill = $wpdb->prefix.$set_name_pj."bill";
        $tb_url_ticket = $wpdb->prefix.$set_name_pj."url_ticket";

        ### Set Table SQL
        $sql_contact = "CREATE TABLE $tb_contact(
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `fullname` varchar(25) NULL,
            `email` varchar(50) NOT NULL,
            `phone` int(10) NOT NULL,
            `address` varchar(100) NULL,
            `comment` text,
            /* `status` tinyint(1), */
            `status` boolean,
            `active` tinyint(1),
            `create_at` timestamp,
            PRIMARY KEY (id)
        ) $charset_collate;";

        $sql_category = "CREATE TABLE $tb_category(
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `name_category` varchar(50) NOT NULL,
            `content` text,
            `create_at` timestamp,
            PRIMARY KEY (id)
        ) $charset_collate;";

        $sql_event = "CREATE TABLE $tb_event(
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `title` varchar(50) NOT NULL,
            `address` varchar(100) NOT NULL,
            `start_date` datetime,
            `end_date` datetime,
            `thumbnail` text NOT NULL,
            `content` text,
            `create_at` timestamp,
            PRIMARY KEY (id)
        ) $charset_collate;";

        $sql_category_event = "CREATE TABLE $tb_category_event(
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `event_id` int(11) NOT NULL,
            `category_id` int(11) NOT NULL,
            `create_at` timestamp,
            PRIMARY KEY (id),
            FOREIGN KEY (event_id) REFERENCES $tb_event(id),
            FOREIGN KEY (category_id) REFERENCES $tb_category(id)
        ) $charset_collate;";

        $sql_package = "CREATE TABLE $tb_package(
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `package_name` varchar(50) NOT NULL,
            `price` int(11) NOT NULL,
            `discount` int(2) NULL,
            `create_at` timestamp,
            PRIMARY KEY (id)
        ) $charset_collate;";

        $sql_ticket = "CREATE TABLE $tb_ticket(
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `fullname` varchar(50) NOT NULL,
            `email` varchar(50) NOT NULL,
            `phone` int(10) NOT NULL,
            `amount` int(2),
            `status` boolean,
            `payment_method` varchar(10),
            `start_date` datetime,
            `end_date` datetime,
            `package_id` int(11) NOT NULL,
            PRIMARY KEY (id),
            FOREIGN KEY (package_id) REFERENCES $tb_package(id)
        ) $charset_collate;";

        $sql_bill = "CREATE TABLE $tb_bill(
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `qrcode_url` text NOT NULL,
            `start_date` datetime NOT NULL,
            `email` varchar(50) NOT NULL,
            `status` boolean,
            `total` int(11),
            `payment_info` varchar(10),
            `ticket_id` int(11) NOT NULL,
            PRIMARY KEY (id),
            FOREIGN KEY (ticket_id) REFERENCES $tb_ticket(id)
        ) $charset_collate;";

        $sql_url_ticket = "CREATE TABLE $tb_url_ticket(
            `id` text NOT NULL,
            `ticket_id` int(11) NOT NULL,
            `create_at` timestamp,
            PRIMARY KEY (id),
            FOREIGN KEY (ticket_id) REFERENCES $tb_ticket(id)
        ) $charset_collate;";

        /**
         * Require ABSPATH
         */
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

        dbDelta($sql_contact);
        dbDelta($sql_category);
        dbDelta($sql_event);
        dbDelta($sql_category_event);
        dbDelta($sql_package);
        dbDelta($sql_ticket);
        dbDelta($sql_bill);
        dbDelta($sql_url_ticket);
    }

    # remove_table function
    public static function remove_table() {
        global $wpdb;
        $set_name_pj = "pj1001_";

        // Set Table Name with prefix . $set_name_pj
        $tb_contact = $wpdb->prefix.$set_name_pj."contact";
        $tb_category = $wpdb->prefix.$set_name_pj."category";
        $tb_event = $wpdb->prefix.$set_name_pj."event";
        $tb_category_event = $wpdb->prefix.$set_name_pj."category_event";
        $tb_package = $wpdb->prefix.$set_name_pj."package";
        $tb_ticket = $wpdb->prefix.$set_name_pj."ticket";
        $tb_bill = $wpdb->prefix.$set_name_pj."bill";
        $tb_url_ticket = $wpdb->prefix.$set_name_pj."url_ticket";

        /**
         * Delete Foreign Key | Table
         */
        $table_array = [
            $tb_url_ticket, $tb_bill, $tb_ticket, $tb_category_event, $tb_event, $tb_package, $tb_contact, $tb_category
        ];

        # Foreach Array Table To Remove
        foreach($table_array as $table_name) {
            $sql_drop_table = "DROP TABLE IF EXISTS $table_name";
            $result = $wpdb->query($sql_drop_table);
        }

        $wpdb->query($result);
    }
}
# activation create_table()
register_activation_hook(ROOT_PLUGIN_FILE, array(ROOT_PLUGIN_CLASS, "create_table"));
# deactivation remove_table()
register_deactivation_hook(ROOT_PLUGIN_FILE, array(ROOT_PLUGIN_CLASS, "remove_table"));

# sidebar menu function [contact, category, event, package, ticket, bill, chart]
function add_menu_contact() {
    # set title
    $page_title = __('contact title', 'contact domain');
    # note: only icon | position not add
    add_menu_page($page_title, 'Phản Hồi', "manage_options", 'contact', "");
    add_submenu_page($page_title, 'Danh Sách', "manage_options", 'contact detail', '');
}

function add_menu_category_event() {
    # set title
    $page_title = __('event title', 'event domain');
    # note: only icon | position not add
    add_menu_page($page_title, 'Sự Kiện', "manage_options", 'event', "");
    add_submenu_page($page_title, 'Thể Loại', "manage_options", 'category list', '');
    add_submenu_page($page_title, 'Danh Sách', "manage_options", 'event list', '');
}

function add_menu_package_ticket() {
    # set title
    $page_title = __('ticket title', 'ticket domain');
    # note: only icon | position not add
    add_menu_page($page_title, 'Đặt Vé', "manage_options", 'ticket', "");
    add_submenu_page($page_title, 'Loại Gói', "manage_options", 'package list', '');
    add_submenu_page($page_title, 'Danh Sách', "manage_options", 'ticket list', '');
    add_submenu_page($page_title, 'Biểu Đồ', "manage_options", 'chart', '');
}

function add_menu_page_bill() {
    # set title
    $page_title = __('bill title', 'bill domain');
    # note: only icon | position not add
    add_menu_page($page_title, 'Hoá Đơn', "manage_options", 'bill', "");
    add_submenu_page($page_title, 'Danh Sách', "manage_options", 'bill list', '');
    add_submenu_page($page_title, 'Biểu Đồ', "manage_options", 'chart', '');
}

# add action sidebar menu
add_action('admin_menu', '');
add_action('admin_menu', '');
add_action('admin_menu', '');

# output file exists [contact (list), category [crud], event[crud], package[crud], ticket[crud], bill[crud]]
# contact (list)
function output_contact_view() {
    if(!file_exists(ROOT_PLUGIN_PATH . '')) {
        require_once(ROOT_PLUGIN_PATH . '');
    }
}

# category [crud] | event [crud]
function output_category_view() {
    if(!file_exists(ROOT_PLUGIN_PATH . '')) {
        require_once(ROOT_PLUGIN_PATH . '');
    }
}

function output_category_create() {
    if(!file_exists(ROOT_PLUGIN_PATH . '')) {
        require_once(ROOT_PLUGIN_PATH . '');
    }
}

function output_category_update() {
    if(!file_exists(ROOT_PLUGIN_PATH . '')) {
        require_once(ROOT_PLUGIN_PATH . '');
    }
}

function output_event_view() {
    if(!file_exists(ROOT_PLUGIN_PATH . '')) {
        require_once(ROOT_PLUGIN_PATH . '');
    }
}

function output_event_create() {
    if(!file_exists(ROOT_PLUGIN_PATH . '')) {
        require_once(ROOT_PLUGIN_PATH . '');
    }
}

function output_event_update() {
    if(!file_exists(ROOT_PLUGIN_PATH . '')) {
        require_once(ROOT_PLUGIN_PATH . '');
    }
}

function output_event_detail() {
    if(!file_exists(ROOT_PLUGIN_PATH . '')) {
        require_once(ROOT_PLUGIN_PATH . '');
    }
}

# package [crud] | ticket [crud]
function output_package_view() {
    if(!file_exists(ROOT_PLUGIN_PATH . '')) {
        require_once(ROOT_PLUGIN_PATH . '');
    }
}

function output_package_create() {
    if(!file_exists(ROOT_PLUGIN_PATH . '')) {
        require_once(ROOT_PLUGIN_PATH . '');
    }
}

function output_package_update() {
    if(!file_exists(ROOT_PLUGIN_PATH . '')) {
        require_once(ROOT_PLUGIN_PATH . '');
    }
}

function output_ticket_view() {
    if(!file_exists(ROOT_PLUGIN_PATH . '')) {
        require_once(ROOT_PLUGIN_PATH . '');
    }
}

function output_ticket_create() {
    if(!file_exists(ROOT_PLUGIN_PATH . '')) {
        require_once(ROOT_PLUGIN_PATH . '');
    }
}

function output_ticket_update() {
    if(!file_exists(ROOT_PLUGIN_PATH . '')) {
        require_once(ROOT_PLUGIN_PATH . '');
    }
}

function output_ticket_detail() {
    if(!file_exists(ROOT_PLUGIN_PATH . '')) {
        require_once(ROOT_PLUGIN_PATH . '');
    }
}

function output_ticket_chart() {

}

# bill [crud]
function output_bill_view() {
    if(!file_exists(ROOT_PLUGIN_PATH . '')) {
        require_once(ROOT_PLUGIN_PATH . '');
    }
}

function output_bill_create() {
    if(!file_exists(ROOT_PLUGIN_PATH . '')) {
        require_once(ROOT_PLUGIN_PATH . '');
    }
}

function output_bill_update() {
    if(!file_exists(ROOT_PLUGIN_PATH . '')) {
        require_once(ROOT_PLUGIN_PATH . '');
    }
}

function output_bill_detail() {
    if(!file_exists(ROOT_PLUGIN_PATH . '')) {
        require_once(ROOT_PLUGIN_PATH . '');
    }
}

function output_bill_chart() {

}

# add action script | link (javascript | css | scss | bootstrap | jquery)

## css
function custom_admin_css() {
    # cdn boxicons
    wp_enqueue_style('boxicons', 'https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css', array(), false, 'all');
    # jquery ui css
    wp_enqueue_style('jquery-ui-css', 'https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css', array(), false, 'all');
    # style
    wp_enqueue_style('style main', ROOT_PLUGIN_URI . '/public/css/style.css', array(), "v1.0", 'all');
}

## javascript
function custom_admin_js() {
    # jquery
    wp_enqueue_script('jquery', 'https://code.jquery.com/jquery-3.2.1.min.js', array(), false, array());
    # jquery ui js
    wp_enqueue_script('jquery-ui-js', 'https://code.jquery.com/ui/1.13.2/jquery-ui.js', array(), false, array());
    // wp_enqueue_script('tinymce', '', array(), false, array());
    # app
    wp_enqueue_script('app', ROOT_PLUGIN_URI . '/public/js/App.js', array(), "v1.0", array());

}

add_action('admin_enqueue_scripts', 'custom_admin_css');
add_action('admin_enqueue_scripts', 'custom_admin_js');

# upgrader

// function custom_upgrader() {
    
// }