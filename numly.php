<?PHP
/*
Plugin Name: numly Numbers
Plugin URI: http://blog.borgnet.us/links/numly-numbers/
Description: Electronic Standard Number (numly) is the unique identifier of electronic content and media. numlys are recognized worldwide by electronic publishing companies and electronic content providers. They serve as branded identifier or copyright for individuals or companies developing electronic content and media. numlys are assigned and managed by <a href="http://www.numly.com">numly.com</a>.  This plugin automatically generates a numly for each new post. This plugin requires WordPress 3.0+
Version: 2.6
Author: Scott Grayban <sgrayban@gmail.com>
Author URI: http://blog.borgnet.us/
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=NAL594NVVW8AU
License: GPLv2
*/

/*
 * $Id: numly.php 972125 2014-08-25 06:14:14Z sgrayban $
 *  Copyright 2008  Scott Grayban  (email: sgrayban@gmail.com)
 *  Copyright 2005  Cal Evans  (email: cal@calevans.com)
 *
 *  This program is free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program; if not, write to the Free Software
 *  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 */

require_once('numly_functions.php');
define( 'NUMLYVERSION', '2.5' );

function numly_output($id=0) {
	$date = date("Y");
	$numly_settings = numly_fetch_options('numly');
	$numly_current_key = get_post_meta($id,'numly_key');
	$output = '';
	$license_array = numly_prepare_license_array();
	if (is_array($numly_current_key)) $numly_current_key = $numly_current_key[0];

	if (!empty($numly_current_key)) {
		$output  = '<br/><div class="numly-output">';
		$output .= '<a href="http://www.numly.com/verify/'.$numly_current_key.'" target="_blank">';
		$output .= '<img align="bottom" alt="numly" src="http://numly.com/images/numly.png" border="0"/>';

		$output .= ' '.$numly_current_key.' ';

		if ($numly_settings['show_barcode']=='yes') {
			$output .= '<br /><iframe height="50" width="400" src="http://www.numly.com/numly/barcode.asp?code='.$numly_current_key.'&height=30" name="munly1" id="numly1" scrolling="no" frameborder="0"/></iframe>';
		} // if ($numly_settings['show_barcode']=='yes')
		$output .= '</a></div>';

		if ($numly_settings['cc_license']!='reserved' && $numly_settings['cc_license']!='publicdomain') {
			$output .= '<div ><!--Creative Commons License--><a rel="license" href="http://creativecommons.org/licenses/'.$numly_settings['cc_license'].'/3.0/"><img alt="Creative Commons License" border="0" src="http://creativecommons.org/images/public/somerights20.png"/></a><br/>This work is licensed under a <a rel="license" href="http://creativecommons.org/licenses/'.$numly_settings['cc_license'].'/3.0/">Creative Commons '.$license_array[$numly_settings['cc_license']].' 3.0 License</a>.<!--/Creative Commons License--><!-- <rdf:RDF xmlns="http://web.resource.org/cc/" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"><Work rdf:about=""><license rdf:resource="http://creativecommons.org/licenses/'.$numly_settings['cc_license'].'/3.0/" /></Work><License rdf:about="http://creativecommons.org/licenses/by-nd/3.0/"><permits rdf:resource="http://web.resource.org/cc/Reproduction"/><permits rdf:resource="http://web.resource.org/cc/Distribution"/><requires rdf:resource="http://web.resource.org/cc/Notice"/><requires rdf:resource="http://web.resource.org/cc/Attribution"/></License></rdf:RDF> --></div>';
		} // if ($numly_settings['cc_license']!='reserved')

		if ($numly_settings['cc_license']=='publicdomain') {
			$output .= '<div ><!-- Creative Commons Public Domain --><a href="http://creativecommons.org/licenses/publicdomain"><img alt="Public Domain Dedication" border="0" src="http://i.creativecommons.org/l/publicdomain/88x31.png" /></a><br />This work is dedicated to the <a href="http://creativecommons.org/licenses/publicdomain/">Public Domain</a>.<!-- /Creative Commons Public Domain --><!--<rdf:RDF xmlns="http://creativecommons.org/ns#"     xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"><Work rdf:about=""><license rdf:resource="http://creativecommons.org/ns#PublicDomain" /></Work><License rdf:about="http://creativecommons.org/ns#PublicDomain"><permits rdf:resource="http://creativecommons.org/ns#Reproduction" /><permits rdf:resource="http://creativecommons.org/ns#Distribution" /><permits rdf:resource="http://creativecommons.org/ns#DerivativeWorks" /></License></rdf:RDF>--></div>';
		} // if ($numly_settings['cc_license']=='publicdomain')

		if ($numly_settings['cc_license']=='reserved') {
			$output .= '<div >&copy; 1999-'.$date.' '.$numly_settings['publisher'].' - All Rights Reserved</div>';
		} // if ($numly_settings['cc_license']=='reserved')

	} // if (!empty($numly_current_key))
	echo $output;
	return;
} // function numly_output()


