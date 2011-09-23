<?php
/**
 * Shadowbox class for frontend actions
 *
 * This class contains all functions and actions required for Shadowbox to work on the frontend of WordPress
 *
 * @since 3.0.0.1b
 * @package shadowbox-js
 * @subpackage frontend
 */
class ShadowboxFrontend extends Shadowbox {

	/**
	 * PHP 4 Style constructor which calls the below PHP5 Style Constructor
	 *
	 * @since 3.0.0.1
	 * @return none
	 */
	function ShadowboxFrontend () {
		$this->__construct();
	}

	/**
	 * Setup frontend functionality for WordPress
	 *
	 * @return none
	 * @since 3.0.0.0
	 */
	function __construct () {
		Shadowbox::__construct ();

		if ( ! empty ( $this->options ) ) {
			add_action ( 'wp_head' , array ( &$this , 'styles' ) , 7 );
			add_action ( 'wp_head' , array ( &$this , 'scripts' ) , 8 );
			if ( $this->get_option ( 'smartLoad' ) == 'false' )
				add_action ( 'wp_footer' , array ( &$this , 'configure' ) , 11 );

			// Automatically add Shadowbox to links
			if ( $this->is_automatic ( 'all' ) ) {
				add_filter ( 'the_content' , array ( &$this , 'add_attr_to_link' ) , 11 );
				add_filter ( 'the_excerpt' , array ( &$this , 'add_attr_to_link' ) , 11 );
			}

			// If we are automating for images make sure we link directly to the attachment
			if ( $this->is_automatic ( 'img' ) )
				add_filter ( 'attachment_link' , array ( &$this , 'attachment_direct_linkage' ) , 10 , 2 );
		}
	}

	/**
	 * Enqueue Shadowbox CSS 
	 *
	 * @return none
	 * @since 2.0.3
	 */
	function styles () {
		$plugin_url = $this->plugin_url ();
		$shadowbox_css = apply_filters ( 'shadowbox-css' , $plugin_url . '/shadowbox/shadowbox.css' );
		if ( ! empty ( $shadowbox_css ) )
			wp_enqueue_style ( 'shadowbox-css' , $shadowbox_css , false , false , 'screen' );
		wp_enqueue_style ( 'shadowbox-extras' , $plugin_url . '/css/extras.css' , false , '3.0.0.0' , 'screen' );
	}

	/**
	 * Enqueue Shadowbox javascript and dependencies
	 * 
	 * @return none
	 * @since 2.0.3
	 */
	function scripts () {
		$plugin_url = $this->plugin_url ();
		$adapter = 'shadowbox-' . $this->get_option ( 'library' );
		$language = $this->get_option ( 'language' );
		$shadowbox_markup = apply_filters ( 'shadowbox-markup' , '' );

		// Scripts packaged with WordPress that are configured to enqueue to the head by default
		$wp_head_scripts = array ( 'jquery' , 'prototype' );

		wp_register_script ( 'yui' , 'http://yui.yahooapis.com/2.7.0/build/yahoo-dom-event/yahoo-dom-event.js' , false , '2.7.0' , true );
		wp_register_script ( 'ext' , $plugin_url . '/js/ext-base-core.js' , false , '2.0.2' , true );
		wp_register_script ( 'dojo' , 'http://ajax.googleapis.com/ajax/libs/dojo/1.2.3/dojo/dojo.xd.js' , false , '1.2.3' , true );
		wp_register_script ( 'mootools' , 'http://ajax.googleapis.com/ajax/libs/mootools/1.2.1/mootools-yui-compressed.js' , false , '1.2.1' , true );
		wp_register_script ( 'shadowbox' , $plugin_url . '/shadowbox/shadowbox.js' , false , '3.0' , true );

		if ( ! empty ( $shadowbox_markup ) )
			wp_enqueue_script ( 'shadowbox-markup' , $shadowbox_markup , array ( 'shadowbox' ) , false , true );

		if ( ( ! function_exists ( 'wp_enqueue_scripts' ) && $this->get_option ( 'library' ) != 'base' ) ||
			 ( function_exists ( 'wp_enqueue_scripts' ) && in_array ( $this->get_option ( 'library' ) , $wp_head_scripts ) ) || 
			 ( $this->get_option ( 'smartLoad' ) == 'false' ) )
				wp_enqueue_script ( $this->get_option ( 'library' ) );

		if ( ! function_exists ( 'wp_enqueue_scripts' ) || $this->get_option ( 'smartLoad' ) == 'false' )
			wp_enqueue_script ( 'shadowbox' );

		// If we haven't printed the styles by now lets do so
		if ( ! did_action ( 'wp_print_styles' ) )
			wp_print_styles ();
	}

