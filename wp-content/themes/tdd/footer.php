<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package tdd
 */

// Declare the object variable
$footer = (object) [
	'status'			=> ( ( get_field( 'disable_main_footer_area', get_queried_object_id() ) ) ?  : false ),
	'logo'				=> get_template_directory_uri() . '/img/common/theme_footer_logo.svg',
	'address'			=> get_field( 'contact_address', 'option' ),
	'phone'				=> get_field( 'contact_phone', 'option' ),
	'email'				=> get_field( 'contact_email', 'option' ),
	'linkedin'			=> get_field( 'sns_linkedin', 'option' ),
	'twitter'			=> get_field( 'sns_twitter', 'option' ),
	'youtube'			=> get_field( 'sns_youtube', 'option' ),
	'facebook'			=> get_field( 'sns_facebook', 'option' ),
	'columns'			=> get_field( 'footer_columns',  'option' ),
	'associations'		=> get_field( 'footer_associations',  'option' ),
	'assoc_heading'		=> get_field( 'copyright_assoc_heading',  'option' ),
	'cta_text'			=> get_field( 'footer_cta_text',  'option' ),
	'cta_add_button'	=> get_field( 'footer_cta_add_button',  'option' ),
	'cta_button'		=> get_field( 'footer_cta_button',  'option' ),
	'copyright_menu'	=> get_field( 'footer_copyright_menu',  'option' ),
	'copyright'			=> ( ( check_string( get_field( 'copyright_text', 'option' ) ) ) ? str_replace( '[YEAR]', date('Y'), get_field( 'copyright_text', 'option' ) ) : '' ),
	'developer'			=> '<a href="https://thomasdigital.com/" target="_blank">San Francisco Web Design</a> by Thomas Digital',
];

