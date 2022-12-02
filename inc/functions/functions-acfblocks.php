<?php 

add_action('acf/init', 'bso_acf_blocks_init');
function bso_acf_blocks_init() {

    // Check function exists.
    if( function_exists('acf_register_block_type') ) {

        acf_register_block_type(array(
            'name'              => 'comparison-tiles',
            'title'             => __('Comparison Tiles'),
            'description'       => __('Between 2-3 providers displayed in tile format.'),
            'render_template'   => 'template-parts/blocks/comparison-tiles.php',
            'category'          => 'acf',
            'mode'              =>  'edit',
        ));
        acf_register_block_type(array(
            'name'              => 'provider-bar',
            'title'             => __('Provider Bar'),
            'description'       => __('Horizontal bar with provider logo, info and cta'),
            'render_template'   => 'template-parts/blocks/provider-bar.php',
            'category'          => 'acf',
            'mode'              =>  'edit',
        ));
        acf_register_block_type(array(
            'name'              => 'comparison-table',
            'title'             => __('Comparison Table'),
            'description'       => __('A table to compare different providers.'),
            'render_template'   => 'template-parts/blocks/comparison-table.php',
            'category'          => 'acf',
            'mode'              =>  'edit',
        ));
        acf_register_block_type(array(
            'name'              => 'small-text',
            'title'             => __('Small Text'),
            'description'       => __('Text formatted to small.'),
            'render_template'   => 'template-parts/blocks/small-text.php',
            'category'          => 'acf',
            'mode'              =>  'edit',
        ));
        acf_register_block_type(array(
            'name'              => 'pros-cons',
            'title'             => __('Pros Cons'),
            'description'       => __('Shows Pros and Cons lists.'),
            'render_template'   => 'template-parts/blocks/pros-cons.php',
            'category'          => 'acf',
            'mode'              =>  'edit',
        ));
        acf_register_block_type(array(
            'name'              => 'image-text-row',
            'title'             => __('Image Text Row'),
            'description'       => __('Shows an image and text side by side.'),
            'render_template'   => 'template-parts/blocks/image-text-row.php',
            'category'          => 'acf',
            'mode'              =>  'edit',
        ));
        acf_register_block_type(array(
            'name'              => 'faqs',
            'title'             => __('FAQs'),
            'description'       => __('A list of FAQs.'),
            'render_template'   => 'template-parts/blocks/faqs.php',
            'category'          => 'acf',
            'mode'              =>  'edit',
        ));
        acf_register_block_type(array(
          'name'              => 'image-text',
          'title'             => __('Image/Text'),
          'description'       => __('Image/Text Block.'),
          'render_template'   => 'template-parts/blocks/image-text.php',
          'category'          => 'acf',
          'mode'              =>  'edit',
      ));
      acf_register_block_type(array(
        'name'              => 'blue-zip',
        'title'             => __('Blue Zip'),
        'description'       => __('Blue Zip Search'),
        'render_template'   => 'template-parts/blocks/blue-zip.php',
        'category'          => 'formatting',
        'mode'              =>  'edit',
    ));
    acf_register_block_type(array(
        'name'              => 'features-highlight',
        'title'             => __('Features Highlight'),
        'description'       => __('A section to highlight features'),
        'render_template'   => 'template-parts/blocks/features-highlight.php',
        'category'          => 'formatting',
        'mode'              =>  'edit',
    ));
    acf_register_block_type(array(
        'name'              => 'aggregate-pros-cons',
        'title'             => __('Aggregate Pros/Cons'),
        'description'       => __('An aggregated section of pros/cons'),
        'render_template'   => 'template-parts/blocks/aggregate-pros-cons.php',
        'category'          => 'formatting',
        'mode'              =>  'edit',
    ));
    acf_register_block_type(array(
        'name'              => 'deals-tile',
        'title'             => __('Deals Tile'),
        'description'       => __('A tile displaying one or more provider deals'),
        'render_template'   => 'template-parts/blocks/deals-tile.php',
        'category'          => 'formatting',
        'mode'              =>  'edit',
    ));
    acf_register_block_type(array(
        'name'              => 'our-thoughts',
        'title'             => __('Our Thoughts'),
        'description'       => __('A bar with some thoughts on the provider and a cta button'),
        'render_template'   => 'template-parts/blocks/our-thoughts.php',
        'category'          => 'formatting',
        'mode'              =>  'edit',
    ));
    acf_register_block_type(array(
        'name'              => 'zip-provider-table',
        'title'             => __('Zip Provider Table'),
        'description'       => __('Provider Table'),
        'render_template'   => 'template-parts/blocks/zip-provider-table.php',
        'category'          => 'acf',
        'mode'              =>  'edit',
    ));
    }
}

//New block category for acf blocks
add_filter( 'block_categories', function($categories, $post) {
  return array_merge(
    array(
      array(
        'slug' => 'acf',
        'title' => 'ACF Blocks',
      ),
    ),
    $categories
  );
}, 10, 2);