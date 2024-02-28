<?php 

if($_SERVER["REQUEST_METHOD"] == "GET") {
    // Check Empty

    if(isset($_GET["id"])) {

        global $wpdb;

        $id = $_GET["id"];

        $set_name_pj = "pj1001_";
        $table_name = $wpdb->prefix.$set_name_pj."bill";

        $sql = $wpdb->get_results("SELECT * FROM $table_name WHERE id = '$id'");
        
    }
}