<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package wp-bestsatelliteoptions
 */

$footer_logo = get_field('footer_logo', 'options');
$footer_disclaimer_text = get_field('footer_disclaimer_text', 'options');
$footer_logo = ($footer_logo == '') ? get_template_directory_uri().'/images/bestsatelliteoptions_footer_logo.svg' : $footer_logo;
$footer_background = get_template_directory_uri() . '/images/BSO_circle.svg';

?>

<footer class="page-footer">
    <div class="footer-background" style="background-image: url(<?php echo $footer_background; ?>);">
        <div class="container pt-5 pb-5">
            <div class="row">
                <div class="col-lg-6 col-12">
                    <div class="footer-logo mb-3">
                        <a href="<?php echo site_url(); ?>">
                            <img src="<?php echo $footer_logo; ?>" alt="hso logo" width="283" height="31">
                        </a>
                    </div>  
                    <div class="left pr-5">
                    <div class="mb-3"><?php echo $footer_disclaimer_text; ?></div>
                    <p>© Copyright <?php echo date('Y'); ?> BestSatelliteOptions</p>
                    <?php 
                            wp_nav_menu( $args = array(
                                'menu'              => "privacy", // (int|string|WP_Term) Desired menu. Accepts a menu ID, slug, name, or object.
                                'menu_class'        => "privacy-menu", // (string) CSS class to use for the ul element which forms the menu. Default 'menu'.
                                'menu_id'           => "privacy-menu", // (string) The ID that is applied to the ul element which forms the menu. Default is the menu slug, incremented.
                                'container'         => "ul", // (string) Whether to wrap the ul, and what to wrap it with. Default 'div'.
                                'theme_location'    => "privacy", // (string) Theme location to be used. Must be registered with register_nav_menu() in order to be selectable by the user.
                            ) );
                        ?>  
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-6">
                    <a href="/providers"><h6 class="mb-2">Providers</h6></a>
                    <?php 
                        wp_nav_menu( $args = array(
                            'menu'              => "providers", // (int|string|WP_Term) Desired menu. Accepts a menu ID, slug, name, or object.
                            'menu_class'        => "listing", // (string) CSS class to use for the ul element which forms the menu. Default 'menu'.
                            'menu_id'           => "providers-menu", // (string) The ID that is applied to the ul element which forms the menu. Default is the menu slug, incremented.
                            'container'         => "ul", // (string) Whether to wrap the ul, and what to wrap it with. Default 'div'.
                            'theme_location'    => "providers", // (string) Theme location to be used. Must be registered with register_nav_menu() in order to be selectable by the user.
                        ) );
                    ?>
                    <div class="mt-2 mb-4">
                        <?php get_template_part( 'template-parts/zip-search-form-alt' ); ?>
                    </div>    

                </div>
                <div class="col-lg-3 col-md-4 col-6">
                    <div class="resources">
                        <h6 class="mb-0">Resources</h6>
                        <?php 
                        wp_nav_menu( $args = array(
                            'menu'              => "resources", // (int|string|WP_Term) Desired menu. Accepts a menu ID, slug, name, or object.
                            'menu_class'        => "listing", // (string) CSS class to use for the ul element which forms the menu. Default 'menu'.
                            'menu_id'           => "resources-menu", // (string) The ID that is applied to the ul element which forms the menu. Default is the menu slug, incremented.
                            'container'         => "ul", // (string) Whether to wrap the ul, and what to wrap it with. Default 'div'.
                            'theme_location'    => "resources", // (string) Theme location to be used. Must be registered with register_nav_menu() in order to be selectable by the user.
                        ) );
                    ?>
                    </div>
                    <div class="company">
                        <h6 class="mb-0">Company</h6>
                        <?php 
                            wp_nav_menu( $args = array(
                                'menu'              => "company", // (int|string|WP_Term) Desired menu. Accepts a menu ID, slug, name, or object.
                                'menu_class'        => "listing", // (string) CSS class to use for the ul element which forms the menu. Default 'menu'.
                                'menu_id'           => "company-menu", // (string) The ID that is applied to the ul element which forms the menu. Default is the menu slug, incremented.
                                'container'         => "ul", // (string) Whether to wrap the ul, and what to wrap it with. Default 'div'.
                                'theme_location'    => "company", // (string) Theme location to be used. Must be registered with register_nav_menu() in order to be selectable by the user.
                            ) );
                        ?>
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-6">
                </div>
                <div class="col-xl-5 col-lg-4 col-12">
                    <div class="left mobile">
                        <div class="mb-3"><?php echo $footer_disclaimer_text; ?></div>
                        <p>© Copyright <?php echo date('Y'); ?> BestSatelliteOptions</p>
                        <?php 
                                wp_nav_menu( $args = array(
                                    'menu'              => "privacy", // (int|string|WP_Term) Desired menu. Accepts a menu ID, slug, name, or object.
                                    'menu_class'        => "privacy-menu", // (string) CSS class to use for the ul element which forms the menu. Default 'menu'.
                                    'menu_id'           => "privacy-menu", // (string) The ID that is applied to the ul element which forms the menu. Default is the menu slug, incremented.
                                    'container'         => "ul", // (string) Whether to wrap the ul, and what to wrap it with. Default 'div'.
                                    'theme_location'    => "privacy", // (string) Theme location to be used. Must be registered with register_nav_menu() in order to be selectable by the user.
                                ) );
                            ?>
                    </div>
                </div>
            </div>
        </div>
    </div>    
</footer>

<?php wp_footer(); ?>

</body>
</html>
