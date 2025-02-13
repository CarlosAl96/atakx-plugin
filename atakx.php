<?php

/**
 * Plugin Name: Atakx Plugin
 * Plugin URI: https://app.atakx.com/
 * Description: Plugin para generar contenido de manera automática usando Open AI
 * Version: 1.0
 */

include_once(plugin_dir_path(__FILE__) . 'save-config.php');
include_once(plugin_dir_path(__FILE__) . 'save-config-post-rate.php');
include_once(plugin_dir_path(__FILE__) . 'save-config-cta.php');
// include_once(plugin_dir_path(__FILE__) . 'send-email.php');
include_once(plugin_dir_path(__FILE__) . 'generate-articles.php');
include_once(plugin_dir_path(__FILE__) . 'init-cron-generate-articles.php');

function atakx_activate_plugin()
{
     global $wpdb;
     $table_name_config = $wpdb->prefix . 'atakx_config';
     $table_name_CTA = $wpdb->prefix . 'atakx_config_cta';

     $config = $wpdb->get_row("SELECT * FROM $table_name_config LIMIT 1", ARRAY_A);

     if ($config) {
          if (!wp_next_scheduled('atakx_initial_cron')) {

               $tiempo_inicial = strtotime("+1 minutes");
               wp_schedule_single_event($tiempo_inicial, 'atakx_initial_cron');
          }
     } else {
          $sql = "CREATE TABLE IF NOT EXISTS {$table_name_config} (
               id INT NOT NULL AUTO_INCREMENT,
               api_key VARCHAR(255) NOT NULL,
               name_business VARCHAR(255) NOT NULL,
               description_business TEXT NOT NULL,
               key_words VARCHAR(255) NOT NULL,
               articles_per_week INTEGER DEFAULT 2,
               max_articles_per_month INTEGER DEFAULT 0,
               is_image_general TINYINT(1) DEFAULT 0,
               is_enable_cta TINYINT(1) DEFAULT 0,
               is_with_content_table TINYINT(1) DEFAULT 0,
               PRIMARY KEY (id)
          )";

          $sql2 = "CREATE TABLE IF NOT EXISTS {$table_name_CTA} (
               id INT NOT NULL AUTO_INCREMENT,
               background_image VARCHAR(255) NOT NULL,
               overlay_color VARCHAR(100) NOT NULL,
               overlay_opacity FLOAT NOT NULL,
               title VARCHAR(255) NOT NULL,
               button_title VARCHAR(255) NOT NULL,
               button_color VARCHAR(100) NOT NULL,
               font VARCHAR(100) NOT NULL,
               lead_email VARCHAR(100) NOT NULL,
               logo VARCHAR(255) NOT NULL,
               with_rounded_border TINYINT(1) DEFAULT 0,
               cta_html LONGTEXT NOT NULL,
               PRIMARY KEY (id)
          )";

          $wpdb->query($sql);
          $wpdb->query($sql2);
     }
}

function atakx_desactivate_plugin()
{
     if (wp_next_scheduled('atakx_initial_cron')) {
          $timestamp = wp_next_scheduled('atakx_initial_cron');
          wp_unschedule_event($timestamp, 'atakx_initial_cron');
     }
     if (wp_next_scheduled('atakx_cron_generate_article')) {
          $timestamp = wp_next_scheduled('atakx_cron_generate_article');
          wp_unschedule_event($timestamp, 'atakx_cron_generate_article');
     }
}

function atakx_create_admin_menu()
{
     add_menu_page('Atakx Plugin', 'Atakx', 'manage_options', 'atakx', 'atakx_view_menu', plugin_dir_url(__FILE__) . 'assets/img/icon.png');
}

function atakx_view_menu()
{
     include('views/config.php');
}

register_activation_hook(
     __FILE__,
     'atakx_activate_plugin'
);

register_deactivation_hook(
     __FILE__,
     'atakx_desactivate_plugin'
);

