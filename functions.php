<?php
/**
 * Dessertstorm functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Dessertstorm
 */

if ( ! function_exists( 'dessertstorm_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function dessertstorm_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Dessertstorm, use a find and replace
	 * to change 'dessertstorm' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'dessertstorm', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

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
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary Menu', 'dessertstorm' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See https://developer.wordpress.org/themes/functionality/post-formats/
	 */
	add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'link',
	) );

}
endif; // dessertstorm_setup
add_action( 'after_setup_theme', 'dessertstorm_setup' );


/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function _dessertstorm_content_width() {
	$GLOBALS['content_width'] = apply_filters( '_dessertstorm_content_width', 640 );
}
add_action( 'after_setup_theme', '_dessertstorm_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function dessertstorm_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'dessertstorm' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
}
add_action( 'widgets_init', 'dessertstorm_widgets_init' );

/**
 * Enqueue styles.
 */
if ( !function_exists( 'dessertstorm_styles' ) ) :

	function dessertstorm_styles() {
		// Enqueue our stylesheet
		$handle = 'dessertstorm_styles';
		$src =  get_template_directory_uri() . '/assets/dist/css/app.css';
		$deps = '';
		$ver = filemtime( get_template_directory() . '/assets/dist/css/app.css');
		$media = '';
		wp_enqueue_style( $handle, $src, $deps, $ver, $media );

		wp_enqueue_style( 'dessertstorm_web_fonts', get_stylesheet_directory_uri() . '/assets/dist/css/web-fonts.css', '', '1.0' );
		wp_enqueue_style( 'fontawesome_styles', get_stylesheet_directory_uri() . '/assets/dist/css/font-awesome.css', '', '9' );
		wp_enqueue_style( 'home_styles', get_stylesheet_directory_uri() . '/style.css', '', '9' );

	}

add_action( 'wp_enqueue_scripts', 'dessertstorm_styles' );

endif;


/**
 * Enqueue scripts.
 */
function dessertstorm_scripts() {

	// Add Foundation JS to footer
	wp_enqueue_script( 'foundation-js',
		get_template_directory_uri() . '/assets/dist/js/foundation.js',
		array( 'jquery' ), '6.1.1', true
	);

	// Add our concatenated JS file after Foundation
	$handle = 'dessertstorm_appjs';
	$src =  get_template_directory_uri() . '/assets/dist/js/app.js';
	$deps = array( 'jquery' );
	$ver = filemtime( get_template_directory() . '/assets/dist/js/app.js');
	$in_footer = true;
	wp_enqueue_script( $handle, $src, $deps, $ver, $in_footer );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'dessertstorm_scripts' );


/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';



add_filter( 'wp_nav_menu', 'dessertstorm_nav_menu', 10, 2 );

function dessertstorm_nav_menu( $menu ){
	$menu = str_replace('current-menu-item', 'current-menu-item active', $menu);
	return $menu;
}


/*******************************************************************************
* Make YouTube and Vimeo oembed elements responsive. Add Foundation's .flex-video 
* class wrapper around any oembeds
*******************************************************************************/

function dessertstorm_oembed_flex_wrapper( $html, $url, $attr, $post_ID ) {
	if ( strpos($url, 'youtube') || strpos($url, 'youtu.be') || strpos($url, 'vimeo') ) {
		return '<div class="flex-video widescreen">' . $html . '</div>';
	}
	return $html;
}
add_filter( 'embed_oembed_html', 'dessertstorm_oembed_flex_wrapper', 10, 4 );

/*******************************************************************************
* Custom login styles for the theme. Sass file is located in ./assets/login.scss
* and is spit out to ./assets/dist/css/login.css by gulp. Functions are here so
* that you can move it wherever works best for your project.
*******************************************************************************/

// Load the CSS
add_action( 'login_enqueue_scripts', 'dessertstorm_login_css' );

function dessertstorm_login_css() {
	wp_enqueue_style( 'dessertstorm_login_css', get_template_directory_uri() .
	'/assets/dist/css/login.css', false );
}

// Change header link to our site instead of wordpress.org
add_filter( 'login_headerurl', 'dessertstorm_remove_logo_link' );

function dessertstorm_remove_logo_link() {
	return get_bloginfo( 'url' );
}

// Change logo title in from WordPress to our site name
add_filter( 'login_headertitle', 'dessertstorm_change_login_logo_title' );

function dessertstorm_change_login_logo_title() {
	return get_bloginfo( 'name' );
}
