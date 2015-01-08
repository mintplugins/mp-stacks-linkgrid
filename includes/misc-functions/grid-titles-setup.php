<?php 
/**
 * This file contains the function which set up the Titles in the Grid
 *
 * To use this for additional Text Overlays in a grid, duplicate this file 
 * 1. Find and replace "linkgrid" with your plugin's prefix
 * 2. Find and replace "title" with your desired text overlay name
 * 3. Make custom changes to the mp_stacks_linkgrid_title function about what is displayed.
 *
 * @since 1.0.0
 *
 * @package    MP Stacks LinkGrid
 * @subpackage Functions
 *
 * @copyright  Copyright (c) 2014, Mint Plugins
 * @license    http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @author     Philip Johnston
 */

/**
 * Add the meta options for the Grid Titles to the LinkGrid Metabox
 *
 * @access   public
 * @since    1.0.0
 * @param    Void
 * @param    $post_id Int - The ID of the Brick
 * @return   Array - All of the placement optons needed for Title, Price, and Excerpt
 */
function mp_stacks_linkgrid_title_meta_options( $items_array ){		
	
	//Title Settings
	$new_fields = array(
		'linkgrid_title_showhider' => array(
			'field_id'			=> 'linkgrid_title_settings',
			'field_title' 	=> __( 'Title Settings', 'mp_stacks_linkgrid'),
			'field_description' 	=> __( '', 'mp_stacks_linkgrid' ),
			'field_type' 	=> 'showhider',
			'field_value' => '',
			'field_showhider' => 'linkgrid_design_showhider',
		),
		'linkgrid_title_show' => array(
			'field_id'			=> 'linkgrid_title_show',
			'field_title' 	=> __( 'Show Titles?', 'mp_stacks_linkgrid'),
			'field_description' 	=> __( 'Do you want to show the Titles for these posts?', 'mp_stacks_linkgrid' ),
			'field_type' 	=> 'checkbox',
			'field_value' => 'true',
			'field_showhider' => 'linkgrid_title_settings',
		),
		'linkgrid_title_placement' => array(
			'field_id'			=> 'linkgrid_title_placement',
			'field_title' 	=> __( 'Titles\' Placement', 'mp_stacks_linkgrid'),
			'field_description' 	=> __( 'Where would you like to place the title? Default: Below Image, Left', 'mp_stacks_linkgrid' ),
			'field_type' 	=> 'select',
			'field_value' => 'below_image_left',
			'field_select_values' => mp_stacks_get_text_position_options(),
			'field_showhider' => 'linkgrid_title_settings',
		),
		'linkgrid_title_color' => array(
			'field_id'			=> 'linkgrid_title_color',
			'field_title' 	=> __( 'Titles\' Color', 'mp_stacks_linkgrid'),
			'field_description' 	=> __( 'Select the color the titles will be (leave blank for theme default)', 'mp_stacks_linkgrid' ),
			'field_type' 	=> 'colorpicker',
			'field_value' => '',
			'field_showhider' => 'linkgrid_title_settings',
		),
		'linkgrid_title_size' => array(
			'field_id'			=> 'linkgrid_title_size',
			'field_title' 	=> __( 'Titles\' Size', 'mp_stacks_linkgrid'),
			'field_description' 	=> __( 'Enter the text size the titles will be. Default: 20', 'mp_stacks_linkgrid' ),
			'field_type' 	=> 'number',
			'field_value' => '20',
			'field_showhider' => 'linkgrid_title_settings',
		),
		'linkgrid_title_lineheight' => array(
			'field_id'			=> 'linkgrid_title_lineheight',
			'field_title' 	=> __( 'Titles\' Line Height', 'mp_stacks_linkgrid'),
			'field_description' 	=> __( 'Enter the line height for the excerpt text. Default: 20', 'mp_stacks_linkgrid' ),
			'field_type' 	=> 'number',
			'field_value' => '20',
			'field_showhider' => 'linkgrid_title_settings',
		),
		'linkgrid_title_animation_desc' => array(
			'field_id'			=> 'linkgrid_title_animation_description',
			'field_title' 	=> __( 'Animate the Title upon Mouse-Over', 'mp_stacks_linkgrid'),
			'field_description' 	=> __( 'Control the animations of the titles when the user\'s mouse is over the featured images by adding keyframes here:', 'mp_stacks_linkgrid' ),
			'field_type' 	=> 'basictext',
			'field_value' => '',
			'field_showhider' => 'linkgrid_title_settings',
		),
		'linkgrid_title_animation_repeater_title' => array(
			'field_id'			=> 'linkgrid_title_animation_repeater_title',
			'field_title' 	=> __( 'KeyFrame', 'mp_stacks_linkgrid'),
			'field_description' 	=> NULL,
			'field_type' 	=> 'repeatertitle',
			'field_repeater' => 'linkgrid_title_animation_keyframes',
			'field_showhider' => 'linkgrid_title_settings',
		),
		'linkgrid_title_animation_length' => array(
			'field_id'			=> 'animation_length',
			'field_title' 	=> __( 'Animation Length', 'mp_stacks_linkgrid'),
			'field_description' 	=> __( 'Set the length between this keyframe and the previous one in milliseconds. Default: 500', 'mp_stacks_linkgrid' ),
			'field_type' 	=> 'number',
			'field_value' => '500',
			'field_repeater' => 'linkgrid_title_animation_keyframes',
			'field_showhider' => 'linkgrid_title_settings',
			'field_container_class' => 'mp_animation_length',
		),
		'linkgrid_title_animation_opacity' => array(
			'field_id'			=> 'opacity',
			'field_title' 	=> __( 'Opacity', 'mp_stacks_linkgrid'),
			'field_description' 	=> __( 'Set the opacity percentage at this keyframe. Default: 100', 'mp_stacks_linkgrid' ),
			'field_type' 	=> 'input_range',
			'field_value' => '100',
			'field_repeater' => 'linkgrid_title_animation_keyframes',
			'field_showhider' => 'linkgrid_title_settings',
		),
		'linkgrid_title_animation_ratation' => array(
			'field_id'			=> 'rotateZ',
			'field_title' 	=> __( 'Rotation', 'mp_stacks_linkgrid'),
			'field_description' 	=> __( 'Set the rotation degree angle at this keyframe. Default: 0', 'mp_stacks_linkgrid' ),
			'field_type' 	=> 'number',
			'field_value' => '0',
			'field_repeater' => 'linkgrid_title_animation_keyframes',
			'field_showhider' => 'linkgrid_title_settings',
		),
		'linkgrid_title_animation_x' => array(
			'field_id'			=> 'translateX',
			'field_title' 	=> __( 'X Position', 'mp_stacks_linkgrid'),
			'field_description' 	=> __( 'Set the X position, in relation to its starting position, at this keyframe. The unit is pixels. Default: 0', 'mp_stacks_linkgrid' ),
			'field_type' 	=> 'number',
			'field_value' => '0',
			'field_repeater' => 'linkgrid_title_animation_keyframes',
			'field_showhider' => 'linkgrid_title_settings',
		),
		'linkgrid_title_animation_y' => array(
			'field_id'			=> 'translateY',
			'field_title' 	=> __( 'Y Position', 'mp_stacks_linkgrid'),
			'field_description' 	=> __( 'Set the Y position, in relation to its starting position, at this keyframe. The unit is pixels. Default: 0', 'mp_stacks_linkgrid' ),
			'field_type' 	=> 'number',
			'field_value' => '0',
			'field_repeater' => 'linkgrid_title_animation_keyframes',
			'field_showhider' => 'linkgrid_title_settings',
		),
		//Title Background
		'linkgrid_title_bg_showhider' => array(
			'field_id'			=> 'linkgrid_title_background_settings',
			'field_title' 	=> __( 'Title Background Settings', 'mp_stacks_linkgrid'),
			'field_description' 	=> __( '', 'mp_stacks_linkgrid' ),
			'field_type' 	=> 'showhider',
			'field_value' => '',
			'field_showhider' => 'linkgrid_design_showhider',
		),
		'linkgrid_title_bg_show' => array(
			'field_id'			=> 'linkgrid_title_background_show',
			'field_title' 	=> __( 'Show Title Backgrounds?', 'mp_stacks_linkgrid'),
			'field_description' 	=> __( 'Do you want to show a background color behind the title?', 'mp_stacks_linkgrid' ),
			'field_type' 	=> 'checkbox',
			'field_value' => '',
			'field_showhider' => 'linkgrid_title_background_settings',
		),
		'linkgrid_title_bg_size' => array(
			'field_id'			=> 'linkgrid_title_background_padding',
			'field_title' 	=> __( 'Title Background Size', 'mp_stacks_linkgrid'),
			'field_description' 	=> __( 'How many pixels bigger should the Title Background be than the Text? Default: 5', 'mp_stacks_linkgrid' ),
			'field_type' 	=> 'number',
			'field_value' => '5',
			'field_showhider' => 'linkgrid_title_background_settings',
		),
		'linkgrid_title_bg_color' => array(
			'field_id'			=> 'linkgrid_title_background_color',
			'field_title' 	=> __( 'Title Background Color', 'mp_stacks_linkgrid'),
			'field_description' 	=> __( 'What color should the title background be? Default: #FFF (White)', 'mp_stacks_linkgrid' ),
			'field_type' 	=> 'colorpicker',
			'field_value' => '#FFF',
			'field_showhider' => 'linkgrid_title_background_settings',
		),
		'linkgrid_title_bg_opacity' => array(
			'field_id'			=> 'linkgrid_title_background_opacity',
			'field_title' 	=> __( 'Title Background Opacity', 'mp_stacks_linkgrid'),
			'field_description' 	=> __( 'Set the opacity percentage? Default: 100', 'mp_stacks_linkgrid' ),
			'field_type' 	=> 'input_range',
			'field_value' => '100',
			'field_showhider' => 'linkgrid_title_background_settings',
		)
	);
	
	return mp_core_insert_meta_fields( $items_array, $new_fields, 'linkgrid_meta_hook_anchor_2' );

}
add_filter( 'mp_stacks_linkgrid_items_array', 'mp_stacks_linkgrid_title_meta_options', 99 );

