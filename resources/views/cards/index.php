<?php

$repo = new ClimbingCard\Repositories\Cards;

get_header();

?>

<main class="wrapper section-inner group" id="site-content">
    <div class="posts">
        <?php get_template_part( 'content', get_post_format() ); ?>	
        <div id="app"></div>
    </div><!-- .posts -->
</main><!-- .wrapper -->

<?php get_footer(); ?>