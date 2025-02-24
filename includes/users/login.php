<?php
// Ensure this file is being included by a parent file
if (!defined('ABSPATH')) {
    exit;
}

// Function to display the login form
function vt_classified_ads_login_form() {
    if (is_user_logged_in()) {
        return '<p>You are already logged in.</p>';
    }

    ob_start(); ?>
    <form action="<?php echo esc_url(site_url('wp-login.php', 'login_post')); ?>" method="post">
        <p>
            <label for="user_login">Username</label>
            <input type="text" name="log" id="user_login" class="input" value="" size="20" />
        </p>
        <p>
            <label for="user_pass">Password</label>
            <input type="password" name="pwd" id="user_pass" class="input" value="" size="20" />
        </p>
        <p>
            <input type="submit" name="wp-submit" id="wp-submit" class="button button-primary" value="Log In" />
            <input type="hidden" name="redirect_to" value="<?php echo esc_url(home_url()); ?>" />
        </p>
    </form>
    <?php
    return ob_get_clean();
}

// Shortcode to display the login form
function vt_classified_ads_login_shortcode() {
    return vt_classified_ads_login_form();
}
add_shortcode('vt_login_form', 'vt_classified_ads_login_shortcode');