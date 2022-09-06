<?php

namespace ClimbingCard\Providers;

/**
 * Handle wordpress registration system
 */
class Registration
{
    /**
     * Init changes on wordpress registration process
     * 
     * @return void
     */
    public static function init()
    {
        add_action('register_form', [new Registration, 'insertFieldsToRegistrationForm']);
        add_filter('registration_errors', [new Registration, 'errors'], 10, 3);
        add_action('user_register', [new Registration, 'save']);
    }

    /**
     * Append fields to wordpress registration form
     * 
     *  @return void
     */
    public function insertFieldsToRegistrationForm()
    {

        $first_name = !empty($_POST['first_name']) ? sanitize_text_field($_POST['first_name']) : '';
        $last_name = !empty($_POST['last_name']) ? sanitize_text_field($_POST['last_name']) : '';

?>
        <p>
            <label for="first_name"><?php esc_html_e('First Name', 'climbingcard') ?><br />
            <input type="text" name="first_name" id="first_name" class="input" value="<?php echo esc_attr($first_name); ?>" size="25" pattern="[a-zA-Z]+" /></label>
        </p>

        <p>
            <label for="last_name"><?php esc_html_e('Last Name', 'climbingcard') ?><br />
            <input type="text" name="last_name" id="last_name" class="input" value="<?php echo esc_attr($last_name); ?>" size="25" pattern="[a-zA-Z]+" /></label>
        </p>
<?php
    }

    /**
     * Handle wordpress registration form errors
     * 
     * @param WP_Error $errors
     * @param string $sanitized_user_login
     * @param string $user_email
     * @return WP_Error
     */
    public function errors($errors, $sanitized_user_login, $user_email)
    {
        $first_name = sanitize_text_field($_POST['first_name']);
        $last_name = sanitize_text_field($_POST['last_name']);

        if (empty($first_name)) {
            $errors->add('first_name_error', __('<strong>ERROR</strong>: You must include a first name.', 'climbingcard'));
        }

        if (empty($last_name)) {
            $errors->add('last_name_error', __('<strong>ERROR</strong>: You must include a last name.', 'climbingcard'));
        }

        if (!empty($first_name) && !preg_match("/^[a-zA-Z]+$/", $first_name)) {
            $errors->add('first_name_error', __('<strong>ERROR</strong>: You must use letters only for first name.', 'climbingcard'));
        }

        if (!empty($last_name) && !preg_match("/^[a-zA-Z]+$/", $last_name)) {
            $errors->add('last_name_error', __('<strong>ERROR</strong>: You must use letters only for last name.', 'climbingcard'));
        }

        return $errors;
    }

    /**
     * Save additional user data immediately after new user is created
     * 
     * @param int $userId
     * @return void
     */
    public function save($userId)
    {
        $first_name = sanitize_text_field($_POST['first_name']);
        $last_name = sanitize_text_field($_POST['last_name']);

        if (!empty($_POST['first_name'])) {
            update_user_meta($userId, 'first_name', $first_name);
        }

        if (!empty($_POST['last_name'])) {
            update_user_meta($userId, 'last_name', $last_name);
        }

        update_user_meta($userId, 'is_climbing_card_public', 'true');
    }
}
