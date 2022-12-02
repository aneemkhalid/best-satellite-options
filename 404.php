<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package wp-bestsatelliteoptions
 */

$info = get_field('404', 'options');
$title = $info['title'];
$content = $info['content'];

get_header();
?>
<div class="container">
	<div class="page-not-found text-center">
		<img class="before" src="<?php echo get_template_directory_uri() ?>/images/page-404.png" alt="404">
		<div class="page-not-found-content">
			<h1 ><?php echo $title ?></h1>
			<p><?php echo $content ?></p>
			<a class="btn-primary btn" href="<?php echo site_url(); ?>">Visit Homepage</a>
		</div>
        <img class="after" src="<?php echo get_template_directory_uri() ?>/images/page-404.png" alt="404">
	</div>
</div>

<?php
get_footer();
