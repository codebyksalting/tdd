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
	
    <div class="resource-cards search-filter-results-list">
	<?php
		while ($query->have_posts())
		{
			$query->the_post();
			
			?>
            <?php
                $_rid = get_the_ID();

                if ( check_string( get_field( 'resource_link_direction', $_rid ) ) && get_field( 'resource_link_direction', $_rid ) == 'resource-link-other' && check_string( get_field( 'resource_target_pagepost', $_rid ) ) ) :
                    $perma_id = get_field( 'resource_target_pagepost', $_rid );
                else :
                    $perma_id = $_rid;
                endif;

                $resource = array(
                    'id'        => $_rid,
                    'title'     => get_the_title( $_rid ),
                    'url'       => get_the_permalink( $perma_id ),
                    'date'      => get_the_date( 'F j, Y', $_rid ),
                    'image'     => get_field( 'blog_image', $_rid ),
                );
            ?>
                <a href="<?php echo $resource['url']; ?>" class="resource-card">
                    <?php $_resource_img = ( ( check_string( $resource['image'] ) ) ? $resource['image'] : 1167 ); ?>
                    <?php if ( check_string( $_resource_img ) ) : ?>
                        <figure class="resource-card__image">
                            <img src="<?php echo wp_get_attachment_image_src( $_resource_img, 'resource-medium', false )[0]; ?>" alt="">
                        </figure>
                    <?php endif; ?>

                    <strong class="resource-card__title">
                        <?php echo $resource['title']; ?>
                    </strong>
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