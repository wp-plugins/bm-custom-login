<?php
/*
Plugin Name: BM Custom Login
Plugin URI: http://www.binarymoon.co.uk/projects/bm-custom-login/
Description: Display custom images on the wordpress login screen. Useful for branding.
Author: Ben Gillbanks
Version: 1.5.2
Author URI: http://www.binarymoon.co.uk/
*/

define ('CL_GROUP', 'custom_login');
define ('CL_PAGE', 'custom_login_admin');
define ('CL_SECTION', 'custom_login_section');
define ('CL_OPTIONS', 'custom_login_options');
define ('CL_LOCAL', 'custom_login');

$cl_options = array ();


/**
 *
 * @global type $cl_options
 * @return type 
 */
function custom_login_get_options () {
	
	global $cl_options;
	
	if (empty ($cl_options)) {
		$cl_options = get_option (CL_OPTIONS);
	}
	
	return $cl_options;
	
}


/**
 * 
 */
function bm_custom_login () {
	
	$cl_options = custom_login_get_options ();

	// default wordpress mu plugin path
	$pluginPath = '/wp-content/mu-plugins/';
	
	// is it wordpress mu or wordpress normal?
	if (!is_dir ($pluginPath)) {
		$pluginPath = '/wp-content/plugins/';
	}

	$pluginUrl = get_option ('siteurl') . $pluginPath . plugin_basename (dirname (__FILE__)) . '/bm-custom-login.css';
	
	// output styles
	echo '<link rel="stylesheet" type="text/css" href="' . $pluginUrl . '" />';
	echo '<style>';
	
	$background = $cl_options['cl_background'];
	
	if (!empty ($background)) {
?>
	#login {
		background:url(<?php echo $background; ?>) top center no-repeat;
	}
<?php
	}

	// text colour
	if (!empty ($cl_options['cl_color'])) {
?>
	#login,
	#login label {
		color:#<?php echo $cl_options['cl_color']; ?>;
	}
<?php
	}

	// text colour
	if (!empty ($cl_options['cl_backgroundColor'])) {
?>
	html,
	body.login {
		background:#<?php echo $cl_options['cl_backgroundColor']; ?> !important;
	}
<?php
	}

	// text colour
	if (!empty ($cl_options['cl_linkColor'])) {
?>
	.login #login a {
		color:#<?php echo $cl_options['cl_linkColor']; ?> !important;
	}
<?php
	}
	
	echo '</style>';
}


/**
 * 
 */
function custom_login_url () {

    echo bloginfo ('url');
	
}


/**
 * 
 */
function custom_login_title () {
	
	$cl_options = custom_login_get_options ();
	
	if (empty ($cl_options['cl_powerby'])) {
	    echo printf (__('Powered by %s', CL_LOCAL), get_option ('blogname'));
	} else {
		echo $cl_options['cl_powerby'];
	}
	
}


/**
 * 
 */
function custom_login_admin_add_page () {
	
	add_options_page ('BM Custom Login', 'Custom Login', 'manage_options', CL_PAGE, 'custom_login_options');
	
}


/**
 * 
 */
function custom_login_options () {
?>
	
<style>
	.wrap {
		position:relative;
	}
	
	.cl_notice {
		padding:10px 20px;
		-moz-border-radius:3px;
		-webkit-border-radius:3px;
		border-radius:3px;
		background:lightyellow;
		border:1px solid #e6db55;
		margin:10px 5px 10px 0;
	}
	
	.cl_notice h3 {
		margin-top:5px;
		padding-top:0;
	}
	
	.cl_notice li {
		list-style-type:disc;
		margin-left:20px;
	}
</style>

<div class="wrap">
	<div class="icon32" id="icon-options-general"><br /></div>
	<h2>Custom Login Options</h2>
	
	<div class="cl_notice">
		<h3>More WordPress Goodies &rsaquo;</h3>
		<p>If you like this plugin then you may also like my themes on <a href="http://prothemedesign.com" target="_blank">Pro Theme Design</a></p>
		<ul>
			<li><a href="http://twitter.com/prothemedesign">Pro Theme Design on Twitter</a></li>
			<li><a href="http://facebook.com/ProThemeDesign">Pro Theme Design on Facebook</a></li>
		</ul>
	</div>
	
	<form action="options.php" method="post">
<?php	
	settings_fields (CL_GROUP);
	do_settings_sections (CL_PAGE);
?>
		<p class="submit">
			<input name="Submit" type="submit" value="<?php esc_attr_e('Save Changes'); ?>" class="button-primary" />	
		</p>
	</form>
</div>

<?php
}


/**
 * 
 */
