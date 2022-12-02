<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 * Template Name: Template - Provider Lander
 * Template Post Type: page
 * @package HSO
 */

get_header();

$title = get_field('lander_title');
$title = ($title) ? $title : 'Find satellite internet offered near you.';
?>
<header class="provider-lander-header">
    <div class="provider-lander-header-background">
       <div class="container">
            <?php get_template_part( 'template-parts/breadcrumbs', null, array( 'has_advertiser_disclosure_link' => true, 'exclude_breadcrumbs' => true ) ); ?>
            <div class="d-flex flex-column align-items-center p-sm-4">
                    <h2 class="text-center mb-4"><?php echo $title; ?></h2>
                    <?php get_template_part( 'template-parts/zip-search-form' ); ?>
            </div>
        </div> 
    </div>
</header>

<main class="site-main">

    <?php
        while ( have_posts() ) :
            the_post();

            echo the_content();

        endwhile; // End of the loop.
    ?>
</main><!-- #main -->

<?php get_footer(); ?>