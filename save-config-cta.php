<?php

include_once(plugin_dir_path(__FILE__) . 'upload-images.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['titleCTA'])) {

     $overlayColor = $_POST['overlayColor'];
     $overlayOpacity = $_POST['overlayOpacity'];
     $titleCTA = $_POST['titleCTA'];
     $buttonTitleCTA = $_POST['buttonTitleCTA'];
     $buttonColorCTA = $_POST['buttonColorCTA'];
     $CTAFont = $_POST['CTAFont'];
     $leadEmail = $_POST['leadEmail'];
     $roundedBordersCTA = isset($_POST['roundedBordersCTA']) ? 1 : 0;

     $oldBg = $_POST['oldBg'];
     $oldLogo = $_POST['oldLogo'];

     global $wpdb;
     $table_name = $wpdb->prefix . 'atakx_config_cta';
     $data_exist = $wpdb->get_row("SELECT * FROM $table_name LIMIT 1");

     $logoCTA = $oldLogo;
     $backgroundImageCTA = $oldBg;

     if (!empty($_FILES['backgroundImageCTA']['name'])) {

          $backgroundImageCTA = atakx_handle_image_upload($_FILES['backgroundImageCTA'], $oldBg);
     }

     if (!empty($_FILES['logoCTA']['name'])) {

          $logoCTA = atakx_handle_image_upload($_FILES['logoCTA'], $oldLogo);
     }

     $ctaHtml = '<div id="cta-container" style="display: flex; flex-direction: row; justify-content: center; align-items: center; margin: 2rem; width: 900px; height: 380px; background-color: #f2f3f5;">
     <style>
          .cta-button:hover {
               -webkit-box-shadow: 0px 0px 4px 0px rgba(0, 0, 0, 0.6);
               -moz-box-shadow: 0px 0px 4px 0px rgba(0, 0, 0, 0.6);
               box-shadow: 0px 0px 4px 0px rgba(0, 0, 0, 0.6);
               transition: all 0.3s;
          }

          .cta-input[type="text"]:focus,
          .cta-input[type="email"]:focus {
               border: none;
               outline: none;
               box-shadow: none;
          }
     </style>
     <div style="position: relative; width: 50%; height: 100%; display: flex; justify-content: center; align-items: center;">
          <img id="prevLogoCTA" src="' . $logoCTA . '" style="z-index: 9; width: 150px;">
          <img id="prevBackgroundImageCTA" src="' . $backgroundImageCTA . '" style="position: absolute; top: 0; left: 0; object-fit: cover; width: 100%; height: 100%;">
          <div id="overlay" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;"></div>
     </div>
     <div style="width: 50%; height: 100%; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 1rem;">
          <span id="prevTitleCTA" style="margin-left: 10px; margin-right: 10px; line-height: 2.5rem; font-size: 2.5rem; font-weight: 700;"></span>
          <div style="display: flex; justify-content: space-between; width: 95%; margin-right: 10px; margin-left: 10px; gap: 10px;">
               <div style="display: flex; flex-direction: column; width: 50%;">
                    <label style="font-size: 16px; font-weight: 500; margin-bottom: 5px; color: #333;">Nombre:</label>
                    <input class="cta-input" placeholder="Nombre" type="text" id="name" name="name" value="" style="background-color: #e8e9eb; padding: 5px; border: none; font-size: 14px; color: #333; width: 100%;">
               </div>
               <div style="display: flex; flex-direction: column; width: 50%;">
                    <label style="font-size: 16px; font-weight: 500; margin-bottom: 5px; color: #333;">Correo electrónico:</label>
                    <input class="cta-input" placeholder="Correo electrónico" type="email" id="email" name="email" value="" style="background-color: #e8e9eb; padding: 5px; border: none; font-size: 14px; color: #333; width: 100%;">
               </div>
          </div>
          <button class="cta-button" id="prevButtonCTA" style="padding: 0.7rem 1.2rem; cursor: pointer; border: none; border-radius: 5px; color: white; font-size: 1.2rem; font-weight: 600;"></button>
     </div>
</div>';


     $message = "";

     if ($data_exist) {
          $wpdb->update(
               $table_name,
               array(
                    'id' => 0,
                    'background_image' => $backgroundImageCTA,
                    'overlay_color' => $overlayColor,
                    'overlay_opacity' => $overlayOpacity,
                    'title' => $titleCTA,
                    'button_title' => $buttonTitleCTA,
                    'button_color' => $buttonColorCTA,
                    'font' => $CTAFont,
                    'lead_email' => $leadEmail,
                    'logo' => $logoCTA,
                    'with_rounded_border' => $roundedBordersCTA,
                    'cta_html' => $ctaHtml,
               ),
               ['id' => $data_exist->id]
          );

          $message = "Correctly edited data";
     } else {
          $wpdb->insert(
               $table_name,
               array(
                    'id' => 0,
                    'background_image' => $backgroundImageCTA,
                    'overlay_color' => $overlayColor,
                    'overlay_opacity' => $overlayOpacity,
                    'title' => $titleCTA,
                    'button_title' => $buttonTitleCTA,
                    'button_color' => $buttonColorCTA,
                    'font' => $CTAFont,
                    'lead_email' => $leadEmail,
                    'logo' => $logoCTA,
                    'with_rounded_border' => $roundedBordersCTA,
                    'cta_html' => $ctaHtml,
               )
          );

          $message = "Data saved successfully";
     }

     $response = array('success' => true, 'message' => $message);
     echo json_encode($response);
     exit;
}
