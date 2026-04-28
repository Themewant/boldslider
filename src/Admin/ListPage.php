<?php
/**
 * @package BoldSlider
 */

declare(strict_types=1);

namespace BoldSlider\Admin;

use BoldSlider\Rest\Controller as RestController;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class ListPage {

	public const MENU_SLUG = 'boldslider';
	public const ROOT_ID   = 'boldslider-list-root';
	public const HANDLE    = 'boldslider-editor';

	public function register(): void {
		add_action( 'admin_menu', array( $this, 'add_menu' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue' ) );
		add_action( 'admin_head', array( $this, 'clean_page_chrome' ) );
	}

	public function add_menu(): void {
		add_menu_page(
			__( 'BoldSlider', 'boldslider' ),
			__( 'BoldSlider', 'boldslider' ),
			'edit_posts',
			self::MENU_SLUG,
			array( $this, 'render' ),
			'dashicons-images-alt2',
			30
		);
	}

	public function enqueue( string $hook_suffix ): void {
		if ( 'toplevel_page_' . self::MENU_SLUG !== $hook_suffix ) {
			return;
		}

		$this->enqueue_bundle();

		$builder_base = admin_url( 'admin.php?page=' . BuilderPage::MENU_SLUG . '&id=' );

		wp_add_inline_script(
			self::HANDLE,
			sprintf(
				'window.BoldSliderEditor = %s;',
				wp_json_encode( array(
					'view'       => 'list',
					'restRoot'   => esc_url_raw( rest_url( RestController::NAMESPACE_V1 ) ),
					'restNonce'  => wp_create_nonce( 'wp_rest' ),
					'builderUrl' => $builder_base,
				) )
			),
			'before'
		);
	}

	public function clean_page_chrome(): void {
		$screen = function_exists( 'get_current_screen' ) ? get_current_screen() : null;
		if ( ! $screen || 'toplevel_page_' . self::MENU_SLUG !== $screen->id ) {
			return;
		}
		// Remove all notice hooks so nothing renders above our React root.
		remove_all_actions( 'admin_notices' );
		remove_all_actions( 'all_admin_notices' );
		remove_all_actions( 'user_admin_notices' );
		?>
		<style id="boldslider-list-chrome">
			/* Hide the default WP page heading and any leftover notice markup */
			.toplevel_page_boldslider .wrap > h1,
			.toplevel_page_boldslider .wp-header-end,
			#wpbody-content > .notice,
			#wpbody-content > .updated,
			#wpbody-content > .update-nag,
			#wpbody-content > .error { display: none !important; }
			/* Let our React root span the full content area */
			.toplevel_page_boldslider #wpbody-content,
			.toplevel_page_boldslider .wrap { padding: 0; margin: 0; }
		</style>
		<?php
	}

	public function render(): void {
		printf( '<div id="%s"></div>', esc_attr( self::ROOT_ID ) );
	}

	public static function enqueue_bundle(): void {
		$asset_file = BOLDSLIDER_PATH . 'assets/dist/editor.asset.php';
		$asset      = file_exists( $asset_file )
			? include $asset_file
			: array( 'dependencies' => array( 'wp-element', 'wp-api-fetch', 'wp-components', 'wp-i18n' ), 'version' => BOLDSLIDER_VERSION );

		wp_enqueue_style(
			self::HANDLE,
			BOLDSLIDER_URL . 'assets/dist/editor.css',
			array( 'wp-components' ),
			$asset['version'] ?? BOLDSLIDER_VERSION
		);

		wp_enqueue_script(
			self::HANDLE,
			BOLDSLIDER_URL . 'assets/dist/editor.js',
			$asset['dependencies'] ?? array(),
			$asset['version'] ?? BOLDSLIDER_VERSION,
			array( 'in_footer' => true, 'strategy' => 'defer' )
		);

		wp_set_script_translations( self::HANDLE, 'boldslider' );
	}
}
