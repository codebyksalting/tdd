<?php
/**
 * @package tdd
 */

?>

<?php if ( check_string( $args['text'] ) ) : ?>
    <div class="section-content">
        <?php echo do_shortcode( trim( $args['text'] ) ); ?>
    </div>
<?php endif; ?>