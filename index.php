 <?php 
    //   Template name: шаблон Главной
    get_header();   
 ?>

<main>
    <main>
    <?php
    if ( have_posts() ) :
        while ( have_posts() ) : the_post();
            the_content();
        endwhile;
    endif;
    ?>
</main>
</main>

<?php get_footer();?>