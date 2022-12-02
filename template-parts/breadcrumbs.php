<?php 

if (array_key_exists('is_blog', $args) && $args['is_blog']):
?>
<div class="d-flex justify-content-between breadcrumbs-container pt-3 pb-3 flex-column flex-md-row is_blog">
    <nav aria-label="breadcrumb">
            <ol class="breadcrumbs-list d-flex align-items-center">
                <span>
                    <span>
                        <a href="<?php echo site_url() ?>">
                            <span class="material-icons">home</span>
                        </a> 
                        <span class="material-icons chevron">chevron_right</span> 
                        <a href="/resources">
                            Resources
                        </a> 
                        <?php if (is_singular('post')): ?>
                        <span class="material-icons chevron">chevron_right</span> 
                        <span class="breadcrumb_last" aria-current="page">Article</span>
                        <?php else: ?>
                            Insights
                        <?php endif; ?>
                    </span>
                </span>
            </ol>
    </nav>
    <div class="advertiser-disclosure-link-container">
        <?php if(array_key_exists('has_advertiser_disclosure_link', $args) && $args['has_advertiser_disclosure_link']): ?>
            <a href="<?php echo site_url('disclosure'); ?>" class="advertiser-disclosure-link extra-small-text">Advertiser Disclosure</a>
        <?php endif; ?>
    </div>
</div>
<?php else: ?>
<div class="d-flex justify-content-between breadcrumbs-container pt-3 pb-3">
    <nav aria-label="breadcrumb">
        <?php
            if ( function_exists('yoast_breadcrumb') && !is_front_page() && (isset($args['exclude_breadcrumbs']) && !$args['exclude_breadcrumbs'])) {
                yoast_breadcrumb( '<ol class="breadcrumbs-list d-flex align-items-center">','</ol>' );
            }
        ?>
    </nav>
    <div class="advertiser-disclosure-link-container">
        <?php if(array_key_exists('has_advertiser_disclosure_link', $args) && $args['has_advertiser_disclosure_link']): ?>
            <a href="<?php echo site_url('disclosure'); ?>" class="advertiser-disclosure-link extra-small-text">Advertiser Disclosure</a>
        <?php endif; ?>
    </div>
</div>
<?php endif; ?>