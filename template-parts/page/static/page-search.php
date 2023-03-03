<?php
/**
 * @package tdd
 */

?>

<?php
    $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

    // WP_Query arguments
    $wp_query_args = array (
        'post_type'              => array( 'product' ),
        'post_status'            => array( 'publish' ),
        'posts_per_page'         => 10,
        'orderby'				 => 'menu_order',
        'paged'                  => $paged,
        's'                      => $search_keyword,
    );

    // The Query
    $wp_query_posts = new WP_Query( $wp_query_args );

?>

    <section class="content-section main-search-results">
        <div class="boxed">
            <h2 class="main-search-keyword">Your searched for: <?php echo $search_keyword; ?></h2>

            <table class="main-search-table">
                <thead>
                    <tr>
                        <th>
                            <?php echo get_field( 'lng_search_results_model', $target_id ); ?>
                        </th>
                        <th class="search_pdf_th">
                            <?php echo get_field( 'lng_search_results_datasheet', $target_id ); ?>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ( $wp_query_posts->have_posts() ) : ?>
                        <?php while ( $wp_query_posts->have_posts() ) : $wp_query_posts->the_post(); ?>
                            <tr>
                                <td><strong><?php echo get_the_title( $wp_query_posts->id ); ?></strong></td>
                                <td class="data-sheet-cell">
                                    <?php if ( get_field( 'prod_data_sheet', $wp_query_posts->ID ) ) : ?>
                                        <a target="_blank" class="news-pdf-link" href="<?php echo get_field( 'prod_data_sheet', $wp_query_posts->ID ); ?>"><?php echo get_field( 'lng_download_text', 'option' ); ?></a>
                                    <?php else : ?>
                                        <a class="news-inquire-link" href="<?php echo get_the_permalink( get_field( 'inquiry_link', 'option' ) ); ?>?model=<?php echo get_the_title( $wp_query_posts->ID ); ?>"><?php echo get_field( 'lng_inquiry_text', 'option' ); ?></a>
                                    <?php endif;  ?>
                                </td>

                            </tr>
                        <?php endwhile; ?>
                    <?php else : ?>
                        <tr>
                                <td colspan="3">No products found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>

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
    // Restore original Post Data
    wp_reset_postdata();                            
?>