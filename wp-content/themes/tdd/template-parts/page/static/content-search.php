<?php
/**
 * Template part for displaying results in search pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package tdd
 */

?>

<?php if ( get_the_content($target_id) ) : ?>
	<?php echo get_the_content($target_id); ?>
	<?php else : ?>
	not working <?php var_dump(get_the_content($target_id)); ?>
<?php endif; ?>


<?php
    $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

    // WP_Query arguments
    $wp_query_args = array (
        'post_type'              => array( 'library' ),
        'post_status'            => array( 'publish' ),
        'posts_per_page'         => 12,
        'orderby'				 => 'menu_order',
        'paged'                  => $paged,
        'tax_query' => array(
            array(
                'taxonomy' => 'resource',
                'terms'    => 8,
            ),
        ),
    );

    // The Query
    $wp_query_posts = new WP_Query( $wp_query_args );

    // The Loop
    if ( $wp_query_posts->have_posts() ) :
?>

    <section class="content-section guidelines-component">
        <div class="inner-boxed">
            <ul class="library-link-list">
                <?php while ( $wp_query_posts->have_posts() ) : $wp_query_posts->the_post(); ?>
                    <li>
                        <a class="news-list__link" href="<?php echo get_the_permalink( $wp_query_posts->id ); ?>"><?php echo get_the_title( $wp_query_posts->id ); ?></a>
                    </li>
                <?php endwhile; ?>
            </ul>
            <div class="pagination">
                <?php 
                    echo paginate_links( array(
                        'base'         => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
                        'total'        => $wp_query_posts->max_num_pages,
                        'current'      => max( 1, get_query_var( 'paged' ) ),
                        'format'       => '?paged=%#%',
                        'show_all'     => false,
                        'type'         => 'plain',
                        'end_size'     => 2,
                        'mid_size'     => 1,
                        'prev_next'    => false,
                        'prev_text'    => sprintf( '<i></i> %1$s', __( 'Prev', 'text-domain' ) ),
                        'next_text'    => sprintf( '%1$s <i></i>', __( 'Next', 'text-domain' ) ),
                        'add_args'     => false,
                        'add_fragment' => '',
                    ) );
                ?>
            </div>
        </div>
    </section>

<?php 
    endif;

    // Restore original Post Data
    wp_reset_postdata();                            
?>

<?php /*
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

		<?php if ( 'post' === get_post_type() ) : ?>
		<div class="entry-meta">
			<?php
			tdd_posted_on();
			tdd_posted_by();
			?>
		</div><!-- .entry-meta -->
		<?php endif; ?>
	</header><!-- .entry-header -->

	<?php tdd_post_thumbnail(); ?>

	<div class="entry-summary">
		<?php the_excerpt(); ?>
	</div><!-- .entry-summary -->

	<footer class="entry-footer">
		<?php tdd_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->
*/ ?>