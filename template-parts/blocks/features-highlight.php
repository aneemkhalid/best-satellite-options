<?php

/**
 * Features Highlight
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

$title = get_field('title');
$subtext = get_field('subtext');
$feature_tiles = get_field('feature_tiles');

?>
<div class="container">
    <section class="features-highlight-container px-5 px-sm-0">
        <?php if ($subtext):?><div class="sub-title font-weight-bold mb-3"><?php echo $subtext; ?></div><?php endif;?>
        <?php if ($title):?><h2 class="mb-4 mb-md-5"><?php echo $title;  ?></h2><?php endif;?>
        <div class="row">
            <?php
            // Loop through rows.
            foreach($feature_tiles as $tile): ?>

                <div class="col-12 col-sm-6 col-xl-3 mb-3 mb-md-4">
                    <?php
                    if ($tile['icon'] != 'other'){
                        $src = get_template_directory_uri() . '/images/icons/'.$tile['icon'].'.svg';
                        $alt = $tile['icon'];

                    } else {
                        $src = $tile['upload_icon']['url'];
                        $alt = $tile['upload_icon']['alt'];

                    } ?>
                    <div class="icon-container border-radius-20 d-flex justify-content-center align-items-center my-4">
                        <img src="<?php echo $src; ?>" alt="<?php echo $alt; ?>">
                    </div>
                    <h4><?php echo $tile['title']; ?></h4>
                    <?php echo ($tile['text']) ? '<p class="small-text">'.$tile['text'].'</p>' : ''; ?>
                </div>

            <?php endforeach;   ?>
        </div>    
    </section>
</div>    