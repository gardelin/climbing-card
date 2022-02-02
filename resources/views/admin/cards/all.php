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
                <?php foreach ($crags as $crag) : ?>
                    <tr>
                        <td><?php echo $crag->display_name; ?></td>
                        <td><span class="<?php echo str_replace(' ', '-', $crag->style);  ?>"></span><span><?php echo $crag->style; ?></span></td>
                        <td><?php echo $crag->comment; ?></td>
                        <td><?php echo $crag->climbedAt; ?></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>