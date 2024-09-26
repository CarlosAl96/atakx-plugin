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

     if (!wp_next_scheduled('atakx_initial_cron')) {
          $tiempo_inicial = strtotime("+5 minutes");
          wp_schedule_single_event($tiempo_inicial, 'atakx_initial_cron');
     }

     $response = array('success' => true, 'message' => $message);
     echo json_encode($response);
     exit;
}
