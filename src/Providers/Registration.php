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

        $first_name = (!empty($_POST['first_name'])) ? trim($_POST['first_name']) : '';
        $last_name = (!empty($_POST['last_name'])) ? trim($_POST['last_name']) : '';

?>
        <p>
            <label for="first_name"><?php _e('First Name', 'climbingcard') ?><br />
                <input type="text" name="first_name" id="first_name" class="input" value="<?php echo esc_attr(wp_unslash($first_name)); ?>" size="25" /></label>
        </p>

        <p>
            <label for="last_name"><?php _e('Last Name', 'climbingcard') ?><br />
                <input type="text" name="last_name" id="last_name" class="input" value="<?php echo esc_attr(wp_unslash($last_name)); ?>" size="25" /></label>
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
        if (empty($_POST['first_name']) || !empty($_POST['first_name']) && trim($_POST['first_name']) == '') {
            $errors->add('first_name_error', __('<strong>ERROR</strong>: You must include a first name.', 'climbingcard'));
        }

        if (empty($_POST['last_name']) || !empty($_POST['last_name']) && trim($_POST['last_name']) == '') {
            $errors->add('last_name_error', __('<strong>ERROR</strong>: You must include a last name.', 'climbingcard'));
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
        if (!empty($_POST['first_name'])) {
            update_user_meta($userId, 'first_name', trim($_POST['first_name']));
        }

        if (!empty($_POST['last_name'])) {
            update_user_meta($userId, 'last_name', trim($_POST['last_name']));
        }

        update_user_meta($userId, 'is_climbing_card_public', 'true');
    }
}
