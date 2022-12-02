<?php
/**
 * Sample implementation of the Custom Header feature
 *
 * You can add an optional custom header image to header.php like so ...
 *
	<?php the_header_image_tag(); ?>
 *
 * @link https://developer.wordpress.org/themes/functionality/custom-headers/
 *
 * @package wp-bestsatelliteoptions
 */

/**
 * Set up the WordPress core custom header feature.
 *
 * @uses wp_bestsatelliteoptions_header_style()
 */
function wp_bestsatelliteoptions_custom_header_setup() {
	add_theme_support(
		'custom-header',
		apply_filters(
			'wp_bestsatelliteoptions_custom_header_args',
			array(
				'default-image'      => '',
				'default-text-color' => '000000',
				'width'              => 1000,
				'height'             => 250,
				'flex-height'        => true,
				'wp-head-callback'   => 'wp_bestsatelliteoptions_header_style',
			)
		)
	);
}
add_action( 'after_setup_theme', 'wp_bestsatelliteoptions_custom_header_setup' );

if ( ! function_exists( 'wp_bestsatelliteoptions_header_style' ) ) :
	/**
	 * Styles the header image and text displayed on the blog.
	 *
	 * @see wp_bestsatelliteoptions_custom_header_setup().
	 */
	function wp_bestsatelliteoptions_header_style() {
		$header_text_color = get_header_textcolor();

		/*
		 * If no custom options for text are set, let's bail.
		 * get_header_textcolor() options: Any hex value, 'blank' to hide text. Default: add_theme_support( 'custom-header' ).
		 */
		if ( get_theme_support( 'custom-header', 'default-text-color' ) === $header_text_color ) {
			return;
		}

		// If we get this far, we have custom styles. Let's do this.
		?>
		<style type="text/css">
		<?php
		// Has the text been hidden?
		if ( ! display_header_text() ) :
			?>
			.site-title,
			.site-description {
				position: absolute;
				clip: rect(1px, 1px, 1px, 1px);
				}
			<?php
			// If the user has set a custom color for the text use that.
		else :
			?>
			.site-title a,
			.site-description {
				color: #<?php echo esc_attr( $header_text_color ); ?>;
			}
		<?php endif; ?>
		</style>
		<?php
	}
endif;


