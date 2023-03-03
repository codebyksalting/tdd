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

                $blog = array(
                    'id'        => $_c_id,
                    'title'     => get_the_title( $_c_id ),
                    'url'       => get_the_permalink( $_c_id ),
                    'date'      => get_the_date( 'F j, Y', $_c_id ),
                    'desc'      => get_field( 'news_content', $_c_id ),
                );
            ?>
            <div class="blog-card">
                <div class="blog-card__content">
                    <div class="blog-card__meta">
                        <em class="blog-card__date"><?php echo $blog['date']; ?></em>
                    </div>

                    <div class="blog-card__heading">
                        <a href="<?php echo $blog['url']; ?>">
                            <?php echo $blog['title']; ?>
                        </a>
                    </div>

                    <div class="blog-card__excerpt">
                        <?php echo generate_excerpt( $blog['desc'], 170 ); ?>
                    </div>
                </div>
            </div>
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