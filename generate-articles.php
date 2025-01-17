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
          $site_url = get_site_url();
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

          for ($i = 0; $i < $articlesNumber; $i++) {
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
                         'pageUrl' => $site_url
                    ]),
                    'headers' => [
                         'Content-Type' => 'application/json',
                    ],
               ];

               $response = wp_remote_post($url, $request_args);

               $http_code = wp_remote_retrieve_response_code($response);

               if ($http_code == 200) {
                    $body = wp_remote_retrieve_body($response);
                    error_log('Error al establecer la imagen destacada: ' . $body);
                    $bodyJSON = json_decode($body);

                    $new_post = array(
                         'post_title' => $bodyJSON->response->title,
                         'post_content' => $bodyJSON->response->content,
                         'post_type' => 'post',
                         'post_status' => 'publish'
                    );

                    $post_id = wp_insert_post($new_post);

                    $result = set_featured_image_for_post($post_id, $bodyJSON->response->imageGeneral);

                    if (is_wp_error($result)) {
                         //error_log('Error al establecer la imagen destacada: ' . $result->get_error_message());
                    }

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
function set_featured_image_for_post($post_id, $image_url)
{
     // Asegúrate de incluir las funciones necesarias
     if (!function_exists('download_url')) {
          require_once(ABSPATH . 'wp-admin/includes/file.php');
     }

     // Descarga la imagen desde la URL
     $temp_file = download_url($image_url);

     if (is_wp_error($temp_file)) {
          return $temp_file;
     }

     // Configura los datos del archivo para subirlo
     $file = array(
          'name'     => basename($image_url),
          'type'     => mime_content_type($temp_file),
          'tmp_name' => $temp_file,
          'error'    => 0,
          'size'     => filesize($temp_file),
     );

     // Subir la imagen a la biblioteca de medios
     $upload = wp_handle_sideload($file, array('test_form' => false));

     // Verificar si la subida fue exitosa
     if (isset($upload['error'])) {
          @unlink($temp_file); // Borra el archivo temporal si falla
          return new WP_Error('upload_error', $upload['error']);
     }

     // Crear el attachment para la imagen subida
     $attachment = array(
          'post_mime_type' => $upload['type'],
          'post_title'     => sanitize_file_name($upload['file']),
          'post_content'   => '',
          'post_status'    => 'inherit',
     );

     // Insertar el attachment en la base de datos
     $attachment_id = wp_insert_attachment($attachment, $upload['file'], $post_id);

     if (is_wp_error($attachment_id)) {
          return $attachment_id;
     }

     // Generar los metadatos de la imagen
     require_once(ABSPATH . 'wp-admin/includes/image.php');
     $attach_data = wp_generate_attachment_metadata($attachment_id, $upload['file']);
     wp_update_attachment_metadata($attachment_id, $attach_data);

     // Establecer la imagen como destacada para el post
     set_post_thumbnail($post_id, $attachment_id);

     return true;
}
