<?php 
/**
 * Template Name: Pet
 */

// prepare pet info
if ($_GET) {
  try {
    ob_start();
    query_pet($_GET);
    $petpoint_api_debug = ob_get_contents();
    ob_end_clean();
  } catch (Exception $e) {
    wp_die($e->getMessage());
  }
} else {
  wp_die("Illegal request.");
}

get_header(); ?>

<div class="row">
  <div class="col">
    <h1><?php the_pet_name(); ?></h1>
  </div>
</div>
<div class="row"></div>
  <div id="pet_info" class="col<?php if(the_pet_has_images()) echo " col-lg-5 col-push-3" ?> ">
    <table class="table table-bordered table-hover">
      <caption>Learn more about <?php the_pet_name(); ?></caption>
      <tbody>
        <tr>
          <th>ID</th>
          <td><?php the_pet_id(); ?></td>
        </tr>
        <tr>
          <th>Species</th>
          <td>
            <?php the_pet_species(); ?>
            <span class="muted">
              (<?php the_pet_breed(); ?> &amp;
              <?php the_pet_secondary_breed(); ?>)
            </span>
          </td>
        </tr>
        <tr>
          <th>Color</th>
          <td>
            <?php the_pet_color(); ?>
            <?php if (trim(the_pet_secondary_color())): ?>
              <span class="muted">
                (&amp; <?php the_pet_secondary_color(); ?>)
              </span>
            <?php endif; ?>
          </td>
        </tr>
        <tr>
          <th>Sex</th>
          <td>
            <?php the_pet_sex(); ?>
          </td>
        </tr>
      </tbody>
    </table>
    <pre>
INTERNAL INFORMATION:
<?php echo esc_html($petpoint_api_debug) ?>

DEBUGGING INFORMATION:
<?php the_pet_debug(); ?>
    </pre>
  </div><!-- .col#pet_info -->
  <?php if (the_pet_has_images()): ?>
    <div id="pet_media" class="col col-lg-3 col-pull-5">
      <div id="pet_image" class="carousel slide">
        <div class="carousel-inner">
          <div class="item active">
            <img src="<?php esc_attr_e(get_the_pet_image()) ?>" alt="">
          </div>
          <?php if (get_the_pet_image2()): ?>
            <div class="item">
              <img src="<?php esc_attr_e(get_the_pet_image2()) ?>" alt="">
            </div>
          <?php endif; ?>
          <?php if (get_the_pet_image3()): ?>
            <div class="item">
              <img src="<?php esc_attr_e(get_the_pet_image3()) ?>" alt="">
            </div>
          <?php endif; ?>

        </div>

        <?php if (get_the_pet_image2()): ?>
          <a class="left carousel-control" href="#pet_image" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left"></span>
          </a>
          <a class="right carousel-control" href="#pet_image" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right"></span>
          </a>
        <?php endif; ?>
      </div>
    </div><!-- .col#pet_media -->
    <div id="adoption_info" class="col col-lg-4">
      <div class="panel panel-success">
        <div class="panel-heading">How to adopt <?php the_pet_name(); ?></div>
        <ul>
          <li>Step 1</li>
          <li>Step 2</li>
          <li>Step 3</li>
          <li>Step 4</li>
        </ul>
      </div>
    </div>
  <?php endif; ?>
</div><!-- .row -->

<?php get_footer(); ?>
