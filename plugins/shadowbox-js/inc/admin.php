<?php
/**
 * Shadowbox class for admin actions
 *
 * This class contains all functions and actions required for Shadowbox to work in the admin of WordPress
 *
 * @package shadowbox-js
 * @subpackage admin
 * @since 3.0.0.1
 */
class ShadowboxAdmin extends Shadowbox {

	/**
	 * Plugin Version
	 *
	 * @since 3.0.0.0
	 * @var int
	 */
	var $version = '3.0.0.0';

	/**
	 * Changlog base url
	 *
	 * @since 3.0.0.1
	 * @var string
	 */
	var $repos_url = 'http://plugins.svn.wordpress.org/shadowbox-js';

	/**
	 * Full file system path to the main plugin file
	 *
	 * @since 3.0.0.0
	 * @var string
	 */
	var $plugin_file;
	
	/**
	 * Path to the main plugin file relative to wp-content/plugins
	 *
	 * @since 3.0.0.0
	 * @var string
	 */
	var $plugin_basename;

	/**
	 * Name of options page hook
	 *
	 * @since 3.0.0.1
	 * @var string
	 */
	var $options_page_hookname;

	/**
	 * PHP 4 Style constructor which calls the below PHP5 Style Constructor
	 *
	 * @since 3.0.0.1
	 * @return none
	 */
	function ShadowboxAdmin () {
		$this->__construct();
	}

	/**
	 * Setup backend functionality in WordPress
	 *
	 * @return none
	 * @since 3.0.0.0
	 */
	function __construct () {
		Shadowbox::__construct ();

		if ( version_compare ( $this->get_option ( 'version' ) , $this->version , '!=' ) && $this->get_option ( 'version' ) !== false )
			$this->check_upgrade ();

		// Full path and plugin basename of the main plugin file
		$this->plugin_file = dirname ( dirname ( __FILE__ ) ) . '/shadowbox-js.php';
		$this->plugin_basename = plugin_basename ( $this->plugin_file );

		// Load localizations if available
		load_plugin_textdomain ( 'shadowbox-js' , FALSE , '/shadowbox-js/localization' );

		// Activation hook
		register_activation_hook ( $this->plugin_file , array ( &$this , 'init' ) );

		// Whitelist options
		add_action ( 'admin_init' , array ( &$this , 'register_settings' ) );

		// Activate the options page
		add_action ( 'admin_menu' , array ( &$this , 'add_page' ) ) ;
		if ( function_exists ( 'wp_enqueue_scripts' ) )
			add_action ( "in_plugin_update_message-{$this->plugin_basename}" , array ( &$this , 'changelog' ) );
	}

	/**
	 * Whitelist the shadowbox-js options
	 *
	 * @since 3.0.0.1
	 * @return none
	 */
	function register_settings () {
		register_setting ( 'shadowbox' , 'shadowbox' , array ( &$this , 'update' ) );
	}

	/**
	 * Enqueue javascript into the admin to hide/show the advanced settings
	 * 
	 * @return none
	 * @since 2.0.3
	 */
	function admin_js () {
		wp_enqueue_script ( 'jquery' );
		wp_enqueue_script ( 'shadowbox-js-helper' , $this->plugin_url () . '/js/shadowbox-admin-helper.js' , array ( 'jquery' ) , '3.0.0.0' , true );
		wp_localize_script ( 'shadowbox-js-helper' , 'shadowboxJsHelperL10n' , array (
													'advConfShow'	 => 'Show Advanced Configuration' ,
													'advConfHide'	 => 'Hide Advanced Configuration' ,
													'messageConfirm' => 'Do you agree that you are not using FLV support for commercial purposes or have already purchased a license for JW FLV Media Player?'
													) );
	}

	/**
	 * Return a list of the languages available to shadowbox.js
	 *
	 * @since 2.0.3.3
	 * @return array
	 */
	function languages () {
		$languages = array ( 
				'ar' , // Arabic
				'bg' , // Bulgarian
				'ca' , // Catalan
				'cs' , // Czech
				'de-CH' , // Swiss German
				'de-DE' , // German
				'en' , // English
				'es' , // Spanish
				'et' , // Estonian
				'fi' , // Finnish
				'fr' , // French
				'gl' , // Galician 
				'he' , // Hebrew
				'hu' , // Hungarian
				'id' , // Indonesian
				'is' , // Icelandic
				'it' , // Italian
				'ja' , // Japanese
				'ko' , // Korean
				'my' , // Burmese 
				'nl' , // Dutch
				'no' , // Norwegian
				'pl' , // Polish
				'pt-BR' , // Brazilian Portuguese
				'pt-PT' , // Portuguese
				'ro' , // Romanian
				'ru' , // Rusian
				'sk' , // Slovak
				'sv' , // Swedish
				'tr' , // Turkish
				'zh-CN' , // Chinese (Simplified)
				'zh-TW'  // Chinese (Traditional)
				);
		return $languages;
	}

