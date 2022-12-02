<?php

/**
 * Pros & Cons Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */
$pros_header = get_field('pros_header');
$pros_header = ($pros_header) ? $pros_header : 'Pros';
$cons_header = get_field('cons_header');
$cons_header = ($cons_header) ? $cons_header : 'Cons';
$pros = get_field('pros');
$cons = get_field('cons');
?>
<div class="container">
	<div class="proscons row">
		<?php if ($pros): ?>
		<div class="col-md-6 mb-3 mb-md-0">
			<div class=" border-radius-20  p-4 pl-5">
				<h3 class="mb-4 pl-4 pros-heading"><?php echo $pros_header; ?></h3>
				<ul class="dashed">
				<?php foreach($pros as $row): ?>
					<li><?php echo str_replace(['<p>', '</p>'], '', $row['pro']); ?></li>
				<?php endforeach; ?>
				</ul>
			</div>
		</div>
		<?php endif; ?>
		<?php if ($cons): ?>
		<div class="col-md-6">
			<div class=" border-radius-20  p-4 pl-5">
				<h3 class="mb-4 pl-4 cons-heading"><?php echo $cons_header; ?></h3>
				<ul class="dashed">
				<?php foreach($cons as $row): ?>
					<li><?php echo str_replace(['<p>', '</p>'], '', $row['con']); ?></li>
				<?php endforeach; ?>
				</ul>
			</div>
		</div>
		<?php endif; ?>
	</div>
</div>	
