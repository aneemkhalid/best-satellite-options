<?php

/**
 * Our Thoughts
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

$title = get_field('title');
$text = get_field('text');
$image_src = get_template_directory_uri() . '/images/icons/glasses.svg';
$provider_id = get_field('provider');

if($provider_id) {
    $logo = get_field('logo', $provider_id);
    $link = get_permalink($provider_id);
    $partner = get_field('partner', $provider_id);
    $cta_arr = get_ctas($provider_id);
}

?>

<section class="our-thoughts m-3 m-sm-0">
    <div class="container">
        <div class="row thoughts-container">
            <div class="blue-container col d-flex p-4 p-lg-5">
                <div class="icon-container pr-4">
                    <img src="<?php echo $image_src; ?>" alt="glasses-icon" width="80" height="80">
                </div>
                <div>
                    <?php echo ($title) ? '<h4>'.$title.'</h4>' : '' ?>
                    <?php echo ($text) ? '<div>'.$text.'</div>' : '' ?>
                </div>
            </div>
            <?php if ($provider_id): ?>
            <div class="provider-info col-md-6 col-xl-4 pt-4 pt-md-5 p-3">
                <div class="logo-container d-flex justify-content-center mb-4">
                    <?php if($logo) : ?>
                        <a href="<?php echo $link ?>">
                            <img src="<?php echo $logo ?>" class="provider-logo" alt="provider-logo" width="200" height="80">
                        </a> 
                    <?php endif; ?>
                </div>
                <div class="text-center">
                    <?php if(!empty($cta_arr['cta_text'])) echo '<a href="'.$cta_arr['cta_link'].'" class="btn-primary btn" target="_blank">'.$cta_arr['cta_text'].'</a>'; ?>
                    <?php if(!empty($cta_arr['cta_text2'])) echo '<a href="'.$cta_arr['cta_link2'].'" target="_blank">'.$cta_arr['cta_text2'].'</a>'; ?>
                </div>
            </div>
        <?php endif; ?>
        </div>
    </div>    
</section>