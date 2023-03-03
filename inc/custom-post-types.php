<?php

function build_custom_post_types() {

	/*----------------- TEAM MEMBERS -------------------*/

	// UI Labels
	$team_labels = array(
		'name'                => _x( 'Team Member', 'Post Type General Name', 'tdd' ),
		'singular_name'       => _x( 'Team Member', 'Post Type Singular Name', 'tdd' ),
		'menu_name'           => __( 'Team Members', 'tdd' ),
		'parent_item_colon'   => __( 'Parent Team Member', 'tdd' ),
		'all_items'           => __( 'All Team Members', 'tdd' ),
		'view_item'           => __( 'View Team Member', 'tdd' ),
		'add_new_item'        => __( 'Add New Team Member', 'tdd' ),
		'add_new'             => __( 'Add New', 'tdd' ),
		'edit_item'           => __( 'Edit Team Member', 'tdd' ),
		'update_item'         => __( 'Update Team Member', 'tdd' ),
		'search_items'        => __( 'Search Team Members', 'tdd' ),
		'not_found'           => __( 'Not Found', 'tdd' ),
		'not_found_in_trash'  => __( 'Not found in Trash', 'tdd' ),
	);
		
	// Configuration Options
	$team_args = array(
		'label'               => __( 'Team Members', 'tdd' ),
		'description'         => __( '', 'tdd' ),
		'labels'              => $team_labels,
		'supports'            => array( 'title', 'revisions' ),
		'taxonomies'          => array(),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 10,
		'can_export'          => true,
		'has_archive'         => false,
		'exclude_from_search' => false,
		'publicly_queryable'  => false,
		'capability_type'     => 'post',
		'show_in_rest'        => true,
	);

	// Register the Custom Post Types
	register_post_type( 'team', $team_args );

	/*----------------- TESTIMONIALS -------------------*/

	// UI Labels
	$testimonial_labels = array(
		'name'                => _x( 'Testimonial', 'Post Type General Name', 'tdd' ),
		'singular_name'       => _x( 'Testimonial', 'Post Type Singular Name', 'tdd' ),
		'menu_name'           => __( 'Testimonials', 'tdd' ),
		'parent_item_colon'   => __( 'Parent Testimonial', 'tdd' ),
		'all_items'           => __( 'All Testimonials', 'tdd' ),
		'view_item'           => __( 'View Testimonial', 'tdd' ),
		'add_new_item'        => __( 'Add New Testimonial', 'tdd' ),
		'add_new'             => __( 'Add New', 'tdd' ),
		'edit_item'           => __( 'Edit Testimonial', 'tdd' ),
		'update_item'         => __( 'Update Testimonial', 'tdd' ),
		'search_items'        => __( 'Search Testimonials', 'tdd' ),
		'not_found'           => __( 'Not Found', 'tdd' ),
		'not_found_in_trash'  => __( 'Not found in Trash', 'tdd' ),
	);
		
	// Configuration Options
	$testimonial_args = array(
		'label'               => __( 'Testimonials', 'tdd' ),
		'description'         => __( '', 'tdd' ),
		'labels'              => $testimonial_labels,
		'supports'            => array( 'title', 'revisions' ),
		'taxonomies'          => array(),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 10,
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'post',
		'show_in_rest'        => true,
	);

	// Register the Custom Post Types
	// register_post_type( 'testimonial', $testimonial_args );

	/*----------------- PRESS RELEASES -------------------*/

	// UI Labels
	$press_labels = array(
		'name'                => _x( 'Press Releases', 'Post Type General Name', 'tdd' ),
		'singular_name'       => _x( 'Press Release', 'Post Type Singular Name', 'tdd' ),
		'menu_name'           => __( 'Press Releases', 'tdd' ),
		'parent_item_colon'   => __( 'Parent Press Release', 'tdd' ),
		'all_items'           => __( 'All Press Releases', 'tdd' ),
		'view_item'           => __( 'View Press Release', 'tdd' ),
		'add_new_item'        => __( 'Add New Press Release', 'tdd' ),
		'add_new'             => __( 'Add New', 'tdd' ),
		'edit_item'           => __( 'Edit Press Release', 'tdd' ),
		'update_item'         => __( 'Update Press Release', 'tdd' ),
		'search_items'        => __( 'Search Press Releases', 'tdd' ),
		'not_found'           => __( 'Not Found', 'tdd' ),
		'not_found_in_trash'  => __( 'Not found in Trash', 'tdd' ),
	);
		
	// Configuration Options
	$press_args = array(
		'label'               => __( 'Press Releases', 'tdd' ),
		'description'         => __( '', 'tdd' ),
		'labels'              => $press_labels,
		'supports'            => array( 'title', 'revisions' ),
		'taxonomies'          => array(),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 11,
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'post',
		'show_in_rest'        => true,
	);

	// Register the Custom Post Types
	// register_post_type( 'press', $press_args );

	// Add Taxonomy
	$type_labels = array(
		'name'              => _x( 'Types', 'Taxonomy General Name', 'tdd' ),
		'singular_name'     => _x( 'Type', 'Taxonomy Singular Name', 'tdd' ),
		'search_items'      => __( 'Search Types', 'tdd' ),
		'all_items'         => __( 'All Type', 'tdd' ),
		'parent_item'       => __( 'Parent Type', 'tdd' ),
		'parent_item_colon' => __( 'Parent Type:', 'tdd' ),
		'edit_item'         => __( 'Edit Type', 'tdd' ), 
		'update_item'       => __( 'Update Type', 'tdd' ),
		'add_new_item'      => __( 'Add New Type', 'tdd' ),
		'new_item_name'     => __( 'New Type', 'tdd' ),
		'menu_name'         => __( 'Types', 'tdd' ),
	);

	// Configuration Options Taxonomy
	$type_args = array(
		'labels' => $type_labels,
		'hierarchical' => true,
		'show_admin_column' => true,
	);

	// Register the Taxonomy
	// register_taxonomy( 'type', 'webinar-guide', $type_args );

	/*----------------- CASE STUDIES-------------------*/

	// UI Labels
	$case_labels = array(
		'name'                => _x( 'Case Studies', 'Post Type General Name', 'tdd' ),
		'singular_name'       => _x( 'Case Study', 'Post Type Singular Name', 'tdd' ),
		'menu_name'           => __( 'Case Studies', 'tdd' ),
		'parent_item_colon'   => __( 'Parent Case Study', 'tdd' ),
		'all_items'           => __( 'All Case Studies', 'tdd' ),
		'view_item'           => __( 'View Case Study', 'tdd' ),
		'add_new_item'        => __( 'Add New Case Study', 'tdd' ),
		'add_new'             => __( 'Add New', 'tdd' ),
		'edit_item'           => __( 'Edit Case Study', 'tdd' ),
		'update_item'         => __( 'Update Case Study', 'tdd' ),
		'search_items'        => __( 'Search Case Studies', 'tdd' ),
		'not_found'           => __( 'Not Found', 'tdd' ),
		'not_found_in_trash'  => __( 'Not found in Trash', 'tdd' ),
	);
		
	// Configuration Options
	$case_args = array(
		'label'               => __( 'Case Studies', 'tdd' ),
		'description'         => __( '', 'tdd' ),
		'labels'              => $case_labels,
		'supports'            => array( 'title', 'revisions' ),
		'taxonomies'          => array(),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 12,
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'post',
		'show_in_rest'        => true,
	);

	// Register the Custom Post Types
	// register_post_type( 'case', $case_args );

}
add_action( 'init', 'build_custom_post_types', 0 );