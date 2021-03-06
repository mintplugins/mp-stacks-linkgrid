<?php 
/**
 * This file contains the function which set up the Descriptions in the Grid
 *
 * To use this for additional Text Overlays in a grid, duplicate this file 
 * 1. Find and replace "linkgrid" with your plugin's prefix
 * 2. Find and replace "description" with your desired text overlay name
 * 3. Make custom changes to the mp_stacks_linkgrid_description function about what is displayed.
 *
 * @since 1.0.0
 *
 * @package    MP Stacks LinkGrid
 * @subpackage Functions
 *
 * @copyright  Copyright (c) 2016, Mint Plugins
 * @license    http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @author     Philip Johnston
 */

/**
 * Add the meta options for the Grid Descriptions to the LinkGrid Metabox
 *
 * @access   public
 * @since    1.0.0
 * @param    Void
 * @param    $items_array Array - The existing Meta Options in this Array
 * @return   Array - All of the placement optons needed for Description
 */
function mp_stacks_linkgrid_description_meta_options( $items_array ){		
	
	//Description Settings
	$new_fields = array(
		//Description
		'linkgrid_description_showhider' => array(
			'field_id'			=> 'linkgrid_description_settings',
			'field_title' 	=> __( 'Description Settings', 'mp_stacks_linkgrid'),
			'field_description' 	=> __( '', 'mp_stacks_linkgrid' ),
			'field_type' 	=> 'showhider',
			'field_value' => '',
			'field_showhider' => 'linkgrid_design_showhider',
		),
		'linkgrid_description_show' => array(
			'field_id'			=> 'linkgrid_description_show',
			'field_title' 	=> __( 'Show Descriptions?', 'mp_stacks_linkgrid'),
			'field_description' 	=> __( 'Do you want to show the Descriptions for these posts?', 'mp_stacks_linkgrid' ),
			'field_type' 	=> 'checkbox',
			'field_value' => 'linkgrid_description_show',
			'field_showhider' => 'linkgrid_description_settings',
		),
		'linkgrid_description_placement' => array(
			'field_id'			=> 'linkgrid_description_placement',
			'field_title' 	=> __( 'Description Placement', 'mp_stacks_linkgrid'),
			'field_description' 	=> __( 'Where would you like to place the description? Default: Below Image, Left', 'mp_stacks_linkgrid' ),
			'field_type' 	=> 'select',
			'field_value' => '',
			'field_select_values' => mp_stacks_get_text_position_options(),
			'field_showhider' => 'linkgrid_description_settings',
		),
		'linkgrid_description_color' => array(
			'field_id'			=> 'linkgrid_description_color',
			'field_title' 	=> __( 'Description Color', 'mp_stacks_linkgrid'),
			'field_description' 	=> __( 'Select the color the descriptions will be (leave blank for theme default)', 'mp_stacks_linkgrid' ),
			'field_type' 	=> 'colorpicker',
			'field_value' => '',
			'field_showhider' => 'linkgrid_description_settings',
		),
		'linkgrid_description_size' => array(
			'field_id'			=> 'linkgrid_description_size',
			'field_title' 	=> __( 'Description Size', 'mp_stacks_linkgrid'),
			'field_description' 	=> __( 'Enter the text size the descriptions will be. Default: 15', 'mp_stacks_linkgrid' ),
			'field_type' 	=> 'number',
			'field_value' => '15',
			'field_showhider' => 'linkgrid_description_settings',
		),
		'linkgrid_description_lineheight' => array(
			'field_id'			=> 'linkgrid_description_lineheight',
			'field_title' 	=> __( 'Description Line Height', 'mp_stacks_linkgrid'),
			'field_description' 	=> __( 'Enter the line height for the description text. Default: 19', 'mp_stacks_linkgrid' ),
			'field_type' 	=> 'number',
			'field_value' => '19',
			'field_showhider' => 'linkgrid_description_settings',
		),
		
		'linkgrid_description_google_font' => array(
			'field_id'			=> 'linkgrid_description_google_font',
			'field_title' 	=> __( 'Google Font Name', 'mp_stacks'),
			'field_description' 	=> 'Enter the name of the Google Font to use for this Text <br /><a class="button" href="https://www.google.com/fonts" target="_blank">Browse Google Fonts<div  style="margin-top: 3.3px; margin-left: 5px;" class="dashicons dashicons-share-alt2"></div></a>',
			'field_type' 	=> 'textbox',
			'field_value' => '',
			'field_placeholder' => __( 'Google Font Name', 'mp_stacks_googlefonts' ),
			'field_showhider' => 'linkgrid_description_settings',
		),
		'linkgrid_description_google_font_weight_style' => array(
			'field_id'			=> 'linkgrid_description_google_font_weight_style',
			'field_title' 	=> __( 'Font Weight/Style', 'mp_stacks'),
			'field_description' 	=> 'Set the weight of this font (If available for your chosen font)',
			'field_type' 	=> 'select',
			'field_select_values' => array( 
				'100' => 'Thin', 
				'200' => 'Extra-Light', 
				'300' => 'Light', 
				'400' => 'Normal', 
				'500' => 'Medium', 
				'600' => 'Semi-Bold', 
				'700' => 'Bold',
				'900' => 'Ultra-Bold', 
			),
			'field_value' => '',
			'field_showhider' => 'linkgrid_description_settings',
		),
		
		'linkgrid_description_spacing' => array(
			'field_id'			=> 'linkgrid_description_spacing',
			'field_title' 	=> __( 'Descriptions\' Spacing', 'mp_stacks_linkgrid'),
			'field_description' 	=> __( 'How much space should there be between the description anything directly above it? Default: 10', 'mp_stacks_linkgrid' ),
			'field_type' 	=> 'number',
			'field_value' => '10',
			'field_showhider' => 'linkgrid_description_settings',
		),
		'linkgrid_description_word_limit' => array(
			'field_id'			=> 'linkgrid_description_word_limit',
			'field_title' 	=> __( 'Word Limit for Description', 'mp_stacks_linkgrid'),
			'field_description' 	=> __( 'How many words should be displayed before the "Read More" link is shown. Default: All words are shown.', 'mp_stacks_linkgrid' ),
			'field_type' 	=> 'number',
			'field_value' => '',
			'field_showhider' => 'linkgrid_description_settings',
		),
		//Description animation stuff
		'linkgrid_description_animation_desc' => array(
			'field_id'			=> 'linkgrid_description_animation_description',
			'field_title' 	=> __( 'Animate the Description upon Mouse-Over', 'mp_stacks_linkgrid'),
			'field_description' 	=> __( 'Add keyframe animations to apply to the description and play upon mouse-over.', 'mp_stacks_linkgrid' ),
			'field_type' 	=> 'basictext',
			'field_value' => '',
			'field_showhider' => 'linkgrid_description_settings',
		),
		'linkgrid_description_animation_repeater_title' => array(
			'field_id'			=> 'linkgrid_description_animation_repeater_title',
			'field_title' 	=> __( 'KeyFrame', 'mp_stacks_linkgrid'),
			'field_description' 	=> NULL,
			'field_type' 	=> 'repeatertitle',
			'field_repeater' => 'linkgrid_description_animation_keyframes',
			'field_showhider' => 'linkgrid_description_settings',
		),
		'linkgrid_description_animation_length' => array(
			'field_id'			=> 'animation_length',
			'field_title' 	=> __( 'Animation Length', 'mp_stacks_linkgrid'),
			'field_description' 	=> __( 'Set the length between this keyframe and the previous one in milliseconds. Default: 500', 'mp_stacks_linkgrid' ),
			'field_type' 	=> 'number',
			'field_value' => '500',
			'field_repeater' => 'linkgrid_description_animation_keyframes',
			'field_showhider' => 'linkgrid_description_settings',
			'field_container_class' => 'mp_animation_length',
		),
		'linkgrid_description_animation_opacity' => array(
			'field_id'			=> 'opacity',
			'field_title' 	=> __( 'Opacity', 'mp_stacks_linkgrid'),
			'field_description' 	=> __( 'Set the opacity percentage at this keyframe. Default: 100', 'mp_stacks_linkgrid' ),
			'field_type' 	=> 'input_range',
			'field_value' => '100',
			'field_repeater' => 'linkgrid_description_animation_keyframes',
			'field_showhider' => 'linkgrid_description_settings',
		),
		'linkgrid_description_animation_rotation' => array(
			'field_id'			=> 'rotateZ',
			'field_title' 	=> __( 'Rotation', 'mp_stacks_linkgrid'),
			'field_description' 	=> __( 'Set the rotation degree angle at this keyframe. Default: 0', 'mp_stacks_linkgrid' ),
			'field_type' 	=> 'number',
			'field_value' => '0',
			'field_repeater' => 'linkgrid_description_animation_keyframes',
			'field_showhider' => 'linkgrid_description_settings',
		),
		'linkgrid_description_animation_x' => array(
			'field_id'			=> 'translateX',
			'field_title' 	=> __( 'X Position', 'mp_stacks_linkgrid'),
			'field_description' 	=> __( 'Set the X position, in relation to its starting position, at this keyframe. The unit is pixels. Default: 0', 'mp_stacks_linkgrid' ),
			'field_type' 	=> 'number',
			'field_value' => '0',
			'field_repeater' => 'linkgrid_description_animation_keyframes',
			'field_showhider' => 'linkgrid_description_settings',
		),
		'linkgrid_description_animation_y' => array(
			'field_id'			=> 'translateY',
			'field_title' 	=> __( 'Y Position', 'mp_stacks_linkgrid'),
			'field_description' 	=> __( 'Set the Y position, in relation to its starting position, at this keyframe. The unit is pixels. Default: 0', 'mp_stacks_linkgrid' ),
			'field_type' 	=> 'number',
			'field_value' => '0',
			'field_repeater' => 'linkgrid_description_animation_keyframes',
			'field_showhider' => 'linkgrid_description_settings',
		),
		//Description Background
		'linkgrid_description_bg_showhider' => array(
			'field_id'			=> 'linkgrid_description_background_settings',
			'field_title' 	=> __( 'Description Background Settings', 'mp_stacks_linkgrid'),
			'field_description' 	=> __( '', 'mp_stacks_linkgrid' ),
			'field_type' 	=> 'showhider',
			'field_value' => '',
			'field_showhider' => 'linkgrid_design_showhider',
		),
		'linkgrid_description_bg_show' => array(
			'field_id'			=> 'linkgrid_description_background_show',
			'field_title' 	=> __( 'Show Description Backgrounds?', 'mp_stacks_linkgrid'),
			'field_description' 	=> __( 'Do you want to show a background color behind the description?', 'mp_stacks_linkgrid' ),
			'field_type' 	=> 'checkbox',
			'field_value' => '',
			'field_showhider' => 'linkgrid_description_background_settings',
		),
		'linkgrid_description_bg_size' => array(
			'field_id'			=> 'linkgrid_description_background_padding',
			'field_title' 	=> __( 'Description Background Size', 'mp_stacks_linkgrid'),
			'field_description' 	=> __( 'How many pixels bigger should the Description Background be than the Text? Default: 5', 'mp_stacks_linkgrid' ),
			'field_type' 	=> 'number',
			'field_value' => '5',
			'field_showhider' => 'linkgrid_description_background_settings',
		),
		'linkgrid_description_bg_color' => array(
			'field_id'			=> 'linkgrid_description_background_color',
			'field_title' 	=> __( 'Description Background Color', 'mp_stacks_linkgrid'),
			'field_description' 	=> __( 'What color should the description background be? Default: #FFF (White)', 'mp_stacks_linkgrid' ),
			'field_type' 	=> 'colorpicker',
			'field_value' => '#FFF',
			'field_showhider' => 'linkgrid_description_background_settings',
		),
		'linkgrid_description_bg_opacity' => array(
			'field_id'			=> 'linkgrid_description_background_opacity',
			'field_title' 	=> __( 'Description Background Opacity', 'mp_stacks_linkgrid'),
			'field_description' 	=> __( 'Set the opacity percentage? Default: 100', 'mp_stacks_linkgrid' ),
			'field_type' 	=> 'input_range',
			'field_value' => '100',
			'field_showhider' => 'linkgrid_description_background_settings',
		),

	);
	
	return mp_core_insert_meta_fields( $items_array, $new_fields, 'linkgrid_meta_hook_anchor_2' );

}
add_filter( 'mp_stacks_linkgrid_items_array', 'mp_stacks_linkgrid_description_meta_options', 90 );

