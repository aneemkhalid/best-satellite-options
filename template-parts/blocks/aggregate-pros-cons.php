<?php

/**
 * Aggregate Pros/Cons
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

$title = get_field('title');
$text = get_field('text');
$pros_title = get_field('pros_title');
$cons_title = get_field('cons_title');
$pros = get_field('pros');
$cons = get_field('cons');
$legal_text = get_field('legal_text');
?>

<section class="aggregate-pros-cons">
    <div class="container py-5 px-sm-6">
        <div class="row justify-content-center px-3 px-sm-0 px-lg-5">
            <?php echo ($title) ? '<h2 class="text-center">'.$title.'</h2>' : '' ?>
            <?php echo ($text) ? '<div class="px-lg-6 mb-4 text-center">'.$text.'</div>' : '' ?>
        </div>
        <div class="row pros-cons-container p-0 p-lg-5">
            <?php if (is_array($pros)): ?>
                <div class="pros-cons-list col-12 col-lg-6 pr-lg-4 p-4 p-lg-0 mb-4 mb-lg-0">
                    <?php echo ($pros_title) ? '<p class="font-weight-bold">'.$pros_title.'</p>' : '' ?>
                    <ul class="pros-cons-list">
                        <?php foreach ($pros as $pro){
                            echo '<li class="li-pro">'.$pro['pro'].'</li>';
                        } ?>
                    </ul>
                </div>
            <?php endif; ?>
            <?php if (is_array($cons)): ?>
                <div class="pros-cons-list col-12 col-lg-6 pl-lg-4 p-4 p-lg-0">
                    <?php echo ($cons_title) ? '<p class="font-weight-bold">'.$cons_title.'</p>' : '' ?>
                    <ul class="pros-cons-list">
                        <?php foreach ($cons as $con){
                            echo '<li class="li-con">'.$con['con'].'</li>';
                        } ?>
                    </ul>
                </div>
            <?php endif; ?>

        </div>
        <?php if ($legal_text): ?>
            <div class="row small-text mt-5 px-3 px-sm-0">
                <p><?php echo $legal_text; ?></p>
            </div>  
        <?php endif; ?>  

    </div>    
</section>