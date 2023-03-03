<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package tdd
 */

$header = (object) [
	'class'			=> '', // ( ( is_front_page() ) ? ' home-header' : '' ),
	'logo'			=> get_template_directory_uri() . '/img/common/theme_logo.svg',
	'menu_args'		=> array(
							'theme_location' => 'header-navigation',
							'menu_id'        => 'primary-menu',
							'depth'			 => 3,
							'echo'			 => false,
						),
	'add_cta'		=> get_field( 'header_cta_add_button', 'option' ),
	'cta_button'	=> get_field( 'header_cta_button', 'option' ),
];

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a tabindex="1" class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'tdd' ); ?></a>

	<header id="masthead" class="site-header" tabindex="2">
		<?php /* get_template_part( 'template-parts/component/component', 'announcement' ); */ ?>

		<div class="boxed header-main">
			<div class="logo-wrapper">
				<a class="site-link" href="<?php echo esc_url( home_url( '/' ) ); ?>">
					<?php if( check_string( $header->logo ) ): ?>
						<img class="site-logo" src="<?php echo $header->logo; ?>" alt="<?php bloginfo('name'); ?>">
					<?php else: ?>
						<?php bloginfo('name'); ?>
					<?php endif; ?>
				</a>
			</div>
			
			<div class="header-nav">
				<nav id="site-navigation" class="main-navigation">
					<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><i class="toggle-icon"></i><span hidden>Toggle Menu</span></button>
					<?php echo str_replace( array('[[', ']]'), array('<span>', '</span>'), wp_nav_menu( $header->menu_args ) ); ?>
					<?php /* if ( is_user_logged_in() ) : ?>
						<div class="test-navigation">
							<?php echo wp_nav_menu( array(
								'theme_location' => 'developer-navigation',
								'menu_id'        => 'developer-menu',
								'depth'			 => 3,
								'echo'			 => false,
							), ); ?>
						</div>
					<?php endif; */ ?>
				</nav>
			</div>

			<?php if ( $header->add_cta && check_array( $header->cta_button ) ) : ?>
				<?php 
					if ( $header->cta_button['button_type'] == 'btn-page' ) :
						$_btn_url = get_the_permalink( $header->cta_button['button_page'] );
					elseif ( $header->cta_button['button_type'] == 'btn-url' ) :
						$_btn_url = $header->cta_button['button_url'];
					elseif ( $header->cta_button['button_type'] == 'btn-file' ) :
						$_btn_url = $header->cta_button['button_file'];
					elseif ( $header->cta_button['button_type'] == 'btn-other' ) :
						$_btn_url = $header->cta_button['button_other'];
					endif;
				?>
				<div class="header-main__cta no-mobile">
					<a href="<?php echo $_btn_url; ?>" target="<?php echo $header->cta_button['button_link_target']; ?>" class="btn">
						<?php echo $header->cta_button['button_text']; ?>
					</a>
				</div>
			<?php endif; ?>
		</div>
	</header>
