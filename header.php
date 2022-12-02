<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package wp-bestsatelliteoptions
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); 

$menu = prepare_menu_items( 'Main' );
$header_logo = get_field('header_logo', 'options');
$header_logo = ($header_logo  == '') ? get_template_directory_uri().'/images/bestsatelliteoptions_header_logo.svg' : $header_logo; 
$hamburger_close = get_template_directory_uri() . '/images/icons/close.svg';

?>

<div class="overlay">
    <?php echo create_primary_nav_html('Main', true); ?>
</div>
<header class="nav-header">
    <div class="main-nav-header d-flex justify-content-between container p-xl-0">
        <div class="header-logo-container d-flex align-items-center">
            <a href="<?php echo get_home_url(); ?>" class="custom-logo-link" rel="home">
                <noscript>
                    <img src="<?php echo $header_logo; ?>" class="custom-logo" alt="highspeedoptions logo" width="260" height="25">
                </noscript>
                <img src="<?php echo $header_logo; ?>" data-src="<?php echo $header_logo; ?>" class="custom-logo lazyloaded" alt="highspeedoptions logo" width="260" height="25">
            </a>
        </div>
        <div class="primary-menu-container d-flex align-items-center">
            <?php echo create_primary_nav_html('Main'); ?>
            <svg width="17" height="17" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg" class="search-open mt-1">
                <circle cx="6.92558" cy="6.92558" r="5.92558" stroke="#2c2c2c" stroke-width="2"/>
                <path d="M11.0742 11.0742L16.9998 16.9998" stroke="#2c2c2c" stroke-width="2"/>
            </svg>
            <div class="search-container">
                <?php get_template_part( 'template-parts/zip-search-form' ); ?>
            </div>
            <div class="header-container-mobile d-flex justify-content-end">
                <div class="hamburger-menu-container ml-4 mr-3 mr-md-0">
                    <button type="button" id="toggle-hamburger" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <div id="navbar-hamburger">
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </div>
                        <div id="navbar-close">
                            <img class="zip_search_icon mt-1" width="15" height="15" src="<?php echo $hamburger_close; ?>" alt="hamburger menu icon">
                        </div>
                    </button>
                </div>
            </div>
        </div>
    </div>
    
</header>