/**
 * Add the placement options for the Description using placement options filter hook
 *
 * @access   public
 * @since    1.0.0
 * @param    Void
 * @param    $post_id Int - The ID of the Brick
 * @return   Array - All of the placement optons needed for Description
 */
function mp_stacks_linkgrid_description_placement_options( $placement_options, $post_id ){
	
	//Show Post Descriptions
	$placement_options['description_show'] = mp_core_get_post_meta($post_id, 'linkgrid_description_show');

	//Descriptions Placement
	$placement_options['description_placement'] = mp_core_get_post_meta($post_id, 'linkgrid_description_placement', 'below_image_left');
	
	//get word limit for exceprts
	$placement_options['word_limit'] = mp_core_get_post_meta($post_id, 'linkgrid_description_word_limit', 20);
	
	return $placement_options;	
}
add_filter( 'mp_stacks_linkgrid_placement_options', 'mp_stacks_linkgrid_description_placement_options', 10, 2 );

/**
 * Get the HTML for the description in the grid
 *
 * @access   public
 * @since    1.0.0
 * @param    $post_id Int - The ID of the post to get the description of
 * @param    $word_limit Int - The total number of words to include in the description
 * @return   $html_output String - A string holding the html for an description in the grid
 */
function mp_stacks_linkgrid_description( $link, $word_limit ){
	
	$the_description = $link['linkgrid_link_description'];
	
	//Check word limit for description				
	if (!empty($word_limit)){							
		//Cut the description off at X number of words
		$the_description = mp_core_limit_text_to_words($the_description, $word_limit);
	}
	
	//If there are 0 words in this description
	if (mp_core_word_count($the_description) == 0 ){
		return NULL;	
	}
	else{
		
		$output_string = strip_tags($the_description);
		
	}
	
	$linkgrid_output = mp_stacks_grid_highlight_text_html( array( 
		'class_name' => 'mp-stacks-linkgrid-item-description',
		'output_string' => $output_string, 
	) );
	
	return $linkgrid_output;	

	
}

