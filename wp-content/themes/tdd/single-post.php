<?php
/**
 * @package tdd
 */

get_header();

// Update the post count
setPostViews( get_queried_object_id() );
?>
	<div class="container page-single">
        <div class="content-container">
            <main id="primary" class="site-main" tabindex="-1">

				<?php
					get_template_part( 
						'template-parts/single/static/content',
						'blog',
						array(
							'target_id' => get_queried_object_id(),
						)
					);
				?>

			</main><!-- #main -->
		</div>
	</div>
<?php
get_footer();