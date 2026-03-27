<?php
/**
 * Minimal WordPress function stubs for Divi & Gravity Forms unit tests.
 */

if ( ! defined( 'ABSPATH' ) ) {
    define( 'ABSPATH', sys_get_temp_dir() . '/wp/' );
}

if ( ! function_exists( 'plugin_basename' ) ) {
    function plugin_basename( string $file ): string {
        return basename( dirname( $file ) ) . '/' . basename( $file );
    }
}

if ( ! function_exists( 'plugins_url' ) ) {
    function plugins_url( string $path = '', string $plugin = '' ): string {
        return 'http://example.com/wp-content/plugins' . ( $path ? '/' . ltrim( $path, '/' ) : '' );
    }
}

if ( ! function_exists( 'add_action' ) ) {
    function add_action( string $hook, $callback, int $priority = 10, int $args = 1 ): bool {
        return true;
    }
}

if ( ! function_exists( 'add_filter' ) ) {
    function add_filter( string $hook, $callback, int $priority = 10, int $args = 1 ): bool {
        return true;
    }
}

if ( ! function_exists( 'wp_enqueue_style' ) ) {
    function wp_enqueue_style(): void {}
}

if ( ! function_exists( 'wp_add_inline_style' ) ) {
    function wp_add_inline_style(): void {}
}
