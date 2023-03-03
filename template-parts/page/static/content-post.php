<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package tdd
 */

if ( has_post_thumbnail() ) {
    $_url = get_the_post_thumbnail_url( get_the_ID(), 'article-thumb' );
} else {
    $_get_thumb_url = wp_get_attachment_image_src( 489, 'article-thumb' );
    $_url = ( ( check_array($_get_thumb_url) ) ? $_get_thumb_url[0] : '' );
}

// $_terms = get_the_terms( get_the_ID(), 'category' );
// $_term = ( ( check_array( $_terms ) ) ? $_terms[0]->name : '' );
// $_slug = ( ( check_array( $_terms ) ) ? $_terms[0]->slug : '' );
?>

<a href="<?php echo get_the_permalink( get_the_ID() ); ?>" id="post-<?php the_ID(); ?>" <?php post_class('resource-card'); ?>>
    <figure>
        <img src="<?php echo $_url; ?>" alt="">
    </figure>
    <div class="resource-content">
        <strong><?php echo substr( get_the_title( get_the_ID() ), 0, 56 ); ?></strong>
        <span class="read-more-resource"><?php echo get_field( 'lng_read_more', 'option' ); ?></span>
    </div>
</a>