function custom_login_init () {
	
	$vars = custom_login_get_options ();
		
	register_setting (CL_GROUP, CL_OPTIONS, 'custom_login_validate');
	add_settings_section (CL_SECTION, __('Login Screen Settings', CL_LOCAL), 'custom_login_section_validate', CL_PAGE);

	add_settings_field (
		'cl_background',
		__('Background Image Url:', CL_LOCAL),
		'form_text',
		CL_PAGE,
		CL_SECTION,
		array (
			'id' => 'cl_background',
			'value' => $vars,
			'default' => '',
			'description' => __('URL path to image to use for background (sized 312px wide, and around 600px tall so that it can be cropped). You can upload your image with the media uploader', CL_LOCAL),
		)
	);

	add_settings_field (
		'cl_powerby',
		__('Custom Login Powered by:', CL_LOCAL),
		'form_text',
		CL_PAGE,
		CL_SECTION,
		array (
			'id' => 'cl_powerby',
			'value' => $vars,
			'default' => '',
			'description' => '',
		)
	);

	add_settings_field (
		'cl_backgroundColor',
		__('Page Background Color:', CL_LOCAL),
		'form_text',
		CL_PAGE,
		CL_SECTION,
		array (
			'id' => 'cl_backgroundColor',
			'value' => $vars,
			'default' => 'eeeeee',
			'description' => __('6 digit hex color code', CL_LOCAL),
		)
	);
	
	add_settings_field (
		'cl_color',
		__('Text Color:', CL_LOCAL),
		'form_text',
		CL_PAGE,
		CL_SECTION,
		array (
			'id' => 'cl_color',
			'value' => $vars,
			'default' => 'ffffff',
			'description' => __('6 digit hex color code', CL_LOCAL),
		)
	);
	
	add_settings_field (
		'cl_linkColor',
		__('Text Link Color:', CL_LOCAL),
		'form_text',
		CL_PAGE,
		CL_SECTION,
		array (
			'id' => 'cl_linkColor',
			'value' => $vars,
			'default' => '21759B',
			'description' => __('6 digit hex color code', CL_LOCAL),
		)
	);
	
}


/**
 *
 * @param type $fields
 * @return type 
 */
function custom_login_validate ($fields) {

	// colour validation
	$fields['cl_color'] = str_replace ('#', '', $fields['cl_color']);
	//$fields['cl_color'] = str_pad ('f', 6, $fields['cl_color'], STR_PAD_RIGHT);
	$fields['cl_color'] = substr ($fields['cl_color'], 0, 6);
	
	// background colour validation
	$fields['cl_backgroundColor'] = str_replace ('#', '', $fields['cl_backgroundColor']);
	//$fields['cl_backgroundColor'] = str_pad ('f', 6, $fields['cl_backgroundColor'], STR_PAD_RIGHT);
	$fields['cl_backgroundColor'] = substr ($fields['cl_backgroundColor'], 0, 6);
	
	// colour validation
	$fields['cl_linkColor'] = str_replace ('#', '', $fields['cl_linkColor']);
	//$fields['cl_linkColor'] = str_pad ('f', 6, $fields['cl_linkColor'], STR_PAD_RIGHT);
	$fields['cl_linkColor'] = substr ($fields['cl_linkColor'], 0, 6);
	
	// clean image urls
	$fields['cl_background'] = esc_url_raw ($fields['cl_background']);
	
	// sanitize powered by message
	$fields['cl_powerby'] = esc_html ($fields['cl_powerby']);
	$fields['cl_powerby'] = strip_tags ($fields['cl_powerby']);
	
	return $fields;
	
}


/**
 *
 * @param type $fields
 * @return type 
 */
function custom_login_section_validate ($fields) {
	
	return $fields;
	
}


/**
 *
 * @param type $args 
 */
function form_text ($args) {
	
	// defaults
	$id = '';
	$value = '';
	$description = '';
	
	// set values
	if (!empty ($args['value'][$args['id']])) {
		$value = $args['value'][$args['id']];
	} else {
		if (!empty ($args['default'])) {
			$value = $args['default'];				
		}
	}
	
	if (!empty ($args['description'])) {
		$description = $args['description'];
	}
	
	$id = $args['id'];
?>
	<input type="text" id="<?php echo $id; ?>" name="<?php echo CL_OPTIONS; ?>[<?php echo $id; ?>]" value="<?php echo $value; ?>" class="regular-text"/>
<?php
	if (!empty ($description)) {
		echo '<br /><span class="description">' . $description . '</span>';
	}
	
}


add_action ('admin_init', 'custom_login_init');
add_action ('admin_menu', 'custom_login_admin_add_page');
add_action ('login_head', 'bm_custom_login');
add_filter ('login_headerurl', 'custom_login_url');
add_filter ('login_headertitle', 'custom_login_title');