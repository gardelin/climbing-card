<?php defined('ABSPATH') || exit; ?>

<?php if (isset($users) && !empty($users)) : ?>
    <div class="sidebar-widget top-users-by-number-of-climbed-routes">
        <div class="widget-container">
            <?php foreach ($users as $user) : ?>
                <div>
                    <a href="<?php echo esc_url($user['card_url']); ?>">
                        <?php echo esc_html($user['fullname']) . ": "; ?>
                    </a>
                    <strong><?php echo esc_html($user['total']); ?></strong>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>