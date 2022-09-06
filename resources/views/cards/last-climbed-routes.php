<?php defined('ABSPATH') || exit; ?>


<?php if (isset($cards) && !empty($cards)) : ?>
    <div class="last-climbed-routes">
        <div class="climbed-routes-container">
            <?php foreach ($cards as $card) : ?>
                <div class="climbed-route ac">
                    <div class="climbed-header ac-header ac-trigger">
                        <span>
                            <?php echo esc_html($card->user_fullname); ?>
                        </span>
                        <div class="info">
                            <?php if (isset($options['show-route-in-header']) && $options['show-route-in-header'] == 1) : ?>
                                <span><?php echo esc_html($card->route); ?></span>
                            <?php endif; ?>
                            <?php if (isset($options['show-date-in-header']) && $options['show-date-in-header'] == 1) : ?>
                                <span><?php echo esc_html($card->climbed_at); ?></span>
                            <?php endif; ?>
                            <div class="climbed-data">
                                <div><?php echo esc_html($card->grade); ?></div>
                                <span class="dot <?php echo esc_html(str_replace(" ", "-", $card->style)); ?>" title=" <?php echo esc_html($card->style); ?>"></span>
                            </div>
                        </div>
                    </div>
                    <div class="climbed-content ac-panel">
                        <span><?php esc_html(printf(__('<strong>Smjer:</strong> %s', 'climbingcard'), $card->route)); ?></span>
                        <span><?php esc_html(printf(__('<strong>Ocjena:</strong> %s', 'climbingcard'), $card->grade)); ?></span>
                        <span><?php esc_html(printf(__('<strong>Penjalište:</strong> %s', 'climbingcard'), $card->crag)); ?></span>
                        <span><?php esc_html(printf(__('<strong>Način:</strong> %s', 'climbingcard'), $card->style)); ?></span>
                        <span><?php esc_html(printf(__('<strong>Datum:</strong> %s', 'climbingcard'), $card->climbed_at)); ?></span>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>