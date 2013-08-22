<?php
/**
 * The Template for displaying all single posts.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header(); ?>

  <div id="primary" class="col col-lg-9">
    <div id="content" role="main">
      <?php while ( have_posts() ) : the_post(); ?>
        <?php get_template_part( 'content', get_post_format() ); ?>
        <?php obspca_content_nav() ?>
        <ul class="pager">
          <li class="previous"><?php previous_post_link('%link', '<span class="meta-nav">' . _x('&larr;', 'Previous post link', 'obspca') . '</span> %title', true); ?></li>
          <li class="next"><?php next_post_link('%link', '%title <span class="meta-nav">' . _x('&rarr;', 'Next post link', 'obspca') . '</span>', true); ?></li>
        </ul><!-- .nav-single -->
      <?php endwhile; // end of the loop. ?>
    </div><!-- #content -->
  </div><!-- #primary -->

  <div id="sidebar" class="col col-lg-3">
    <?php get_sidebar(); ?>
  </div>

<?php get_footer(); ?>