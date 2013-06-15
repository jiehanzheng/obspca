<?php

/**
 * Sets up the content width value based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) )
  $content_width = 625;

/**
 * Sets up theme defaults and registers the various WordPress features.
 */
function obspca_setup() {
  // Adds RSS feed links to <head> for posts and comments.
  add_theme_support( 'automatic-feed-links' );

  // This theme supports a variety of post formats.
  add_theme_support( 'post-formats', array( 'aside', 'image', 'link', 'quote', 'status' ) );

  // This theme uses wp_nav_menu() in one location.
  register_nav_menu( 'primary', 'Global Navbar');
}
add_action( 'after_setup_theme', 'obspca_setup' );


/**
 * Enqueues scripts and styles for front-end.
 */
function obspca_scripts_styles() {
  /*
   * Loads our main stylesheet
   */
  wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/vendor/bootstrap/css/bootstrap.css' );
  wp_enqueue_style( 'obspca-style', get_stylesheet_uri() );

  /*
   * Bootstrap components
   */
  wp_enqueue_script('jquery');
  wp_enqueue_script('raphael', get_template_directory_uri() . '/vendor/livicons/js/raphael-min.js');
  wp_enqueue_script('livicons', get_template_directory_uri() . '/vendor/livicons/js/livicons-1.2.min.js', array('raphael', 'jquery'));
  wp_enqueue_script('bootstrap-transition', get_template_directory_uri() . '/vendor/bootstrap/js/bootstrap-transition.js');
  wp_enqueue_script('bootstrap-carousel', get_template_directory_uri() . '/vendor/bootstrap/js/bootstrap-carousel.js');
  wp_enqueue_script('bootstrap-dropdown', get_template_directory_uri() . '/vendor/bootstrap/js/bootstrap-dropdown.js');
  wp_enqueue_script('bootstrap-collapse', get_template_directory_uri() . '/vendor/bootstrap/js/bootstrap-collapse.js');
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
  register_sidebar( array(
    'name' => __( 'Main Sidebar', 'twentytwelve' ),
    'id' => 'sidebar-1',
    'description' => __( 'Appears on posts and pages except the optional Front Page template, which has its own widgets', 'twentytwelve' ),
    'before_widget' => '<aside id="%1$s" class="widget %2$s">',
    'after_widget' => '</aside>',
    'before_title' => '<h3 class="widget-title">',
    'after_title' => '</h3>',
  ) );
}
add_action( 'widgets_init', 'obspca_widgets_init' );


/**
 * Return relative time in human-readable form
 *
 * Taken from http://www.zachstronaut.com/posts/2009/01/20/php-relative-date-time-string.html
 */
function obspca_time_elapsed_string($ptime) {
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



if ( ! function_exists( 'twentytwelve_content_nav' ) ) :
/**
 * Displays navigation to next/previous pages when applicable.
 *
 * @since Twenty Twelve 1.0
 */
function twentytwelve_content_nav( $html_id ) {
  global $wp_query;

  $html_id = esc_attr( $html_id );

  if ( $wp_query->max_num_pages > 1 ) : ?>
    <nav id="<?php echo $html_id; ?>" class="navigation" role="navigation">
      <h3 class="assistive-text"><?php _e( 'Post navigation', 'twentytwelve' ); ?></h3>
      <div class="nav-previous alignleft"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'twentytwelve' ) ); ?></div>
      <div class="nav-next alignright"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'twentytwelve' ) ); ?></div>
    </nav><!-- #<?php echo $html_id; ?> .navigation -->
  <?php endif;
}
endif;

if ( ! function_exists( 'twentytwelve_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments template
 * simply create your own twentytwelve_comment(), and that function will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @since Twenty Twelve 1.0
 */
function twentytwelve_comment( $comment, $args, $depth ) {
  $GLOBALS['comment'] = $comment;
  switch ( $comment->comment_type ) :
    case 'pingback' :
    case 'trackback' :
    // Display trackbacks differently than normal comments.
  ?>
  <li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
    <p><?php _e( 'Pingback:', 'twentytwelve' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( '(Edit)', 'twentytwelve' ), '<span class="edit-link">', '</span>' ); ?></p>
  <?php
      break;
    default :
    // Proceed with normal comments.
    global $post;
  ?>
  <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
    <article id="comment-<?php comment_ID(); ?>" class="comment">
      <header class="comment-meta comment-author vcard">
        <?php
          echo get_avatar( $comment, 44 );
          printf( '<cite class="fn">%1$s %2$s</cite>',
            get_comment_author_link(),
            // If current post author is also comment author, make it known visually.
            ( $comment->user_id === $post->post_author ) ? '<span> ' . __( 'Post author', 'twentytwelve' ) . '</span>' : ''
          );
          printf( '<a href="%1$s"><time datetime="%2$s">%3$s</time></a>',
            esc_url( get_comment_link( $comment->comment_ID ) ),
            get_comment_time( 'c' ),
            /* translators: 1: date, 2: time */
            sprintf( __( '%1$s at %2$s', 'twentytwelve' ), get_comment_date(), get_comment_time() )
          );
        ?>
      </header><!-- .comment-meta -->

      <?php if ( '0' == $comment->comment_approved ) : ?>
        <p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'twentytwelve' ); ?></p>
      <?php endif; ?>

      <section class="comment-content comment">
        <?php comment_text(); ?>
        <?php edit_comment_link( __( 'Edit', 'twentytwelve' ), '<p class="edit-link">', '</p>' ); ?>
      </section><!-- .comment-content -->

      <div class="reply">
        <?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply', 'twentytwelve' ), 'after' => ' <span>&darr;</span>', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
      </div><!-- .reply -->
    </article><!-- #comment-## -->
  <?php
    break;
  endswitch; // end comment_type check
}
endif;

if ( ! function_exists( 'twentytwelve_entry_meta' ) ) :
/**
 * Prints HTML with meta information for current post: categories, tags, permalink, author, and date.
 *
 * Create your own twentytwelve_entry_meta() to override in a child theme.
 *
 * @since Twenty Twelve 1.0
 */
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
endif;


/**
 * Adjusts content_width value for full-width and single image attachment
 * templates, and when there are no active widgets in the sidebar.
 *
 * @since Twenty Twelve 1.0
 */
function obspca_content_width() {
  if ( is_page_template( 'page-templates/full-width.php' ) || is_attachment() || ! is_active_sidebar( 'sidebar-1' ) ) {
    global $content_width;
    $content_width = 960;
  }
}
add_action( 'template_redirect', 'obspca_content_width' );

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @since Twenty Twelve 1.0
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 * @return void
 */
function twentytwelve_customize_register( $wp_customize ) {
  $wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
  $wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';
}
add_action( 'customize_register', 'twentytwelve_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 *
 * @since Twenty Twelve 1.0
 */
function twentytwelve_customize_preview_js() {
  wp_enqueue_script( 'twentytwelve-customizer', get_template_directory_uri() . '/js/theme-customizer.js', array( 'customize-preview' ), '20120827', true );
}
add_action( 'customize_preview_init', 'twentytwelve_customize_preview_js' );


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
      $item_output .= ' <span class="caret"></span>';
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
