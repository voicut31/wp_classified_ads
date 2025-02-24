<?php
    if ($ad) {
        echo '<div class="wrap ads-plugin-admin-page">';
        echo '<h2>View Ad Details</h2>';
        echo '<p><strong>ID:</strong> ' . $ad->id . '</p>';
        echo '<p><strong>Name:</strong> ' . $ad->title . '</p>';
        echo '<p><strong>Content:</strong> ' . $ad->description . '</p>';
        echo '<p><strong>Price:</strong> ' . $ad->price . '</p>';
        echo '<p><a href="ads-page">Back to Ads List</a></p>';
        echo '</div>';
    } else {
        echo '<div class="wrap ads-plugin-admin-page">';
        echo '<p>Ad not found.</p>';
        echo '<p><a href="/ads-page/">Back to Ads List</a></p>';
        echo '</div>';
    }