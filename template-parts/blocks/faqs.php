<?php

/**
 * FAQ List Block.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

$faqs = get_field('faqs');
$faqs_title = get_field('faqs_title');
$faqs_subtext = get_field('faqs_subtext');
$arrow_url = get_template_directory_uri() . '/images/icons/arrow-blue-circle.svg';
if( have_rows('faqs') ): ?>
    <div class="container">
        <section class="faqs-container">
            <?php if ($faqs_subtext):?><div class="sub-title font-weight-bold mb-3"><?php echo $faqs_subtext; ?></div><?php endif;?>
            <?php if ($faqs_title):?><h3 class="mb-5"><?php echo $faqs_title;  ?></h3><?php endif;?>
                <?php
                // Loop through rows.
                foreach($faqs as $faq): ?>

                    <div class="faq-card border-radius-10 p-4 pl-sm-5 mb-4">
                        <div class="faq-title-container d-flex justify-content-between align-items-center mb-3">
                            <h4 class="mb-0"> <?php echo $faq['question']; ?></h4>
                            <img src="<?php echo $arrow_url; ?>" alt="arrow" width="48" height="48">
                        </div>    
                        <p class="pr-sm-5"><?php echo str_replace(['<p>', '</p>'], '', $faq['answer']); ?></p>
                    </div>

                <?php endforeach;	?>
        </section>
    </div>    
<?php endif; ?>

