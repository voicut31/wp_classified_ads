<?php

function print_vt_classified_ads()  {
    echo "<h1>Classified Ads</h1>";
    require_once 'admin/admin.php';
}

function vt_classified_ads_admin_menu()  {
    add_menu_page(
        'Classified Ads',
        'Classified Ads',
        'manage_options',
        'vt-classified-ads',
        'print_vt_classified_ads'
    );
}

function vtads_wordpress_plugin_form() {
    ob_start();
    require_once 'ad-form.php';
    return ob_get_clean();
}

function vtads_wordpress_plugin_list() {
    ob_start();
    require_once 'list.php';
    return ob_get_clean();
}


function vtads_wordpress_plugin_single() {
    global $wpdb;
    $table = $wpdb->prefix . 'classified_ads';

    $strKey = $_GET['ad'];

    // Fetch the ad details
    $ad = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table WHERE str_key LIKE '%s'", $strKey));

    ob_start();
    require_once 'ad-single.php';
    return ob_get_clean();
}

function vtads_load_more_scripts() {
    global $wpdb;
    global $wp_query;

    wp_enqueue_script('jquery');
    wp_register_script('vtads_loadmore',  plugins_url( '/js/vtadsloadmore.js', __FILE__ ), array('jquery'));

    $table = $wpdb->prefix . 'classified_ads';
    $recordsCount = $wpdb->get_results("SELECT count(id) as recordsNumber FROM $table");
    $pagesNumber = ($recordsCount[0]->recordsNumber % 10 === 0) ? $recordsCount[0]->recordsNumber / 10 : (int)($recordsCount[0]->recordsNumber / 10) + 1;

    wp_localize_script('vtads_loadmore', 'vtads_loadmore_params', array(
        'ajaxurl' => site_url() . '/wp-admin/admin-ajax.php', // WordPress AJAX
        'records' => json_encode( $wp_query->query_vars ),
        'current_page' => get_query_var( 'paged' ) ? get_query_var('paged') : 1,
        'max_page' => $pagesNumber
    ) );

    wp_enqueue_script('vtads_loadmore');
    wp_enqueue_style('ads-plugin-styles', plugins_url('css/vtads-styles.css', __FILE__ ));
}

function vtads_loadmore_ajax_handler(){
    global $wpdb;
    $pageRecordsNumber = 10;

    $page = $_POST['page'];
    $table = $wpdb->prefix . 'classified_ads';

    //Query for limit paging
    $limit = "LIMIT " . $pageRecordsNumber . " OFFSET " . ($page - 1) * $pageRecordsNumber;
    $sql = "SELECT id, str_key, title, description, price, filename FROM $table WHERE status = 2 " . $limit;

    $records = $wpdb->get_results($sql);

    print json_encode($records);
    die;
}


add_action('wp_ajax_loadmore', 'vtads_loadmore_ajax_handler');
add_action('wp_ajax_nopriv_loadmore', 'vtads_loadmore_ajax_handler');
add_action( 'wp_enqueue_scripts', 'vtads_load_more_scripts' );
add_action( 'admin_menu', 'vt_classified_ads_admin_menu' );

add_shortcode('vtads-plugin-form', 'vtads_wordpress_plugin_form');
add_shortcode('vtads-plugin-list', 'vtads_wordpress_plugin_list');
add_shortcode('vtads-plugin-single', 'vtads_wordpress_plugin_single');
