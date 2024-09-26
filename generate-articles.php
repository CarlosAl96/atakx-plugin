<?php

function atakx_generate_articles()
{
     global $wpdb;
     $table_name = $wpdb->prefix . 'atakx_config';
     $config = $wpdb->get_row("SELECT * FROM $table_name LIMIT 1");

     if ($config) {

          $apiKey = $config->api_key;
          $nameBusiness = $config->name_business;
          $descriptionBusiness = $config->description_business;
          $keyWords = $config->key_words;
          $isImageGeneral = $config->is_image_general == 1 ? true : false;
          $isImagesMiddle = $config->is_images_middle == 1 ? true : false;
          $isWithContentTable = $config->is_with_content_table == 1 ? true : false;

          $url = 'http://localhost:4000/api/v1/plugin-wp/article';

          $request_args = [
               'timeout'     => '1000',
               'redirection' => '5',
               'httpversion' => '1.0',
               'blocking'    => true,
               'body' => json_encode([
                    'apiKey' => $apiKey,
                    'name' => $nameBusiness,
                    'descriptionBusiness' => $descriptionBusiness,
                    'keyWords' => $keyWords,
                    'isImageGeneral' => $isImageGeneral,
                    'isImagesMiddle' => $isImagesMiddle,
                    'isWithContentTable' => $isWithContentTable,
                    'categories' => ["Carros deportivos", "JDM", "Tuning", "Mantenimiento"],
               ]),
               'headers' => [
                    'Content-Type' => 'application/json',
               ],
          ];

          $response = wp_remote_post($url, $request_args);
          $body = wp_remote_retrieve_body($response);

          $bodyJSON = json_decode($body);

          // Crea una nueva entrada
          $new_post = array(
               'post_title' => $bodyJSON->response->title,
               'post_content' => $bodyJSON->response->content,
               'post_type' => 'post',
               'post_status' => 'publish'
          );

          $post_id = wp_insert_post($new_post);

     } else {
          exit;
     }
}
