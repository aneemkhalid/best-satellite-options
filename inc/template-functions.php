<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package wp-bestsatelliteoptions
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function wp_bestsatelliteoptions_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	return $classes;
}
add_filter( 'body_class', 'wp_bestsatelliteoptions_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function wp_bestsatelliteoptions_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'wp_bestsatelliteoptions_pingback_header' );

/**
 * Enqueue admin styles.
 */
function load_admin_styles() {
    wp_enqueue_style( 'admin_css', get_template_directory_uri() . '/css/admin-styles.css', false, '1.0.0' );
}
add_action( 'admin_enqueue_scripts', 'load_admin_styles' ); 

//enqueues gutenburg scripts
function gutenberg_enqueue() {
    wp_enqueue_script(
        'bsoguten-script',
        get_template_directory_uri() . '/build/index-gutenberg.js',
        array('wp-blocks') // Include wp.blocks Package             
    );
}

add_action('enqueue_block_editor_assets', 'gutenberg_enqueue');

/**
 * Create custom theme options menu
 */

if( function_exists('acf_add_options_page') ) {
    
    acf_add_options_page(array(
        'page_title'    => 'General Settings',
        'menu_title'    => 'Theme Settings',
        'menu_slug'     => 'theme-settings',
        'capability'    => 'edit_posts',
        'redirect'      => false
    ));
    
    acf_add_options_sub_page(array(
        'page_title'    => 'Locations Settings',
        'menu_title'    => 'Locations',
        'parent_slug'   => 'theme-settings',
    ));
    
}
/**
 * Foreach post type registration
 *
 * @link https://codex.wordpress.org/Post_Types#Custom_Post_Types
 * @link https://codex.wordpress.org/Function_Reference/register_post_type
 * @link https://codex.wordpress.org/Function_Reference/register_taxonomy
 */
add_action('init', 'post_types');
function post_types(){
    global $wp_post_types;
    global $wp_taxonomies;

    $post_types = array(

        array(
            'slug'        => 'provider',
            'rewrite'     => 'providers',
            'single_name' => 'Provider',
            'plural_name' => 'Providers',
            'menu_name'	  => 'Provider',
            'show-in-rest'  => true,
            'description' => 'Provider that we have',
			'menu-position'  => 4,
            // https://developer.wordpress.org/resource/dashicons/#microphone
            'dashicon'    => 'dashicons-admin-page',
            'publicly_queryable' => true,
            'hierarchical' => true,
            'supports' => array('title', 'editor', 'thumbnail', 'page-attributes'),
        ),
        array(
            'slug'        => 'build-buyer',
            'rewrite'     => 'build-buyer',
            'single_name' => 'Build Buyer',
            'plural_name' => 'Build Buyers',
            'menu_name'	  => 'Build Buyers',
            'show-in-rest'  => false,
            'description' => 'Build Buyers that we have',
			'menu-position'  => 5,
            // https://developer.wordpress.org/resource/dashicons/#microphone
            'dashicon'    => 'dashicons-admin-page',
            'publicly_queryable' => false,
            'hierarchical' => false,
            'supports' => array('title', 'editor', 'thumbnail'),
        ),
        array(
            'slug'        => 'locations',
            'rewrite'     => 'locations',
            'single_name' => 'Location',
            'plural_name' => 'Locations',
            'menu_name'   => 'Locations',
            'show-in-rest'  => true,
            'description' => 'Locations for Geo Pages',
            'menu-position'  => 7,
            // https://developer.wordpress.org/resource/dashicons/#microphone
            'dashicon'    => 'dashicons-location',
            'publicly_queryable' => true,
            'hierarchical' => true,
            'supports' => array('title', 'editor', 'thumbnail', 'page-attributes'),
        ),
        array(
            'slug'        => 'authors',
            'rewrite'     => 'authors',
            'single_name' => 'Author',
            'plural_name' => 'Authors',
            'menu_name'   => 'Authors',
            'show-in-rest'  => false,
            'description' => 'Authors Bio',
            'menu-position'  => 8,
            'dashicon'    => 'dashicons-admin-page',
            'publicly_queryable' => false,
            'hierarchical' => true,
            'supports' => array('title', 'editor', 'thumbnail', 'page-attributes'),
        ),
    );

    foreach ($post_types as $post_type) {
        $post_type_labels = array(
            'name'                  => _x($post_type["plural_name"], 'Post Type General Name', 'hso'),
            'singular_name'         => _x($post_type["single_name"], 'Post Type Singular Name', 'hso'),
            'menu_name'             => __($post_type["menu_name"], 'hso'),
            'name_admin_bar'        => __($post_type["plural_name"], 'hso'),
            'archives'              => __($post_type["single_name"] . ' Archives', 'hso'),
            'attributes'            => __($post_type["single_name"] . ' Attributes', 'hso'),
            'parent_item_colon'     => __('Parent ' . $post_type["single_name"], 'hso'),
            'all_items'             => __('All ' . $post_type["plural_name"], 'hso'),
            'add_new_item'          => __('Add New ' . $post_type["single_name"], 'hso'),
            'add_new'               => __('Add New ' . $post_type["single_name"], 'hso'),
            'new_item'              => __('New ' . $post_type["single_name"], 'hso'),
            'edit_item'             => __('Edit ' . $post_type["single_name"], 'hso'),
            'update_item'           => __('Update ' . $post_type["single_name"], 'hso'),
            'view_item'             => __('View ' . $post_type["single_name"], 'hso'),
            'view_items'            => __('View ' . $post_type["single_name"], 'hso'),
            'search_items'          => __('Search ' . $post_type["single_name"], 'hso'),
            'not_found'             => __('Not found', 'hso'),
            'not_found_in_trash'    => __('Not found in Trash', 'hso'),
            'featured_image'        => __($post_type["single_name"] . ' Image', 'hso'),
            'set_featured_image'    => __('Set ' . $post_type["single_name"] . ' image', 'hso'),
            'remove_featured_image' => __('Remove ' . $post_type["single_name"] . ' image', 'hso'),
            'use_featured_image'    => __('Use as ' . $post_type["single_name"] . ' image', 'hso'),
            'insert_into_item'      => __('Insert into ' . $post_type["single_name"], 'hso'),
            'uploaded_to_this_item' => __('Uploaded to this ' . $post_type["single_name"], 'hso'),
            'items_list'            => __($post_type["single_name"] . ' list', 'hso'),
            'items_list_navigation' => __($post_type["single_name"] . ' list navigation', 'hso'),
            'filter_items_list'     => __('Filter ' . $post_type["single_name"] . ' list', 'hso')
        );

        $post_types_args = array(
            'label'                 => __($post_type["single_name"], 'hso'),
            'description'           => __($post_type["description"], 'hso'),
            'labels'                => $post_type_labels,
            'supports'              => $post_type["supports"],
            // 'taxonomies'            => array('example', 'post_tag'),
            'hierarchical'          => $post_type['hierarchical'],
            'public'                => true,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'show_in_rest'          => $post_type["show-in-rest"],
            'menu_position'         => $post_type["menu-position"],
            'menu_icon'             => $post_type["dashicon"],
            'show_in_admin_bar'     => true,
            'show_in_nav_menus'     => true,
            'can_export'            => true,
            'has_archive'           => true,
            'exclude_from_search'   => false,
            'publicly_queryable'    => $post_type["publicly_queryable"],
            'capability_type'       => 'page',
            'rewrite' =>  array( 'with_front' => false, 'slug' => $post_type['rewrite']),
        );

        $slug = $post_type['slug'];

        /**
         * Gutenberg & Rest API Support
         */
        if (isset($wp_post_types[$slug])) {
            $wp_post_types[$slug]->show_in_rest = true;
            $wp_post_types[$slug]->rest_base = $slug;
            $wp_post_types[$slug]->rest_controller_class = 'WP_REST_Posts_Controller';
        }

        register_post_type($post_type['slug'], $post_types_args);
    }

}

function getPre($fld, $Arr, $Prep = true){
    //$Internet2 = get_field_object('internet', $Provider );
    foreach( $Arr['sub_fields'] as $SubField ){
        if ( $SubField['name'] == 'details' ){
            foreach ( $SubField['sub_fields'] as $SubSubField ){
                if ( $SubSubField['name'] == $fld ){
                    if ( $Prep == true ){
                        return $SubSubField['prepend'];
                    }else{
                        return $SubSubField['append'];
                    }
                }
            }
        }
    }
}

function acf_load_buyer_field_choices( $field ) {
    
    $field['choices'] = array();
    if (isset($_GET['post'])){
        $current_provider =  $_GET['post'];
        if ($current_provider){
            $buyer_ids = get_posts(array(
                'fields'          => 'ids',
                'posts_per_page'  => -1,
                'post_type' => 'build-buyer'
            ));
            $provider_campaigns = [];
            foreach($buyer_ids as $buyer_id){
                $campaigns = get_field('campaign', $buyer_id);
                foreach($campaigns as $campaign){
                    if ($campaign['campaign_name'] == $current_provider){
                        $title = get_the_title($buyer_id);
                        $title_mod = str_replace(' ', '_', strtolower($title));
                        $provider_campaigns[$buyer_id] = $title;
                    }
                }
            }
            $provider_campaigns = array_map('trim', $provider_campaigns);
            if( is_array($provider_campaigns) ) {
                foreach( $provider_campaigns as $key => $provider_campaign ) {
                    $field['choices'][ $key ] = $provider_campaign;
                }
            }
        }
    }

    // return the field
    return $field;
    
}

add_filter('acf/load_field/name=buyer', 'acf_load_buyer_field_choices');

add_action('init', 'bso_blocks_style');
function bso_blocks_style() {
    register_block_style('core/table', [
        'name' => 'bso-table',
        'label' => __('BSO Minimal Table', 'bso'),
    ]);
};

function custom_render_block_core_group ($block_content, $block){
    if ($block['blockName'] === 'core/table' && !is_admin() && !wp_is_json_request()){
        $custom_style = '';
        $figcaption = '';
        if (isset($block['attrs']['className'])){
            $custom_style = $block['attrs']['className'];
        }
        $table_arr = [];
        $contents = $block_content;
        $DOM = new DOMDocument('1.0', 'UTF-8');
        @$DOM->loadHTML($contents);

        $items = $DOM->getElementsByTagName('tr');
        $figcaption_obj = $DOM->getElementsByTagName('figcaption');
        if (is_object($figcaption_obj->item(0))){
            $figcaption = $figcaption_obj->item(0)->nodeValue;
        }
        foreach ($items as $node) {
            $row_arr = [];
            foreach ($node->childNodes as $element) {
                $row_arr[] = $DOM->saveXML($element);
            }
            $table_arr[] = $row_arr;
            
        }
        $header = $table_arr[0];
        array_shift($table_arr);
        $mobile_table = '';
        $mobile_table .= '<figure class="wp-block-table mobile-table '.$custom_style.'"><table>';
        foreach($table_arr as $row){
            foreach($row as $key => $cell){
                $row_class = '';
                if ($key == 0){
                    $row_class = 'top-mobile-row';
                }
                $mobile_table .= '<tr class="'.$row_class.'">'.$header[$key].''.$cell.'</tr>';
            }
        }
        $mobile_table .= '</table>';
        $mobile_table .= '<figcaption>'.$figcaption.'</figcaption></figure>';
        $block_content .= $mobile_table;
    }

    return $block_content;
}

add_filter('render_block', 'custom_render_block_core_group', 10, 2);

function add_page_slug_body_class( $classes ) {
    global $post;
    
    if ( isset( $post ) ) {
        $classes[] = 'page-' . $post->post_name;
    }
    return $classes;
}

add_filter( 'body_class', 'add_page_slug_body_class' );

function custom_scripts() {
    //Load AJAX scripts
    wp_enqueue_script( 'bso-ajax', get_template_directory_uri() . '/js/bso-ajax.js', array( 'jquery') );
    // define ajax url
    $ajax_url = admin_url( 'admin-ajax.php' );
    $site_environment = wp_get_environment_type();
    $theme_path = get_template_directory_uri();
    $script = array('ajaxurl' => $ajax_url, 'site_environment' => $site_environment, 'theme_path' => $theme_path);
    // localize script
    wp_localize_script( 'bso-ajax', 'bso_ajax', $script );
}
add_action( 'wp_enqueue_scripts', 'custom_scripts' );

function get_ctas($provider_id = '', $style = ''){
    $cta_arr = [];
    $phone_icon = '<svg xmlns="http://www.w3.org/2000/svg" height="20" width="20" viewBox="0 0 20 20" fill="currentColor" class="mr-1">
            <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
            </svg>';

    if ($provider_id):
        $partner = get_field('partner', $provider_id);
        $provider_link = get_post_permalink( $provider_id );
        if($partner){
            $buyer_id = get_field('buyer', $provider_id);
            $campaign = get_field( "campaign", $buyer_id );
            foreach($campaign as $key => $camp) {
                $type_of_partnership = $camp['type_of_partnership'];

                if($camp['campaign_name'] == $provider_id){

                    if($type_of_partnership == 'call_center'){
                        $cta_arr['cta_type'] = 'call_center';
                        $cta_arr['cta_text'] = $phone_icon . $camp['call_center'];
                        $cta_arr['cta_link'] = 'tel:'.$camp['call_center'];
                        $cta_arr['variantProvider'] = ['text' => 'Call'];
                        $cta_arr['target'] = '';
                
                    }elseif($type_of_partnership == 'digital_link'){
                        $cta_arr['cta_type'] = 'digital_link';
                        $cta_arr['cta_text'] = 'Order Online';
                        $cta_arr['cta_link'] = $camp['digital_tracking_link'];
                        $cta_arr['target'] = 'target="_blank"';
                        $cta_arr['variantProvider'] = ['text' => 'Order Online'];
                    } else {
                        if ($camp['primary_conversion_method'] == 'call_center'){
                            $cta_arr['cta_type'] = 'call_center';
                            $cta_arr['cta_type2'] = 'digital_link';
                            switch ($style){
                                case 'text-below-button-centered':
                                    $cta_arr['cta_text'] = $phone_icon . $camp['call_center'];
                                    $cta_arr['cta_text2'] = '<p class="mt-2 mb-0 tel-link text-center font-weight-bold">Order Online</p>';
                                    break;
                                default:
                                    $cta_arr['cta_text'] = $phone_icon . $camp['call_center'];
                                    $cta_arr['cta_text2'] = 'Order Online';    
                            }
                            $cta_arr['cta_link'] = 'tel:'.$camp['call_center'];
                            $cta_arr['cta_link2'] = $camp['digital_tracking_link'];
                            $cta_arr['target'] = '';
                            $cta_arr['target2'] = 'target="_blank"';
                            $cta_arr['variantProvider'] = ['text' => 'Call'];
                            $cta_arr['variantProvider2'] = ['text' => 'Order Online', 'url' => $cta_arr['cta_link2']];
                        } else {
                            $cta_arr['cta_type'] = 'digital_link';
                            $cta_arr['cta_type2'] = 'call_center';
                            switch ($style){
                                case 'text-below-button-centered':
                                    $cta_arr['cta_text'] = 'Order Online';
                                    $cta_arr['cta_text2'] = '<p class="mt-2 mb-0 text-center small-text">Call to order:<span class="tel-link font-weight-bold"> '.$camp['call_center'].'</span></p>';
                                    break;
                                default:
                                    $cta_arr['cta_text'] = 'Order Online';
                                    $cta_arr['cta_text2'] = $phone_icon . $camp['call_center'];
                            }
                            $cta_arr['cta_link'] = $camp['digital_tracking_link'];
                            $cta_arr['cta_link2'] = 'tel:'.$camp['call_center'];
                            $cta_arr['target'] = 'target="_blank"';
                            $cta_arr['target2'] = '';
                            $cta_arr['variantProvider'] = ['text' => 'Order Online', 'url' => $cta_arr['cta_link']];
                            $cta_arr['variantProvider2'] = ['text' => 'Call'];
                        }
                    }
                }
                
            }           
        }else{
            if (get_field('display_website_url_or_phone_number', $provider_id) == 'phone'){
                $phone = get_field('phone_number', $provider_id);
                $cta_arr['cta_type'] = 'call_center';
                $cta_arr['cta_text'] = $phone_icon . $phone;
                $cta_arr['cta_link'] = 'tel:'.$phone;
                $cta_arr['target'] = '';
                $cta_arr['variantProvider'] = ['text' => 'Call'];
            } else {
                $cta_arr['cta_type'] = 'digital_link';
                $cta_arr['cta_text'] = 'Learn More';
                $cta_arr['cta_link'] = get_field('brands_website_url',$provider_id);
                $cta_arr['target'] = 'target="_blank"';
                $cta_arr['variantProvider'] = ['text' => 'Learn More'];
            }
        }
    endif;
    return $cta_arr;
}

add_filter('template_include', 'bso_include_locations_template', 1000, 1);
function bso_include_locations_template($template){
    //if it's a 404 page check if it's a programmatic city page
    if(is_page('zip-search')) {
        (isset($_GET['zip'])) ? $zip = $_GET['zip'] : $zip = false;

        global $zipcode;
        $zipcode = $zip;

    }

    return $template;
}

//Move yoast below acf fields
add_filter( 'wpseo_metabox_prio', function() { return 'low'; } );

function my_posts_where( $where ) {
    
    $where = str_replace("meta_key = 'possible_provider_names_$", "meta_key LIKE 'possible_provider_names_%", $where);

    return $where;
}