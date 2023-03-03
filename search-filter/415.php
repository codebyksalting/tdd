<?php
/**
 * Search & Filter Pro 
 *
 * Sample Results Template
 * 
 * @package   Search_Filter
 * @author    Ross Morsali
 * @link      https://searchandfilter.com
 * @copyright 2018 Search & Filter
 * 
 * Note: these templates are not full page templates, rather 
 * just an encaspulation of the your results loop which should
 * be inserted in to other pages by using a shortcode - think 
 * of it as a template part
 * 
 * This template is an absolute base example showing you what
 * you can do, for more customisation see the WordPress docs 
 * and using template tags - 
 * 
 * http://codex.wordpress.org/Template_Tags
 *
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( $query->have_posts() )
{
	?>
	
    <div class="blog-cards search-filter-results-list">
	<?php
		while ($query->have_posts())
		{
			$query->the_post();
			
			?>
            <?php
                $_c_id = get_the_ID();
                $author_id = get_post_field( 'post_author', $_c_id );
                $tags = array();

                $blog = array(
                    'id'        => $_c_id,
                    'title'     => get_the_title( $_c_id ),
                    'tags'      => get_the_tags( $_c_id ),
                    'url'       => get_the_permalink( $_c_id ),
                    'date'      => get_the_date( 'm-d-Y', $_c_id ),
                    'author'    => ( ( check_string( $author_id ) ) ? get_the_author_meta( 'display_name', $author_id ) : '' ),
                    'desc'      => get_field( 'blog_shortdesc', $_c_id ),
                    'image'     => ( ( check_string( get_field( 'blog_image', $_c_id ) ) ) ? wp_get_attachment_image_src( get_field( 'blog_image', $_c_id ) , 'smallcpt-thumb' )[0] : wp_get_attachment_image_src( 474, 'smallcpt-thumb' )[0] ),
                );

                if ( $blog['tags'] ) :
                    foreach ( $blog['tags'] as $tag ) :
                        array_push( $tags, $tag->name );
                    endforeach;
                endif;
            ?>
            <a href="<?php echo $blog['url']; ?>" class="blog-card">
                <figure class="blog-card__thumbnail">
                    <img src="<?php echo $blog['image']; ?>" alt="<?php echo $blog['title']; ?>">
                </figure>

                <div class="blog-card__content">
                    <?php if ( check_array( $tags ) ) : ?>
                        <em class="blog-card__tags">
                            <?php echo implode( ', ', $tags ); ?>
                        </em>
                    <?php endif; ?>

                    <strong class="blog-card__heading"><?php echo $blog['title']; ?></strong>

                    <div class="blog-card__footer">
                        <em class="blog-card__date"><?php echo $blog['date']; ?></em> by <?php echo $blog['author']; ?>
                    </div>
                </div>
            </a>		
			<?php
		}
	?>
	</div>
<?php
}
else
{
	?>
	<div class="search-result-end search-filter-results-list" data-search-filter-action="infinite-scroll-end" hidden>
		<span>End of Results</span>
	</div>
	<?php
}
?>