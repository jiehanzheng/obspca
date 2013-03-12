<?php get_header(); ?>
</div><!-- container -->

<div id="nicePics" class="carousel slide hidden-phone">
  <div class="carousel-inner">
    <div class="item">
      <img src="http://placekitten.com/2400/600" alt="cats" />
    </div>
    <div class="item active">
      <img src="http://placedog.com/2400/600" alt="cats" />
    </div>
    <div class="item">
      <img src="http://placehold.it/2400x600" alt="cats" />
    </div>
  </div>

  <a class="left carousel-control" href="#nicePics" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left"></span>
  </a>
  <a class="right carousel-control" href="#nicePics" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right"></span>
  </a>
</div>

<div class="container">

  <div class="alert alert-error">
    <strong>Example announcement:</strong>
    This is not the official Outer anks SPCA website yet.
  </div>

  <div class="alert alert-info">
    Under construction.
  </div>

  <div class="row">
    <div class="span8">
      <h2>News</h2>
      <?php if ( have_posts() ) : ?>

        <?php /* Start the Loop */ ?>
        <?php while ( have_posts() ) : the_post(); ?>
          <?php get_template_part( 'content', get_post_format() ); ?>
        <?php endwhile; ?>

        <?php twentytwelve_content_nav( 'nav-below' ); ?>

      <?php else : ?>

        <p>Oops no posts were found</p>

      <?php endif; // end have_posts() check ?>
    </div>
    <div class="span4">
      <div class="well">
        <p>Donation and stuff</p>
      </div>
      <h2>Featured Pets</h2>
    </div>
  </div>

<?php get_footer(); ?>