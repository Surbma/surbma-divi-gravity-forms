<?php

/*
Plugin Name: Surbma - Divi & Gravity Forms
Plugin URI: http://surbma.com/wordpress-plugins/
Description: Divi form styles for Gravity Forms.

Version: 1.5.5

Author: Surbma
Author URI: http://surbma.com/

License: GPLv2

Text Domain: surbma-divi-gravity-forms
Domain Path: /languages/
*/

// Prevent direct access to the plugin
if ( !defined( 'ABSPATH' ) ) exit( 'Good try! :)' );

// Localization
function surbma_divi_gravity_forms_init() {
	load_plugin_textdomain( 'surbma-divi-gravity-forms', false, plugin_basename( dirname( __FILE__ ) ) . '/languages' );
}
add_action( 'plugins_loaded', 'surbma_divi_gravity_forms_init' );

// Enqueue the css file
function surbma_divi_gravity_forms_enqueue_scripts() {
	if ( class_exists( 'GFForms' ) && function_exists( 'et_get_option' ) ) {
		wp_enqueue_style( 'surbma-divi-gravity-forms-styles', plugins_url( '', __FILE__ ) . '/css/surbma-divi-gravity-forms.css' );

		$accent_color = esc_html( et_get_option( 'accent_color', '#2ea3f2' ) );
		$all_buttons_font_size = esc_html( et_get_option( 'all_buttons_font_size', '20' ) );
		$all_buttons_text_color = esc_html( et_get_option( 'all_buttons_text_color', $accent_color ) );
		$all_buttons_text_color_hover = esc_html( et_get_option( 'all_buttons_text_color_hover', $accent_color ) );
		$all_buttons_bg_color = esc_html( et_get_option( 'all_buttons_bg_color', '#fff' ) );
		$all_buttons_bg_color_hover = esc_html( et_get_option( 'all_buttons_bg_color_hover', 'rgba(0,0,0,.05)' ) );
		$all_buttons_border_width = esc_html( et_get_option( 'all_buttons_border_width', '2' ) );
		$all_buttons_border_color = esc_html( et_get_option( 'all_buttons_border_color', $accent_color ) );
		$all_buttons_border_color_hover = esc_html( et_get_option( 'all_buttons_border_color_hover', 'transparent' ) );
		$all_buttons_border_radius = esc_html( et_get_option( 'all_buttons_border_radius', '3' ) );
		$all_buttons_border_radius_hover = esc_html( et_get_option( 'all_buttons_border_radius_hover', '3' ) );
		$all_buttons_spacing = esc_html( et_get_option( 'all_buttons_spacing', '0' ) );
		$all_buttons_spacing_hover = esc_html( et_get_option( 'all_buttons_spacing_hover', '0' ) );
		$all_buttons_font_style = esc_html( et_get_option( 'all_buttons_font_style', '', '', true ) );
		$button_text_style = '';
		if ( $all_buttons_font_style !== '' )
			$button_text_style = et_pb_print_font_style( $all_buttons_font_style );
		$all_buttons_font = sanitize_text_field( et_get_option( 'all_buttons_font', 'inherit' ) );
		$all_buttons_font = sanitize_text_field( et_builder_get_font_family( $all_buttons_font ) );
		$custom_css = "body .gform_wrapper .gform_footer input.button,body .gform_wrapper .gform_page_footer input.button,body div.form_saved_message div.form_saved_message_emailform form input[type=submit]{background-color:{$all_buttons_bg_color};color:{$all_buttons_text_color};border-width:{$all_buttons_border_width}px;border-color:{$all_buttons_border_color};border-radius:{$all_buttons_border_radius}px;{$button_text_style}{$all_buttons_font}font-size:{$all_buttons_font_size}px;letter-spacing:{$all_buttons_spacing}px;}body .gform_wrapper .gform_footer input.button:hover,body .gform_wrapper .gform_page_footer input.button:hover,body div.form_saved_message div.form_saved_message_emailform form input[type=submit]:hover{background-color:{$all_buttons_bg_color_hover};color:{$all_buttons_text_color_hover};border-color:{$all_buttons_border_color_hover};border-radius:{$all_buttons_border_radius_hover}px;letter-spacing:{$all_buttons_spacing_hover}px;}";
		wp_add_inline_style( 'surbma-divi-gravity-forms-styles', $custom_css );
	}
}
add_action( 'wp_enqueue_scripts', 'surbma_divi_gravity_forms_enqueue_scripts' );
