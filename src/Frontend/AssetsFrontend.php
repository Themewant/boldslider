<?php
/**
 * @package BoldSlider
 */

declare(strict_types=1);

namespace BoldSlider\Frontend;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class AssetsFrontend {

	public const HANDLE = 'boldslider-frontend';

	public function register(): void {
		add_action( 'wp_enqueue_scripts', array( $this, 'register_assets' ), 5 );
		add_action( 'wp', array( $this, 'maybe_enqueue_for_post' ) );
	}

	public function register_assets(): void {
		$asset_file = BOLDSLIDER_PATH . 'assets/dist/frontend.asset.php';
		$asset      = file_exists( $asset_file )
			? include $asset_file
			: array( 'dependencies' => array(), 'version' => BOLDSLIDER_VERSION );

		$js_url  = BOLDSLIDER_URL . 'assets/dist/frontend.js';
		$css_url = BOLDSLIDER_URL . 'assets/dist/frontend.css';

		if ( file_exists( BOLDSLIDER_PATH . 'assets/dist/frontend.css' ) ) {
			wp_register_style(
				self::HANDLE,
				$css_url,
				array(),
				$asset['version'] ?? BOLDSLIDER_VERSION
			);
		}

		if ( file_exists( BOLDSLIDER_PATH . 'assets/dist/frontend.js' ) ) {
			wp_register_script(
				self::HANDLE,
				$js_url,
				$asset['dependencies'] ?? array(),
				$asset['version'] ?? BOLDSLIDER_VERSION,
				array(
					'in_footer' => true,
					'strategy'  => 'defer',
				)
			);
		}
	}

	public function maybe_enqueue_for_post(): void {
		if ( is_admin() ) {
			return;
		}
		$post = get_post();
		if ( ! $post instanceof \WP_Post ) {
			return;
		}
		if ( has_shortcode( (string) $post->post_content, 'boldslider' ) ) {
			self::ensure_enqueued();
		}
	}

	public static function ensure_enqueued(): void {
		// When called before wp_enqueue_scripts fires (e.g. on template_redirect
		// for the preview route), the handles aren't registered yet. Force registration —
		// wp_register_* is idempotent so this is safe to call any number of times.
		if ( ! wp_style_is( self::HANDLE, 'registered' ) || ! wp_script_is( self::HANDLE, 'registered' ) ) {
			( new self() )->register_assets();
		}
		if ( wp_style_is( self::HANDLE, 'registered' ) ) {
			wp_enqueue_style( self::HANDLE );
		}
		if ( wp_script_is( self::HANDLE, 'registered' ) ) {
			wp_enqueue_script( self::HANDLE );
		}
	}
}
