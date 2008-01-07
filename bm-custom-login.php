<?php
/*
Plugin Name: BM Custom Login
Plugin URI: http://www.binarymoon.co.uk/projects/bm-custom-login/
Description: Display custom images on the wordpress login screen. Useful for branding.
Author: Ben Gillbanks
Version: 1.0
Author URI: http://www.binarymoon.co.uk/
*/ 

function bm_custom_login() {
	echo '<link rel="stylesheet" type="text/css" href="' . get_settings('siteurl') . '/wp-content/plugins/bm-custom-login/bm-custom-login.css" />';
}

add_action('login_head', 'bm_custom_login');

?>