/**
 * Add the placement options for the Title using placement options filter hook
 *
 * @access   public
 * @since    1.0.0
 * @param    Void
 * @param    $post_id Int - The ID of the Brick
 * @return   Array - All of the placement optons needed for Title, Price, and Excerpt
 */
function mp_stacks_linkgrid_title_placement_options( $placement_options, $post_id ){
	
	print_r($placement_options);
	
	//Show Post Titles
	$placement_options['title_show'] = mp_core_get_post_meta($post_id, 'linkgrid_title_show');
	
	//Titles placement
	$placement_options['title_placement'] = mp_core_get_post_meta($post_id, 'linkgrid_title_placement', 'below_image_left');
	
	return $placement_options;	
}
add_filter( 'mp_stacks_linkgrid_placement_options', 'mp_stacks_linkgrid_title_placement_options', 10, 2 );

/**
 * Get the HTML for the title in the grid
 *
 * @access   public
 * @since    1.0.0
 * @post_id  $post_id Int - The ID of the post to get the title of
 * @return   $html_output String - A string holding the html for a title in the grid
 */
function mp_stacks_linkgrid_title( $link ){
	
	$title_html_output = mp_stacks_grid_highlight_text_html( array( 
		'class_name' => 'mp-stacks-linkgrid-item-title',
		'output_string' => $link['linkgrid_link_title'], 
	) );
	
	return $title_html_output;
	
}

