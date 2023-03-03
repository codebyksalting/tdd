<?php
/**
 * @package tdd
 */

?>

<?php if ( $args['add_button'] && check_array( $args['button'] ) ) : ?>
    <div<?php echo ( ( check_string( $args['wrapper_class'] ) ) ? ' class="' . implode( ' ', $args['wrapper_class'] ) . '"' : '' ); ?>>
        <?php foreach ( $args['button'] as $key => $button ) : ?>
            <a href="<?php echo $button['button_url']; ?>" class="btn" target="_blank">
                <span><?php echo $button['button_text']; ?></span><img class="anim-svg-moveleft" src="<?php echo get_template_directory_uri(); ?>/img/common/btn_arrow.svg" alt="">
            </a>
        <?php endforeach; ?>
    </div>
<?php endif; ?>