	/**
	 * Possibly enqueue a script to the footer if it is not already enqueued
	 *
	 * Used to enqueue a script to the footer in mid page as long as the
	 * script is not already enqueued.
	 *
	 * @return none
	 * @since 3.0.0.0
	 */
	function possibly_enqueue ( $script ) {
		// if not at least WP 2.8.0 return
		if ( ! function_exists ( 'wp_enqueue_scripts' ) )
			return;

		// Scripts packaged with WordPress that are by default printed to the head
		$wp_head_scripts = array ( 'jquery' , 'prototype' );

		// If not using a script that defaults to printing in the head enqueue to the footer
		if ( ! in_array ( $this->get_option ( 'library' ) , $wp_head_scripts ) )
			add_action ( 'wp_footer' , create_function ( '$a' , 'wp_print_scripts ( "' . $this->get_option ( 'library' ) . '" );' ) );
		add_action ( 'wp_footer' , create_function ( '$a' , 'wp_print_scripts ( "' . $script . '" );' ) );
		add_action ( 'wp_footer' , array ( &$this , 'configure' ) , 11 );
	}

	/**
	 * Echo Shadowbox configuration and initialization scripts
	 *
	 * @return none
	 * @since 0.1
	 */
	function configure () {
		$library = $this->get_option ( 'library' );
		$start = "\n<!-- Begin Shadowbox JS -->\n";
		$end = "<!-- End Shadowbox JS -->\n\n";

		if ( $this->get_option ( 'enableFlv' ) == 'false' && in_array ( 'flv' , $this->get_option ( 'players' ) ) )
			$players = '[' . str_replace ( 'flv",', '', implode ( '","' , $this->get_option ( 'players' ) ) ) . '"]';
		else
			$players = '["' . implode ( '","' , $this->get_option ( 'players' ) ) . '"]';

		// Shadowbox initialization options
		$init_ops  = '		adapter: "' . $this->get_option ( 'library' ) . '",' . "\n";
		$init_ops .= '		language: "' . $this->get_option ( 'language' ) . '",' . "\n";
		$init_ops .= '		players: ' . $players . ',' . "\n";
		$init_ops .= '		animate: ' . $this->get_option ( 'animate' ) . ',' . "\n";
		$init_ops .= '		animateFade: ' . $this->get_option ( 'animateFade' ) . ',' . "\n";
		$init_ops .= '		animSequence: "' . $this->get_option ( 'animSequence' ) . '",' . "\n";
		$init_ops .= '		autoDimensions: ' . $this->get_option ( 'autoDimensions' ) . ',' . "\n";
		$init_ops .= '		modal: ' . $this->get_option ( 'modal' ) . ',' . "\n";
		$init_ops .= '		showOverlay: ' . $this->get_option ( 'showOverlay' ) . ',' . "\n";
		$init_ops .= '		overlayColor: "' . $this->get_option ( 'overlayColor' ) . '",' . "\n";
		$init_ops .= '		overlayOpacity: ' . $this->get_option ( 'overlayOpacity' ) . ',' . "\n";
		$init_ops .= '		flashBgColor: "' . $this->get_option ( 'flashBgColor' ) . '",' . "\n";
		$init_ops .= '		autoplayMovies: ' . $this->get_option ( 'autoplayMovies' ) . ',' . "\n";
		$init_ops .= '		showMovieControls: ' . $this->get_option ( 'showMovieControls' ) . ',' . "\n";
		$init_ops .= '		slideshowDelay: ' . $this->get_option ( 'slideshowDelay' ) . ',' . "\n";
		$init_ops .= '		resizeDuration: ' . $this->get_option ( 'resizeDuration' ) . ',' . "\n";
		$init_ops .= '		fadeDuration: ' . $this->get_option ( 'fadeDuration' ) . ',' . "\n";
		$init_ops .= '		displayNav: ' . $this->get_option ( 'displayNav' ) . ',' . "\n";
		$init_ops .= '		continuous: ' . $this->get_option ( 'continuous' ) . ',' . "\n";
		$init_ops .= '		displayCounter: ' . $this->get_option ( 'displayCounter' ) . ',' . "\n";
		$init_ops .= '		counterType: "' . $this->get_option ( 'counterType' ) . '",' . "\n";
		$init_ops .= '		counterLimit: ' . $this->get_option ( 'counterLimit' ) . ',' . "\n";
		$init_ops .= '		viewportPadding: ' . $this->get_option ( 'viewportPadding' ) . ',' . "\n";
		$init_ops .= '		handleOversize: "' . $this->get_option ( 'handleOversize' ) . '",' . "\n";
		$init_ops .= '		handleUnsupported: "' . $this->get_option ( 'handleUnsupported' ) . '",' . "\n";
		$init_ops .= '		initialHeight: ' . $this->get_option ( 'initialHeight' ) . ',' . "\n";
		$init_ops .= '		initialWidth: ' . $this->get_option ( 'initialWidth' ) . ',' . "\n";
		$init_ops .= '		enableKeys: ' . $this->get_option ( 'enableKeys' ) . ',' . "\n";
		$init_ops .= '		skipSetup: ' . $this->get_option ( 'skipSetup' ) . ',' . "\n";
		$init_ops .= '		flashParams: ' . $this->get_option ( 'flashParams' ) . ',' . "\n";
		$init_ops .= '		flashVars: ' . $this->get_option ( 'flashVars' ) . ',' . "\n";
		$init_ops .= '		flashVersion: "' . $this->get_option ( 'flashVersion' ) . '"';

		// The full Shadowbox configuration
		$init  = "<script type=\"text/javascript\">\n";
		$init .= "	var shadowbox_conf = {\n";
		$init .= "$init_ops\n";
		$init .= "	};\n";
		$init .= "	Shadowbox.init(shadowbox_conf);\n";
		$init .= "</script>\n";

		echo $start . $init . $end;
	}

