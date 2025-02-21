<?php

//$categories = get_categories();
//print_r($categories); die();

    $status = [
      'pending' => 1,
      'online' => 2,
      'offline' => 0,
    ];
?>
<ul class="subsubsub">
    <li class="all"><a href="/wp-admin/admin.php?page=vt-classified-ads" class="current" aria-current="page">All <span class="count">(1)</span></a> |</li>
    <li class="pending"><a href="/wp-admin/admin.php?page=vt-classified-ads&status=pending">Pending <span class="count">(1)</span></a></li>
    <li class="online"><a href="/wp-admin/admin.php?page=vt-classified-ads&status=online">Online <span class="count">(10)</span></a></li>
    <li class="offline"><a href="/wp-admin/admin.php?page=vt-classified-ads&status=offline">Offline <span class="count">(5)</span></a></li>
</ul>

    <div class="tablenav top">

        <div class="alignleft actions bulkactions">
            <label for="bulk-action-selector-top" class="screen-reader-text">Select bulk action</label><select name="action" id="bulk-action-selector-top">
                <option value="-1">Bulk actions</option>
                <option value="edit" class="hide-if-no-js">Edit</option>
                <option value="trash">Move to Trash</option>
            </select>
            <input type="submit" id="doaction" class="button action" value="Apply">
        </div>
        <div class="alignleft actions">
            <label for="filter-by-date" class="screen-reader-text">Filter by date</label>
            <select name="m" id="filter-by-date">
                <option selected="selected" value="0">All dates</option>
                <option value="202407">July 2024</option>
            </select>
            <label class="screen-reader-text" for="cat">Filter by category</label><select name="cat" id="cat" class="postform">
                <option value="0">All Categories</option>
                <option class="level-0" value="1">Uncategorized</option>
            </select>
            <input type="submit" name="filter_action" id="post-query-submit" class="button" value="Filter">		</div>
        <div class="tablenav-pages one-page"><span class="displaying-num">1 item</span>
            <span class="pagination-links"><span class="tablenav-pages-navspan button disabled" aria-hidden="true">«</span>
            <span class="tablenav-pages-navspan button disabled" aria-hidden="true">‹</span>
            <span class="paging-input"><label for="current-page-selector" class="screen-reader-text">Current Page</label><input class="current-page" id="current-page-selector" type="text" name="paged" value="1" size="1" aria-describedby="table-paging"><span class="tablenav-paging-text"> of <span class="total-pages">1</span></span></span>
            <span class="tablenav-pages-navspan button disabled" aria-hidden="true">›</span>
            <span class="tablenav-pages-navspan button disabled" aria-hidden="true">»</span></span></div>
        <br class="clear">
    </div>
<?php

global $wpdb;
$ads_table_name = $wpdb->prefix . 'classified_ads';

$ads_sql = "SELECT * FROM $ads_table_name ;";
$where = '';
$limit = '';

if (isset($_GET['status']) && in_array($_GET['status'], $status)) {
    $where = " WHERE status = " . $status[$_GET['status']];
}

if (isset($_GET['adspage'])) {
    $offset = $_GET['adspage'] * 20;
    $limit = " LIMIT " . $offset . ", " . ($offset + 20);
}

$ads_sql .= $where . $limit;

$records = $wpdb->get_results($ads_sql);

if (count($records) > 0) {
    require_once 'admin_list.php';
}
?>

<div class="tablenav bottom">
    <div class="alignleft actions bulkactions">
        <label for="bulk-action-selector-bottom" class="screen-reader-text">Select bulk action</label>
        <select name="action2" id="bulk-action-selector-bottom">
            <option value="-1">Bulk actions</option>
	        <option value="edit" class="hide-if-no-js">Edit</option>
	        <option value="trash">Move to Trash</option>
        </select>
        <input type="submit" id="doaction2" class="button action" value="Apply">
    </div>
    <div class="alignleft actions">
    </div>
    <div class="tablenav-pages one-page"><span class="displaying-num">1 item</span>
        <span class="pagination-links"><span class="tablenav-pages-navspan button disabled" aria-hidden="true">«</span>
        <span class="tablenav-pages-navspan button disabled" aria-hidden="true">‹</span>
        <span class="screen-reader-text">Current Page</span><span id="table-paging" class="paging-input"><span class="tablenav-paging-text">1 of <span class="total-pages">1</span></span></span>
        <span class="tablenav-pages-navspan button disabled" aria-hidden="true">›</span>
        <span class="tablenav-pages-navspan button disabled" aria-hidden="true">»</span></span>
    </div>
    <br class="clear">
</div>