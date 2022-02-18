<?php defined('ABSPATH') || exit; ?>

<?php if (isset($users) && !empty($users)) : ?>
    <div class="sidebar-widget top-users-by-number-of-climbed-routes">
        <h4><?php _e('Top 10 e-kartona po broju popetih smjerova', 'climbingcard'); ?></h4>
        <div class="widget-container">
            <?php foreach ($users as $user) : ?>
                <div><?php echo $user['fullname'] . ": "; ?><strong><?php echo $user['total']; ?></strong></div>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>