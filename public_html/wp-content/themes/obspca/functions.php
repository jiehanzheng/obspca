<?php

/**
 * Sets up the content width value based on the theme's design and stylesheet.
 */
if (!isset($content_width))
  $content_width = 625;


add_action('admin_init', 'obspca_install_categories');
function obspca_install_categories() {
  // announcements
  wp_create_term('Announcements', 'announcement-category');
  wp_create_term('Information', 'announcement-category');
}


add_action('init', 'obspca_register_post_types');
function obspca_register_post_types() {
  // pets
  register_post_type('pet',
    array('labels' => array('name'          => 'Pets',
                            'singular_name' => "Pet"),
          'description' => 'Objects to store ID links to PetPoint.',
          'public' => false,
          'show_ui' => true));

  // homepage featured image
  register_post_type('homepage-image',
    array('labels' => array('name'          => 'Homepage Images',
                            'singular_name' => "Homepage Image"),
          'description' => 'Images for homepage slider.',
          'public' => false,
          'show_ui' => true,
          'supports' => array('post-formats', 'editor', 'title') ));

  // announcements
  register_taxonomy('announcement-category', null,
    array('hierarchical' => true));

  register_post_type('announcements',
    array('labels' => array('name'          => 'Announcements',
                            'singular_name' => "Announcement"),
          'description' => 'Site-wide announcements.',
          'public' => false,
          'show_ui' => true,
          'taxonomies' => array('announcement-category') ));
}


/**
 * Sets up theme defaults and registers the various WordPress features.
 */
function obspca_setup() {
  // Adds RSS feed links to <head> for posts and comments.
  add_theme_support('automatic-feed-links');

  // Post formats
  add_theme_support('post-formats', array('image'));

  // This theme uses wp_nav_menu() in one location.
  register_nav_menu('primary', 'Global Navbar');

  // Featured image support for homepage slider
  add_theme_support('post-thumbnails'); 
}
add_action('after_setup_theme', 'obspca_setup');


/**
 * Enqueues scripts and styles for front-end.
 */
function obspca_scripts_styles() {
  /*
   * Loads our main stylesheet
   */
  wp_enqueue_style('bootstrap', get_template_directory_uri() . '/vendor/bootstrap/css/bootstrap.css');
  wp_enqueue_style('obspca-style', get_stylesheet_uri());

  /*
   * Main JS
   */
  wp_enqueue_script('obspca-header', get_template_directory_uri() . '/js/header.js');

  /*
   * Bootstrap components
   */
  wp_enqueue_script('jquery');
  wp_enqueue_script('raphael', get_template_directory_uri() . '/vendor/livicons/js/raphael-min.js');
  wp_enqueue_script('livicons', get_template_directory_uri() . '/vendor/livicons/js/livicons-1.2.min.js', array('raphael', 'jquery'));
  wp_enqueue_script('bootstrap', get_template_directory_uri() . '/vendor/bootstrap/js/bootstrap.min.js');

  /*
   * Page-specific JS
   */
  if (is_home()) {

    wp_enqueue_script('obspca-home', get_template_directory_uri() . '/js/home.js');
  }
  
}
add_action( 'wp_enqueue_scripts', 'obspca_scripts_styles' );


/**
 * Alter the main loop on homepage to make it get News only
 */
function obspca_alter_homepage_query($query) {
  if ( $query->is_home() && $query->is_main_query() ) {
    $query->set('category_name', 'news');
  }
}
add_action('pre_get_posts', 'obspca_alter_homepage_query');


/**
 * Creates a nicely formatted and more specific title element text
 * for output in head of document, based on current view.
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string Filtered title.
 */
function obspca_wp_title( $title, $sep ) {
  global $paged, $page;

  if ( is_feed() )
    return $title;

  // Add the site name.
  $title .= get_bloginfo( 'name' );

  // Add the site description for the home/front page.
  $site_description = get_bloginfo( 'description', 'display' );
  if ( $site_description && ( is_home() || is_front_page() ) )
    $title = "$title $sep $site_description";

  // Add a page number if necessary.
  if ( $paged >= 2 || $page >= 2 )
    $title = "$title $sep " . sprintf('Page %s', max( $paged, $page ) );

  return $title;
}
add_filter( 'wp_title', 'obspca_wp_title', 10, 2 );

/**
 * Registers our main widget area and the front page widget areas.
 */
