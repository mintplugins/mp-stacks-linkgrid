<?php 
/**
 * This file contains the function which hooks to a brick's content output
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
 * Process the CSS needed for the grid
 *
 * @access   public
 * @since    1.0.0
 * @param    $css_output          String - The incoming CSS output coming from other things using this filter
 * @param    $post_id             Int - The post ID of the brick
 * @param    $first_content_type  String - The first content type chosen for this brick
 * @param    $second_content_type String - The second content type chosen for this brick
 * @return   $html_output         String - A string holding the css the brick
 */
function mp_stacks_brick_content_output_css_linkgrid( $css_output, $post_id, $first_content_type, $second_content_type ){
	
	if ( $first_content_type != 'linkgrid' && $second_content_type != 'linkgrid' ){
		return $css_output;	
	}
	
	//Download per row
	$linkgrid_per_row = mp_core_get_post_meta($post_id, 'linkgrid_per_row', '3');
	
	//Post Spacing (padding)
	$linkgrid_post_spacing = mp_core_get_post_meta($post_id, 'linkgrid_post_spacing', '20');
	
	//Padding inside the featured images
	$linkgrid_link_images_inner_margin = mp_core_get_post_meta($post_id, 'linkgrid_link_images_inner_margin', '20' );
	
	//Image Overlay Color and Opacity
	$linkgrid_images_overlay_color = mp_core_get_post_meta($post_id, 'linkgrid_images_overlay_color', '#FFF' );
	$linkgrid_images_overlay_opacity = mp_core_get_post_meta($post_id, 'linkgrid_images_overlay_opacity', '0' );
	
	//Use the Excerpt's Color as the default fallback for all text in the grid
	$default_text_color = mp_core_get_post_meta( $post_id, 'linkgrid_excerpt_color' );
	
	//Get CSS Output
	
	$css_output = '
	#mp-brick-' . $post_id . ' .mp-stacks-grid-item{' . 
			mp_core_css_line( 'color', $default_text_color ) . 
			mp_core_css_line( 'width', (100/$linkgrid_per_row), '%' ) . 
			mp_core_css_line( 'padding', $linkgrid_post_spacing, 'px' ) . 
	'}';
	
	$css_output .= apply_filters( 'mp_stacks_linkgrid_css', $css_output, $post_id );
	
	$css_output .= '
	#mp-brick-' . $post_id . ' .mp-stacks-grid-over-image-text-container,
	#mp-brick-' . $post_id . ' .mp-stacks-grid-over-image-text-container-top,
	#mp-brick-' . $post_id . ' .mp-stacks-grid-over-image-text-container-middle,
	#mp-brick-' . $post_id . ' .mp-stacks-grid-over-image-text-container-bottom{' . 
		mp_core_css_line( 'padding', $linkgrid_link_images_inner_margin, 'px' ) . 
	'}';
	
	//Get the css output for the image overlay for mobile
	$css_output .= mp_stacks_grid_overlay_mobile_css( $post_id, 'linkgrid_image_overlay_animation_keyframes' );
	
	return $css_output;
	
}
add_filter('mp_brick_additional_css', 'mp_stacks_brick_content_output_css_linkgrid', 10, 4);