/**
 * Hook the Description to the "Top" and "Over" position in the grid
 *
 * @access   public
 * @since    1.0.0
 * @param    $post_id Int - The ID of the post
 * @return   $html_output String - A string holding the html for text over a featured image in the grid
 */
function mp_stacks_linkgrid_description_top_over_callback( $linkgrid_output, $link, $options ){
	
	//If we should show the description over the image
	if ( strpos( $options['description_placement'], 'over') !== false && strpos( $options['description_placement'], 'top') !== false && $options['description_show']){
		
		return $linkgrid_output . mp_stacks_linkgrid_description( $link, $options['word_limit'] );

	}
	
	return $linkgrid_output;
	
}
add_filter( 'mp_stacks_linkgrid_top_over', 'mp_stacks_linkgrid_description_top_over_callback', 15, 3 );

/**
 * Hook the Description to the "Middle" and "Over" position in the grid
 *
 * @access   public
 * @since    1.0.0
 * @param    $post_id Int - The ID of the post
 * @return   $html_output String - A string holding the html for text over a featured image in the grid
 */
function mp_stacks_linkgrid_description_middle_over_callback( $linkgrid_output, $link, $options ){
	
	//If we should show the description over the image
	if ( strpos( $options['description_placement'], 'over') !== false && strpos( $options['description_placement'], 'middle') !== false && $options['description_show']){
		
		return $linkgrid_output . mp_stacks_linkgrid_description( $link, $options['word_limit'] );

	}
	
	return $linkgrid_output;
}
add_filter( 'mp_stacks_linkgrid_middle_over', 'mp_stacks_linkgrid_description_middle_over_callback', 15, 3 );