?>

	<?php get_template_part( 'template-parts/component/component', 'cta' ); ?>

	<footer id="colophon" class="site-footer">
		<div class="footer-area__logocontact">
			<div class="boxed">
				<?php if ( check_string( $footer->logo ) ) : ?>
					<div class="footer-column logo-column">
						<figure class="footer-logo">
							<img src="<?php echo $footer->logo; ?>" alt="">
						</figure>
					</div>
				<?php endif; ?>

				<?php if ( check_string( $footer->address ) || check_string( $footer->phone ) || check_string( $footer->email ) ) : ?>
					<div class="footer-column footer-contact">
						<?php if ( check_string( $footer->address ) ) : ?>
							<address class="contact-item contact-info__address">
								<?php echo $footer->address; ?>
							</address>
						<?php endif; ?>

						<?php if ( check_string( $footer->phone ) ) : ?>
							<a href="<?php echo get_href( $footer->phone ); ?>" target="_blank" class="contact-item contact-info__phone">
								<?php echo $footer->phone; ?>
							</a>
						<?php endif; ?>

						<?php if ( check_string( $footer->email ) ) : ?>
							<a href="<?php echo get_href( $footer->email, 'email' ); ?>" target="_blank" class="contact-item contact-info__email">
								<?php echo $footer->email; ?>
							</a>
						<?php endif; ?>
					</div>
				<?php endif; ?>
			</div>
		</div>

		<div class="footer-area__infolinks">
			<div class="boxed">
				<?php if ( check_array( $footer->columns ) ) : ?>
					<div class="footer-col footer-menu">
						<div class="links-flex">
							<?php foreach ( $footer->columns as $key => $menu ) : ?>
								<div class="footer-column menu-column-<?php echo $key; ?> <?php echo $menu['menu_column_num']; ?>">
									<?php if ( check_string( $menu['menu_heading'] ) ) : ?>
										<strong class="footer-column-heading"><?php echo $menu['menu_heading']; ?></strong>
									<?php endif; ?>

									<?php if ( check_string( $menu['menu_code'] ) ) : ?>
										<?php echo $menu['menu_code']; ?>
									<?php endif; ?>
								</div>
							<?php endforeach; ?>
						</div>

						<?php if ( check_string( $footer->linkedin ) || check_string( $footer->twitter ) || check_string( $footer->youtube ) || check_string( $footer->facebook ) ) : ?>
							<ul class="footer-sns">
								<?php if ( check_string( $footer->linkedin ) ) : ?>
									<li>
										<a class="icn li-icon" href="<?php echo $footer->linkedin; ?>" target="_blank">
											<?php echo $footer->linkedin; ?>
										</a>
									</li>
								<?php endif; ?>

								<?php if ( check_string( $footer->twitter ) ) : ?>
									<li>
										<a class="icn tw-icon" href="<?php echo $footer->twitter; ?>" target="_blank">
											<?php echo $footer->twitter; ?>
										</a>
									</li>
								<?php endif; ?>

								<?php if ( check_string( $footer->youtube ) ) : ?>
									<li>
										<a class="icn yt-icon" href="<?php echo $footer->youtube; ?>" target="_blank">
											<?php echo $footer->youtube; ?>
										</a>
									</li>
								<?php endif; ?>

								<?php if ( check_string( $footer->facebook ) ) : ?>
									<li>
										<a class="icn fb-icon" href="<?php echo $footer->facebook; ?>" target="_blank">
											<?php echo $footer->facebook; ?>
										</a>
									</li>
								<?php endif; ?>
							</ul>
						<?php endif; ?>
					</div>
				<?php endif; ?>

				<div class="footer-col snsasoc">
					<?php if ( check_array( $footer->associations ) ) : ?>
						<?php if ( check_string( $footer->assoc_heading ) ) : ?>
							<strong class="footer-column-heading"><?php echo $footer->assoc_heading; ?></strong>
						<?php endif; ?>
						
						<ul>
							<?php foreach ( $footer->associations as $key => $item ) : ?>
								<li>
									<?php if ( check_string( $item['logo_logo'] ) ) : ?>
										<img src="<?php echo wp_get_attachment_image_src( $item['logo_logo'], 'full', false )[0]; ?>" alt="">
									<?php endif; ?>

									<?php if ( check_string( $item['logo_title'] ) ) : ?>
										<?php echo $item['logo_title']; ?>
									<?php endif; ?>
								</li>
							<?php endforeach; ?>
						</ul>
					<?php endif; ?>
				</div>
			</div>
		</div>

		<div class="footer-area__copydev">
			<div class="boxed">
				<div class="footer-column copyright-menu">
					<?php if ( check_string( $footer->copyright ) ) : ?>
						<p class="copyright">
							<?php echo $footer->copyright; ?>
						</p>
					<?php endif; ?>

					<?php if ( check_string( $footer->copyright_menu ) ) : ?>
						<?php echo $footer->copyright_menu; ?>
					<?php endif; ?>
				</div>

				<?php if ( check_string( $footer->developer ) ) : ?>
					<div class="footer-column copyright-dev">
						<span class="developer"><?php echo $footer->developer; ?></span>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</footer>
</div>

<div class="mask-container">
	<svg>
		<defs>
			<clipPath id="small_mask" clipPathUnits="objectBoundingBox">
				<path d="M0.934,0.66 C1,0.572,1,0.43,0.934,0.342 L0.66,0.067 C0.571,-0.021,0.429,-0.021,0.341,0.067 L0.066,0.342 C-0.022,0.43,-0.022,0.572,0.066,0.66 L0.341,0.935 C0.429,1,0.571,1,0.66,0.935 L0.934,0.66" />
			</clipPath>
			<clipPath id="large_mask" clipPathUnits="objectBoundingBox">
				<path d="M0.057,0.639 C-0.019,0.563,-0.019,0.439,0.057,0.363 L0.362,0.058 C0.439,-0.018,0.562,-0.018,0.638,0.058 L0.943,0.363 C1,0.439,1,0.563,0.943,0.639 L0.638,0.944 C0.562,1,0.439,1,0.362,0.944 L0.057,0.639" />
			</clipPath>
		</defs>
	</svg>
</div>

<?php wp_footer(); ?>

</body>
</html>
