<?php
/**
 * wp-bestsatelliteoptions functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package wp-bestsatelliteoptions
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function wp_bestsatelliteoptions_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on wp-bestsatelliteoptions, use a find and replace
		* to change 'wp-bestsatelliteoptions' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'wp-bestsatelliteoptions', get_template_directory() . '/languages' );

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
	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary', 'wp-bestsatelliteoptions' ),
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

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'wp_bestsatelliteoptions_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

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
}
add_action( 'after_setup_theme', 'wp_bestsatelliteoptions_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function wp_bestsatelliteoptions_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'wp_bestsatelliteoptions_content_width', 640 );
}
add_action( 'after_setup_theme', 'wp_bestsatelliteoptions_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function wp_bestsatelliteoptions_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'wp-bestsatelliteoptions' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'wp-bestsatelliteoptions' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'wp_bestsatelliteoptions_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function wp_bestsatelliteoptions_scripts() {
	//wp_enqueue_style( 'wp-bestsatelliteoptions-style', get_stylesheet_uri(), array(), _S_VERSION );
	//wp_style_add_data( 'wp-bestsatelliteoptions-style', 'rtl', 'replace' );

	wp_enqueue_script( 'wp-bestsatelliteoptions-navigation', get_template_directory_uri() . '/build/index.js', array(), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'wp_bestsatelliteoptions_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';


/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/bso_ajax.php';

require get_template_directory() . '/inc/autoloader.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

if (file_exists(get_template_directory() . '/vendor/autoload.php')){
	require get_template_directory() . '/vendor/autoload.php';
}

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/* ========= LOAD CUSTOM FUNCTIONS ===================================== */
require_once get_template_directory() . '/inc/functions/functions-acfblocks.php';
require_once get_template_directory() . '/inc/functions/functions-shortcodes.php';
require_once get_template_directory() . '/inc/functions/functions-tables.php';


//custom code


// Add code to <head>
add_action( 'wp_head', 'add_header_scripts' );
function add_header_scripts() {
     if('https://www.bestsatelliteoptions.com' === home_url() || 'https://stagetmspeed.wpengine.com' === home_url() || 'https://devtmspeed.wpengine.com' === home_url() ) {
        echo "
        <!-- Google Tag Manager -->
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-M7ZP4KF');</script>
        <!-- End Google Tag Manager -->";
    } 

      //if not elementor page set meta referrer
  //  if ( !Elementor\Plugin::instance()->db->is_built_with_elementor( get_the_ID()) ) {
        echo '<meta name="referrer" content="no-referrer-when-downgrade" />';
   // }
}
// Add code just after opening <body> tag
add_action('wp_body_open', 'add_body_open_scripts');
function add_body_open_scripts() {
	 if('https://www.bestsatelliteoptions.com' === home_url() || 'https://stagetmspeed.wpengine.com' === home_url() || 'https://devtmspeed.wpengine.com' === home_url() ) {
	    echo '<!-- Google Tag Manager (noscript) -->
            <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-M7ZP4KF" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
            <!-- End Google Tag Manager (noscript) -->';
      
	}
    
     
    echo '<script>
        window.dataLayer = window.dataLayer || [];  
        </script>';
}


//bring in min stylesheet through plugin inline option
add_filter('autoptimize_filter_css_defer_inline','my_ao_css_defer_inline',10,1);
function my_ao_css_defer_inline($inlined) {
    
     //automatic file versioning base on save info
    $style_saved_css_version = filemtime( get_stylesheet_directory().'/style.min.css' );

	return $inlined.'</style><link rel="stylesheet" href="'.get_template_directory_uri().'/style.min.css?v='.$style_saved_css_version.'" media="all"><style>';
}
//for some reason preview broke with plugin update
add_filter('autoptimize_filter_noptimize','turn_on_for_preview',10,0);
function turn_on_for_preview() {
	 if ( is_preview() ) {
		return false;
	} 
}
//remove jquery migrate dont need it
function remove_jquery_migrate( $scripts ) {
   if ( ! is_admin() && isset( $scripts->registered['jquery'] ) ) {
        $script = $scripts->registered['jquery'];
       if ( $script->deps ) { 
        // Check whether the script has any dependencies

            $script->deps = array_diff( $script->deps, array( 'jquery-migrate' ) );
        }
    }
 }
add_action( 'wp_default_scripts', 'remove_jquery_migrate' );

function wporg_block_wrapper( $block_content, $block ) {

	if (str_contains($block['blockName'], 'core/') && !is_single() && !is_page_template('template-parts/template-bubbles.php')){
		$content = '<div class="container">';
        $content .= $block_content;
        $content .= '</div>';
        return $content;
	}
    return $block_content;
}

add_filter( 'render_block', 'wporg_block_wrapper', 10, 2 );

add_action('enqueue_block_editor_assets', function () {

	wp_enqueue_script('admin.js', get_stylesheet_directory_uri() . '/js/admin.js', null, null, true);

}, 100);
