<?php

function handle_send_email_request()
{
     if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'send_email') {

          $message = "";

          if (isset($_POST['name'], $_POST['email'])) {
               $name = sanitize_text_field($_POST['name']);
               $email = sanitize_email($_POST['email']);

               if (!is_email($email)) {
                    wp_send_json_error(['message' => 'El correo electrónico no es válido.']);
                    $message = "El correo electrónico no es válido.";
                    $response = array('success' => false, 'message' => $message);
                    echo json_encode($response);
                    exit;
               }

               $to = $email;
               $subject = "Hola, $name";
               $message = "¡Gracias por contactarnos, $name! Hemos recibido tu correo y pronto te responderemos.";
               $headers = ['Content-Type: text/plain; charset=UTF-8'];

               if (wp_mail($to, $subject, $message, $headers)) {
                    wp_send_json_success(['message' => 'Correo enviado exitosamente.']);
                    error_log('Correo enviado exitosamente.');
                    $message = "enviado";
                    $response = array('success' => true, 'message' => $message);
                    echo json_encode($response);
                    exit;
               } else {
                    wp_send_json_error(['message' => 'No se pudo enviar el correo.']);
                    error_log('Correo no enviado exitosamente.');
                    $message = "No enviado";
                    $response = array('success' => false, 'message' => $message);
                    echo json_encode($response);
                    exit;
               }
          } else {
               wp_send_json_error(['message' => 'Todos los campos son obligatorios.']);
               $message = "No enviado";
               $response = array('success' => false, 'message' => $message);
               error_log('Correo no enviado exitosamente.');
               echo json_encode($response);
               exit;
          }
     }
}
add_action('admin_post_nopriv_send_email', 'handle_send_email_request');
add_action('admin_post_send_email', 'handle_send_email_request');