function create_primary_nav_html($menu_title, $is_sidebar = false) {
    $menu = prepare_menu_items($menu_title);

    $responsive_menu_classes = '';
    $selector = $is_sidebar ? '-sidebar' : '';
    $responsive_menu_classes = $is_sidebar ? 'flex-column justify-content-start align-items-center pt-4' : '';
    $html = '<ul id="primary-menu'. $selector .'" class="primary-menu d-flex align-items-center mb-0'. $selector .' '.$responsive_menu_classes.'">';
    $submenu_html = '';

    // featured resource element - configured in theme settings
    $enable_featured_resource = get_field('enable_featured_resource_nav_item', 'option');
    $featured_resource_group = get_field('featured_resource_nav_item', 'option');
    $featured_resource_image_id = null;
    $featured_resource_title = null;
    $featured_resource_description = null;
    $featured_resource_link = null;
    $featured_resource_class = null;

    if( $enable_featured_resource ){
        $featured_resource_image_id = $featured_resource_group['image']['id'];
        $featured_resource_title = $featured_resource_group['title'];
        $featured_resource_description = $featured_resource_group['description'];
        $featured_resource_link = $featured_resource_group['link'];
    }

    if( is_array($menu) ) {
        foreach($menu as $item) {
            extract($item);
            $svg = $parent_class = $list_item_sidebar_class = $svg_class = '';
            if(array_key_exists('submenu', $item)) {
            	if ($is_sidebar) {
            		$svg_class = 'mt-2';
            	}
            	$svg= '<svg class="ml-2 '.$svg_class.' submenu-arrow" width="13" height="9" viewBox="0 0 13 9" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M0.999988 1.37257L6.37256 6.74514L11.7451 1.37257" stroke="#002772" stroke-width="2"/></svg>';
            	$parent_class = 'is_parent_nav';
            }

            if ($is_sidebar){
            	$list_item_sidebar_class = 'text-right';
            }

            $html .= '<li id="menu-item-'. $id .'" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-'. $id . ' ' . $classes . ' '. $parent_class . ' '. $list_item_sidebar_class.' mr-xl-4" data-parent-menu-title="'. strtolower($title) .'"><a href="'. $url .'" class="menu-item-link">'. $title;
            $html .= $svg;

            $html .= '</a>';
            if(array_key_exists('submenu', $item)) {
                // check if current menu item is using featured resource
                if( !empty($classes) && strpos($classes, 'menu-item-resource') >= 0 && $enable_featured_resource){
                    $featured_resource_class = ' featured-resource-active';
                }
                $html .= '<div class="submenu-container ' . $featured_resource_class . '">';
                $see_all_item = null;


                if($is_sidebar) {
                    // if using the featured resource submenu and it is enabled
                    if( !empty($classes) && strpos($classes, 'menu-item-resource') >= 0 && $enable_featured_resource){
                        $html .= 
                            '<div class="featured-resource-nav-item">' . 
                                '<a href="' . esc_url($featured_resource_link) . '" class="featured-resource-link">' .
                                    '<p class="featured-resource-title">' . $featured_resource_title . '</p>' . 
                                    '<div class="featured-resource-description-cont">' . $featured_resource_description . '</div>' . 
                                '</a>' . 
                            '</div>';
                    }
                    $html .= '<ul class="submenu p-0" data-parent-menu-title="'. strtolower($title) .'">';
                } else {
                    $submenu_2_col = '';
                    if( count($item['submenu']) > 5 ){
                        $submenu_2_col = ' submenu-2-col';
                    }

                    // if using the featured resource submenu and it is enabled
                    if( !empty($classes) && strpos($classes, 'menu-item-resource') >= 0 && $enable_featured_resource){
                        $html .= 
                        '<div class="featured-resource-nav-item">' . 
                            '<a href="' . esc_url($featured_resource_link) . '" class="featured-resource-link">' .
                                wp_get_attachment_image($featured_resource_image_id, 'small') . 
                                '<p class="featured-resource-title">' . $featured_resource_title . '</p>' . 
                                '<div class="featured-resource-description-cont">' . $featured_resource_description . '</div>' . 
                            '</a>' . 
                        '</div>';
                    }
                    $html .= '<div class="submenu-inner border-radius-bottom-20">';
                    $html .= '<ul class="submenu p-0'. $submenu_2_col .'">';
                }
                $sub_count = 1;
                foreach($item['submenu'] as $k => $subitem) {

                	$last_submenu = count($item['submenu']);
                    $subitem_id = $subitem['id'];
                    $subitem_title = $subitem['title'];
                    $subitem_url = $subitem['url'];
                    $subitem_classes = $subitem['classes'];

                    if($is_sidebar) {
                        $subitem_seeall = null;
                        if(!empty($subitem_classes) && strpos($subitem_classes, 'nav-item-see-all') >= 0){
                            $subitem_seeall = ' nav-item-see-all';
                        }
                        if ($sub_count == 1){
                        	$html .= '<li class="back-item"><a>Back<svg class="ml-2 mt-2 submenu-arrow" width="13" height="9" viewBox="0 0 13 9" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M0.999988 1.37257L6.37256 6.74514L11.7451 1.37257" stroke="#0878C9" stroke-width="2"/></svg></a></li>';
                        }
                        $html .= '<li id="submenu-item-'. $subitem_id .'" class="submenu-item submenu-item slide-in-menu submenu-item-'. $subitem_id . $subitem_seeall .' text-right"><a href="'. $subitem_url .'">'. $subitem_title . '</a></li>';
                    } else {

                    	$extra_class = '';
                    	if ($sub_count == $last_submenu){
                    		$extra_class .= 'border-radius-bottom-20';
                    	}
                        $html .= '<li id="submenu-item-'. $subitem_id .'" class="submenu-item submenu-item submenu-item-'. $subitem_id . ' ' . $subitem_classes .' '.$extra_class.' pt-3 pb-3 pl-4 pr-4"><a href="'. $subitem_url .'"><span class="submenu-item-text">'. $subitem_title . '</span></a></li>';
                    }
                    $sub_count++;
                }
                if($is_sidebar) {
                    // $html .= '<li id="submenu-item-back-'. strtolower($title) .'" class="submenu-item submenu-item-back-link submenu-item-back-'. strtolower($title) .'" data-parent-menu-title="'. strtolower($title) .'"><a href="#"><span class="material-icons">chevron_left</span> Back</a></li></ul>';
                } else {
                    $html .= '</ul>';
                }
                // add see all button to nav dropdown
                if( !empty($see_all_item) ){
                    $html .= $see_all_item;
                }
                // close submenu inner
                if( !$is_sidebar ){
                    $html .= '</div>';
                }

                $html .= '</div>';
            }
            $html .= '</li>';
        }
        $html .= '</ul>';
    }

    return $is_sidebar ? $html . $submenu_html : $html;

}

function prepare_menu_items($menu_title) {
    // Obtain array of menu objects from the $menu_title
    $menu_items = wp_get_nav_menu_items( $menu_title );

    $prepared_menu_items = [];
    if( is_array( $menu_items ) ) {
        foreach($menu_items as $item) {
            // Values with no parent are highest level menu items
            if( !$item->menu_item_parent ) {
                $parent_obj = array();
                $parent_obj['id'] = $item->ID;
                $parent_obj['title'] = $item->title;
                $parent_obj['url'] = $item->url;
                $parent_obj['classes'] = implode( ' ', $item->classes );
                
                $prepared_menu_items[$item->ID] = $parent_obj;
            } else {
                $child_obj = array();
                $child_obj['id'] = $item->ID;
                $child_obj['title'] = $item->title;
                $child_obj['url'] = $item->url;
                $child_obj['classes'] = implode( ' ', $item->classes );
                
                $prepared_menu_items[$item->menu_item_parent]['submenu'][$item->ID] = $child_obj;
            }
        }
    }

    return $prepared_menu_items;
}
