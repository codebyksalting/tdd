<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package tdd
 */

$type = 'default';
$addtl_class = '';

if ( is_front_page() ) :
	$type = 'home';
endif;

get_header();
?>
	<div class="container page-<?php echo $type; ?>">
		<?php if ( !is_front_page() ) : ?>
			<?php
				get_template_part( 
					'template-parts/component/component',
					'headline',
					array(
						'target_id' => get_queried_object_id(),
						'main_heading' => true,
						// alt_title => '',
					)
				);
			?>
		<?php endif; ?>
		
		<div class="content-container<?php echo $addtl_class; ?>">
			<main id="primary" class="site-main" tabindex="-1">

				<?php if ( is_front_page() ) : ?>
					<h1 hidden><?php echo get_the_title( get_queried_object_id() ); ?></h1>
				<?php endif; ?>

				<?php display_template( '/template-parts/page/flexible/default', ['target_id' => get_queried_object_id()] ); ?>

			</main><!-- #main -->
		</div>
	</div>
<?php
get_footer();
