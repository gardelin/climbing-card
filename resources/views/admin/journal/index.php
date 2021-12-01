<?php

use function ClimbingCard\view;

$repo = new \ClimbingCard\Repositories\Journals;
$current_user = wp_get_current_user();
$korisnik = $current_user->user_login;
$siteurl = get_option('siteurl');

?>

<div class='wrap'>
    <?php echo '<h2>Ekarton ' . $current_user->user_firstname . ' ' . $current_user->user_lastname . "</h2>";

    $ekarton_karton_exist = $repo->ekarton_karton_exist($korisnik);

    if ($ekarton_karton_exist == 1) {
        view('admin/journal/admin_view');
    } else {
        view('admin/journal/prvi_smjer');
    }

    ?>
    <!-- enqueuing script here because including it via webpack wasn't working -->
    <script type='text/javascript' src='<?php echo $siteurl; ?>/wp-content/plugins/climbing-card/resources/assets/js/legacy/raphael.js'></script>
</div>