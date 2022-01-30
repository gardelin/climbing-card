<?php defined('ABSPATH') || exit; ?>

<div class="last-climbed-routes">
    <div class="climbed-routes-container">
        <?php foreach ($journals as $journal) : ?>
            <div class="climbed-route ac">
                <div class="climbed-header ac-header ac-trigger">
                    <span><?php $user = get_user_by('login', $journal->userName);
                            echo $user->user_firstname . " " . $user->user_lastname; ?></span>
                    <div class="climbed-data">
                        <div><?php echo $journal->ocjena; ?></div>
                        <span class="dot <?php echo str_replace(" ", "-", $journal->nacin); ?> title=" <?php echo $journal->nacin; ?>"></span>
                    </div>
                </div>
                <div class="climbed-content ac-panel">
                    <span><?php printf(__('<strong>Smjer:</strong> %s', 'climbingcard'), $journal->smjer); ?></span>
                    <span><?php printf(__('<strong>Ocjena:</strong> %s', 'climbingcard'), $journal->ocjena); ?></span>
                    <span><?php printf(__('<strong>Penjalište:</strong> %s', 'climbingcard'), $journal->penjaliste); ?></span>
                    <span><?php printf(__('<strong>Način:</strong> %s', 'climbingcard'), $journal->nacin); ?></span>
                    <span><?php printf(__('<strong>Datum:</strong> %s', 'climbingcard'), $journal->datum); ?></span>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>