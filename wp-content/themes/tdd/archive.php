<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package tdd
 */

get_header();
?>
	<div class="container page-archive">
		<div class="content-container has-no-banner">
			<main id="primary" class="site-main" tabindex="-1">
				<div class="content-section content-blog-list">
					<div class="boxed">
						<h1 class="section-heading"><?php echo single_term_title( '', false ); ?></h1>

						<?php if ( check_string( get_the_archive_description() ) ) : ?>
							<div class="section-content">
								<?php echo get_the_archive_description(); ?>
							</div>
						<?php endif; ?>

						<div class="pseudo-container">
							<?php display_template( '/template-parts/sidebar/static/sidebar-blog', ['target_id' => get_queried_object_id()] ); ?>

							<div class="has-sidebar-content">
								<?php if ( have_posts() ) : ?>
									<ul class="blog-cards">
										<?php while ( have_posts() ) : the_post(); ?>
											<?php
												$_c_id = get_the_ID();

												$blog = array(
													'id'        => $_c_id,
													'title'     => get_the_title( $_c_id ),
													'url'       => get_the_permalink( $_c_id ),
													'date'      => get_the_date( 'F j, Y', $_c_id ),
													'desc'      => get_field( 'blog_text', $_c_id ),
													'image'     => get_field( 'blog_image', $_c_id ),
													'featured'  => ( ( has_post_thumbnail( $_c_id ) ) ? get_the_post_thumbnail( $_c_id, 'blog-large' ) : '' ),
												);

												$nav_args = array(
													'prev_text' => __( 'Prev' ),
													'next_text' => __( 'Next' ),
												);
												$nav_tax = get_the_post_navigation( $nav_args );
											?>
											<div class="blog-card">
												<a href="<?php echo $blog['url']; ?>" class="blog-card__link">
													<figure class="blog-card__image">
														<?php if ( check_string( $blog['image'] ) ) : ?>
															<img src="<?php echo wp_get_attachment_image_src( $blog['image'], 'full', false )[0]; ?>" alt="">
														<?php elseif ( check_string( $blog['featured'] ) ) : ?>
															<?php echo $blog['featured']; ?>
														<?php endif; ?>
													</figure>

													<div class="blog-card__meta">
														<em class="blog-card__date"><?php echo $blog['date']; ?></em>
													</div>

													<div class="blog-card__heading">
														<?php echo $blog['title']; ?>
													</div>

													<?php if ( check_string( $blog['desc'] ) || check_string( get_the_content( $blog['id'] ) ) ) : ?>
														<div class="blog-card__excerpt">
															<?php if ( check_string( $blog['desc'] ) ) : ?>
																<?php $_main_content = $blog['desc']; ?>
															<?php else : ?>
																<?php $_main_content = get_the_content( $blog['id'] ); ?>
															<?php endif; ?>

															<?php echo generate_excerpt( $_main_content, 210 ); ?>
														</div>
													<?php endif; ?>
												</a>
											</div>
										<?php endwhile; ?>
									</ul>
									
									<?php if ( check_string( $nav_tax ) ) : ?>
										<div class="pagination">
											<?php echo $nav_tax; ?>
										</div>
									<?php endif; ?>
								<?php endif; ?>
							</div>
						</div>
					</div>
				</div>
			</main><!-- #main -->
		</div>
	</div>
<?php
get_footer();
