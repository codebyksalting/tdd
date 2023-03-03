<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package tdd
 */

get_header();
?>
	<div class="container page-blog page-with-sidebar">
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

		<div class="boxed content-container has-sidebar">
			<main id="primary" class="site-main" tabindex="-1">

				<div class="content-section content-blog">
					<div class="boxed">
						<?php if ( have_posts() ) : ?>
							<ul class="blog-cards">
								<?php while ( have_posts() ) : the_post(); ?>
									<?php
										$_pub_id = get_the_ID();
										$_pub_terms = get_the_terms( $_pub_id, 'category' );

										$publication = array(
											'id'			=> $_pub_id,
											'title'			=> get_the_title( $_pub_id ),
											'date'			=> get_the_date( 'Y', $_pub_id ),
											// 'external_url'	=> ( ( get_field( 'publication_url', $_pub_id ) ) ? ' href="' . get_field( 'publication_url', $_pub_id ) . '" target="_blank"' : '' ),
											'term'			=> ( ( check_array($_pub_terms) ) ? $_pub_terms[0]->name : '' ),
										);
									?>
									<li>
									<a href="<?php echo get_the_permalink( $_pub_id ); ?>" class="blog-card">
										<strong class="blog-card__heading"><?php echo get_the_title( $_pub_id ); ?></strong>

										<div class="blog-meta">
											<?php if ( check_string( $publication['term'] ) ) : ?>
												<?php echo $publication['term']; ?>
											<?php endif; ?>

											<?php if ( check_string( $publication['date'] ) ) : ?>
												, <?php echo $publication['date']; ?>
											<?php endif; ?>
										</div>
									</a>
									</li>
								<?php endwhile; ?>
							</ul>
							
							<?php 
								the_posts_navigation(
									array(
										'prev_text' => __('Prev', 'tdd'),
										'next_text' => __('Next', 'tdd'),
									)
							)	;
							?>

						<?php endif; ?>
					</div>
				</div>

			</main><!-- #main -->

			<?php display_template( '/template-parts/sidebar/static/blog', ['target_id' => $_idx] ); ?>
		</div>
	</div>
<?php
get_footer();
