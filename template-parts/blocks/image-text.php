<?php
/**
 * Image/Text Block
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

$content = get_field('content');
$image = get_field('image');
$bg = get_field('bg_color');
$pos = ($side = get_field('image_position')) ? 'img-left' : 'img-right';
$bg_class = ($bg) ? 'has-bg' : '';

?>

<div class="image-text-block py-5 row-full <?php echo $pos . ' ' . $bg_class ?>" style="background-color: <?php echo $bg; ?>;">
    <div class="container px-xl-0">
        <div class="row">
          <div class="col-12 mb-3 col-md-8 col-lg-6 content-container">
            <?php echo $content; ?>
          </div>
          <div class="col-12 p-0 img-container col-md-4 col-lg-6">
            <div class="d-flex justify-content-center px-4">
              <?php
                if ($image):
                  echo wp_get_attachment_image( $image['ID'], 'large',  );
                endif; 
              ?>  
            </div>
          </div>
        </div>
    </div> 
</div>
