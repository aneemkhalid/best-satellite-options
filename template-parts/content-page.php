<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package wp-bestsatelliteoptions
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
        <?php get_template_part( 'template-parts/breadcrumbs', null, array( 'has_banner' => false ) ); ?>
		<?php the_title( '<h1>', '</h1>' ); ?>
	</header><!-- .entry-header -->

	<?php wp_bestsatelliteoptions_post_thumbnail(); ?>

	<div class="entry-content">
		<?php
		the_content();
	
		?>
	</div><!-- .entry-content -->


</article><!-- #post-<?php the_ID(); ?> -->
