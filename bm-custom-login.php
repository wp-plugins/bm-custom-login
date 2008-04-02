<?php
/*
Plugin Name: BM Custom Login
Plugin URI: http://www.binarymoon.co.uk/projects/bm-custom-login/
Description: Display custom images on the wordpress login screen. Useful for branding.
Author: Ben Gillbanks
Version: 1.2
Author URI: http://www.binarymoon.co.uk/
*/ 

// display custom login styles
function bm_custom_login() {

	// default wordpress mu plugin path
	$pluginPath = "/wp-content/mu-plugins/";
	// change this to wordpress mu version that has the new login design
	$versionCheck = 999;
	// is it wordpress mu or wordpress normal?
	if( ! is_dir( $pluginPath ) ) {
		$pluginPath = "/wp-content/plugins/";
		$versionCheck = 2.5;
	}
	
	// full plugin path
	$pluginUrl = get_settings( 'siteurl' ) . $pluginPath . plugin_basename( dirname( __FILE__ ) );

	// check which version of wp is being used
	$blog_version = get_bloginfo( 'version' );
	// split style sheets based upon current wp version	
	If ( $blog_version >= $versionCheck ) {
		$pluginUrl .= '/bm-custom-login-2.css';	
	}else {
		$pluginUrl .= '/bm-custom-login.css';
	}
	
	echo '<link rel="stylesheet" type="text/css" href="' . $pluginUrl . '" />';

}

function change_wp_login_url() {
    echo get_option( 'siteurl' );
}

function change_wp_login_title() {
    echo 'Powered by ' . get_option( 'blogname' );
}

add_action( 'login_head', 'bm_custom_login' );
add_filter( 'login_headerurl', 'change_wp_login_url' );
add_filter( 'login_headertitle', 'change_wp_login_title' );

?>
