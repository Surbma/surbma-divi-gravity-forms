<?php
/**
 * PHPUnit bootstrap for Surbma | Divi & Gravity Forms plugin tests.
 *
 * Unit tests run standalone. Integration tests require WP_TESTS_DIR.
 */

if ( file_exists( __DIR__ . '/../vendor/yoast/phpunit-polyfills/phpunitpolyfills-autoload.php' ) ) {
    require_once __DIR__ . '/../vendor/yoast/phpunit-polyfills/phpunitpolyfills-autoload.php';
}

require_once __DIR__ . '/stubs/wordpress-stubs.php';

if ( ! defined( 'SURBMA_DIVI_GF_LOADED' ) ) {
    define( 'SURBMA_DIVI_GF_LOADED', true );
    require dirname( __DIR__ ) . '/surbma-divi-gravity-forms.php';
}