/**
 * Hook the Description to the "Bottom" and "Over" position in the grid
 *
 * @access   public
 * @since    1.0.0
 * @param    $link Int - The ID of the post
 * @return   $html_output String - A string holding the html for text over a featured image in the grid
 */
function mp_stacks_linkgrid_description_bottom_over_callback( $linkgrid_output, $link, $options ){
	
	//If we should show the description over the image
	if ( strpos( $options['description_placement'], 'over') !== false && strpos( $options['description_placement'], 'bottom') !== false && $options['description_show']){
		
		return $linkgrid_output . mp_stacks_linkgrid_description( $link, $options['word_limit'] );

	}
	
	return $linkgrid_output;
	
}
add_filter( 'mp_stacks_linkgrid_bottom_over', 'mp_stacks_linkgrid_description_bottom_over_callback', 15, 3 );

/**
 * Hook the Description to the "Below" position in the grid
 *
 * @access   public
 * @since    1.0.0
 * @param    $link Int - The ID of the post
 * @return   $html_output String - A string holding the html for text over a featured image in the grid
 */
function mp_stacks_linkgrid_description_below_over_callback( $linkgrid_output, $link, $options ){
	
	//If we should show the description below the image
	if ( strpos( $options['description_placement'], 'below') !== false && $options['description_show']){
		
		//Defaults 
		$target = ' target="" ';	
		$lightbox_class = NULL;
		$description_html_output = NULL;
			
		//Get this links open-type
		if ( $link['linkgrid_link_open_type'] == '_blank' || $link['linkgrid_link_open_type'] == '_parent' ){
			$target = ' target="' . $link['linkgrid_link_open_type'] . '" ';	
			$lightbox_class = NULL;	
		}
		elseif( $link['linkgrid_link_open_type'] == 'lightbox' ){
			$target = NULL;
			$lightbox_class = 'mp-stacks-lightbox-link';	
		}
		
		if ( !empty( $link['linkgrid_link_url'] ) ){				
			$description_html_output .= '<a href="' . $link['linkgrid_link_url'] . '" class="mp-stacks-linkgrid-description-link mp-stacks-grid-image-link ' . $lightbox_class . '" ' . $target . '" title="' . htmlspecialchars( strip_tags( $link['linkgrid_link_title'] ) ) . '"  alt="' . htmlspecialchars( strip_tags( $link['linkgrid_link_title'] ) ) . '">';
		}
		else{
			$description_html_output .= '<div class="mp-stacks-linkgrid-description-no-link mp-stacks-grid-image-link ' . $lightbox_class . '" ' . $target . '" title="' . htmlspecialchars( strip_tags( $link['linkgrid_link_title'] ) ) . '"  alt="' . htmlspecialchars( strip_tags( $link['linkgrid_link_title'] ) ) . '">';
		}
		
			$description_html_output .= mp_stacks_linkgrid_description( $link, $options['word_limit'] );
		
		if ( !empty( $link['linkgrid_link_url'] ) ){
			$description_html_output .= '</a>';
		}
		else{
			$description_html_output .= '</div>';
		}	
		
		return $linkgrid_output . $description_html_output;
	}
	
	return $linkgrid_output;
	
}
add_filter( 'mp_stacks_linkgrid_below', 'mp_stacks_linkgrid_description_below_over_callback', 15, 3 );

