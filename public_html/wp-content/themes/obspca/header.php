<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php wp_title( '|', true, 'right' ); ?></title>
  <link rel="profile" href="http://gmpg.org/xfn/11" />
  <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

  <!--[if lt IE 9]>
  <script src="<?php echo get_template_directory_uri(); ?>/bootstrap/js/html5shiv.js" type="text/javascript"></script>
  <![endif]-->

  <link href="<?php echo get_template_directory_uri(); ?>/bootstrap/css/bootstrap.css" rel="stylesheet" media="screen">
  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
  <div class="container">
    <div class="navbar navbar-fixed-top">
      <a class="navbar-brand" href="<?php echo esc_url(home_url('/')); ?>" 
         title="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>" 
         rel="home"><?php bloginfo('name'); ?></a>
      <?php wp_nav_menu(array( 'theme-location' => 'primary',
                               'container' => false,
                               'menu_class' => 'nav',
                               'walker' => new Bootstrap_Walker_Nav_Menu )); ?>
    </div>