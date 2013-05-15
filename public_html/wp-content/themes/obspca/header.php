<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php wp_title( '|', true, 'right' ); ?></title>
  <link rel="profile" href="http://gmpg.org/xfn/11" />
  <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

  <!--[if lt IE 9]>
  <script src="<?php echo get_template_directory_uri(); ?>/vendor/bootstrap/js/html5shiv.js" type="text/javascript"></script>
  <![endif]-->

  <link href="<?php echo get_template_directory_uri(); ?>/vendor/bootstrap/css/bootstrap.css" rel="stylesheet" media="screen">
  
  <!--[if lt IE 8]>
    <script src="<?php echo get_template_directory_uri(); ?>/vendor/livicons/js/json2.min.js"></script>
  <![endif]-->
  <script src="<?php echo get_template_directory_uri(); ?>/vendor/livicons/js/raphael-min.js"></script>
  <script src="<?php echo get_template_directory_uri(); ?>/vendor/livicons/js/livicons-1.1.1.min.js"></script>

  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
  <div class="navbar navbar-fixed-top">
    <a class="navbar-brand" href="<?php echo esc_url(home_url('/')); ?>" 
       title="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>" 
       rel="home">
      <div class="visible-phone">
        <?php bloginfo('name'); ?>
      </div>
      <div id="fixed_logo" class="hidden-phone">
        <img src="<?php echo get_template_directory_uri() ?>/images/navbar-logo.png" />
      </div>
    </a>

    <a class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </a>

    <div class="nav-collapse collapse navbar-responsive-collapse">
      <?php wp_nav_menu(array( 'theme-location' => 'primary',
                               'container' => false,
                               'menu_class' => 'nav',
                               'walker' => new Bootstrap_Walker_Nav_Menu )); ?>
    </div>
  </div>

  <div class="container">
    <div class="row">
      <div class="span12">
        <?php query_posts('category_name=announcements') ?>
        <?php while (have_posts()): the_post(); ?>
          <div class="alert alert-error">
            <strong><?php the_title() ?>:</strong>
            <?php echo esc_html(get_the_content()); ?>
          </div>
        <?php endwhile; ?>
        <?php wp_reset_query(); ?>

        <?php query_posts('category_name=information') ?>
        <?php while (have_posts()): the_post(); ?>
          <div class="alert alert-info">
            <strong><?php the_title() ?>:</strong>
            <?php echo esc_html(get_the_content()); ?>
          </div>
        <?php endwhile; ?>
        <?php wp_reset_query(); ?>
      </div><!-- .span12 -->
    </div><!-- .row -->