/**
 * Hook the Title to the "Top" and "Over" position in the grid
 *
 * @access   public
 * @since    1.0.0
 * @param    $post_id Int - The ID of the post
 * @return   $html_output String - A string holding the html for text over a featured image in the grid
 */
function mp_stacks_linkgrid_title_top_over_callback( $linkgrid_output, $link, $options ){
	
	//If we should show the title over the image
	if ( strpos( $options['title_placement'], 'over') !== false && strpos( $options['title_placement'], 'top') !== false && $options['title_show']){
		
		return $linkgrid_output . mp_stacks_linkgrid_title( $link );

	}
	
	return $linkgrid_output;
	
}
add_filter( 'mp_stacks_linkgrid_top_over', 'mp_stacks_linkgrid_title_top_over_callback', 10, 3 );

/**
 * Hook the Title to the "Middle" and "Over" position in the grid
 *
 * @access   public
 * @since    1.0.0
 * @param    $post_id Int - The ID of the post
 * @return   $html_output String - A string holding the html for text over a featured image in the grid
 */
function mp_stacks_linkgrid_title_middle_over_callback( $linkgrid_output, $link, $options ){
	
	//If we should show the title over the image
	if ( strpos( $options['title_placement'], 'over') !== false && strpos( $options['title_placement'], 'middle') !== false && $options['title_show']){
		
		return $linkgrid_output . mp_stacks_linkgrid_title( $link );

	}
	
	return $linkgrid_output;
}
add_filter( 'mp_stacks_linkgrid_middle_over', 'mp_stacks_linkgrid_title_middle_over_callback', 10, 3 );

