<?php
// Ensure this file is being included by a parent file
defined('ABSPATH') or die('Direct script access disallowed.');

// Function to display the registration form
function vt_classified_ads_registration_form() {
    ?>
    <form action="<?php echo esc_url($_SERVER['REQUEST_URI']); ?>" method="post">
        <p>
            <label for="username">Username <strong>*</strong></label>
            <input type="text" name="username" value="<?php echo isset($_POST['username']) ? esc_attr($_POST['username']) : ''; ?>" size="40" />
        </p>
        <p>
            <label for="email">Email <strong>*</strong></label>
            <input type="email" name="email" value="<?php echo isset($_POST['email']) ? esc_attr($_POST['email']) : ''; ?>" size="40" />
        </p>
        <p>
            <label for="password">Password <strong>*</strong></label>
            <input type="password" name="password" value="<?php echo isset($_POST['password']) ? esc_attr($_POST['password']) : ''; ?>" size="40" />
        </p>
        <p>
            <input type="submit" name="submit" value="Register"/>
        </p>
    </form>
    <?php
}

// Function to handle the form submission
function vt_classified_ads_registration_form_handler() {
    if (isset($_POST['submit'])) {
        $username = sanitize_user($_POST['username']);
        $email = sanitize_email($_POST['email']);
        $password = esc_attr($_POST['password']);

        $errors = new WP_Error();

        if (empty($username) || empty($email) || empty($password)) {
            $errors->add('field', 'Required form field is missing');
        }

        if (username_exists($username)) {
            $errors->add('username', 'Username already exists');
        }

        if (!is_email($email)) {
            $errors->add('email_invalid', 'Email is not valid');
        }

        if (email_exists($email)) {
            $errors->add('email', 'Email already exists');
        }

        if (is_wp_error($errors) && !empty($errors->get_error_messages())) {
            foreach ($errors->get_error_messages() as $error) {
                echo '<div>' . $error . '</div>';
            }
        } else {
            $user_id = wp_create_user($username, $password, $email);
            if (!is_wp_error($user_id)) {
                echo 'Registration complete. Please check your email.';
            } else {
                echo 'An error occurred: ' . $user_id->get_error_message();
            }
        }
    }
}

// Shortcode to display the registration form
function vt_classified_ads_registration_shortcode() {
    ob_start();
    vt_classified_ads_registration_form();
    vt_classified_ads_registration_form_handler();
    return ob_get_clean();
}

add_shortcode('vt_classified_ads_registration', 'vt_classified_ads_registration_shortcode');