<?php
/**
 * NOTE - unclosed tags:
 *  div.container
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php wp_title( '|', true, 'right' ); ?></title>
  <link rel="profile" href="http://gmpg.org/xfn/11" />
  <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

  <!--[if lt IE 9]><script src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.6.2/html5shiv.min.js" type="text/javascript"></script><![endif]-->
  <!--[if lt IE 8]><script src="<?php echo get_template_directory_uri(); ?>/vendor/livicons/js/json2.min.js"></script><![endif]-->
  
  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

  <div class="container">
    <div id="logo_row" class="row">
      <header id="top_logo_area" class="col-sm-5 col-md-3 col-xs-6">
        <h1>
          <a href="<?php echo esc_url(home_url('/')); ?>" title="Home">
            <img src="<?php echo get_template_directory_uri() ?>/images/header_logo.png"
                 alt="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>" />
          </a>
        </h1>
      </header>

      <div class="clearfix visible-xs"></div>

      <div id="important_info_area" class="col-sm-5 col-sm-push-2 col-md-4 col-md-push-5">
        <div class="panel-group" id="quick_refs">
          <div class="panel panel-warning">
            <div class="panel-heading">
              <h4 class="panel-title">
                <span class="glyphicon glyphicon-earphone"></span>
                <a class="quick_refs-toggle" data-toggle="collapse" data-parent="#quick_refs" href="#emergency">
                  OBSPCA emergency service
                </a>
              </h4>
            </div>

            <div id="emergency" class="panel-collapse collapse">
              <div class="panel-body">
                <p>The Dare County Animal Shelter provides care of stray and unwanted animals, cruelty investigation, injured animal rescue, euthanasia of sick, injured and unplaceable animals, response to animal-nuisance complaints, response to animal bites, rabies control, and humane education.</p>
                <p>If you have an animal-related emergency after our normal business hours, please call:</p>
                <p class="lead">1-888-876-5942</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div id="navbar_row">
      <nav class="navbar navbar-default" role="navigation">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-not-important">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
        </div>
        <div class="collapse navbar-collapse navbar-not-important">
          <?php wp_nav_menu(array( 'theme-location' => 'primary',
                                   'container' => false,
                                   'menu_class' => 'nav navbar-nav',
                                   'walker' => new Bootstrap_Walker_Nav_Menu )); ?>
          <form role="search" method="get" class="navbar-form navbar-right" action="<?php echo esc_url( home_url( '/' ) ) ?>">
            <div class="form-group">
              <input type="search" class="form-control" placeholder="Search &hellip;" value="<?php echo esc_attr_e(get_search_query()) ?>" name="s" />
            </div>
            <button type="submit" class="btn btn-default">Go</button>
          </form>
        </div>
      </nav>
    </div>

    <div id="announcements">
      <?php query_posts('category_name=announcements') ?>
      <?php while (have_posts()): the_post(); ?>
        <div class="alert alert-danger">
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
    </div><!-- #announcements -->
