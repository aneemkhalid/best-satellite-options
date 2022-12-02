<?php 

// use ZipSearch\ProviderSearchController as ProviderSearchController;
// use ZipSearch\BDAPIConnection as BDAPIConnection;
// use ZipSearch\ProvidersDBConnection as ProvidersDBConnection;

$results_arr = $args['providers'];
$is_satellite = $args['is_satellite'];
$zipcode = $args['zipcode'];

// error_log('NEW ZIP SEARCH');
// error_log(print_r($results_arr, TRUE));

$not_found = false;
if (empty($results_arr)) {
	$not_found = true;
}
else {
	//If results found get data for cards
	$provider_info = [];

	foreach($results_arr as $provider):

		$logo = get_field('logo', $provider['id']);
		$download_speed = $provider['download_speed'];
		$cost = $provider['cost'];
		$internet_info = get_field('internet', $provider['id']);

		$partner = get_field('partner', $provider['id']);

		$unit = $internet_info['unit'];
		$default_na_text= $internet_info['default_not_available_text'];

		//$internet_info = array_filter($internet_info);

		// error_log($provider['name']);
		// error_log(print_r( $internet_info, TRUE));
		
		if (isset($internet_info['connection_types']) && $internet_info['connection_types'] != NULL) {
			if ($internet_info['satellite_connection']['satellite_plan_highlights'] && $internet_info['satellite_connection']['satellite_terms_&_conditions']) {
				$internet_plan_highlights = $internet_info['satellite_connection']['satellite_plan_highlights'];
				$internet_terms_conditions = $internet_info['satellite_connection']['satellite_terms_&_conditions'];
			}
			else {
				$internet_plan_highlights = $internet_info['plan_highlights'];
				$internet_terms_conditions = $internet_info['terms_&_conditions'];
			}
		}

		$cta_arr = get_ctas($provider['id'], 'text-below-button-centered');

		//Sort into separate arrays with needed info
		if($is_satellite) {
			$provider_info[] = [
				'id' => $provider['id'],
				'link' => get_permalink($provider['id']),
				'name' => trim(strtolower($provider['name'])),
				'logo' => $logo,
				'download_speed' => $download_speed,
				'unit' => $unit,
				'cost' => $cost,
				'highlights' => $internet_plan_highlights,
				'conditions' => $internet_terms_conditions,
				'cta' => $cta_arr,
				'coverage' => '100',
			];
		}
		else {
			$provider_info[] = [
				'id' => $provider['id'],
				'link' => get_permalink($provider['id']),
				'name' => trim(strtolower($provider['name'])),
				'logo' => $logo,
				'download_speed' => $download_speed,
				'unit' => $unit,
				'cost' => $cost,
				'cta' => $cta_arr,
				'coverage' => $provider['coverage'],
			];
		}

	endforeach;

}

// error_log('Satellite');
// error_log(print_r($provider_info, TRUE));

?>

