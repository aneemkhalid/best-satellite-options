<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package wp-bestsatelliteoptions
 */

$author = get_field('select_article_author');

if($author){
	$authorName = get_field('select_article_author');
}else{
	$authorName = get_the_author();
}
?>

<?php $toc = ( get_field('toc_toggle') ) ? 'toc-sidebar' : ''; ?>
<article id="post-<?php the_ID(); ?>" <?php post_class($toc); ?>>
	<header class="entry-header mb-5">
		<?php
		if ( is_singular() ) :
			the_title( '<h1>', '</h1>' );
		else :
			the_title( '<h2><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		endif;

		if ( 'post' === get_post_type() ) :
			?>
			<div class="entry-meta d-flex justify-content-between mb-4 align-items-center">
				<div class="author-info">
					<div class="author">By <?php echo $authorName; ?></div>
					<div class="date"><?php echo get_the_date(); ?></div>
				</div>
				<div class="entry-social d-flex align-items-center">
					<span class="mr-3 mb-sm-0 mb-1">Share this post</span>
					<div class="social-icons d-flex">
						<a class="pl-0" id="facebook" href="https://www.facebook.com/sharer?u=<?php the_permalink() ?>&amp;t=<?php the_title(); ?>" target="_blank" rel="noopener noreferrer">
							<div class="social-icon" style="background-image: url('<?php echo get_template_directory_uri(). '/images/icons/facebook_social_share.svg'; ?>');"></div>
						</a>
						<a id="twitter" href="https://twitter.com/intent/tweet?url=<?php the_permalink() ?>&amp;text=<?php the_title(); ?>" target="_blank" rel="noopener noreferrer">
							<div class="social-icon" style="background-image: url('<?php echo get_template_directory_uri(). '/images/icons/twitter_social_share.svg'; ?>');"></div>
						</a>
						<a id="linkedin" href="https://www.linkedin.com/shareArticle?mini=true&amp;url=<?php the_permalink() ?>" target="_blank" rel="noopener noreferrer">
							<div class="social-icon" style="background-image: url('<?php echo get_template_directory_uri(). '/images/icons/linkedin_social_share.svg'; ?>');"></div>
						</a>
					</div>
				</div>
			</div><!-- .entry-meta -->
		<?php endif; ?>
	</header><!-- .entry-header -->

	<?php wp_bestsatelliteoptions_post_thumbnail(); ?>
	
	<div class="content-container d-flex">
		<div class="main-content order-0">
			<?php if( get_field('toc_toggle') ) : ?>
			<div class="entry-content d-flex flex-column sidebar-added">
				<?php else : ?>	
					<div class="entry-content d-flex flex-column">   
				<?php endif; ?> 
				<div class="disclaimer-block">
					<p>BestSatelliteOptions is reader supported. When you make purchases through links on our site, we may earn a commission. a	<a href="">Learn how</a>.</p>
				</div>
				<?php
				the_content(
					sprintf(
						wp_kses(
							/* translators: %s: Name of current post. Only visible to screen readers */
							__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'wp-bestsatelliteoptions' ),
							array(
								'span' => array(
									'class' => array(),
								),
							)
						),
						wp_kses_post( get_the_title() )
					)
				);
				?>
			</div><!-- .entry-content -->
		</div>

		<?php if( get_field('toc_toggle') ) : ?>

		<div class="right">
			<div class="toc-wrapper">
				<?php echo do_shortcode('[toc]'); ?>
				<style>
					<?php
					 if( !get_field('toc_heading') ) {
                        $toc_title = 'Table of Contents'; 
                    } else {
                       $toc_title = get_field("toc_heading"); 
                    } 
					 ?>

					.content-container .right .ez-toc-title-container:before, .content-container .main-content .ez-toc-title-container:before{
						position: absolute;
						content:'<?php echo addslashes($toc_title); ?>';
						padding: 10px 15px 10px 20px;
						margin-bottom: 0;
						width: 100%;
						top: 0;
						left: 0;
						font-size: 18px;
						font-weight: bold;
						line-height: 1.3;
						color: #444444;
					}
					.content-container .right .ez-toc-title, .content-container .main-content .ez-toc-title {
						visibility: hidden;
					}
				
				</style>
			</div>
		</div>
		<?php else : ?>	

		<style>
			#ez-toc-container{ display: none !important; }
		</style>

		<?php endif; ?>
	</div>
</article><!-- #post-<?php the_ID(); ?> -->
