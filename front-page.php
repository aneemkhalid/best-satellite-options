<?php /* 
This page is used to display the static frontpage. 
*/ 
get_header();

$title = get_field('homepage_title');
$header_background = get_template_directory_uri() . '/images/homepage-header.svg';

?>

<header class="homepage-header">
    <div class="homepage-header-background" style="background-image: url(<?php echo $header_background; ?>);">
       <div class="container">
            <?php get_template_part( 'template-parts/breadcrumbs', null, array( 'has_advertiser_disclosure_link' => true ) ); ?>
            <div class="d-flex flex-column align-items-center p-sm-5">
                    <h1 class="text-center mb-5"><?php echo $title; ?></h1>
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