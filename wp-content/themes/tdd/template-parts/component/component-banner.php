<?php
/**
 * @package tdd
 */

// Current page ID
$_obj_id = ( isset( $args['target_id'] ) && !empty( $args['target_id'] ) ) ? $args['target_id'] : get_queried_object_id() ;
$_section_class = array( 'content-section', 'content-page-banner' );
$_image_styles = array();

// Banner Object
$banner = (object) [
	'element' 					=> array(
										'mini_heading' => 'h1',
										'heading' => 'h1',
									),
	'status'					=> get_field('banner_status', $_obj_id ),
	'mini_heading'				=> get_field('banner_mini_heading', $_obj_id ),
	'heading'					=> get_field('banner_heading', $_obj_id ),
	'text'						=> get_field('banner_content', $_obj_id ),
	'add_button'				=> get_field('banner_add_button', $_obj_id ),
	'button'					=> get_field('banner_button', $_obj_id ),
	'add_link'					=> get_field('banner_add_link', $_obj_id ),
	'link'						=> get_field('banner_link', $_obj_id ),
	'image_source'				=> get_field('banner_image_source', $_obj_id ),
	'image'						=> get_field('banner_image', $_obj_id ),
	'choices'					=> get_field('banner_choices', $_obj_id ),
	'add_additional'			=> get_field('banner_add_additional', $_obj_id ),
	'additional'				=> get_field('banner_additional', $_obj_id ),
	'enable_map'				=> get_field('banner_enable_map_background', $_obj_id ),
	'enable_wave'				=> get_field('banner_enable_wave_border', $_obj_id ),
	'enable_testimonial'		=> get_field('banner_enable_testimonial_slider', $_obj_id ),
	'adjust_image_box'			=> get_field('section_add_image_box_with_shadow', $_obj_id ),
	'adjust_image_shadow'		=> get_field('banner_adjust_shadow', $_obj_id ),
	'adjust_large_image_shadow'	=> get_field('banner_adjust_large_shadow', $_obj_id ),
	'override_image_width'		=> get_field('section_override_image_width', $_obj_id ),
	'override_size'				=> get_field('section_override_size', $_obj_id ),
	'override_image_margin'		=> get_field('section_override_image_margin', $_obj_id ),
	'override_margin'			=> get_field('section_override_margin', $_obj_id ),
	'vertical_alignment'		=> get_field('section_vertical_alignment', $_obj_id ),
];

// Overrides
if ( check_string( $banner->mini_heading ) ) :
	$banner->element['heading'] = 'h2';
endif;
if ( $banner->enable_map ) :
	array_push( $_section_class, 'has-map-background' );
endif;
if ( $banner->enable_wave && !$banner->enable_testimonial ) :
	array_push( $_section_class, 'has-wave-border' );
endif;
if ( $banner->adjust_image_box ) :
	array_push( $_section_class, 'has-image-box' );
elseif ( $banner->adjust_large_image_shadow ) :
	array_push( $_section_class, 'adjust-large-image-shadow' );
elseif ( $banner->adjust_image_shadow ) :
	array_push( $_section_class, 'adjust-image-shadow' );
endif;
if ( $banner->enable_testimonial ) :
	array_push( $_section_class, 'has-testimonial-slider' );
endif;
if ( $banner->override_image_width && check_string( $banner->override_size ) ) :
	array_push( $_image_styles, 'width: 100%;', '--desk-mxw: ' . $banner->override_size . 'px;' );
endif;
if ( $banner->override_image_margin && check_string( $banner->override_margin ) ) :
	array_push( $_image_styles, '--desk-ml: ' . $banner->override_margin . 'px;' );
endif;
if ( check_string( $banner->vertical_alignment ) ) :
	array_push( $_section_class, $banner->vertical_alignment );
endif;

$_img_style = ( ( check_array( $_image_styles ) ) ? ' style="' . implode( ' ', $_image_styles ) . '"' : '' );

