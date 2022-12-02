<?php
/**
 * Provider Single Template
 */

get_header();

$provider_id = get_the_ID();
$title = get_field('provider_title');
$description = get_field('provider_overview');
$hero_image_override = get_field('hero_image');
if (is_array($hero_image_override)){
    $hero_image = $hero_image_override['url'];
    $alt_text = $hero_image_override['alt'];
} else {
    $hero_image = get_template_directory_uri() . '/images/satellite-provider-hero.svg';
    $alt_text = 'Satellite Provider Hero Image';
}
$logo = get_field('logo');
$header_background_circle1 = get_template_directory_uri() . '/images/provider-header-background-circle-1.svg';
$header_background_circle2 = get_template_directory_uri() . '/images/provider-header-background-circle-2.svg';

$cta_arr = get_ctas($provider_id);
?>
<div class="provider-single-container" style="background-image: url(<?php echo $header_background_circle2; ?>);">
    <header class="provider-header pb-lg-4" style="background-image: url(<?php echo $header_background_circle1; ?>);">
        <div class="container">
            <?php get_template_part( 'template-parts/breadcrumbs', null, array( 'has_advertiser_disclosure_link' => true ) ); ?>
            <div class="d-flex justify-content-between pt-3 px-sm-5 px-xl-0">
                <div class="mr-lg-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="mr-0 mr-md-6 mr-xl-0">
                            <img class="provider-logo mb-4" src="<?php echo $logo; ?>" alt="logo">
                            <h1 class="mb-1 mb-sm-0 mb-xl-4"><?php echo $title; ?></h1>
                        </div>
                        <img src="<?php echo $hero_image; ?>" alt="<?php echo $alt_text; ?>" class="desktop-hidden mobile-hidden mb-3" width="175" height="175">
                    </div>    
                    <div class="mb-2 mb-xl-4 pb-1">
                        <p><?php echo $description; ?></p>
                    </div>
                    <div class="d-flex justify-content-center justify-content-sm-start">
                        <?php if(!empty($cta_arr['cta_text'])) echo '<a href="'.$cta_arr['cta_link'].'" class="btn-primary btn" target="_blank">'.$cta_arr['cta_text'].'</a>'; ?>
                    </div>
                </div>
                <div class="ml-5 mobile-hidden tablet-hidden">
                    <img src="<?php echo $hero_image; ?>" alt="<?php echo $alt_text; ?>" width="350" height="350">
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
    <?php get_template_part( 'template-parts/related-posts' ); ?>

</div>    

<?php get_footer(); ?>