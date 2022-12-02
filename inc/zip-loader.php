<?php
use ZipSearch\ProviderSearchController as ProviderSearchController;
//use ZipSearch\BDAPIConnection as BDAPIConnection;
//use ZipSearch\ProvidersDBConnection as ProvidersDBConnection;


//get params for display
$url = $_SERVER["HTTP_REFERER"];
$parts = parse_url($url);
//error_log(print_r($parts, TRUE));

if($parts) {
	parse_str($parts['query'], $query);
	(isset($query['zip'])) ? $zipcode = $query['zip'] : $zipcode = false;
	(isset($query['type']) && $query['type']) ? $type = $query['type'] : $type = 'internet';
}

$zip_arr=[];

$args = [
	'zipcode' => $zipcode,
	//'zip_arr' => $zip_arr,
	//'provider_id' => $provider_id,
];

$results_arr = (new ProviderSearchController())->getAllProviders($args);

$provider_count = 0;
if(!empty($results_arr)) {
  $provider_count = count($results_arr['internet']) + count($results_arr['satellite']);
}
// error_log('ZIP LOADER');
// error_log(print_r($results_arr, TRUE));

//$counter = 1;

//return different none found text depending on whether it's a programmatic city or top city

$zipcode = str_pad($zipcode, 5, '0', STR_PAD_LEFT);
//$no_results = $zipcode;

//$check = get_template_directory_uri() . '/images/check.svg';

//Check if zip qual and has results otherwise return null
if(is_array($results_arr['satellite'])) {
  ob_start();
  get_template_part('/template-parts/new-zip-search', null, ['providers' => $results_arr['satellite'], 'is_satellite' => true, 'zipcode' => $zipcode]);
  $satellite = ob_get_contents();
  ob_end_clean();
}

if(is_array($results_arr['internet'])) {
  ob_start();
  get_template_part('/template-parts/new-zip-search', null, ['providers' => $results_arr['internet'], 'is_satellite' => false, 'zipcode' => $zipcode ]);
  $internet = ob_get_contents();
  ob_end_clean();
}

?>
