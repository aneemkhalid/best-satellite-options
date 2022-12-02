<?php

/**
 * Deals Tile
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

$provider_id = get_field('provider');

if ($provider_id):

    $logo = get_field('logo', $provider_id);
    $provider_link = get_permalink($provider_id);
    $title = get_field('title');
    $text = get_field('text');
    $cta_arr = get_ctas($provider_id);

    ?>

    <section class="deals-tile container border-radius-20 p-4 p-md-5">
        <div class="row mb-4">
            <div class="col">
                <?php if($logo): ?>
                    <a href="<?php echo $provider_link ?>">
                        <img src="<?php echo $logo ?>" alt="provider-logo" class="provider-logo" width="200" height="70">
                    </a>
                <?php endif; ?>
            </div>    
        </div>
        <div class="row">
            <div class="col-md-6">
                <?php echo ($title) ? '<h3 class="mb-5">'.$title.'</h3>' : ''; ?>
            </div>    
        </div>
        <div class="row">
            <div class="col">
                <?php echo ($text) ? '<div class="pr-md-4 mb-4">'.$text.'</div>' : ''; ?>
                <div class="text-center text-md-left">
                    <?php if(!empty($cta_arr['cta_text'])) echo '<a href="'.$cta_arr['cta_link'].'" class="btn-primary btn" target="_blank">'.$cta_arr['cta_text'].'</a>'; ?>
                    <?php if(!empty($cta_arr['cta_text2'])) echo '<a href="'.$cta_arr['cta_link2'].'" target="_blank">'.$cta_arr['cta_text2'].'</a>'; ?>
                </div>
            </div>    
        </div>
    </section>
<?php endif;    