	/**
	 * Try to set Shadowbox language based on defined language for WordPress
	 *
	 * @since 2.0.3.3
	 * @return string
	 */
	function set_lang () {
		if ( defined ( 'WPLANG' ) )
			$wp_lang = WPLANG;
		else
			$wp_lang = 'en';
	
		switch ( $wp_lang ) {
			case 'ar':
				$lang = 'ar'; // Arabic
				break;
			case 'bg_BG':
				$lang = 'bg'; // Bulgarian
				break;
			case 'ca':
				$lang = 'ca'; // Catalan
				break;
			case 'cs_CZ':
				$lang = 'cs'; // Czech
				break;
			case 'de_DE':
				$lang = 'de-DE'; // German
				break;
			case 'es_ES':
				$lang = 'es'; // Spanish
				break;
			case 'et':
				$lang = 'et'; // Estonian
				break;
			case 'fi':
			case 'fi_FI':
				$lang = 'fi'; // Finnish
				break;
			case 'fr_BE':
			case 'fr_FR':
				$lang = 'fr'; // French
				break;
			case 'gl_ES':
				$lang = 'gl'; // Galician
				break;
			case 'he_IL':
				$lang = 'he'; // Hebrew
				break;
			case 'hu_HU':
				$lang = 'hu'; // Hungarian
				break;
			case 'id_ID':
				$lang = 'id'; // Indonesian
				break;
			case 'is_IS':
				$lang = 'is'; // Icelandic
				break;
			case 'it_IT':
				$lang = 'it'; // Italian
				break;
			case 'ja':
				$lang = 'ja'; // Japanese
				break;
			case 'ko_KR':
				$lang = 'ko'; // Korean
				break;
			case 'my_MM':
				$lang = 'my'; // Burmese
				break;
			case 'nl':
				$lang = 'nl'; // Dutch
				break;
			case 'nn_NO':
				$lang = 'no'; // Norwegian
				break;
			case 'pl_PL':
				$lang = 'pl'; // Polish
				break;
			case 'pt_BR':
				$lang = 'pt-BR'; // Brazilian Portuguese
				break;
			case 'pt_PT':
				$lang = 'pt-PT'; // Portuguese
				break;
			case 'ro':
				$lang = 'ro'; // Romanian
				break;
			case 'ru_RU':
			case 'ru_UA':
				$lang = 'ru'; // Rusian
				break;
			case 'sk':
				$lang = 'sk'; // Slovak
				break;
			case 'sv_SE':
				$lang = 'sv'; // Swedish
				break;
			case 'tr':
				$lang = 'tr'; // Turkish
				break;
			case 'zh_CN':
				$lang = 'zh-CN'; // Chinese (Simplified)
				break;
			default:
				$lang = 'en'; // English
				break;
		}
		return $lang;
	}

	/**
	 * Return the default list of enabled players available with Shadowbox
	 *
	 * @return array
	 * @since 3.0.0.0
	 */
	function players () {
		$players = array (
				'html' ,
				'iframe' , 
				'img' ,
				'qt' ,
				'swf' ,
				'wmp'
				);
		return $players;
	}

	/**
	 * Return the default options
	 *
	 * @return array
	 * @since 2.0.3
	 */
	function defaults () {
		$defaults = array (
				'version'			=>	$this->version ,
				'library'			=>	'base' ,
				'language'			=>	$this->set_lang () ,
				'smartLoad'			=>	'false' ,
				'autoimg'			=>	'true' ,
				'automov'			=>	'true' ,
				'autotube'			=>	'true' ,
				'autoaud'			=>	'true' ,
				'enableFlv'			=>	'false' ,
				'tubeWidth'			=>	640 ,
				'tubeHeight'		=>	385 ,
				'autoDimensions'	=>	'false' ,
				'animateFade'		=>	'true' ,
				'animate'			=>	'true' ,
				'animSequence'		=>	'sync' ,
				'autoplayMovies'	=>	'true' ,
				'continuous'		=>	'false' ,
				'counterLimit'		=>	10 ,
				'counterType'		=>	'default' ,
				'displayCounter'	=>	'true' ,
				'displayNav'		=>	'true' ,
				'enableKeys'		=>	'true' ,
				'fadeDuration'		=>	0.35 ,
				'flashBgColor'		=>	'#000000' ,
				'flashParams'		=>	'{bgcolor:"#000000", allowFullScreen:true}' ,
				'flashVars'			=>	'{}' ,
				'flashVersion'		=>	'9.0.0' ,
				'handleOversize'	=>	'resize' ,
				'handleUnsupported'	=>	'link' ,
				'initialHeight'		=>	160 ,
				'initialWidth'		=>	320 ,
				'modal'				=>	'false' ,
				'overlayColor'		=>	'#000' ,
				'overlayOpacity'	=>	0.8 ,
				'players'			=>	$this->players () ,
				'resizeDuration'	=>	0.35 ,
				'showMovieControls'	=>	'true' ,
				'showOverlay'		=>	'true' ,
				'skipSetup'			=>	'false' ,
				'slideshowDelay'	=>	0 ,
				'viewportPadding'	=>	20
				);
		return $defaults;
	}

	/**
	 * Initialize the default options during plugin activation
	 *
	 * @return none
	 * @since 2.0.3
	 */
	function init () {
		if ( ! get_option ( 'shadowbox' ) )
			add_option ( 'shadowbox' , $this->defaults () );
		else
			$this->check_upgrade ();
	}

