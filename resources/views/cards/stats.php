<?php defined('ABSPATH') || exit; ?>

<?php if (isset($stats) && !empty($stats)) : ?>
    <div class="sidebar-widget club-stats">
        <div class="widget-container">
            <div><?php esc_html(printf(__("Ukupno smjerova: <strong>%d</strong>", 'climbingcard'), $stats['total'])); ?></div>
            <div><?php esc_html(printf(__("Ukupno on sight: <strong>%d</strong>", 'climbingcard'), $stats['total_on_sight'])); ?></div>
            <div><?php esc_html(printf(__("Ukupno flash: <strong>%d</strong>", 'climbingcard'), $stats['total_flash'])); ?></div>
            <div><?php esc_html(printf(__("Ukupno red point: <strong>%d</strong>", 'climbingcard'), $stats['total_red_point'])); ?></div>
            <div><?php esc_html(printf(__("Najveći on sight: <strong>%s</strong>", 'climbingcard'), $stats['biggest_on_sight'])); ?></div>
            <div><?php esc_html(printf(__("Najveći flash: <strong>%s</strong>", 'climbingcard'), $stats['biggest_flash'])); ?></div>
            <div><?php esc_html(printf(__("Najveći red point: <strong>%s</strong>", 'climbingcard'), $stats['biggest_red_point'])); ?></div>
        </div>
    </div>
<?php endif; ?>