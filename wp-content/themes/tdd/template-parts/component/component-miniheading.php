<?php
/**
 * @package tdd
 */

$mini_heading = array(
    'id'    => ( ( check_string( $args['target_id'] ) ) ?  $args['target_id'] : get_the_ID() ),
    'text'  => ( ( check_string( $args['text'] ) ) ?  $args['text'] : '' ),
    'tag'   => array(
                    'element'   => ( ( check_string( $args['element'] ) ) ?  $args['element'] : 'strong' ),
                    'class'     => array( 'section-mini-heading' ),
                    'style'     => array(),
                ),
);

// Set classes
if ( check_array( $mini_heading['tag']['class'] ) ) :
    $heading_style = ' class="' . implode( ' ', $mini_heading['tag']['class'] ) . '"';
endif;

// Set styles
if ( check_array( $mini_heading['tag']['style'] ) ) :
    $heading_style = ' style="' . implode( ' ', $mini_heading['tag']['style'] ) . '"';
endif;
?>

<?php if ( check_string( $mini_heading['text'] ) ) : ?>
    <<?php echo $mini_heading['tag']['element']; ?><?php echo $heading_class; ?><?php echo $heading_style; ?>><?php echo $mini_heading['text']; ?></<?php echo $mini_heading['tag']['element']; ?>>
<?php endif; ?>