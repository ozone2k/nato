<?php
/*
Plugin Name: Wordpress Multibox PlugIn
Plugin URI: http://www.rutschmann.biz/php-mysql-javascript-und-ajax/multibox-wordpress-plugin
Feed URI: 
Description: Add the wordpress multibox plugin to your blog. For more Information visit the <a href="http://www.rutschmann.biz/php-mysql-javascript-und-ajax/multibox-wordpress-plugin">Wordpress Multibox Plugin Site</a>
Version: 1.3.8
Author: Manfred Rutschmann
Author URI: http://www.rutschmann.biz
*/


####### Multibox install section
$version = '1.3.5';
register_activation_hook(__FILE__,'wmp_install');

function wmp_install () {
	get_option('wmp_automatic')==' ' ? update_option( 'wmp_automatic', '1' ) : $wmp_automatic;
	get_option('wmp_regex')=='' ? update_option( 'wmp_regex', 'jpg,jpeg,png,gif,bmp,ico,mp3,wmv,mov,flv,rv,rm,rmvb,swf' ) : $wmp_regex;
	get_option('wmp_moo12')==' ' ? update_option( 'wmp_moo12', '1' ) : $wmp_moo12;
	get_option('wmp_classname')=='' ? update_option( 'wmp_classname', 'wmp' ) : $wmp_classname;
	get_option('wmp_useoverlay')==' ' ? update_option( 'wmp_useoverlay', '1' ) : $wmp_useoverlay;
	get_option('wmp_initialWidth')=='' ? update_option( 'wmp_initialWidth', '150' ) : $wmp_initialWidth;
	get_option('wmp_initialHeight')=='' ? update_option( 'wmp_initialHeight', '150' ) : $wmp_initialHeight;
	get_option('wmp_showNumbers')==' ' ? update_option( 'wmp_showNumbers', '1' ) : $wmp_showNumbers;
	get_option('wmp_showControls')==' ' ? update_option( 'wmp_showControls', '1' ) : $wmp_showControls;
	get_option('wmp_disableDesc')==' ' ? update_option( 'wmp_disableDesc', '0' ) : $wmp_disableDesc;
	get_option('wmp_activatepdf')==' ' ? update_option( 'wmp_activatepdf', '1' ) : $wmp_activatepdf;
	get_option('wmp_pdfwidth')=='' ? update_option( 'wmp_pdfwidth', '900' ) : $wmp_pdfwidth;
	get_option('wmp_pdfheight')=='' ? update_option( 'wmp_pdfheight', '750' ) : $wmp_pdfheight;
	get_option('wmp_slideshow')==' ' ? update_option( 'wmp_slideshow', '1' ) : $wmp_slideshow;
	get_option('wmp_slideshowTime')=='' ? update_option( 'wmp_slideshowTime', '8500' ) : $wmp_slideshowTime;
	get_option('wmp_deactivateHelp')==' ' ? update_option( 'wmp_deactivateHelp', '1' ) : $wmp_deactivateHelp;
	get_option('wmp_useDesign')==' ' ? update_option( 'wmp_useDesign', '1' ) : $wmp_useDesign;
	get_option('wmp_uDBorderColor')=='' ? update_option( 'wmp_uDBorderColor', '#000000' ) : $wmp_uDBorderColor;
	get_option('wmp_uDBorderWith')=='' ? update_option( 'wmp_uDBorderWith', '20' ) : $wmp_uDBorderWith;
	get_option('wmp_uDBorderRadius')=='' ? update_option( 'wmp_uDBorderRadius', '0' ) : $wmp_uDBorderRadius;
	get_option('wmp_uDBorderPadding')=='' ? update_option( 'wmp_uDBorderPadding', '0' ) : $wmp_uDBorderPadding;
	get_option('wmp_uDBackgroundColor')=='' ? update_option( 'wmp_uDBackgroundColor', '#000000' ) : $wmp_uDBackgroundColor;
	get_option('wmp_uDTitleColor')=='' ? update_option( 'wmp_uDTitleColor', '#FFFFFF' ) : $wmp_uDTitleColor;
	get_option('wmp_uDDescColor')=='' ? update_option( 'wmp_uDDescColor', '#FFFFFF' ) : $wmp_uDDescColor;
	get_option('wmp_useOwnIcons')=='' ? update_option( 'wmp_useOwnIcons', 'images' ) : $wmp_useOwnIcons;
	get_option('wmp_uDOverlayBG')=='' ? update_option( 'wmp_uDOverlayBG', '#000000' ) : $wmp_uDOverlayBG;
}

####### Multibox admin section
		
add_action('admin_menu', 'add_OptionPage');

