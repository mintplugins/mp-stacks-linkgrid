<?php
/**
 * This file contains the enqueue scripts function for the linkgrid plugin
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
 * Enqueue JS and CSS for linkgrid 
 *
 * @access   public
 * @since    1.0.0
 * @return   void
 */

/**
 * Enqueue css and js
 *
 * Filter: mp_stacks_linkgrid_css_location
 */
function mp_stacks_linkgrid_enqueue_scripts(){
			
	//Enqueue velocity JS
	wp_enqueue_script( 'velocity_js', MP_CORE_JS_SCRIPTS_URL . 'velocity.min.js', array( 'jquery' ), MP_STACKS_LINKGRID_VERSION );
	
	//Enqueue Waypoints JS
	wp_enqueue_script( 'waypoints_js', MP_CORE_JS_SCRIPTS_URL . 'waypoints.min.js', array( 'jquery' ), MP_STACKS_LINKGRID_VERSION );
	
	//masonry script
	wp_enqueue_script( 'masonry' );
			
	//Enqueue linkgrid JS
	wp_enqueue_script( 'mp_stacks_linkgrid_js', plugins_url( 'js/linkgrid.js', dirname( __FILE__ ) ), array( 'jquery', 'velocity_js', 'masonry', 'waypoints_js' ), MP_STACKS_LINKGRID_VERSION );

}
 
/**
 * Enqueue css face for linkgrid
 */
add_action( 'wp_enqueue_scripts', 'mp_stacks_linkgrid_enqueue_scripts' );

/**
 * Enqueue css and js
 *
 * Filter: mp_stacks_linkgrid_css_location
 */
function mp_stacks_linkgrid_admin_enqueue_scripts(){
	

}
 
/**
 * Enqueue css face for linkgrid
 */
add_action( 'admin_enqueue_scripts', 'mp_stacks_linkgrid_admin_enqueue_scripts' );