<?php
/**
 * Comparison Tiles Block.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

$comparison_tiles_providers = get_field('comparison_tiles_providers');
$disclaimer = get_field('disclaimer');

$element_pb = ($disclaimer) ? 'pb-3' : 'pb-5';

if($comparison_tiles_providers){ ?>
    <div class="comparison-tiles-container border-radius-30 mx-auto pl-0 pr-0 pt-5 <?php echo $element_pb; ?> pl-xl-6 pr-xl-6">
        <div class="container">
            <div class="row justify-content-between">
            <?php
            foreach($comparison_tiles_providers as $key => $provider):

                $provider_id = $provider['provider'];
                $logo = get_field('logo', $provider_id);
                $permalink = get_permalink($provider_id);
                if ($provider['superlative']['superlative_icon'] == 'other'){
                    $sup_icon = $provider['superlative']['icon_upload'];
                    $sup_alt = 'providers comparison';

                } else {
                    $sup_icon = get_template_directory_uri() . '/images/icons/'.$provider['superlative']['superlative_icon'].'.svg';
                    $sup_alt = $provider['superlative']['superlative_icon'];
                }
                $provider['cta_text'] = ($provider['cta_text']) ? $provider['cta_text'] : 'View Plans';
                ?>
                <div class="col-12 col-lg-4 comparison-tile d-flex flex-column justify-content-between mx-auto border-radius-20 px-0 pb-3 mb-4 mb-lg-0 mx-lg-auto">
                    <div class="superlative-row d-flex justify-content-center align-items-center border-radius-top-20 p-3">
                        <img src="<?php echo $sup_icon ?>" alt="<?php echo $sup_alt; ?>" class="mr-3" width="30" height="30">
                        <p class="superlative-text font-weight-bold mb-0"><?php echo $provider['superlative']['superlative_text']; ?></p>
                    </div>
                    <div class="pt-4 px-4 pb-3">
                        <img class="mx-auto d-block provider-logo" height="45" width="170" src="<?php echo $logo; ?>">
                    </div>
                    <div class="features pl-4 pr-4 pb-3">
                        <ul class="ml-5">
                        <?php foreach ($provider['provider_features'] as $feature){
                            echo '<li class="li-done ml-0 pl-0">'.$feature['feature'].'</li>';
                        }
                        ?>
                        </ul>
                    </div>
                    <div class="pb-4 text-center">
                        <a href="<?php echo $permalink; ?>" class="btn-primary btn"><?php echo $provider['cta_text']; ?></a>
                    </div>
                </div>

                <?php
            endforeach; ?>
            </div>
            <?php if ($disclaimer): ?>
                <div class="extra-small-text mx-4 mt-4 mx-lg-3"><?php echo $disclaimer; ?></div>
            <?php endif; ?>
        </div> 
    </div>    
    <?php  
}