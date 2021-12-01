<?php defined('ABSPATH') || exit; ?>

<div class="last-climbed-routes">
    <?php foreach ($journals as $journal) : ?>
        <div class="climbed-route">
            <div class="climbed-header">
                <span><?php $user = get_user_by('login', $journal->userName);
                        echo $user->user_firstname . " " . $user->user_lastname; ?></span>
                <span class="dot <?php echo str_replace(" ", "-", $journal->nacin); ?> title=" <?php echo $journal->nacin; ?>"></span>
            </div>
            <div class="climbed-content">
                <span><?php echo $journal->smjer . " (" . $journal->ocjena . ')'; ?></span>
            </div>
        </div>
    <?php endforeach; ?>
</div>