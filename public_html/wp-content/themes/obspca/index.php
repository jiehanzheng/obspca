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

  <?php //query_pets(); ?>
  <?php //query_pet(array("animalID" => "13809115")); ?>

  <div class="row">
    <div id="featured_pets" class="span4">
      <h2>Featured Pets</h2>
      <ul class="media-list">
        <?php query_posts('category_name=featured-pets') ?>
        <?php while (have_posts()): the_post(); ?>
          <li class="media">
            <?php query_pet(array("animalID" => get_the_title())); ?>
            <a class="pull-left" href="<?php echo esc_attr(get_the_pet_path()); ?>">
              <img src="<?php echo esc_attr(get_the_pet_image()); ?>" />
            </a>
            <div class="media-body">
              <h4>
                <a href="<?php echo esc_attr(get_the_pet_path()); ?>">
                  <?php the_pet_name(); ?>
                </a>
              </h4>
              <?php the_excerpt(); ?>
            </div>
          </li>
        <?php endwhile; ?>
      </ul>
      <?php wp_reset_query(); ?>
    </div>
    <div class="span5">
      <h2>News Feed</h2>
      <?php if ( have_posts() ) : ?>
        <?php /* Start the Loop */ ?>
        <?php while ( have_posts() ) : the_post(); ?>
          <?php get_template_part( 'content', get_post_format() ); ?>
        <?php endwhile; ?>
      <?php endif; // end have_posts() check ?>
    </div>
    <div class="span3">
      <div class="well">
        <p>Donation and stuff</p>
      </div>
    </div>
  </div>

<?php get_footer(); ?>
