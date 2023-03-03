<?php
// Declare the object variable
$section = (object) [
    'box_class'         => array(),
    'box_css'           => array(),
    'class'             => array( 'content-section' ),
    'content'           => '',
    'css'               => array(),
    'e'                 => array( 'heading_tag' => 'h1' ), // Elements
    'id'                => '',
    'strings'           => array(),
];

array_push( $section->class, 'content-main-banner' );
array_push( $section->box_class, 'boxed', 'full-width' );

// Content
$section->e['heading'] = get_field( 'homepage_heading', get_the_ID() );
$section->e['menu'] = get_field( 'homepage_menu', get_the_ID() );
$section->e['video_type'] = get_field( 'homepage_video_type', get_the_ID() );
if ( $section->e['video_type'] == 'homepage-video-youtube' && check_string( get_field( 'homepage_video_url', get_the_ID() ) ) ) :
    parse_str( parse_url( get_field( 'homepage_video_url', get_the_ID() ), PHP_URL_QUERY ), $_yt );
    $embed_url = 'https://www.youtube-nocookie.com/embed/' . $_yt['v'] . '?controls=0&amp;autoplay=1&amp;playsinline=1&amp;loop=1&amp;playlist=' . $_yt['v'] . '&amp;rel=0&amp;showinfo=0&amp;mute=1';
else :
    $embed_url = get_field( 'homepage_video_file', get_the_ID() );
endif;

ob_start();
?>

    <div class="boxed">
        <?php if ( check_string( $section->e['heading'] ) ) : ?>
            <div class="homepage-content">
                <<?php echo $section->e['heading_tag']; ?> class="homepage-heading"><?php echo $section->e['heading']; ?></<?php echo $section->e['heading_tag']; ?>>
            </div>
        <?php endif; ?>

        <?php if ( check_string( $section->e['menu'] ) ) : ?>
            <div class="homepage-menu">
                <?php echo $section->e['menu']; ?>
            </div>
        <?php endif; ?>
    </div>

    <?php if ( check_string( $embed_url ) ) : ?>
        <?php if ( $section->e['video_type'] == 'homepage-video-youtube' ) : ?>
            <div class="video-bg cover">
                <div class="video-fg">
                    <iframe src="<?php echo $embed_url; ?>" title="YouTube video player" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
            </div>
        <?php else : ?>
            <div class="video-bg cover">
                <div class="video-fg supports-cover">
                    <video playsinline autoplay muted loop id="bgvideo">
                        <source src="<?php echo $embed_url; ?>" type="video/mp4">
                    </video>
                </div>
            </div>
        <?php endif; ?>
    <?php endif; ?>

<?php
$section->content .= ob_get_clean();

// Build the classes & css
$section->strings['class'] = ( ( check_array( $section->class ) ) ? implode( ' ', $section->class ) : '' );
$section->strings['box_class'] = ( ( check_array( $section->box_class ) ) ? implode( ' ', $section->box_class ) : '' );
$section->strings['css'] = ( ( check_array( $section->css ) ) ? ' style="' . implode( '; ', $section->css ) . '"' : '' );
$section->strings['box_css'] = ( ( check_array( $section->box_css ) ) ? ' style="' . implode( '; ', $section->box_css ) . '"' : '' );

// Display the section
?>

    <div<?php echo $section->id; ?> class="<?php echo $section->strings['class']; ?>"<?php echo $section->strings['css']; ?>>
        <?php if ( $section->strings['box_class'] !== '' ) : ?>
            <div class="<?php echo $section->strings['box_class']; ?>"<?php echo $section->strings['box_css']; ?>>
        <?php endif; ?>
        <?php echo $section->content; ?>
        <?php if ( $section->strings['box_class'] !== '' ) : ?>
            </div>
        <?php endif; ?>
    </div>

<?php
