<?php defined('ABSPATH') || exit; ?>

<div class="club-stats-counters">
    <h2 class="club-stats-counters-title"><?php _e('Statistika Kluba', 'climbing-card'); ?></h2>
    <div class="widget-container">
        <div class="stats-counter">
            <h1 class="counter" data-type="numeric" data-start="0" data-end="<?php echo $stats['total']; ?>" data-duration="200">0</h1>
            <p><?php _e("Ukupno smjerova", 'climbingcard'); ?></p>
        </div>
        <div class="stats-counter">
            <h1 class="counter" data-type="numeric" data-start="0" data-end="<?php echo $stats['total_on_sight']; ?>" data-duration="200">0</h1>
            <p><?php _e("Ukupno On Sight", 'climbingcard'); ?></p>
        </div>
        <div class="stats-counter">
            <h1 class="counter" data-type="numeric" data-start="0" data-end="<?php echo $stats['total_flash']; ?>" data-duration="200">0</h1>
            <p><?php _e("Ukupno Flash", 'climbingcard'); ?></p>
        </div>
        <div class="stats-counter">
            <h1 class="counter" data-type="numeric" data-start="0" data-end="<?php echo $stats['total_red_point']; ?>" data-duration="200">0</h1>
            <p><?php _e("Ukupno Red Point", 'climbingcard'); ?></p>
        </div>
        <div class="stats-counter">
            <h1 class="counter" data-type="grade" data-start="0" data-end="<?php echo $stats['biggest_grade']; ?>" data-duration="200">0</h1>
            <p><?php _e("Najveca ocijena", 'climbingcard'); ?></p>
        </div>
        <div class="stats-counter">
            <h1 class="counter" data-type="grade" data-start="0" data-end="<?php echo $stats['biggest_on_sight']; ?>" data-duration="200">0</h1>
            <p><?php _e("Najveca On Sight Ocijena", 'climbingcard'); ?></p>
        </div>
        <div class="stats-counter">
            <h1 class="counter" data-type="grade" data-start="0" data-end="<?php echo $stats['biggest_flash']; ?>" data-duration="200">0</h1>
            <p><?php _e("Najveca Flash Ocijena", 'climbingcard'); ?></p>
        </div>
        <div class="stats-counter">
            <h1 class="counter" data-type="grade" data-start="0" data-end="<?php echo $stats['biggest_red_point']; ?>" data-duration="200">0</h1>
            <p><?php _e("Najveca Red Point Ocijena", 'climbingcard'); ?></p>
        </div>
    </div>
</div>