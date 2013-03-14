<?php 
/**
 * Template Name: Pets
 */

get_header(); ?>

<?php if ($_GET): ?>
  <?php query_pet($_GET); ?>
  <h1><?php echo the_pet_id(); ?></h1>
  <h1><?php echo the_pet_name(); ?></h1>
<?php else: ?>
  <p>Illegal request.</p>
<?php endif; ?>

<?php get_footer(); ?>