	/**
	 * Check if an upgraded is needed
	 *
	 * @return none
	 * @since 3.0.0.1
	 */
	function check_upgrade () {
		if ( version_compare ( $this->get_option ( 'version' ) , '3.0.0.0' , '<' ) )
			$this->upgrade ( '3.0.0.0' );
	}

	/**
	 * Upgrade options 
	 *
	 * @return none
	 * @since 3.0.0.0
	 */
	function upgrade ( $ver ) {
		if ( $ver == '3.0.0.0' ) {
			$shadowbox = get_option ( 'shadowbox' );
			$newopts = array (
					'version'			=>	$this->version ,
					'smartLoad'			=>	'false' ,
					'enableFlv'			=>	'false' ,
					'tubeWidth'			=>	640 ,
					'tubeHeight'		=>	385 ,
					'players'			=>	$this->players () ,
					'autoDimensions'	=>	'false' ,
					'showOverlay'		=>	'true' ,
					'skipSetup'			=>	'false' ,
					'flashParams'		=>	'{bgcolor:"#000000", allowFullScreen:true}' , 
					'flashVars'			=>	'{}' ,
					'flashVersion'		=>	'9.0.0'
					);
			unset ( $shadowbox['ie8hack'] , $shadowbox['skin'] );
			update_option ( 'shadowbox' , array_merge ( $shadowbox , $newopts ) );
		}
	}

	/**
	 * Update/validate the options in the options table from the POST
	 *
	 * @since 3.0.0.1
	 * @return none
	 */
	function update ( $options ) {
		if ( isset ( $options['delete'] ) && $options['delete'] == 'true' ) {
			delete_option ( 'shadowbox' );
		} else if ( isset ( $options['default'] ) && $options['default'] == 'true' ) {
			return $this->defaults ();
		} else {
			unset ( $options['delete'] , $options['default'] );
			return $options;
		}
	}

	/**
	 * Add the options page
	 *
	 * @return none
	 * @since 2.0.3
	 */
	function add_page () {
		if ( current_user_can ( 'manage_options' ) && function_exists ( 'add_options_page' ) ) {
			$this->options_page_hookname = add_options_page ( 'Shadowbox JS' , 'Shadowbox JS' , 'manage_options' , 'shadowbox-js' , array ( &$this , 'admin_page' ) );
			add_action ( "admin_print_scripts-{$this->options_page_hookname}" , array ( &$this , 'admin_js' ) );
			add_filter ( "plugin_action_links_{$this->plugin_basename}" , array ( &$this , 'filter_plugin_actions' ) );
		}
	}

	/**
	 * Add a settings link to the plugin actions
	 *
	 * @param array $links Array of the plugin action links
	 * @return array
	 * @since 2.0.3
	 */
	function filter_plugin_actions ( $links ) { 
		$settings_link = '<a href="options-general.php?page=shadowbox-js">' . __( 'Settings' ) . '</a>'; 
		array_unshift ( $links, $settings_link ); 
		return $links;
	}

	/**
	 * Retrieves a changelog and outputs it into the upgrade notice
	 *
	 * @since 3.0.0.1
	 * @return none
	 */
	function changelog () {
		$url = "{$this->repos_url}/tags/{$this->version}/upgrade.html";
		$response = wp_remote_get ( $url );
		$code = (int) wp_remote_retrieve_response_code ( $response );
		if ( $code == 200 ) {
			$body = wp_remote_retrieve_body ( $response );
			echo "\n<p class='upgrade'>\n$body\n</p>\n";
		}
	}

