=== MP Stacks + LinkGrid ===
Contributors: johnstonphilip
Donate link: http://mintplugins.com/
Tags: message bar, header
Requires at least: 3.5
Tested up to: 4.4
Stable tag: 1.0.0.8
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Add-On Plugin for MP Stacks which shows a grid of custom links in a Brick. Each link can have its own title, description, and image - along with customizeable grid sizes,  

== Description ==

Extremely simple to set up - allows you to show a grid of links on any page, at any time, anywhere on your website.

== Installation ==

This section describes how to install the plugin and get it working.

1. Upload the mp-stacks-linkgrid folder to the /wp-content/plugins/ directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Build Bricks under the Manage Stacks menu. 
4. Publish your bricks into a Stack.
5. Put Stacks on pages using the shortcode or the Add Stack button.

== Frequently Asked Questions ==

See full instructions at http://mintplugins.com/doc/mp-stacks

== Screenshots ==


== Changelog ==

= 1.0.0.8 = February 21, 2016
* Added Google Font Controls for all Grid-text elements

= 1.0.0.7 = November 4, 2015
* Add a filter for the grid attributes

= 1.0.0.6 = September 24, 2015
* Make sure $link['linkgrid_lightbox_height'] is set.
* Changed grid posts_per_row to use the "mp_stacks_grid_posts_per_row_percentage" function in MP Stacks.

= 1.0.0.5 = September 20, 2015
* Links images show even if no URL is entered
* Brick Metabox controls now load using ajax.
* Admin Meta Scripts now enqueued only when needed.
* Front End Scripts now enqueued only when needed.

= 1.0.0.4 = May 20, 2015
* Make CSS Filter add to css instead of replacing previous CSS. This fixes bug with Google Fonts Addon not working fi the type was a LinkGrid.
* Fixed Title and Description Animations not working because of new mp_stacks_js_output filter hook replacing old animation hook.
* Enqueue MP Stacks Grid css (new file in MP Stacsk Specific to grids)
* Added lightbox sizing support for links

= 1.0.0.3 = April 25, 2015
* Isotope filtering added - without controls though for now. This keeps this grid in sync with other grids and keep masonry working as it should.

= 1.0.0.2 = March 1, 2015
* Added alt tags to outputs
* Changed “Image Height/Width” to “Image Crop Height/Width”
* Post Bg Controls Added
* Spacing between text items added
* Velocity JS updated to use velocity.min.js instead of jquery.velocity.min.js in MP_CORE.
* Versioning added to all enqueues.
* Better line height presets set for titles and excerpts.
* Added max-width option for grid images.

= 1.0.0.1 = January 8, 2015
* Fixed - Links weren’t working if the title or description was below the image.

= 1.0.0.0 = December 22, 2014
* Original release
