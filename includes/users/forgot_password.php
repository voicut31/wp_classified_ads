<?php
// Shortcode for forgot password form
function vt_forgot_password_form() {
    ob_start();
    ?>
    <form id="forgot-password-form" method="post" action="">
        <p>
            <label for="user_email">Email Address</label>
            <input type="email" name="user_email" id="user_email" required>
        </p>
        <p>
            <input type="submit" name="submit" value="Reset Password">
        </p>
    </form>
    <?php
    return ob_get_clean();
}
add_shortcode('vt_forgot_password', 'vt_forgot_password_form');

// Handle form submission
function vt_handle_forgot_password() {
    if (isset($_POST['submit'])) {
        $user_email = sanitize_email($_POST['user_email']);
        if (!is_email($user_email)) {
            echo '<p>Invalid email address.</p>';
            return;
        }

        $user = get_user_by('email', $user_email);
        if (!$user) {
            echo '<p>No user found with this email address.</p>';
            return;
        }

        // Generate reset key and URL
        $reset_key = get_password_reset_key($user);
        $reset_url = network_site_url("wp-login.php?action=rp&key=$reset_key&login=" . rawurlencode($user->user_login), 'login');

        // Send reset email
        $message = "To reset your password, visit the following address:\n\n";
        $message .= $reset_url;
        wp_mail($user_email, 'Password Reset', $message);

        echo '<p>Check your email for the confirmation link.</p>';
    }
}
add_action('init', 'vt_handle_forgot_password');
?>