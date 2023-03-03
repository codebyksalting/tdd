<?php
/**
 * tdd functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package tdd
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

if ( ! function_exists( 'tdd_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function tdd_setup() {
		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(
				'header-navigation' => esc_html__( 'Header Navigation', 'tdd' ),
				// 'developer-navigation' => esc_html__( 'Developer Navigation', 'tdd' ),
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 250,
				'width'       => 250,
				'flex-width'  => true,
				'flex-height' => true,
			)
		);

		// Custom Image Sizes
		// add_image_size( 'team-thumb', 333, 333, array( 'center', 'top' ) );
		// add_image_size( 'team-large', 1027, 1027, array( 'center', 'top' ) );
		// add_image_size( 'resource-medium', 620, 420, array( 'center', 'center' ) );
		// add_image_size( 'resource-thumb', 360, 244, array( 'center', 'center' ) );
		// add_image_size( 'mask-large', 1026, 1026, array( 'center', 'center' ) );
	}
endif;
add_action( 'after_setup_theme', 'tdd_setup' );

function remove_menus(){
	remove_menu_page( 'edit-comments.php' );          //Comments

}
add_action( 'admin_menu', 'remove_menus' );

// Removes from post and pages
function remove_comment_support() {
    remove_post_type_support( 'post', 'comments' );
    remove_post_type_support( 'page', 'comments' );
}
add_action('init', 'remove_comment_support', 100);

// Removes from admin bar
function tdd_admin_bar_render() {
    global $wp_admin_bar;
    $wp_admin_bar->remove_menu('comments');
}
add_action( 'wp_before_admin_bar_render', 'tdd_admin_bar_render' );

// add_filter( 'image_size_names_choose','tdd_custom_image_sizes' );
// function tdd_custom_image_sizes( $sizes ) {
// 	return array_merge( $sizes, array(
// 		'team-thumb' 		=> __( 'Team Member Thumbnail' ),
// 		'resource-thumb' 	=> __( 'Resource Thumbnail' ),
// 		'resource-medium' 	=> __( 'Resource Medium' ),
// 	) );
// }

/**
 * Remove tags support from posts (WordPress 3.7+)
 */
function tdd_unregister_tags() {
    unregister_taxonomy_for_object_type('post_tag', 'post');
}
add_action('init', 'tdd_unregister_tags');

/**
 * Build the ACF options
 */
if( function_exists('acf_add_options_page') ) {
	acf_add_options_page( array(
		'page_title' 	=> 'Theme Options',
		'menu_title'	=> 'Theme Options',
		'menu_slug' 	=> 'theme-options',
		'capability'	=> 'edit_posts',
		'redirect'		=> false
	) );
}

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function tdd_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'tdd_content_width', 640 );
}
add_action( 'after_setup_theme', 'tdd_content_width', 0 );

/**
 * Register our sidebars and widgetized areas.
 *
 */
/*
function widget_areas_init() {

	register_sidebar( array(
		'name'          => 'Blog Widgets',
		'id'            => 'blog_widget',
		'before_widget' => '<div class="content-section content-blog-widgets">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="section-heading">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => 'Blog Sidebar',
		'id'            => 'blog_sidebar',
		'before_widget' => '<div class="sidebar-blog-widgets">',
		'after_widget'  => '</div>',
		'before_title'  => '<strong class="widget-heading">',
		'after_title'   => '</strong>',
	) );

}
add_action( 'widgets_init', 'widget_areas_init' );
*/

/**
 * Enqueue scripts and styles.
 */
function tdd_scripts() {
	// Add Google Fonts
	wp_enqueue_style( 'tdd-gfont-readex', '//fonts.googleapis.com/css2?family=Readex+Pro:wght@400;500;600;700&display=swap', false );

	wp_enqueue_style( 'tdd-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'tdd-style', 'rtl', 'replace' );

	wp_enqueue_script( 'tdd-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );

	// wp_enqueue_script( 'tdd-main-js', get_template_directory_uri() . '/js/main.js', array('jquery'), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'tdd_scripts' );

/**
 * Add custom CSS to the back-end
 */
function admin_style() {
	wp_enqueue_style( 'custom-admin-styles', get_template_directory_uri() . '/css/admin.css' );
}
add_action( 'admin_enqueue_scripts', 'admin_style' );

/**
 * Get related posts
 */
function get_related_posts($ppp = 3) {
    $post_id = get_the_ID();
	$related_posts = array();
    // $cat_ids = array();
	// $categories = get_the_category( $post_id );

    // if( !empty( $categories ) && !is_wp_error( $categories ) ) {
    //     foreach ( $categories as $category ) {
    //         array_push( $cat_ids, $category->term_id );
	// 	}
	// }

    $current_post_type = get_post_type($post_id);

    $query_args = array( 
        // 'category__in'    => $cat_ids,
        'post_type'       => $current_post_type,
        'post__not_in'    => array($post_id),
        'posts_per_page'  => $ppp,
		'orderby' 		  => 'rand',
    );

    $related_cats_post = new WP_Query( $query_args );

    if( $related_cats_post->have_posts() ) {
        while($related_cats_post->have_posts()) { 
			$related_cats_post->the_post();
            $related_posts[] = get_the_ID();
		}
	}
	
	// Restore original Post Data
	wp_reset_postdata();

	return $related_posts;
}

/**
 * Increase the excerpt limit
 */
function increase_excerpt_length( $length ) {
    return 164;
}
add_filter( 'excerpt_length', 'increase_excerpt_length', 999 );

/**
 * Change the default excerpt breaker
 */
function modify_excerpt_more( $more ) {
	return '&hellip;';
}
add_filter( 'excerpt_more', 'modify_excerpt_more' );

/**
 * Add the template customizations file
 */
require get_template_directory() . '/inc/template-customizations.php';

/**
 * Add the custom post types file
 */
require get_template_directory() . '/inc/custom-post-types.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Disable WordPress Admin Bar for all users
 */
// add_filter( 'show_admin_bar', '__return_false' );

/*
 * Set post views count using post meta
 */
function setPostViews( $postID ) {
    $countKey = 'post_views_count';
    $count = get_post_meta( $postID, $countKey, true );
    if ( $count == '' ) {
        $count = 0;
        delete_post_meta($postID, $countKey);
        add_post_meta($postID, $countKey, '0');
    } else {
        $count++;
        update_post_meta( $postID, $countKey, $count );
    }
}
