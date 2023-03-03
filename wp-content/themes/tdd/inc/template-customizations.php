<?php
/**
 * Customizations which enhance the theme by hooking into WordPress
 *
 * @package custom
 */

/**
 * Change the login page logo
 */
function change_login_logo() { 
	if( get_field('theme_logo', 'option') ) {
	?> 
	<style type="text/css"> 
	body.login div#login h1 a {
		width: 46px;
		height: 46px;
		background-image: url(<?php echo get_field( 'theme_logo', 'option' ); ?>);
		background-attachment: scroll;
		background-repeat: no-repeat;
		background-position: center;
		background-size: contain;
	} 
	</style>
	<?php
	}
}
add_action( 'login_enqueue_scripts', 'change_login_logo' );


/**
 * Change the placeholder text for the title field of Custom Post Types
 * 
 * @param string $title String containing the default placeholder text
 * @return string
 */
function change_default_title( $title ){
    $screen = get_current_screen();

    // For Team Members
    if  ( 'team' == $screen->post_type ) {
        $title = 'Name';

    // For Testimonials
	} elseif ( 'testimonial' == $screen->post_type ) {
		$title = 'Name';

	}

    return $title;
}
add_filter( 'enter_title_here', 'change_default_title' );


/**
 * Remove the private and protected text from the title
 * 
 * @param string $title String containing the title
 * @return string
 */
function the_title_trim( $title ) {

	$title = attribute_escape( $title );

	$findthese = array(
		'#Protected:#',
		'#Private:#'
	);

	$replacewith = array(
		'',
		''
	);

	$title = preg_replace( $findthese, $replacewith, $title );

	return $title;
}
add_filter( 'the_title', 'the_title_trim' );


/**
 * Extract the first paragraph from a string
 * 
 * @param string $target_string String where the paragraph will be extracted
 * @return string Returns the original string if there is no </p> tag found
 */
function extract_first_paragraph( $target_string = '' ) {
	if ( $target_string !== '' ) {
		$_start = 0;
		$_end = strpos( $target_string, '</p>', $_start );

		return ( $_end === false ) ? $target_string : substr( $target_string, 0, $_end-$_start+4 );
	}
}


/**
 * Enclose the paragraph in quotes
 * 
 * @param string $target_string Target paragrah
 * @return string 
 */
function enclose_paragraph( $target_string = '' ) {
	return str_replace( '</p>', '&rdquo;</p>', str_replace('<p>', '<p>&ldquo;', $target_string) );
}


/**
 * Display the fieldname as a class if the field's value is true
 * 
 * @param int $target_pageid The page ID
 * @param string $field_name The Advanced Custom Field name
 * @param boolean $add_class_attribute Whether to enlose the class name with the class attribute
 * @return string
 */
function display_field_class( $target_pageid, $field_name = '', $add_space = false, $add_class_attribute = false ) {
	$field_class = '';

	if ( $target_pageid && $field_name !== '' ) {
		if ( $add_space ) {
			$field_class .= ' ';
		}

		//$field_class .= str_replace( '_' , '-', get_field( $field_name, $target_pageid ) );

		if ( $add_class_attribute ) {
			$field_class = ' class="' . $field_class . '"';
		}
	}

	return $field_class;
}


/**
 * Better display_template() function that accepts variables
 * 
 * Usage: 
 * 
 *   display_template('header-promotion', ['message' => 'Example message']);
 *   display_template( '/template-parts/content-sidebar', ['target_id' => get_queried_object_id()] );
 * 
 * @param string $template_name The template name
 * @param array $data Array of data to be passed on to the template
 * @return null
 */

function display_template( $template_name, $data = [] ) {
    $template = locate_template($template_name . '.php', false);

    if (!$template) {
        return;
    }

    if ($data) {
        extract($data);
    }

    include($template);
}


/**
 * Check if array is valid
 * 
 * @param array $arr Target array
 * @return boolean
 */
function check_array( $arr ) {
	return ( is_array($arr) && count($arr) > 0 );
}


/**
 * Check if string is set and not empty
 * 
 * @param string $str Target array
 * @return boolean
 */
function check_string( $str ) {
	return ( isset($str) && $str != '' );
}


