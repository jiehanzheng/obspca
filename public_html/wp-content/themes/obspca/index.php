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
    <div class="span3">
      <h2>Featured Pets</h2>
      <?php query_pets(array("orderBy" => "ID")); ?>
      <?php while (have_pets()): the_pet(); ?>
        <a href="/pets?animalID=<?php echo the_pet_id() ?>">
          <img src="<?php echo the_pet_image() ?>" class="img-circle" alt="cats" />
        </a>
      <?php endwhile; ?>
    </div>
    <div class="span5">
      <?php if ( have_posts() ) : ?>
        <?php /* Start the Loop */ ?>
        <?php while ( have_posts() ) : the_post(); ?>
          <?php get_template_part( 'content', get_post_format() ); ?>
        <?php endwhile; ?>
      <?php endif; // end have_posts() check ?>
    </div>
    <div class="span4">
      <div class="well">
        <p>Donation and stuff</p>
      </div>
    </div>
  </div>

<?php get_footer(); ?>
