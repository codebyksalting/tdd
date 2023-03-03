<?php
/**
 * @package tdd
 */

// Current page ID
$_obj_id = ( isset( $args['target_id'] ) && !empty( $args['target_id'] ) ) ? $args['target_id'] : get_queried_object_id() ;
$_classes = array( 'content-page-headline' );
// Headline Object
$headline = (object) [
	'element' 			=> array(
								'mini_heading' 	=> 'h1',
								'heading' 		=> 'h1',
								'class'			=> ''
							),
	'status'			=> get_field( 'headline_status', $_obj_id ),
	'is_main_heading' 	=> ( ( $args['main_heading'] ) ? $args['main_heading'] : true ),
	'mini'				=> ( ( check_string( get_field( 'headline_mini_heading', $_obj_id ) ) ) ? get_field( 'headline_mini_heading', $_obj_id ) : '' ),
	'title'				=> ( ( isset( $args['alt_title '] ) && $args['alt_title '] != '' ) ? $args['alt_title '] : get_the_title( $_obj_id ) ),
	'text'				=> ( ( check_string( get_field( 'headline_text', $_obj_id ) ) ) ? get_field( 'headline_text', $_obj_id ) : '' ),
	'background'		=> ( ( check_string( get_field( 'headline_background', $_obj_id ) ) ) ? ' style="background-image: url(' . wp_get_attachment_image_src( get_field( 'headline_background', $_obj_id ), 'full', false )[0] . ');"' : '' ),
];

// Overrides
if ( get_field( 'add_alternative_title', $_obj_id ) ) :
	$headline->title = get_field( 'headline_heading', $_obj_id );
endif;
$headline->title = str_replace( array( '[[', ']]' ), array( '<b>', '</b>' ), $headline->title );
if ( check_string( $headline->mini ) ) :
	$headline->element['heading'] = 'strong';
endif;

$headline->element['class'] = implode( ' ', $_classes );

if ( $headline->status && !is_front_page() ) :
	?>

		<a id="top"></a>
		<div class="<?php echo $headline->element['class']; ?>"<?php echo $headline->background; ?>>
			<div class="boxed">
				<?php if ( check_string( $headline->mini ) ) : ?>
					<<?php echo $headline->element['mini_heading']; ?> class="page-mini-title"><?php echo $headline->mini; ?></<?php echo $headline->element['mini_heading']; ?>>
				<?php endif; ?>
				<<?php echo $headline->element['heading']; ?> class="page-title"><?php echo $headline->title; ?></<?php echo $headline->element['heading']; ?>>
				<?php if ( check_string( $headline->text ) ) : ?>
					<div class="page-headline-text">
						<?php echo $headline->text; ?>
					</div>
				<?php endif; ?>
			</div>
		</div>

	<?php
elseif ( !$headline->status && !is_front_page() ) :
	?>
		<h1 hidden><?php echo get_the_title( $_obj_id ); ?></h1>
	<?php
endif;