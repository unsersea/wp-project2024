<?php

// print_r($_REQUEST);

$path = preg_replace('/wp-content(?!.*wp-content).*/', '', __DIR__);
include($path . 'wp-load.php');

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (!empty($_REQUEST["action"])) {

        $action = $_REQUEST["action"];

        if ($action == "submit-create-category") {
            // print_r($_REQUEST);
            // die();
            // $category = $_REQUEST["category-name"];
            // $content = $_REQUEST["category-content"];

            $category = $_REQUEST["category"];
            $content = $_REQUEST["content"];

            global $wpdb;

            $set_name_pj = "pj1001_";

            date_default_timezone_set('Asia/Ho_Chi_Minh');

            $table_name = $wpdb->prefix . $set_name_pj . "category";

            $wpdb->insert($table_name, array(
                'name_category' => $category,
                'content' => $content,
                // 'create_at' => date('j/n/Y - g:i a')
            ));
        }

    } else {

    }

} else {

}