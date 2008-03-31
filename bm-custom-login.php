<?php
/*
Plugin Name: BM Custom Login
Plugin URI: http://www.binarymoon.co.uk/projects/bm-custom-login/
Description: Display custom images on the wordpress login screen. Useful for branding.
Author: Ben Gillbanks
Version: 1.1
Author URI: http://www.binarymoon.co.uk/
*/ 

// display custom login styles
function bm_custom_login() {

	$blog_version = get_bloginfo( 'version' );
	If ( $blog_version >= 2.5 ) {
		echo '<link rel="stylesheet" type="text/css" href="' . get_settings( 'siteurl' ) . '/wp-content/plugins/bm-custom-login/bm-custom-login-2.css" />';	
	}else {
		echo '<link rel="stylesheet" type="text/css" href="' . get_settings( 'siteurl' ) . '/wp-content/plugins/bm-custom-login/bm-custom-login.css" />';
	}

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
