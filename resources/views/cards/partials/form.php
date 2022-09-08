<?php

$users = get_users();
$usersThatHavePublicClimbingCard = [];

foreach ($users as $user) {
    $isClimbingCardPublic = get_user_meta($user->ID, 'is_climbing_card_public', true);

    // User don't have meta key saved in database
    // In this scenario we will assume that user's
    // climbing card is public
    if ($isClimbingCardPublic == '')
        $isClimbingCardPublic = 'true';

    $isClimbingCardPublic = filter_var($isClimbingCardPublic, FILTER_VALIDATE_BOOLEAN);

    if ($isClimbingCardPublic)
        array_push($usersThatHavePublicClimbingCard, $user);
}

?>

<form id="climbing-card-form" method="" action="">
    <div>
        <select name="users">
            <option value="" disabled selected>Odaberite e-karton</option>
            <?php foreach ($usersThatHavePublicClimbingCard as $user) : ?>
                <?php if (empty($user->user_firstname) || empty($user->user_lastname)) : ?>
                    <?php continue; ?>
                <?php endif; ?>
                <option value="<?php echo esc_attr($user->ID); ?>"><?php echo esc_html($user->user_firstname . ' ' . $user->user_lastname); ?></option>';
            <?php endforeach; ?>
        </select>
        <input type="text" id="table-filter" placeholder="<?php esc_attr_e('Search', 'climbing-card'); ?>" />
    </div>
    <?php if (is_user_logged_in()) : ?>
        <a class="button" href="/wp-admin/admin.php?page=climbingcard">Administriraj svoj e-karton</a>
    <?php endif; ?>
</form>