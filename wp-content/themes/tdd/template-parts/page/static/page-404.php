<?php
    // WP_Query arguments
    $wp_query_args = array (
        'post_type'              => array( 'page' ),
        'post_status'            => array( 'publish' ),
        'posts_per_page'         => 1,
        'orderby'				 => 'menu_order',
        'p'                      => $args['target_id'],
    );

    // The Query
    $wp_query_posts = new WP_Query( $wp_query_args );

?>

    <section class="content-section content-default-404">
        <div class="boxed">
            <?php if ( $wp_query_posts->have_posts() ) : ?>
                <?php while ( $wp_query_posts->have_posts() ) : $wp_query_posts->the_post(); ?>
                    <h1 class="section-heading">
                        <?php echo get_the_title( get_the_ID() ); ?>
                    </h1>

                    <div class="section-content">
                        <?php echo get_the_content( get_the_ID() ); ?>
                    </div>
                <?php endwhile; ?>
            <?php endif; ?>
        </div>
    </section>

<?php 
    // Restore original Post Data
    wp_reset_postdata();                            
?>