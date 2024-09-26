<?php

if (!defined('WP_UNINSTALL_PLUGIN')) {
     die;
}

global $wpdb;
$table_name = $wpdb->prefix . 'atakx_config';

$wpdb->query("DROP TABLE IF EXISTS $table_name");
