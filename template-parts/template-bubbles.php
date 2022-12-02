<?php
/**
 * Template Name: Template - Bubbles
 *
 * This is the template that displays various elemetns and typography you create
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package wp-bestsatelliteoptions
 */

get_header();

$bubbles = get_stylesheet_directory_uri() . '/images/bubbles.svg';

while ( have_posts() ) : the_post(); 
?>

  <main id="primary" class="site-main overflow-hidden position-relative">

    <div class="container pt-3 px-xl-0">
      <?php get_template_part( 'template-parts/breadcrumbs', null, array( 'has_advertiser_disclosure_link' => true ) ); ?>
      <img src="<?php echo $bubbles ?>" alt="bubbles" height="200" width="200" class="bubbles bubble-left position-absolute">
      <img src="<?php echo $bubbles ?>" alt="bubbles" height="200" width="200" class="bubbles bubble-right position-absolute">

      <section class="header-container pt-3">
        <h1><?php echo get_the_title(); ?></h1>
      </section>

      <div class="mb-6">
        <?php echo the_content(); ?>
      </div>

    </div>

  </main>
<!-- #main -->

<?php 		
endwhile;
get_footer();
