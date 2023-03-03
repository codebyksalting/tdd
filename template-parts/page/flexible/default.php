<?php
$_tab_counter = 1;
if ( have_rows( 'default_flexible_content' ) ) :
    while ( have_rows('default_flexible_content') ) : the_row();

        // Declare the object variable
        $section = (object) [
            'visibility'        => true,
            'id'                => '', // Section ID
            'class'             => array( 'content-section' ), // Section class
            'css'               => array(), // Section inline styles
            'box_class'         => array(), // Box class
            'box_css'           => array(), // Box inline styles
            'content'           => '', // Section content
            'outer_content'     => '', // Video backgrounds, animated SVG backgrounds, etc.
            'e'                 => array(), // ACF content
            'strings'           => array(), // Recurring or hard-coded text
        ];

        // ACF Field :: True/False :: Default - True
        $section->visibility = get_sub_field( 'section_visibility' );

        // ACF Field :: Text :: Default - null
        $_section_id = get_sub_field( 'section_id' );
        if ( $_section_id ) :
            $section->id = ' id="' . str_replace( ' ', '-', $_section_id ) . '"'; // Replace spaces with hyphen
        endif;

        // ACF Field :: Text :: Default - null
        $_section_class = get_sub_field( 'section_class' );
        if ( check_string( $_section_class ) ) :
            array_push( $section->class, $_section_class );
        endif;

        if ( $section->visibility ) :

            // SECTION - TESTIMONIAL SLIDER
            if ( get_row_layout() == 'section_testimonial_slider' ) :
                array_push( $section->class, 'content-testimonial-slider' );
                array_push( $section->box_class, 'boxed' );

                // Content
                $section->e['mini_heading'] = get_sub_field( 'section_mini_heading' );
                $section->e['heading'] = get_sub_field( 'section_heading' );

                // WP_Query arguments
                $wp_query_args = array (
                    'post_type'              => array( 'testimonial' ),
                    'post_status'            => array( 'publish' ),
                    'posts_per_page'         => 10,
                    'orderby'				 => 'menu_order',
                    'order'                  => 'ASC',
                );

                // Query
                $wp_query_posts = new WP_Query( $wp_query_args );

                // Settings
                $section->e['background'] = get_sub_field( 'section_background' );

                // Overrides
                if ( check_string( $section->e['background'] ) ) :
                    array_push( $section->class, $section->e['background'] );
                endif;
                
                ob_start();
                ?>

                    <?php
                        // Component: Mini Heading
                        get_template_part( 'template-parts/component/component', 'miniheading', array(
                            'text'      => $section->e['mini_heading'],
                            'element'   => 'h2',
                        ));
                    ?>

                    <?php
                        // Component: Heading
                        get_template_part( 'template-parts/component/component', 'heading', array(
                            'text'      => $section->e['heading'],
                            'element'   => 'strong',
                        ));
                    ?>

                    <?php if ( $wp_query_posts->have_posts() ) : ?>
                        <div class="testimonial-wrapper">
                            <div class="testimonial-slides">
                                <?php while ( $wp_query_posts->have_posts() ) : $wp_query_posts->the_post(); ?>
                                    <div class="testimonial-slide">
                                        <div class="testimonial-cols">
                                            <?php if ( check_string( get_field( 'testimonial_photo', get_the_ID() ) ) ) : ?>
                                                <figure class="testimonial-col testimonial-col__photo">
                                                    <img src="<?php echo wp_get_attachment_image_src( get_field( 'testimonial_photo', get_the_ID() ), 'full', false )[0]; ?>" alt="">
                                                </figure>
                                            <?php endif; ?>

                                            <div class="testimonial-col testimonial-col__content">
                                                <?php if ( check_string( get_field( 'testimonial_text', get_the_ID() ) ) ) : ?>
                                                    <div class="testimonial-slide__text">
                                                        <?php echo generate_excerpt( get_field( 'testimonial_text', get_the_ID() ), 213, '&nbsp;[&hellip;]'); ?>
                                                    </div>
                                                <?php endif; ?>

                                                <strong class="testimonial-slide__title">
                                                    <?php echo get_the_title( get_the_ID() ); ?><?php echo ( ( check_string( get_field( 'testimonial_position', get_the_ID() ) ) ) ? ', <span>' . get_field( 'testimonial_position', get_the_ID() ) . '</span>' : '' ); ?>
                                                </strong>
                                            </div>
                                        </div>
                                    </div>
                                <?php endwhile; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php wp_reset_postdata(); ?>

                <?php
                $section->content .= ob_get_clean();

            // SECTION - LATEST BLOG POSTS
            elseif ( get_row_layout() == 'section_latest_blogs' ) :
                array_push( $section->class, 'content-latest-blogs' );
                array_push( $section->box_class, 'boxed' );

                // Content
                $section->e['heading'] = get_sub_field( 'section_heading' );

                // WP_Query arguments
                $wp_query_args = array (
                    'post_type'              => array( 'post' ),
                    'post_status'            => array( 'publish' ),
                    'posts_per_page'         => 3,
                    'orderby'				 => 'date',
                    'order'                  => 'DESC',
                );

                // Strings
                $section->strings = array(
                    'btn_continue'      => 'Continue reading',
                );

                // Query
                $wp_query_posts = new WP_Query( $wp_query_args );

                ob_start();
                ?>

                    <?php
                        // Component: Mini Heading
                        get_template_part( 'template-parts/component/component', 'miniheading', array(
                            'text'      => $section->e['heading'],
                            'element'   => 'h2',
                        ));
                    ?>

                    <?php if ( $wp_query_posts->have_posts() ) : ?>
                        <div class="blog-tiles">
                            <?php while ( $wp_query_posts->have_posts() ) : $wp_query_posts->the_post(); ?>
                                <?php
                                    $section->e['tile'] = array(
                                        'id'        => get_the_ID(),
                                        'title'     => get_the_title( get_the_ID() ),
                                        'url'       => get_the_permalink( get_the_ID() ),
                                        'date'      => get_the_date( 'F j, Y', get_the_ID() ),
                                        'image'     => ( ( check_string( get_field( 'blog_image', get_the_ID() ) ) ) ? get_field( 'blog_image', get_the_ID() ) : 912 ),
                                        'desc'      => generate_excerpt( get_field( 'blog_text', get_the_ID() ), 143, '&nbsp;[&hellip;]'),
                                    );
                                ?>
                                <div class="blog-tile">
                                    <div class="blog-tile__link">
                                        <?php if ( check_string( $section->e['tile']['image'] ) ) : ?>
                                            <figure class="blog-tile__image">
                                                <div>
                                                    <img src="<?php echo wp_get_attachment_image_src( $section->e['tile']['image'], 'resource-thumb', false )[0]; ?>" alt="">
                                                </div>
                                            </figure>
                                        <?php endif; ?>

                                        <?php if ( check_string( $section->e['tile']['title'] ) ) : ?>
                                            <strong class="blog-tile__title"><?php echo $section->e['tile']['title']; ?></strong>
                                        <?php endif; ?>

                                        <?php if ( check_string( $section->e['tile']['desc'] ) ) : ?>
                                            <div class="blog-tile__excerpt">
                                                <?php echo $section->e['tile']['desc']; ?>
                                            </div>
                                        <?php endif; ?>

                                        <div class="section-buttons">
                                            <a href="<?php echo $section->e['tile']['url']; ?>" class="btn"><?php echo $section->strings['btn_continue']; ?></a>
                                        </div>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    <?php endif; ?>

                <?php
                $section->content .= ob_get_clean();

                wp_reset_postdata();

            // SECTION - TEAM GRID
            elseif ( get_row_layout() == 'section_team_grid' ) :
                array_push( $section->class, 'content-team-grid' );
                array_push( $section->box_class, 'boxed' );

                // WP_Query arguments
                $wp_query_args = array (
                    'post_type'              => array( 'team' ),
                    'post_status'            => array( 'publish' ),
                    'posts_per_page'         => -1,
                    'orderby'				 => 'menu_order',
                    'order'                  => 'ASC',
                );

                // Strings
                $section->strings = array(
                    'btn_details'      => 'View Details',
                );

                // Query
                $wp_query_posts = new WP_Query( $wp_query_args );

                ob_start();
                ?>

                    <?php if ( $wp_query_posts->have_posts() ) : ?>
                        <div class="team-tiles">
                            <?php while ( $wp_query_posts->have_posts() ) : $wp_query_posts->the_post(); ?>
                                <?php
                                    $section->e['team'] = array(
                                        'id'        => get_the_ID(),
                                        'title'     => get_the_title( get_the_ID() ),
                                        'url'       => get_the_permalink( get_the_ID() ),
                                        'image'     => get_field( 'team_photo', get_the_ID() ),
                                        'position'  => get_field( 'team_position', get_the_ID() ),
                                        'linkedin'  => get_field( 'team_linkedin', get_the_ID() ),
                                    );
                                ?>
                                <div class="team-tile">
                                    <a class="team-tile__link" href="<?php echo $section->e['team']['url']; ?>">
                                        <?php if ( check_string( $section->e['team']['image'] ) ) : ?>
                                            <figure class="team-tile__image">
                                                <div>
                                                    <img class="clip-small-mask" src="<?php echo wp_get_attachment_image_src( $section->e['team']['image'], 'team-thumb', false )[0]; ?>" alt="">
                                                </div>
                                            </figure>
                                        <?php endif; ?>

                                        <?php if ( check_string( $section->e['team']['title'] ) ) : ?>
                                            <strong class="team-tile__title"><?php echo $section->e['team']['title']; ?></strong>
                                        <?php endif; ?>

                                        <?php if ( check_string( $section->e['team']['position'] ) ) : ?>
                                            <em class="team-tile__position"><?php echo $section->e['team']['position']; ?></em>
                                        <?php endif; ?>

                                        <div class="section-buttons">
                                            <button href="<?php echo $section->e['team']['url']; ?>" class="btn"><?php echo $section->strings['btn_details']; ?></button>
                                        </div>
                                    </a>

                                    <?php if ( check_string( $section->e['team']['linkedin'] ) ) : ?>
                                        <a class="team-tile__linkedin" href="<?php echo $section->e['team']['linkedin']; ?>">
                                            <img src="<?php echo get_template_directory_uri(); ?>/img/content/li_team.svg" alt="LinkedIn">
                                        </a>
                                    <?php endif; ?>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    <?php endif; ?>

                <?php
                $section->content .= ob_get_clean();

                wp_reset_postdata();

            // SECTION - LATEST CASE STUDIES (CAROUSEL)
            elseif ( get_row_layout() == 'section_latest_cases' ) :
                array_push( $section->class, 'content-latest-cases' );
                array_push( $section->box_class, 'boxed' );

                // Content
                $section->e['heading'] = get_sub_field( 'section_heading' );

                // WP_Query arguments
                $wp_query_args = array (
                    'post_type'              => array( 'case' ),
                    'post_status'            => array( 'publish' ),
                    'posts_per_page'         => 5,
                    'orderby'				 => 'date',
                    'order'                  => 'DESC',
                );

                // Strings
                $section->strings = array(
                    'btn_continue'      => 'Continue reading',
                );

                // Query
                $wp_query_posts = new WP_Query( $wp_query_args );

                ob_start();
                ?>

                    <?php
                        // Component: Mini Heading
                        get_template_part( 'template-parts/component/component', 'miniheading', array(
                            'text'      => $section->e['heading'],
                            'element'   => 'h2',
                        ));
                    ?>

                    <?php if ( $wp_query_posts->have_posts() ) : ?>
                        <div class="case-items case-carousel">
                            <?php while ( $wp_query_posts->have_posts() ) : $wp_query_posts->the_post(); ?>
                                <?php
                                    $section->e['case'] = array(
                                        'id'        => get_the_ID(),
                                        'title'     => get_the_title( get_the_ID() ),
                                        'excerpt'   => generate_excerpt( get_field( 'case_desc', get_the_ID() ) , 250 ),
                                        'url'       => get_the_permalink( get_the_ID() ),
                                        'image'     => ( ( check_string( get_field( 'case_main_image', get_the_ID() ) ) ) ? wp_get_attachment_image_src( get_field( 'case_main_image', get_the_ID() ) , 'resource-medium' )[0] : wp_get_attachment_image_src( 912, 'resource-medium' )[0] ),
                                    );
                                ?>
                                <div class="case-item">
                                    <div class="case-item__cols">
                                        <figure class="case-item__col case-item__image">
                                            <div>
                                                <img src="<?php echo $section->e['case']['image']; ?>" alt="">
                                            </div>
                                        </figure>

                                        <div class="case-item__col case-item__content">
                                            <strong class="case-item__title"><?php echo $section->e['case']['title']; ?></strong>

                                            <div class="case-item__text">
                                                <?php echo $section->e['case']['excerpt']; ?>
                                            </div>

                                            <div class="section-buttons">
                                                <a href="<?php echo $section->e['case']['url']; ?>" class="btn"><?php echo $section->strings['btn_continue']; ?></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    <?php endif; ?>

                <?php
                $section->content .= ob_get_clean();

                wp_reset_postdata();

            // SECTION - LATEST CASE STUDY (SINGLE)
            elseif ( get_row_layout() == 'section_latest_case' ) :
                array_push( $section->class, 'content-latest-case' );
                array_push( $section->box_class, 'boxed' );

                // Content
                $section->e['heading'] = get_sub_field( 'section_heading' );

                // WP_Query arguments
                $wp_query_args = array (
                    'post_type'              => array( 'case' ),
                    'post_status'            => array( 'publish' ),
                    'posts_per_page'         => 1,
                    'orderby'				 => 'date',
                    'order'                  => 'DESC',
                );

                // Strings
                $section->strings = array(
                    'btn_continue'      => 'Continue reading',
                );

                // Query
                $wp_query_posts = new WP_Query( $wp_query_args );

                ob_start();
                ?>

                    <?php
                        // Component: Mini Heading
                        get_template_part( 'template-parts/component/component', 'miniheading', array(
                            'text'      => $section->e['heading'],
                            'element'   => 'h2',
                        ));
                    ?>

                    <?php if ( $wp_query_posts->have_posts() ) : ?>
                        <div class="case-items case-carousel">
                            <?php while ( $wp_query_posts->have_posts() ) : $wp_query_posts->the_post(); ?>
                                <?php
                                    $section->e['case'] = array(
                                        'id'        => get_the_ID(),
                                        'title'     => get_the_title( get_the_ID() ),
                                        'excerpt'   => generate_excerpt( get_field( 'case_desc', get_the_ID() ) , 426 ),
                                        'url'       => get_the_permalink( get_the_ID() ),
                                        'image'     => ( ( check_string( get_field( 'case_main_image', get_the_ID() ) ) ) ? wp_get_attachment_image_src( get_field( 'case_main_image', get_the_ID() ) , 'resource-medium' )[0] : wp_get_attachment_image_src( 912, 'resource-medium' )[0] ),
                                    );
                                ?>
                                <div class="case-item">
                                    <strong class="case-item__title"><?php echo $section->e['case']['title']; ?></strong>

                                    <div class="case-item__cols">
                                        <figure class="case-item__col case-item__image">
                                            <div>
                                                <img src="<?php echo $section->e['case']['image']; ?>" alt="">
                                            </div>
                                        </figure>

                                        <div class="case-item__col case-item__content">
                                            <div class="case-item__text">
                                                <?php echo $section->e['case']['excerpt']; ?>
                                            </div>

                                            <div class="section-buttons">
                                                <a href="<?php echo $section->e['case']['url']; ?>" class="btn"><?php echo $section->strings['btn_continue']; ?></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    <?php endif; ?>

                <?php
                $section->content .= ob_get_clean();

                wp_reset_postdata();

            // SECTION - HEADING & TEXT
            elseif ( get_row_layout() == 'section_heading_text' ) :
                array_push( $section->class, 'content-heading-text' );
                array_push( $section->box_class, 'boxed', 'narrow' );

                // Content
                $section->e['heading'] = get_sub_field( 'section_heading' );
                $section->e['content'] = get_sub_field( 'section_content' );
                $section->e['add_button'] = get_sub_field( 'section_add_button' );
                if ( $section->e['add_button'] ) :
                    $section->e['button'] = get_sub_field( 'section_button' );
                endif;

                ob_start();
                ?>

                    <?php
                        // Component: Heading
                        get_template_part( 'template-parts/component/component', 'heading', array(
                            'text' => $section->e['heading'],
                        ));
                    ?>

                    <?php
                        // Component: Content
                        get_template_part( 'template-parts/component/component', 'content', array(
                            'text' => $section->e['content'],
                        ));
                    ?>

                    <?php
                        // Component: Button
                        get_template_part( 'template-parts/component/component', 'button', array(
                            'add_button'    => $section->e['add_button'],
                            'button'        => $section->e['button'],
                            'wrapper_class' => array( 'section-buttons', 'centered-buttons' ),
                            'button_class'  => array( 'btn' ),
                        ));
                    ?>

                <?php
                $section->content .= ob_get_clean();

            // SECTION - TEXT WITH LEFT IMAGE
            elseif ( get_row_layout() == 'section_left_image' ) :
                array_push( $section->class, 'content-left-image' );
                array_push( $section->box_class, 'boxed' );

                // Content
                $section->e['heading'] = get_sub_field( 'section_heading' );
                $section->e['content'] = get_sub_field( 'section_content' );
                $section->e['image'] = get_sub_field( 'section_image' );
                $section->e['add_button'] = get_sub_field( 'section_add_button' );
                if ( $section->e['add_button'] ) :
                    $section->e['button'] = get_sub_field( 'section_button' );
                endif;

                ob_start();
                ?>

                    <div class="two-columns">
                        <?php if ( check_string( $section->e['image'] ) ) : ?>
                            <figure class="two-columns__image">
                                <img src="<?php echo wp_get_attachment_image_src( $section->e['image'], 'full' )[0]; ?>" alt="">
                            </figure>
                        <?php endif; ?>

                        <div class="two-columns__content">
                            <?php
                                // Component: Heading
                                get_template_part( 'template-parts/component/component', 'heading', array(
                                    'text' => $section->e['heading'],
                                ));
                            ?>

                            <?php
                                // Component: Content
                                get_template_part( 'template-parts/component/component', 'content', array(
                                    'text' => $section->e['content'],
                                ));
                            ?>
                            
                            <?php
                                // Component: Button
                                get_template_part( 'template-parts/component/component', 'button', array(
                                    'add_button'    => $section->e['add_button'],
                                    'button'        => $section->e['button'],
                                    'wrapper_class' => array( 'section-buttons' ),
                                    'button_class'  => array( 'btn' ),
                                ));
                            ?>
                        </div>
                    </div>

                <?php
                $section->content .= ob_get_clean();

            // SECTION - TEXT WITH RIGHT IMAGE
            elseif ( get_row_layout() == 'section_right_image' ) :
                array_push( $section->class, 'content-right-image' );
                array_push( $section->box_class, 'boxed' );

                // Content
                $section->e['heading'] = get_sub_field( 'section_heading' );
                $section->e['content'] = get_sub_field( 'section_content' );
                $section->e['image'] = get_sub_field( 'section_image' );
                $section->e['add_button'] = get_sub_field( 'section_add_button' );
                if ( $section->e['add_button'] ) :
                    $section->e['button'] = get_sub_field( 'section_button' );
                endif;

                ob_start();
                ?>

                    <div class="two-columns">
                        <?php if ( check_string( $section->e['image'] ) ) : ?>
                            <figure class="two-columns__image">
                                <img src="<?php echo wp_get_attachment_image_src( $section->e['image'], 'full' )[0]; ?>" alt="">
                            </figure>
                        <?php endif; ?>

                        <div class="two-columns__content">
                            <?php
                                // Component: Heading
                                get_template_part( 'template-parts/component/component', 'heading', array(
                                    'text' => $section->e['heading'],
                                ));
                            ?>

                            <?php
                                // Component: Content
                                get_template_part( 'template-parts/component/component', 'content', array(
                                    'text' => $section->e['content'],
                                ));
                            ?>
                            
                            <?php
                                // Component: Button
                                get_template_part( 'template-parts/component/component', 'button', array(
                                    'add_button'    => $section->e['add_button'],
                                    'button'        => $section->e['button'],
                                    'wrapper_class' => array( 'section-buttons' ),
                                    'button_class'  => array( 'btn' ),
                                ));
                            ?>
                        </div>
                    </div>

                <?php
                $section->content .= ob_get_clean();

            // SECTION - PAGE BANNER
            elseif ( get_row_layout() == 'section_page_banner' ) :
                array_push( $section->class, 'content-page-banner' );
                array_push( $section->box_class, 'boxed', 'full-width' );

                // Content
                $section->e['heading'] = get_sub_field( 'section_heading' );
                $section->e['content'] = get_sub_field( 'section_content' );
                $section->e['image'] = get_sub_field( 'section_image' );
                $section->e['add_button'] = get_sub_field( 'section_add_button' );
                if ( $section->e['add_button'] ) :
                    $section->e['button'] = get_sub_field( 'section_button' );
                endif;

                ob_start();
                ?>

                    <div class="two-cols">
                        <?php if ( check_string( $section->e['image'] ) ) : ?>
                            <figure class="two-col two-col__image">
                                <img class="clip-large-mask" src="<?php echo wp_get_attachment_image_src( $section->e['image'], 'mask-large' )[0]; ?>" alt="">
                            </figure>
                        <?php endif; ?>

                        <div class="two-col two-col__content">
                            <div class="two-col__inner">
                                <?php
                                    // Component: Heading
                                    get_template_part( 'template-parts/component/component', 'heading', array(
                                        'text'      => $section->e['heading'],
                                        'element'   => 'h1',
                                    ));
                                ?>

                                <?php
                                    // Component: Content
                                    get_template_part( 'template-parts/component/component', 'content', array(
                                        'text' => $section->e['content'],
                                    ));
                                ?>
                                
                                <?php
                                    // Component: Button
                                    get_template_part( 'template-parts/component/component', 'button', array(
                                        'add_button'    => $section->e['add_button'],
                                        'button'        => $section->e['button'],
                                        'wrapper_class' => array( 'section-buttons' ),
                                        'button_class'  => array( 'btn' ),
                                    ));
                                ?>
                            </div>
                        </div>
                    </div>

                <?php
                $section->content .= ob_get_clean();

            // SECTION - TEXT WITH RIGHT FLOWCHART
            elseif ( get_row_layout() == 'section_right_flowchart' ) :
                array_push( $section->class, 'content-right-flowchart' );
                array_push( $section->box_class, 'boxed', 'full-width' );

                // Content
                $section->e['mini_heading'] = get_sub_field( 'section_mini_heading' );
                $section->e['heading'] = get_sub_field( 'section_heading' );
                $section->e['content'] = get_sub_field( 'section_content' );
                $section->e['add_button'] = get_sub_field( 'section_add_button' );
                if ( $section->e['add_button'] ) :
                    $section->e['button'] = get_sub_field( 'section_button' );
                endif;
                $section->e['columns'] = get_sub_field( 'section_columns' );

                ob_start();
                ?>

                    <div class="two-cols">
                        <?php if ( check_array( $section->e['columns'] ) ) : ?>
                            <div class="two-col two-col__list">
                                <ol>
                                    <?php foreach ( $section->e['columns'] as $key => $item ) : ?>
                                        <?php
                                            $_href = '';
                                            if ( check_string( $item['column_url'] ) ) :
                                                $_href = ' href="' . $item['column_url'] . '"';
                                            endif;
                                        ?>
                                        <li>
                                            <a<?php echo $_href; ?>>
                                                <figure class="two-list__image">
                                                    <img src="<?php echo wp_get_attachment_image_src( $item['column_image'], 'full', false )[0]; ?>" alt="<?php echo $item['column_title']; ?>">
                                                </figure>

                                                <div class="two-list__inner">
                                                    <strong class="two-list__title"><?php echo $item['column_title']; ?></strong>

                                                    <ul class="two-list__items">
                                                        <?php if ( check_array( $item['column_list'] ) ) : ?>
                                                            <?php foreach ( $item['column_list'] as $key => $list ) : ?>
                                                                <li><?php echo $list['list_item']; ?></li>
                                                            <?php endforeach; ?>
                                                        <?php endif; ?>
                                                    </ul>
                                                </div>
                                            </a>
                                        </li>
                                    <?php endforeach; ?>
                                </ol>
                            </div>
                        <?php endif; ?>

                        <div class="two-col two-col__content">
                            <div class="two-col__inner">
                                <?php
                                    // Component: Mini Heading
                                    get_template_part( 'template-parts/component/component', 'miniheading', array(
                                        'text'      => $section->e['mini_heading'],
                                        'element'   => 'h2',
                                    ));
                                ?>

                                <?php
                                    // Component: Heading
                                    get_template_part( 'template-parts/component/component', 'heading', array(
                                        'text'      => $section->e['heading'],
                                        'element'   => 'strong',
                                    ));
                                ?>

                                <?php
                                    // Component: Content
                                    get_template_part( 'template-parts/component/component', 'content', array(
                                        'text' => $section->e['content'],
                                    ));
                                ?>
                                
                                <?php
                                    // Component: Button
                                    get_template_part( 'template-parts/component/component', 'button', array(
                                        'add_button'    => $section->e['add_button'],
                                        'button'        => $section->e['button'],
                                        'wrapper_class' => array( 'section-buttons' ),
                                        'button_class'  => array( 'btn' ),
                                    ));
                                ?>
                            </div>
                        </div>
                    </div>

                <?php
                $section->content .= ob_get_clean();

            // SECTION - MAIN BANNER
            elseif ( get_row_layout() == 'section_main_banner' ) :
                array_push( $section->class, 'content-main-banner' );
                array_push( $section->box_class, 'boxed', 'full-width' );

                // Content
                $section->e['mini_heading'] = get_sub_field( 'section_mini_heading' );
                $section->e['heading'] = get_sub_field( 'section_heading' );
                $section->e['content'] = get_sub_field( 'section_content' );
                $section->e['image'] = get_sub_field( 'section_image' );
                $section->e['cta'] = get_sub_field( 'section_columns' );

                ob_start();
                ?>

                    <div class="two-cols">
                        <?php if ( check_string( $section->e['image'] ) ) : ?>
                            <figure class="two-col two-col__image">
                                <img class="clip-large-mask" src="<?php echo wp_get_attachment_image_src( $section->e['image'], 'mask-large' )[0]; ?>" alt="">
                            </figure>
                        <?php endif; ?>

                        <div class="two-col two-col__content">
                            <div class="two-col__inner">
                                <?php
                                    // Component: Mini Heading
                                    get_template_part( 'template-parts/component/component', 'miniheading', array(
                                        'text'      => $section->e['mini_heading'],
                                        'element'   => 'strong',
                                    ));
                                ?>

                                <?php
                                    // Component: Heading
                                    get_template_part( 'template-parts/component/component', 'heading', array(
                                        'text'      => $section->e['heading'],
                                        'element'   => 'h1',
                                    ));
                                ?>

                                <?php
                                    // Component: Content
                                    get_template_part( 'template-parts/component/component', 'content', array(
                                        'text' => $section->e['content'],
                                    ));
                                ?>
                            </div>
                        </div>
                    </div>

                    <?php if ( check_array( $section->e['cta'] ) ) : ?>
                        <div class="main-banner__cta">
                            <div class="boxed">
                                <div class="cta-items">
                                    <?php foreach ( $section->e['cta'] as $key => $cta ) : ?>
                                        <div class="cta-item">
                                            <?php if ( check_string( $cta['cta_title'] ) ) : ?>
                                                <strong class="cta-item__title"><?php echo $cta['cta_title']; ?></strong>
                                            <?php endif; ?>

                                            <?php
                                                // Component: Button
                                                get_template_part( 'template-parts/component/component', 'button', array(
                                                    'add_button'    => true,
                                                    'button'        => $cta['cta_button'],
                                                    'wrapper_class' => array( 'section-buttons' ),
                                                    'button_class'  => array( 'btn' ),
                                                ));
                                            ?>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                <?php
                $section->content .= ob_get_clean();

            // SECTION - TEXT WITH LEFT MASKED IMAGE
            elseif ( get_row_layout() == 'section_left_masked_image' ) :
                array_push( $section->class, 'content-left-masked-image' );
                array_push( $section->box_class, 'boxed', 'full-width' );

                // Content
                $section->e['heading'] = get_sub_field( 'section_heading' );
                $section->e['mini_heading'] = get_sub_field( 'section_mini_heading' );
                $section->e['content'] = get_sub_field( 'section_content' );
                $section->e['image'] = get_sub_field( 'section_image' );
                $section->e['add_button'] = get_sub_field( 'section_add_button' );
                if ( $section->e['add_button'] ) :
                    $section->e['button'] = get_sub_field( 'section_button' );
                endif;

                ob_start();
                ?>

                    <div class="two-cols">
                        <?php if ( check_string( $section->e['image'] ) ) : ?>
                            <figure class="two-col two-col__image">
                                <img class="clip-large-mask" src="<?php echo wp_get_attachment_image_src( $section->e['image'], 'mask-large' )[0]; ?>" alt="">
                            </figure>
                        <?php endif; ?>

                        <div class="two-col two-col__content">
                            <div class="two-col__inner">

                                <?php
                                    // Component: Mini Heading
                                    get_template_part( 'template-parts/component/component', 'miniheading', array(
                                        'text' => $section->e['mini_heading'],
                                    ));
                                ?>

                                <?php
                                    // Component: Heading
                                    get_template_part( 'template-parts/component/component', 'heading', array(
                                        'text'      => $section->e['heading'],
                                        'element'   => 'h1',
                                    ));
                                ?>

                                <?php
                                    // Component: Content
                                    get_template_part( 'template-parts/component/component', 'content', array(
                                        'text' => $section->e['content'],
                                    ));
                                ?>
                                
                                <?php
                                    // Component: Button
                                    get_template_part( 'template-parts/component/component', 'button', array(
                                        'add_button'    => $section->e['add_button'],
                                        'button'        => $section->e['button'],
                                        'wrapper_class' => array( 'section-buttons' ),
                                        'button_class'  => array( 'btn' ),
                                    ));
                                ?>
                            </div>
                        </div>
                    </div>

                <?php
                $section->content .= ob_get_clean();

            // SECTION - TWO COLUMN TABLE
            elseif ( get_row_layout() == 'section_twocol_table' ) :
                array_push( $section->class, 'content-twocol-table' );
                array_push( $section->box_class, 'boxed' );

                // Content
                $section->e['tables'] = get_sub_field( 'section_tables' );

                // Strings
                $section->strings = array(
                    'lbl_state'         => 'State',
                    'lbl_owner'         => 'Owner',
                    'lbl_license'       => 'License #',
                );

                ob_start();
                ?>

                    <?php if ( check_array( $section->e['tables'] ) ) : ?>
                        <div class="table-cols">
                            <?php foreach ( $section->e['tables'] as $key => $tbl ) : ?>
                                <div class="table-col">
                                    <table>
                                        <tr class="tbl-heading">
                                            <th><?php echo $section->strings['lbl_state']; ?></th>
                                            <th><?php echo $section->strings['lbl_owner']; ?></th>
                                            <th><?php echo $section->strings['lbl_license']; ?></th>
                                        </tr>
                                        <?php foreach ( $tbl as $key => $rows ) : ?>
                                            <tr>
                                                <td><?php echo $rows['col_state']; ?></td>
                                                <td><?php echo $rows['col_owner']; ?></td>
                                                <td><?php echo $rows['col_license']; ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </table>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                <?php
                $section->content .= ob_get_clean();

            // SECTION - MULTIPLE ROWS IMAGE & TEXT
            elseif ( get_row_layout() == 'section_multiple_rows' ) :
                array_push( $section->class, 'content-multiple-rows' );
                array_push( $section->box_class, 'boxed', 'full-width' );

                // Variables
                $section->e['heading_element'] = 'strong';

                // Content
                $section->e['heading'] = get_sub_field( 'section_heading' );
                $section->e['rows'] = get_sub_field( 'section_columns' );

                // Settings
                $section->e['use_h1'] = get_sub_field( 'section_use_h1' );

                // Overrides
                if ( $section->e['use_h1'] ) :
                    $section->e['heading_element'] = 'h1';
                endif;

                ob_start();
                ?>

                    <?php if ( check_array( $section->e['rows'] ) ) : ?>
                        <div class="section-rows">
                            <?php foreach ( $section->e['rows'] as $key => $row ) : ?>
                                <div class="row-columns <?php echo $row['column_type']; ?>">
                                    <?php if ( check_string( $row['column_image'] ) ) : ?>
                                        <figure class="row-column row-columns__image">
                                            <img class="clip-large-mask" src="<?php echo wp_get_attachment_image_src( $row['column_image'], 'mask-large', false )[0]; ?>" alt="">
                                        </figure>
                                    <?php endif; ?>

                                    <div class="row-column row-columns__content">
                                        <div class="row-columns__inner">
                                            <?php if ( check_string( $section->e['heading'] ) && $key == 0 ) : ?>
                                                <<?php echo $section->e['heading_element']; ?> class="row-columns__heading"><?php echo $section->e['heading']; ?></<?php echo $section->e['heading_element']; ?>>
                                            <?php endif; ?>

                                            <?php
                                                // Component: Heading
                                                get_template_part( 'template-parts/component/component', 'heading', array(
                                                    'text'      => $row['column_heading'],
                                                    'element'   => 'h2',
                                                ));
                                            ?>

                                            <?php if ( check_string( $row['column_highlight'] ) ) : ?>
                                                <div class="section-highlight">
                                                    <?php echo do_shortcode( trim( $row['column_highlight'] ) ); ?>
                                                </div>
                                            <?php endif; ?>

                                            <?php
                                                // Component: Content
                                                get_template_part( 'template-parts/component/component', 'content', array(
                                                    'text' => $row['column_text'],
                                                ));
                                            ?>

                                            <?php
                                                // Component: Button
                                                get_template_part( 'template-parts/component/component', 'button', array(
                                                    'add_button'    => $row['column_add_button'],
                                                    'button'        =>  $row['column_button'],
                                                    'wrapper_class' => array( 'section-buttons' ),
                                                    'button_class'  => array( 'btn' ),
                                                ));
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                <?php
                $section->content .= ob_get_clean();

            // SECTION - LINK CARDS
            elseif ( get_row_layout() == 'section_link_cards' ) :
                array_push( $section->class, 'content-link-cards' );
                array_push( $section->box_class, 'boxed' );

                // Content
                $section->e['content'] = get_sub_field( 'section_content' );
                $section->e['columns'] = get_sub_field( 'section_columns' );

                // Settings
                $section->e['icon_size'] = get_sub_field( 'section_icon_size' );

                // Overrides
                if ( check_string( $section->e['icon_size'] ) ) :
                    array_push( $section->class, $section->e['icon_size'] );
                endif;

                ob_start();
                ?>

                    <?php
                        // Component: Content
                        get_template_part( 'template-parts/component/component', 'content', array(
                            'text' => $section->e['content'],
                        ));
                    ?>

                    <?php if ( check_array( $section->e['columns'] ) ) : ?>
                        <div class="link-cards">
                            <?php foreach ( $section->e['columns'] as $key => $card ) : ?>
                                <div class="link-card">
                                    <?php if ( check_string( $card['card_title'] ) ) : ?>
                                        <strong class="link-card__title"><?php echo $card['card_title']; ?></strong>
                                    <?php endif; ?>

                                    <div class="link-cols">
                                        <?php if ( check_string( $card['card_logo'] ) ) : ?>
                                            <figure class="link-cols__image">
                                                <img src="<?php echo wp_get_attachment_image_src( $card['card_logo'], 'full', false )[0]; ?>" alt="">
                                            </figure>
                                        <?php endif; ?>

                                        <div class="link-cols__content">
                                            <?php if ( check_string( $card['card_text'] ) ) : ?>
                                                <div class="link-cols__text">
                                                    <?php echo $card['card_text']; ?>
                                                </div>
                                            <?php endif; ?>

                                            <?php
                                                // Component: Button
                                                get_template_part( 'template-parts/component/component', 'button', array(
                                                    'add_button'    => $card['card_add_button'],
                                                    'button'        => $card['card_button'],
                                                    'wrapper_class' => array( 'section-buttons' ),
                                                    'button_class'  => array( 'btn' ),
                                                ));
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                <?php
                $section->content .= ob_get_clean();

            // SECTION - THREE COLUMN ICON & TEXT WITH HOVER
            elseif ( get_row_layout() == 'section_threecol_hover' ) :
                array_push( $section->class, 'content-threecol-hover' );
                array_push( $section->box_class, 'boxed' );

                // Content
                $section->e['mini_heading'] = get_sub_field( 'section_mini_heading' );
                $section->e['heading'] = get_sub_field( 'section_heading' );
                $section->e['columns'] = get_sub_field( 'section_columns' );
                $section->e['add_button'] = get_sub_field( 'section_add_button' );
                if ( $section->e['add_button'] ) :
                    $section->e['button'] = get_sub_field( 'section_button' );
                endif;

                ob_start();
                ?>

                    <?php
                        // Component: Mini Heading
                        get_template_part( 'template-parts/component/component', 'miniheading', array(
                            'text' => $section->e['mini_heading'],
                        ));
                    ?>

                    <?php
                        // Component: Heading
                        get_template_part( 'template-parts/component/component', 'heading', array(
                            'text' => $section->e['heading'],
                        ));
                    ?>

                    <?php if ( check_array( $section->e['columns'] ) ) : ?>
                        <div class="link-cards">
                            <?php foreach ( $section->e['columns'] as $key => $card ) : ?>
                                <?php
                                    $section->e['href'] = '';
                                    if ( check_string( $card['column_link'] ) ) :
                                        $section->e['href'] = ' href="' . get_the_permalink( $card['column_link'] ) . '"';
                                    endif;
                                ?>
                                <a<?php echo $section->e['href']; ?> class="link-card">
                                    <div class="link-card__header">
                                        <?php if ( check_string( $card['column_icon'] ) ) : ?>
                                            <figure class="link-card__image">
                                                <img src="<?php echo wp_get_attachment_image_src( $card['column_icon'], 'full', false )[0]; ?>" alt="">
                                            </figure>
                                            <?php endif; ?>
                                            <?php if ( check_string( $card['column_title'] ) ) : ?>
                                                <strong class="link-card__title"><?php echo $card['column_title']; ?></strong>
                                            <?php endif; ?>
                                    </div>
                                                                           
                                    <?php if ( check_string( $card['column_text'] ) ) : ?>
                                        <div class="link-card__text">
                                            <?php echo $card['column_text']; ?>
                                        </div>
                                    <?php endif; ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <?php
                        // Component: Button
                        get_template_part( 'template-parts/component/component', 'button', array(
                            'add_button'    => $section->e['add_button'],
                            'button'        => $section->e['button'],
                            'wrapper_class' => array( 'section-buttons', 'centered-buttons' ),
                            'button_class'  => array( 'btn' ),
                        ));
                    ?>

                <?php
                $section->content .= ob_get_clean();

            // SECTION - NAVIGATION CARDS
            elseif ( get_row_layout() == 'section_navigation_cards' ) :
                array_push( $section->class, 'content-navigation-cards' );
                array_push( $section->box_class, 'boxed' );

                // Content
                $section->e['columns'] = get_sub_field( 'section_columns' );

                ob_start();
                ?>

                    <?php if ( check_array( $section->e['columns'] ) ) : ?>
                        <ol class="link-cards">
                            <?php foreach ( $section->e['columns'] as $key => $card ) : ?>
                                <li>
                                    <a href="<?php echo $card['column_link']; ?>" class="link-card">
                                        <?php if ( check_string( $card['column_image'] ) ) : ?>
                                            <figure class="link-card__image">
                                                <img src="<?php echo wp_get_attachment_image_src( $card['column_image'], 'full', false )[0]; ?>" alt="">
                                            </figure>
                                        <?php endif; ?>

                                        <?php if ( check_string( $card['column_heading'] ) ) : ?>
                                            <strong class="link-card__title"><?php echo $card['column_heading']; ?></strong>
                                        <?php endif; ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ol>
                    <?php endif; ?>

                <?php
                $section->content .= ob_get_clean();

            // SECTION - MULTI-COLUMN ICON & TEXT
            elseif ( get_row_layout() == 'section_multiple_columns' ) :
                array_push( $section->class, 'content-multiple-columns' );
                array_push( $section->box_class, 'boxed' );

                // Content
                $section->e['columns'] = get_sub_field( 'section_columns' );

                ob_start();
                ?>

                    <?php if ( check_array( $section->e['columns'] ) ) : ?>
                        <div class="section-columns">
                            <?php foreach ( $section->e['columns'] as $key => $column ) : ?>
                                <div class="row-column">
                                    <a class="row-column__anchor">
                                        <?php if ( check_string( $column['column_image'] ) ) : ?>
                                            <figure class="row-column__image">
                                                <img src="<?php echo wp_get_attachment_image_src( $column['column_image'], 'full', false )[0]; ?>" alt="">
                                            </figure>
                                        <?php endif; ?>

                                        <?php if ( check_string( $column['column_heading'] ) ) : ?>
                                            <strong class="row-column__title"><?php echo $column['column_heading']; ?></strong>
                                        <?php endif; ?>

                                        <?php if ( check_string( $column['column_text'] ) ) : ?>
                                            <div class="row-column__text">
                                                <?php echo $column['column_text']; ?>
                                            </div>
                                        <?php endif; ?>
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                <?php
                $section->content .= ob_get_clean();

            // SECTION - CONTENT WITH SIDEBAR
            elseif ( get_row_layout() == 'section_content_sidebar' ) :
                array_push( $section->class, 'content-content-sidebar' );
                array_push( $section->box_class, 'boxed' );

                // Content
                $section->e['rows'] = get_sub_field( 'section_columns' );
                $section->e['sidebar'] = get_sub_field( 'section_sidebar' );

                ob_start();
                ?>

                    <?php if ( $section->e['rows'] ) : ?>
                        <div class="pseudo-container">
                            <div class="pseudo-sidebar">
                                <?php if ( check_array( $section->e['sidebar'] ) ) : ?>
                                    <div class="hc-sticky">
                                        <ul class="float-menu">
                                            <?php foreach ( $section->e['sidebar'] as $key => $menu ) : ?>
                                                <li class="float-menu-item">
                                                    <a href="#<?php echo $menu['menu_anchor_id']; ?>"><?php echo $menu['menu_text']; ?></a>

                                                    <?php if ( check_array( $menu['menu_submenu'] ) ) : ?>
                                                        <ul class="float-sub-menu">
                                                            <?php foreach ( $menu['menu_submenu'] as $key => $submenu ) : ?>
                                                                <li class="float-menu-item">
                                                                    <a href="#<?php echo $submenu['submenu_anchro_id']; ?>"><?php echo $submenu['submenu_text']; ?></a>
                                                                </li>
                                                            <?php endforeach; ?>
                                                        </ul>
                                                    <?php endif; ?>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div class="pseudo-content">
                                <?php if ( check_array( $section->e['rows'] ) ) : ?>
                                    <div class="section-rows">
                                        <?php foreach( $section->e['rows'] as $key => $row ) : ?>
                                            <div class="section-row"<?php echo ( ( check_string( $row['section_anchor_id'] ) ) ? ' id="' . $row['section_anchor_id'] . '"' : '' ); ?>>
                                                <?php if ( check_string( $row['section_title'] ) ) : ?>
                                                    <h2 class="section-row__title"><?php echo $row['section_title']; ?></h2>
                                                <?php endif; ?>

                                                <?php if ( check_array( $row['section_areas'] ) ) : ?>
                                                    <div class="section-row__areas">
                                                        <?php foreach ( $row['section_areas'] as $key => $area ) : ?>
                                                            <div class="section-row__area <?php echo $area['area_type']; ?>"<?php echo ( ( check_string( $area['area_id'] ) ) ? ' id="' . $area['area_id'] . '"' : '' ); ?>>
                                                                <div class="row-area__content cf">
                                                                    <?php if ( check_string( $area['area_image'] ) ) : ?>
                                                                        <figure class="row-area__image">
                                                                            <div>
                                                                                <img src="<?php echo wp_get_attachment_image_src( $area['area_image'], 'full', false )[0]; ?>" alt="">
                                                                            </div>
                                                                        </figure>
                                                                    <?php endif; ?>

                                                                    <?php if ( check_string( $area['area_heading'] ) ) : ?>
                                                                        <strong class="row-area__title"><?php echo $area['area_heading']; ?></strong>
                                                                    <?php endif; ?>

                                                                    <?php if ( check_string( $area['area_text'] ) ) : ?>
                                                                            <?php echo $area['area_text']; ?>
                                                                    <?php endif; ?>
                                                                </div>

                                                                <?php if ( check_array( $area['icon_items'] ) ) : ?>
                                                                    <ul class="row-area__icons <?php echo $area['icon_columns']; ?>">
                                                                        <?php foreach ( $area['icon_items'] as $key => $item ) : ?>
                                                                            <li class="row-area__icon">
                                                                                <?php if ( check_string( $item['icon_image'] ) ) : ?>
                                                                                    <figure class="row-icon__image">
                                                                                        <img src="<?php echo wp_get_attachment_image_src( $item['icon_image'], 'full', false )[0]; ?>" alt="">
                                                                                    </figure>
                                                                                <?php endif; ?>

                                                                                <div class="row-icon__content">
                                                                                    <?php if ( check_string( $item['icon_title'] ) ) : ?>
                                                                                        <strong class="row-icon__title"><?php echo $item['icon_title']; ?></strong>
                                                                                    <?php endif; ?>
    
                                                                                    <?php if ( check_string( $item['icon_text'] ) ) : ?>
                                                                                        <?php echo $item['icon_text']; ?>
                                                                                    <?php endif; ?>
                                                                                </div>
                                                                            </li>
                                                                        <?php endforeach; ?>
                                                                    </ul>
                                                                <?php endif; ?>
                                                            </div>
                                                        <?php endforeach; ?>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                            <?php /*
                                            <div class="tab-content" id="tabs-<?php echo $_tab_counter . '-' . $key; ?>">
                                                <div class="tab-flex">
                                                    <?php if ( check_string( $tab['tab_title'] ) ) : ?>
                                                        <strong class="tab-content__title"><?php echo $tab['tab_title']; ?></strong>
                                                    <?php endif; ?>

                                                    <div class="tab-content__flex">
                                                        <?php if ( check_string( $tab['tab_image'] ) ) : ?>
                                                            <?php $_svg_url = get_template_directory_uri() . '/img/content/choices/' . $tab['tab_image']; ?>
                                                            <?php if ( file_get_contents( $_svg_url ) !== false ) : ?>
                                                                <div class="tab-content__image">
                                                                    <?php echo file_get_contents( $_svg_url ); ?>
                                                                </div>
                                                            <?php endif; ?>
                                                        <?php endif; ?>

                                                        <?php if ( check_string( $tab['tab_text'] ) ) : ?>
                                                            <div class="tab-content__text">
                                                                <?php echo $tab['tab_text']; ?>
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                            */ ?>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                <?php
                $section->content .= ob_get_clean();

            // SECTION - STATISTICS COUNTER
            elseif ( get_row_layout() == 'section_statistics' ) :
                array_push( $section->class, 'content-statistics' );
                array_push( $section->box_class, 'boxed' );

                // Content
                $section->e['heading'] = get_sub_field( 'section_heading' );
                $section->e['statistics'] = get_sub_field( 'section_columns' );

                ob_start();
                ?>

                    <?php
                        // Component: Heading
                        get_template_part( 'template-parts/component/component', 'heading', array(
                            'text' => $section->e['heading'],
                        ));
                    ?>

                    <?php if ( check_array( $section->e['statistics'] ) ) : ?>
                        <div class="section-statistics">
                            <div class="stat-boxes">
                                <?php foreach( $section->e['statistics'] as $key => $stat ) : ?>
                                    <?php $_unit = ( ( check_string( $stat['column_unit'] ) ) ? '<span>' . $stat['column_unit'] . '</span>' : '' ); ?>
                                    <div class="stat-box">
                                        <?php if ( check_string( $stat['column_title'] ) ) : ?>
                                            <strong class="stat-box__title">
                                                <?php echo $stat['column_title']; ?>
                                            </strong>
                                        <?php endif; ?>

                                        <div class="stat-box__value">
                                            <strong class="counter counter-whole"><?php echo $stat['column_value']; ?></strong><?php echo $_unit; ?>
                                        </div>

                                        <?php if ( check_string( $stat['column_text'] ) ) : ?>
                                            <div class="stat-box__text">
                                                <?php echo $stat['column_text']; ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                <?php
                $section->content .= ob_get_clean();

            // SECTION - CONTACT US FORM
            elseif ( get_row_layout() == 'section_contact' ) :
                array_push( $section->class, 'content-contact' );
                array_push( $section->box_class, 'boxed', 'narrow' );

                // Content
                $section->e['heading'] = get_sub_field( 'section_heading' );
                $section->e['content'] = get_sub_field( 'section_content' );

                ob_start();
                ?>

                    <?php
                        // Component: Heading
                        get_template_part( 'template-parts/component/component', 'heading', array(
                            'text' => $section->e['heading'],
                        ));
                    ?>

                    <?php
                        // Component: Content
                        get_template_part( 'template-parts/component/component', 'content', array(
                            'text' => $section->e['content'],
                        ));
                    ?>

                    <div class="section-form">
                        <?php echo do_shortcode('[gravityform id="1" title="false" description="false" ajax="true"]'); ?>
                    </div>

                <?php
                $section->content .= ob_get_clean();

            // SECTION - CONTACT INFO WITH MAP
            elseif ( get_row_layout() == 'section_contact_infomap' ) :
                array_push( $section->class, 'content-contact-infomap' );
                array_push( $section->box_class, 'boxed' );

                // Content
                $section->e['phone_label'] = get_sub_field( 'phone_label' );
                $section->e['sns_label'] = get_sub_field( 'sns_label' );
                $section->e['code'] = get_sub_field( 'section_code' );
                $section->e['address'] = get_field( 'contact_address', 'option' );
                $section->e['phone'] = get_field( 'contact_phone', 'option' );
                $section->e['linkedin'] = get_field( 'sns_linkedin', 'option' );
                $section->e['facebook'] = get_field( 'sns_facebook', 'option' );

                ob_start();
                ?>

                    <div class="infomap-cols">
                        <div class="infomap-col infomap-col__contact">
                            <div class="infomap-col__tel">
                                <div>
                                    <?php if ( check_string( $section->e['phone_label'] ) ) : ?>
                                        <strong class="infomap-col__title"><?php echo $section->e['phone_label']; ?></strong>
                                    <?php endif; ?>

                                    <?php if ( check_string( $section->e['phone'] ) ) : ?>
                                        <a href="<?php echo get_href( $section->e['phone'] ); ?>" class="infomap-col__phone" target="_blank"><?php echo $section->e['phone']; ?></a>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="infomap-col__social">
                                <div>
                                    <?php if ( check_string( $section->e['sns_label'] ) ) : ?>
                                        <strong class="infomap-col__title"><?php echo $section->e['sns_label']; ?></strong>
                                    <?php endif; ?>

                                    <?php if ( check_string( $section->e['linkedin'] ) || check_string( $section->e['facebook'] ) ) : ?>
                                        <ul>
                                            <?php if ( check_string( $section->e['linkedin'] ) ) : ?>
                                                <li>
                                                    <a href="<?php echo get_href( $section->e['linkedin'] ); ?>" class="icn li-icon" target="_blank">LinkedIn</a>
                                                </li>
                                            <?php endif; ?>

                                            <?php if ( check_string( $section->e['facebook'] ) ) : ?>
                                                <li>
                                                    <a href="<?php echo get_href( $section->e['facebook'] ); ?>" class="icn fb-icon" target="_blank">Facebook</a>
                                                </li>
                                            <?php endif; ?>
                                        </ul>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <div class="infomap-col infomap-col__address">
                            <?php if ( check_string( $section->e['address'] ) ) : ?>
                                <address><i class="icn icn-address"></i> <span><?php echo $section->e['address']; ?></span></address>
                            <?php endif; ?>

                            <?php if ( check_string( $section->e['code'] ) ) : ?>
                                <div class="map-container">
                                    <?php echo $section->e['code']; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                <?php
                $section->content .= ob_get_clean();

            // SECTION - NEWSLETTER SIGNUP FORM
            elseif ( get_row_layout() == 'section_newsletter_signup' ) :
                array_push( $section->class, 'content-newsletter-signup' );
                array_push( $section->box_class, 'boxed' );

                // Content
                $section->e['heading'] = get_sub_field( 'section_heading' );
                $section->e['content'] = get_sub_field( 'section_content' );

                ob_start();
                ?>
                    <div class="newsletter-cols">
                        <figure class="newsletter-col newsletter-col__image">
                            <img src="<?php echo get_template_directory_uri(); ?>/img/content/contact_img.svg" alt="">
                        </figure>

                        <div class="newsletter-col newsletter-col__content">
                            <div class="section-header">
                                <?php
                                    // Component: Heading
                                    get_template_part( 'template-parts/component/component', 'heading', array(
                                        'text' => $section->e['heading'],
                                    ));
                                ?>

                                <?php
                                    // Component: Content
                                    get_template_part( 'template-parts/component/component', 'content', array(
                                        'text' => $section->e['content'],
                                    ));
                                ?>
                            </div>

                            <div class="section-form">
                                <?php echo do_shortcode('[gravityform id="2" title="false" description="false" ajax="true"]'); ?>
                            </div>
                        </div>
                    </div>

                <?php
                $section->content .= ob_get_clean();

            // SECTION - PDF EMBED
            elseif ( get_row_layout() == 'section_pdf_embed' ) :
                array_push( $section->class, 'content-pdf-embed' );
                array_push( $section->box_class, 'boxed', 'narrow' );

                // Content
                $section->e['file'] = get_sub_field( 'section_file' );
                $section->e['button_text'] = get_sub_field( 'section_download_button' );

                ob_start();
                ?>

                    
                    <?php if ( check_string( $section->e['file'] ) ) : ?>
                        <div class="section-embed">
                            <?php echo do_shortcode( '[pdf-embedder url=\'' . $section->e['file'] . '\']' ); ?>
                        </div>

                        <?php if ( check_string( $section->e['button_text'] ) ) : ?>
                            <div class="section-buttons">
                                <a href="<?php echo $section->e['file']; ?>" class="btn" target="_blank"><?php echo $section->e['button_text']; ?></a>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>

                <?php
                $section->content .= ob_get_clean();

            // SECTION - ACCORDION
            elseif ( get_row_layout() == 'section_accordion' ) :
                array_push( $section->class, 'content-accordion' );
                array_push( $section->box_class, 'boxed' );

                // Content
                $section->e['heading'] = get_sub_field( 'section_heading' );
                $section->e['items'] = get_sub_field( 'section_columns' );

                ob_start();
                ?>

                    <?php
                        // Component: Heading
                        get_template_part( 'template-parts/component/component', 'heading', array(
                            'text' => $section->e['heading'],
                        ));
                    ?>

                    <?php if ( check_array( $section->e['items'] ) ) : ?>
                        <div class="section-accordion accordion-wrapper">
                            <?php foreach ( $section->e['items'] as $key => $item ) : ?>
                                <article class="accrdion-entry">
                                    <header class="accrdion-header">
                                        <?php echo $item['column_title']; ?>
                                    </header>

                                    <div class="accrdion-content">
                                        <?php echo $item['column_text']; ?>
                                    </div>
                                </article>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                <?php
                $section->content .= ob_get_clean();

            endif;

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
                    <?php echo $section->outer_content; ?>
                </div>

            <?php

            // Fix Tab ID for multiple instances of tabbed content
            $_tab_counter++;

        endif;

    endwhile;

else:

    ?>

        <div class="content-section content-none" hidden>
            <div class="boxed">
                &nbsp;
            </div>
        </div>

    <?php

endif;