function numly_prepare_license_array() {
	$license_array = array();
	$license_array["reserved"] = "All Rights Reserved";
	$license_array["by"]       = "Attribution v3.0";
	$license_array["by-nc"]    = "Attribution-NonCommercial v3.0";
	$license_array["by-nc-nd"] = "Attribution-NonCommercial-NoDerivsv 3.0";
	$license_array["by-nc-sa"] = "Attribution-NonCommercial-ShareAlike v3.0";
	$license_array["by-nd"]    = "Attribution-NoDerivs v3.0";
	$license_array["by-sa"]    = "Attribution-ShareAlike v3.0";

	return $license_array;

} // function numly_prepare_license_array()


/*
 * The options Page
 */
function numly_options_page()
{
	/*
	 * Process a POSTED form.
	 */
	if (isset($_POST['info_update']))
	{
		numly_post_options('numly',$_POST['numly_settings']);
	} // if (isset($_POST['info_update']))


	$numly_settings = numly_fetch_options('numly');
	$license_array = numly_prepare_license_array()
?>

<?PHP if (isset($_POST['info_update'])) {?>
<div id="message" class="updated fade">
<p><strong><?php _e('Options Saved','options_saved')?></strong></p>
</div>
<?PHP } ?>

<div class=wrap>
  <form method="post">
    <h2>numly numbers Configuration Options</h2>
    <fieldset name="user_name">
		<legend><?php _e('Your numly User Name','username')?><br />
		<?php _e('(Note: The plugin will not operate without it.)','username_note')?></legend>
		<input type="text"
               name="numly_settings[username]"
               value="<?=$numly_settings['username'];?>" size="75" />
	</fieldset>

    <fieldset name="publisher">
		<legend><?php _e('Your Name or the name of the publisher of the content.','publisher_name')?></legend>
		<input type="text"
               name="numly_settings[publisher]"
               value="<?=$numly_settings['publisher'];?>" size="75" />
	</fieldset>

    <fieldset name="show_barcode">
	<input type  = "checkbox"
	       name  = "numly_settings[show_barcode]"
	       value = "yes" <?=$numly_settings['show_barcode']=='yes'?'CHECKED':'';?> />
               <label><?php _e('Display the barcode?','display_barcode')?></label>
    </fieldset>
    <fieldset name="cc_license">
		<legend><?php _e('What Creative Commons License would you like to use?','license_type')?></legend>
		<select name="numly_settings[cc_license]">
		<?PHP
			foreach($license_array as $key=>$value) {
		?>
		<option value="<?=$key?>" <?=($numly_settings['cc_license']==$key)?'SELECTED':''?> ><?=$value;?></option>
		<?PHP
			} // foreach($license_array as $key=>$value)
		?>
		<option value="publicdomain">Public Domain</option>
	</select>
    </fieldset>

<div class="submit">
  <input type="submit" name="info_update" value="<?php _e('Update','update_button')?>" />
</div>
  </form>
 </div>
	<div class="wrap" >
<?PHP
?>
<table border="0" width="100%">
	<tr>
		<td alignt="left" width="50%">File a bug report <a href="http://wordpress.org/tags/numly-numbers?forum_id=10">here</a> if you are having problems.<br />
	If you like this plugin please donate.
	<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
	<input type="hidden" name="cmd" value="_s-xclick">
	<input type="hidden" name="hosted_button_id" value="NAL594NVVW8AU">
	<input type="image" src="https://www.paypal.com/en_US/i/btn/btn_donate_SM.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
	<img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
	</form>
		</td>

		<td align="right" width="50%">Get an <a href="http://www.numly.com">numly</a> account or manage the one you have.<br />
	<a href="http://www.numly.com" target="_BLANK"><img src="http://numly.com/images/numly.png" alt="numly" /></a>
		</td>
	</tr>
</table>
</div>
<?PHP
}


