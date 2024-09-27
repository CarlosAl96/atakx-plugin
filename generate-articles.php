<?php

function atakx_generate_articles()
{
     global $wpdb;
     $table_config = $wpdb->prefix . 'atakx_config';
     $table_config_cta = $wpdb->prefix . 'atakx_config_cta';
     $config = $wpdb->get_row("SELECT * FROM $table_config LIMIT 1");
     $config_cta = $wpdb->get_row("SELECT * FROM $table_config_cta LIMIT 1");

     if ($config) {

          $apiKey = $config->api_key;
          $nameBusiness = $config->name_business;
          $descriptionBusiness = $config->description_business;
          $keyWords = $config->key_words;
          $isImageGeneral = $config->is_image_general == 1 ? true : false;
          $withCta = $config->is_enable_cta == 1 ? true : false;
          $isWithContentTable = $config->is_with_content_table == 1 ? true : false;
          $articlesNumber = $config->articles_per_week;
          $htmlCta = "";

          $categorias = get_categories();
          $array_categorias = array();

          foreach ($categorias as $categoria) {
               $array_categorias[] = array(
                    'id' => $categoria->term_id,
                    'name' => $categoria->name
               );
          }

          $intents = 0;

          if ($withCta && $config_cta) {
               $htmlCta = $config_cta->cta_html;
          }

          $url = 'http://localhost:4000/api/v1/plugin-wp/article';

          for ($i = 0; $i < $articlesNumber; $I++) {
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
                         'withCta' => $withCta,
                         'isWithContentTable' => $isWithContentTable,
                         'categories' => $array_categorias,
                         'htmlCta' => $htmlCta,
                    ]),
                    'headers' => [
                         'Content-Type' => 'application/json',
                    ],
               ];

               $response = wp_remote_post($url, $request_args);

               $http_code = wp_remote_retrieve_response_code($response);

               if ($http_code == 200) {
                    $body = wp_remote_retrieve_body($response);

                    $bodyJSON = json_decode($body);

                    $new_post = array(
                         'post_title' => $bodyJSON->response->title,
                         'post_content' => $bodyJSON->response->content,
                         'post_type' => 'post',
                         'post_status' => 'publish'
                    );

                    $post_id = wp_insert_post($new_post);
                    $intents = 0;
               } else {
                    $i--;
                    $intents++;
               }

               if ($intents == 5) {
                    break;
               }
          }
     } else {
          exit;
     }
}
