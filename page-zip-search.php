<?php
/**
 * The template for the zip search page
 * @package HSO
 */

get_header();

use ZipSearch\ProviderSearchController as ProviderSearchController;
use ZipSearch\PostgreSQLConnection as PostgreSQLConnection;
use ZipSearch\BDAPIConnection as BDAPIConnection;

global $zipcode;

global $wpdb;

//require get_theme_file_path( '/template-parts/zip-search-popup.php' );

//get params for display
// (isset($_GET['zip'])) ? $zipcode = $_GET['zip'] : $zipcode = false;
// (isset($_GET['city']) && $_GET['city']) ? $city = $_GET['city'] : $city = '';
// (isset($_GET['state']) && $_GET['state']) ? $state = $_GET['state'] : $state = '';

$non_satellite = get_field('non_satellite_provider_title');
$subheader = get_field('header_descriptive_text');

$location = zip_to_city($zipcode);
if($location) {
	$location = $location['city'] . ', ' . $location['state'] . ' ' . $zipcode;
}
else {
	$location = $zipcode;
}

//echo $location;

$zip_search_loader_progress_text = get_field('zip_search_loader_progress_text');
(isset($zip_search_loader_progress_text['h3_text']) && $zip_search_loader_progress_text['h3_text'] != 
'') ? $h3_text = $zip_search_loader_progress_text['h3_text'] : $h3_text = 'Finding the Best Deals for You.';
(isset($zip_search_loader_progress_text['h4_text']) && $zip_search_loader_progress_text['h4_text'] != '') ? $h4_text = $zip_search_loader_progress_text['h4_text'] : $h4_text = 'This should only take a sec.';
?>
	<main class="site-main zip_search">

		<section class="banner">
			<div class="container">
				<?php //get_template_part( 'template-parts/breadcrumbs', null, array( 'has_banner' => true, 'is_location' => false )); ?>
				<div class="py-5 hero-inner py-md-6">
					<h1 class="text-left text-white">Providers in <?php echo $location; ?></h1>
					<h4 class="text-white font-weight-bold"><?php echo $subheader; ?></h4>
					<div class="d-flex justify-content-start mt-3 zip-btn-container align-items-center">
						<a href="#" class="cta_btn zip-popup-btn text-white underline">Edit Location</a>
						<div class="d-inline-block overflow-hidden">
							<div class="search-container zip-search-hero" style="">
								<?php get_template_part( 'template-parts/zip-search-form' ); ?>
							</div>
						</div>
						<a href="#" class="cta_btn zip-cancel-btn text-white underline">Cancel</a>
					</div>
				</div>
			</div>
		</section>
   
		<div class="container count-container pt-4">
			A total of <span class="font-weight-bold provider-count"><?php  echo do_shortcode('[provider_count]') ?></span> providers in this area
		</div>

		<div class="zip_search_overview zip_search_overview-load-height common-style my-5" id="accordion">
			<div class="container zip-search-loader-container">
				<div class="zip-search-loader-container-inner border-radius-20 pt-5 pt-md-0 px-3 d-flex flex-column justify-content-md-center align-items-center">
					<video autoplay loop muted playsinline height="100" width="100">
						<source src="<?php echo get_template_directory_uri() ?>/images/zip-search-load.png" type="video/webm">
						<source src="<?php echo get_template_directory_uri() ?>/images/animations/zip-search-load.mp4" type="video/mp4">
					</video>
					<h3 class="mt-3 text-center"><?php echo $h3_text; ?></h3>
					<h4 class="mt-3 text-center"><?php echo $h4_text; ?></h4>
				</div>
			</div>	
		</div>

		<div class="internet_search_overview mb-5" style="display: none;">
			<div class="container">
				<h3 class="mb-4"><?php echo do_shortcode($non_satellite); ?></h3>
			</div>
			<div class="zip-search-internet"></div>
		</div>


		<div><?php echo the_content(); ?></div>


		

		
	</main><!-- #main -->
	<?php get_template_part( 'template-parts/related-posts' ); ?>

<?php
get_footer();
