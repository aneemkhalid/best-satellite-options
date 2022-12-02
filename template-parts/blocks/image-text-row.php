<?php

/**
 * Image & Text Row
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

$title = get_field('title');
$text = get_field('text', false, false);
$image = get_field('image');
$image_url = $image_alt = '';
if ($image){
    $image_url = $image['url'];
    $image_alt = $image['alt'];
}
$image_url = ($image_url) ? $image_url : get_template_directory_uri() . '/images/satellite-internet.svg';
$image_alt = ($image_alt) ? $image_alt : 'satellite internet';

?>

<div class="image-text-row p-5">
    <div class="container">
        <div class="row">
            <div class="col-5 p-0 mr-3 image-row">
                <?php if ($image_url): ?>
                    <img src="<?php echo $image_url; ?>" alt="<?php echo $image_alt; ?>" width="380" height="380">
                <?php endif; ?>  
            </div>
            <div class="col p-0 ml-sm-3">
                <?php echo ($title) ? '<h3>'.$title .'</h3>' : ''; ?>
                <?php echo ($text) ? '<p>'.$text .'</p>' : ''; ?>
            </div>
        </div>
    </div> 
</div>
