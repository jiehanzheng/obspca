<?php get_header(); ?>

  <?php $obspca_first_header_image = true; ?>
  <?php query_posts('post_type=homepage-image') ?>
  <?php if (have_posts()) : ?>
    <div id="nice_pics" class="carousel slide hidden-xs" data-interval="10000">
      <div class="carousel-inner">
        <?php while (have_posts()) : the_post(); ?>
          <div class="item<?php if ($obspca_first_header_image) { echo ' active'; $obspca_first_header_image = false; } ?>">
            <?php the_content(); ?>
          </div>
        <?php endwhile; ?>
      </div>

<!--       <a class="left carousel-control" href="#nice_pics" data-slide="prev">
        <span class="icon-prev"></span>
      </a>
      <a class="right carousel-control" href="#nice_pics" data-slide="next">
        <span class="icon-next"></span>
      </a> -->
    </div>
  <?php endif; ?>
  <?php wp_reset_query(); ?>

  <div class="row">
    <div id="news" class="col-md-5 col-md-push-4">
      <h2>News Feed</h2>
      <?php if (have_posts()) : ?>
        <?php /* Start the Loop */ ?>
        <?php while (have_posts()) : the_post(); ?>
          <?php get_template_part('content'); ?>
        <?php endwhile; ?>
      <?php endif; // end have_posts() check ?>
    </div>
    <div id="left_main" class="col-md-4 col-md-pull-5">
      <div id="featured_pets">
        <h2>Pet of the Week</h2>
        <ul class="media-list">
          <?php query_posts('post_type=pet') ?>
          <?php while (have_posts()): the_post(); ?>
            <li class="media">
              <?php try { ?>
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
              <?php } catch (Exception $e) { ?>
                <div class="alert alert-danger">
                  <h4>WP-PetPoint error</h4>
                  <strong>An error occurred while fetching animalID #<?php the_title() ?> specified by post #<?php the_ID() ?>:</strong>
                  <?php echo $e->getMessage(); ?>
                </div>
              <?php } ?>
            </li>
          <?php endwhile; ?>
        </ul>
        <?php wp_reset_query(); ?>
      </div>

      <?php dynamic_sidebar('homepage-left'); ?>
    </div>
    <div id="donation_sidebar" class="col-md-3">
      <div class="row">
        <div id="help_us" class="col-md-12 col-sm-4">
          <div class="panel panel-info">
            <div class="panel-heading">We need your help</div>
            <div class="panel-body">
              <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_donations&amp;business=obspca@embarqmail.com&amp;item_name=General+donation" 
                 class="btn btn-block btn-lg btn-primary" 
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
            </div>
            <div class="panel-footer">
              <strong>Or mail your donation to:</strong>
              <address>
                1031 Driftwood Drive<br>
                PO Box 2477<br>
                Manteo, NC 27954<br>
              </address>
            </div>
          </div>
        </div>

        <div id="volunteering" class="col-md-12 col-sm-4">
          <div class="panel panel-default">
            <div class="panel-heading">Volunteering</div>
            <div class="panel-body">
              Become a volunteer!  We have a full time staff at the shelter but nothing pleases them more than to see the animals getting extra attention.  <a href="#dummy">Learn more</a>
            </div>
            <div class="panel-footer">
              <strong>Don&rsquo;t hesitate to contact us:</strong><br>
              (252) 475-5620<br>
              <a href="mailto:SPCAevents@embarqmail.com">SPCAevents@embarqmail.com</a>
            </div>
          </div>
        </div>

        <div id="social_networks" class="col-md-12 col-sm-4">
          <div class="panel panel-default">
            <div class="panel-heading">Follow OBSPCA</div>
            <div class="panel-body">
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
        </div>
      </div>
    </div><!-- sidebar .row -->
  </div><!-- .row -->

<?php get_footer(); ?>