/**
 * Hook the Title to the "Bottom" and "Over" position in the grid
 *
 * @access   public
 * @since    1.0.0
 * @param    $link Int - The ID of the post
 * @return   $html_output String - A string holding the html for text over a featured image in the grid
 */
function mp_stacks_linkgrid_title_bottom_over_callback( $linkgrid_output, $link, $options ){
	
	//If we should show the title over the image
	if ( strpos( $options['title_placement'], 'over') !== false && strpos( $options['title_placement'], 'bottom') !== false && $options['title_show']){
		
		return $linkgrid_output . mp_stacks_linkgrid_title( $link );

	}
	
	return $linkgrid_output;
	
}
add_filter( 'mp_stacks_linkgrid_bottom_over', 'mp_stacks_linkgrid_title_bottom_over_callback', 10, 3 );

/**
 * Hook the Title to the "Below" position in the grid
 *
 * @access   public
 * @since    1.0.0
 * @param    $link Int - The ID of the post
 * @return   $html_output String - A string holding the html for text over a featured image in the grid
 */
function mp_stacks_linkgrid_title_below_over_callback( $linkgrid_output, $link, $options ){
	
	//If we should show the title below the image
	if ( strpos( $options['title_placement'], 'below') !== false && $options['title_show']){
		
		
		//Get this links open-type
		if ( $link['linkgrid_link_open_type'] == '_blank' || $link['linkgrid_link_open_type'] == '_parent' ){
			$target = ' target="' . $link['linkgrid_link_open_type'] . '" ';	
			$lightbox_class = NULL;	
		}
		elseif( $link['linkgrid_link_open_type'] == 'lightbox' ){
			$target = NULL;
			$lightbox_class = 'mp-stacks-lightbox-link';	
		}
		
		$title_html_output = '<a href="' . $link['linkgrid_link_url'] . '" class="mp-stacks-linkgrid-title-link mp-stacks-grid-image-link ' . $lightbox_class . '" ' . $target . '>';	
			$title_html_output .= mp_stacks_linkgrid_title( $link );
		$title_html_output .= '</a>';
		
		return $linkgrid_output . $title_html_output;
	}
	
	return $linkgrid_output;
	
}
add_filter( 'mp_stacks_linkgrid_below', 'mp_stacks_linkgrid_title_below_over_callback', 10, 3 );

/**
 * Add the JS for the title to LinkGrid's HTML output
 *
 * @access   public
 * @since    1.0.0
 * @param    $linkgrid_output String - The output for linkgrid up until this point.
 * @return   $linkgrid_output String - The incoming HTML with the new JS animation for the title appended.
 */
function mp_stacks_linkgrid_title_animation_js( $linkgrid_output, $post_id ){
			
	//Get JS output to animate the titles on mouse over and out
	$title_animation_js = mp_core_js_mouse_over_animate_child( '#mp-brick-' . $post_id . ' .mp-stacks-grid-item', '.mp-stacks-linkgrid-item-title-holder', mp_core_get_post_meta( $post_id, 'linkgrid_title_animation_keyframes', array() ) ); 

	return $linkgrid_output . $title_animation_js;
}
add_filter( 'mp_stacks_linkgrid_animation_js', 'mp_stacks_linkgrid_title_animation_js', 10, 2 );
		
/**
 * Add the CSS for the title to LinkGrid's CSS
 *
 * @access   public
 * @since    1.0.0
 * @param    $css_output String - The CSS that exists already up until this filter has run
 * @return   $css_output String - The incoming CSS with our new CSS for the title appended.
 */
function mp_stacks_linkgrid_title_css( $css_output, $post_id ){
	
	$title_css_defaults = array(
		'color' => NULL,
		'size' => 20,
		'lineheight' => 20,
		'background_padding' => 5,
		'background_color' => '#fff',
		'background_opacity' => 100,
		'placement_string' => 'below_image_left',
	);

	return $css_output .= mp_stacks_grid_text_css( $post_id, 'linkgrid_title', 'mp-stacks-linkgrid-item-title', $title_css_defaults );
}
add_filter('mp_stacks_linkgrid_css', 'mp_stacks_linkgrid_title_css', 10, 2);