<?php
/**
 * tailwind theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package tailwind_theme
 */

if ( ! defined( 'TAILWIND_THEME_VERSION' ) ) {
	/*
	 * Set the theme’s version number.
	 *
	 * This is used primarily for cache busting. If you use `npm run bundle`
	 * to create your production build, the value below will be replaced in the
	 * generated zip file with a timestamp, converted to base 36.
	 */
	define( 'TAILWIND_THEME_VERSION', '0.1.0' );
}

if ( ! defined( 'TAILWIND_THEME_TYPOGRAPHY_CLASSES' ) ) {
	/*
	 * Set Tailwind Typography classes for the front end, block editor and
	 * classic editor using the constant below.
	 *
	 * For the front end, these classes are added by the `tailwind_theme_content_class`
	 * function. You will see that function used everywhere an `entry-content`
	 * or `page-content` class has been added to a wrapper element.
	 *
	 * For the block editor, these classes are converted to a JavaScript array
	 * and then used by the `./javascript/block-editor.js` file, which adds
	 * them to the appropriate elements in the block editor (and adds them
	 * again when they’re removed.)
	 *
	 * For the classic editor (and anything using TinyMCE, like Advanced Custom
	 * Fields), these classes are added to TinyMCE’s body class when it
	 * initializes.
	 */
	define(
		'TAILWIND_THEME_TYPOGRAPHY_CLASSES',
		'prose prose-neutral max-w-none prose-a:text-primary'
	);
}

if ( ! function_exists( 'tailwind_theme_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function tailwind_theme_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on tailwind theme, use a find and replace
		 * to change 'tailwind-theme' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'tailwind-theme', get_template_directory() . '/languages' );

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

		// This theme uses wp_nav_menu() in two locations.
		register_nav_menus(
			array(
				'menu-1' => __( 'Primary', 'tailwind-theme' ),
				'menu-2' => __( 'Footer Menu', 'tailwind-theme' ),
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

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		// Add support for editor styles.
		add_theme_support( 'editor-styles' );

		// Enqueue editor styles.
		add_editor_style( 'style-editor.css' );

		// Add support for responsive embedded content.
		add_theme_support( 'responsive-embeds' );

		// Remove support for block templates.
		remove_theme_support( 'block-templates' );
	}
endif;
add_action( 'after_setup_theme', 'tailwind_theme_setup' );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function tailwind_theme_widgets_init() {
	register_sidebar(
		array(
			'name'          => __( 'Footer', 'tailwind-theme' ),
			'id'            => 'sidebar-1',
			'description'   => __( 'Add widgets here to appear in your footer.', 'tailwind-theme' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'tailwind_theme_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function tailwind_theme_scripts() {
	wp_enqueue_style( 'tailwind-theme-style', get_stylesheet_uri(), array(), TAILWIND_THEME_VERSION );
	wp_enqueue_script( 'tailwind-theme-script', get_template_directory_uri() . '/js/script.min.js', array(), TAILWIND_THEME_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'tailwind_theme_scripts' );

/**
 * Enqueue the block editor script.
 */
function tailwind_theme_enqueue_block_editor_script() {
	wp_enqueue_script(
		'tailwind-theme-editor',
		get_template_directory_uri() . '/js/block-editor.min.js',
		array(
			'wp-blocks',
			'wp-edit-post',
		),
		TAILWIND_THEME_VERSION,
		true
	);
}
add_action( 'enqueue_block_editor_assets', 'tailwind_theme_enqueue_block_editor_script' );

/**
 * Enqueue the script necessary to support Tailwind Typography in the block
 * editor, using an inline script to create a JavaScript array containing the
 * Tailwind Typography classes from TAILWIND_THEME_TYPOGRAPHY_CLASSES.
 */
function tailwind_theme_enqueue_typography_script() {
	if ( is_admin() ) {
		wp_enqueue_script(
			'tailwind-theme-typography',
			get_template_directory_uri() . '/js/tailwind-typography-classes.min.js',
			array(
				'wp-blocks',
				'wp-edit-post',
			),
			TAILWIND_THEME_VERSION,
			true
		);
		wp_add_inline_script( 'tailwind-theme-typography', "tailwindTypographyClasses = '" . esc_attr( TAILWIND_THEME_TYPOGRAPHY_CLASSES ) . "'.split(' ');", 'before' );
	}
}
add_action( 'enqueue_block_assets', 'tailwind_theme_enqueue_typography_script' );

/**
 * Add the Tailwind Typography classes to TinyMCE.
 *
 * @param array $settings TinyMCE settings.
 * @return array
 */
function tailwind_theme_tinymce_add_class( $settings ) {
	$settings['body_class'] = TAILWIND_THEME_TYPOGRAPHY_CLASSES;
	return $settings;
}
add_filter( 'tiny_mce_before_init', 'tailwind_theme_tinymce_add_class' );

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';


/**
 * Add button
 */
function add_body_button() {
	echo '<button id="actionButton" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">Button</button>';
};
add_action( 'wp_body_open', 'add_body_button' );
