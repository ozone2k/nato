<?php
/**
 * Shadowbox is an online media viewing application that supports all of the web's
 * most popular media publishing formats. Shadowbox is written entirely in
 * JavaScript and CSS and is highly customizable. Using Shadowbox, website authors
 * can display a wide assortment of media in all major browsers without navigating
 * users away from the linking page.
 *
 * @author Matt Martz <matt@sivel.net>
 * @version 3.0.0.1
 * @package shadowbox-js
 */

/*
Plugin Name:  Shadowbox JS
Plugin URI:   http://sivel.net/wordpress/shadowbox-js/
Description:  A javascript media viewer similar to Lightbox and Thickbox. Supports all types of media, not just images. 
Version:      3.0.0.1
Author:       Matt Martz
Author URI:   http://sivel.net/
License:      LGPL

	Shadowbox JS (c) 2009 Matt Martz (http://sivel.net/)
	Shadowbox JS is released under the GNU General Public License (LGPL)
	http://www.gnu.org/licenses/lgpl-2.1.txt

	Shadowbox (c) 2009 Michael J. I. Jackson (http://www.shadowbox-js.com/)
	Shadowbox is licensed under the Shadowbox.js License version 1.0
	http://www.shadowbox-js.com/license.txt

	JW FLV Media Player (c) 2008 LongTail As Solutions (http://www.longtailvideo.com/)
	JW FLV Media Player is licensed under the Creative Commons Attribution-Noncommercial-Share Alike 3.0 Unported License
	http://creativecommons.org/licenses/by-nc-sa/3.0/
*/

/**
 * Shadowbox class for common actions between admin and frontend
 *
 * This class contains all of the shared functions required for Shadowbox to work 
 * on the frontend and admin of WordPress
 *
 * @since 3.0.0.1
 * @package shadowbox-js
 * @subpackage frontend
 */
class Shadowbox {

	/**
	 * Options array containing all options for this plugin
	 *
	 * @since 3.0.0.1
	 * @var string
	 */
	var $options;

	/**
	 * Setup shared functionality for ADmin and Front End
	 *
	 * @return none
	 * @since 3.0.0.1
	 */
	function __construct () {
		$this->options = get_option ( 'shadowbox' );
	} 

	/**
	 * Get specific option from the options table
	 *
	 * @param string $option Name of option to be used as array key for retrieving the specific value
	 * @return mixed 
	 * @since 2.0.3
	 */
	function get_option ( $option ) {
		if ( isset ( $this->options[$option] ) )
			return $this->options[$option];
		else
			return false;
	}

	/**
	 * Get the full URL to the plugin
	 *
	 * @return string
	 * @since 2.0.3
	 */
	function plugin_url () {
		$plugin_url = plugins_url ( plugin_basename ( dirname ( __FILE__ ) ) );
		return $plugin_url;
	}

}

/**
 * Instantiate the ShadowboxFrontend or ShadowboxAdmin Class
 *
 * If we are in the admin load the admin view else load the frontend view
 */
if ( is_admin () ) {
	require_once ( dirname ( __FILE__ ) . '/inc/admin.php' );
	$ShadowboxAdmin = new ShadowboxAdmin ();
} else {
	require_once ( dirname ( __FILE__ ) . '/inc/frontend.php' );
	$ShadowboxFrontend = new ShadowboxFrontend ();
}

?>
