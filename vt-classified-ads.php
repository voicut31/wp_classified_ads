<?php

/**
 * Plugin Name: VT Classified Ads
 * Plugin URI: https://www.voicu-tibea.ro/
 * Description: A plugin for managing classified ads.
 * Version: 1.0.0
 * Author: Voicu Tibea
 * Author URI: https://www.voicu-tibea.ro/
 **/

require_once(ABSPATH . 'wp-admin/includes/upgrade.php');


// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

define( 'VT_CLASSIFIED_ADS_VERSION', '1.0.0' );


/**
 * @throws Exception
 */
function vatads_install() {
    global $wpdb;
    global $vtads_db_version;

    // Define table names
    $ads_table_name = $wpdb->prefix . 'classified_ads';

    $charset_collate = $wpdb->get_charset_collate();

    // SQL for ads table
    $categories_table_name = $wpdb->prefix . 'classified_categories';
    
    $categories_sql = "CREATE TABLE $categories_table_name (
        `id` int NOT NULL AUTO_INCREMENT,
        `title` varchar(255) NOT NULL,
        `description` text,
        `slug` varchar(100) NOT NULL,
        `status` tinyint DEFAULT 1,
        `created_at` timestamp NULL DEFAULT NULL,
        `updated_at` timestamp NULL DEFAULT NULL,
        PRIMARY KEY (`id`)
    ) $charset_collate;";

    $ads_sql = "CREATE TABLE $ads_table_name (
        `id` int NOT NULL AUTO_INCREMENT,
        `title` varchar(255) NOT NULL,
        `slug` varchar(100) DEFAULT NULL,
        `description` text,
        `phone` varchar(25) DEFAULT NULL,
        `price` float DEFAULT NULL,
        `user_id` int NOT NULL,
        `type` tinyint DEFAULT NULL,
        `filename` varchar(255) DEFAULT NULL,
        `status` tinyint DEFAULT 1,
        `created_at` timestamp NULL DEFAULT NULL,
        `updated_at` timestamp NULL DEFAULT NULL,
        PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

    // Create or update tables
    dbDelta($ads_sql);

    add_option( 'vtads_db_version', $vtads_db_version );
}

function vatads_uninstall()
{
    global $wpdb;

    $ads_table_name = $wpdb->prefix . 'classified_ads';
    $ads_sql = "DROP TABLE IF EXISTS $ads_table_name;";
    $wpdb->query($ads_sql);
}

function head_code()
{

    $output = '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">';
    $output .= "\n";
    $output .= '<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>';

    echo $output;

}


add_action('wp_head','head_code');

register_activation_hook( __FILE__, 'vatads_install' );

register_deactivation_hook( __FILE__, 'vatads_uninstall' );

require_once 'functions.php';