add_action('admin_menu', 'atakx_create_admin_menu');
add_action('atakx_cron_generate_article', 'atakx_generate_articles');
add_action('atakx_initial_cron', 'atakx_init_cron_generate_article');

add_action('admin_post_atakx_save_config', 'atakx_save_config');
add_action('admin_post_nopriv_atakx_save_config', 'atakx_save_config');

add_action('admin_post_atakx_save_config_cta', 'atakx_save_config_cta');
add_action('admin_post_nopriv_atakx_save_config_cta', 'atakx_save_config_cta');

add_action('admin_post_atakx_save_config_post_rate', 'atakx_save_config_post_rate');
add_action('admin_post_nopriv_atakx_save_config_post_rate', 'atakx_save_config_post_rate');


wp_register_style('atakx', plugin_dir_url(__FILE__) . 'assets/css/atakx.css', array());
wp_enqueue_style('atakx');

function custom_cta_shortcode($atts)
{
     // Atributos predeterminados del shortcode
     $atts = shortcode_atts([
          'background_image' => '',
          'logo' => '',
          'overlay_color' => '',
          'overlay_opacity' => '',
          'title' => '',
          'button_title' => '',
          'button_color' => '',
          'lead_email' => '',
          'overlayBorderRadius' => '',
          'containerBorderRadius' => '',
     ], $atts);

     // $output = '
     
     // <script src="https://www.google.com/recaptcha/api.js"></script>

     // <div style="display: flex; flex-direction: row; width: 100%; justify-content: center;">
     //      <div id="cta-container" style="display: flex !important; gap: 0.3rem; flex-direction: row !important; justify-content: center !important; align-items: center !important; width: 100% !important; max-width: 900px; height: 380px !important; background-color: #f2f3f5 !important; border-radius: 10px;">
     //           <div style="position: relative !important; width: 50% !important; height: 100% !important; display: flex !important; justify-content: center !important; align-items: center !important;">
     //                <img id="prevLogoCTA" src="' . esc_attr($atts['logo']) . '" style="z-index: 9 !important; width: 150px !important;">
     //                <img id="prevBackgroundImageCTA" src="' . esc_attr($atts['background_image']) . '" style="position: absolute !important; top: 0 !important; left: 0 !important; object-fit: cover !important; width: 100% !important; height: 100% !important; border-top-left-radius: 10px; border-bottom-left-radius: 10px;">
     //                <div id="overlay" style="position: absolute !important; top: 0 !important; left: 0 !important; width: 100% !important; height: 100% !important; background-color: ' . esc_attr($atts['overlay_color']) . ' !important; opacity: ' . esc_attr($atts['overlay_opacity']) . ' !important; border-top-left-radius: 10px; border-bottom-left-radius: 10px;"></div>
     //           </div>
     //           <div style="width: 50% !important; padding-right: 1rem; height: 100% !important; display: flex !important; flex-direction: column !important; align-items: center !important; justify-content: center !important; gap: 1rem !important;">
     //                <span id="prevTitleCTA" style="margin-left: 10px !important; margin-right: 10px !important; line-height: 2rem !important; font-size: 2rem !important; font-weight: 700 !important;">' . esc_attr($atts['title']) . '</span>
     //                <div style="display: flex !important; justify-content: space-between !important; width: 95% !important; margin-right: 10px !important; margin-left: 10px !important; gap: 0.5rem !important;">
     //                     <div style="display: flex !important; flex-direction: column !important; width: calc(50% - 1rem) !important;">
     //                          <label style="font-size: 16px !important; font-weight: 500 !important; margin-bottom: 5px !important; color: #333 !important;">Nombre:</label>
     //                          <input class="cta-input" placeholder="Nombre" type="text" id="name" name="name" value="" style="background-color: #e8e9eb !important; padding: 10px !important; border: none !important; font-size: 14px !important; color: #333 !important; width: cacl(100%-0.5rem) !important;">
     //                     </div>
     //                     <div style="display: flex !important; flex-direction: column !important; width: calc(50% - 1rem) !important;">
     //                          <label style="font-size: 16px !important; font-weight: 500 !important; margin-bottom: 5px !important; color: #333 !important;">Email:</label>
     //                          <input class="cta-input" placeholder="Email" type="email" id="email" name="email" value="" style="background-color: #e8e9eb !important; padding: 10px !important; border: none !important; font-size: 14px !important; color: #333 !important; width: cacl(100%-0.5rem) !important;">
     //                     </div>
     //                </div>
     //         <div class="g-recaptcha" data-sitekey="6LfB670qAAAAAF4IE-z-g7nvuO1jCb2gG0qMWCoZ"></div>
     //                <button class="cta-button" id="prevButtonCTA" style="padding: 0.7rem 1.2rem !important; cursor: pointer !important; border: none !important; border-radius: 5px !important; color: white !important; font-size: 1.2rem !important; font-weight: 600 !important; background-color: ' . esc_attr($atts['button_color']) . ' !important;">' . esc_attr($atts['button_title']) . '</button>
     //           </div>
     //      </div>

     //      <script>

     //           function getValidationRecaptcha() {
     //                const response = grecaptcha.getResponse();

     //                if(response.length == 0){
     //                     return false;
     //                }
     //                return true;
     //           }

     //           document.getElementById("prevButtonCTA").addEventListener("click", function() {
     //                const name = document.getElementById("name").value;
     //                const email = document.getElementById("email").value;

     //                if (!name || !email) {
     //                     return;
     //                }

     //                if(getValidationRecaptcha()){
                         
     //                     fetch("' . admin_url('admin-post.php') . '", {
     //                          method: "POST",
     //                          headers: {
     //                               "Content-Type": "application/json",
     //                          },
     //                          body: JSON.stringify({
     //                               action: "send_email",
     //                               name: name,
     //                               email: email,
     //                          }),
     //                     })
     //                     .then(response => response)
     //                     .then(data => {
     //                          console.log(data);
     //                     })
     //                     .catch(error => {
     //                          console.log(error);
     //                     });
     //                }
     //           });
     //      </script>
     // </div>
     // ';

     $output = '
          <script src="https://www.google.com/recaptcha/api.js"></script>

          <div style="display: flex; flex-direction: row; width: 100%; justify-content: center;">
               <div id="cta-container" style="display: flex !important; gap: 0.3rem; flex-direction: row !important; justify-content: center !important; align-items: center !important; width: 100% !important; max-width: 900px; height: 380px !important; background-color: #f2f3f5 !important; border-radius: 10px;">
                    <div style="position: relative !important; width: 50% !important; height: 100% !important; display: flex !important; justify-content: center !important; align-items: center !important;">
                         <img id="prevLogoCTA" src="' . esc_attr($atts['logo']) . '" style="z-index: 9 !important; width: 150px !important;">
                         <img id="prevBackgroundImageCTA" src="' . esc_attr($atts['background_image']) . '" style="position: absolute !important; top: 0 !important; left: 0 !important; object-fit: cover !important; width: 100% !important; height: 100% !important; border-top-left-radius: 10px; border-bottom-left-radius: 10px;">
                         <div id="overlay" style="position: absolute !important; top: 0 !important; left: 0 !important; width: 100% !important; height: 100% !important; background-color: ' . esc_attr($atts['overlay_color']) . ' !important; opacity: ' . esc_attr($atts['overlay_opacity']) . ' !important; border-top-left-radius: 10px; border-bottom-left-radius: 10px;"></div>
                    </div>
                    <div style="width: 50% !important; padding-right: 1rem; height: 100% !important; display: flex !important; flex-direction: column !important; align-items: center !important; justify-content: center !important; gap: 1rem !important;">
                         <span id="prevTitleCTA" style="margin-left: 10px !important; margin-right: 10px !important; line-height: 2rem !important; font-size: 2rem !important; font-weight: 700 !important;">' . esc_attr($atts['title']) . '</span>
                         <div style="display: flex !important; justify-content: space-between !important; width: 95% !important; margin-right: 10px !important; margin-left: 10px !important; gap: 0.5rem !important;">
                              <div style="display: flex !important; flex-direction: column !important; width: calc(50% - 1rem) !important;">
                                   <label style="font-size: 16px !important; font-weight: 500 !important; margin-bottom: 5px !important; color: #333 !important;">Nombre:</label>
                                   <input class="cta-input" placeholder="Nombre" type="text" id="name" name="name" value="" style="background-color: #e8e9eb !important; padding: 10px !important; border: none !important; font-size: 14px !important; color: #333 !important; width: calc(100%-0.5rem) !important;">
                              </div>
                              <div style="display: flex !important; flex-direction: column !important; width: calc(50% - 1rem) !important;">
                                   <label style="font-size: 16px !important; font-weight: 500 !important; margin-bottom: 5px !important; color: #333 !important;">Email:</label>
                                   <input class="cta-input" placeholder="Email" type="email" id="email" name="email" value="" style="background-color: #e8e9eb !important; padding: 10px !important; border: none !important; font-size: 14px !important; color: #333 !important; width: calc(100%-0.5rem) !important;">
                              </div>
                         </div>
                         <div class="g-recaptcha" data-sitekey="6LfB670qAAAAAF4IE-z-g7nvuO1jCb2gG0qMWCoZ" data-callback="onRecaptchaSuccess"></div>
                         <button class="cta-button" id="prevButtonCTA" disabled style="padding: 0.7rem 1.2rem !important; cursor: not-allowed !important; border: none !important; border-radius: 5px !important; color: white !important; font-size: 1.2rem !important; font-weight: 600 !important; background-color: #cccccc !important;">' . esc_attr($atts['button_title']) . '</button>
                    </div>
               </div>

               <script>
                    let recaptchaValidated = false;

                    function validateForm() {
                         const name = document.getElementById("name").value.trim();
                         const email = document.getElementById("email").value.trim();
                         const button = document.getElementById("prevButtonCTA");

                         if (name && email && recaptchaValidated) {
                              button.disabled = false;
                              button.style.cursor = "pointer";
                              button.style.backgroundColor = "' . esc_attr($atts['button_color']) . '";
                         } else {
                              button.disabled = true;
                              button.style.cursor = "not-allowed";
                              button.style.backgroundColor = "#cccccc";
                         }
                    }

                    document.getElementById("name").addEventListener("input", validateForm);
                    document.getElementById("email").addEventListener("input", validateForm);

                    function onRecaptchaSuccess() {
                         recaptchaValidated = true;
                         validateForm();
                    }

                    document.getElementById("prevButtonCTA").addEventListener("click", function() {
                         const name = document.getElementById("name").value;
                         const email = document.getElementById("email").value;

                         if (!name || !email) {
                              return;
                         }

                         fetch("http://localhost:4000/api/v1/plugin-wp/sendLead", {
                              method: "POST",
                              headers: {
                                   "Content-Type": "application/json",
                              },
                              body: JSON.stringify({
                                   userName: name,
                                   userEmail: email,
                                   userEmailSend: "' . esc_attr($atts['lead_email']) . '",
                              }),
                         })
                         .then(response => response)
                         .then(data => {
                              console.log(data);
                         })
                         .catch(error => {
                              console.log(error);
                         });
                    });
               </script>
          </div>

     ';

     return $output;
}
add_shortcode('custom_cta', 'custom_cta_shortcode');

function allow_custom_mime_types($mimes)
{
     $mimes['png'] = 'image/png'; // Permite archivos PNG
     return $mimes;
}
add_filter('upload_mimes', 'allow_custom_mime_types');