	/**
	 * Returns whether or not a specific type or all of the automations are enabled
	 *
	 * @return boolean
	 * @since 2.0.4.0
	 */
	function is_automatic ( $type = null ) {
		switch ( $type ) {
			case 'img':
			case 'mov':
			case 'aud':
			case 'tube':
				if ( $this->get_option ( "auto{$type}" ) == "true" )
					return true;
				else
					return false;
				break;
			default:
				if ( $this->get_option ( 'autoimg' )  == "true" ||
					 $this->get_option ( 'automov' )  == "true" ||
					 $this->get_option ( 'autoaud' )  == "true" ||
					 $this->get_option ( 'autotube' ) == "true" )
					return true;
				else
					return false;
				break;
		}
	}

	/**
	 * This function is called by the add_filter WordPress function to 
	 * link the gallery images directly to their full size counterpart
	 *
	 * @param string $link The link of the attachment
	 * @param integer $id The id of the post
	 * @return string
	 * @since 2.0.1
	 */
	function attachment_direct_linkage ( $link , $id ) {
		$mimetypes = array ( 'image/jpeg' , 'image/png' , 'image/gif' );
		$post = get_post ( $id );
		if ( in_array ( $post->post_mime_type , $mimetypes ) )
			return wp_get_attachment_url ( $id );
		else
			return $link;
	}

