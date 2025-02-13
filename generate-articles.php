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

          set_time_limit(500);

          //for ($i = 0; $i < $articlesNumber; $i++) {

          $response = wp_remote_post($url, $request_args);

          $http_code = wp_remote_retrieve_response_code($response);

          if ($http_code == 200) {
               $body = wp_remote_retrieve_body($response);
               $bodyJSON = json_decode($body);
               error_log('Error al establecer la imagen destacada: ' . $bodyJSON->response->imageGeneral);


               $new_post = array(
                    'post_title' => $bodyJSON->response->title,
                    'post_content' => $bodyJSON->response->content,
                    'post_type' => 'post',
                    'post_status' => 'publish'
               );

               $post_id = wp_insert_post($new_post);

               $result = set_featured_image_for_post($post_id, $bodyJSON->response->imageGeneral);

               if (is_wp_error($result)) {
                    error_log('Error al establecer la imagen destacada: ' . $result->get_error_message());
               }

               //   $intents = 0;
          }

          // else {
          //      $i--;
          //      $intents++;
          // }

          // if ($intents == 5) {
          //      //break;
          // }
          // //}
     } else {
          exit;
     }
}
function set_featured_image_for_post($post_id, $image_url)
{
     // Verificar que el post ID sea válido
     if (!get_post($post_id)) {
          return new WP_Error('invalid_post', 'El ID del post no es válido.');
     }

     // Descargar la imagen desde la URL
     $response = wp_remote_get($image_url);
     if (is_wp_error($response)) {
          return $response; // Retorna el error si falla la descarga
     }

     // Obtener el contenido de la imagen
     $image_data = wp_remote_retrieve_body($response);
     if (empty($image_data)) {
          return new WP_Error('empty_image', 'No se pudo descargar la imagen.');
     }

     // Generar un nombre único para la imagen
     $filename = basename(parse_url($image_url . '.png', PHP_URL_PATH));

     // Especificar la ruta temporal para guardar la imagen
     $upload_dir = wp_upload_dir();
     $file_path = $upload_dir['path'] . '/' . $filename;

     // Guardar la imagen en el servidor
     if (!file_put_contents($file_path, $image_data)) {
          return new WP_Error('write_error', 'No se pudo guardar la imagen en el servidor.');
     }

     // Crear un attachment para la imagen
     $file_type = wp_check_filetype($filename, null);
     $attachment = array(
          'post_mime_type' => $file_type['type'],
          'post_title'     => sanitize_file_name($filename),
          'post_content'   => '',
          'post_status'    => 'inherit',
     );

     // Insertar la imagen en la biblioteca de medios
     $attach_id = wp_insert_attachment($attachment, $file_path, $post_id);
     if (is_wp_error($attach_id)) {
          return $attach_id;
     }

     // Generar los metadatos de la imagen
     require_once(ABSPATH . 'wp-admin/includes/image.php');
     $attach_data = wp_generate_attachment_metadata($attach_id, $file_path);
     wp_update_attachment_metadata($attach_id, $attach_data);

     // Asignar la imagen como destacada al post
     set_post_thumbnail($post_id, $attach_id);

     return true;
}
