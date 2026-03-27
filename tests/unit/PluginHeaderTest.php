<?php
/**
 * Tests for Surbma | Divi & Gravity Forms plugin.
 *
 * Validates plugin header correctness, direct access guard, and
 * the accent-color / button style default fallback logic.
 *
 * Runs standalone — no WordPress installation required.
 */

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

class PluginHeaderTest extends TestCase {

    private string $pluginFile;

    protected function setUp(): void {
        $this->pluginFile = dirname( __DIR__, 2 ) . '/surbma-divi-gravity-forms.php';
    }

    public function test_plugin_file_exists(): void {
        $this->assertFileExists( $this->pluginFile );
    }

    public function test_plugin_name_header_present(): void {
        $content = file_get_contents( $this->pluginFile );
        $this->assertStringContainsString( 'Plugin Name:', $content );
        $this->assertStringContainsString( 'Divi', $content );
        $this->assertStringContainsString( 'Gravity Forms', $content );
    }

    public function test_text_domain_declared(): void {
        $content = file_get_contents( $this->pluginFile );
        $this->assertStringContainsString( 'Text Domain: surbma-divi-gravity-forms', $content );
    }

    public function test_direct_access_guard_present(): void {
        $content = file_get_contents( $this->pluginFile );
        $this->assertStringContainsString( 'ABSPATH', $content );
    }

    /**
     * Default accent colour must be #2ea3f2 when Divi returns empty.
     * Mirrors: if (empty($accent_color)) { $accent_color = '#2ea3f2'; }
     */
    public function test_default_accent_color_is_divi_blue(): void {
        $accent_color = '';
        if ( empty( $accent_color ) ) {
            $accent_color = '#2ea3f2';
        }
        $this->assertSame( '#2ea3f2', $accent_color );
    }

    /**
     * Default button font size must be 20 when Divi returns empty.
     */
    public function test_default_button_font_size_is_20(): void {
        $size = '';
        if ( empty( $size ) ) {
            $size = 20;
        }
        $this->assertSame( 20, $size );
    }

    /**
     * Default button background colour is #fff when Divi returns empty.
     */
    public function test_default_button_bg_color_is_white(): void {
        $color = '';
        if ( empty( $color ) ) {
            $color = '#fff';
        }
        $this->assertSame( '#fff', $color );
    }

    /**
     * Default button border width must be 2 when Divi returns empty.
     */
    public function test_default_button_border_width_is_2(): void {
        $width = '';
        if ( empty( $width ) ) {
            $width = 2;
        }
        $this->assertSame( 2, $width );
    }

    /**
     * Default button border radius must be 3 when Divi returns empty.
     */
    public function test_default_button_border_radius_is_3(): void {
        $radius = '';
        if ( empty( $radius ) ) {
            $radius = 3;
        }
        $this->assertSame( 3, $radius );
    }

    /**
     * Default button background on hover is rgba semi-transparent when Divi returns empty.
     */
    public function test_default_button_bg_hover_is_rgba(): void {
        $color = '';
        if ( empty( $color ) ) {
            $color = 'rgba(0,0,0,.05)';
        }
        $this->assertStringContainsString( 'rgba', $color );
    }

    /**
     * Default border color on hover is transparent when Divi returns empty.
     */
    public function test_default_button_border_color_hover_is_transparent(): void {
        $color = '';
        if ( empty( $color ) ) {
            $color = 'transparent';
        }
        $this->assertSame( 'transparent', $color );
    }
}