if ( $banner->status ) :
	?>

		<a id="top"></a>
		<div class="<?php echo implode( ' ', $_section_class ); ?>">
			<div class="boxed">
				<div class="banner-cols">
					<?php if ( check_string( $banner->image_source ) ) : ?>
						<figure class="banner-col banner-col__image <?php echo $banner->image_source; ?><?php echo ( ( $banner->image_source == 'img-src-animation' && check_string( $banner->choices ) && $banner->choices == 'hero-animation-one.svg' ) ) ? ' animated-banner-img' : '' ; ?>"<?php echo $_img_style; ?>>
							<?php if ( $banner->image_source == 'img-src-upload' && check_string( $banner->image ) ) : ?>
								<img src="<?php echo wp_get_attachment_image_src( $banner->image, 'banner-large', false )[0]; ?>" alt=""<?php echo ( ( $banner->override_image_width && check_string( $banner->override_size ) ) ) ? ' style="display: block; width: 100%;"' : '' ; ?>>
							<?php elseif ($banner->image_source == 'img-src-animation' && check_string( $banner->choices ) ) : ?>
								<?php if ( $banner->choices == 'hero-animation-one.svg' ) : ?>
									<svg class="animated-hero-svg" id="hero-claravine" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="580 170 760 740">
										<defs>
											<radialGradient id="radial-gradient" cx="0.9" cy="1081.48" r="1" gradientTransform="matrix(0, 202.5, 206, 0, -221823.94, 357.36)" gradientUnits="userSpaceOnUse">
												<stop offset="0" stop-color="#fff"/>
												<stop offset="1" stop-color="#f2f5f9"/>
											</radialGradient>
											<filter id="filter-blur" x="-100%" y="-100%" width="300%" height="300%" filterUnits="objectBoundingBox" primitiveUnits="userSpaceOnUse" color-interpolation-filters="linearRGB">
												<feGaussianBlur stdDeviation="7 7" x="-100%" y="-100%" width="300%" height="300%" in="SourceGraphic" edgeMode="none" result="blur"/>
											</filter>

											<mask id="clip-green-dots">
												<path id="shapeMask-green" d="M936.77,372.56c54.74-14.18,82.16-15.65,109.15-1.51s75.65,58.34,75.65,58.34,43.3,54.87,52.72,103.23-13.37,89.58-13.37,89.58-61.93,55.57-152.55,61.41c-57.75,4.08-73.63,11.45-110.74,7.94-28.46-3.3-67.35,2.66-96-33.64-9.82-17.81-63.28-121.32-50.65-178,5.64-44.52,28.77-58.59,59-69.92C861.72,397.13,882,386.74,936.77,372.56Z" fill="#fff"/>
											</mask>
										</defs>
										<g>
											<g id="bg-shape">
												<ellipse cx="959.92" cy="539.85" rx="271" ry="266.5" fill="#30505a"/>
												<ellipse cx="959.92" cy="539.85" rx="206" ry="202.5" fill="url(#radial-gradient)"/>
											</g>
											<g id="red-lines" >
												<path d="M1073.92,284.31C1013.12,287.91,982.26,421.85,986.92,503.31" fill="none" stroke="#f37f7f" stroke-linecap="round" stroke-linejoin="round" stroke-width="5" stroke-dasharray="265" stroke-dashoffset="265"></path>
												<path d="M1187.14,390.32c-69.14,8-123.62,31.78-136.22,113" fill="none" stroke="#f37f7f" stroke-linecap="round" stroke-linejoin="round" stroke-width="5" stroke-dasharray="200" stroke-dashoffset="200"></path>
												<path d="M1236.92,560c-55.14-.65-118.35-7.07-186-16.67" fill="none" stroke="#f37f7f" stroke-linecap="round" stroke-linejoin="round" stroke-width="5" stroke-dasharray="200" stroke-dashoffset="200"></path>
												<path d="M1138.76,744.46c-85.62,0-127-111.49-121.51-176.11" fill="none" stroke="#f37f7f" stroke-linecap="round" stroke-linejoin="round" stroke-width="5" stroke-dasharray="250" stroke-dashoffset="250"></path>
												<path d="M914.92,808.15c25-50.75,21.26-170.65,18-239.8" fill="none" stroke="#f37f7f" stroke-linecap="round" stroke-linejoin="round" stroke-width="5" stroke-dasharray="250" stroke-dashoffset="250"></path>
												<path d="M726.8,693.82c91,3.8,140.84-32.52,147.12-110.47" fill="none" stroke="#f37f7f" stroke-linecap="round" stroke-linejoin="round" stroke-width="5" stroke-dasharray="230" stroke-dashoffset="230"></path>
												<path d="M720,432.57c91.47-9.57,135.17,56.33,147,74.16" fill="none" stroke="#f37f7f" stroke-linecap="round" stroke-linejoin="round" stroke-width="5" stroke-dasharray="200" stroke-dashoffset="200"></path>
												<path d="M852.49,320.07c47.2,97.2,47.67,140.5,42,150" fill="none" stroke="#f37f7f" stroke-linecap="round" stroke-linejoin="round" stroke-width="5" stroke-dasharray="180" stroke-dashoffset="180"></path>
											</g>
											<g id="red-dots" >
												<path d="M1073.92,284.31C1013.12,287.91,982.26,421.85,986.92,503.31" fill="none" stroke="#f37f7f" stroke-linecap="round" stroke-linejoin="round" stroke-width="19" stroke-dasharray="0.1 265" stroke-dashoffset="265.2"></path>
												<path d="M1187.14,390.32c-69.14,8-123.62,31.78-136.22,113" fill="none" stroke="#f37f7f" stroke-linecap="round" stroke-linejoin="round" stroke-width="19" stroke-dasharray="0.1 210" stroke-dashoffset="210.4"></path>
												<path d="M1236.92,560c-55.14-.65-118.35-7.07-186-16.67" fill="none" stroke="#f37f7f" stroke-linecap="round" stroke-linejoin="round" stroke-width="19" stroke-dasharray="0.1 200" stroke-dashoffset="200.4"></path>
												<path d="M1138.76,744.46c-85.62,0-127-111.49-121.51-176.11" fill="none" stroke="#f37f7f" stroke-linecap="round" stroke-linejoin="round" stroke-width="19" stroke-dasharray="0.1 250" stroke-dashoffset="250.4"></path>
												<path d="M914.92,808.15c25-50.75,21.26-170.65,18-239.8" fill="none" stroke="#f37f7f" stroke-linecap="round" stroke-linejoin="round" stroke-width="19" stroke-dasharray="0.1 250" stroke-dashoffset="250.4"></path>
												<path d="M726.8,693.82c91,3.8,140.84-32.52,147.12-110.47" fill="none" stroke="#f37f7f" stroke-linecap="round" stroke-linejoin="round" stroke-width="19" stroke-dasharray="0.1 230" stroke-dashoffset="230.4"></path>
												<path d="M720,432.57c91.47-9.57,135.17,56.33,147,74.16" fill="none" stroke="#f37f7f" stroke-linecap="round" stroke-linejoin="round" stroke-width="19" stroke-dasharray="0.1 200" stroke-dashoffset="200.4"></path>
												<path d="M852.49,320.07c47.2,97.2,47.67,140.5,42,150" fill="none" stroke="#f37f7f" stroke-linecap="round" stroke-linejoin="round" stroke-width="19" stroke-dasharray="0.1 180" stroke-dashoffset="180.4"></path>
											</g>
											<g id="green-lines" opacity="0">
												<path d="M1073.92,284.31C1013.12,287.91,982.26,421.85,986.92,503.31" fill="none" stroke="#5DD39E" stroke-linecap="round" stroke-linejoin="round" stroke-width="6" stroke-dasharray="265" stroke-dashoffset="265"></path>
												<path d="M1187.14,390.32c-69.14,8-123.62,31.78-136.22,113" fill="none" stroke="#5DD39E" stroke-linecap="round" stroke-linejoin="round" stroke-width="6" stroke-dasharray="200" stroke-dashoffset="200"></path>
												<path d="M1236.92,560c-55.14-.65-118.35-7.07-186-16.67" fill="none" stroke="#5DD39E" stroke-linecap="round" stroke-linejoin="round" stroke-width="6" stroke-dasharray="200" stroke-dashoffset="200"></path>
												<path d="M1138.76,744.46c-85.62,0-127-111.49-121.51-176.11" fill="none" stroke="#5DD39E" stroke-linecap="round" stroke-linejoin="round" stroke-width="6" stroke-dasharray="250" stroke-dashoffset="250"></path>
												<path d="M914.92,808.15c25-50.75,21.26-170.65,18-239.8" fill="none" stroke="#5DD39E" stroke-linecap="round" stroke-linejoin="round" stroke-width="6" stroke-dasharray="250" stroke-dashoffset="250"></path>
												<path d="M726.8,693.82c91,3.8,140.84-32.52,147.12-110.47" fill="none" stroke="#5DD39E" stroke-linecap="round" stroke-linejoin="round" stroke-width="5" stroke-dasharray="230" stroke-dashoffset="230"></path>
												<path d="M720,432.57c91.47-9.57,135.17,56.33,147,74.16" fill="none" stroke="#5DD39E" stroke-linecap="round" stroke-linejoin="round" stroke-width="6" stroke-dasharray="200" stroke-dashoffset="200"></path>
												<path d="M852.49,320.07c47.2,97.2,47.67,140.5,42,150" fill="none" stroke="#5DD39E" stroke-linecap="round" stroke-linejoin="round" stroke-width="6" stroke-dasharray="180" stroke-dashoffset="180"></path>
											</g>
											<g mask="url(#clip-green-dots)">
												<g id="green-dots" >
													<path d="M1073.92,284.31C1013.12,287.91,982.26,421.85,986.92,503.31" fill="none" stroke="#5DD39E" stroke-linecap="round" stroke-linejoin="round" stroke-width="20" stroke-dasharray="0.1 265" stroke-dashoffset="265.2"></path>
													<path d="M1187.14,390.32c-69.14,8-123.62,31.78-136.22,113" fill="none" stroke="#5DD39E" stroke-linecap="round" stroke-linejoin="round" stroke-width="20" stroke-dasharray="0.1 210" stroke-dashoffset="210.4"></path>
													<path d="M1236.92,560c-55.14-.65-118.35-7.07-186-16.67" fill="none" stroke="#5DD39E" stroke-linecap="round" stroke-linejoin="round" stroke-width="20" stroke-dasharray="0.1 200" stroke-dashoffset="200.4"></path>
													<path d="M1138.76,744.46c-85.62,0-127-111.49-121.51-176.11" fill="none" stroke="#5DD39E" stroke-linecap="round" stroke-linejoin="round" stroke-width="20" stroke-dasharray="0.1 250" stroke-dashoffset="250.4"></path>
													<path d="M914.92,808.15c25-50.75,21.26-170.65,18-239.8" fill="none" stroke="#5DD39E" stroke-linecap="round" stroke-linejoin="round" stroke-width="20" stroke-dasharray="0.1 250" stroke-dashoffset="250.4"></path>
													<path d="M726.8,693.82c91,3.8,140.84-32.52,147.12-110.47" fill="none" stroke="#5DD39E" stroke-linecap="round" stroke-linejoin="round" stroke-width="20" stroke-dasharray="0.1 230" stroke-dashoffset="230.4"></path>
													<path d="M720,432.57c91.47-9.57,135.17,56.33,147,74.16" fill="none" stroke="#5DD39E" stroke-linecap="round" stroke-linejoin="round" stroke-width="20" stroke-dasharray="0.1 200" stroke-dashoffset="200.4"></path>
													<path d="M852.49,320.07c47.2,97.2,47.67,140.5,42,150" fill="none" stroke="#5DD39E" stroke-linecap="round" stroke-linejoin="round" stroke-width="20" stroke-dasharray="0.1 180" stroke-dashoffset="180.4"></path>
												</g>
											</g>
											<g id="carrots">
												<g class="carrot" opacity="0">
													<circle class="bg-carrot" r="16.85" fill="#5dd39e"/>
													<g class="carrot-icon">
														<circle r="15.31" fill="#fff"/>
														<path d="M0-6.11A6.1,6.1,0,0,0-6.11,0V3.64A2.76,2.76,0,0,0-3.35,6.41,2.77,2.77,0,0,0-.58,3.64V2.87A3.35,3.35,0,0,1,2.77-.48H3.3A2.81,2.81,0,0,0,6.11-3.3,2.81,2.81,0,0,0,3.3-6.11Z" fill="#5dd39e"/>
													</g>
													<g class="checkmark-icon" opacity="0">
														<circle r="14" fill="#5dd39e"/>
														<path d="M4.2-4.28a.87.87,0,0,1,.63-.24.91.91,0,0,1,.63.25.91.91,0,0,1,.26.62A.85.85,0,0,1,5.49-3L.7,3a.86.86,0,0,1-.29.21.85.85,0,0,1-.35.08A1.13,1.13,0,0,1-.3,3.2,1.21,1.21,0,0,1-.6,3L-3.77-.18A.86.86,0,0,1-4-.47a.85.85,0,0,1-.08-.35A.84.84,0,0,1-4-1.17a.69.69,0,0,1,.2-.3.69.69,0,0,1,.3-.2.84.84,0,0,1,.35-.07,1.05,1.05,0,0,1,.35.08.86.86,0,0,1,.29.21L0,1.06,4.18-4.25l0,0Z" fill="#fff"/>
													</g>
												</g>
												<g class="carrot" opacity="0">
													<circle class="bg-carrot" r="16.85" fill="#5dd39e"/>
													<g class="carrot-icon">
														<circle r="15.31" fill="#fff"/>
														<path d="M0-6.11A6.1,6.1,0,0,0-6.11,0V3.64A2.76,2.76,0,0,0-3.35,6.41,2.77,2.77,0,0,0-.58,3.64V2.87A3.35,3.35,0,0,1,2.77-.48H3.3A2.81,2.81,0,0,0,6.11-3.3,2.81,2.81,0,0,0,3.3-6.11Z" fill="#5dd39e"/>
													</g>
													<g class="checkmark-icon" opacity="0">
														<circle r="14" fill="#5dd39e"/>
														<path d="M4.2-4.28a.87.87,0,0,1,.63-.24.91.91,0,0,1,.63.25.91.91,0,0,1,.26.62A.85.85,0,0,1,5.49-3L.7,3a.86.86,0,0,1-.29.21.85.85,0,0,1-.35.08A1.13,1.13,0,0,1-.3,3.2,1.21,1.21,0,0,1-.6,3L-3.77-.18A.86.86,0,0,1-4-.47a.85.85,0,0,1-.08-.35A.84.84,0,0,1-4-1.17a.69.69,0,0,1,.2-.3.69.69,0,0,1,.3-.2.84.84,0,0,1,.35-.07,1.05,1.05,0,0,1,.35.08.86.86,0,0,1,.29.21L0,1.06,4.18-4.25l0,0Z" fill="#fff"/>
													</g>
												</g>
												<g class="carrot" opacity="0">
													<circle class="bg-carrot" r="16.85" fill="#5dd39e"/>
													<g class="carrot-icon">
														<circle r="15.31" fill="#fff"/>
														<path d="M0-6.11A6.1,6.1,0,0,0-6.11,0V3.64A2.76,2.76,0,0,0-3.35,6.41,2.77,2.77,0,0,0-.58,3.64V2.87A3.35,3.35,0,0,1,2.77-.48H3.3A2.81,2.81,0,0,0,6.11-3.3,2.81,2.81,0,0,0,3.3-6.11Z" fill="#5dd39e"/>
													</g>
													<g class="checkmark-icon" opacity="0">
														<circle r="14" fill="#5dd39e"/>
														<path d="M4.2-4.28a.87.87,0,0,1,.63-.24.91.91,0,0,1,.63.25.91.91,0,0,1,.26.62A.85.85,0,0,1,5.49-3L.7,3a.86.86,0,0,1-.29.21.85.85,0,0,1-.35.08A1.13,1.13,0,0,1-.3,3.2,1.21,1.21,0,0,1-.6,3L-3.77-.18A.86.86,0,0,1-4-.47a.85.85,0,0,1-.08-.35A.84.84,0,0,1-4-1.17a.69.69,0,0,1,.2-.3.69.69,0,0,1,.3-.2.84.84,0,0,1,.35-.07,1.05,1.05,0,0,1,.35.08.86.86,0,0,1,.29.21L0,1.06,4.18-4.25l0,0Z" fill="#fff"/>
													</g>
												</g>
												<g class="carrot" opacity="0">
													<circle class="bg-carrot" r="16.85" fill="#5dd39e"/>
													<g class="carrot-icon">
														<circle r="15.31" fill="#fff"/>
														<path d="M0-6.11A6.1,6.1,0,0,0-6.11,0V3.64A2.76,2.76,0,0,0-3.35,6.41,2.77,2.77,0,0,0-.58,3.64V2.87A3.35,3.35,0,0,1,2.77-.48H3.3A2.81,2.81,0,0,0,6.11-3.3,2.81,2.81,0,0,0,3.3-6.11Z" fill="#5dd39e"/>
													</g>
													<g class="checkmark-icon" opacity="0">
														<circle r="14" fill="#5dd39e"/>
														<path d="M4.2-4.28a.87.87,0,0,1,.63-.24.91.91,0,0,1,.63.25.91.91,0,0,1,.26.62A.85.85,0,0,1,5.49-3L.7,3a.86.86,0,0,1-.29.21.85.85,0,0,1-.35.08A1.13,1.13,0,0,1-.3,3.2,1.21,1.21,0,0,1-.6,3L-3.77-.18A.86.86,0,0,1-4-.47a.85.85,0,0,1-.08-.35A.84.84,0,0,1-4-1.17a.69.69,0,0,1,.2-.3.69.69,0,0,1,.3-.2.84.84,0,0,1,.35-.07,1.05,1.05,0,0,1,.35.08.86.86,0,0,1,.29.21L0,1.06,4.18-4.25l0,0Z" fill="#fff"/>
													</g>
												</g>
												<g class="carrot" opacity="0">
													<circle class="bg-carrot" r="16.85" fill="#5dd39e"/>
													<g class="carrot-icon">
														<circle r="15.31" fill="#fff"/>
														<path d="M0-6.11A6.1,6.1,0,0,0-6.11,0V3.64A2.76,2.76,0,0,0-3.35,6.41,2.77,2.77,0,0,0-.58,3.64V2.87A3.35,3.35,0,0,1,2.77-.48H3.3A2.81,2.81,0,0,0,6.11-3.3,2.81,2.81,0,0,0,3.3-6.11Z" fill="#5dd39e"/>
													</g>
													<g class="checkmark-icon" opacity="0">
														<circle r="14" fill="#5dd39e"/>
														<path d="M4.2-4.28a.87.87,0,0,1,.63-.24.91.91,0,0,1,.63.25.91.91,0,0,1,.26.62A.85.85,0,0,1,5.49-3L.7,3a.86.86,0,0,1-.29.21.85.85,0,0,1-.35.08A1.13,1.13,0,0,1-.3,3.2,1.21,1.21,0,0,1-.6,3L-3.77-.18A.86.86,0,0,1-4-.47a.85.85,0,0,1-.08-.35A.84.84,0,0,1-4-1.17a.69.69,0,0,1,.2-.3.69.69,0,0,1,.3-.2.84.84,0,0,1,.35-.07,1.05,1.05,0,0,1,.35.08.86.86,0,0,1,.29.21L0,1.06,4.18-4.25l0,0Z" fill="#fff"/>
													</g>
												</g>
												<g class="carrot" opacity="0">
													<circle class="bg-carrot" r="16.85" fill="#5dd39e"/>
													<g class="carrot-icon">
														<circle r="15.31" fill="#fff"/>
														<path d="M0-6.11A6.1,6.1,0,0,0-6.11,0V3.64A2.76,2.76,0,0,0-3.35,6.41,2.77,2.77,0,0,0-.58,3.64V2.87A3.35,3.35,0,0,1,2.77-.48H3.3A2.81,2.81,0,0,0,6.11-3.3,2.81,2.81,0,0,0,3.3-6.11Z" fill="#5dd39e"/>
													</g>
													<g class="checkmark-icon" opacity="0">
														<circle r="14" fill="#5dd39e"/>
														<path d="M4.2-4.28a.87.87,0,0,1,.63-.24.91.91,0,0,1,.63.25.91.91,0,0,1,.26.62A.85.85,0,0,1,5.49-3L.7,3a.86.86,0,0,1-.29.21.85.85,0,0,1-.35.08A1.13,1.13,0,0,1-.3,3.2,1.21,1.21,0,0,1-.6,3L-3.77-.18A.86.86,0,0,1-4-.47a.85.85,0,0,1-.08-.35A.84.84,0,0,1-4-1.17a.69.69,0,0,1,.2-.3.69.69,0,0,1,.3-.2.84.84,0,0,1,.35-.07,1.05,1.05,0,0,1,.35.08.86.86,0,0,1,.29.21L0,1.06,4.18-4.25l0,0Z" fill="#fff"/>
													</g>
												</g>
												<g class="carrot" opacity="0">
													<circle class="bg-carrot" r="16.85" fill="#5dd39e"/>
													<g class="carrot-icon">
														<circle r="15.31" fill="#fff"/>
														<path d="M0-6.11A6.1,6.1,0,0,0-6.11,0V3.64A2.76,2.76,0,0,0-3.35,6.41,2.77,2.77,0,0,0-.58,3.64V2.87A3.35,3.35,0,0,1,2.77-.48H3.3A2.81,2.81,0,0,0,6.11-3.3,2.81,2.81,0,0,0,3.3-6.11Z" fill="#5dd39e"/>
													</g>
													<g class="checkmark-icon" opacity="0">
														<circle r="14" fill="#5dd39e"/>
														<path d="M4.2-4.28a.87.87,0,0,1,.63-.24.91.91,0,0,1,.63.25.91.91,0,0,1,.26.62A.85.85,0,0,1,5.49-3L.7,3a.86.86,0,0,1-.29.21.85.85,0,0,1-.35.08A1.13,1.13,0,0,1-.3,3.2,1.21,1.21,0,0,1-.6,3L-3.77-.18A.86.86,0,0,1-4-.47a.85.85,0,0,1-.08-.35A.84.84,0,0,1-4-1.17a.69.69,0,0,1,.2-.3.69.69,0,0,1,.3-.2.84.84,0,0,1,.35-.07,1.05,1.05,0,0,1,.35.08.86.86,0,0,1,.29.21L0,1.06,4.18-4.25l0,0Z" fill="#fff"/>
													</g>
												</g>
												<g class="carrot" opacity="0">
													<circle class="bg-carrot" r="16.85" fill="#5dd39e"/>
													<g class="carrot-icon">
														<circle r="15.31" fill="#fff"/>
														<path d="M0-6.11A6.1,6.1,0,0,0-6.11,0V3.64A2.76,2.76,0,0,0-3.35,6.41,2.77,2.77,0,0,0-.58,3.64V2.87A3.35,3.35,0,0,1,2.77-.48H3.3A2.81,2.81,0,0,0,6.11-3.3,2.81,2.81,0,0,0,3.3-6.11Z" fill="#5dd39e"/>
													</g>
													<g class="checkmark-icon" opacity="0">
														<circle r="14" fill="#5dd39e"/>
														<path d="M4.2-4.28a.87.87,0,0,1,.63-.24.91.91,0,0,1,.63.25.91.91,0,0,1,.26.62A.85.85,0,0,1,5.49-3L.7,3a.86.86,0,0,1-.29.21.85.85,0,0,1-.35.08A1.13,1.13,0,0,1-.3,3.2,1.21,1.21,0,0,1-.6,3L-3.77-.18A.86.86,0,0,1-4-.47a.85.85,0,0,1-.08-.35A.84.84,0,0,1-4-1.17a.69.69,0,0,1,.2-.3.69.69,0,0,1,.3-.2.84.84,0,0,1,.35-.07,1.05,1.05,0,0,1,.35.08.86.86,0,0,1,.29.21L0,1.06,4.18-4.25l0,0Z" fill="#fff"/>
													</g>
												</g>
											</g>
											<g id="table">
												<g>
													<path filter="url(#filter-blur)" opacity="0.3" d="M799.92,468.35a20,20,0,0,1,20-20h280a20,20,0,0,1,20,20v138a20,20,0,0,1-20,20h-280a20,20,0,0,1-20-20Z" fill="#215687"/>
													<path d="M799.92,468.35a20,20,0,0,1,20-20h280a20,20,0,0,1,20,20v138a20,20,0,0,1-20,20h-280a20,20,0,0,1-20-20Z" fill="#fff"/>
													<path d="M800.42,468.35a19.5,19.5,0,0,1,19.5-19.5h280a19.5,19.5,0,0,1,19.5,19.5v138a19.5,19.5,0,0,1-19.5,19.5h-280a19.5,19.5,0,0,1-19.5-19.5Z" fill="none" stroke="#eee"/>
												</g>
												<g id="table-data-new">
													<g id="t-data1">
														<rect opacity="0" x="873.92" y="588.35" width="54" height="15" fill="#1889ee"/>
														<rect opacity="0" x="1050.92" y="528.35" width="54" height="15" fill="#d25f5d"/>
														<rect opacity="0" x="932.92" y="488.35" width="54" height="15" fill="#fecdde"/>
														<rect opacity="0" x="814.92" y="488.35" width="54" height="15" fill="#fecdde"/>
														<rect opacity="0" x="932.92" y="528.35" width="54" height="15" fill="#ba68c8"/>
														<rect opacity="0" x="932.92" y="508.35" width="54" height="15" fill="#7ec83b"/>
														<rect opacity="0" x="873.92" y="508.35" width="54" height="15" fill="#ba68c8"/>
														<rect opacity="0" x="991.92" y="568.35" width="54" height="15" fill="#7ec83b"/>
														<rect opacity="0" x="991.92" y="508.35" width="54" height="15" fill="#d25f5d"/>
														<rect opacity="0" x="873.92" y="568.35" width="54" height="15" fill="#1889ee"/>
														<rect opacity="0" x="1050.92" y="548.35" width="54" height="15" fill="#7ec83b"/>
														<rect opacity="0" x="1050.92" y="508.35" width="54" height="15" fill="#7ec83b"/>
														<rect opacity="0" x="814.92" y="528.35" width="54" height="15" fill="#d25f5d"/>
														<rect opacity="0" x="991.92" y="488.35" width="54" height="15" fill="#fecdde"/>
														<rect opacity="0" x="1050.92" y="488.35" width="54" height="15" fill="#fecdde"/>
														<rect opacity="0" x="814.92" y="548.35" width="54" height="15" fill="#ba68c8"/>
														<rect opacity="0" x="814.92" y="508.35" width="54" height="15" fill="#7ec83b"/>
														<rect opacity="0" x="873.92" y="488.35" width="54" height="15" fill="#7ec83b"/>
														<rect opacity="0" x="991.92" y="548.35" width="54" height="15" fill="#fecdde"/>
													</g>
													<g id="t-data2">
														<rect opacity="0" x="932.92" y="548.35" width="54" height="15" fill="#7ec83b"/>
														<rect opacity="0" x="1050.92" y="568.35" width="54" height="15" fill="#7ec83b"/>
														<rect opacity="0" x="932.92" y="568.35" width="54" height="15" fill="#7ec83b"/>
														<rect opacity="0" x="873.92" y="528.35" width="54" height="15" fill="#7ec83b"/>
														<rect opacity="0" x="1050.92" y="588.35" width="54" height="15" fill="#7ec83b"/>
														<rect opacity="0" x="873.92" y="548.35" width="54" height="15" fill="#7ec83b"/>
														<rect opacity="0" x="814.92" y="588.35" width="54" height="15" fill="#7ec83b"/>
														<rect opacity="0" x="991.92" y="588.35" width="54" height="15" fill="#7ec83b"/>
														<rect opacity="0" x="814.92" y="568.35" width="54" height="15" fill="#7ec83b"/>
														<rect opacity="0" x="991.92" y="528.35" width="54" height="15" fill="#7ec83b"/>
														<rect opacity="0" x="932.92" y="588.35" width="54" height="15" fill="#7ec83b"/>
													</g>
												</g>
												<g>
													<rect x="873.92" y="468.35" width="54" height="15" fill="#30505a"/>
													<rect x="814.92" y="468.35" width="54" height="15" fill="#30505a"/>
													<rect x="932.92" y="468.35" width="54" height="15" fill="#30505a"/>
													<rect x="991.92" y="468.35" width="54" height="15" fill="#30505a"/>
													<rect x="1050.92" y="468.35" width="54" height="15" fill="#30505a"/>
												</g>
											</g>
											<g id="icons">
												<g opacity="0">
													<path filter="url(#filter-blur)" opacity="0.3" d="M1033.92,264.35a20,20,0,0,1,20-20h40a20,20,0,0,1,20,20v40a20,20,0,0,1-20,20h-40a20,20,0,0,1-20-20Z" fill="#215687"/>
													<path d="M1033.92,264.35a20,20,0,0,1,20-20h40a20,20,0,0,1,20,20v40a20,20,0,0,1-20,20h-40a20,20,0,0,1-20-20Z" fill="#fff"/>
													<g>
														<path d="M1084.63,267.8h-20.42a7.37,7.37,0,0,0-5.15,2.14,7.29,7.29,0,0,0-2.14,5.16v17.5a7.31,7.31,0,0,0,7.29,7.29h20.42a7.31,7.31,0,0,0,7.29-7.29V275.1a7.31,7.31,0,0,0-7.29-7.3Zm-20.42,2.92h20.42a4.37,4.37,0,0,1,4.37,4.38v1.45h-29.16V275.1a4.37,4.37,0,0,1,4.37-4.38ZM1084.63,297h-20.42a4.37,4.37,0,0,1-4.37-4.37V279.47H1089V292.6a4.37,4.37,0,0,1-4.37,4.37Z" fill="#30505a"/>
														<path d="M1084.63,285.3a1.45,1.45,0,0,1-1.46,1.46h-17.5a1.45,1.45,0,0,1-1-.42,1.46,1.46,0,0,1,0-2.07,1.45,1.45,0,0,1,1-.42h17.5a1.45,1.45,0,0,1,1.46,1.45Z" fill="#30505a"/>
														<path d="M1078.8,291.14a1.47,1.47,0,0,1-1.46,1.46h-11.67a1.46,1.46,0,0,1-1-.43,1.48,1.48,0,0,1-.43-1,1.46,1.46,0,0,1,.43-1,1.42,1.42,0,0,1,1-.43h11.67a1.44,1.44,0,0,1,1,.43A1.46,1.46,0,0,1,1078.8,291.14Z" fill="#30505a"/>
														<path d="M1061.3,273.64a1.44,1.44,0,0,1,.9-1.35,1.47,1.47,0,0,1,1.59.32,1.49,1.49,0,0,1,.4.74,1.48,1.48,0,0,1-.62,1.5,1.46,1.46,0,0,1-1.85-.18A1.47,1.47,0,0,1,1061.3,273.64Z" fill="#30505a"/>
														<path d="M1065.67,273.64a1.46,1.46,0,0,1,.25-.81,1.48,1.48,0,0,1,.65-.54,1.43,1.43,0,0,1,.84-.08,1.35,1.35,0,0,1,.75.4,1.49,1.49,0,0,1,.4.74,1.45,1.45,0,0,1-.08.85,1.48,1.48,0,0,1-.54.65,1.44,1.44,0,0,1-1.84-.18A1.48,1.48,0,0,1,1065.67,273.64Z" fill="#30505a"/>
														<path d="M1070.05,273.64a1.44,1.44,0,0,1,.9-1.35,1.47,1.47,0,0,1,1.59.32,1.49,1.49,0,0,1,.4.74,1.48,1.48,0,0,1-.62,1.5,1.46,1.46,0,0,1-1.85-.18A1.47,1.47,0,0,1,1070.05,273.64Z" fill="#30505a"/>
													</g>
												</g>
												<g opacity="0">
													<ellipse cx="1186.92" cy="390.85" rx="41" ry="40.5" fill="#fecdde"/>
													<circle cx="1187.36" cy="390.78" r="21.17" fill="#ffe0eb"/>
													<g>
														<path d="M1194.12,378.79s.77,8.19-1.52,11.65l-3.45-1.69-1.42-4.94,4.87-5.75Z" fill="#452514"/>
														<path d="M1189.15,388.74l1.84.91a23.11,23.11,0,0,0,1.61-10.93l-1.26.82-3.61,4.26Z" fill="#26120a"/>
														<path d="M1180.5,390.21l4-.37.91-5.6-4.36-5.52Z" fill="#26120a"/>
													</g>
													<g>
														<path d="M1196.52,390.92s3.48.06,3.71,4.53c0,0,1.17,16.84,1.12,17.69H1198s-2.11-14.4-2.45-15.92A17.07,17.07,0,0,1,1196.52,390.92Z" fill="#c84e3d"/>
														<path d="M1199.15,413.14a21,21,0,0,1-1-7.71c.33-3.35-1.37-7.72-1.37-7.72l-.72-.88-.36,1.73c.65,4,2.21,14.58,2.21,14.58Z" fill="#a1352c"/>
														<path d="M1178.27,390.92s-3.47.06-3.71,4.53c0,0-1.16,16.84-1.12,17.69h3.4s2.12-14.4,2.46-15.92C1179.29,397.22,1179.41,393.33,1178.27,390.92Z" fill="#c84e3d"/>
														<path d="M1178,397.77a18.63,18.63,0,0,0-1.14,6.82,29.56,29.56,0,0,1-1.31,8.55h1.31s1.38-9.35,2.09-13.78Z" fill="#a1352c"/>
														<path d="M1197.07,396.26s.12-5.18-.55-5.34c0,0-3-.71-8-2.39a3.26,3.26,0,0,0-1.39,0,3.3,3.3,0,0,0-1.4,0c-4.94,1.69-8,2.39-8,2.39-.66.16-.26,5.18-.26,5.18s.93,7.27,1.77,11.5a44,44,0,0,1,.26,5.56h15.2a41.08,41.08,0,0,1,.25-5.57C1195.86,403.34,1197.07,396.26,1197.07,396.26Z" fill="#c84e3d"/>
														<path d="M1184.5,387.39l-2.24,2-.38,5.11s1.54-1.37,1.63-1.76l3.55,1.76Z" fill="#fff"/>
														<path d="M1189.61,387.36l2.24,2,.38,5.11a9.93,9.93,0,0,1-1.64-1.76l-3.53,1.76Z" fill="#fff"/>
														<path d="M1197.07,396.26V396c-.66,1.84-1.48,4.88-1.83,6-.53,1.72-4.38,1.08-5.32.79a11.36,11.36,0,0,0-5.28.05c-1.43.54-4.28.78-5,.34s-2.13-8-2.13-8c0,.56.06.95.06.95s.92,7.24,1.76,11.47a44.15,44.15,0,0,1,.26,5.56h15.2a41.08,41.08,0,0,1,.25-5.57C1195.86,403.34,1197.07,396.26,1197.07,396.26Z" fill="#b34033"/>
													</g>
													<g>
														<path d="M1190.23,389.76s-1.3-4.25-.78-6.76h-5.29s.18,4.44-.65,6.76l3.55,4.76Z" fill="#dfa179"/>
														<path d="M1184.16,383a34.25,34.25,0,0,1-.12,4.05,11.55,11.55,0,0,0,6.09,2.33c-.3-1.09-1.11-4.32-.68-6.38Z" fill="#cc8a65"/>
														<path d="M1192.41,381.18a37.65,37.65,0,0,0,.89-4.83c0-5.21-2.77-8.33-6.21-8.38H1187c-3.45,0-6.21,3.63-6.21,8.84a26.81,26.81,0,0,0,.76,4.37,4.29,4.29,0,0,0,.46,1.36c.26.3,3.54,4.28,4.19,4.43a3,3,0,0,0,1.67-.1,16.54,16.54,0,0,0,3.93-3.9A5.67,5.67,0,0,0,1192.41,381.18Z" fill="#e9af85"/>
														<path d="M1194.26,376.81c-.37-.87-.85-.25-1,.05,0-.17,0-.33.07-.49a11.53,11.53,0,0,0-.75-4.28c-.44-.32-2.38-2-2.66-2.14s-5.73,1.49-5.87,1.56-1.75,1.6-3,2.83a13.68,13.68,0,0,0-.23,2.47,27,27,0,0,0,.38,2.7l0-.07a12.69,12.69,0,0,0,5.64-4.39s2-2.43,2.56-2.5c0,0,3.16,3.85,3.16,4.68,0,0-.7,5.34-1.27,5.73,0,0-2.62,3.49-4.81,4.05a2.44,2.44,0,0,0,1.39-.12,16.17,16.17,0,0,0,3.93-3.9,5.4,5.4,0,0,0,.59-1.79c.09-.33.15-.68.22-1,.26.5.71-.4.71-.4a8.17,8.17,0,0,1,.6-.7,2.65,2.65,0,0,0,.32-2.28Z" fill="#d99e75"/>
														<g>
															<path d="M1193.3,369.36c-1-1.74-3.66-1.77-3.66-1.77-9.47-2.21-10,5.23-10,8,0,2.14.36,9.88,0,12.9s2.86,3.91,2.86,3.91c-.58-1.05-1-14.85-1-14.85.53.06,4-2.09,5.48-4.23a3.41,3.41,0,0,1,2.76-1.77c.12.14,3.38,3.92,3.61,5.15,0,0,.45-.85,1,0C1194.25,376.71,1194.74,371.83,1193.3,369.36Z" fill="#452514"/>
															<path d="M1194,371.31c-.32.17-.71-.24-.71-.24a4.61,4.61,0,0,0-3.66-1.73c-3.24-.17-7.07,1.61-7.77,1.72-.5.07-.84-.43-1.06-.94a11.12,11.12,0,0,0-1.23,5.43v.63c2.45.14,7.84-5.54,9.19-5.92a2,2,0,0,1,.91,0c1.21.31,2.43,1.84,3.47,3.32a4.29,4.29,0,0,0,1.18,1.29A16.84,16.84,0,0,0,1194,371.31Z" fill="#4e2a19"/>
														</g>
													</g>
													<path d="M1196.49,367.94a3.45,3.45,0,0,1,4.87-1.9,28.43,28.43,0,1,1-25.49-1.27,3.45,3.45,0,0,1,4.66,2.37,4.45,4.45,0,0,1-2.5,5.08,20.77,20.77,0,1,0,20.44,1A4.46,4.46,0,0,1,1196.49,367.94Z" fill="#fff"/>
												</g>
												<g opacity="0">
													<path filter="url(#filter-blur)" opacity="0.3" d="M1196.92,541.35a20,20,0,0,1,20-20h40a20,20,0,0,1,20,20v40a20,20,0,0,1-20,20h-40a20,20,0,0,1-20-20Z" fill="#215687"/>
													<g>
														<path d="M1196.92,541.35a20,20,0,0,1,20-20h40a20,20,0,0,1,20,20v40a20,20,0,0,1-20,20h-40a20,20,0,0,1-20-20Z" fill="#fff"/>
														<path d="M1254.92,557.93a1.73,1.73,0,0,0,0-.32l-1.9-8.55a7.24,7.24,0,0,0-7.12-5.71H1229a7.22,7.22,0,0,0-7.11,5.71l-1.9,8.55a1.17,1.17,0,0,0,0,.32v1.46a5.8,5.8,0,0,0,1.46,3.85v7.81a7.31,7.31,0,0,0,7.29,7.3h17.5a7.31,7.31,0,0,0,7.29-7.3v-7.81a5.8,5.8,0,0,0,1.46-3.85Zm-32.08.16,1.86-8.4a4.36,4.36,0,0,1,4.27-3.43h1.16v4.38a1.42,1.42,0,0,0,.43,1,1.46,1.46,0,0,0,1,.43,1.48,1.48,0,0,0,1-.43,1.46,1.46,0,0,0,.43-1v-4.38h8.75v4.38a1.45,1.45,0,0,0,.42,1,1.46,1.46,0,0,0,2.07,0,1.45,1.45,0,0,0,.42-1v-4.38h1.16a4.42,4.42,0,0,1,2.74,1,4.33,4.33,0,0,1,1.53,2.47l1.86,8.4v1.3a2.9,2.9,0,0,1-2.91,2.91h-1.46a2.92,2.92,0,0,1-2.92-2.91,1.46,1.46,0,1,0-2.91,0,2.92,2.92,0,0,1-2.92,2.91H1236a2.9,2.9,0,0,1-2.91-2.91,1.46,1.46,0,0,0-.43-1,1.44,1.44,0,0,0-1-.43,1.47,1.47,0,0,0-1.46,1.46,3,3,0,0,1-.85,2.06,2.91,2.91,0,0,1-2.07.85h-1.46a2.91,2.91,0,0,1-2.06-.85,3,3,0,0,1-.85-2.06Zm23.33,17.34h-17.5a4.37,4.37,0,0,1-4.37-4.38v-6a5.88,5.88,0,0,0,1.45.18h1.46a5.67,5.67,0,0,0,2.4-.52,2.07,2.07,0,0,1,4,0,5.73,5.73,0,0,0,2.4.52h2.92a5.83,5.83,0,0,0,4.37-2,5.83,5.83,0,0,0,2,1.46,5.67,5.67,0,0,0,2.4.52h1.46a6,6,0,0,0,1.46-.18v6a4.37,4.37,0,0,1-4.38,4.38Z" fill="#30505a"/>
													</g>
												</g>
												<g opacity="0">
													<ellipse cx="1138.92" cy="740.85" rx="41" ry="40.5" fill="#70d5fb"/>
													<circle cx="1139.42" cy="740.85" r="21.5" fill="#62bee3"/>
													<g>
														<path d="M1155.71,744.92c-.28-2.25-3.74-3.12-3.74-3.12a.21.21,0,0,1,0,.06.33.33,0,0,0-.1-.06,57.82,57.82,0,0,0-11.49-3.1,57.63,57.63,0,0,0-11.48,3.1.54.54,0,0,0-.13.07l0-.07s-3.46.87-3.74,3.12c0,0-1.15,15.49-1.32,17.53h5.75s.22-4.1.27-8.68a25.27,25.27,0,0,0,1,4,28.1,28.1,0,0,1,.24,4.7h19a29.67,29.67,0,0,1,.23-4.7,24.12,24.12,0,0,0,1-3.94c.06,4.56.28,8.65.28,8.65h5.54C1156.66,760.41,1155.71,744.92,1155.71,744.92Z" fill="#022a43"/>
														<path d="M1140.37,741l-5.46.39s4.62,13.32,4.75,14.09.71,3.67.71,3.67.58-2.85.71-3.67,4.74-14.09,4.74-14.09Z" fill="#c6e6f4"/>
														<path d="M1141.07,743.7a13.07,13.07,0,0,0,.73-1.9l-1.43-.58h0l-1.42.58a12,12,0,0,0,.77,2h0c-.23,1.32-.94,5.71-1.1,8.57.55,1.66,1,2.9,1,3.12.13.78.72,3.67.72,3.67s.58-2.86.71-3.67c0-.24.53-1.74,1.17-3.67A80,80,0,0,0,1141.07,743.7Z" fill="#041219"/>
														<path d="M1134.27,762.43c-.52-1.72-1.43-4.32-1.15-4.72s-.44-1-.44-1c-.81-.33-2.09-3-3-5.11,0-2.46-.07-4.88-.27-6.74l-.31.59s-1.76,4.16-1.08,6.69c.58,2.17-1.16,8-2.65,10.31h4s.22-4.11.28-8.69a24.51,24.51,0,0,0,1,4,28.1,28.1,0,0,1,.24,4.7Z" fill="#032133"/>
														<path d="M1152.37,753.3a14.07,14.07,0,0,0-.87-2.52c.12-.85.23-1.69.33-2.48-.23-1-.43-1.48-.48-.58-.14,2.48-4.08,9.66-4.08,9.66a22.57,22.57,0,0,1-2,5h4.6a29.67,29.67,0,0,1,.23-4.7,25.5,25.5,0,0,0,.94-3.92c.06,4.55.28,8.62.28,8.62h1.51C1151.54,761.55,1152.51,754.29,1152.37,753.3Z" fill="#032133"/>
													</g>
													<g>
														<path d="M1136,733.36s1.13,4,.09,6.2a7.78,7.78,0,0,0,8.54.33s-1-4.1-.12-6.53Z" fill="#dfa179"/>
														<path d="M1144.46,738.92a18.88,18.88,0,0,1-.28-3.09,8.43,8.43,0,0,1,.29-2.45H1136a12.68,12.68,0,0,1,.36,1.71c0,.11,0,.22.07.32.89.76,2.72,2.81,3.41,2.9,0,0,1.22.32,1.75-.1a9,9,0,0,1-1,2.81,6.54,6.54,0,0,0,1.08-.08,2.71,2.71,0,0,0,.38-.06Z" fill="#cc8c68"/>
														<path d="M1140.58,718.86h-.06c-3.43.06-6.19,3.51-6.19,8.54v0s-.58-1.23-1.06-.11a2.76,2.76,0,0,0-.12,1.21,2.55,2.55,0,0,0,.45,1.12q.33.35.63.72s.32.8.58.55c.06.24.11.48.18.73a4.15,4.15,0,0,0,.47,1.3c.27.29,3.39,4.44,4.17,4.58a4.25,4.25,0,0,0,2-.1,17.67,17.67,0,0,0,3.81-4.07,5.23,5.23,0,0,0,.6-1.71,26.48,26.48,0,0,0,.78-4.67C1146.77,721.92,1144,718.92,1140.58,718.86Z" fill="#e9af85"/>
														<path d="M1147.7,727.29c-.36-.83-.78-.36-1-.07,0-.1,0-.19,0-.28,0-3.67-1.47-6.27-3.6-7.42-.57-.19-1.14-.4-1.71-.58a5.24,5.24,0,0,0-.88-.08h-.06c-2.87,0-5.28,2.48-6,6.22l.77.06s.18-1.63.72-1.75a28.25,28.25,0,0,0,4.52,1.16,11.29,11.29,0,0,0,3.34-.53c.38-.24.92-.58,1.06-.41s-.48,2.86,0,3.5-.24,4.7-.68,5.67-2.65,4.14-3.73,4.18a3,3,0,0,1-2.32-.69,4.66,4.66,0,0,0,1.39,1.23,4.45,4.45,0,0,0,2-.1,17.58,17.58,0,0,0,3.8-4.08,4.79,4.79,0,0,0,.61-1.71c.06-.24.1-.48.15-.71.27.25.59-.55.59-.55a8.54,8.54,0,0,1,.63-.72,2.54,2.54,0,0,0,.45-1.13A2.62,2.62,0,0,0,1147.7,727.29Z" fill="#d99e75"/>
														<path d="M1134.4,727.79a6.08,6.08,0,0,1,.74-1.69,1.14,1.14,0,0,0,0-1.32s.09-1.63.59-1.93a20.94,20.94,0,0,1,4.37.76c.92.46,3.67-.3,3.93-.59a1.6,1.6,0,0,1,1.31-.17c.29.1.43,1.1.45,1.61s.09,1.33.31,1.5.35,1.54.43,1.83a8.9,8.9,0,0,0,.68-2.8,3.5,3.5,0,0,1-.07-1.87,3.66,3.66,0,0,0,0-2,10.36,10.36,0,0,0-1.07-2,6.62,6.62,0,0,0-2.59-2.35c-.75-.27-5.55-.56-6.28.15s-1.83.67-2.29,1.68a2.44,2.44,0,0,0-.73.7,2.32,2.32,0,0,0-.37.94,9,9,0,0,0-.07,4.14A28.12,28.12,0,0,1,1134.4,727.79Z" fill="#261b13"/>
														<path d="M1146.09,726a7.64,7.64,0,0,1,.43,1.84,8.9,8.9,0,0,0,.68-2.8,3.53,3.53,0,0,1-.07-1.88,3.62,3.62,0,0,0,0-2,9.92,9.92,0,0,0-1.07-2,6.67,6.67,0,0,0-2.59-2.34c-.75-.27-5.55-.56-6.28.14-.56.54-1.33.65-1.87,1.12.09,0,2.47-1,3.59-.53a8.87,8.87,0,0,0,3.71.21c.82-.11,1.86.57,1.85,1a4.18,4.18,0,0,1-2.21,2.71c-1.29.39-7.55-.25-7.72.75-.06.36.41.67,1,.91a.52.52,0,0,1,.19-.2,21.63,21.63,0,0,1,4.37.76c.93.46,3.67-.29,3.93-.58a1.57,1.57,0,0,1,1.31-.18c.29.1.44,1.1.45,1.61S1145.87,725.79,1146.09,726Z" fill="#160e09"/>
													</g>
													<path d="M1146.35,739.93c-.29-.32-1.74-2.67-2.08-2.75a26.26,26.26,0,0,1-3.9,3.8,26.26,26.26,0,0,1-3.9-3.8c-.34.08-1,1.41-1.9,2.7-.17.25.65,3.6.65,3.89a.36.36,0,0,0,0,.1.27.27,0,0,0,.08.07l.1,0a.16.16,0,0,0,.09,0,44.38,44.38,0,0,1,4.49-2.33.26.26,0,0,1,0-.15.24.24,0,0,1,.07-.13.31.31,0,0,1,.11-.09l.15,0a.32.32,0,0,1,.14,0,.27.27,0,0,1,.12.09.24.24,0,0,1,.07.13.26.26,0,0,1,0,.15,43.93,43.93,0,0,1,4.49,2.33.16.16,0,0,0,.09,0l.1,0a.27.27,0,0,0,.08-.07.36.36,0,0,0,0-.1C1145.55,743.48,1146.55,740.15,1146.35,739.93Z" fill="#fff"/>
													<path d="M1148.58,718a3.46,3.46,0,0,1,4.88-1.9,28.49,28.49,0,1,1-25.55-1.28,3.47,3.47,0,0,1,4.67,2.38,4.47,4.47,0,0,1-2.5,5.09,20.8,20.8,0,1,0,20.49,1A4.45,4.45,0,0,1,1148.58,718Z" fill="#fff"/>
												</g>
												<g opacity="0">
													<path filter="url(#filter-blur)" opacity="0.3" d="M874.92,786.35a20,20,0,0,1,20-20h40a20,20,0,0,1,20,20v40a20,20,0,0,1-20,20h-40a20,20,0,0,1-20-20Z" fill="#215687"/>
													<path d="M874.92,786.35a20,20,0,0,1,20-20h40a20,20,0,0,1,20,20v40a20,20,0,0,1-20,20h-40a20,20,0,0,1-20-20Z" fill="#fff"/>
													<g>
														<path d="M918.8,789.35h-8.75a7.29,7.29,0,0,0-7.3,7.29v20.41a7.31,7.31,0,0,0,7.3,7.3h8.75a7.31,7.31,0,0,0,7.29-7.3V796.64a7.29,7.29,0,0,0-7.29-7.29Zm-8.75,2.91h8.75a4.37,4.37,0,0,1,4.37,4.38v16h-17.5v-16a4.37,4.37,0,0,1,4.38-4.38Zm8.75,29.17h-8.75a4.37,4.37,0,0,1-4.38-4.38V815.6h17.5v1.45a4.37,4.37,0,0,1-4.37,4.38Z" fill="#30505a"/>
														<path d="M914.42,820a1.46,1.46,0,1,0-1.46-1.46A1.46,1.46,0,0,0,914.42,820Z" fill="#30505a"/>
													</g>
												</g>
												<g opacity="0">
													<ellipse cx="728.92" cy="691.85" rx="41" ry="40.5" fill="#1889ee"/>
													<circle cx="729.35" cy="691.78" r="21.17" fill="#6fbbff"/>
													<g>
														<path d="M744.86,696.76c-.28-2.24-3.71-3.09-3.71-3.09l0,0a.21.21,0,0,0-.11,0,56.73,56.73,0,0,0-11.41-3.09,56.34,56.34,0,0,0-11.39,3.09.28.28,0,0,0-.12,0l0,0s-3.43.85-3.7,3.09c0,0-1.14,15.4-1.31,17.4h5.69s.23-4.07.28-8.6a24.09,24.09,0,0,0,1,3.94,26.86,26.86,0,0,1,.23,4.66H739a29.14,29.14,0,0,1,.23-4.66,24.65,24.65,0,0,0,1-3.9c.06,4.52.28,8.56.28,8.56H746C745.8,712.16,744.86,696.76,744.86,696.76Z" fill="#ce3736"/>
														<path d="M745.28,703.66c0-.43,0-.85-.07-1.26h0c-.05-.68-.09-1.34-.12-1.94h0c0-.57-.07-1.11-.1-1.6h0c-.06-.92-.1-1.61-.12-1.92h0l0-.18v0l0-.2v0a2.5,2.5,0,0,0-.65-1.22h-1.32v-1l-.57-.27v1.28h-2v-1.94h0c-.93-.34-2.77-1-5-1.61h-.19v0l-5.61-1.18-5.79,1.21c-2.18.63-4,1.27-5,1.61h.57v1.94h-2v-1.49l-.57.23v1.26H715l-.13.15h0l0,.06a2.67,2.67,0,0,0-.3.49l-.06.15a2.85,2.85,0,0,0-.14.5.14.14,0,0,1,0,.07s0,.07,0,.18v1.92h-.14c0,.47-.08,1-.12,1.6h.26v1.94h-.41c0,.52-.07,1.06-.11,1.62h.52v1.91h-.67l-.12,1.62h.79v6.61h.57v-6.61h2v6.61h.57v-6.61H719c0-.54,0-1.08,0-1.62h-1.58V704h2v1.91h-.34c.11.57.21,1.11.33,1.62h0a12.6,12.6,0,0,0,.54,1.91h0v0s.08.69.16,1.58H722v3.1h.57v-3.1h2v3.08h.57v-3.08h2v3.08h.57v-3.08h2v3.09h.57v-3.08h2v3.08h.57v-3.08h2v3.08h.57v-3.08h3.87c.07-.89.15-1.58.15-1.58l0,0h-1.5v-1.91l2,.26a2,2,0,0,0,0-.26h0q.16-.74.33-1.62h0c0-.12,0-.23.07-.35v.33h0c0,.23,0,.43,0,.65s0,.25,0,.38,0,.4,0,.59h0c0,1,0,1.86.08,2.68v-2.68h2v6.63h.57v-6.63h2l.57-2.23C745.35,704.75,745.32,704.2,745.28,703.66Zm-30.38-6.72h2v1.92h-2Zm0,3.52h2v1.94h-2Zm0,5.47V704h2v1.91Zm4.52-3.53h-2v-1.94h2Zm0-3.54h-2v-1.92h2Zm2.53,10.6h-2v-1.91h2Zm0-3.53h-2V704h2Zm0-3.53h-2v-1.94h2Zm0-3.54h-2v-1.92h2Zm0-3.51h-2v-1.94h2Zm2.54,14.11h-2v-1.91h2Zm0-3.53h-2V704h2Zm0-3.53h-2v-1.94h2Zm0-3.54h-2v-1.92h2Zm0-3.51h-2v-1.94h2ZM727,709.46h-2v-1.91h2Zm0-3.53h-2V704h2Zm0-3.53h-2v-1.94h2Zm0-3.54h-2v-1.92h2Zm0-3.51h-2v-1.94h2Zm2.54,14.11h-2v-1.91h2Zm0-3.53h-2V704h2Zm0-3.53h-2v-1.94h2Zm0-3.54h-2v-1.92h2Zm0-3.51h-2v-1.94h2Zm2.54,14.11h-2v-1.91h2Zm0-3.53h-2V704h2Zm0-3.53h-2v-1.94h2Zm0-3.54h-2v-1.92h2Zm0-3.51h-2v-1.94h2Zm2.53,14.11h-2v-1.91h2Zm0-3.53h-2V704h2Zm0-3.53h-2v-1.94h2Zm0-3.54h-2v-1.92h2Zm0-3.51h-2v-1.94h2Zm2.55,14.11h-2v-1.91h2Zm0-3.53h-2V704h2Zm0-3.53h-2v-1.94h2Zm0-3.54h-2v-1.92h2Zm0-3.51h-2v-1.94h2Zm2.55,10.58h-2V704h2Zm0-3.53h-2v-1.94h2Zm0-3.54h-2v-1.92h2Zm0-3.51h-2v-1.94h2Zm2.54,10.56h-2V704h2Zm0-3.51h-2v-1.94h2Zm0-3.54h-2v-1.92h2Zm2.54,7h-2V704h2Zm0-3.51h-2v-1.94h2Zm0-3.54h-2v-1.92h2Z" fill="#971c1a"/>
													</g>
													<g>
														<path d="M725.31,685.28s1.12,3.93.08,6.16a7.74,7.74,0,0,0,8.48.32s-1-4.07-.11-6.48Z" fill="#dfa179"/>
														<path d="M733.69,690.8a17.52,17.52,0,0,1-.27-3.07,8.64,8.64,0,0,1,.28-2.43h-8.39a16.57,16.57,0,0,1,.36,1.7c0,.13.05.24.06.32.89.75,2.7,2.78,3.39,2.88,0,0,1.21.32,1.74-.1a8.75,8.75,0,0,1-1,2.79,7.56,7.56,0,0,0,1.06-.08,2.2,2.2,0,0,0,.41-.07Z" fill="#cc8c68"/>
														<path d="M729.84,670.88h-.07c-3.41.06-6.14,3.49-6.14,8.48,0,0-.58-1.22-1.06-.1a2.56,2.56,0,0,0-.11,1.2,2.44,2.44,0,0,0,.45,1.12,7,7,0,0,1,.62.71s.32.79.58.55c0,.24.11.47.17.71a4.23,4.23,0,0,0,.46,1.29c.27.29,3.37,4.41,4.15,4.55a4.17,4.17,0,0,0,1.94-.1,17.6,17.6,0,0,0,3.79-4,5,5,0,0,0,.59-1.7,26,26,0,0,0,.77-4.64C736,673.92,733.25,670.94,729.84,670.88Z" fill="#e9af85"/>
														<path d="M736.92,679.26c-.38-.88-.81-.32-1,0,0-.1,0-.21,0-.31,0-3.64-1.46-6.22-3.57-7.36l-1.7-.58a6.42,6.42,0,0,0-.87-.09h-.07c-2.85,0-5.24,2.48-5.94,6.17l.77.07s.18-1.65.71-1.74a28.18,28.18,0,0,0,4.5,1.16,11.45,11.45,0,0,0,3.31-.53c.39-.24.91-.58,1-.39s-.48,2.83,0,3.47-.23,4.67-.67,5.63-2.62,4.09-3.69,4.14a3,3,0,0,1-2.31-.68,4.61,4.61,0,0,0,1.38,1.22,4.36,4.36,0,0,0,2-.1,17.74,17.74,0,0,0,3.78-4,4.81,4.81,0,0,0,.6-1.7c.06-.25.1-.49.16-.74.26.3.59-.52.59-.52a7.1,7.1,0,0,1,.63-.71,2.68,2.68,0,0,0,.45-1.12A2.56,2.56,0,0,0,736.92,679.26Z" fill="#d99e75"/>
														<path d="M723.63,679.16a8.9,8.9,0,0,0,.25,1.67,6.68,6.68,0,0,0,.5-2.73c-.09-.81.44-3.56.93-3.71s3.81.85,4.83.71,3.5-.27,3.92-.72.81,1,.77,1.46a25.31,25.31,0,0,0,.38,4c.21.75.25,1.3.49,1.3,0,0,1.27-7.23.46-9.8,0,0-1-3.24-6-3.14s-6.75,2.33-7.33,3.2C722.8,671.39,721.82,673.9,723.63,679.16Z" fill="#160b06"/>
														<path d="M735,679.14c0-.2-.72-.29-.72-.29a12.5,12.5,0,0,0-3.29,0l-.16.07a4.52,4.52,0,0,0-1-.09,4,4,0,0,0-1.09.11.48.48,0,0,0-.19-.09,12.08,12.08,0,0,0-3.29,0s-.76.09-.72.28a.44.44,0,0,0,0,.2.4.4,0,0,0,.1.18l.36.3s.19,1.32.59,1.62c0,0,2.36.74,3.17-.72a2.47,2.47,0,0,0,.36-1.15,2,2,0,0,1,1.32,0,2.54,2.54,0,0,0,.36,1.17c.81,1.46,3.17.72,3.17.72.41-.28.59-1.62.59-1.62l.36-.3a.42.42,0,0,0,.11-.18A.37.37,0,0,0,735,679.14Zm-7.28,2c-1,.34-2,.06-2.12-.4s-.33-1.35-.33-1.35.24-.25.45-.23c0,0,2.88-.34,2.92.37C728.62,679.53,728.69,680.79,727.7,681.13Zm6.19-.4c-.15.45-1.14.74-2.13.4s-.91-1.62-.91-1.62c0-.71,2.91-.37,2.91-.37a.8.8,0,0,1,.45.23s-.18.92-.32,1.37Z" fill="#061f33"/>
													</g>
													<g>
														<path d="M734.81,691.66c-.29-.31-1-2.51-1.3-2.59a26.83,26.83,0,0,1-3.87,3.78,26.5,26.5,0,0,1-3.88-3.78c-.33.08-.49,1.09-1.36,2.37a21.9,21.9,0,0,0,.77,3.31.17.17,0,0,0,0,.1.12.12,0,0,0,.07.07.12.12,0,0,0,.1,0,.14.14,0,0,0,.09,0,17.73,17.73,0,0,1,3.84-1.45.68.68,0,0,0,.21-.17.7.7,0,0,0,.13-.24.55.55,0,0,0,.12.24.62.62,0,0,0,.22.17,22.58,22.58,0,0,1,3.58,1.72l.09,0a.16.16,0,0,0,.1,0,.27.27,0,0,0,.08-.07.3.3,0,0,0,0-.1C733.88,694.73,735,691.88,734.81,691.66Z" fill="#d54d4c"/>
														<path d="M732.8,692.88c-.58-.13-2.11,1.35-2.59,1.82,0,0,0-.07-.06-.09a.4.4,0,0,0-.29-.12h-.52a.41.41,0,0,0-.28.11.42.42,0,0,0-.1.17c-.38-.39-2.05-2-2.65-1.89s0,2.53,0,2.53-.41,2.5,0,2.8,1.81-1.3,2.63-1.94a.47.47,0,0,0,.11.26.44.44,0,0,0,.29.11h.52a.44.44,0,0,0,.29-.11.5.5,0,0,0,.1-.19c.83.67,2.18,2.15,2.55,1.87s0-2.8,0-2.8S733.49,693,732.8,692.88Z" fill="#091728"/>
													</g>
													<path d="M738.49,668.94a3.45,3.45,0,0,1,4.87-1.9,28.43,28.43,0,1,1-25.49-1.27,3.45,3.45,0,0,1,4.66,2.37,4.45,4.45,0,0,1-2.5,5.08,20.77,20.77,0,1,0,20.44,1A4.46,4.46,0,0,1,738.49,668.94Z" fill="#fff"/>
												</g>
												<g opacity="0">
													<path filter="url(#filter-blur)" opacity="0.3" d="M662.92,411.35a20,20,0,0,1,20-20h40a20,20,0,0,1,20,20v40a20,20,0,0,1-20,20h-40a20,20,0,0,1-20-20Z" fill="#215687"/>
													<path d="M662.92,411.35a20,20,0,0,1,20-20h40a20,20,0,0,1,20,20v40a20,20,0,0,1-20,20h-40a20,20,0,0,1-20-20Z" fill="#fff"/>
													<g>
														<path d="M719.46,445.43H690.3a1.47,1.47,0,0,1-1.46-1.46V414.8a1.5,1.5,0,0,0-.43-1,1.46,1.46,0,0,0-2.49,1V444a4.37,4.37,0,0,0,4.38,4.38h29.16a1.46,1.46,0,0,0,1-.43,1.44,1.44,0,0,0,.43-1,1.47,1.47,0,0,0-1.46-1.46Z" fill="#30505a"/>
														<path d="M707.8,442.51a1.43,1.43,0,0,0,1.45-1.45V430.85a1.45,1.45,0,0,0-1.45-1.46,1.47,1.47,0,0,0-1.46,1.46v10.21a1.45,1.45,0,0,0,1.46,1.45Z" fill="#30505a"/>
														<path d="M696.13,442.51a1.45,1.45,0,0,0,1-.42,1.5,1.5,0,0,0,.43-1V430.85a1.46,1.46,0,0,0-.43-1,1.46,1.46,0,0,0-2.49,1v10.21a1.45,1.45,0,0,0,1.46,1.45Z" fill="#30505a"/>
														<path d="M713.63,442.51a1.45,1.45,0,0,0,1-.42,1.5,1.5,0,0,0,.43-1v-17.5a1.5,1.5,0,0,0-.43-1,1.46,1.46,0,0,0-2.49,1v17.5a1.45,1.45,0,0,0,1.46,1.46Z" fill="#30505a"/>
														<path d="M702,442.51a1.45,1.45,0,0,0,1.46-1.46v-17.5A1.45,1.45,0,0,0,702,422.1a1.45,1.45,0,0,0-1.46,1.45v17.5a1.5,1.5,0,0,0,.43,1A1.49,1.49,0,0,0,702,442.51Z" fill="#30505a"/>
													</g>
												</g>
												<g opacity="0">
													<ellipse cx="837.92" cy="300.85" rx="41" ry="40.5" fill="#7ec83b"/>
													<circle cx="838.35" cy="300.78" r="21.17" fill="#abed6f"/>
													<g>
														<path d="M852.85,304.88c-.27-2.25-3.72-3.11-3.72-3.11s0,0,0,.05a.6.6,0,0,0-.11-.06,57.69,57.69,0,0,0-11.46-3.1,57.33,57.33,0,0,0-11.43,3.1.42.42,0,0,0-.13.07l0-.06s-3.44.86-3.72,3.11c0,0-1.14,15.44-1.31,17.47l5.68,0h0s.23-4.14.28-8.73a25.17,25.17,0,0,0,1,4,28.17,28.17,0,0,1,.23,4.68H847a29.36,29.36,0,0,1,.23-4.68,23.62,23.62,0,0,0,.95-3.85c.05,4.51.27,8.54.27,8.54h0l5.5,0C853.8,320.32,852.85,304.88,852.85,304.88Z" fill="#3d5f6d"/>
														<path d="M840.53,322.32c.44-5.73,1.51-21.06,1.51-21.06l-4.46-.31-4.34,0s.93,15.74,1.31,21.34Z" fill="#c6e6f4"/>
														<path d="M849.53,313.21a13.5,13.5,0,0,0-.87-2.51c.12-.85.23-1.69.33-2.47-.22-1-.4-1.47-.47-.58-.14,2.47-4.06,9.62-4.06,9.62a22.46,22.46,0,0,1-2,5H847a29.36,29.36,0,0,1,.23-4.68,24.39,24.39,0,0,0,1-3.94c.05,4.54.27,8.62.27,8.62H850C848.71,321.43,849.67,314.18,849.53,313.21Z" fill="#32535c"/>
														<path d="M831.5,322.31c-.52-1.71-1.43-4.31-1.15-4.7s-.44-1-.44-1c-.8-.32-2.08-3-3-5.08,0-2.45-.07-4.87-.26-6.71l-.3.6s-1.77,4.11-1.09,6.64c.58,2.17-1.16,7.95-2.64,10.28h4s.22-4.1.28-8.66a23.45,23.45,0,0,0,1,4,27.41,27.41,0,0,1,.22,4.68Z" fill="#32535c"/>
													</g>
													<g>
														<path d="M833.24,293.34s1.12,4,.08,6.19a7.76,7.76,0,0,0,8.51.32s-1-4.09-.11-6.5Z" fill="#dfa179"/>
														<path d="M841.65,298.89a18.78,18.78,0,0,1-.28-3.09,8.76,8.76,0,0,1,.29-2.44h-8.42a16.21,16.21,0,0,1,.36,1.71c0,.13,0,.24.06.32.89.75,2.71,2.79,3.4,2.89,0,0,1.22.32,1.74-.11a8.89,8.89,0,0,1-1,2.81,7.71,7.71,0,0,0,1.07-.08,2.11,2.11,0,0,0,.4-.07Z" fill="#cc8c68"/>
														<path d="M837.78,278.89h-.07c-3.42.06-6.16,3.5-6.16,8.5h0s-.58-1.22-1.06-.1a2.57,2.57,0,0,0-.12,1.2,2.72,2.72,0,0,0,.45,1.13,5.42,5.42,0,0,1,.63.72s.32.79.58.55c.06.24.11.47.18.71a4,4,0,0,0,.46,1.3c.27.29,3.38,4.42,4.16,4.57a4.36,4.36,0,0,0,1.95-.1,17.8,17.8,0,0,0,3.8-4.06,4.94,4.94,0,0,0,.59-1.71A26.11,26.11,0,0,0,844,287C844,281.94,841.2,279,837.78,278.89Z" fill="#e9af85"/>
														<path d="M844.89,287.29c-.38-.88-.8-.33-1,0a2.58,2.58,0,0,1,0-.29c0-3.66-1.47-6.24-3.59-7.39l-1.7-.59a6.4,6.4,0,0,0-.88-.09h-.07c-2.84.05-5.25,2.47-6,6.2l.77.06s.18-1.65.71-1.74a28.56,28.56,0,0,0,4.51,1.15,10.88,10.88,0,0,0,3.32-.53c.39-.24.92-.57,1.06-.38s-.48,2.84,0,3.48-.24,4.69-.67,5.65-2.64,4.11-3.71,4.16a3,3,0,0,1-2.32-.69,4.57,4.57,0,0,0,1.39,1.22,4.31,4.31,0,0,0,1.95-.09,17.8,17.8,0,0,0,3.8-4.06,4.8,4.8,0,0,0,.6-1.71c.07-.25.11-.5.16-.75.27.3.6-.52.6-.52a5.42,5.42,0,0,1,.63-.72,2.72,2.72,0,0,0,.45-1.13A2.57,2.57,0,0,0,844.89,287.29Z" fill="#d99e75"/>
														<path d="M831.55,287.39a2.53,2.53,0,0,0,.13,1,9.11,9.11,0,0,0,.45-1.78c0-.61.41-3.74.9-3.86s3.49.67,4.42.67a9.35,9.35,0,0,0,3-.25c.56-.29,4.09-.94,4.59-2.39a3.82,3.82,0,0,1-1.78-.77,7.57,7.57,0,0,0,1.78,0,20.78,20.78,0,0,1-2.78-1.42c-.68-.51-5.93-1.64-7-1.06s-3.39,1.77-3.49,3.09a10,10,0,0,0-1.18,2.9c0,.84.4,3.31.4,3.31A3.08,3.08,0,0,1,831.55,287.39Z" fill="#6b3e20"/>
														<path d="M845,280a20.72,20.72,0,0,1-2.78-1.41,9,9,0,0,0-2.33-.74,6.14,6.14,0,0,1,.82.71,16,16,0,0,1,1.83,2.27,7.93,7.93,0,0,1-2.77,1.5c-.9.27-5.73-.58-5.73-.58a3.26,3.26,0,0,0-2-.92c.35,0,1,.59,1,.59-.82.81-1.22,4.13-1.22,4.13-.7-.33-.94-2-.94-2-.17-.32.83-2.69.83-2.69a9,9,0,0,0-1.06,2.69c0,.83.4,3.31.4,3.31a3.17,3.17,0,0,1,.53.57,2.53,2.53,0,0,0,.13,1,9.11,9.11,0,0,0,.45-1.78c0-.61.41-3.74.9-3.86s3.49.67,4.42.67a9.64,9.64,0,0,0,3-.25c.23-.12,1-.3,1.78-.57.17.64.55,2,.77,2.6a15.24,15.24,0,0,1,.68,3.19,6.17,6.17,0,0,1,.66-1.53,34,34,0,0,0-.11-5.16,2,2,0,0,0,.81-.92,3.82,3.82,0,0,1-1.78-.77A7.57,7.57,0,0,0,845,280Z" fill="#532b10"/>
													</g>
													<path d="M842.77,299.74c-.29-.31-1-2.52-1.3-2.59a26.7,26.7,0,0,1-3.89,3.78,26.18,26.18,0,0,1-3.89-3.78c-.33.07-.49,1.09-1.36,2.37a29.57,29.57,0,0,0,.13,4.19.19.19,0,0,0,0,.1.16.16,0,0,0,.07.07l.1,0a.14.14,0,0,0,.09,0,45.07,45.07,0,0,1,4.47-2.32.6.6,0,0,0,.22-.16.6.6,0,0,0,.12-.24.8.8,0,0,0,.13.24.6.6,0,0,0,.22.16,43.83,43.83,0,0,1,4.46,2.32.17.17,0,0,0,.1,0l.1,0,.07-.07a.19.19,0,0,0,0-.1A21.19,21.19,0,0,0,842.77,299.74Z" fill="#fff"/>
													<path d="M847.49,277.94a3.45,3.45,0,0,1,4.87-1.9,28.43,28.43,0,1,1-25.49-1.27,3.45,3.45,0,0,1,4.66,2.37,4.45,4.45,0,0,1-2.5,5.08,20.77,20.77,0,1,0,20.44,1A4.46,4.46,0,0,1,847.49,277.94Z" fill="#fff"/>
												</g>
											</g>
										</g>
										<style>
											#hero-claravine  {
												overflow: visible;
											}
										</style>
									</svg>
								<script src="<?php echo get_template_directory_uri(); ?>/js/anim/gsap.min.js"></script>
								<script>

									function moveIcon(iconObj, mX, mY, del, pData, carrot, num) {

										let prcnt = {val: 1};

										gsap.to(iconObj, 5, {x: mX, ease: 'sine.inOut', yoyo: true, repeat: -1, delay: 0 + del, 
											onUpdate: function() { 
												//moving lines with icons
												let x = gsap.getProperty(iconObj, 'x');
												let y = gsap.getProperty(iconObj, 'y');
												let d = 'M' + (pData.x[num] + x) + ',' + (pData.y[num] + y) + pData.d[num];
												pData.redLines[num].setAttribute('d', d);
												pData.greenLines[num].setAttribute('d', d);
												pData.redDots[num].setAttribute('d', d);
												pData.greenDots[num].setAttribute('d', d);
										
												// carrot icons moving with lines
												let prcntLength = prcnt.val * pData.redLines[num].getTotalLength();
												let pt = pData.redLines[num].getPointAtLength(prcntLength);
												gsap.set(carrot.icon[num], {x: pt.x, y: pt.y});
											}
										});

										gsap.to(iconObj, 5, {y: mY, ease: 'sine.inOut', yoyo: true, repeat: -1, delay: -2.5 + del});
										// grow carrot icons to center
										gsap.to(prcnt, carrot.dur, {val: carrot.position[num], ease: 'sine.out', delay: carrot.delay, repeat: -1, repeatDelay: carrot.loop - carrot.dur});
									}

									function heroClaravineAnimation() {

										let idSVG = '#hero-claravine' + ' ';
										let icons = document.querySelectorAll(idSVG + '#icons > g')

										// lines data
										let pathData = {};

										pathData.redLines = document.querySelectorAll(idSVG + '#red-lines > path');
										pathData.redDots = document.querySelectorAll(idSVG + '#red-dots > path');
										pathData.greenLines = document.querySelectorAll(idSVG + '#green-lines > path');
										pathData.greenDots = document.querySelectorAll(idSVG + '#green-dots > path');

										pathData.d = [  'C1013.12,287.91,982.26,421.85,986.92,503.31',
														'C1118,398.32,1063.52,422.1,1050.92,503.32',
														'C1181.78,559.35,1118.57,552.93,1050.92,543.33',
														'C1053.14,744.46,1011.76,632.97,1017.25,568.35',
														'C939.92,757.4,936.18,637.5,932.92,568.35',
														'C817.8,697.62,867.64,661.3,873.92,583.35',
														'C811.47,423,855.17,488.9,867,506.73',
														'C899.69,417.27,900.16,460.57,894.49,470.07' ];
										pathData.x = [1073.92, 1187.14, 1236.92, 1138.76, 914.92, 726.8, 720, 852.49];
										pathData.y = [284.31, 390.32, 560, 744.46, 808.15, 693.82, 432.57, 320.07];

										// carrots icons data
										let carrots = {};
										carrots.icon = document.querySelectorAll(idSVG + '.carrot');
										carrots.position = [0.5, 0.4, 0.4, 0.5, 0.5, 0.4, 0.3, 0.4];
										carrots.dur = 1.5;
										carrots.delay = 5; //9
										carrots.loop = 16.5 + carrots.delay; //restart time for moving the carrot icons to the middle of the lines
										// green lines data 
										let greenLineStop = [385, 340, 320, 380, 370, 370, 350, 300];

										//float move icons animation
										moveIcon(icons[0], 50, -50, 0, pathData, carrots, 0);
										moveIcon(icons[1], -20, 50, -2, pathData, carrots, 1);
										moveIcon(icons[2], 45, -20, -5, pathData, carrots, 2);
										moveIcon(icons[3], -20, -40, -8, pathData, carrots, 3);
										moveIcon(icons[4], 70, 20, -1, pathData, carrots, 4);
										moveIcon(icons[5], 20, -50, -3, pathData, carrots, 5);
										moveIcon(icons[6], -30, 50, -6, pathData, carrots, 6);
										moveIcon(icons[7], 40, 30, -9, pathData, carrots, 7);

										// main animation
										gsap.set(icons, {scale: 0, opacity: 1, transformOrigin: '50% 50%'})
										gsap.set(idSVG + '#shapeMask-green', {scale: 0, transformOrigin: '50% 50%'})
										gsap.set(idSVG + '#green-lines', {opacity: 1})
										gsap.set(idSVG + '.checkmark-icon', {scale: 0, rotate: -180, transformOrigin: '50% 50%', opacity: 1})

										gsap.to(idSVG + '#icons > g', 1, {scale: 1, ease: 'back.out(1.4)', stagger: 0.05, delay: 0.5})

										let clirivineAnim = gsap.timeline({defaults: { ease: 'sine.inOut' }, repeat: -1, repeatDelay: 0.5, delay: 0.5});
											clirivineAnim
												.to(idSVG + '#red-lines > path', 1.2, {strokeDashoffset: 0, stagger: 0.05}, 1)
												//table anim
												.to(idSVG + '#t-data1 > rect', 0.75, {opacity: 1, stagger: 0.35}, 2)
												.to(idSVG + '#t-data2 > rect', 0.75, {opacity: 1, stagger: 0.35}, carrots.delay + 0.5)
												.to(idSVG + '#t-data1 > rect', 0.75, {fill: '#7ec83b', stagger: 0.4}, carrots.delay + 1.5)
												// dots anim
												.to(idSVG + '#red-dots > path:nth-child(2n)', 2.5, {strokeDashoffset: 0, ease: 'none', stagger: {each: 0.75, repeat: 4}}, 1)
												.to(idSVG + '#red-dots > path:nth-child(2n+1)', 2.5, {strokeDashoffset: 0, ease: 'none', stagger: {each: 0.75, repeat: 4}}, 2)
												.to(idSVG + '#green-dots > path:nth-child(2n)', 2.5, {strokeDashoffset: 0, ease: 'none', stagger: {each: 0.75, repeat: 4}}, 1)
												.to(idSVG + '#green-dots > path:nth-child(2n+1)', 2.5, {strokeDashoffset: 0, ease: 'none', stagger: {each: 0.75, repeat: 4}}, 2)

												//draw green lines
												.to(pathData.greenLines, 1.5, {strokeDashoffset: function(index, element) {
													return greenLineStop[index];
												}, ease: 'sine.out'}, carrots.delay - 0.5)
												.to(idSVG + '#shapeMask-green', 1.5, {scale: 1, ease: 'sine.out'}, carrots.delay - 0.5)
												// show carrot icon
												.to(carrots.icon, 0.1, {opacity: 1}, carrots.delay - 0.5)
												//transform carrot icon to checkmark icon
												.to(idSVG + '.carrot-icon', 2, {rotate: 360, transformOrigin: '50% 50%', ease: 'none', repeat: 5}, carrots.delay - 0.5)
												.to(idSVG + '.carrot-icon', 1, {scale: 0, transformOrigin: '50% 50%'}, carrots.delay + 9.5)
												.to(idSVG + '.checkmark-icon', 1, {scale: 1, rotate: 0, transformOrigin: '50% 50%'}, carrots.delay + 10.2)
												.to(idSVG + '.bg-carrot', 1.5, {fill: '#fff'}, carrots.delay + 9.5)

												.to(pathData.greenLines, 1.5, {strokeDashoffset: function(index, element) {
													return gsap.getProperty(element, 'strokeDasharray') * 2;
												}}, carrots.delay + 9.5)
												.to(pathData.redLines, 0.5, {opacity: 0}, carrots.delay + 11)
												//ent to start
												.to([idSVG + '#t-data1 > rect', idSVG + '#t-data2 > rect'], 1.5, {opacity: 0}, carrots.delay + 14)
												.to(carrots.icon, 1.5, {scale: 0, transformOrigin: '50% 50%'}, carrots.delay + 14)
												.to(pathData.greenLines, 1.5, {strokeDashoffset: function(index, element) {
													return gsap.getProperty(element, 'strokeDasharray') * 3;
												}}, carrots.delay + 14.5)

									}

									heroClaravineAnimation();


								</script>
								<?php else : ?>
									<?php $_svg_url = get_template_directory_uri() . '/img/content/banner/' . $banner->choices; ?>
									<?php if ( file_get_contents( $_svg_url ) !== false ) : ?>
										<?php echo file_get_contents( $_svg_url ); ?>
									<?php endif; ?>
								<?php endif; ?>
							<?php endif; ?>
						</figure>
					<?php endif; ?>

					<div class="banner-col banner-col__content">
						<?php if ( check_string( $banner->mini_heading ) ) : ?>
							<<?php echo $banner->element['mini_heading']; ?> class="section-mini-heading">
								<?php echo $banner->mini_heading; ?>
							</<?php echo $banner->element['mini_heading']; ?>>
						<?php endif; ?>

						<?php if ( check_string( $banner->heading ) ) : ?>
							<<?php echo $banner->element['heading']; ?> class="section-heading">
								<?php echo $banner->heading; ?>
							</<?php echo $banner->element['heading']; ?>>
						<?php endif; ?>

						<?php if ( check_string( $banner->text ) ) : ?>
							<div class="section-content">
								<?php echo $banner->text; ?>
							</div>
						<?php endif; ?>

						<?php if ( ( $banner->add_button && check_array( $banner->button ) ) || ( $banner->add_link && check_array( $banner->link ) ) ) : ?>
							<div class="section-buttons">
								<?php if ( $banner->add_button && check_array( $banner->button ) ) : ?>
									<?php 
										$_main_button_id = rand(100000, 999999);
										$_main_class = '';
										if ( $banner->button['button_type'] == 'btn-page' ) :
											$_btn_url = get_the_permalink( $banner->button['button_page'] );
										elseif ( $banner->button['button_type'] == 'btn-url' ):
											$_btn_url = $banner->button['button_url'];
										elseif ( $banner->button['button_type'] == 'btn-other' ):
											$_btn_url = $banner->button['button_other'];
										elseif ( $banner->button['button_type'] == 'btn-embed' ):
											$_btn_url = '#light_' . $_main_button_id;
											$_main_class = ' open-popup-link';
										endif;
									?>
										<a href="<?php echo $_btn_url; ?>" class="btn<?php echo $_main_class; ?><?php echo ( ( $banner->button['button_add_icon'] ) ? ' btn-has-video-icon' : '' ); ?>" target="<?php echo $banner->button['button_link_target']; ?>">
											<?php if ( $banner->button['button_add_icon'] ) : ?><img src="<?php echo get_template_directory_uri(); ?>/img/common/icon_video.svg" alt=""><?php endif; ?><?php echo $banner->button['button_text']; ?>
										</a>

										<?php if ( $banner->button['button_type'] == 'btn-embed' && check_string( $banner->button['button_embed'] ) ): ?>
											<div id="light_<?php echo $_main_button_id; ?>" class="mfp-hide white-popup">
												<?php echo do_shortcode( trim( $banner->button['button_embed'] ) ); ?>
											</div>
										<?php endif; ?>
								<?php endif; ?>

								<?php if ( $banner->add_link && check_array( $banner->link ) ) : ?>
									<?php 
										$_addlink_button_id = rand(100000, 999999);
										$_addlink_class = '';
										if ( $banner->link['button_type'] == 'btn-page' ) :
											$_link_url = get_the_permalink( $banner->link['button_page'] );
										elseif ( $banner->link['button_type'] == 'btn-url' ):
											$_link_url = $banner->link['button_url'];
										elseif ( $banner->link['button_type'] == 'btn-embed' ):
											$_link_url = '#light_' . $_addlink_button_id;
											$_addlink_class = ' open-popup-link';
										endif;
									?>
										<a href="<?php echo $_link_url; ?>" class="btn btn-blank btn-video<?php echo $_addlink_class; ?>" target="<?php echo $banner->link['button_link_target']; ?>">
                                        	<img src="<?php echo get_template_directory_uri(); ?>/img/common/icon_video.svg" alt=""><?php echo $banner->link['button_text']; ?>
										</a>

										<?php if ( $banner->link['button_type'] == 'btn-embed' && check_string( $banner->link['button_embed'] ) ): ?>
											<div id="light_<?php echo $_addlink_button_id; ?>" class="mfp-hide white-popup">
												<?php echo do_shortcode( trim( $banner->link['button_embed'] ) ); ?>
											</div>
										<?php endif; ?>
								<?php endif; ?>
							</div>
						<?php endif; ?>
					</div>
				</div>

				<?php if ( $banner->add_additional && check_array( $banner->additional ) ) : ?>
					<div class="banner-additional">
						<?php if ( check_string( $banner->additional['additional_heading'] ) ) : ?>
							<strong class="section-heading">
								<?php echo $banner->additional['additional_heading']; ?>
							</strong>
						<?php endif; ?>

						<?php if ( check_string( $banner->additional['additional_text'] ) ) : ?>
							<div class="section-content">
								<?php echo $banner->additional['additional_text']; ?>
							</div>
						<?php endif; ?>

						<?php if ( $banner->additional['additional_add_button'] && check_array( $banner->additional['additional_button'] ) ) : ?>
							<div class="section-buttons">
								<?php 
									$_extra_button_id = rand(100000, 999999);
									$_extra_class = '';
									if ( $banner->additional['additional_button']['button_type'] == 'btn-page' ) :
										$_addtl_url = get_the_permalink( $banner->additional['additional_button']['button_page'] );
									elseif ( $banner->additional['additional_button']['button_type'] == 'btn-url' ):
										$_addtl_url = $banner->additional['additional_button']['button_url'];
									elseif ( $banner->additional['additional_button']['button_type'] == 'btn-other' ):
										$_addtl_url = $banner->additional['additional_button']['button_other'];
									elseif ( $banner->additional['button_type'] == 'btn-embed' ):
										$_addtl_url = '#light_' . $_extra_button_id;
										$_extra_class = ' open-popup-link';
									endif;
								?>
									<a href="<?php echo $_addtl_url; ?>" class="btn btn-purple<?php echo $_extra_class; ?>" target="<?php echo $banner->additional['additional_button']['button_link_target']; ?>"><?php echo $banner->additional['additional_button']['button_text']; ?></a>

									<?php if ( $banner->additional['button_type'] == 'btn-embed' && check_string( $banner->additional['button_embed'] ) ): ?>
										<div id="light_<?php echo $_extra_button_id; ?>" class="mfp-hide white-popup">
											<?php echo do_shortcode( trim( $banner->additional['button_embed'] ) ); ?>
										</div>
									<?php endif; ?>
							</div>
						<?php endif; ?>
					</div>
				<?php endif; ?>
			</div>

			<?php if ( $banner->add_additional && check_array( $banner->additional ) ) : ?>

				<div class="animator">
					<svg width="1440" height="601" viewBox="0 0 1440 601" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path opacity="0.07" d="M916 148V283H977.138V208.755H1051V148H916Z" fill="#50CA73"/>
						<path class="anim-svg-rotate-cc" opacity="0.5" d="M132.645 398L105 400.232L106.011 412.752L121.214 411.524L122.436 426.649L134.877 425.644L132.645 398Z" fill="#5DD39E"/>
						<path class="anim-svg-rotate-c" opacity="0.5" d="M1310.1 394.105L1326.71 352.158L1307.71 344.637L1298.58 367.707L1275.63 358.621L1268.16 377.499L1310.1 394.105Z" fill="#5DD39E"/>
						<path class="anim-svg-grow" opacity="0.3" d="M512 66C512 72.0751 507.075 77 501 77C494.925 77 490 72.0751 490 66C490 59.9249 494.925 55 501 55C507.075 55 512 59.9249 512 66ZM493.671 66C493.671 70.0479 496.952 73.3293 501 73.3293C505.048 73.3293 508.329 70.0479 508.329 66C508.329 61.9521 505.048 58.6707 501 58.6707C496.952 58.6707 493.671 61.9521 493.671 66Z" fill="#5DD39E"/>
						<path class="anim-svg-shrink" opacity="0.3" d="M1197 95C1197 101.075 1192.08 106 1186 106C1179.92 106 1175 101.075 1175 95C1175 88.9249 1179.92 84 1186 84C1192.08 84 1197 88.9249 1197 95ZM1178.67 95C1178.67 99.0479 1181.95 102.329 1186 102.329C1190.05 102.329 1193.33 99.0479 1193.33 95C1193.33 90.9521 1190.05 87.6707 1186 87.6707C1181.95 87.6707 1178.67 90.9521 1178.67 95Z" fill="#82CEF9"/>
					</svg>
				</div>

			<?php elseif ( $banner->enable_testimonial ) : ?>

				<div class="content- section content-testimonial-slider has-half-background">
					<div class="boxed">
						<?php
							// WP_Query arguments
							$wp_query_args = array (
								'post_type'              => array( 'testimonial' ),
								'post_status'            => array( 'publish' ),
								'posts_per_page'         => 10,
								'orderby'				 => 'menu_order',
								'order'                  => 'ASC',
							);

							// Query
							$wp_query_posts = new WP_Query( $wp_query_args );
						?>

						<?php if ( $wp_query_posts->have_posts() ) : ?>
							<div class="testimonial-wrapper">
								<div class="testimonial-slides">
									<?php while ( $wp_query_posts->have_posts() ) : $wp_query_posts->the_post(); ?>
										<div class="testimonial-slide">
											<?php if ( get_field( 'testimonial_show_title', get_the_ID() ) ) : ?>
												<strong class="testimonial-slide__title">
													<?php echo get_the_title( get_the_ID() ); ?>
												</strong>
											<?php endif; ?>

											<?php if ( check_string( get_field( 'testimonial_text', get_the_ID() ) ) ) : ?>
												<div class="testimonial-slide__text">
													<?php echo get_field( 'testimonial_text', get_the_ID() ); ?>
												</div>
											<?php endif; ?>

											<div class="testimonial-slide__source">
												<?php if ( check_string( get_field( 'testimonial_photo', get_the_ID() ) ) ) : ?>
													<figure class="testimonial-slide__photo">
														<img src="<?php echo wp_get_attachment_image_src( get_field( 'testimonial_photo', get_the_ID() ), 'thumbnail', false )[0]; ?>" alt="">
													</figure>
												<?php endif; ?>

												<?php if ( check_string( get_field( 'testimonial_name', get_the_ID() ) ) ) : ?>
													<strong class="testimonial-slide__name">
														<?php echo get_field( 'testimonial_name', get_the_ID() ); ?>
													</strong>
												<?php endif; ?>
											</div>                                   
										</div>
									<?php endwhile; ?>
								</div>

								<div class="animator">
									<svg width="1029" height="368" viewBox="0 0 1029 368" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path class="anim-svg-rotate-c" opacity="0.5" d="M933.979 285L958.491 286.979L957.595 298.08L944.114 296.991L943.031 310.402L932 309.512L933.979 285Z" fill="#E89356"/>
										<path class="anim-svg-shrink" opacity="0.3" d="M846 47C846 53.0751 850.925 58 857 58C863.075 58 868 53.0751 868 47C868 40.9249 863.075 36 857 36C850.925 36 846 40.9249 846 47ZM864.329 47C864.329 51.0479 861.048 54.3293 857 54.3293C852.952 54.3293 849.671 51.0479 849.671 47C849.671 42.9521 852.952 39.6707 857 39.6707C861.048 39.6707 864.329 42.9521 864.329 47Z" fill="#5884F4"/>
										<path class="anim-svg-grow" opacity="0.3" d="M52 232C52 235.314 54.6863 238 58 238C61.3137 238 64 235.314 64 232C64 228.686 61.3137 226 58 226C54.6863 226 52 228.686 52 232ZM61.9978 232C61.9978 234.208 60.2079 235.998 58 235.998C55.7921 235.998 54.0022 234.208 54.0022 232C54.0022 229.792 55.7921 228.002 58 228.002C60.2079 228.002 61.9978 229.792 61.9978 232Z" fill="#6B67EC"/>
										<path opacity="0.07" d="M332 117V252H270.862V177.755H197V117H332Z" fill="#52AC8C"/>
									</svg>
								</div>
							</div>
						<?php endif; ?>

						<?php wp_reset_postdata(); ?>
					</div>

				</div>

			<?php endif; ?>
		</div>

	<?php
else:
	?>
		<h1 hidden><?php echo get_the_title( $_obj_id ); ?></h1>
	<?php
endif;