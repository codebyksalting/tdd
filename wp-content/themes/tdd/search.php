<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package tdd
 */

get_header();

$_search_page = 1521;
?>
	<div class="container">
		<?php 
			display_template( 
				'/template-parts/component/headline',
				[
					'target_id' => $_search_page,
					'main_heading' => true,
					// alt_title => '',
				] 
			); 
		?>

		<div class="content-container search-results-wrapper">
			<main id="primary" class="site-main">

				<?php display_template( '/template-parts/page/static/page-search', ['target_id' => $_search_page, 'search_keyword' => get_search_query()] ); ?>

			</main><!-- #main -->
		</div>
	</div>

<?php
get_footer();
