
<?php
/**
 * @package tdd
 */

// Current page ID
$_obj_id = ( isset( $target_id ) && !empty( $target_id ) ) ? $target_id : get_queried_object_id() ;

$author_id = get_post_field( 'post_author', $_obj_id );
$tags = array();

$blog = array(
    'id'            => $_obj_id,
    'title'         => get_the_title( $_obj_id ),
    'url'           => get_the_permalink( $_obj_id ),
    'date'          => get_the_date( 'F j, Y', $_obj_id ),
    'image'         => get_field( 'blog_image', $_obj_id ),
    'description'   => get_field( 'blog_text', $_obj_id ),
    'related'       => get_related_posts(3),
);

$strings = array(
    'lbl_related'       => 'RELATED BLOG ARTICLES',
    'btn_continue'      => 'Continue reading',
);
?>
<article class="content-section content-post-single">
    <div class="boxed slim">
        <div class="blog-single__content">
            <?php if ( check_string( $blog['image'] ) ) : ?>
                <figure class="blog-single__banner">
                    <div>
                        <img src="<?php echo wp_get_attachment_image_src( $blog['image'], 'full', false )[0]; ?>" alt="">
                    </div>
                </figure>
            <?php endif; ?>

            <?php if ( check_string( $blog['title'] ) ) : ?>
                <header class="blog-single__header">
                    <h1 class="blog-single__title">
                        <?php echo $blog['title']; ?>
                    </h1>

                    <div class="blog-single__date">
                        <?php echo $blog['date']; ?>
                    </div>
                </header>
            <?php endif; ?>

            <?php if ( check_string( $blog['description'] ) ) : ?>
                <div class="blog-single__text">
                    <?php echo $blog['description']; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</article>

<?php if ( check_array( $blog['related'] ) ) : ?>
    <div class="content-section content-post-related">
        <div class="boxed">
            <h2 class="section-mini-heading"><?php echo $strings['lbl_related']; ?></h2>
            <div class="blog-tiles">
                <?php foreach ( $blog['related'] as $key => $related ) : ?>
                    <?php
                        $related = array(
                            'id'        => $related,
                            'title'     => get_the_title( $related ),
                            'url'       => get_the_permalink( $related ),
                            'date'      => get_the_date( 'F j, Y', $related ),
                            'image'     => ( ( check_string( get_field( 'blog_image', $related ) ) ) ? get_field( 'blog_image', $related ) : 912 ),
                            'desc'      => generate_excerpt( get_field( 'blog_text', $related ), 143, '&nbsp;[&hellip;]'),
                        );
                    ?>
                    <div class="blog-tile">
                        <div class="blog-tile__link">
                            <?php if ( check_string( $related['image'] ) ) : ?>
                                <figure class="blog-tile__image">
                                    <div>
                                        <img src="<?php echo wp_get_attachment_image_src( $related['image'], 'resource-thumb', false )[0]; ?>" alt="">
                                    </div>
                                </figure>
                            <?php endif; ?>

                            <?php if ( check_string( $related['title'] ) ) : ?>
                                <strong class="blog-tile__title"><?php echo $related['title']; ?></strong>
                            <?php endif; ?>

                            <?php if ( check_string( $related['desc'] ) ) : ?>
                                <div class="blog-tile__excerpt">
                                    <?php echo $related['desc']; ?>
                                </div>
                            <?php endif; ?>

                            <div class="section-buttons">
                                <a href="<?php echo $related['url']; ?>" class="btn"><?php echo $strings['btn_continue']; ?></a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
<?php endif; ?>