<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package tdd
 */

get_header();

$related_posts = get_related_posts(4);
?>
	<div class="container page-single">
		<?php
			get_template_part( 
				'template-parts/component/component',
				'headline',
				array(
					'target_id' => 157,
					'main_heading' => false,
					// alt_title => '',
				)
			);
		?>

		<div class="content-container">
			<main id="primary" class="site-main" tabindex="-1">
			
				<article class="content-section default-post-single">
					<div class="boxed narrow">
						<?php
							$_featured = get_field( 'blog_featured_image', get_the_ID() );
							if ( check_string( $_featured ) ) :
								$_img = wp_get_attachment_image_src( $_featured, 'full' )[0];
							endif;
						?>
						<?php if ( check_string( $_img ) ) : ?>
							<figure class="blog-featured-image">
								<img src="<?php echo $_img; ?>" alt="">
							</figure>
						<?php endif; ?>

						<header>
							<h1 class="section-heading">
								<?php echo get_the_title( get_the_ID() ); ?>
							</h1>
							<em class="blog-date"><?php echo get_the_date( 'F j, Y', get_the_ID() ); ?></em>
						</header>

						<div class="blog-inner-content">
							<?php echo get_field( 'blog_content', get_the_ID() ); ?>
						</div>

						<div class="section-buttons centered-buttons">
							<a href="<?php echo get_the_permalink( 157 ); ?>" class="btn go-back">Back</a>
						</div>
					</div>
				</article>

				<?php if ( check_array( $related_posts ) ) : ?>
					<div class="content-section default-related-posts">
						<div class="boxed">
							<h2 class="section-heading"><?php echo str_replace( array( '[[', ']]' ), array( '<b>', '</b>' ), get_field( 'lng_related_stories', 'option' ) ); ?></h2>
							<div class="related-posts">
								<?php foreach( $related_posts as $related_post ) : ?>
									<a class="blog-card" href="<?php echo get_the_permalink( $related_post ); ?>">
										<em class="blog-date"><?php echo get_the_date( 'F j, Y', $related_post ); ?></em>
										<strong class="article-title"><?php echo get_the_title( $related_post ); ?></strong>
									</a>
								<?php endforeach; ?>
							</div>
						</div>
					</div>
				<?php endif; ?>
			</main><!-- #main -->
		</div>
	</div>
<?php
get_footer();
