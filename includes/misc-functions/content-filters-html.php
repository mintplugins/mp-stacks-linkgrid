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
 * This function hooks to the brick output. If it is supposed to be a 'linkgrid', then it will output the linkgrid
 *
 * @access   public
 * @since    1.0.0
 * @return   void
 */
function mp_stacks_brick_content_output_linkgrid( $default_content_output, $mp_stacks_content_type, $post_id ){
	
	//If this stack content type is NOT set to be a linkgrid	
	if ($mp_stacks_content_type != 'linkgrid'){
		
		return $default_content_output;
		
	}
	
	//Because we run the same function for this and for "Load More" ajax, we call a re-usable function which returns the output
	$linkgrid_output = mp_stacks_linkgrid_output( $post_id );
	
	//Return
	return $linkgrid_output['linkgrid_output'] . $linkgrid_output['load_more_button'] . $linkgrid_output['linkgrid_after'];

}
add_filter('mp_stacks_brick_content_output', 'mp_stacks_brick_content_output_linkgrid', 10, 3);

/**
 * Output more posts using ajax
 *
 * @access   public
 * @since    1.0.0
 * @return   void
 */
function mp_linkgrid_ajax_load_more(){
	
	if ( !isset( $_POST['mp_stacks_grid_post_id'] ) || !isset( $_POST['mp_stacks_grid_offset'] ) ){
		return;	
	}
	
	$post_id = $_POST['mp_stacks_grid_post_id'];
	$post_offset = $_POST['mp_stacks_grid_offset'];

	//Because we run the same function for this and for "Load More" ajax, we call a re-usable function which returns the output
	$linkgrid_output = mp_stacks_linkgrid_output( $post_id, $post_offset );
	
	echo json_encode( array(
		'items' => $linkgrid_output['linkgrid_output'],
		'button' => $linkgrid_output['load_more_button'],
		'animation_trigger' => $linkgrid_output['animation_trigger']
	) );
	
	die();
			
}
add_action( 'wp_ajax_mp_stacks_linkgrid_load_more', 'mp_linkgrid_ajax_load_more' );
add_action( 'wp_ajax_nopriv_mp_stacks_linkgrid_load_more', 'mp_linkgrid_ajax_load_more' );

/**
 * Run the Grid Loop and Return the HTML Output, Load More Button, and Animation Trigger for the Grid
 *
 * @access   public
 * @since    1.0.0
 * @param    Void
 * @param    $post_id Int - The ID of the Brick
 * @param    $post_offset Int - The number of posts deep we are into the loop (if doing ajax). If not doing ajax, set this to 0;
 * @return   Array - HTML output from the Grid Loop, The Load More Button, and the Animation Trigger in an array for usage in either ajax or not.
 */
