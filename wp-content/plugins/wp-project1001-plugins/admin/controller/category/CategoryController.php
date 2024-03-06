<?php 
// 
$set_name_pj = "pj1001_";

$table_name = $wpdb->prefix . $set_name_pj . "category";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (!empty($_REQUEST["action-modal"])) { 
        $action = $_REQUEST["action-modal"];

        if ($action == "submit-create-category") {
            
        }
    }
}
