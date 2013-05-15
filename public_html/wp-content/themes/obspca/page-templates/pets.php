<?php 
/**
 * Template Name: Pets
 */

get_header(); ?>

<?php if ($_GET): ?>
  <?php query_pet($_GET); ?>
  <h1><?php the_pet_name(); ?></h1>
  </div><!-- .container -->
  <div class="container">
    <div class="row">
      <div class="span7 offset5">
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
DEBUGGING INFORMATION:
<?php the_pet_debug(); ?>
        </pre>
      </div>
<?php else: ?>
  <p>Illegal request.</p>
<?php endif; ?>

<?php get_footer(); ?>
