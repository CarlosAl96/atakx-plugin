<?php
function atakx_handle_image_upload($image, $old_image)
{
     include(ABSPATH . "wp-includes/pluggable.php");

     if ($image['error'] === UPLOAD_ERR_OK) {

          $file_type = wp_check_filetype($image['name']);
          $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];

          if (in_array($file_type['type'], $allowed_types)) {

               $uploaded_file = wp_upload_bits(
                    $image['name'],
                    null,
                    file_get_contents($image['tmp_name'])
               );

               if (!$uploaded_file['error']) {

                    $image_url = $uploaded_file['url'];

                    $attachment_id = attachment_url_to_postid($old_image);

                    if ($attachment_id) {

                         wp_delete_attachment($attachment_id, true);
                    }
                    return $image_url;
               }
          }
     }

     return $old_image;
}