function add_OptionPage() 
{
	$mypage = add_options_page('Multibox', 'Multibox', 8, 'wordpress-multibox-plugin/multibox.php', 'optionsPage');
	add_action( "admin_print_scripts-$mypage", 'add_admin_js' );
}
function add_admin_js() 
{
	$multibox_path = get_option('siteurl')."/wp-content/plugins/wordpress-multibox-plugin/";
	$content='<script src="' . $multibox_path . 'CP/201a.js" type="text/javascript"></script>
	<script type="text/javascript">
	function setColor(inputIn,inputOut) {
		var inputColor = document.getElementById(inputIn).value;
		document.getElementById(inputOut).style.backgroundColor = inputColor;
	}
	</script>
	';
	echo $content;
}

function optionsPage() 
{
	global $_POST;
	$multibox_path = get_option('siteurl')."/wp-content/plugins/wordpress-multibox-plugin/";
	$content.='<div class="wrap">
						<h2>General options for your wordpress multibox plugin</h2><br>
						<div class="updated"><p>
						Have you any questions about the plugin visit my site: <a href="http://www.rutschmann.biz/php-mysql-javascript-und-ajax/multibox-wordpress-plugin">Wordpress Multibox Plugin on rutschmann.biz</a>
						If you like my script and want donate a little bit, click on the paypal botton. Many thanks for your aid. <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
						<input type="hidden" name="cmd" value="_s-xclick">
						<input type="image" src="https://www.paypal.com/de_DE/DE/i/btn/btn_donate_SM.gif" border="0" name="submit" alt="Jetzt einfach, schnell und sicher online bezahlen – mit PayPal.">
						<img alt="" border="0" src="https://www.paypal.com/de_DE/i/scr/pixel.gif" width="1" height="1">
						<input type="hidden" name="encrypted" value="-----BEGIN PKCS7-----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-----END PKCS7-----
						">
						</form>
						</p></div><br>
	';
	if( $_POST['wmp_update'] == 1 ) 
  {
			update_option( 'wmp_automatic', $_POST['wmp_automatic'] );
			update_option( 'wmp_regex', $_POST['wmp_regex'] );
			update_option( 'wmp_classname', $_POST['wmp_classname'] );
			update_option( 'wmp_useoverlay', $_POST['wmp_useoverlay'] );
			update_option( 'wmp_initialWidth', $_POST['wmp_initialWidth'] );
			update_option( 'wmp_initialHeight', $_POST['wmp_initialHeight'] );
			update_option( 'wmp_showNumbers', $_POST['wmp_showNumbers'] );
			update_option( 'wmp_showControls', $_POST['wmp_showControls'] );
			update_option( 'wmp_disableDesc', $_POST['wmp_disableDesc'] );
			update_option( 'wmp_activatepdf', $_POST['wmp_activatepdf'] );
			update_option( 'wmp_pdfwidth', $_POST['wmp_pdfwidth'] );
			update_option( 'wmp_pdfheight', $_POST['wmp_pdfheight'] );
			update_option( 'wmp_moo12', $_POST['wmp_moo12'] );
			update_option( 'wmp_slideshow', $_POST['wmp_slideshow'] );
			update_option( 'wmp_slideshowTime', $_POST['wmp_slideshowTime'] );
			update_option( 'wmp_deactivateHelp', $_POST['wmp_deactivateHelp'] );
			update_option( 'wmp_useDesign', $_POST['wmp_useDesign'] );
			update_option( 'wmp_uDBorderColor', $_POST['wmp_uDBorderColor'] );
			update_option( 'wmp_uDBorderWith', $_POST['wmp_uDBorderWith'] );
			update_option( 'wmp_uDBorderRadius', $_POST['wmp_uDBorderRadius'] );
			update_option( 'wmp_uDBorderPadding', $_POST['wmp_uDBorderPadding'] );
			update_option( 'wmp_uDBackgroundColor', $_POST['wmp_uDBackgroundColor'] );
			update_option( 'wmp_uDTitleColor', $_POST['wmp_uDTitleColor'] );
			update_option( 'wmp_uDDescColor', $_POST['wmp_uDDescColor'] );
			update_option( 'wmp_useOwnIcons', $_POST['wmp_useOwnIcons'] );
			update_option( 'wmp_uDOverlayBG', $_POST['wmp_uDOverlayBG'] );
	 		$content.='<div class="updated"><p><strong>Options saved.</strong></p></div>';
	}
			
		$wmp_automatic = get_option('wmp_automatic');
		$wmp_useoverlay = get_option('wmp_useoverlay');
		$wmp_showNumbers = get_option('wmp_showNumbers');
		$wmp_showControls = get_option('wmp_showControls');
		$wmp_disableDesc = get_option('wmp_disableDesc');
		$wmp_activatepdf = get_option('wmp_activatepdf');
		$wmp_moo12 = get_option('wmp_moo12');
 		$wmp_slideshow = get_option('wmp_slideshow');
		$wmp_deactivateHelp = get_option('wmp_deactivateHelp');
		$wmp_useDesign = get_option('wmp_useDesign');

		$content.='
			<br>
			<form name="form1" method="post" action="'. str_replace( '%7E', '~', $_SERVER['REQUEST_URI']).'">
				<input type="hidden" name="wmp_update" value="1">
				
				<h3>General Options</h3><br>

				<div style="padding: 10px; margin: 0 0 10px 0; background: #EAF3FA;">
						<label style="width: 275px; display: block; float:left; margin-right:10px;" for="wmp_automatic">Automatic Mode:</label>
						';
						$wmp_automatic==1 ? $content.='<input style="float: left;" type="checkbox" name="wmp_automatic" id="wmp_automatic" value="1" checked>' : $content.='<input style="float: left;" type="checkbox" name="wmp_automatic" id="wmp_automatic" value="1">';
						$content.='
						<div style="clear: both"></div>
				</div>

				<div style="padding: 10px; margin: 0 0 10px 0; background: #EAF3FA;">
						<label style="width: 275px; display: block; float:left; margin-right:10px;" for="wmp_moo12">Use mootools v 1.2 instead of mootools 1.11</label>
						';
						$wmp_moo12==1 ? $content.='<input style="float: left;" type="checkbox" name="wmp_moo12" id="wmp_moo12" value="1" checked>' : $content.='<input style="float: left;" type="checkbox" name="wmp_moo12" id="wmp_moo12" value="1">';
						$content.='
						<div style="clear: both"></div>
				</div>

				<div style="padding: 10px; margin: 0 0 10px 0; background: #EAF3FA;">
						<label for="wmp_regex" style="width: 275px; display: block; float:left; margin-right:10px;">
							Comma seperated list of file extensions for automtatic mode (e.g. jpg,bmp,gif,png)
						</label>
						<textarea  style="float: left;" name="wmp_regex" id="wmp_regex" cols="60" rows="2">' . get_option('wmp_regex') . '</textarea>
						<div style="clear: both"></div>
				</div>
				
				<div style="padding: 10px; margin: 0 0 10px 0; background: #EAF3FA;">
						<label for="wmp_classname" style="width: 275px; display: block; float:left; margin-right:10px;">
							Name of the class in the a tag params (also for css an id used)
						</label>
						<input style="float: left;" type="text" size="25" name="wmp_classname" value="' . get_option('wmp_classname') . '"><br><br><br>
						<div style="clear: both"></div>
				</div>
				
				<div style="padding: 10px; margin: 0 0 10px 0; background: #EAF3FA;">
						<label for="wmp_useoverlay" style="width: 275px; display: block; float:left; margin-right:10px;">
							Use an overlay with opacity for the background
						</label>
						';
						$wmp_useoverlay==1 ? $content.='<input  style="float: left;" type="checkbox" name="wmp_useoverlay" id="wmp_useoverlay" value="1" checked>' : $content.='<input style="float: left;" type="checkbox" name="wmp_useoverlay" id="wmp_useoverlay" value="1">';

						$content.='
						<div style="clear: both"></div>
				</div>
						
				<div style="padding: 10px; margin: 0 0 10px 0; background: #EAF3FA;">
						<label for="wmp_initialWidth" style="width: 275px; display: block; float:left; margin-right:10px;">
							Width of the multibox when content is loading
						</label>
						<input  style="float: left;"type="text" size="8" name="wmp_initialWidth" value="' . get_option('wmp_initialWidth') . '">
						<div style="clear: both"></div>
				</div>

				<div style="padding: 10px; margin: 0 0 10px 0; background: #EAF3FA;">
						<label for="wmp_initialHeight" style="width: 275px; display: block; float:left; margin-right:10px;">
							Height of the multibox when content is loading
						</label>
						<input  style="float: left;"type="text" size="8" name="wmp_initialHeight" value="' . get_option('wmp_initialHeight') . '">
						<div style="clear: both"></div>
				</div>

				<div style="padding: 10px; margin: 0 0 10px 0; background: #EAF3FA;">
						<label for="wmp_showNumbers" style="width: 275px; display: block; float:left; margin-right:10px;">
							Shows the number of availible content for loading with the multibox on the page
						</label>
						';
						$wmp_showNumbers==1 ? $content.='<input type="checkbox" style="float: left;" name="wmp_showNumbers" id="wmp_showNumbers" value="1" checked>' : $content.='<input type="checkbox" style="float: left;" name="wmp_showNumbers" id="wmp_showNumbers" value="1">';

						$content.='
						<div style="clear: both"></div>
				</div>

				<div style="padding: 10px; margin: 0 0 10px 0; background: #EAF3FA;">
						<label for="wmp_showControls"  style="width: 275px; display: block; float:left; margin-right:10px;">
							Show the controls like description and arrows for browsing
						</label>
						';
						$wmp_showControls==1 ? $content.='<input  style="float: left;" type="checkbox" name="wmp_showControls" id="wmp_showControls" value="1" checked>' : $content.='<input  style="float: left;" type="checkbox" name="wmp_showControls" id="wmp_showControls" value="1">';

						$content.='
						<div style="clear: both"></div>
				</div>

				<div style="padding: 10px; margin: 0 0 10px 0; background: #EAF3FA;">
						<label for="wmp_disableDesc"  style="width: 275px; display: block; float:left; margin-right:10px;">
							Disable the description (need for NextGen Gallery at the moment)
						</label>
						';
						$wmp_disableDesc==1 ? $content.='<input  style="float: left;" type="checkbox" name="wmp_disableDesc" id="wmp_disableDesc" value="1" checked>' : $content.='<input  style="float: left;" type="checkbox" name="wmp_disableDesc" id="wmp_disableDesc" value="1">';

						$content.='
						<div style="clear: both"></div>
				</div>

				<div style="padding: 10px; margin: 0 0 10px 0; background: #EAF3FA;">
						<label for="wmp_deactivateHelp"  style="width: 275px; display: block; float:left; margin-right:10px;">
							Disable the help icon with version information
						</label>
						';
						$wmp_deactivateHelp==1 ? $content.='<input  style="float: left;" type="checkbox" name="wmp_deactivateHelp" id="wmp_deactivateHelp" value="1" checked>' : $content.='<input  style="float: left;" type="checkbox" name="wmp_deactivateHelp" id="wmp_deactivateHelp" value="1">';

						$content.='
						<div style="clear: both"></div>
				</div>

				<h3>Design options</h3><br>
				<div style="padding: 10px; margin: 0 0 10px 0; background: #EAF3FA;">
						<label for="wmp_useDesign" style="width: 275px; display: block; float:left; margin-right:10px;">
							Use this design settings and overwrite the standard design (look at the thumb for more informations)
						</label>
						';
						$wmp_useDesign==1 ? $content.='<input  style="float: left;" type="checkbox" name="wmp_useDesign" id="wmp_useDesign" value="1" checked>' : $content.='<input style="float: left;" type="checkbox" name="wmp_useDesign" id="wmp_useDesign" value="1">';

						$content.='
						&nbsp;<img src="' . $multibox_path . 'design_mini.jpg" style="cursor: pointer;" onclick="window.open(\'' . $multibox_path . 'design.jpg\', \'big\', \'width=662,height=471,status=no,scrollbars=no,resizable=no\');">
						<div style="clear: both"></div>
				</div>

				<div style="padding: 10px; margin: 0 0 10px 0; background: #EAF3FA;">
						<label for="wmp_uDBorderWith" style="width: 275px; display: block; float:left; margin-right:10px;">
							1. Width of the border<br>
							<i>(std: 20 )(without "px")</i>
						</label>
						<input  style="float: left;"type="text" size="8" name="wmp_uDBorderWith" value="' . get_option('wmp_uDBorderWith') . '">
						<div style="clear: both"></div>
				</div>

				<div style="padding: 10px; margin: 0 0 10px 0; background: #EAF3FA;">
						<label for="wmp_uDBorderColor" style="width: 275px; display: block; float:left; margin-right:10px;">
							2. Color of the border, you can make use of <i>transparent</i><br>
							<i>(std: #000000)</i>
						</label>
						<input style="float: left;"type="text" size="8" onkeyup="setColor(\'wmp_uDBorderColor\',\'wmp_uDBorderColorField\')" name="wmp_uDBorderColor" id="wmp_uDBorderColor" value="' . get_option('wmp_uDBorderColor') . '">
						<input class="button-secondary" value="..." onclick="showColorGrid2(\'wmp_uDBorderColor\',\'wmp_uDBorderColorField\');" type="button" title="Select color">
						<input id="wmp_uDBorderColorField" class="button-highlighted" style="background-color: ' . get_option('wmp_uDBorderColor') . ';" type="text" size="4" DISABLED>
						<div id="colorpicker201" class="colorpicker201"></div>
						<div style="clear: both"></div>
				</div>

				<div style="padding: 10px; margin: 0 0 10px 0; background: #EAF3FA;">
						<label for="wmp_uDBorderRadius" style="width: 275px; display: block; float:left; margin-right:10px;">
							3. Radius of all corners from the border above. Works not in I.E.<br>
							<i>(std: 0)</i>
						</label>
						<input  style="float: left;"type="text" size="8" name="wmp_uDBorderRadius" value="' . get_option('wmp_uDBorderRadius') . '">
						<div style="clear: both"></div>
				</div>


				<div style="padding: 10px; margin: 0 0 10px 0; background: #EAF3FA;">
						<label for="wmp_uDBorderPadding" style="width: 275px; display: block; float:left; margin-right:10px;">
							4. Padding between image an border<br>
							<i>(std: 0 )(without "px")</i>
						</label>
						<input  style="float: left;"type="text" size="8" name="wmp_uDBorderPadding" value="' . get_option('wmp_uDBorderPadding') . '">
						<div style="clear: both"></div>
				</div>


				<div style="padding: 10px; margin: 0 0 10px 0; background: #EAF3FA;">
						<label for="wmp_uDBackgroundColor" style="width: 275px; display: block; float:left; margin-right:10px;">
							5. Background color of the multibox and the control panel, you can make use of <i>transparent</i><br>
							<i>(std: #000000)</i>
						</label>
						<input style="float: left;"type="text" size="8" onkeyup="setColor(\'wmp_uDBackgroundColor\',\'wmp_uDBackgroundColorField\')" name="wmp_uDBackgroundColor" id="wmp_uDBackgroundColor" value="' . get_option('wmp_uDBackgroundColor') . '">
						<input class="button-secondary" value="..." onclick="showColorGrid2(\'wmp_uDBackgroundColor\',\'wmp_uDBackgroundColorField\');" type="button" title="Select color">
						<input id="wmp_uDBackgroundColorField" class="button-highlighted" style="background-color: ' . get_option('wmp_uDBackgroundColor') . ';" type="text" size="4" DISABLED>
						<div id="colorpicker201" class="colorpicker201"></div>
						<div style="clear: both"></div>
				</div>

				<div style="padding: 10px; margin: 0 0 10px 0; background: #EAF3FA;">
						<label for="wmp_uDTitleColor" style="width: 275px; display: block; float:left; margin-right:10px;">
							6. Color of the title text<br>
							<i>(std: #FFFFFF)</i>
						</label>
						<input style="float: left;"type="text" size="8" onkeyup="setColor(\'wmp_uDTitleColor\',\'wmp_uDTitleColorField\')" name="wmp_uDTitleColor" id="wmp_uDTitleColor" value="' . get_option('wmp_uDTitleColor') . '">
						<input class="button-secondary" value="..." onclick="showColorGrid2(\'wmp_uDTitleColor\',\'wmp_uDTitleColorField\');" type="button" title="Select color">
						<input id="wmp_uDTitleColorField" class="button-highlighted" style="background-color: ' . get_option('wmp_uDTitleColor') . ';" type="text" size="4" DISABLED>
						<div id="colorpicker201" class="colorpicker201"></div>
						<div style="clear: both"></div>
				</div>

				<div style="padding: 10px; margin: 0 0 10px 0; background: #EAF3FA;">
						<label for="wmp_uDDescColor" style="width: 275px; display: block; float:left; margin-right:10px;">
							7. Color of the description text<br>
							<i>(std: #FFFFFF)</i>
						</label>
						<input style="float: left;"type="text" size="8" onkeyup="setColor(\'wmp_uDDescColor\',\'wmp_uDDescColorField\')" name="wmp_uDDescColor" id="wmp_uDDescColor" value="' . get_option('wmp_uDDescColor') . '">
						<input class="button-secondary" value="..." onclick="showColorGrid2(\'wmp_uDDescColor\',\'wmp_uDDescColorField\');" type="button" title="Select color">
						<input id="wmp_uDDescColorField" class="button-highlighted" style="background-color: ' . get_option('wmp_uDDescColor') . ';" type="text" size="4" DISABLED>
						<div id="colorpicker201" class="colorpicker201"></div>
						<div style="clear: both"></div>
				</div>

				<div style="padding: 10px; margin: 0 0 10px 0; background: #EAF3FA;">
						<label for="wmp_uDOverlayBG" style="width: 275px; display: block; float:left; margin-right:10px;">
							8. Background color of the transparent overlay<br>
							<i>(std: #000000)</i>
						</label>
						<input style="float: left;"type="text" size="8" onkeyup="setColor(\'wmp_uDOverlayBG\',\'wmp_uDOverlayBGField\')" name="wmp_uDOverlayBG" id="wmp_uDOverlayBG" value="' . get_option('wmp_uDOverlayBG') . '">
						<input class="button-secondary" value="..." onclick="showColorGrid2(\'wmp_uDOverlayBG\',\'wmp_uDOverlayBGField\');" type="button" title="Select color">
						<input id="wmp_uDOverlayBGField" class="button-highlighted" style="background-color: ' . get_option('wmp_uDOverlayBG') . ';" type="text" size="4" DISABLED>
						<div id="colorpicker201" class="colorpicker201"></div>
						<div style="clear: both"></div>
				</div>
				
				<div style="padding: 10px; margin: 0 0 10px 0; background: #EAF3FA;">
						<label for="wmp_useOwnIcons" style="width: 275px; display: block; float:left; margin-right:10px;">
							Make use of own icons. Take a look at the images folder. You need ALL icons in an additional folder like "myimages". Please note that the folder must be in the multibox plugin folder, the images must been in png format and all filenames must be like the original image names!<br>
							<i>(std: images)</i>
						</label>
						<input style="float: left;" type="text" size="40" name="wmp_useOwnIcons" value="' . get_option('wmp_useOwnIcons') . '"><br><br><br>
						<div style="clear: both"></div>
				</div>

				
				<h3>Handle PDF files in multibox</h3><br>

				<div style="padding: 10px; margin: 0 0 10px 0; background: #EAF3FA;">
						<label for="wmp_activatepdf"  style="width: 275px; display: block; float:left; margin-right:10px;">
							Activate the multibox for pdf files (opens the acrobat reader in multibox)
						</label>
						';
						$wmp_activatepdf==1 ? $content.='<input  style="float: left;" type="checkbox" name="wmp_activatepdf" id="wmp_activatepdf" value="1" checked>' : $content.='<input  style="float: left;" type="checkbox" name="wmp_activatepdf" id="wmp_activatepdf" value="1">';

						$content.='
						<div style="clear: both"></div>
				</div>

				<div style="padding: 10px; margin: 0 0 10px 0; background: #EAF3FA;">
						<label for="wmp_pdfwidth"  style="width: 275px; display: block; float:left; margin-right:10px;">
							Width of the multibox for pdf files
						</label>
						<input  style="float: left;"type="text" size="8" name="wmp_pdfwidth" value="' . get_option('wmp_pdfwidth') . '">
						<div style="clear: both"></div>
				</div>

				<div style="padding: 10px; margin: 0 0 10px 0; background: #EAF3FA;">
						<label for="wmp_pdfheight"  style="width: 275px; display: block; float:left; margin-right:10px;">
							Height of the multibox for pdf files
						</label>
						<input  style="float: left;"type="text" size="8" name="wmp_pdfheight" value="' . get_option('wmp_pdfheight') . '">
						<div style="clear: both"></div>
				</div>

				<h3>Slideshow:</h3><br>

				<div style="padding: 10px; margin: 0 0 10px 0; background: #EAF3FA;">
						<label for="wmp_slideshow"  style="width: 275px; display: block; float:left; margin-right:10px;">
							Activate the Slideshow in the control panel
						</label>
						';
						$wmp_slideshow==1 ? $content.='<input  style="float: left;" type="checkbox" name="wmp_slideshow" id="wmp_slideshow" value="1" checked>' : $content.='<input  style="float: left;" type="checkbox" name="wmp_slideshow" id="wmp_slideshow" value="1">';

						$content.='
						<div style="clear: both"></div>
				</div>

				<div style="padding: 10px; margin: 0 0 10px 0; background: #EAF3FA;">
						<label for="wmp_slideshowTime"  style="width: 275px; display: block; float:left; margin-right:10px;">
							Stop time for each image in milliseconds (1000 = 1 second!)
						</label>
						<input  style="float: left;"type="text" size="8" name="wmp_slideshowTime" value="' . get_option('wmp_slideshowTime') . '">
						<div style="clear: both"></div>
				</div>
				

			<hr />
			<p class="submit"><input type="submit" name="Submit" value="Update Options" /></p>
			</form></div>';		
	
	echo $content;
	}
		
		
		####### Multibox output section
		
		function multibox_styles() {

			
			echo makeHeader(get_option('wmp_moo12'));
		}

function makeHeader($moo) 
{
			$multibox_path = get_option('siteurl')."/wp-content/plugins/wordpress-multibox-plugin/";

	if($moo == 1) 
  {
			$content = '
			<!-- added by the wordpress multibox plugin -->
			<style type="text/css">
			.MultiBoxClose, .MultiBoxPrevious, .MultiBoxNext, .MultiBoxNextDisabled, .MultiBoxPreviousDisabled, .MultiBoxHelpButton { 
				behavior: url('.$multibox_path.'iepng/iepngfix.htc); 
			}
			 </style>
			
			<link rel="stylesheet" href="' . $multibox_path . 'multibox.css" type="text/css" media="screen" />
			<script type="text/javascript" src="' . $multibox_path . 'mtv120/mootools-1.2-core-yc.js"></script>
			<script type="text/javascript" src="' . $multibox_path . 'mtv120/mootools-1.2-more.js"></script>
			<script type="text/javascript" src="' . $multibox_path . 'mtv120/overlay-1.2.js"></script>
			<script type="text/javascript" src="' . $multibox_path . 'mtv120/multibox-1.3.1.js"></script>
			'. getJSconfig() .'
			'. getCSSconfig() .'
			'. getCSSDesignConfig() .'
  		<!-- added by the wordpress multibox plugin -->';
	}
	else 
  {
			$content = '
			<!-- added by the wordpress multibox plugin -->
			<style type="text/css">
			.MultiBoxClose, .MultiBoxPrevious, .MultiBoxNext, .MultiBoxNextDisabled, .MultiBoxPreviousDisabled { 
				behavior: url('.$multibox_path.'iepng/iepngfix.htc); 
			}
			 </style>
			
			<link rel="stylesheet" href="' . $multibox_path . 'multibox.css" type="text/css" media="screen" />
			<script type="text/javascript" src="' . $multibox_path . 'mtv111/mootools.js"></script>
			<script type="text/javascript" src="' . $multibox_path . 'mtv111/overlay.js"></script>
			<script type="text/javascript" src="' . $multibox_path . 'mtv111/multibox.js"></script>
			'. getJSconfig() .'
			'. getCSSconfig() .'
			'. getCSSDesignConfig() .'
  		<!-- added by the wordpress multibox plugin -->
		 ';
	}
	return $content;
}
function getCSSDesignConfig() 
{
			global $wp_version, $post, $wp_query;
			$multibox_path = get_option('siteurl')."/wp-content/plugins/wordpress-multibox-plugin/";
			
			if(get_option('wmp_useDesign')=='1') {

				$content='
				 <style type="text/css" media="screen">
				.MultiBoxContainer {
				border-color: ' . get_option('wmp_uDBorderColor') . ';
				border-width: ' . get_option('wmp_uDBorderWith') . 'px;
				padding: ' . get_option('wmp_uDBorderPadding') . 'px;
				-moz-border-radius: ' . get_option('wmp_uDBorderRadius') . 'px;
				-khtml-border-radius: ' . get_option('wmp_uDBorderRadius') . 'px;
				-webkit-border-radius: ' . get_option('wmp_uDBorderRadius') . 'px;
				background-color: ' . get_option('wmp_uDBackgroundColor') . ';
				}
				.MultiBoxControls {background-color: ' . get_option('wmp_uDBackgroundColor') . ';}
				.MultiBoxTitle {color: ' . get_option('wmp_uDTitleColor') . ';}
				.MultiBoxNumber {color: ' . get_option('wmp_uDTitleColor') . ';}
				.MultiBoxDescription {color: ' . get_option('wmp_uDDescColor') . ';}
				.MultiBoxLoading { background: url(' . $multibox_path.get_option('wmp_useOwnIcons') . '/loader.gif) no-repeat center;}
				.MultiBoxClose {background: url(' . $multibox_path.get_option('wmp_useOwnIcons') . '/close.png) no-repeat;}
				.MultiBoxPrevious {background: url(' . $multibox_path.get_option('wmp_useOwnIcons') . '/left.png) no-repeat;}
				.MultiBoxPlayPrevious {background: url(' . $multibox_path.get_option('wmp_useOwnIcons') . '/leftplay.png) no-repeat;}
				.MultiBoxNext {background: url(' . $multibox_path.get_option('wmp_useOwnIcons') . '/right.png) no-repeat;}
				.MultiBoxPlayNext {background: url(' . $multibox_path.get_option('wmp_useOwnIcons') . '/play.png) no-repeat;}
				.MultiBoxPlayNextPause {background: url(' . $multibox_path.get_option('wmp_useOwnIcons') . '/pause.png) no-repeat;}
				.MultiBoxPlayPreviousPause {background: url(' . $multibox_path.get_option('wmp_useOwnIcons') . '/pause.png) no-repeat;}
				.MultiBoxPlayPreviousDisabled {background: url(' . $multibox_path.get_option('wmp_useOwnIcons') . '/leftplayDisabled.png) no-repeat;}
				.MultiBoxPlayNextDisabled {background: url(' . $multibox_path.get_option('wmp_useOwnIcons') . '/playDisabled.png) no-repeat;}
				.MultiBoxNextDisabled {background: url(' . $multibox_path.get_option('wmp_useOwnIcons') . '/rightDisabled.png) no-repeat;}
				.MultiBoxPreviousDisabled {background: url(' . $multibox_path.get_option('wmp_useOwnIcons') . '/leftDisabled.png) no-repeat;}
				#Overlay { background-color: ' . get_option('wmp_uDOverlayBG') . ';}
				</style>
			';
			}
		return $content;
}

function getCSSconfig() 
{
			global $wp_version, $post, $wp_query;
			
			get_option('wmp_deactivateHelp')=='1' ? $wmp_deactivateHelp = 'display:none;' : $wmp_deactivateHelp;

			$content='
			 <style type="text/css" media="screen">
			.MultiBoxHelpButton {
				'.$wmp_deactivateHelp.'
			}
			</style>
			';
		return $content;
}
function getJSconfig () 
{

			$multibox_path = get_option('siteurl')."/wp-content/plugins/wordpress-multibox-plugin/";
			global $wp_version, $post, $wp_query;
			get_option('wmp_classname')=='' ? $wmp_classname = 'wmpi' : $wmp_classname = get_option('wmp_classname');
			get_option('wmp_useoverlay')==1 ? $wmp_useoverlay = 'true' : $wmp_useoverlay = 'false';
			get_option('wmp_showNumbers')==1 ? $wmp_showNumbers = 'true' : $wmp_showNumbers = 'false';
			get_option('wmp_showControls')==1 ? $wmp_showControls = 'true' : $wmp_showControls = 'false';
			get_option('wmp_initialWidth')=='' ? $wmp_initialWidth = '150' : $wmp_initialWidth = get_option('wmp_initialWidth');
			get_option('wmp_initialHeight')=='' ? $wmp_initialHeight = '150' : $wmp_initialHeight = get_option('wmp_initialHeight');
			get_option('wmp_slideshow')==1 ? $wmp_slideshow = 'true' : $wmp_slideshow = 'false';
			
			$content='
			<script type="text/javascript">
			var box = {};
			var overlay = {};
						window.addEvent(\'domready\', function(){
							box = new MultiBox(\'' . $wmp_classname . '\', {
								useOverlay: ' . $wmp_useoverlay . ',
								initialWidth: ' . $wmp_initialWidth . ',
								initialHeight: ' . $wmp_initialHeight . ',
								showNumbers: ' . $wmp_showNumbers . ',
								showControls: ' . $wmp_showControls . ',
								path: \'' . $multibox_path .'files/\',
								slideshow: ' . $wmp_slideshow . ',								
								slideshowTime: ' . get_option('wmp_slideshowTime') . '';
								if(get_option('wmp_disableDesc')!='1') {
								$content.=',
								descClassName: \'' . get_option('wmp_classname') . 'Desc\''; }
								$content.=' });
							});
		 </script>
			';
		return $content;
}
function imagebox_create($content)
{
	global $version;

	$multibox_path = get_option('siteurl')."/wp-content/plugins/wordpress-multibox-plugin/";
	get_option('wmp_useDesign')!='1' ? $wmp_useOwnIcons = 'images' : $wmp_useOwnIcons = get_option('wmp_useOwnIcons');

	$regs = get_option('wmp_regex');
	$regsStr = str_replace(',','|', $regs);					
	$regsStr = str_replace(' ','', $regsStr);					

	$content = preg_replace('/<a(.*?)href=(.*?).('.$regsStr.')"(.*?)>/i', '<div class="MultiBoxHelp" id="MultiBoxHelp"><a href="http://www.rutschmann.biz" title="powered by Wordpress Multibox Plugin v'.$version.'" target="_blank"><img src="'.$multibox_path.$wmp_useOwnIcons.'/help.png" alt="powered by Wordpress Multibox Plugin v'.$version.'" title="powered by Wordpress Multibox Plugin v'.$version.'"></a></div><a$1href=$2.$3" $4 class="' . get_option('wmp_classname') . '" id="' . get_option('wmp_classname') . '1">', $content);
	$content = preg_replace_callback('/(.*?)' . get_option('wmp_classname') . '1(.*?)/i', 'getCount', $content);
	
	preg_match_all('/\[caption(.*?)id="attachment_(.*?)"(.*?)id="' . get_option('wmp_classname') . '(.*?)"(.*?)alt="(.*?)"(.*?)\[\/caption\]/i',$content,$out);
	
	$i=0;
	foreach($out[2] as $dummy) {
		$content.='<div style="display: none;" class="' . get_option('wmp_classname') . 'Desc ' . get_option('wmp_classname') . '' . $out[4][$i] . '">' . $out[6][$i] . '</div>';
		$i++;
	}
	
	if(get_option('wmp_activatepdf')==1) {
		$content = preg_replace('/<a(.*?)href=(.*?).(pdf)"(.*?)>/i', '<a$1href=$2.$3" rel="width:' . get_option('wmp_pdfwidth') .',height:' . get_option('wmp_pdfheight') .'" $4 class="' . get_option('wmp_classname') . '" id="' . get_option('wmp_classname') . '1">', $content);
	}
	
	$content.='';
	return $content;
}

		
function getCount($hit) 
{
	static $i = 1;
	$hit1 = $hit[1];
	$hit2 = $hit[2];
	$out = $hit1.'' . get_option('wmp_classname') . ''.$i.$hit2;
	$i++;
return $out;
}

	####### Multibox description section
	
if(get_option('wmp_automatic')==1) {
	add_filter('the_content', 'imagebox_create', 2);
}
add_action('wp_head', 'multibox_styles');


?>