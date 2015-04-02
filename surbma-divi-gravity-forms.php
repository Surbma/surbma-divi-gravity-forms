<?php

/*
Plugin Name: Surbma - Divi & Gravity Forms
Plugin URI: http://surbma.com/wordpress-plugins/
Description: Divi form styles for Gravity Forms.

Version: 1.1.1

Author: Surbma
Author URI: http://surbma.com/

License: GPLv2

Text Domain: surbma-divi-gravity-forms
Domain Path: /languages/
*/

// Prevent direct access to the plugin
if ( !defined( 'ABSPATH' ) ) {
	die( 'Good try! :)' );
}

// Localization
function surbma_divi_gravity_forms_init() {
	load_plugin_textdomain( 'surbma-divi-gravity-forms', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}
add_action( 'plugins_loaded', 'surbma_divi_gravity_forms_init' );

// Enqueue the css file
function surbma_divi_gravity_forms_enqueue_scripts() {
	if ( wp_basename( get_bloginfo( 'template_directory' ) ) == 'Divi' && class_exists( 'GFForms' ) ) {
		wp_enqueue_style( 'surbma-divi-gravity-forms-styles', plugins_url( '', __FILE__ ) . '/css/surbma-divi-gravity-forms.css' );

		$accent_color = esc_html( et_get_option( 'accent_color', '#2EA3F2' ) );
		$custom_css = "body .gform_wrapper .gform_footer .button,body .gform_wrapper .gform_page_footer .button{color: {$accent_color};border-color: {$accent_color};}";
		wp_add_inline_style( 'surbma-divi-gravity-forms-styles', $custom_css );
	}
}
add_action( 'wp_enqueue_scripts', 'surbma_divi_gravity_forms_enqueue_scripts' );