	/**
	 * This function is called by the add_filter WordPress function to add 
	 * the rel="shadowbox[post-123]" attribute to all links of a specified
	 * type.
	 *
	 * @param string $content The content of the post
	 * @return string
	 * @since 2.0.3
	 */
	function add_attr_to_link ( $content ) {
		global $post;

		// Search Patterns
		$img_pattern = '/<a(.*?)href=(\'|")([^>]*)\.(bmp|gif|jpe?g|png)(\'|")(.*?)>/i';
		$mov_pattern = '/<a(.*?)href=(\'|")([^>]*)\.(swf|flv|f4v|dv|moo?v|movie|mp4|asf|wmv?|avi|mpe?g)(\'|")(.*?)>/i';
		$aud_pattern = '/<a(.*?)href=(\'|")([^>]*)\.(mp3|aac)(\'|")(.*?)>/i';
		$tube_pattern = '/<a(.*?)href=(\'|")([^>]*)(youtube\.com\/(watch|v\/)|video\.google\.com\/googleplayer.swf)(.*?)(\'|")(.*?)>/i';
		$master_pattern = '/<a(.*?)href=(\'|")([^>]*)(\.(bmp|gif|jpe?g|png|swf|flv|f4v|dv|moo?v|movie|mp4|asf|wmv?|avi|mpe?g|mp3|aac)(\'|")|(youtube\.com\/(watch|v\/)|video\.google\.com\/googleplayer.swf))(.*?)>/i';	

		// Rel attrs for different file types
		$img_rel_attr = 'rel=$2shadowbox[post-' . $post->ID . '];player=img;$5';
		$mov_rel_attr = 'rel=$2shadowbox[post-' . $post->ID . ']$5';
		$aud_rel_attr = 'rel=$2shadowbox[post-' . $post->ID . '];player=flv;width=500;height=0;$5';
		$tube_rel_attr = 'rel=$2shadowbox[post-' . $post->ID . '];player=swf;width=' . $this->get_option ( 'tubeWidth' ) . ';height=' . $this->get_option ( 'tubeHeight' ) . ';$7';

		// Replacement patterns
		$img_replace = '<a$1href=$2$3.$4$5 ' . $img_rel_attr . '$6>';
		$mov_replace = '<a$1href=$2$3.$4$5 ' . $mov_rel_attr . '$6>';
		$aud_replace = '<a$1href=$2$3.$4$5 ' . $aud_rel_attr . '$6>';
		$tube_replace = '<a$1href=$2$3$4$6$7 ' . $tube_rel_attr . '$8>';

		// Non specific search patterns
		$rel_pattern = '/\ rel=(\'|")(.*?)(\'|")/i';
		$box_rel_pattern = '/\ rel=(\'|")(.*?)(shadow|light|no)box(.*?)(\'|")/i';
		$slbox_rel_pattern = '/\ rel=(\'|")(.*?)(shadow|light)box(.*?)(\'|")/i';

		if ( preg_match_all ( $master_pattern , $content , $links ) ) {
			foreach ( $links[0] as $link ) {
			
				if ( preg_match ( $img_pattern , $link ) && $this->get_option ( 'autoimg' ) == "true" ) {
					$link_pattern = $img_pattern;
					$rel_attr = $img_rel_attr;
					$link_replace = $img_replace;
				} elseif ( preg_match ( $mov_pattern , $link ) && $this->get_option ( 'automov' ) == "true" ) {
					$link_pattern = $mov_pattern;
					$rel_attr = $mov_rel_attr;
					$link_replace = $mov_replace;
				} elseif ( preg_match ( $aud_pattern , $link ) && $this->get_option ( 'autoaud' ) == "true" ) {
					$link_pattern = $aud_pattern;
					$rel_attr = $aud_rel_attr;
					$link_replace = $aud_replace;
				} elseif ( preg_match ( $tube_pattern , $link ) && $this->get_option ( 'autotube' ) == "true" ) {
					$link_pattern = $tube_pattern;
					$rel_attr = $tube_rel_attr;
					$link_replace = $tube_replace;
				} else {
					return $content;
				}

				if ( ! preg_match ( $rel_pattern , $link ) ) {
					$link_replace = preg_replace ( $link_pattern , $link_replace , $link );
					$content = str_replace ( $link , $link_replace , $content );
				} elseif ( ! preg_match ( $box_rel_pattern , $link ) ) {
					preg_match ( $rel_pattern , $link , $link_rel );
					$link_no_rel = preg_replace( $rel_pattern , '' , $link );
					$link_replace = preg_replace ( $link_pattern , $link_replace , $link_no_rel );
					$content = str_replace ( $link , $link_replace , $content );
				}
			}
		}

		// Check to see if we need to try to load shadowbox and dependencies into the footer
		if ( preg_match ( $slbox_rel_pattern , $content ) && $this->get_option ( 'smartLoad' ) == 'true')
			$this->possibly_enqueue ( 'shadowbox' );

		return $content;
	}
}

?>
