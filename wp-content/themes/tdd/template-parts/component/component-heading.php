<?php
/**
 * @package tdd
 */

if ( check_string( $args['text'] ) ) :
    $heading = array(
        'id'        => ( ( check_string( $args['target_id'] ) ) ?  $args['target_id'] : get_queried_object_id() ),
        'text'   => $args['text'],
        'element'   => ( ( check_string( $args['element'] ) ) ?  $args['element'] : 'h2' ),
        'class'     => array( 'section-heading' ),
        'style'     => array(),
    );

    // Set classes
    if ( check_array( $heading['class'] ) ) :
        if ( check_array( $args['class'] ) ) :
            $heading['class'] = array_merge( $heading['class'], $args['class'] );
        endif;

        $heading_class = ' class="' . implode( ' ', $heading['class'] ) . '"';
    endif;

    // Set styles
    if ( check_array( $heading['style'] ) ) :
        $heading_style = ' style="' . implode( ' ', $heading['style'] ) . '"';
    endif;

    // Apply bold/colored text
    if ( check_string( $heading['text'] ) ) :
        $heading['text'] = str_replace( array( '[[', ']]' ), array( '<b>', '</b>' ), $heading['text'] );
    endif;
?>

    <<?php echo $heading['element']; ?><?php echo $heading_class; ?><?php echo $heading_style; ?>>
        <?php echo $heading['text']; ?>
    </<?php echo $heading['element']; ?>>

<?php
endif;