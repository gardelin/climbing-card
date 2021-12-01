<?php

use function ClimbingCard\view;

$repo = new ClimbingCard\Repositories\Journals;

get_header();

?>

<main class="wrapper section-inner group" id="site-content">
    <div class="content center" style="width: 80%;">
        <div class="posts">
            <?php
            if (have_posts()) :
                while (have_posts()) : the_post();
                    get_template_part('content', get_post_type());
                    view('journal/partials/form');
                    view('journal/partials/table');
                endwhile;
            endif;
            ?>
        </div><!-- .posts -->
    </div><!-- .content -->
</main><!-- .wrapper -->

<?php get_footer(); ?>