<div class="zip-tiles provider-bar-container" id="typeTabContent">
	<div id="internet-search" class="container">
		<div class="dashed-border pb-4 tiles-container">
			<?php if ($not_found) : ?>

				<?php if ($is_satellite) : ?>
					<div>
						<h2 class="no-results-header">No results found for <?php echo $zipcode; ?></h2>
						<p class="demote"> Try searching again using a different zip code. </p>
					</div>
				<?php else : ?>
					<div>
						<p>We’ve checked <?php echo $zipcode; ?> and found no other internet provider deals in your area. </p>
					</div>
				<?php endif; ?>

			<?php else : ?>

				<?php foreach($provider_info as $prov) : ?>
					<section class="mb-5 <?php echo ($is_satellite) ? 'satellite-provider' : 'internet-provider'; ?>">
						<div class="provider-bar border-radius-20">

							<div class="coverage-container px-3 py-2 px-lg-4">
								<div class="coverage-text text-right">
									<?php echo round($prov['coverage']); ?>% coverage in this area
								</div>
							</div>

							<div class="white-container p-3 py-4 px-lg-4 px-xl-5">
								<div class="row m-0 d-flex justify-content-between align-items-md-center main-row">
									<div class="img_wrap col-12 col-md-3 col-xl mb-4 mb-md-0 text-center text-md-left px-md-0">
										<?php 
										if($prov['logo']): 
											$begin = ($is_satellite) ? '<a href="'. $prov['link'] . '">' : '<div>';
											$end = ($is_satellite) ? '</a>' : '</div>';
											$format = '%s' . '<img src="' . $prov['logo'] .'" alt="'. $prov['name'] .'" class="provider-logo"> %s';

											echo sprintf($format, $begin, $end);
										endif;
										?>

									</div>
			
									<div class="col-12 col-xl col-md-3 mb-4 mb-xl-0 px-md-0 mb-md-0">
										<div class="data-container mx-auto mx-md-0 ml-md-5">
											<h5 class="mb-0">Starting at</h5>
											<p class="provider-bar-data font-weight-bold mb-0">$<?php echo $prov['cost']; ?>/mo</p>
										</div>
									</div>
			
									<div class="col-12 col-xl col-md-3 mb-4 mb-xl-0 px-md-0 mb-md-0">
										<div class="data-container mx-auto mx-md-0 ml-md-2">
											<h5 class="mb-0">Max Download</h5>
											<p class="provider-bar-data font-weight-bold mb-0"><?php echo $prov['download_speed']; ?> <span>Mbps</span></p>
										</div>
									</div>
			
									<div class="text-center col-12 col-xl col-md-3 px-md-0 cta-container">
										<?php if(!empty($prov['cta']['cta_link'])) echo '<a href="'.$prov['cta']['cta_link'].'" class="btn-primary btn" target="'.$prov['cta']['target'].'">'.$prov['cta']['cta_text'].'</a>'; ?>
										<?php if(!empty($prov['cta']['cta_link2'])) echo '<a href="'.$prov['cta']['cta_link2'].'" class="cta-secondary" target="'.$prov['cta']['target2'].'">'.$prov['cta']['cta_text2'].'</a>'; ?>
									</div>
			
								</div>
			
								<?php if($is_satellite && ($prov['highlights'] || $prov['conditions'])) : ?>
									<div class="row m-0 collapsed-content">
										<div class="col-12 text-center view-container px-0">
											<button class="btn collapsed view-more-btn pt-1 mt-3 mb-n2 pt-xl-0 mt-md-1 mt-lg-2 mt-xl-3 mb-xl-n2" data-toggle="collapse" data-target="#collapse-<?php echo $prov['name'] ?>" aria-expanded="false" aria-controls="collapse-<?php echo $prov['name'] ?>">
												<div class="d-flex align-items-center justify-content-center">
													<div class="detail-text">View Details</div>
													<svg xmlns="http://www.w3.org/2000/svg" class="icon" viewBox="0 0 20 20" fill="currentColor" height="20" width="20">
														<path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
													</svg>
												</div>
											</button>
										</div>
										<div class="provider_box provider-more-info w-100">
											<div id="collapse-<?php echo $prov['name']?>" class="collapse collapse-box" aria-labelledby="heading-<?php echo $prov['name'] ?>" data-parent="#accordion">
												<div class="collapsed-container">
													<ul class="nav nav-tabs d-flex justify-content-between justify-content-md-start" id="providerTab" role="tablist">
														<?php if($prov['highlights']) : ?>
														<li class="nav-item mr-md-3" role="presentation">
															<a class="nav-link" id="plan-highlights-tab" data-toggle="tab" href="#plan-highlights-<?php echo $prov['name'] ?>" role="tab" aria-controls="plan-highlights" aria-selected="true">Plan Highlights</a>
														</li>
														<?php endif; ?>
														<?php if($prov['conditions']) : ?>
														<li class="nav-item" role="presentation">
															<a class="nav-link" id="terms-conditions-tab" data-toggle="tab" href="#terms-conditions-<?php echo $prov['name'] ?>" role="tab" aria-controls="terms-conditions" aria-selected="false">Terms & Conditions</a>
														</li>
														<?php endif; ?>
													</ul>
													<div class="tab-content" id="providerTabContent">
														
														<?php if($prov['highlights']) : ?>
															<div class="tab-pane fade active show plan-highlights pb-md-2 pb-lg-3" id="plan-highlights-<?php echo $prov['name'] ?>" role="tabpanel" aria-labelledby="plan-highlights-tab">
																<?php if (is_array($prov['highlights'])) : ?>
																	<ul>
																		<?php foreach($prov['highlights'] as $highlight) : ?>
																			<li>
																				<div class="icon-container">
																					<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" height="16" width="16">
																						<path fill-rule="evenodd" clip-rule="evenodd" d="M9.00002 16.2001L4.80002 12.0001L3.40002 13.4001L9.00002 19.0001L21 7.0001L19.6 5.6001L9.00002 16.2001Z" fill="#0878C9"/>
																					</svg>
																				</div>
																				<div><?php echo $highlight['feature']; ?></div>
																			</li>
																		<?php endforeach; ?>
																	</ul>
																<?php endif; ?>
															</div>
														<?php endif; ?>
			
														<div class="tab-pane fade terms-conditions pb-md-2 pb-lg-3" id="terms-conditions-<?php echo $prov['name'] ?>" role="tabpanel" aria-labelledby="terms-conditions-tab"><?php echo $prov['conditions'] ?></div>
			
													</div>
												</div> 
											</div>
												
										</div>
									</div>
									<?php endif; ?>

							</div>
						</div>
						
					

					</section>
					
				<?php endforeach; ?>

			<?php                           
				endif;	
			?>
		</div>
	</div>
</div>
