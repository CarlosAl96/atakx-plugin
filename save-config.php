<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['apiKey'])) {

     $apiKey = $_POST['apiKey'];
     $nameBusiness = $_POST['nameBusiness'];
     $descriptionBusiness = $_POST['descriptionBusiness'];
     $keyWords = $_POST['keyWords'];
     $maxArticlesPerMonth = $_POST['maxArticlesPerMonth'];
     $isImageGeneral = isset($_POST['isImageGeneral']) ? 1 : 0;
     $isEnableCta = isset($_POST['isEnableCta']) ? 1 : 0;
     $isWithContentTable = isset($_POST['isWithContentTable']) ? 1 : 0;

     global $wpdb;
     $table_name = $wpdb->prefix . 'atakx_config';
     $data_exist = $wpdb->get_row("SELECT * FROM $table_name LIMIT 1");

     $message = "";

     if ($data_exist && $_POST['apiKey']) {
          $wpdb->update(
               $table_name,
               array(
                    'id' => 0,
                    'api_key' => $apiKey,
                    'name_business' => $nameBusiness,
                    'description_business' => $descriptionBusiness,
                    'key_words' => $keyWords,
                    'is_image_general' => $isImageGeneral,
                    'is_enable_cta' => $isEnableCta,
                    'is_with_content_table' => $isWithContentTable,
                    'max_articles_per_month' => $maxArticlesPerMonth,
               ),
               ['id' => $data_exist->id]
          );

          $message = "Correctly edited data";
     } else {
          $wpdb->insert(
               $table_name,
               array(
                    'id' => 0,
                    'api_key' => $apiKey,
                    'name_business' => $nameBusiness,
                    'description_business' => $descriptionBusiness,
                    'key_words' => $keyWords,
                    'is_image_general' => $isImageGeneral,
                    'is_enable_cta' => $isEnableCta,
                    'is_with_content_table' => $isWithContentTable,
                    'articles_per_week' => 2,
                    'max_articles_per_month' => $maxArticlesPerMonth,
               )
          );

          $message = "Data saved successfully";
     }

     if (!wp_next_scheduled('atakx_initial_cron')) {

          $tiempo_inicial = strtotime("+1 minutes");
          wp_schedule_single_event($tiempo_inicial, 'atakx_initial_cron');
     }

     $response = array('success' => true, 'message' => $message);
     echo json_encode($response);
     exit;
}