/**
 * Add the JS for the title to PostGrid's HTML output
 *
 * @access   public
 * @since    1.0.0
 * @param    $existing_filter_output String - Any output already returned to this filter previously
 * @param    $post_id String - the ID of the Brick where all the meta is saved.
 * @param    $meta_prefix String - the prefix to put before each meta_field key to differentiate it from other plugins. :EG "linkgrid"
 * @return   $new_grid_output - the existing grid output with additional thigns added by this function.
 */
function mp_stacks_linkgrid_description_animation_js( $existing_filter_output, $post_id, $meta_prefix ){
	
	if ( $meta_prefix != 'linkgrid' ){
		return $existing_filter_output;	
	}
					
	//Get JS output to animate the titles on mouse over and out
	$title_animation_js = mp_core_js_mouse_over_animate_child( '#mp-brick-' . $post_id . ' .mp-stacks-grid-item', '.mp-stacks-linkgrid-item-description-holder', mp_core_get_post_meta( $post_id, 'linkgrid_description_animation_keyframes', array() ), true, true, 'mp-brick-' . $post_id ); 

	return $existing_filter_output .= $title_animation_js;
}
add_filter( 'mp_stacks_grid_js', 'mp_stacks_linkgrid_description_animation_js', 10, 3 );
		
/**
 * Add the CSS for the description to LinkGrid's CSS
 *
 * @access   public
 * @since    1.0.0
 * @param    $css_output String - The CSS that exists already up until this filter has run
 * @return   $css_output String - The incoming CSS with our new CSS for the description appended.
 */
