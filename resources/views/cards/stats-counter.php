<?php defined('ABSPATH') || exit; ?>

<?php if (isset($stats) && !empty($stats)) : ?>
    <div class="club-stats-counters">
        <div class="widget-container">
            <div class="stats-counter">
                <h1 class="counter" data-type="numeric" data-start="0" data-end="<?php echo esc_attr_e($stats['total']); ?>" data-duration="200">0</h1>
                <p><?php esc_html_e("Ukupno smjerova", 'climbingcard'); ?></p>
            </div>
            <div class="stats-counter">
                <h1 class="counter" data-type="numeric" data-start="0" data-end="<?php echo esc_attr_e($stats['total_on_sight']); ?>" data-duration="200">0</h1>
                <p><?php esc_html_e("Ukupno On Sight", 'climbingcard'); ?></p>
            </div>
            <div class="stats-counter">
                <h1 class="counter" data-type="numeric" data-start="0" data-end="<?php echo esc_attr_e($stats['total_flash']); ?>" data-duration="200">0</h1>
                <p><?php esc_html_e("Ukupno Flash", 'climbingcard'); ?></p>
            </div>
            <div class="stats-counter">
                <h1 class="counter" data-type="numeric" data-start="0" data-end="<?php echo esc_attr_e($stats['total_red_point']); ?>" data-duration="200">0</h1>
                <p><?php esc_html_e("Ukupno Red Point", 'climbingcard'); ?></p>
            </div>
            <div class="stats-counter">
                <h1 class="counter" data-type="grade" data-start="0" data-end="<?php echo esc_attr_e($stats['biggest_grade']); ?>" data-duration="200">0</h1>
                <p><?php esc_html_e("Najveca Ocjena", 'climbingcard'); ?></p>
            </div>
            <div class="stats-counter">
                <h1 class="counter" data-type="grade" data-start="0" data-end="<?php echo esc_attr_e($stats['biggest_on_sight']); ?>" data-duration="200">0</h1>
                <p><?php esc_html_e("Najveca On Sight Ocjena", 'climbingcard'); ?></p>
            </div>
            <div class="stats-counter">
                <h1 class="counter" data-type="grade" data-start="0" data-end="<?php echo esc_attr_e($stats['biggest_flash']); ?>" data-duration="200">0</h1>
                <p><?php esc_html_e("Najveca Flash Ocjena", 'climbingcard'); ?></p>
            </div>
            <div class="stats-counter">
                <h1 class="counter" data-type="grade" data-start="0" data-end="<?php echo esc_attr_e($stats['biggest_red_point']); ?>" data-duration="200">0</h1>
                <p><?php esc_html_e("Najveca Red Point Ocjena", 'climbingcard'); ?></p>
            </div>
        </div>
    </div>
<?php endif; ?>