<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['articlesPerWeek'])) {

     $articlesPerWeek = $_POST['articlesPerWeek'];

     global $wpdb;
     $table_name = $wpdb->prefix . 'atakx_config';
     $data_exist = $wpdb->get_row("SELECT * FROM $table_name LIMIT 1");

     $message = "";

     if ($data_exist) {
          $wpdb->update(
               $table_name,
               array(
                    'articles_per_week' => $articlesPerWeek,
               ),
               ['id' => $data_exist->id]
          );

          $message = "Correctly edited data";
     }

     $response = array('success' => true, 'message' => $message);
     echo json_encode($response);
     exit;
}
