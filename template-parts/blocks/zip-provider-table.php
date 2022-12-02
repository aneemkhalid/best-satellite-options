<?php
/**
 * Providers Table for Locations Pages Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */
use ZipSearch\ProvidersDBConnection as ProvidersDBConnection;
// global $locations_provider_count;
// $locations_settings = get_field('locations_settings', 'options');
// $provider_table_columns = $locations_settings['provider_table_columns'];

global $post;
global $zipcode;
global $wpdb;

$db = new ProvidersDBConnection();
$tract_arr = $db->getTractsByZip($zipcode);

$tract_where = implode(', ', $tract_arr);
$provider_table_name = $wpdb->prefix . "broadband_hso";
$sql = "SELECT DISTINCT hso_provider FROM $provider_table_name WHERE census_block_fips_code_11 IN ($tract_where) AND zip_code = '$zipcode'";
$providers = $wpdb -> get_results($sql);

$providers_arr_new = [];
foreach($providers as $provider){
  $providers_arr_new[] = $provider->hso_provider;
}

//Add in starlink
$providers_arr_new[] = 'starlink';

add_filter('posts_where', 'my_posts_where');

// args
$args = array(
    'numberposts'   => -1,
    'post_type'     => 'provider',
    'suppress_filters' => false,
    'fields'        => 'ids',
    'order' => 'ASC',
    'orderby' => 'title',
    'meta_query'    => array(
        array(
            'key'       => 'possible_provider_names_$_name',
            'compare'   => 'IN',
            'value'     => $providers_arr_new,
        ),
    )
);
$Providers = get_posts($args);

//print_r($Providers, TRUE);

//$locations_provider_count = count($Providers);

//$FilterResult = false;

// NEW CODE
$table_columns = get_field('table_columns');
$TableStyle = 'minimal-table';
$CTAButton = '';
$ProviderFilter = '';
$Heading = '';
$TableDescription = get_field('disclaimer');

//Not sure what these do
$FilterResult = false;
$ProviderFilter = false;

// Default Columns
$Tbl_Columns = array( "Provider" );
$Tbl_Columns_Mobile = array( "Provider", "Type", "Max Download Speed", "Max Upload Speed", "" );
// User Added Columns
foreach( $table_columns as $Column ) {
    $Tbl_Columns[] = $Column['column_name'];
    $Tbl_ColumnsVal[] = $Column['column'];
}

// Add Last Column
$Tbl_Columns[] = '';

?>

<div class="container mb-3">
  <?php include( "provider-data-table-internet.php" ); ?>
</div>



