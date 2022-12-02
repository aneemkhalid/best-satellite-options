<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package wp-bestsatelliteoptions
 */

 get_header();
?>

	<main id="primary" class="site-main">
            <div class="container mb-lg-4 mb-md-3">
            <?php get_template_part( 'template-parts/breadcrumbs', null, array( 'has_advertiser_disclosure_link' => true ) ); ?>
            </div>
        <section class="post-content">
            <div class="container">   
                <?php
                while ( have_posts() ) :
                    the_post();

                    get_template_part( 'template-parts/content', get_post_type() );

                endwhile; // End of the loop.
                ?>
            </div>
        </section>
        <?php get_template_part( 'template-parts/related-posts' ); ?>
	</main><!-- #main -->

<?php
get_footer();
