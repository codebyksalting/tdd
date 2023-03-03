<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package tdd
 */

get_header();

$_404_page = 820;
?>

	<div class="container">
		<?php 
			/*
			get_template_part( 
				'template-parts/component/component',
				'headline',
				array(
					'target_id' => $_404_page,
					'main_heading' => true,
					// alt_title => '',
				)
			);
			*/
		?>

		<div class="content-container 404-wrapper">
			<main id="primary" class="site-main" tabindex="-1">

				<?php 
					get_template_part( 
						'/template-parts/page/static/page',
						'404',
						array(
							'target_id' => $_404_page,
						)
					);
				?>

			</main><!-- #main -->
		</div>
	</div>

<?php
get_footer();
