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
	
    <div class="integration-cards search-filter-results-list">
	<?php
		while ($query->have_posts())
		{
			$query->the_post();
			
            $_iid = get_the_ID();

            $integration = array(
                'id'        => $_iid,
                'title'     => get_the_title( $_iid ),
                'url'       => get_the_permalink( $_iid ),
                'image'     => get_field( 'integration_logo', $_iid ),
                'subtext'   => get_field( 'integration_subtext', $_iid ),
                'flipcard'  => get_field( 'integration_flipcard', $_iid ),
            );

            ob_start();
            ?>

                <figure class="integration-card__figure">
                    <div>
                        <?php if ( check_string( $integration['image'] ) ) : ?>
                            <img src="<?php echo wp_get_attachment_image_src( $integration['image'], 'full', false )[0]; ?>" alt="<?php echo $integration['title']; ?>">
                        <?php endif; ?>
                    </div>

                    <?php if ( check_string( $integration['title'] ) ) : ?>
                        <figcaption>
                            <strong><?php echo $integration['title']; ?></strong>

                            <?php if ( check_string( $integration['subtext'] ) ) : ?>
                                <em><?php echo $integration['subtext']; ?></em>
                            <?php endif; ?>
                        </figcaption>
                    <?php endif; ?>
                </figure>

            <?php $card_face = ob_get_clean(); ?>

                <a class="integration-card card-flip">
                    <div class="flip-inner">
                        <div class="front-face">
                            <?php echo $card_face; ?>
                        </div>

                        <div class="back-face">
                            <?php if ( check_string( $integration['flipcard'] ) ) : ?>
                                <div class="card-description">
                                    <?php echo $integration['flipcard']; ?>
                                </div>
                            <?php else : ?>
                                <?php echo $card_face; ?>
                            <?php endif; ?>
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