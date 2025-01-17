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

     $overlayBorderRadius = '';
     $containerBorderRadius = '';
     if ($roundedBordersCTA) {
          $containerBorderRadius = 'border-radius: 10px;';
          $overlayBorderRadius = 'border-top-left-radius: 10px; border-bottom-left-radius: 10px;';
     }

     $ctaHtml = '[custom_cta background_image="' . $backgroundImageCTA . '" logo="' . $logoCTA . '" overlay_color="' . $overlayColor . '" overlay_opacity="' . $overlayOpacity . '" title="' . $titleCTA . '" button_title="' . $buttonTitleCTA . '" button_color="' . $buttonColorCTA . '" lead_email="' . $leadEmail . '" overlayBorderRadius="' . $overlayBorderRadius . '" containerBorderRadius="' . $containerBorderRadius . '"]';

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
