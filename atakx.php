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
include_once(plugin_dir_path(__FILE__) . 'generate-articles.php');
include_once(plugin_dir_path(__FILE__) . 'init-cron-generate-articles.php');

function atakx_activate_plugin()
{
     global $wpdb;
     $table_name_config = $wpdb->prefix . 'atakx_config';
     $table_name_CTA = $wpdb->prefix . 'atakx_config_cta';


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

wp_register_style('atakx', plugin_dir_url(__FILE__) . 'assets/css/atakx.css', array());
wp_enqueue_style('atakx');