function obspca_widgets_init() {
  register_sidebar(array(
    'name' => 'Main Sidebar',
    'id' => 'sidebar-1',
    'description' => 'Appears on posts and pages',
    'before_widget' => '<aside id="%1$s" class="widget %2$s">',
    'after_widget' => '</aside>',
    'before_title' => '<h3 class="widget-title">',
    'after_title' => '</h3>',
  ));

  register_sidebar(array(
    'name' => 'Homepage Left',
    'id' => 'homepage-left',
    'before_widget' => '<aside id="%1$s" class="widget %2$s">',
    'after_widget' => '</aside>',
    'before_title' => '<h2 class="widget-title">',
    'after_title' => '</h2>',
  ));

  register_sidebar(array(
    'name' => 'Homepage Right',
    'id' => 'homepage-right',
    'before_widget' => '<aside id="%1$s" class="widget %2$s">',
    'after_widget' => '</aside>',
    'before_title' => '<h2 class="widget-title">',
    'after_title' => '</h2>',
  ));
}
add_action( 'widgets_init', 'obspca_widgets_init' );


/**
 * Return relative time in human-readable form
 *
 * Taken from http://www.zachstronaut.com/posts/2009/01/20/php-relative-date-time-string.html
 */
function obspca_get_time_elapsed_string($ptime) {
  $etime = time() - $ptime;
  
  if ($etime < 1) {
    return '0 seconds';
  }
  
  $a = array( 12 * 30 * 24 * 60 * 60  =>  'year',
              30 * 24 * 60 * 60       =>  'month',
              24 * 60 * 60            =>  'day',
              60 * 60                 =>  'hour',
              60                      =>  'minute',
              1                       =>  'second' );
  
  foreach ($a as $secs => $str) {
    $d = $etime / $secs;
    if ($d >= 1) {
      $r = round($d);
      return $r . ' ' . $str . ($r > 1 ? 's' : '');
    }
  }
}


function obspca_entry_meta() {
  // Translators: used between list items, there is a space after the comma.
  $categories_list = get_the_category_list( __( ', ', 'twentytwelve' ) );

  // Translators: used between list items, there is a space after the comma.
  $tag_list = get_the_tag_list( '', __( ', ', 'twentytwelve' ) );

  $date = sprintf( '<a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s">%4$s</time></a>',
    esc_url( get_permalink() ),
    esc_attr( get_the_time() ),
    esc_attr( get_the_date( 'c' ) ),
    esc_html( get_the_date() )
  );

  $author = sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></span>',
    esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
    esc_attr( sprintf( __( 'View all posts by %s', 'twentytwelve' ), get_the_author() ) ),
    get_the_author()
  );

  // Translators: 1 is category, 2 is tag, 3 is the date and 4 is the author's name.
  if ( $tag_list ) {
    $utility_text = __( 'This entry was posted in %1$s and tagged %2$s on %3$s<span class="by-author"> by %4$s</span>.', 'twentytwelve' );
  } elseif ( $categories_list ) {
    $utility_text = __( 'This entry was posted in %1$s on %3$s<span class="by-author"> by %4$s</span>.', 'twentytwelve' );
  } else {
    $utility_text = __( 'This entry was posted on %3$s<span class="by-author"> by %4$s</span>.', 'twentytwelve' );
  }

  printf(
    $utility_text,
    $categories_list,
    $tag_list,
    $date,
    $author
  );
}


class Bootstrap_Walker_Nav_Menu extends Walker_Nav_Menu {
  /**
   * @see Walker::start_lvl()
   *
   * @param string $output Passed by reference. Used to append additional content.
   * @param int $depth Depth of page. Used for padding.
   */
  function start_lvl( &$output, $depth = 0, $args = array() ) {
    $indent = str_repeat("\t", $depth);

    // JIEHAN'S CHANGE:
    //   RENAME THE CLASS TO FIT BOOTSTRAP'S NAMING CONVENTION
    $output .= "\n$indent<ul class=\"dropdown-menu\">\n";
  }

  /**
   * @see Walker::start_el()
   *
   * @param string $output Passed by reference. Used to append additional content.
   * @param object $item Menu item data object.
   * @param int $depth Depth of menu item. Used for padding.
   * @param int $current_page Menu item ID.
   * @param object $args
   */
  function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
    $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

    $class_names = $value = '';

    $classes = empty( $item->classes ) ? array() : (array) $item->classes;
    $classes[] = 'menu-item-' . $item->ID;
    // JIEHAN'S CHANGE:
    if ($args->has_children)
      $classes[] = 'dropdown';

