<?php

if (!defined('ABSPATH')) {
    exit;
}

use function ClimbingCard\view;

?>

<div id="climbingcard">
    <div class="wrapper">
        <table>
            <thead>
                <tr>
                    <th><?php _e("Climber", 'climbingcard'); ?></th>
                    <th><?php _e("Style", 'climbingcard'); ?></th>
                    <th><?php _e("Comment", 'climbingcard'); ?></th>
                    <th><?php _e("Date", 'climbingcard'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($journals as $journal) : ?>
                    <tr>
                        <td><?php echo $journal->display_name; ?></td>
                        <td><span class="<?php echo str_replace(' ', '-', $journal->style);  ?>"></span><span><?php echo $journal->style; ?></span></td>
                        <td><?php echo $journal->comment; ?></td>
                        <td><?php echo $journal->climbedAt; ?></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>