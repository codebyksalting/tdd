<?php
$_obj_id = get_queried_object_id();

$cta = (object) [
    'status'        => false,
    'element'       => 'h2',
    'heading'       => get_field( 'cta_heading', 'option' ),
    'text'          => get_field( 'cta_text', 'option' ),
    'add_button'    => get_field( 'cta_add_button', 'option' ),
    'button'        => get_field( 'cta_button', 'option' ), // Array | false
];

// Overrides
if ( get_field( 'cta_override_status', $_obj_id ) ) :
    $cta->status = get_field( 'cta_override_status', $_obj_id );
endif;
if ( get_field( 'cta_override_heading', $_obj_id ) && check_string( get_field( 'cta_heading_override', $_obj_id ) ) ) :
    $cta->heading = get_field( 'cta_heading_override', $_obj_id );
endif;
if ( get_field( 'cta_override_text', $_obj_id ) ) :
    $cta->text = get_field( 'cta_text_override', $_obj_id );
endif;
if ( get_field( 'cta_override_button_display', $_obj_id ) && check_string( get_field( 'cta_add_button_override', $_obj_id ) ) ) :
    $cta->add_button = get_field( 'cta_add_button_override', $_obj_id );
endif;
if ( get_field( 'cta_override_button', $_obj_id ) && check_string( get_field( 'cta_button_override', $_obj_id ) ) ) :
    $cta->button = get_field( 'cta_button_override', $_obj_id );
endif;

// Apply bold/colored text
if ( check_string( $cta->heading ) ) :
    $cta->heading = str_replace( array( '[[', ']]' ), array( '<b>', '</b>' ), $cta->heading );
endif;
?>
<?php if ( $cta->status ) : ?>
    <div class="content-section content-cta-bar">
        <div class="boxed">
            <?php if ( check_string( $cta->heading ) ) : ?>
                <<?php echo $cta->element; ?> class="section-heading"><?php echo $cta->heading; ?></<?php echo $cta->element; ?>>
            <?php endif; ?>

            <?php if ( check_string( $cta->text ) ) : ?>
                <div class="section-content">
                    <?php echo $cta->text; ?>
                </div>
            <?php endif; ?>

            <?php if ( check_array( $cta->button ) ) : ?>
                <?php
                    if ( $cta->button['cta_type'] == 'btn-page' ) :
                        $_btn_url = get_the_permalink( $cta->button['cta_page'] );
                    elseif ( $cta->button['cta_type'] == 'btn-url' ) :
                        $_btn_url = $cta->button['cta_url'];
                    elseif ( $cta->button['cta_type'] == 'btn-other' ) :
                        $_btn_url = $cta->button['cta_other'];
                    endif;
                ?>
                <div class="section-buttons centered-buttons">
                    <a class="btn btn-accent" href="<?php echo $_btn_url; ?>" target="<?php echo $cta->button['cta_link_target']; ?>">
                        <?php echo $cta->button['cta_text']; ?>
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php endif; ?>