    $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
    $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

    $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
    $id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

    $output .= $indent . '<li' . $id . $value . $class_names . '>';

    $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
    $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
    $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
    $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';

    // JIEHAN'S CHANGE:
    if ($args->has_children)
      $attributes .= ' class="dropdown-toggle"' . ' data-toggle="dropdown"';

    $item_output = $args->before;
    $item_output .= '<a'. $attributes .'>';
    $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
    // JIEHAN'S CHANGE:
    //   ADD A CARET WHEN THERE'S A DROPDOWN MENU
    if ($args->has_children)
      $item_output .= ' <b class="caret"></b>';
    $item_output .= '</a>';
    $item_output .= $args->after;

    $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
  }

  /**
   * Traverse elements to create list from elements.
   *
   * Display one element if the element doesn't have any children otherwise,
   * display the element and its children. Will only traverse up to the max
   * depth and no ignore elements under that depth. It is possible to set the
   * max depth to include all depths, see walk() method.
   *
   * This method shouldn't be called directly, use the walk() method instead.
   *
   * @param object $element Data object
   * @param array $children_elements List of elements to continue traversing.
   * @param int $max_depth Max depth to traverse.
   * @param int $depth Depth of current element.
   * @param array $args
   * @param string $output Passed by reference. Used to append additional content.
   * @return null Null on failure with no changes to parameters.
   */
  function display_element( $element, &$children_elements, $max_depth, $depth=0, $args, &$output ) {

    if ( !$element )
      return;

    $id_field = $this->db_fields['id'];

    // JIEHAN'S CHANGE:
    //   ALWAYS SET has_children SO THAT WE KNOW WHEN TO ADD DATA-TOGGLE
    $args[0]->has_children = ! empty( $children_elements[$element->$id_field] );
    $cb_args = array_merge( array(&$output, $element, $depth), $args);
    call_user_func_array(array($this, 'start_el'), $cb_args);

    $id = $element->$id_field;

    // descend only when the depth is right and there are childrens for this element
    if ( ($max_depth == 0 || $max_depth > $depth+1 ) && isset( $children_elements[$id]) ) {

      foreach( $children_elements[ $id ] as $child ){

        if ( !isset($newlevel) ) {
          $newlevel = true;
          //start the child delimiter
          $cb_args = array_merge( array(&$output, $depth), $args);
          call_user_func_array(array($this, 'start_lvl'), $cb_args);
        }
        $this->display_element( $child, $children_elements, $max_depth, $depth + 1, $args, $output );
      }
      unset( $children_elements[ $id ] );
    }

    if ( isset($newlevel) && $newlevel ){
      //end the child delimiter
      $cb_args = array_merge( array(&$output, $depth), $args);
      call_user_func_array(array($this, 'end_lvl'), $cb_args);
    }

    //end this element
    $cb_args = array_merge( array(&$output, $element, $depth), $args);
    call_user_func_array(array($this, 'end_el'), $cb_args);
  }
}

add_action('current_screen', 'obspca_add_help_tabs');
function obspca_add_help_tabs() {
  $obspca_help = '<p>' . "Several things are critical in making sure that your special posts will be recognized by my code and will be used correctly without breaking the site.  Please pay special attention to the following formatting and categories requirements." . '</p>' .
    '<p>' . "<strong>Homepage featured image</strong> - select category &ldquo;Homepage banner image&rdquo;.  Then, find &ldquo;Featured image&rdquo; meta box below, and &ldquo;Set featured image&rdquo; to a 2340x560 image.  After you are done, use &ldquo;Preview&rdquo; to see it live.  You must resize your browser window to make sure it looks great for all page widths." . '</p>';

  get_current_screen()->add_help_tab(array(
    'id'        => 'obspca-general',
    'title'     => 'OBSPCA Instructions',
    'content'   => $obspca_help
  ));
}

add_action('admin_head', 'obspca_add_help_sidebar');
function obspca_add_help_sidebar() {
  $wp_sidebar = get_current_screen()->get_help_sidebar();
  $sidebar_obspca_prepended = '<p>' . "<strong>If you break something or have technical questions</strong>, contact Jiehan Zheng at zheng@jiehan.org." . '</p>' . 
      $wp_sidebar;

  get_current_screen()->set_help_sidebar($sidebar_obspca_prepended);
}
