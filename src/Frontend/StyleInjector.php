<?php
/**
 * @package BoldSlider
 */

declare(strict_types=1);

namespace BoldSlider\Frontend;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Manages inline CSS injection for sliders via wp_add_inline_style().
 * This centralizes all responsive CSS, preview CSS, and other dynamic styles
 * to comply with WordPress enqueue standards.
 */
final class StyleInjector {

	private static array $styles_to_inject = array();

	public function register(): void {
		add_action( 'wp_enqueue_scripts', array( $this, 'inject_styles' ), 11 );
		add_action( 'admin_enqueue_scripts', array( $this, 'inject_admin_styles' ), 11 );
	}

	/**
	 * Queue a style to be injected via wp_add_inline_style on the next enqueue.
	 *
	 * @param string $id Unique identifier for this style block.
	 * @param string $css CSS content to inject.
	 * @param string $dependency Handle of the script/style this depends on (default: boldslider-frontend).
	 */
	public static function queue_style( string $id, string $css, string $dependency = AssetsFrontend::HANDLE ): void {
		self::$styles_to_inject[ $id ] = array(
			'css'        => $css,
			'dependency' => $dependency,
		);
	}

	public function inject_styles(): void {
		foreach ( self::$styles_to_inject as $id => $data ) {
			if ( wp_style_is( $data['dependency'], 'enqueued' ) || wp_script_is( $data['dependency'], 'enqueued' ) ) {
				// $data['css'] is built by build_responsive_css() which properly escapes all
				// dynamic values with esc_attr(). wp_add_inline_style() handles injection safely.
				wp_add_inline_style( $data['dependency'], $data['css'] );
			}
		}
		self::$styles_to_inject = array();
	}

	public function inject_admin_styles(): void {
		// Admin styles use the editor handle as dependency.
		foreach ( self::$styles_to_inject as $id => $data ) {
			if ( 'boldslider-admin' === $data['dependency'] ) {
				// $data['css'] is built by build_responsive_css() which properly escapes all
				// dynamic values with esc_attr(). wp_add_inline_style() handles injection safely.
				wp_add_inline_style( $data['dependency'], $data['css'] );
			}
		}
		self::$styles_to_inject = array();
	}
}
