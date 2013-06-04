<?php get_header(); ?>
</div><!-- container -->

<div id="nice_pics" class="carousel slide hidden-sm">
  <div class="carousel-inner">
    <div class="item">
      <img src="http://placekitten.com/2340/560" alt="cats" />
    </div>
    <div class="item active">
      <img src="http://placedog.com/2340/560" alt="cats" />
    </div>
    <div class="item">
      <img src="http://placehold.it/2340x560" alt="cats" />
    </div>
  </div>

  <a class="left carousel-control" href="#nice_pics" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left"></span>
  </a>
  <a class="right carousel-control" href="#nice_pics" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right"></span>
  </a>
</div>

<div class="container">
  <div class="row">
    <div id="news" class="col col-lg-5 col-push-4">
      <h2>News Feed</h2>
      <?php if ( have_posts() ) : ?>
        <?php /* Start the Loop */ ?>
        <?php while ( have_posts() ) : the_post(); ?>
          <?php get_template_part( 'content', get_post_format() ); ?>
        <?php endwhile; ?>
      <?php endif; // end have_posts() check ?>
    </div>
    <div id="featured_pets" class="col col-lg-4 col-pull-5">
      <h2>Adopt Pets</h2>
      <ul class="media-list">
        <?php query_posts('category_name=featured-pets') ?>
        <?php while (have_posts()): the_post(); ?>
          <li class="media">
            <?php query_pet(array("animalID" => get_the_title())); ?>
            <a class="pull-left" href="<?php echo esc_attr(get_the_pet_path()); ?>">
              <img src="<?php echo esc_attr(get_the_pet_image()); ?>"
                   class="img-thumbnail" />
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
    <div class="col col-lg-3">
      <div id="help_us" class="panel panel-info">
        <div class="panel-heading">We need your help</div>
        <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_donations&amp;business=obspca@embarqmail.com&amp;item_name=General+donation" 
           class="btn btn-block btn-large btn-primary" 
           target="_blank"
           title="PayPal and credit card donations">
          Donate via 
          <span class="livicon" 
                data-name="credit-card" 
                data-size="24" 
                data-color="#fff" 
                data-hovercolor="#fff"
                title="Credit card"></span>
          /
          <span class="livicon" 
                data-name="paypal" 
                data-size="24" 
                data-color="#fff" 
                data-hovercolor="#fff"
                title="PayPal"></span>
        </a>
        <ul class="list-group list-group-flush">
          <li class="list-group-item">
            <strong>Or mail your donation to:</strong>
            <address>
              1031 Driftwood Drive<br>
              PO Box 2477<br>
              Manteo, NC 27954<br>
            </address>
          </li>
        </ul>
      </div>

      <div id="social_networks" class="panel">
        <div class="panel-heading">Follow OBSPCA</div>
        <div class="row">
          <div class="col col-lg-4 col-sm-4">
            <a href="https://www.facebook.com/pages/Outer-Banks-SPCA/116792203297"
               title="Facebook"
               target="_blank">
              <span class="livicon" 
                    data-name="facebook-alt" 
                    data-size="48"></span>
            </a>
          </div>
          <div class="col col-lg-4 col-sm-4">
            <a href="https://twitter.com/obspca"
               title="Twitter"
               target="_blank">
              <span class="livicon" 
                    data-name="twitter-alt" 
                    data-size="48"></span>
            </a>
          </div>
          <div class="col col-lg-4 col-sm-4">
            <a href="https://www.facebook.com/pages/Outer-Banks-SPCA/116792203297"
               title="YouTube"
               target="_blank">
              <span class="livicon" 
                    data-name="youtube" 
                    data-size="48"></span>
            </a>
          </div>
        </div>
      </div>

    </div>
  </div><!-- .row -->

<?php get_footer(); ?>
