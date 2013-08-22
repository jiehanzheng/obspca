<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
  <header class="entry-header">
    <?php the_post_thumbnail(); ?>
    <?php if ( is_single() ) : ?>
      <h2 class="entry-title"><?php the_title(); ?></h2>
    <?php else : ?>
      <h3 class="entry-title">
        <a href="<?php the_permalink(); ?>" title="<?php echo esc_attr(sprintf('Permalink to %s', the_title_attribute('echo=0'))); ?>" rel="bookmark"><?php the_title(); ?></a>
      </h3>
    <?php endif; // is_single() ?>
  </header><!-- .entry-header -->

  <?php if ( is_search() || is_home() ) : // Only display Excerpts for Search and Home ?>
  <div class="entry-summary">
    <time pubdate class="time_elapsed"
          datetime="<?php esc_attr_e(get_the_time('Y-m-d g:i')); ?>"
          title="<?php esc_attr_e(get_the_time('Y-m-d g:i')); ?>">
      <?php echo obspca_get_time_elapsed_string(get_the_time('U')) ?> ago &mdash;
    </time>
    <?php the_excerpt(); ?>
  </div><!-- .entry-summary -->
  <?php else : ?>
    <div class="entry-content">
      <?php the_content('Continue reading <span class="meta-nav">&rarr;</span>'); ?>
      <?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'twentytwelve' ), 'after' => '</div>' ) ); ?>
    </div><!-- .entry-content -->
  <?php endif; ?>

  <?php if ( ! is_home() ) : ?>
    <footer class="entry-meta">
      <?php obspca_entry_meta(); ?>
      <?php edit_post_link('Edit', '<span class="edit-link">', '</span>'); ?>
    </footer><!-- .entry-meta -->
  <?php endif; ?>
</article><!-- #post -->