/**
 * Check if variable is set and provide the href clause
 * 
 * @param array $lnk Target variable
 * @return string
 */
function check_link( $lnk ) {
	return ( ( $lnk ) ? ' href="' . $lnk . '"' : '' );
}


/**
 * Get the thumbnail URL. Also allows setting a default thumbnail
 * 
 * @param int $post_id Page, post or custom post type ID
 * @param string $image_size Custom image size
 * @param string $alt_text Alternate text
 * @param int $alter_id (optional) Default media ID
 * @return string
 */
function get_default_thumbnail( $post_id = 0, $image_size = 'full', $alt_text = '', $alter_id = false ) {
	$_url = '';

	if ( $post_id > 0 ) {
		if ( has_post_thumbnail( $post_id ) ) {
			$_url = get_the_post_thumbnail_url( $post_id, $image_size );
		} else {
			if ( $alter_id ) {
				$_get_thumb_url = wp_get_attachment_image_src( $alter_id, $image_size );
				$_url = ( ( check_array($_get_thumb_url) ) ? $_get_thumb_url[0] : '' );
			}
		}
	}

	return ( ( $_url !== '' ) ? '<img src="' . $_url . '" alt="' . $alt_text . '">' : '' );
}


/**
 * Substitute [YEAR] with the current year
 * 
 * @param string $full_string Target string containing the placeholder text
 * @return string
 */
function get_year( $full_string = '' ) {
	if ( $full_string == '' ) {
		return;
	}

	return str_ireplace( '[YEAR]', strftime('%Y'), $full_string );
}


/**
 * Get the href link for the passed string
 * 
 * @param string $target_string String to convert
 * @param string $target_protocol Type of link
 * @return string
 */
function get_href( $target_string = '', $target_protocol = 'tel' ) {
	if ( check_string( $target_string ) ) {
		switch ( $target_protocol ) {
			// Telephone Number
			case 'tel':
				$target_string = 'tel:' . str_replace( 
					array(
						'+',
						'-',
						'.',
						'(',
						')',
						' '
					),
					array(
						'',
						'',
						'',
						'',
						'',
						''
					),
					$target_string
				);
				break;
			
			// Email Address
			case 'email':
				$target_string = 'mailto:' . $target_string;
				break;

		}

		return $target_string;
	}
}


/**
 * Get the taxonomy of the post type id entered
 * 
 * @param string $target_id Post type ID
 * @param string $target_taxonomy Post type taxonomy
 * @param string $single Return the first row only
 * @return array
 */
function get_tax( $target_id = 0, $target_taxonomy = 'category', $single = true ) {
	$tax_arr = array();

	if ( $target_id > 0 ) {
		$_terms = get_the_terms( $target_id, $target_taxonomy );

		if ( check_array($_terms) ) {
			foreach ( $_terms as $_term ) {
				$tax_arr[] = array(
					'id' => $_terms[0]->term_id,
					'name' => $_terms[0]->name,
					'slug' => $_terms[0]->slug,
				);

				if ( $single ) {
					break;
				}
			}
		}
	}

	return $tax_arr;
}


/**
 * Get the attachment alt
 * 
 * @param int $attachment_id Attachment ID
 * @return string
 */
function get_attachment_alt( $attachment_id = 0 ) {
	$alt = '';

	if ( $attachment_id > 0 ) {
        	$image_alt = get_post_meta( $attachment_id, '_wp_attachment_image_alt', true );
        	if ( check_string( $image_alt ) ) {
            		$alt = $image_alt;
        	}
	}

	return $alt;
}


/**
 * Create an excerpt
 * 
 * @param string $target_string Haystack
 * @param string $char_length Character Length
 * @param string $read_more Read More text
 * @return string
 */
function generate_excerpt( $target_string = '', $char_length = 120, $read_more = '&hellip;' ) {
	$_excerpt = $target_string;

	if ( strlen( $target_string ) > 0 ) {
		$_excerpt = strip_shortcodes( $target_string );
		$_excerpt = excerpt_remove_blocks( $_excerpt );
		$_excerpt = strip_tags( $_excerpt );

		$_excerpt = substr( $_excerpt, 0, $char_length ) . $read_more;
	}

	return $_excerpt;
}
