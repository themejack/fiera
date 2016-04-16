<?php
/**
 * Fiera functions and definitions
 *
 * @package Fiera
 */

/**
 * Remove Easy Forms for MailChimp by YIKES plugin styles
 */
if ( ! defined( 'YIKES_MAILCHIMP_EXCLUDE_STYLES' ) ) {
	define( 'YIKES_MAILCHIMP_EXCLUDE_STYLES', true );
}

if ( ! function_exists( 'fiera_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function fiera_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Fiera, use a find and replace
		 * to change 'fiera' to the name of your theme in all the template files
		 */
		load_theme_textdomain( 'fiera', get_template_directory() . '/languages' );

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
		 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'primary' => esc_html__( 'Primary Menu', 'fiera' ),
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
		 * See http://codex.wordpress.org/Post_Formats
		 */
		add_theme_support( 'post-formats', array(
			'aside',
			'image',
			'video',
			'quote',
			'link',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'fiera_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add editor style.
		add_editor_style( str_replace( ',', '%2C', '//fonts.googleapis.com/css?family=Lato:100,300,400,700,900,100italic,300italic,400italic,700italic,900italic&subset=latin,latin-ext' ) );
		add_editor_style( get_template_directory_uri() . '/admin/css/fiera-editor.css' );
	}
endif; // End fiera_setup.
add_action( 'after_setup_theme', 'fiera_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function fiera_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'fiera_content_width', 640 );
}
add_action( 'after_setup_theme', 'fiera_content_width', 0 );

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function fiera_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'fiera' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
}
add_action( 'widgets_init', 'fiera_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function fiera_scripts() {
	// Google Fonts.
	wp_enqueue_style( 'fiera-lato-font', '//fonts.googleapis.com/css?family=Lato:100,300,400,700,900,100italic,300italic,400italic,700italic,900italic&subset=latin,latin-ext' );

	// Style.
	wp_enqueue_style( 'fiera-style', get_template_directory_uri() . '/css/style.css' );

	// Custom style.
	$fiera_custom_style = '
		.site-title a, .site-description {
			color: ' . get_theme_mod( 'fiera_header_textcolor', '#ffffff' ) . ';
		}
	';
	wp_add_inline_style( 'fiera-style', esc_html( $fiera_custom_style ) );

	// Skip link focus fix.
	wp_enqueue_script( 'fiera-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	// Mapbox.
	wp_enqueue_script( 'fiera-mapbox', 'https://api.mapbox.com/mapbox.js/v2.2.3/mapbox.js', array(), '', true );
	wp_enqueue_style( 'fiera-mapbox', 'https://api.mapbox.com/mapbox.js/v2.2.3/mapbox.css' );

	// Scripts.
	wp_enqueue_script( 'fiera-scripts', get_template_directory_uri() . '/js/scripts.js', array( 'jquery', 'fiera-mapbox' ), '20150724', true );

	// Theme options.
	$theme_options = array(
		'mapbox_public_token' => get_option( 'fiera_mapbox_public_token' ),
	);
	wp_localize_script( 'fiera-scripts', 'fiera_theme_options', $theme_options );

	// Comment reply.
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'fiera_scripts' );

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

/**
 * Load Metaboxes.
 */
require get_template_directory() . '/inc/metaboxes.php';

/**
 * Admin page.
 */
require get_template_directory() . '/inc/admin-page.php';
