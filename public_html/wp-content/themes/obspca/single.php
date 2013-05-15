<?php
/**
 * The Template for displaying all single posts.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header(); ?>

  <div id="primary" class="span9 site-content">
    <div id="content" role="main">
      <?php while ( have_posts() ) : the_post(); ?>
        <?php get_template_part( 'content', get_post_format() ); ?>
        <nav class="nav-single">
          <span class="nav-previous"><?php previous_post_link( '%link', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'twentytwelve' ) . '</span> %title', true ); ?></span>
          <span class="nav-next"><?php next_post_link( '%link', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'twentytwelve' ) . '</span>', true ); ?></span>
        </nav><!-- .nav-single -->
        <?php comments_template( '', true ); ?>
      <?php endwhile; // end of the loop. ?>
    </div><!-- #content -->
  </div><!-- #primary -->

  <div id="sidebar" class="span3">
    <?php get_sidebar(); ?>
  </div>

<?php get_footer(); ?>