function mp_stacks_linkgrid_output( $post_id, $post_offset = 0 ){
	
	global $wp_query;
	
	//Get this Brick Info
	$post = get_post($post_id);
	
	$linkgrid_output = NULL;
	
	//Get the repeater which we will loop through
	$linkgrid_links_repeater = mp_core_get_post_meta($post_id, 'linkgrid_links_repeater' );
	
	//Item per row
	$linkgrid_per_row = mp_core_get_post_meta($post_id, 'linkgrid_per_row', '3');
	
	//Item per page
	$linkgrid_per_page = mp_core_get_post_meta($post_id, 'linkgrid_per_page', '9');
	
	//Show Item Images?
	$linkgrid_link_images_show = mp_core_get_post_meta($post_id, 'linkgrid_link_images_show');
	
	//Images Widths and Heights
	$linkgrid_link_images_width = mp_core_get_post_meta($post_id, 'linkgrid_link_images_width', 500);
	$linkgrid_link_images_height = mp_core_get_post_meta($post_id, 'linkgrid_link_images_height', 0);
	
	//Get the options for the grid placement - we pass this to the action filters for text placement
	$grid_placement_options = apply_filters( 'mp_stacks_linkgrid_placement_options', NULL, $post_id );
	
	//Get the JS for animating items - only needed the first time we run this - not on subsequent Ajax requests.
	if ( !defined('DOING_AJAX') ){
		
		//Here we set javascript for this grid
		$linkgrid_output .= apply_filters( 'mp_stacks_grid_js', NULL, $post_id, 'linkgrid' );
						
	}
	
	//Grid Container Output
	$linkgrid_output .= !defined('DOING_AJAX') ? '<div class="mp-stacks-grid mp-stacks-linkgrid ' . apply_filters( 'mp_stacks_grid_classes', NULL, $post_id, 'linkgrid' ) . '">' : NULL;
	
	$total_posts = count( $linkgrid_links_repeater );
	
	$css_output = NULL;
	
	//Loop through the stack group		
	if ( is_array( $linkgrid_links_repeater ) ) { 
		
		$loop_counter = 1;
		
		//Loop through each link repeater (-1 because it starts at 0)
		for ( $x = $post_offset; $x <= $total_posts-1; $x++ ) {
			
			//Set the $link var 
			$link = $linkgrid_links_repeater[$x];
			
			$class_string = NULL;
			$class_string = apply_filters( 'mp_stacks_grid_item_classes', $class_string, $post_id, 'linkgrid' ); 
			$linkgrid_output .= '<div class="mp-stacks-grid-item ' . $class_string . '"><div class="mp-stacks-grid-item-inner">';
				
				//If we should show the featured images
				if ($linkgrid_link_images_show){
					
					$linkgrid_output .= '<div class="mp-stacks-grid-item-image-holder">';
					
						$linkgrid_output .= '<div class="mp-stacks-grid-item-image-overlay"></div>';
						
						$target = NULL;
						$lightbox_class = NULL;	
							
						//Get this links open-type
						if ( $link['linkgrid_link_open_type'] == '_blank' || $link['linkgrid_link_open_type'] == '_parent' ){
							$target = ' target="' . $link['linkgrid_link_open_type'] . '" ';	
							$lightbox_class = NULL;	
							$mfp_width_height_attr = NULL;
						}
						elseif( $link['linkgrid_link_open_type'] == 'lightbox' ){
							$target = NULL;
							$lightbox_width = $link['linkgrid_lightbox_width'];
							$lightbox_width = !empty( $lightbox_width ) ? $lightbox_width : '640';
							$lightbox_height = $link['linkgrid_lightbox_height'];
							$lightbox_height = !empty( $lightbox_height ) ? $lightbox_height : '360';
							$lightbox_class = 'mp-stacks-iframe-custom-width-height';	
							$mfp_width_height_attr = ' mfp-width="' . $lightbox_width . '" mfp-height="' . $lightbox_height . '" ';
						}
						
						$linkgrid_output .= '<a href="' . $link['linkgrid_link_url'] . '" class="mp-stacks-grid-image-link ' . $lightbox_class . '" ' . $target . ' title="' . htmlspecialchars( strip_tags( $link['linkgrid_link_title'] ) ) . '"  alt="' . htmlspecialchars( strip_tags( $link['linkgrid_link_title'] ) ) . '" ' . $mfp_width_height_attr . '>';
						
						$linkgrid_output .= '<img src="' . mp_aq_resize( $link['linkgrid_link_image'], $linkgrid_link_images_width, $linkgrid_link_images_height, true ) . '" class="mp-stacks-grid-item-image" title="' . htmlspecialchars( strip_tags( $link['linkgrid_link_title'] ) ) . '"  alt="' . htmlspecialchars( strip_tags( $link['linkgrid_link_title'] ) ) . '" />';
						
						//Top Over
						$linkgrid_output .= '<div class="mp-stacks-grid-over-image-text-container-top">';
						
							$linkgrid_output .= '<div class="mp-stacks-grid-over-image-text-container-table">';
							
								$linkgrid_output .= '<div class="mp-stacks-grid-over-image-text-container-table-cell">';
									
									//Filter Hook to output HTML into the "Top" and "Over" position on the featured Image
									$linkgrid_output .= apply_filters( 'mp_stacks_linkgrid_top_over', NULL, $link, $grid_placement_options );
								
								$linkgrid_output .= '</div>';
								
							$linkgrid_output .= '</div>';
						
						$linkgrid_output .= '</div>';
						
						//Middle Over
						$linkgrid_output .= '<div class="mp-stacks-grid-over-image-text-container-middle">';
						
							$linkgrid_output .= '<div class="mp-stacks-grid-over-image-text-container-table">';
							
								$linkgrid_output .= '<div class="mp-stacks-grid-over-image-text-container-table-cell">';
								
									//Filter Hook to output HTML into the "Middle" and "Over" position on the featured Image
									$linkgrid_output .= apply_filters( 'mp_stacks_linkgrid_middle_over', NULL, $link, $grid_placement_options );
								
								$linkgrid_output .= '</div>';
								
							$linkgrid_output .= '</div>';
						
						$linkgrid_output .= '</div>';
						
						//Bottom Over
						$linkgrid_output .= '<div class="mp-stacks-grid-over-image-text-container-bottom">';
						
							$linkgrid_output .= '<div class="mp-stacks-grid-over-image-text-container-table">';
							
								$linkgrid_output .= '<div class="mp-stacks-grid-over-image-text-container-table-cell">';
									
									//Filter Hook to output HTML into the "Bottom" and "Over" position on the featured Image
									$linkgrid_output .= apply_filters( 'mp_stacks_linkgrid_bottom_over', NULL, $link, $grid_placement_options );
								
								$linkgrid_output .= '</div>';
								
							$linkgrid_output .= '</div>';
						
						$linkgrid_output .= '</div>';
						
						$linkgrid_output .= '</a>';
						
					$linkgrid_output .= '</div>';
					
				}
				
				//Below Image Area Container:
				$linkgrid_output .= '<div class="mp-stacks-grid-item-below-image-holder">';
				
					//Filter Hook to output HTML into the "Below" position on the featured Image
					$linkgrid_output .= apply_filters( 'mp_stacks_linkgrid_below', NULL, $link, $grid_placement_options );
			
				$linkgrid_output .= '</div>';
			
			$linkgrid_output .= '</div></div>';
			
			//Increment Offset
			$post_offset = $post_offset + 1;
			
			//If we've reached our postsperpage limit (if we are at a multiple of 3)
			if ( $loop_counter == $linkgrid_per_page ){
				break;
			}
			
			//Increment Loop COunter
			$loop_counter = $loop_counter + 1;
			
		}
	}
	
	//If we're not doing ajax, add the stuff to close the linkgrid container and items needed after
	if ( !defined('DOING_AJAX') ){
		$linkgrid_output .= '</div>';
	}
	
	
	//jQuery Trigger to reset all linkgrid animations to their first frames
	$animation_trigger = '<script type="text/javascript">jQuery(document).ready(function($){ $(document).trigger("mp_core_animation_set_first_keyframe_trigger"); });</script>';
	
	//Assemble args for the load more output
	$load_more_args = array(
		 'meta_prefix' => 'linkgrid',
		 'total_posts' => $total_posts, 
		 'posts_per_page' => $linkgrid_per_page, 
		 'paged' => false, 
		 'post_offset' => $post_offset,
		 'brick_slug' => $post->post_name
	);
	
	return array(
		'linkgrid_output' => $linkgrid_output,
		'load_more_button' => apply_filters( 'mp_stacks_linkgrid_load_more_html_output', $load_more_html = NULL, $post_id, $load_more_args ),
		'animation_trigger' => $animation_trigger,
		'linkgrid_after' => '<div class="mp-stacks-grid-item-clearedfix"></div><div class="mp-stacks-grid-after"></div>'
	);
		
}