	/**
	 * Output the options page
	 *
	 * @return none
	 * @since 2.0.3
	 */
	function admin_page () {
		?>
		<div class="wrap">
			<h2><?php _e( 'Shadowbox JS' ); ?></h2>
			<form action="options.php" method="post">
				<?php settings_fields('shadowbox'); ?>
				<?php if ( ! empty ( $this->options ) ) : // Start option check. Don't show most of the form if there are no options in the db ?>
				<?php if ( ! function_exists ( 'wp_enqueue_scripts' ) ) : ?>
					<input type="hidden" name="shadowbox[smartLoad]" value="false" />
				<?php endif; ?>
				<h3>General</h3>
				<p><?php _e( 'These are general options for the Shadowbox Javascript that tell Shadowbox how to run, how to look and what language to use.' ); ?></p>
				<table class="form-table">
					<tr valign="top">
						<th scope="row">
							<?php _e( 'Javascript Library' ); ?>
						</th>
						<td>
							<select name="shadowbox[library]">
								<option value="base"<?php selected ( 'base' , $this->get_option ( 'library' ) ); ?>><?php _e( 'None' ); ?></option>
								<option value="yui"<?php selected ( 'yui' , $this->get_option ( 'library' ) ); ?>>YUI</option>
								<option value="prototype"<?php selected ( 'prototype' , $this->get_option ( 'library' ) ); ?>>Prototype</option>
								<option value="jquery"<?php selected ( 'jquery' , $this->get_option ( 'library' ) ); ?>>jQuery</option>
								<option value="ext"<?php selected ( 'ext' , $this->get_option ( 'library' ) ); ?>>Ext</option>
								<option value="dojo"<?php selected ( 'dojo' , $this->get_option ( 'library' ) ); ?>>Dojo</option>
								<option value="mootools"<?php selected ( 'mootools' , $this->get_option ( 'library' ) ); ?>>Mootools</option>
							</select>
							<br />
							<?php _e( 'Default is None.' ); ?>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<?php _e( 'Language' ); ?>
						</th>
						<td>
							<select name="shadowbox[language]">
		<?php foreach ( $this->languages () as $language ) : ?>
								<option value="<?php echo $language; ?>"<?php selected ( $language , $this->get_option ( 'language' ) ); ?>><?php echo $language; ?></option>
		<?php endforeach; ?>
		<?php unset ( $language ); ?>
							</select>
							<br />
							<?php _e( 'Default is en.' ); ?>
						</td>
					</tr>
					<?php if ( function_exists ( 'wp_enqueue_scripts' ) ) : ?>
						<tr valign="top">
							<th scope="row">
								<?php _e( 'Enable Smart Loading' ); ?>
							</th>
							<td>
								<select name="shadowbox[smartLoad]">
									<option value="true"<?php selected ( 'true' , $this->get_option ( 'smartLoad' ) ); ?>><?php _e( 'true' ); ?></option>
									<option value="false"<?php selected ( 'false' , $this->get_option ( 'smartLoad' ) ); ?>><?php _e( 'false' ); ?></option>
								</select>
								<br />
								<?php _e( 'Enabling this will only load Shadowbox and its dependencies when needed based on the content of your posts.	Please note that when enabling this Shadowbox will not be loaded if rel="shadowbox" is not found in the content of your post(s).  If you experience problems after enabling this, try disabling. Default is false.' ); ?>
							</td>
						</tr>
					<?php endif; ?>
					<tr valign="top">
						<th scope="row">
							<?php _e( 'Players' ); ?>
						</th>
						<td>
							<?php if ( $this->get_option ( 'enableFlv' ) == 'true' ) : ?>
								<p><input type="checkbox" name="shadowbox[players][]" value="flv"<?php checked ( true , in_array ( 'flv' , $this->get_option ( 'players' ) ) ); ?>/>FLV</p>
							<?php endif; ?>
							<p><input type="checkbox" name="shadowbox[players][]" value="html"<?php checked ( true , in_array ( 'html' , $this->get_option ( 'players' ) ) ); ?>/>HTML</p>
							<p><input type="checkbox" name="shadowbox[players][]" value="iframe"<?php checked ( true , in_array ( 'iframe' , $this->get_option ( 'players' ) ) ); ?>/>IFRAME</p>
							<p><input type="checkbox" name="shadowbox[players][]" value="img"<?php checked ( true , in_array ( 'img' , $this->get_option ( 'players' ) ) ); ?>/>IMG</p>
							<p><input type="checkbox" name="shadowbox[players][]" value="qt"<?php checked ( true , in_array ( 'qt' , $this->get_option ( 'players' ) ) ); ?>/>QT</p>
							<p><input type="checkbox" name="shadowbox[players][]" value="swf"<?php checked ( true , in_array ( 'swf' , $this->get_option ( 'players' ) ) ); ?>/> SWF</p>
							<p><input type="checkbox" name="shadowbox[players][]" value="wmp"<?php checked ( true , in_array ( 'wmp' , $this->get_option ( 'players' ) ) ); ?>/> WMP</p>
							<?php _e( 'The list of enabled or disabled players. Default is HTML, IFRAME, IMG, QT, SWF and WMP.' ); ?>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<?php _e( 'Enable FLV Support' ); ?>
						</th>
						<td>
							<select id="enableFlv" name="shadowbox[enableFlv]">
								<option value="true"<?php selected ( 'true' , $this->get_option ( 'enableFlv' ) ); ?>><?php _e( 'true' ); ?></option>
								<option value="false"<?php selected ( 'false' , $this->get_option ( 'enableFlv' ) ); ?>><?php _e( 'false' ); ?></option>
							</select>
							<br />
							<?php _e( 'By enabling FLV support you are agreeing to the the <a href="http://creativecommons.org/licenses/by-nc-sa/3.0/">noncommercial license</a> used by JW FLV Media Player. The JW FLV Media Player is licensed under the terms of the <a href="http://creativecommons.org/licenses/by-nc-sa/3.0/">Creative Commons Attribution-Noncommercial-Share Alike 3.0 Unported License</a>. After enabling FLV support you will need to select FLV from the list of players above. Default is false.' ); ?>
						</td>
					</tr>
				</table>
				<h3 id="sbadvancedtitle"><?php _e( 'Advanced Configuration' ); ?></h3>
				<p><input id="sbadvancedbtn" type="button" class="button" value="<?php _e( 'Show Advanced Configuration' ); ?>" style="display:none; font-weight: bold; width: 216px;"/></p>
				<table id="sbadvanced" class="form-table">
					<tr valign="top">
						<th scope="row">
							<?php _e( 'Animate' ); ?>
						</th>
						<td>
							<select name="shadowbox[animate]">
								<option value="true"<?php selected ( 'true' , $this->get_option ( 'animate' ) ); ?>><?php _e( 'true' ); ?></option>
								<option value="false"<?php selected ( 'false' , $this->get_option ( 'animate' ) ); ?>><?php _e( 'false' ); ?></option>
							</select>
							<br />
							<?php _e( 'Set this false to disable all fancy animations (except fades). This can improve the overall effect on computers with poor performance. Defaults to true.' ); ?>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<?php _e( 'Fade Animations' ); ?>
						</th>
						<td>
							<select name="shadowbox[animateFade]">
								<option value="true"<?php selected ( 'true' , $this->get_option ( 'animateFade' ) ); ?>><?php _e( 'true' ); ?></option>
								<option value="false"<?php selected ( 'false' , $this->get_option ( 'animateFade' ) ); ?>><?php _e( 'false' ); ?></option>
							</select>
							<br />
							<?php _e( 'Set this false to disable all fading animations. Defaults to true.' ); ?>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<?php _e( 'Animation Sequence' ); ?>
						</th>
						<td>
							<select name="shadowbox[animSequence]">
								<option value="wh"<?php selected ( 'wh' , $this->get_option ( 'animSequence' ) ); ?>>wh</option>
								<option value="hw"<?php selected ( 'hw' , $this->get_option ( 'animSequence' ) ); ?>>hw</option>
								<option value="sync"<?php selected ( 'sync' , $this->get_option ( 'animSequence' ) ); ?>>sync</option>
							</select>
							<br />
							<?php _e( 'The animation sequence to use when resizing Shadowbox. May be either "wh" (width first, then height), "hw" (height first, then width), or "sync" (both simultaneously). Defaults to "sync".' ); ?>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<?php _e( 'Modal' ); ?>
						</th>
						<td>
							<select name="shadowbox[modal]">
								<option value="true"<?php selected ( 'true' , $this->get_option ( 'modal' ) ); ?>><?php _e( 'true' ); ?></option>
								<option value="false"<?php selected ( 'false' , $this->get_option ( 'modal' ) ); ?>><?php _e( 'false' ); ?></option>
							</select>
							<br />
							<?php _e( 'Set this true to disable listening for mouse clicks on the overlay that will close Shadowbox. Defaults to false.' ); ?>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<?php _e( 'Show Overlay' ); ?>
						</th>
						<td>
							<select name="shadowbox[showOverlay]">
								<option value="true"<?php selected ( 'true' , $this->get_option ( 'showOverlay' ) ); ?>><?php _e( 'true' ); ?></option>
								<option value="false"<?php selected ( 'false' , $this->get_option ( 'showOverlay' ) ); ?>><?php _e( 'false' ); ?></option>
							</select>
							<br />
							<?php _e( 'Set this false to disable showing the overlay. Defaults to true.' ); ?>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<?php _e( 'Overlay Color' ); ?>
						</th>
						<td>
							<input type="text" name="shadowbox[overlayColor]" value="<?php echo $this->get_option ( 'overlayColor' ); ?>" size="7" />
							<br />
							<?php _e( 'The color to use for the modal overlay (in hex). Defaults to "#000".' ); ?>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<?php _e( 'Overlay Opacity' ); ?>
						</th>
						<td>
							<input type="text" name="shadowbox[overlayOpacity]" value="<?php echo $this->get_option ( 'overlayOpacity' ); ?>" size="4" />
							<br />
							<?php _e( 'The opacity to use for the modal overlay. Defaults to 0.8.' ); ?>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<?php _e( 'Flash Background Color' ); ?>
						</th>
						<td>
							<input type="text" name="shadowbox[flashBgColor]" value="<?php echo $this->get_option ( 'flashBgColor' ); ?>" size="7" />
							<br />
							<?php _e( 'The default background color to use for Flash movies. Defaults to "#000000".' ); ?>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<?php _e( 'Auto-Play Movies' ); ?>
						</th>
						<td>
							<select name="shadowbox[autoplayMovies]">
								<option value="true"<?php selected ( 'true' , $this->get_option ( 'autoplayMovies' ) ); ?>><?php _e( 'true' ); ?></option>
								<option value="false"<?php selected ( 'false' , $this->get_option ( 'autoplayMovies' ) ); ?>><?php _e( 'false' ); ?></option>
							</select>
							<br />
							<?php _e( 'Set this false to disable automatically playing movies when they are loaded. Defaults to true.' ); ?>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<?php _e( 'Show Movie Controls' ); ?>
						</th>
						<td>
							<select name="shadowbox[showMovieControls]">
								<option value="true"<?php selected ( 'true' , $this->get_option ( 'showMovieControls' ) ); ?>><?php _e( 'true' ); ?></option>
								<option value="false"<?php selected ( 'false' , $this->get_option ( 'showMovieControls' ) ); ?>><?php _e( 'false' ); ?></option>
							</select>
							<br />
							<?php _e( 'Set this false to disable displaying QuickTime and Windows Media player movie control bars. Defaults to true.' ); ?>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<?php _e( 'Slideshow Delay' ); ?>
						</th>
						<td>
							<input type="text" name="shadowbox[slideshowDelay]" value="<?php echo $this->get_option ( 'slideshowDelay' ); ?>" size="2" style="width: 1.5em;" />
							<br />
							<?php _e( 'A delay (in seconds) to use for slideshows. If set to anything other than 0, this value determines an interval at which Shadowbox will automatically proceed to the next piece in the gallery. Defaults to 0.' ); ?>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<?php _e( 'Resize Duration' ); ?>
						</th>
						<td>
							<input type="text" name="shadowbox[resizeDuration]" value="<?php echo $this->get_option ( 'resizeDuration' ); ?>" size="4" />
							<br />
							<?php _e( 'The duration (in seconds) of the resizing animations. Defaults to 0.55.' ); ?>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<?php _e( 'Fade Duration' ); ?>
						</th>
						<td>
							<input type="text" name="shadowbox[fadeDuration]" value="<?php echo $this->get_option ( 'fadeDuration' ); ?>" size="4" />
							<br />
							<?php _e( 'The duration (in seconds) of the fade animations. Defaults to 0.35.' ); ?>
						</td>
					</tr>				
					<tr valign="top">
						<th scope="row">
							<?php _e( 'Display Navigation' ); ?>
						</th> 
						<td>
							<select name="shadowbox[displayNav]">
								<option value="true"<?php selected ( 'true' , $this->get_option ( 'displayNav' ) ); ?>><?php _e( 'true' ); ?></option>
								<option value="false"<?php selected ( 'false' , $this->get_option ( 'displayNav' ) ); ?>><?php _e( 'false' ); ?></option>
							</select>
							<br />
							<?php _e( 'Set this false to hide the gallery navigation controls. Defaults to true.' ); ?>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<?php _e( 'Continuous' ); ?>
						</th> 
						<td>
							<select name="shadowbox[continuous]">
								<option value="true"<?php selected ( 'true' , $this->get_option ( 'continuous' ) ); ?>><?php _e( 'true' ); ?></option>
								<option value="false"<?php selected ( 'false' , $this->get_option ( 'continuous' ) ); ?>><?php _e( 'false' ); ?></option>
							</select>
							<br />
							<?php _e( 'Set this true to enable "continuous" galleries. By default, the galleries will not let a user go before the first image or after the last. Enabling this feature will let the user go directly to the first image in a gallery from the last one by selecting "Next". Defaults to false.' ); ?>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<?php _e( 'Display Counter' ); ?>
						</th>
						<td>
							<select name="shadowbox[displayCounter]">
								<option value="true"<?php selected ( 'true' , $this->get_option ( 'displayCounter' ) ); ?>><?php _e( 'true' ); ?></option>
								<option value="false"<?php selected ( 'false' , $this->get_option ( 'displayCounter' ) ); ?>><?php _e( 'false' ); ?></option>
							</select>
							<br />
							<?php _e( 'Set this false to hide the gallery counter. Counters are never displayed on elements that are not part of a gallery. Defaults to true.' ); ?>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<?php _e( 'Counter Type' ); ?>
						</th>
						<td>
							<select name="shadowbox[counterType]">
								<option value="default"<?php selected ( 'default' , $this->get_option ( 'counterType' ) ); ?>><?php _e( 'default' ); ?></option>
								<option value="skip"<?php selected ( 'skip' , $this->get_option ( 'counterType' ) ); ?>><?php _e( 'skip' ); ?></option>
							</select>
							<br />
							<?php _e( 'The mode to use for the gallery counter. May be either "default" or "skip". The default counter is a simple "1 of 5" message. The skip counter displays a separate link to each piece in the gallery, enabling quick navigation in large galleries. Defaults to "default".' ); ?>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<?php _e( 'Counter Limit' ); ?>
						</th>
						<td>
							<input type="text" name="shadowbox[counterLimit]" value="<?php echo $this->get_option ( 'counterLimit' ); ?>" size="3" />
							<br />
							<?php _e( 'Limits the number of counter links that will be displayed in a "skip" style counter. If the actual number of gallery elements is greater than this value, the counter will be restrained to the elements immediately preceding and following the current element. Defaults to 10.' ); ?>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<?php _e( 'Viewport Padding' ); ?>
						</th>
						<td>
							<input type="text" name="shadowbox[viewportPadding]" value="<?php echo $this->get_option ( 'viewportPadding' ); ?>" size="3" />
							<br />
							<?php _e( 'The amount of padding (in pixels) to maintain around the edge of the browser window. Defaults to 20.' ); ?>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<?php _e( 'Handle Oversize' ); ?>
						</th>
						<td>
							<select name="shadowbox[handleOversize]">
								<option value="none"<?php selected ( 'none' , $this->get_option ( 'handleOversize' ) ); ?>><?php _e( 'none' ); ?></option>
								<option value="resize"<?php selected ( 'resize' , $this->get_option ( 'handleOversize' ) ); ?>><?php _e( 'resize' ); ?></option>
								<option value="drag"<?php selected ( 'drag' , $this->get_option ( 'handleOversize' ) ); ?>><?php _e( 'drag' ); ?></option>
							</select>
							<br />
							<?php _e( 'The mode to use for handling content that is too large for the viewport. May be one of "none", "resize", or "drag" (for images). The "none" setting will not alter the image dimensions, though clipping may occur. Setting this to "resize" enables on-the-fly resizing of large content. In this mode, the height and width of large, resizable content will be adjusted so that it may still be viewed in its entirety while maintaining its original aspect ratio. The "drag" mode will display an oversized image at its original resolution, but will allow the user to drag it within the view to see portions that may be clipped. Defaults to "resize".' ); ?>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<?php _e( 'Handle Unsupported' ); ?>
						</th>
						<td>
							<select name="shadowbox[handleUnsupported]">
								<option value="link"<?php selected ( 'link' , $this->get_option ( 'handleUnsupported' ) ); ?>><?php _e( 'link' ); ?></option>
								<option value="remove"<?php selected ( 'remove' , $this->get_option ( 'handleUnsupported' ) ); ?>><?php _e( 'remove' ); ?></option>
							</select>
							<br />
							<?php _e( 'The mode to use for handling unsupported media. May be either "link" or "remove". Media are unsupported when the browser plugin required to display the media properly is not installed. The link option will display a user-friendly error message with a link to a page where the needed plugin can be downloaded. The remove option will simply remove any unsupported gallery elements from the gallery before displaying it. With this option, if the element is not part of a gallery, the link will simply be followed. Defaults to "link".' ); ?>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<?php _e( 'Auto Dimensions' ); ?>
						</th>
						<td>
							<select name="shadowbox[autoDimensions]">
								<option value="true"<?php selected ( 'true' , $this->get_option ( 'autoDimensions' ) ); ?>><?php _e( 'true' ); ?></option>
								<option value="false"<?php selected ( 'false' , $this->get_option ( 'autoDimensions' ) ); ?>><?php _e( 'false' ); ?></option>
							</select>
							<br />
							<?php _e( 'Set this true to automatically set the initialHeight and initialWidth automatically from the configured object\'s height and width. Defaults to false.' ); ?>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<?php _e( 'Initial Height' ); ?>
						</th>
						<td>
							<input type="text" name="shadowbox[initialHeight]" value="<?php echo $this->get_option ( 'initialHeight' ); ?>" size="3" />
							<br />
							<?php _e( 'The height of Shadowbox (in pixels) when it first appears on the screen. Defaults to 160.' ); ?>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<?php _e( 'Initial Width' ); ?>
						</th> 
						<td>
							<input type="text" name="shadowbox[initialWidth]" value="<?php echo $this->get_option ( 'initialWidth' ); ?>" size="3" />
							<br />
							<?php _e( 'The width of Shadowbox (in pixels) when it first appears on the screen. Defaults to 320.' ); ?>
						</td>
					</tr>				
					<tr valign="top">
						<th scope="row">
							<?php _e( 'Enable Keys' ); ?>
						</th> 
						<td>
							<select name="shadowbox[enableKeys]">
								<option value="true"<?php selected ( 'true' , $this->get_option ( 'enableKeys' ) ); ?>><?php _e( 'true' ); ?></option>
								<option value="false"<?php selected ( 'false' , $this->get_option ( 'enableKeys' ) ); ?>><?php _e( 'false' ); ?></option>
							</select>
							<br />
							<?php _e( 'Set this false to disable keyboard navigation of galleries. Defaults to true.' ); ?>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<?php _e( 'Skip Setup' ); ?>
						</th>
						<td>
							<select name="shadowbox[skipSetup]">
								<option value="true"<?php selected ( 'true' , $this->get_option ( 'skipSetup' ) ); ?>><?php _e( 'true' ); ?></option>
								<option value="false"<?php selected ( 'false' , $this->get_option ( 'skipSetup' ) ); ?>><?php _e( 'false' ); ?></option>
							</select>
							<br />
							<?php _e( 'Set this true to skip Shadowbox.setup() during Shadowbox.init(). Defaults to false.' ); ?>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<?php _e( 'Flash Params' ); ?>
						</th>
						<td>
							<textarea name="shadowbox[flashParams]" rows="10" cols="50"><?php echo $this->get_option ( 'flashParams' ); ?></textarea>
							<br />
							<?php _e( 'A list of parameters (in a JavaScript object) that will be passed to a flash &lt;object&gt;. For a partial list of available parameters, see <a href="http://kb.adobe.com/selfservice/viewContent.do?externalId=tn_12701">this page</a>. Only one parameter is specified by default: bgcolor. Defaults to {bgcolor:"#000000", allowFullScreen:true}.' ); ?>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<?php _e( 'Flash Vars' ); ?>
						</th>
						<td>
							<textarea name="shadowbox[flashVars]" rows="10" cols="50"><?php echo $this->get_option ( 'flashVars' ); ?></textarea>
							<br />
							<?php _e( 'A list of variables (in a JavaScript object) that will be passed to a flash movie as <a href="http://kb.adobe.com/selfservice/viewContent.do?externalId=tn_16417">FlashVars</a>. Defaults to {}.' ); ?>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<?php _e( 'Flash Version' ); ?>
						</th>
						<td>
							<input type="text" name="shadowbox[flashVersion]" value="<?php echo $this->get_option ( 'flashVersion' ); ?>" size="5" />
							<br />
							<?php _e( 'The minimum Flash version required to play a flash movie (as a string). Defaults to "9.0.0".' ); ?>
						</td>
					</tr>
				</table>
				<h3><?php _e( 'Shadowbox Automation' ); ?></h3>
				<p><?php _e( 'These options will give you the capability to have Shadowbox automatically used for all of a certain file type.' ); ?></p>
				<table class="form-table">
					<tr valign="top">
						<th scope="row">
							<acronym title="bmp, gif, png, jpg, and jpeg"><?php _e( 'Image Links' ); ?></acronym>
						</th>
						<td>
							<select name="shadowbox[autoimg]">
								<option value="true"<?php selected ( 'true' , $this->get_option ( 'autoimg' ) ); ?>><?php _e( 'true' ); ?></option>
								<option value="false"<?php selected ( 'false' , $this->get_option ( 'autoimg' ) ); ?>><?php _e( 'false' ); ?></option>
							</select>
							<br />
							<?php _e( 'Default is true.' ); ?>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<acronym title="swf, flv, f4v, dv, mov, moov, movie, mp4, asf, wm, wmv, avi, mpg and mpeg"><?php _e( 'Movie Links' ); ?></acronym>
						</th>
						<td>
							<select name="shadowbox[autotube]">
								<option value="true"<?php selected ( 'true' , $this->get_option ( 'autotube' ) ); ?>><?php _e( 'true' ); ?></option>
								<option value="false"<?php selected ( 'false' , $this->get_option ( 'autotube' ) ); ?>><?php _e( 'false' ); ?></option>
							</select>
							<br />
							<?php _e( 'Default is true.' ); ?>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<acronym title="mp3, aac"><?php _e( 'Music Links' ); ?></acronym>
						</th>
						<td>
							<select name="shadowbox[autoaud]">
								<option value="true"<?php selected ( 'true' , $this->get_option ( 'autoaud' ) ); ?>><?php _e( 'true' ); ?></option>
								<option value="false"<?php selected ( 'false' , $this->get_option ( 'autoaud' ) ); ?>><?php _e( 'false' ); ?></option>
							</select>
							<br />
							<?php _e( 'Default is true.' ); ?>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<?php _e( 'YouTube and Google Video Links' ); ?>
						</th>
						<td>
							<select name="shadowbox[automov]">
								<option value="true"<?php selected ( 'true' , $this->get_option ( 'automov' ) ); ?>><?php _e( 'true' ); ?></option>
								<option value="false"<?php selected ( 'false' , $this->get_option ( 'automov' ) ); ?>><?php _e( 'false' ); ?></option>
							</select>
							<br />
							<?php _e( 'Default is true.' ); ?>
						</td>
					</tr>
				</table>
				<h3><?php _e( 'Sizes' ); ?></h3>
				<table class="form-table">
					<tr valign="top">
						<th scope="row">
							<?php _e( 'YouTube / Google Video Width' ); ?>
						</th>
						<td>
							<input type="text" name="shadowbox[tubeWidth]" value="<?php echo $this->get_option ( 'tubeWidth' ); ?>" size="3" />
							<br />
							<?php _e( 'The width of Shadowbox (in pixels) when displaying YouTube or Google Video. Defaults to 640.' ); ?>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<?php _e( 'YouTube / Google Video Height' ); ?>
						</th>
						<td>
							<input type="text" name="shadowbox[tubeHeight]" value="<?php echo $this->get_option ( 'tubeHeight' ); ?>" size="3" />
							<br />
							<?php _e( 'The height of Shadowbox (in pixels) when when displaying YouTube of Google Video. Defaults to 385.' ); ?>
						</td>
					</tr>
				</table>
				<?php else : // Else option check. Display this if there are no options in the DB ?>
					<div id="error" class="error"><p><strong><?php _e( 'The settings for this plugin have been deleted. The plugin can now be' ); ?> <a href="<?php echo wp_nonce_url ( 'plugins.php?action=deactivate&amp;plugin=' . $this->plugin_basename , 'deactivate-plugin_' . $this->plugin_basename ); ?>" title="<?php _e( 'Deactivate Shadowbox JS' ); ?>" style="border-bottom: none;"><?php _e( 'deactivated' ); ?></a>. <?php _e( 'If you want to create the settings with their defaults so this plugin can be used again, set "Reset to Defaults" to "true" and click "Save Changes"' ); ?>.</strong></p></div>
				<?php endif; // End Option Check ?>
				<h3><?php _e( 'Resets' ); ?></h3>
				<p><?php _e( 'These options will allow you to revert the options back to their defaults or to remove the options from the database for a clean uninstall.' ); ?></p>
				<table class="form-table">
					<tr valign="top">
						<th scope="row">
							<?php _e( 'Reset to Defaults' ); ?>
						</th>
						<td>
							<select name="shadowbox[default]">
								<option value="false" selected="selected"><?php _e( 'false' ); ?></option>
								<option value="true"><?php _e( 'true' ); ?></option>
							</select>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<?php _e( 'Delete Options for a Clean Uninstall' ); ?>
						</th>
						<td>
							<select name="shadowbox[delete]">
								<option value="false" selected="selected"><?php _e( 'false' ); ?></option>
								<option value="true"><?php _e( 'true' ); ?></option>
							</select>
						</td>
					</tr>
				</table>
				<p class="submit">
					<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
				</p>
			</form>
		</div>
	<?php
	}
}

?>
