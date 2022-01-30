<?php
$blogusers = get_users();
?>

<form id="climbing-card-form" method="" action="">
    <select name="users">
        <option value="" disabled selected>Odaberite e-karton</option>
        <?php foreach ($blogusers as $user) : ?>
            <?php if (empty($user->user_firstname) || empty($user->user_lastname)) : ?>
                <?php continue; ?>
            <?php endif; ?>
            <option value="<?php echo $user->ID; ?>"><?php echo $user->user_firstname . ' ' . $user->user_lastname; ?></option>';
        <?php endforeach; ?>
    </select>
    <input type="submit" class="pogledaj_karton" value="Pogledaj karton" />
    <?php if (is_user_logged_in()) : ?>
        <a class="button" href="/wp-admin/admin.php?page=climbingcard">Administriraj svoj e-karton</a>
    <?php endif; ?>
    <input type="text" id="table-filter" placeholder="<?php _e('Search', 'climbing-card'); ?>" />
</form>