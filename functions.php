<?php
/**
 * functions.php
 *
 * All functionality specific to the custom theme lives here.
 * Note that if you're building a theme based on flux, you'll want to find and replace
 * the flux package name with your own package name.
 *
 * @package flux
 */

/**
 * Library functions that act independently of the theme templates.
 */
require_once get_template_directory() . '/inc/lib.php';

/**
 * Sets up the theme and registers support for WordPress features
 *
 * Note this is hooked into after_setup_theme, which runs before the init hook.
 * The init hook is too late for some features
 */
add_action( 'after_setup_theme', 'flux_bourbon_setup' );
function flux_bourbon_setup()
{
	// Make the theme available for translations. Complete and install translations into ./languages/
	load_theme_textdomain( 'flux', get_template_directory() . '/languages' );

	// Enable support for Post Thumbnails on posts and pages.
	add_theme_support( 'post-thumbnails' );

	// Enable support for Post Formats.
	add_theme_support( 'post-formats', array( 'aside', 'image', 'video', 'quote', 'link' ) );

	// Enable support for HTML5 markup.
	add_theme_support( 'html5', array( 'comment-list', 'search-form', 'comment-form', 'gallery', 'caption' ) );

	// Enable default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	// Register Nav Menus
	if ( function_exists( 'flux_register_nav_menus' ) ) {
		flux_register_nav_menus();
	}

	// Register sidebars
	if ( function_exists( 'flux_widgets_init' ) ) {
		flux_widgets_init();
	}

	// Set up the custom post types, if there are any
	// we build out our CPT using a custom plugin with the below function
	if ( function_exists( 'theme_custom_post_types' ) ) {
		theme_custom_post_types();
	}
}

/**
 * Registers Nav Menus for the theme. Add array entries as needed.
 * If not registering any menus, you can safely delete this function
 *
 * For new menus, follow the format
 * 'menu-slug' => __( 'menu-name', 'textdomain' ),
 */
function flux_register_nav_menus()
{
	register_nav_menus( array(
			'primary' => __( 'Primary Menu', 'flux' ),
		) );
}

/**
 * Register any Sidebars for the theme
 * If not registering any sidebars, you can safely delete this function
 *
 * For new sidebars, copy and paste the register sidebar function
 */
function flux_widgets_init()
{
	register_sidebar( array(
			'name'          => __( 'Sidebar', 'flux' ),
			'id'            => 'sidebar-1',
			'description'   => '',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h1 class="widget-title">',
			'after_title'   => '</h1>'
		));
}

/**
 * Include Advanced Custom Fields as a required plugin
 */

	/**
	 * This includes the free version (4.3.9) of ACF and is included with this theme
	 * Comment this out if you are using ACF Pro
	 */
	include_once( get_template_directory() . '/inc/advanced-custom-fields/acf.php' );

	/**
	 * This includes ACF Pro, but you must install into ./inc/ yourself
	 * If using ACF Pro, simply uncomment all of the following code
	 */
	/*
	add_filter( 'acf/settings/path', 'acfSettingsPath' );
	function acfSettingsPath( $path )
	{
	    $path = get_template_directory() . '/inc/advanced-custom-fields-pro/';
	    return $path;
	}

	add_filter( 'acf/settings/dir', 'acfSettingsDir' );
	function acfSettingsDir( $dir )
	{
	    $dir = get_template_directory_uri() . '/inc/advanced-custom-fields-pro/';
	    return $dir;
	}

	include_once( get_template_directory() . '/inc/advanced-custom-fields-pro/acf.php' );
	*/

/**
 * Include the web-admin-role plugin. This creates a Web Admin user role when the theme
 * is activated, and removes it when deactivated. We use the Web Admin role to
 * slightly limit what the client admins can do in the backend. Usually this will
 * prevent them from updating plugins or core code, inserting crazy html on the site,
 * and willy-nilly activating, deactivating, or deleting things like themes.
 *
 * Comment this line out to disable the feature.
 */
include_once( get_template_directory() . '/inc/web-admin-role/web-admin-role.php' );

/**
 * Enqueue scripts and styles
 *
 * Note that we enqueue minified versions of all of these files. If you are not
 * using minified files, you may want to modify the enqueues here. Or more likely,
 * you'll want to start using minified files.
 *
 * Note that you can uncomment the vendor-style and vendor-script enqueues if you
 * need them for your theme. They are used if you have bower components installed
 * that will create css or js files via gulp.
 */
add_action( 'wp_enqueue_scripts', 'theme_enqueue_scripts', 99 );
function theme_enqueue_scripts() {
    wp_enqueue_style( 'theme-style', get_template_directory_uri() . '/style.min.css' );
    //wp_enqueue_style( 'vendor-style', get_template_directory_uri() . '/vendor.min.css' );

    wp_enqueue_script( 'jquery' );
    wp_enqueue_script( 'modernizr-script', get_template_directory_uri() . '/assets/js/dist/modernizr-2.8.3.min.js', array(), '2.8.3', false );
    wp_enqueue_script( 'theme-script', get_template_directory_uri() . '/assets/js/dist/all.min.js', array(), '', true );
    //wp_enqueue_script( 'vendor-script', get_template_directory_uri() . '/assets/js/dist/vendor.min.js', array(), '', true );
}

/**
 * Features you can enable or disable as needed.
 */

	// Implement the Custom Header feature.
	//require get_template_directory() . '/inc/custom-header.php';

	// Customizer additions.
	//require get_template_directory() . '/inc/customizer.php';

	// Load Jetpack compatibility file.
	//require get_template_directory() . '/inc/jetpack.php';

	// Load Dashboard Overrides - for white labeling
	require get_template_directory() . '/inc/dashboard.php';

	// Load Media Library Improvements and Support.
	require get_template_directory() . '/inc/media.php';

	// Add support for automatic creation of alt tags for images in the content
	add_filter( 'the_content', 'flux_add_alt_tags', 9999 );

	// Add support for including <p> tags in the excerpts
	remove_filter( 'get_the_excerpt', 'wp_trim_excerpt' );
	add_filter( 'get_the_excerpt', 'flux_trim_excerpt' );

    // add support for responsive background images from the media library
    //add_action( 'wp_footer', 'flux_output_responsive_backgrounds', 99 );

    // Sets up the theme color
    // this is used as the ms tile background color and the chrome toolbar color
    global $favicon_theme_color;
    $favicon_theme_color = '#ffffff';
    // Adds generated favicons to theme from end and backend
    // http://realfavicongenerator.net/
    add_action( 'wp_head', 'flux_output_favicons' );
    add_action( 'admin_head', 'flux_output_favicons' );
    add_action( 'login_head', 'flux_output_favicons' );

    // turns off wordpress emojis for the front end because there's a bug in
    // wp 4.2.2 that causes JS errors when using SVG
    remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
    remove_action( 'wp_print_styles', 'print_emoji_styles' );