function mp_stacks_linkgrid_description_css( $css_output, $post_id ){
	
	$description_css_defaults = array(
		'color' => NULL,
		'size' => 15,
		'lineheight' => 19,
		'padding_top' => 10, //aka 'spacing'
		'background_padding' => 5,
		'background_color' => '#fff',
		'background_opacity' => 100,
		'placement_string' => 'below_image_left',
	);

	return $css_output .= mp_stacks_grid_text_css( $post_id, 'linkgrid_description', 'mp-stacks-linkgrid-item-description', $description_css_defaults );
}
add_filter('mp_stacks_linkgrid_css', 'mp_stacks_linkgrid_description_css', 10, 2);

/**
 * Add the Google Fonts for the Grid Excerpts
 *
 * @param    $css_output          String - The incoming CSS output coming from other things using this filter
 * @param    $post_id             Int - The post ID of the brick
 * @param    $first_content_type  String - The first content type chosen for this brick
 * @param    $second_content_type String - The second content type chosen for this brick
 * @return   $css_output          String - A string holding the css the brick
 */
function mp_stacks_linkgrid_description_google_font( $css_output, $post_id, $first_content_type, $second_content_type ){
	
	if ( $first_content_type != 'linkgrid' && $second_content_type != 'linkgrid' ){
		return $css_output;	
	}
	
	global $mp_stacks_footer_inline_css, $mp_core_font_families;
	
	//Default settings for the MP Core Google Font Class
	$mp_core_google_font_args = array( 'echo_google_font_css' => false, 'wrap_in_style_tags' => false );
	
	$linkgrid_description_googlefont = mp_core_get_post_meta( $post_id, 'linkgrid_description_google_font' );
	$linkgrid_description_googlefontweight = mp_core_get_post_meta( $post_id, 'linkgrid_description_google_font_weight_style' );
	
	//If a font name has been entered
	if ( !empty( $linkgrid_description_googlefont ) ){
		
		//Check if a font extra (weight) has been selected and add it if so.
		$linkgrid_description_googlefontweight = isset($linkgrid_description_googlefontweight) && !empty( $linkgrid_description_googlefontweight ) ? ':' . $linkgrid_description_googlefontweight : NULL;
		$linkgrid_description_googlefont = $linkgrid_description_googlefont . $linkgrid_description_googlefontweight;
	
		//Load the Google Font using the Google Font Class in MP Core
		new MP_CORE_Font( $linkgrid_description_googlefont, $linkgrid_description_googlefont, $mp_core_google_font_args );
		$mp_stacks_footer_inline_css[$linkgrid_description_googlefont] = $mp_core_font_families[$linkgrid_description_googlefont];
		
		//Return the incoming css string plus css to apply this font family to all paragraph tags
		$css_output .=  '#mp-brick-' . $post_id . ' .mp-stacks-linkgrid-item-description, #mp-brick-' . $post_id . ' .mp-stacks-linkgrid-item-description * { font-family: \'' . $linkgrid_description_googlefont . '\';}';
	
	}
	
	return $css_output;	
}
add_filter('mp_brick_additional_css', 'mp_stacks_linkgrid_description_google_font', 10, 4);	