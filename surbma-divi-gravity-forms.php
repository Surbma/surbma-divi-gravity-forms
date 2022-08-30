<?php

/*
Plugin Name: Surbma | Divi & Gravity Forms
Plugin URI: https://surbma.com/wordpress-plugins/
Description: Divi form styles for Gravity Forms.

Version: 5.1

Author: Surbma
Author URI: https://surbma.com/

License: GPLv2

Text Domain: surbma-divi-gravity-forms
Domain Path: /languages/
*/

// Prevent direct access to the plugin
if ( !defined( 'ABSPATH' ) ) exit( 'Good try! :)' );

// Localization
add_action( 'plugins_loaded', function() {
	load_plugin_textdomain( 'surbma-divi-gravity-forms', false, plugin_basename( dirname( __FILE__ ) ) . '/languages' );
} );

// Enqueue the css file
add_action( 'gform_enqueue_scripts', function() {
	if ( class_exists( 'GFForms' ) && function_exists( 'et_get_option' ) ) {
		wp_enqueue_style( 'surbma-divi-gravity-forms-styles', plugins_url( '', __FILE__ ) . '/css/surbma-divi-gravity-forms.css', array(), '5.1' );

		$accent_color = esc_html( et_get_option( 'accent_color' ) );
		if ( empty( $accent_color ) ) {
			$accent_color = '#2ea3f2';
		}

		$all_buttons_font_size = esc_html( et_get_option( 'all_buttons_font_size' ) );
		if ( empty( $all_buttons_font_size ) ) {
			$all_buttons_font_size = 20;
		}

		$all_buttons_text_color = esc_html( et_get_option( 'all_buttons_text_color' ) );
		if ( empty( $all_buttons_text_color ) ) {
			$all_buttons_text_color = $accent_color;
		}

		$all_buttons_text_color_hover = esc_html( et_get_option( 'all_buttons_text_color_hover' ) );
		if ( empty( $all_buttons_text_color_hover ) ) {
			$all_buttons_text_color_hover = $accent_color;
		}

		$all_buttons_bg_color = esc_html( et_get_option( 'all_buttons_bg_color' ) );
		if ( empty( $all_buttons_bg_color ) ) {
			$all_buttons_bg_color = '#fff';
		}

		$all_buttons_bg_color_hover = esc_html( et_get_option( 'all_buttons_bg_color_hover' ) );
		if ( empty( $all_buttons_bg_color_hover ) ) {
			$all_buttons_bg_color_hover = 'rgba(0,0,0,.05)';
		}

		$all_buttons_border_width = esc_html( et_get_option( 'all_buttons_border_width' ) );
		if ( empty( $all_buttons_border_width ) ) {
			$all_buttons_border_width = 2;
		}

		$all_buttons_border_color = esc_html( et_get_option( 'all_buttons_border_color' ) );
		if ( empty( $all_buttons_border_color ) ) {
			$all_buttons_border_color = $accent_color;
		}

		$all_buttons_border_color_hover = esc_html( et_get_option( 'all_buttons_border_color_hover' ) );
		if ( empty( $all_buttons_border_color_hover ) ) {
			$all_buttons_border_color_hover = 'transparent';
		}

		$all_buttons_border_radius = esc_html( et_get_option( 'all_buttons_border_radius' ) );
		if ( empty( $all_buttons_border_radius ) ) {
			$all_buttons_border_radius = 3;
		}

		$all_buttons_border_radius_hover = esc_html( et_get_option( 'all_buttons_border_radius_hover' ) );
		if ( empty( $all_buttons_border_radius_hover ) ) {
			$all_buttons_border_radius_hover = 3;
		}

		$all_buttons_spacing = esc_html( et_get_option( 'all_buttons_spacing' ) );
		if ( empty( $all_buttons_spacing ) ) {
			$all_buttons_spacing = 0;
		}

		$all_buttons_spacing_hover = esc_html( et_get_option( 'all_buttons_spacing_hover' ) );
		if ( empty( $all_buttons_spacing_hover ) ) {
			$all_buttons_spacing_hover = 0;
		}

		$all_buttons_font_style = esc_html( et_get_option( 'all_buttons_font_style', '', '', true ) );

		$button_font_style = '';
		if ( '' !== $all_buttons_font_style ) {
			$button_font_style = et_pb_print_font_style( $all_buttons_font_style );
		}

		$all_buttons_font = sanitize_text_field( et_get_option( 'all_buttons_font' ) );
		if ( empty( $all_buttons_font ) ) {
			$all_buttons_font = '';
		} else {
			$all_buttons_font = sanitize_text_field( et_builder_get_font_family( $all_buttons_font ) );
		}

		$custom_css = "body .gform_wrapper #field_submit input,body .gform_wrapper .gform_footer input.button,body .gform_wrapper .gform_page_footer input.button,body div.form_saved_message div.form_saved_message_emailform form input[type=submit]{background-color:{$all_buttons_bg_color};color:{$all_buttons_text_color};border-width:{$all_buttons_border_width}px;border-color:{$all_buttons_border_color};border-radius:{$all_buttons_border_radius}px;{$button_font_style}{$all_buttons_font}font-size:{$all_buttons_font_size}px;letter-spacing:{$all_buttons_spacing}px;}body .gform_wrapper #field_submit input:hover,body .gform_wrapper .gform_footer input.button:hover,body .gform_wrapper .gform_page_footer input.button:hover,body div.form_saved_message div.form_saved_message_emailform form input[type=submit]:hover{background-color:{$all_buttons_bg_color_hover};color:{$all_buttons_text_color_hover};border-color:{$all_buttons_border_color_hover};border-radius:{$all_buttons_border_radius_hover}px;letter-spacing:{$all_buttons_spacing_hover}px;}";
		wp_add_inline_style( 'surbma-divi-gravity-forms-styles', $custom_css );
	}
} );
