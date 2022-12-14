<?php get_header(); ?>
<div class="l-container">
    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
    <?php get_template_part( 'entry' ); ?>
    <?php if ( comments_open() && !post_password_required() ) { comments_template( '', true ); } ?>
    <?php endwhile; endif; ?>
</div>
<footer class="footer">
    <?php get_template_part( 'nav', 'below-single' ); ?>
</footer>
<?php get_footer(); ?>