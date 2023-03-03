<?php
session_start();

$_obj_id = get_queried_object_id();

$top = (object) [
    'status'        => get_field( 'announcement_status', 'option' ),
    'details'       => get_field( 'announcement_detais', 'option' ),
];

if ( isset($_COOKIE["annclosed"]) && !empty($_COOKIE["annclosed"]) ) :
    $top->status = false;
endif;

?>
<?php if ( $top->status ) : ?>
    <div class="content-section content-announcement-bar">
        <div class="boxed">
            <?php if ( check_string( $top->details['announcement_title'] ) ) : ?>
                <strong class="announcement__title">
                    <?php echo $top->details['announcement_title']; ?>
                </strong>
            <?php endif; ?>

            <?php if ( check_string( $top->details['announcement_text'] ) ) : ?>
                <div class="announcement__text">
                    <?php echo $top->details['announcement_text']; ?>
                </div>
            <?php endif; ?>

            <?php if ( $top->details['announcement_add_read_more'] && check_array( $top->details['announcement_read_more'] ) ) : ?>
                <?php
                    if ( $top->details['announcement_read_more']['button_type'] == 'btn-page' ) :
                        $_btn_url = get_the_permalink( $top->details['announcement_read_more']['button_page'] );
                    elseif ( $top->details['announcement_read_more']['button_type'] == 'btn-url' ) :
                        $_btn_url = $top->details['announcement_read_more']['button_url'];
                    elseif ( $top->details['announcement_read_more']['button_type'] == 'btn-other' ) :
                        $_btn_url = $top->details['announcement_read_more']['button_other'];
                    endif;
                ?>
                <div class="announcement__more">
                    <a href="<?php echo $_btn_url; ?>" target="<?php echo $top->details['announcement_read_more']['button_link_target']; ?>">
                        <?php echo $top->details['announcement_read_more']['button_text']; ?>
                    </a>
                </div>
            <?php endif; ?>
        </div>

        <button class="close-btn" role="button">Close</button>
    </div>
<?php endif; ?>