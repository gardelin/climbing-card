<?php defined('ABSPATH') || exit; ?>

<div class="sidebar-widget club-stats">
    <h4><?php _e('Statistika kluba', 'climbingcard'); ?></h4>
    <div class="widget-container">
        <div><?php printf(__("Ukupno smjerova: <strong>%d</strong>", 'climbingcard'), $stats['total']); ?></div>
        <div><?php printf(__("Ukupno on sight: <strong>%d</strong>", 'climbingcard'), $stats['total_on_sight']); ?></div>
        <div><?php printf(__("Ukupno flash: <strong>%d</strong>", 'climbingcard'), $stats['total_flash']); ?></div>
        <div><?php printf(__("Ukupno red point: <strong>%d</strong>", 'climbingcard'), $stats['total_red_point']); ?></div>
        <div><?php printf(__("Najveći on sight: <strong>%s</strong>", 'climbingcard'), $stats['biggest_on_sight']); ?></div>
        <div><?php printf(__("Najveći flash: <strong>%s</strong>", 'climbingcard'), $stats['biggest_flash']); ?></div>
        <div><?php printf(__("Najveći red point: <strong>%s</strong>", 'climbingcard'), $stats['biggest_red_point']); ?></div>
    </div>
</div>