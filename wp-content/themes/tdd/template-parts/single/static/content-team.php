<?php
/**
 * @package tdd
 */

// Current career id
$_obj_id = ( isset( $args['target_id'] ) && !empty( $args['target_id'] ) ) ? $args['target_id'] : get_queried_object_id() ;

$team = array(
    'id'            => $_obj_id,
    'title'         => get_the_title( $_obj_id ),
    'url'           => get_the_permalink( $_obj_id ),
    'image'         => get_field( 'team_photo', $_obj_id ),
    'position'      => get_field( 'team_position', $_obj_id ),
    'linkedin'      => get_field( 'team_linkedin', $_obj_id ),
    'text'          => get_field( 'team_text', $_obj_id ),
    'qa'            => get_field( 'team_qa_items', $_obj_id ),
);

$strings = array(
    'btn_prev'      => 'Location',
    'btn_next'      => 'Department',
);
?>

    <div class="content-section content-team-single">
        <div class="boxed">
            <div class="two-cols">
                <?php if ( check_string( $team['image'] ) ) : ?>
                    <figure class="two-col two-col__image">
                        <img class="clip-large-mask" src="<?php echo wp_get_attachment_image_src( $team['image'], 'team-large' )[0]; ?>" alt="">
                    </figure>
                <?php endif; ?>

                <div class="two-col two-col__content">
                    <div class="two-col__inner">
                        <?php
                            // Component: Heading
                            get_template_part( 'template-parts/component/component', 'heading', array(
                                'text'      => $team['title'],
                                'element'   => 'h1',
                            ));
                        ?>

                        <?php if ( check_string( $team['position'] ) ) : ?>
                            <div class="two-col__position">
                                <?php echo $team['position']; ?>
                            </div>
                        <?php endif; ?>

                        <?php if ( check_string( $team['linkedin'] ) ) : ?>
                            <div class="two-col__sns">
                                <span class="two-col__spanleft"></span>
                                <a href="<?php echo $team['linkedin']; ?>" class="icn li-icon" target="_blank">LinkedIn</a>
                                <span class="two-col__spanright"></span>
                            </div>
                        <?php endif; ?>

                        <?php if ( check_string( $team['text'] ) ) : ?>
                            <div class="section-content">
                                <?php echo $team['text']; ?>
                            </div>
                        <?php endif; ?>

                        <div class="two-col__navigation">
                            <div class="prev-post-nav"><?php previous_post_link( '%link', 'Previous' ) ?></div>
                            <div class="next-post-nav"><?php next_post_link( '%link', 'Next' ) ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php if ( check_array( $team['qa'] ) ) : ?>
        <div class="content-team-qa">
            <div class="boxed">
                <ul class="qa-list">
                    <?php foreach ( $team['qa'] as $key => $qa ) : ?>
                        <li class="qa-item">
                            <strong class="qa-item__question"><?php echo $qa['qa_question']; ?></strong>
                            <div>
                                <?php echo $qa['qa_answer']; ?>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
    <?php endif; ?>

<?php