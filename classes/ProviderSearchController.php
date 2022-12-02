<?php
namespace ZipSearch;

use ZipSearch\PostgreSQLConnection as PostgreSQLConnection;
use ZipSearch\BDAPIConnection as BDAPIConnection;
use ZipSearch\ProvidersDBConnection as ProvidersDBConnection;
use Dotenv\Dotenv as DotEnv;
// use ZipSearch\VaultTask as VaultTask;

class ProviderSearchController {

    /**
     * return all providers
     */
    public function getAllProviders($args=[]) {

        $zipcode = isset($args['zipcode']) ? $args['zipcode'] : null;
        $is_city = isset($args['is_city']) ? $args['is_city'] : false;
        $zip_arr = isset($args['zip_arr']) ? $args['zip_arr'] : [];
        $city = isset($args['city']) ? $args['city'] : null;
        $state = isset($args['state']) ? $args['state'] : null;
        $zip_provider = isset($args['provider_id']) ? $args['provider_id'] : null;

        $auth = $this->get_auth();
        $bd_providers = [];
        $fcc_providers = [];
        $provider_arr = [];
        $provider_arr['internet'] = [];

        $is_valid_zip = self::isValidZipCode($zipcode);
        if (!$is_valid_zip){
            return  $provider_arr;
        }
        
        //get provider buyers
        if($zip_provider) {
            $providers[] = get_post($zip_provider);
        }
        else {
            $providers = get_posts(array(
                'numberposts'   => -1,
                'post_type'     => 'provider',
            ));
        }

        //sort out where we need to get data for each provider
        foreach($providers as $provider){

            if (get_field('partner', $provider->ID)){
                $partner_order = get_field('order', $provider->ID);

                if (!$partner_order){
                    $partner_order = 9999999;
                }

                $hide_from_results = get_field('hide_from_zip_search', $provider->ID);
                if ($hide_from_results){
                    continue;
                }

                $internet = get_field('internet', $provider->ID);
                $connection_types = $internet['connection_types'];

                $buyer_id = get_field('buyer', $provider->ID);
                $campaigns = get_field('campaign', $buyer_id);
                $possible_names_arr = get_field('possible_provider_names', $provider->ID);
                
                $possible_names = [];
                $campaign_key = false;
                if (is_array($possible_names_arr)){
                    foreach($possible_names_arr as $name){
                        $possible_names[] = $name['name'];
                    }
                }
                //find campaign key where the campaign name field has the same provider id
                $test = false;
                if(is_array($campaigns)){
                    $test = array_search (  $provider->ID, array_column($campaigns, 'campaign_name') );
                }
                
                if (is_numeric($test) && $test !== false){
                    $campaign_key = $test;
                }
                if ($campaign_key !== false){
                    $has_internet = get_field('internet_check', $provider->ID);
                    $coverage_type = isset($campaigns[$campaign_key]['coverage_type']) ? $campaigns[$campaign_key]['coverage_type'] : 0;
                    //$products_arr = get_field('products', $provider->ID);

                    //PRODUCTS IS NOT A FIELD ANYMORE

                    if ($has_internet){
                        $internet = get_field('internet', $provider->ID);
                        $i_connection_types = $internet['connection_types'];
                        if ($internet['split_out_connection']){
                            $min_starting_price_arr = [];
                            $max_d_speed_arr = [];
                            $max_u_speed_arr = [];
                            foreach ($i_connection_types as $i_connection_type){
                                switch ($i_connection_type) {
                                    case "cable":
                                        $min_starting_price_arr[] = $internet['cable_connection']['cable_starting_price'];
                                        $max_d_speed_arr[] = $internet['cable_connection']['cable_max_download_speed'];
                                        $max_u_speed_arr[] = $internet['cable_connection']['cable_max_upload_speed'];
                                    case "fiber":
                                        $min_starting_price_arr[] = $internet['fiber_connection']['fiber_starting_price'];
                                        $max_d_speed_arr[] = $internet['fiber_connection']['fiber_max_download_speed'];
                                        $max_u_speed_arr[] = $internet['fiber_connection']['fiber_max_upload_speed'];
                                    case "dsl":
                                        $min_starting_price_arr[] = $internet['dsl_connection']['dsl_starting_price'];
                                        $max_d_speed_arr[] = $internet['dsl_connection']['dsl_max_download_speed'];
                                        $max_u_speed_arr[] = $internet['dsl_connection']['dsl_max_upload_speed'];
                                    case "fixed":
                                        $min_starting_price_arr[] = $internet['fixed_connection']['fixed_starting_price'];
                                        $max_d_speed_arr[] = $internet['fixed_connection']['fixed_max_download_speed'];
                                        $max_u_speed_arr[] = $internet['fixed_connection']['fixed_max_upload_speed'];
                                    case "wireless":
                                        $min_starting_price_arr[] = $internet['wireless_connection']['wireless_starting_price'];
                                        $max_d_speed_arr[] = $internet['wireless_connection']['wireless_max_download_speed'];
                                        $max_u_speed_arr[] = $internet['wireless_connection']['wireless_max_upload_speed'];
                                    case "satellite":
                                        $min_starting_price_arr[] = $internet['satellite_connection']['satellite_starting_price'];
                                        $max_d_speed_arr[] = $internet['satellite_connection']['satellite_max_download_speed'];
                                        $max_u_speed_arr[] = $internet['satellite_connection']['satellite_max_upload_speed'];
                                }
                                if (!empty($min_starting_price_arr)){
                                    $min_starting_price_arr = array_filter($min_starting_price_arr);
                                    $i_min_starting_price = min($min_starting_price_arr);
                                } else {
                                    $i_min_starting_price = $internet['details']['min_starting_price'];
                                }
                                if (!empty($max_d_speed_arr)){
                                    $max_d_speed_arr = array_filter($max_d_speed_arr);
                                    $i_max_d_speed = max($max_d_speed_arr);
                                } else {
                                    $i_max_d_speed = $internet['details']['max_download_speed'];
                                }
                                if (!empty($max_u_speed_arr)){
                                    $max_u_speed_arr = array_filter($max_u_speed_arr);
                                    $i_max_u_speed = max($max_u_speed_arr);
                                } else {
                                    $i_max_u_speed = $internet['details']['max_upload_speed'];
                                }
                            }
                        } else {
                            $i_min_starting_price = $internet['details']['min_starting_price'];
                            $i_max_d_speed = $internet['details']['max_download_speed'];
                            $i_max_u_speed = $internet['details']['max_upload_speed'];
                            //$i_connection_types = $internet['details']['connection_types'];
                        }
                        //$has_internet = true;
                        $i_min_starting_price = preg_replace("/[^0-9.]/", "", $i_min_starting_price);
                    } 
                     
                    //REMOVE BDAPI ARRAY
                    // if ($coverage_type == 'bundle_dealer_api'){
                    //     $bd_providers[$provider->ID] = [
                    //         'possible_names' => $possible_names,
                    //         'order' => $partner_order,
                    //         'connection_type' => $connection_types,
                    //     ];
                    // } 
                    if ($coverage_type == 'all' || $coverage_type == 'bundle_dealer_api') {
                        if ($has_internet){
                            $cleaned = preg_replace('/[^A-Za-z0-9\-]/', '', $possible_names[0]);
                            $name = trim(strtolower($cleaned));
                            $provider_arr['internet'][$name] = [
                                'name' => $name,
                                'id' => $provider->ID,
                                'download_speed' => preg_replace('/[^0-9]/', '', $i_max_d_speed),
                                'upload_speed' => preg_replace('/[^0-9]/', '', $i_max_u_speed),
                                'cost' => $i_min_starting_price,
                                'order' => $partner_order,
                                'connection_type' => $connection_types,
                            ];
                        } 
                    } else {
                        $i_cost = 'N/A';
                        if ($has_internet){
                            $i_cost = $i_min_starting_price;
                        }
                        if ($coverage_type == 'zip_upload'){
                            $zip_upload_providers[$provider->ID] = [
                                'possible_names' => $possible_names,
                                'i_cost' => $i_cost,
                                'order' => $partner_order,
                                'connection_type' => $connection_types,
                            ];

                        } elseif ($coverage_type == 'fcc'){
                            $fcc_providers[$provider->ID] = [
                                'possible_names' => $possible_names,
                                'i_cost' => $i_cost,
                                'order' => $partner_order,
                                'connection_type' => $connection_types,
                            ];
                        }
                    }

                }
            }

            //Add in starlink
        }
        // error_log('PRoV FROM PROVS');
        // error_log(print_r($provider_arr['internet'], TRUE));
        // error_log('FCCD FROM PROVS');
        // error_log(print_r($fcc_providers, TRUE));
        // error_log('ZIP UPLOAD FROM PROVS');
        // error_log(print_r($zip_upload_providers, TRUE));

        $providersDB = new ProvidersDBConnection($zipcode);
        $temp_provider_arr = [];
        $temp_provider_arr['internet'] = [];

        //get all internet providers from FCC

        $fcc_providers_arr = $providersDB->getAllInternetProviderData();
        $zip_upload_prov_arr = $providersDB->getAllZipUploadProviderData();

        // error_log('FCC');
        // error_log(print_r($internet_providers_arr, TRUE));
    

        $in_fcc_zip_upload_arrs = [];
        if (is_array($zip_upload_prov_arr) && !empty($zip_upload_prov_arr)){
            foreach($zip_upload_prov_arr as $provider){
                foreach($zip_upload_providers as $key => $zip_upload_provider) {
                   if (in_array($provider->hso_provider, $zip_upload_provider['possible_names'])) {
                        //$name = $zip_upload_provider['possible_names'][0];
                        $name = $provider->hso_provider;
                        $in_fcc_zip_upload_arrs[] = $name;
                        $temp_provider_arr['internet'][$name] = [
                            'name' => $name,
                            'id' => $key,
                            'download_speed' => (int)$provider->max_advertised_downstream_speed_mbps,
                            'upload_speed' => (int)$provider->max_advertised_upstream_speed_mbps,
                            'cost' => $zip_upload_provider['i_cost'],
                            'order' => $zip_upload_provider['order'],
                            'connection_type' => get_field('internet', $key)['connection_types']
                        ];
                        //if download speed is empty then add it to fcc providers array
                        if ($temp_provider_arr['internet'][$name]['download_speed'] == '' || $temp_provider_arr['internet'][$name]['upload_speed'] == ''){
                            $fcc_providers[$key] = $zip_upload_provider;
                            if ($temp_provider_arr['internet'][$name]['download_speed'] == ''){
                                $fcc_providers[$key]['update_download_speed'] == true;
                            }
                            if ($temp_provider_arr['internet'][$name]['upload_speed'] == ''){
                                $fcc_providers[$key]['update_upload_speed'] == true;
                            }
                            if ($temp_provider_arr['internet'][$name]['connection_type'] == ''){
                                $fcc_providers[$key]['update_connection_type'] == true;
                            }
                        }
                        //just for xfinity and Frontier we use the price in the zip uploads table instead of the WP backend
                        if ($name == 'Xfinity' || $name == 'Frontier'){
                            $temp_provider_arr['internet'][$name]['cost'] = (float)$provider->price;
                        }
                   }
                }
            }
        }

        // error_log('BEFORE FCC');
        // error_log(print_r($temp_provider_arr, TRUE));

        // error_log('FCC ARRAY');
        // error_log(print_r($fcc_providers_arr, TRUE));

        if (is_array($fcc_providers_arr) && !empty($fcc_providers_arr)){
            foreach($fcc_providers_arr as $provider){
                foreach($fcc_providers as $key => $fcc_provider) {
                   if (in_array($provider->hso_provider, $fcc_provider['possible_names'])) {
                        $name = trim(strtolower($fcc_provider['possible_names'][0]));
                        //never grab frontier data even if it's blank
                        if ($name == 'frontier'){
                            continue;
                        }
                        if ($fcc_provider['update_download_speed'] || $fcc_provider['update_upload_speed']){
                            if ($fcc_provider['update_download_speed']){
                                $temp_provider_arr['internet'][$name] = [
                                    'download_speed' => (int)$provider->max_advertised_downstream_speed_mbps,
                                ];
                            }
                            if ($fcc_provider['update_upload_speed']){
                                $temp_provider_arr['internet'][$name] = [
                                    'upload_speed' => (int)$provider->max_advertised_upstream_speed_mbps,
                                ];
                            }
                            if ($fcc_provider['update_connection_type']){
                                $temp_provider_arr['internet'][$name] = [
                                    'connection_type' => $provider->connection_type,
                                ];
                            }
                        } else {
                            //$in_fcc_zip_upload_arrs[] = $name;
                            $temp_provider_arr['internet'][$name] = [
                                'name' => $name,
                                'id' => $key,
                                'download_speed' => (int)$provider->max_advertised_downstream_speed_mbps,
                                'upload_speed' => (int)$provider->max_advertised_upstream_speed_mbps,
                                'cost' => $fcc_provider['i_cost'],
                                'order' => $fcc_provider['order'],
                                'connection_type' => get_field('internet', $key)['connection_types']
                            ];
                        }
                   }
                }
            }
        }

        // error_log('TEMP PROVIDER');
        // error_log(print_r($temp_provider_arr['internet'], TRUE));

        $provider_arr['internet'] = array_merge($temp_provider_arr['internet'], $provider_arr['internet']);

        //Check if provider array exists in fcc data and is a partner
        foreach($provider_arr['internet'] as $key => $prov) {
            if(!array_key_exists($key, $fcc_providers_arr)) {
                //error_log($key . 'REMOVED');
                //KEEP STARLINK REGARDLESS SINCE IT"S INTERNET UNSET IF NOT FOUND IN FCC DATA
                if($key !== 'starlink') {
                    unset($provider_arr['internet'][$key]);
                }
            }
        }

        //error_log('AFTER FCC & ZIP');
        // error_log(print_r($provider_arr['internet'], TRUE));

        //get all providers for API

        //REMOVE BDAPI CONNECTION

        //$api_connection = new BDAPIConnection();

        //$api = $api_connection->get_api_providers_by_zip($zipcode, $auth);

        // if (is_array($api) && isset($api['AvailableProducts'])){
        //     foreach ($api['AvailableProducts'] as $provider){
        //         //error_log('Provider: ' . $provider);
        //         //ignore earthlinkv6
        //         if ( isset($provider['Provider']['ProviderCode']) && $provider['Provider']['ProviderCode'] == 'EARTHLINKv6'){
        //             continue;
        //         }
        //         if (isset($provider['Provider']['ProviderName']) && $provider['Provider']['ProviderName'] == 'Earthlink Hyperlink'){
        //             $provider['Provider']['ProviderName'] = 'Earthlink';
        //         }
        //         if (isset($provider['Provider']['ProviderName'])){
        //             $found = false;
        //             $altice_found = false;
        //             foreach($bd_providers as $key => $bd_provider) {
        //                 if ($altice_found){
        //                     break;
        //                 }
        //                 if (in_array($provider['Provider']['ProviderName'], $bd_provider['possible_names'])) {
        //                     //error_log('Got provider from API: ' . $provider['Provider']['ProviderName']);
        //                     $found = true;
        //                     $provider_id = $key;
        //                     $provider_order = $bd_provider['order'];
        //                     //if the provider returned is altice, check the FCC data to see if it's suddenlink or optimum
        //                     if ($provider['Provider']['ProviderName'] == 'Altice'){
        //                         $found = false;
        //                         foreach($internet_providers_arr as $key2=>$fcc_provider){
        //                             if (in_array($key2, $bd_provider['possible_names'])){
        //                                 $altice_found = true;
        //                                 $found = true;
        //                             }
        //                         }
        //                     }
        //                 }
        //             }
        //             if ($found == true){
        //                 if (isset($provider['Products']) && is_array($provider['Products'])){
        //                     $download_speed = 0;
        //                     $upload_speed = 0;
        //                     $i_cost = 9999999999;
        //                     $connections = [];

        //                     foreach ($provider['Products'] as $product){

        //                         if ($product['VerticalName'] == 'Internet'){

        //                             if ($provider['Provider']['ProviderName'] == 'AT&T and DIRECTV'){
        //                                 $i_provider_name = 'AT&T';
        //                                 foreach($bd_providers as $key => $bd_provider) {
        //                                     if (in_array($i_provider_name, $bd_provider['possible_names'])) {
        //                                         $provider_id = $key;
 
        //                                         $provider_order = $bd_provider['order'];
        //                                     }
        //                                 }
        //                             } else {
        //                                 $i_provider_name = $provider['Provider']['ProviderName'];
        //                             }

        //                             if (is_array($product['FeatureList'])){
        //                                 foreach($product['FeatureList'] as $featurelist){
        //                                     $lc_featurelist_name = strtolower($featurelist['Name']);
        //                                     $lc_featurelist_val = strtolower($featurelist['Value']);
        //                                     if ( $lc_featurelist_name == 'download speed'){
        //                                         $download_speed = $featurelist['Value'];
        //                                         if (strpos($lc_featurelist_val, 'gb') !== false || strpos($lc_featurelist_val, 'gbps') !== false){
        //                                             $download_speed = preg_replace('/[^0-9\.]/', '',$download_speed);
        //                                             $download_speed = $download_speed * 1000;
        //                                         } elseif (strpos($lc_featurelist_val, 'kb') !== false || strpos($lc_featurelist_val, 'kbs') !== false || strpos($lc_featurelist_val, 'kbps') !== false){
        //                                             $download_speed = preg_replace('/[^0-9\.]/', '',$download_speed);
        //                                             $download_speed = $download_speed / 1000;
        //                                         } else {
        //                                             $download_speed = preg_replace('/[^0-9\.]/', '',$download_speed);
        //                                         }
        //                                     }
        //                                     if ($lc_featurelist_name == 'upload speed' || $lc_featurelist_name == 'upstream speed'){
        //                                         $upload_speed = $featurelist['Value'];
        //                                         if (strpos($lc_featurelist_val, 'gb') !== false || strpos($lc_featurelist_val, 'gbps') !== false){
        //                                             $upload_speed = preg_replace('/[^0-9\.]/', '',$upload_speed);
        //                                             $upload_speed = $upload_speed * 1000;
        //                                         } elseif (strpos($lc_featurelist_val, 'kb') !== false || strpos($lc_featurelist_val, 'kbs') !== false || strpos($lc_featurelist_val, 'kbps') !== false){
        //                                             $upload_speed = preg_replace('/[^0-9\.]/', '',$upload_speed);
        //                                             $upload_speed = $upload_speed / 1000;
        //                                         } else {
        //                                             $upload_speed = preg_replace('/[^0-9\.]/', '',$upload_speed);
        //                                         }
        //                                     }
        //                                 }
        //                             }
        //                             if (!isset($provider_arr['internet'][$i_provider_name])){
        //                                 if ($product['BasePrice']['InitialAmount'] == 0){
        //                                     $product['BasePrice']['InitialAmount'] = $i_cost;
        //                                 }
        //                                 $provider_arr['internet'][ $i_provider_name] = [
        //                                     'name' => $i_provider_name,
        //                                     'id' => $provider_id,
        //                                     'download_speed' => $download_speed,
        //                                     'upload_speed' => $upload_speed,
        //                                     'cost' => $product['BasePrice']['InitialAmount'],
        //                                     'order' => $provider_order,
        //                                     'connection_type'=> get_field('internet', $provider_id)['connection_types'],
        //                                 ];
        //                             } else {
        //                                 if ($download_speed > $provider_arr['internet'][$i_provider_name]['download_speed']){
        //                                     $provider_arr['internet'][$i_provider_name]['download_speed'] = $download_speed;
        //                                 }
        //                                 if ($upload_speed > $provider_arr['internet'][$i_provider_name]['upload_speed']){
        //                                     $provider_arr['internet'][$i_provider_name]['upload_speed'] = $upload_speed;
        //                                 }
        //                                 if ($product['BasePrice']['InitialAmount'] != 0 && $product['BasePrice']['InitialAmount'] < $provider_arr['internet'][$i_provider_name]['cost']){
        //                                     $provider_arr['internet'][$i_provider_name]['cost'] = $product['BasePrice']['InitialAmount'];
        //                                 }
        //                             }
        //                         }
        //                     }
        //                 }
        //             }
        //         }
        //     }
        // }

        //Fill in coverage for provider array
        $tracts_total = 0;
        //$db = new ProvidersDBConnection();
        $tract_arr = $providersDB->getTractsByZip($zipcode);
        $tract_where = implode(', ', $tract_arr);
        $tracts_total = count($tract_arr);

        // error_log('TRACT COUNT');
        // error_log(print_r($tract_arr, TRUE));
        // error_log(print_r($tracts_total, TRUE));

        foreach($provider_arr['internet'] as $key => $provider){
            $coverage = $providersDB->getCoverage($tract_where, $tracts_total, $provider['id']);
            $provider_arr['internet'][$key]['coverage'] = $coverage;
        }

        // error_log('BEFORE SORTING');
        // error_log(print_r($provider_arr['internet'], TRUE));


        usort($provider_arr['internet'], function($a, $b) {
            return $b['download_speed'] <=> $a['download_speed'];
        });

        usort($provider_arr['internet'], function($a, $b) {
            if ($a['order'] === $b['order']) return 0;
            if ($a['order'] === 0) return 1;
            if ($b['order'] === 0) return -1;
            return $a['order'] > $b['order'] ? 1 : -1;
        });

        foreach ($provider_arr['internet'] as $key => $internet){
            if ($internet['download_speed'] === 0 || $internet['download_speed'] === 'N/A' || $internet['download_speed'] === null || $internet['download_speed'] === ''){
                $provider_arr['internet'][$key]['download_speed'] = 'N/A';
            } elseif ($internet['download_speed'] < 1){
                $provider_arr['internet'][$key]['download_speed'] = '< 1';
            } else {
                $provider_arr['internet'][$key]['download_speed'] = round($internet['download_speed'], 0);
            }
            if ($internet['upload_speed'] === 0 || $internet['upload_speed'] === 'N/A' || $internet['upload_speed'] === null || $internet['upload_speed'] === ''){
                $provider_arr['internet'][$key]['upload_speed'] = 'N/A';
            } elseif ($internet['upload_speed'] < 1){
                $provider_arr['internet'][$key]['upload_speed'] = '< 1';
            } else {
                $provider_arr['internet'][$key]['upload_speed'] = round($internet['upload_speed'], 0);
            }
            if ($internet['cost'] == 9999999999 || $internet['cost'] == 'N/A'){
                $provider_arr['internet'][$key]['cost'] = 'N/A';
            } else {
                $provider_arr['internet'][$key]['cost'] = number_format((float)$provider_arr['internet'][$key]['cost'], 2, '.', '');
            }
            if ($provider_arr['internet'][$key]['download_speed'] == 'N/A' && $provider_arr['internet'][$key]['upload_speed'] == 'N/A' && $provider_arr['internet'][$key]['cost'] == 'N/A' && $provider_arr['internet'][$key]['name'] != 'Frontier'){
                unset($provider_arr['internet'][$key]);
            }
        }


        // $provider_count = count($provider_arr['internet']);
        // $final_array['count'] = $provider_count;

        //Sort into satellite and into other
        $final_arr['satellite'] = [];
        $final_arr['internet'] = [];
        foreach($provider_arr['internet'] as $item) {
            if(in_array('satellite', $item['connection_type'])) {
                $final_arr['satellite'][] = $item;
            }
            else {
                $final_arr['internet'][] = $item;
            }
        }

        // error_log('FINAL ARRAY');
        // error_log(print_r($final_arr, TRUE));

        return $final_arr;
    }

    static function format_phone_number($number){
        $phone = preg_replace("/[^\d]/", "", $number);
        return preg_replace("/^1?(\d{3})(\d{3})(\d{4})$/", "$1-$2-$3", $phone);
    }
    static function isValidZipCode($zipCode) {
        return (preg_match('/^[0-9]{5}(-[0-9]{4})?$/', $zipCode)) ? true : false;
    }
    static function getZipType(){
        $type = get_post_field( 'post_name', get_post() );
        if ($type != 'internet' && $type != 'tv' && $type != 'bundle'){
            $type = 'internet';
        }
        return $type;
    }
    static function get_auth(){
        // $task = new VaultTask();
        // $task->unseal();
        // $response = $task->get_auth();
        $dotenv = DotEnv::createUnsafeImmutable(ABSPATH);
        $dotenv->load();
        $json = base64_decode(getenv('ZIP_AUTH'));
        $auth_arr = json_decode($json, true);
        return $auth_arr;
    }

}