function numly_publish_post($id = 0) {
	$numly_current_key = get_post_meta($id,'numly_key');

	if (strlen($_POST['post_password'])<1 and
		empty($numly_current_key)) {
		// get the options
		$numly_settings = numly_fetch_options('numly');
		$user_info = get_userdata($_POST['post_author']);

		if (is_object($user_info)) {
			$numly_data = array();
			$numly_data['username']  = $numly_settings['username'];
			$numly_data['docname']   = $_POST['post_title'];
			$numly_data['docdesc']   = $_POST['content'];
			$numly_data['author']    = $numly_settings ['publisher'];
			$numly_data['publisher'] = $numly_settings ['publisher'];
			$numly_data['licensee']  = $numly_settings ['publisher'];
			$numly_data['licemail']  = $user_info->user_email;
			$numly_data['url']       = get_settings('siteurl').'/index.php?p='.$id;
			$numly_data['idonly']    = 'true';

			$numly_query = '';
			foreach ($numly_data as $key=>$value) {
				$numly_query .= urlencode(trim($key))."=".urlencode(trim($value))."&";
			}  // foreach ($numly_data as $key=>$value)

			// call the site
			$numly_id = numly_send_to_host('www.numly.com','POST','/numly/generate.asp',$numly_query);
		} // if (is_array($user_info))
		// save off the meta.
		if (is_array($numly_id)) $numly_id = $numly_id[0];
		if (is_numeric($numly_id)) {
			add_post_meta($id,'numly_key',$numly_id,true);
		} // if (is_numeric($numly_id))
	} // if (empty($numly_current_key))

} // function numly_publish_post()


/*
 * Undo the damage we may have done. if this plugin has already been installed
 * then let's hit the database, grab the options, store them all in one array
 * then write the back out.
 */
function numly_install() {
	$output = array();
	$output['username']               = get_option('numly_username');
	$output['publisher']              = get_option('numly_publisher');
	$output['show_barcode']           = get_option('numly_show_barcode');

	delete_option('numly_username');
	delete_option('numly_publisher');
	delete_option('numly_show_barcode');

	/*
	 * Set Defaults
	 */
	$output['username']               = empty($output['username'])?'':$output['username'];
	$output['publisher']              = empty($output['publisher'])?'':$output['publisher'];
	$output['show_barcode']           = ($output['show_barcode']=='yes')?'yes':'no';
	$output['last_version_check']     = empty($output['last_version_check'])?0:$output['last_version_check'];
	$output['version_check_interval'] = empty($output['version_check_interval'])?7:$output['version_check_interval'];
	$output['cc_license']             = empty($output['cc_license'])?'reserved':$output['cc_license'];
	numly_post_options('numly',$output);
	return;
} // function numly_install()


/*
 * Register our intentions with WordPress.
 */
function numly_add_option_page() {
	add_options_page("numly Configurator", 'numly Numbers', 7, __FILE__, 'numly_options_page');
//	$settings_link = '<a href="options-general.php?page=numly-numbers/numly.php">' . __('Settings') . '</a>';
} // function numly_add_option_page()

if (isset($wp_version))  {
	add_action('admin_menu', 'numly_add_option_page');
	add_action('publish_post','numly_publish_post');
	register_activation_hook(__file__, 'numly_install');
} // if (isset($wp_version))
/*


<!--Creative Commons License--><a rel="license" href="http://creativecommons.org/licenses/by-nc/3.0/"><img alt="Creative Commons License" border="0" src="http://creativecommons.org/images/public/somerights20.png"/></a><br/>This work is licensed under a <a rel="license" href="http://creativecommons.org/licenses/by-nc/3.0/">Creative Commons Attribution-NonCommercial 3.0 License</a>.<!--/Creative Commons License--><!-- <rdf:RDF xmlns="http://web.resource.org/cc/" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#">
		<Work rdf:about="">
			<license rdf:resource="http://creativecommons.org/licenses/by-nc/3.0/" />
		</Work>
		<License rdf:about="http://creativecommons.org/licenses/by-nc/3.0/"><permits rdf:resource="http://web.resource.org/cc/Reproduction"/><permits rdf:resource="http://web.resource.org/cc/Distribution"/><requires rdf:resource="http://web.resource.org/cc/Notice"/><requires rdf:resource="http://web.resource.org/cc/Attribution"/><prohibits rdf:resource="http://web.resource.org/cc/CommercialUse"/><permits rdf:resource="http://web.resource.org/cc/DerivativeWorks"/></License></rdf:RDF> -->


<!--Creative Commons License--><a rel="license" href="http://creativecommons.org/licenses/by-nd/3.0/"><img alt="Creative Commons License" border="0" src="http://creativecommons.org/images/public/somerights20.png"/></a><br/>This work is licensed under a <a rel="license" href="http://creativecommons.org/licenses/by-nd/3.0/">Creative Commons Attribution-NoDerivs 3.0 License</a>.<!--/Creative Commons License--><!-- <rdf:RDF xmlns="http://web.resource.org/cc/" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#">
		<Work rdf:about="">
			<license rdf:resource="http://creativecommons.org/licenses/by-nd/3.0/" />
		</Work>
		<License rdf:about="http://creativecommons.org/licenses/by-nd/3.0/"><permits rdf:resource="http://web.resource.org/cc/Reproduction"/><permits rdf:resource="http://web.resource.org/cc/Distribution"/><requires rdf:resource="http://web.resource.org/cc/Notice"/><requires rdf:resource="http://web.resource.org/cc/Attribution"/></License></rdf:RDF> -->
*/

?>
