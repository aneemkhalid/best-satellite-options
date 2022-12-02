<?php

/**
 * Blue Zip Block.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

$blue_zip = get_field('bue_zip');

if($blue_zip) :
?>
<div class="d-flex flex-column align-items-center p-5 zipcode_wrap">
    <?php if($blue_zip['title']) : ?>
        <h3 class="text-center mb-4"><?php echo $blue_zip['title']; ?></h3>
        <?php else : ?>
            <h3 class="text-center mb-4">Enter your zip code to see providers near you</h3>
    <?php endif; ?> 
    <?php get_template_part( 'template-parts/zip-search-form' ); ?>
</div>
<?php endif; ?>

