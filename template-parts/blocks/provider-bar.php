<?php

/**
 * Provider Bar Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */
$provider = get_field('provider');

$data_fields = get_field('data_fields');
$cta_or_custom_link = get_field('cta_or_custom_link');
$disclaimer = get_field('disclaimer', false, false);
$ctaButton = true;
$filterResult = 0;

// Default Columns
$tblColumns = $tblColumnsVal = $mapping_arr = [];

// User Added Columns
foreach( $data_fields as $data_field ) {
    $tblColumns[] = $data_field['data_field_name'];
    $tblColumnsVal[] = $data_field['data_field'];
    $mapping_arr[$data_field['data_field']] = $data_field['data_field_name'];
}

// Add Last Column
$ind = $doFiltering = 0;

include( "compare-provider-tbl-internet-data-array.php");

if ($provider):
	$logo = get_field('logo', $provider);
	$partner = get_field('partner', $provider);
	$provider_link = get_post_permalink( $provider );
	$cta_text2 = $cta_link2 = '';

	if ($cta_or_custom_link == 'cta'):
		if($partner){
			$buyer_id = get_field('buyer', $provider);
			$campaign = get_field( "campaign", $buyer_id );
			foreach($campaign as $key => $camp) {
				$type_of_partnership = $camp['type_of_partnership'];

				if($camp['campaign_name'] == $provider){

					if($type_of_partnership == 'call_center'){
						$cta_text = $camp['call_center'];
						$cta_link = 'tel:'.$camp['call_center'];
				
					}elseif($type_of_partnership == 'digital_link'){
						$cta_text = 'Order Online';
						$cta_link = $camp['digital_tracking_link'];
					} else {

						if ($camp['primary_conversion_method'] == 'call_center'){
							$cta_text = $camp['call_center'];
							$cta_text2 = '<p class="mt-2 mb-0 tel-link font-weight-bold">Order Online</p>';
							$cta_link = 'tel:'.$camp['call_center'];
							$cta_link2 = $camp['digital_tracking_link'];
						} else {
							$cta_text = 'Order Online';
							$cta_text2 = '<p class="mt-2 mb-0"><span class="small-text">Call to order:</span><span class="tel-link font-weight-bold"> '.$camp['call_center'].'</span></p>';
							$cta_link = $camp['digital_tracking_link'];
							$cta_link2 = 'tel:'.$camp['call_center'];
						}
					}
				}
				
			}			
		}else{
			$cta_text = 'Learn More';
			$cta_link = get_field('brands_website_url',$provider);
		}
	else :
		$cta_text = get_field('custom_link_text');
		$cta_text = ($cta_text) ? $cta_text : 'Learn More';
		$cta_link = get_field('custom_link_url');
	endif;	
	?>
	<div class="provider-bar-container pb-4">
		<div class="container">
			<section class="provider-bar row m-0 border-radius-20 p-4 p-xl-5 d-flex justify-content-between align-items-xl-center">
				<div class="img_wrap col-12 col-xl mb-4 mb-xl-0 text-center text-xl-left">
					<?php if($logo): ?>
						<a href="<?php echo $provider_link ?>">
							<img src="<?php echo $logo ?>" alt="<?php echo get_the_title() ?>" class="provider-logo">
						</a>
					<?php endif; ?>
				</div>
				<?php foreach($mapping_arr as $key => $value): ?>
				<div class="col-6 col-xl mb-4 mb-xl-0">
					<h5 class="mb-0"><?php echo $value; ?></h5>
					<?php
					if (stripos($detail_Table[0][$key][0], '/mo.')){
						$detail_Table[0][$key][0] = str_ireplace('/mo.', '', $detail_Table[0][$key][0]);
						$detail_Table[0][$key][0] = $detail_Table[0][$key][0].'<span class="provider-bar-data-append font-weight-normal">/mo.</span>';
					}
					if (stripos($detail_Table[0][$key][0], 'mbps')){
						$detail_Table[0][$key][0] = str_ireplace('mbps', '', $detail_Table[0][$key][0]);
						$detail_Table[0][$key][0] = $detail_Table[0][$key][0].'<span class="provider-bar-data-append font-weight-normal"> Mbps</span>';
					}
					?>
					<p class="provider-bar-data font-weight-bold mb-0"><?php echo $detail_Table[0][$key][0]; ?></p>

				</div>
				<?php endforeach; ?>
				<div class="text-center col-12 col-xl">
					<?php if(!empty($cta_text)) echo '<a href="'.$cta_link.'" class="btn-primary btn" target="_blank">'.$cta_text.'</a>'; ?>
					<?php if(!empty($cta_text2)) echo '<a href="'.$cta_link2.'" target="_blank">'.$cta_text2.'</a>'; ?>
				</div>
			</section>
			<?php if(!empty($disclaimer)) echo '<p class="small-text disclaimer-text mt-4 mb-0 ml-2 mr-2">'.$disclaimer.'</p>'; ?>
		</div>
	</div>	
<?php endif; ?>