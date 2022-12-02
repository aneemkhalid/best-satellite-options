<?php
use ZipSearch\BDAPIConnection as BDAPIConnection;
use ZipSearch\ProviderSearchController as ProviderSearchController;
use Dotenv\Dotenv as DotEnv;

function resources_post_load_more(){

    $pageid = get_page_by_path( 'resources' );
    $top_featured_post = get_field('top_featured_post', $pageid->ID);
    $featured_sidebar_posts = get_field('featured_sidebar_posts', $pageid->ID);
    array_push($featured_sidebar_posts, $top_featured_post);
    $offset = ($_POST["ppp"] * $_POST['pageNumber']);
    $args = array(
        'post_type' => 'post',
        'posts_per_page' => $_POST["ppp"],
        'offset'         => $offset,
        'post__not_in' => $featured_sidebar_posts,
        'post_status' => 'publish',
        'orderby'  => 'date',
        'order' => 'DESC',
    );
    $resource_query = new WP_Query( $args );
    if ($resource_query -> have_posts()) :  
        while ($resource_query->have_posts()) : $resource_query->the_post();
        $return_resources .= '<a href="'.get_the_permalink().'" class="resource-article  d-block mb-5">';
        $return_resources .= '<h3 class="mb-4">'.get_the_title().'</h3>';
        $return_resources .= '<span class="mb-4 d-block">'.get_field('select_article_author').', '.get_the_date().'</span>';
        $return_resources .= '<p>'.get_the_excerpt().'</p>';
        $return_resources .= '</a>';
        endwhile;
    else:
        $return_resources = '';
    endif;
    
    wp_reset_postdata();
    die($return_resources);
}
add_action('wp_ajax_nopriv_resources_post_load_more', 'resources_post_load_more');
add_action('wp_ajax_resources_post_load_more', 'resources_post_load_more');

function zip_to_city($zipcode) {
	//get data

	global $wpdb;
	$table_name = $wpdb->prefix . "zip_tract";
	$rmZero = ltrim($zipcode, '0');

	//get city based on zip code
	$city_query = "SELECT usps_zip_pref_city, usps_zip_pref_state FROM $table_name WHERE zip = $rmZero LIMIT 1";
	$row = $wpdb -> get_results($city_query);
	$city = $row[0]->usps_zip_pref_city;
	$state = $row[0]->usps_zip_pref_state;
	$city = ucwords(strtolower($row[0]->usps_zip_pref_city));
	$state = strtoupper($state);

	$results = array(
		'city' => $city,
		'state' => $state
	);

	// output results
	return $results;
	// end processing
	wp_die();
}

add_action( 'wp_ajax_zip_to_city', 'zip_to_city' );
// ajax hook for non-logged-in users: wp_ajax_nopriv_{action}
add_action( 'wp_ajax_nopriv_zip_to_city', 'zip_to_city' );

function saveBDAPIData() {
	//get data
	$zip = isset( $_POST['zip'] ) ? $_POST['zip'] : false;
	$zip = sanitize_text_field( $zip );
	$auth = (new ProviderSearchController)->get_auth();
	$result = (new BDAPIConnection)->get_api_providers_by_zip($zip, $auth);

	$return = array('content' => $result);
	// end processing
	wp_die();
}
// ajax hook for logged-in users: wp_ajax_{action}
add_action( 'wp_ajax_saveBDAPIData', 'saveBDAPIData' );
// ajax hook for non-logged-in users: wp_ajax_nopriv_{action}
add_action( 'wp_ajax_nopriv_saveBDAPIData', 'saveBDAPIData' );

function load_zip_search() {
	//Check for zip and type from post
	if(isset($_POST['zip'])) {
		$zipcode = isset( $_POST['zip'] ) ? $_POST['zip'] : false;
	}

	require get_template_directory() . '/inc/zip-loader.php';

	$return = array('satellite' => $satellite, 'internet' => $internet, 'count' => $provider_count);
	wp_send_json($return);
	wp_die();

}
// ajax hook for logged-in users: wp_ajax_{action}
add_action( 'wp_ajax_load_zip_search', 'load_zip_search' );
// ajax hook for non-logged-in users: wp_ajax_nopriv_{action}
add_action( 'wp_ajax_nopriv_load_zip_search', 'load_zip_search' );