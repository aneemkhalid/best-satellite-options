<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package wp-bestsatelliteoptions
 * 
 * Template Name: Resources
 * 
 */

get_header();

$top_featured_post = get_field('top_featured_post');
$featured_sidebar_posts = get_field('featured_sidebar_posts');
?>

	<main id="primary" class="site-main">
        <section class="resource-banner">
            <div class="resource-banner-background" style="background-image: url(<?php echo get_template_directory_uri(); ?>/images/resource-banner.svg)">
                <div class="container">
                    <?php get_template_part( 'template-parts/breadcrumbs', null, array( 'has_advertiser_disclosure_link' => true ) ); ?>
                    <?php 
                    $featured_post = get_post($top_featured_post);
                    $author = get_field('select_article_author', $featured_post->ID);
                    ?>
                    <a href="<?php echo get_the_permalink($featured_post->ID); ?>" class="resource-article top-featured-article d-block mt-2">
                        <h3 class="mb-4"><?php echo $featured_post->post_title; ?></h3>
                        <span class="mb-4 d-block"><?php echo $author; ?>, <?php echo get_the_date('M j, Y', $featured_post->ID); ?></span>
                        <p><?php echo $featured_post->post_excerpt; ?></p>
                    </a>
                </div>
            </div>
        </section>
        <section class="all-resource-articles pt-5">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8">
                        <?php 
                        $notin_all_articles = $featured_sidebar_posts; 
                        array_push($notin_all_articles, $top_featured_post);
                        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                        $args = array(
                            'post_type' => 'post',
                            'posts_per_page' => 4,
                            'post_status' => 'publish',
                            'paged'   => $paged,
                            'post__not_in' => $notin_all_articles,
                            'orderby'  => 'date',
							'order' => 'DESC',
                        );

                        $the_query = new WP_Query( $args );
                        if ( $the_query->have_posts() ) :
                        ?>
                        <div class="all-articles">
                            <?php 
                            while ( $the_query->have_posts() ) :
                                $the_query->the_post();
                            ?>
                            <a href="<?php the_permalink(); ?>" class="resource-article  d-block mb-5">
                                <h3 class="mb-4"><?php the_title(); ?></h3>
                                <span class="mb-4 d-block"><?php echo get_field('select_article_author'); ?>, <?php echo get_the_date(); ?></span>
                                <p><?php the_excerpt(); ?></p>
                            </a>
                            <?php endwhile; ?>
                        </div>
                        <?php 
                        wp_reset_postdata();
                        endif;
                        ?>
                        <input type="hidden" class="pageNumber" id="pageno" value="<?php echo $paged; ?>">
                    <div class="text-center more-articles-btn-wrap">
                        <a href="#" class="more-articles-btn">View More</a>
                    </div>
                     </div>
                    <div class="col-lg-4">
                        <div class="featured-articles justify-content-between">
                        <?php
                            $args = array(
                                'post_type'  => 'post',
                                'post__in' => $featured_sidebar_posts
                            );
                            $sidebar_posts = get_posts($args);
                            foreach($sidebar_posts as $sidebar_post) :
                                $author = get_field('select_article_author', $sidebar_post->ID);
                            ?>
                            <a href="<?php echo get_the_permalink($sidebar_post->ID); ?>" class="resource-article  d-block">
                                <h5><?php echo $sidebar_post->post_title; ?></h5>
                                <span class="mb-3 d-block"><?php echo $author ?>, <?php echo get_the_date('M j, Y', $sidebar_post->ID); ?></span>
                            </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div> 
            </div>
        </section>
	</main><!-- #main -->

<?php
get_footer();
