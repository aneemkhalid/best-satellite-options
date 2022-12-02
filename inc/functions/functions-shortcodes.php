<?php

use ZipSearch\ProviderSearchController as ProviderSearchController;
use ZipSearch\PostgreSQLConnection as PostgreSQLConnection;
use ZipSearch\BDAPIConnection as BDAPIConnection;
use ZipSearch\ProvidersDBConnection as ProvidersDBConnection;
use ZipSearch\VaultTask as VaultTask;
use Dotenv\Dotenv as DotEnv;

function provider_count_shortcode() { 

  if (is_page('zip-search')):
    global $zip_provider_count;
    // if ($zip_provider_count != ''){
    //   return $zip_provider_count;
    // }

    global $zipcode;
    global $wpdb;

    $db = new ProvidersDBConnection();
    $tract_arr = $db->getTractsByZip($zipcode);
    $tract_where = implode(', ', $tract_arr);
    $provider_table_name = $wpdb->prefix . "broadband_hso";
    $sql = "SELECT DISTINCT hso_provider as hso_provider FROM $provider_table_name WHERE census_block_fips_code_11 IN ($tract_where) AND zip_code = '$zipcode'";
    $provider_count = $wpdb -> get_results($sql);

    //Count only providers that are actually a provider on the site

    $providers_arr_new = [];
    foreach($provider_count as $provider){
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
        'meta_query'    => array(
            array(
                'key'       => 'possible_provider_names_$_name',
                'compare'   => 'IN',
                'value'     => $providers_arr_new,
            ),
        )
    );
    $Providers = get_posts($args);

    $zip_provider_count = count($Providers);

    return $zip_provider_count;
  endif;     
} 
add_shortcode('provider_count', 'provider_count_shortcode');

function zipcode_city() {
  global $zipcode;
  $location = zip_to_city($zipcode);
  return $location['city'];
}

add_shortcode('city', 'zipcode_city');

function zipcode_state() {
  global $zipcode;
  $location = zip_to_city($zipcode);
  return $location['state'];
}

add_shortcode('state', 'zipcode_state');

function zipcode_shortcode() {
  global $zipcode;
  return $zipcode;
}

add_shortcode('zipcode', 'zipcode_shortcode');

function zipcode_location() {
  global $zipcode;

  if ($zipcode != ''){
    $location = zip_to_city($zipcode);
  }

  if (!empty($location)) {
    return $location['city'] . ', ' . $location['state'];
  }
  else {
    return $zipcode;
  }


}

add_shortcode('location', 'zipcode_location');