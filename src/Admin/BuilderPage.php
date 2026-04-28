<?php
/**
 * @package BoldSlider
 */

declare(strict_types=1);

namespace BoldSlider\Admin;

use BoldSlider\Rest\Controller as RestController;
use BoldSlider\Render\Fonts;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class BuilderPage {

	public const MENU_SLUG = 'boldslider-builder';
	public const ROOT_ID   = 'boldslider-builder-root';

	public function register(): void {
		add_action( 'admin_menu', array( $this, 'add_page' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue' ) );
		add_action( 'admin_head', array( $this, 'fullscreen_css' ) );
	}

	public function add_page(): void {
		// Registered under a blank parent so it is navigable but not shown in the menu.
		add_submenu_page(
			'',
			__( 'Slider Builder — BoldSlider', 'boldslider' ),
			__( 'Slider Builder', 'boldslider' ),
			'edit_posts',
			self::MENU_SLUG,
			array( $this, 'render' )
		);
	}

	public function enqueue( string $hook_suffix ): void {
		// WP generates the hook as 'admin_page_<slug>' for blank-parent submenus.
		if ( 'admin_page_' . self::MENU_SLUG !== $hook_suffix ) {
			return;
		}

		ListPage::enqueue_bundle();
		wp_enqueue_media();
		// NOTE: Google Fonts are intentionally NOT loaded from the Google CDN here.
		// WordPress.org plugin guidelines disallow third-party CDN requests.
		// The Pro add-on can self-host or use the WPTT WebFont Loader to enable
		// Google Fonts compliantly. The font picker in the builder still lists
		// Google font names — they fall back to the user's theme stack in the free
		// version unless the theme already loads them.

		// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- read-only admin page id; the page itself is capability-gated by add_submenu_page().
		$post_id = isset( $_GET['id'] ) ? absint( wp_unslash( $_GET['id'] ) ) : 0;

		wp_add_inline_script(
			ListPage::HANDLE,
			sprintf(
				'window.BoldSliderEditor = %s;',
				wp_json_encode( array(
					'view'       => 'builder',
					'postId'     => $post_id,
					'restRoot'   => esc_url_raw( rest_url( RestController::NAMESPACE_V1 ) ),
					'restNonce'  => wp_create_nonce( 'wp_rest' ),
					'listUrl'    => admin_url( 'admin.php?page=' . ListPage::MENU_SLUG ),
					'previewUrl' => esc_url_raw( add_query_arg( 'boldslider_preview', $post_id, home_url( '/' ) ) ),
					'shortcode'  => self::build_shortcode( $post_id ),
				) )
			),
			'before'
		);
	}

	public function render(): void {
		// Server-render a dark loading shell *inside* the root. React replaces
		// its children once mounted, so the user never sees an empty white area
		// or a flash of WP admin chrome.
		?>
		<div id="<?php echo esc_attr( self::ROOT_ID ); ?>">
			<div class="bs-loading-shell" aria-live="polite">
				<div class="bs-loading-shell__spinner" aria-hidden="true"></div>
				<span class="bs-loading-shell__text">
					<?php esc_html_e( 'Loading builder…', 'boldslider' ); ?>
				</span>
			</div>
		</div>
		<?php
	}

	public function fullscreen_css(): void {
		$screen = function_exists( 'get_current_screen' ) ? get_current_screen() : null;
		if ( ! $screen || 'admin_page_' . self::MENU_SLUG !== $screen->id ) {
			return;
		}
		?>
		<style id="boldslider-fullscreen">
			/* Hide WP admin chrome immediately — must beat any later admin stylesheet. */
			#wpadminbar,
			#adminmenumain,
			#adminmenuback,
			#adminmenu { display: none !important; }

			/* Force the dark builder background from the very first paint so there's
			   no flash of light WP-admin grey before React mounts. */
			html,
			body {
				padding-top: 0 !important;
				margin: 0 !important;
				background: #13161a !important;
			}
			body.wp-admin { background: #13161a !important; }

			#wpcontent,
			#wpbody,
			#wpbody-content {
				margin-left: 0 !important;
				padding-top: 0 !important;
				float: none;
				background: #13161a !important;
			}

			.wrap { margin: 0 !important; padding: 0 !important; }

			#<?php echo esc_attr( self::ROOT_ID ); ?> {
				position: fixed;
				inset: 0;
				z-index: 9999;
				overflow: hidden;
				background: #13161a;
			}

			/* ── Server-rendered loading shell (replaced by React on mount) ── */
			.bs-loading-shell {
				position: absolute;
				inset: 0;
				display: flex;
				flex-direction: column;
				align-items: center;
				justify-content: center;
				gap: 14px;
				background: #13161a;
				color: #b0b6bf;
				font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
			}
			.bs-loading-shell__spinner {
				width: 36px;
				height: 36px;
				border: 3px solid #2d3136;
				border-top-color: #2271b1;
				border-radius: 50%;
				animation: bs-loading-spin 0.7s linear infinite;
			}
			.bs-loading-shell__text {
				font-size: 13px;
				font-weight: 500;
				letter-spacing: .01em;
			}
			@keyframes bs-loading-spin {
				to { transform: rotate( 360deg ); }
			}
		</style>
		<?php
	}

	/**
	 * Build a `[boldslider id="<slug>"]` shortcode string for a slider post.
	 * Falls back to the numeric ID when the slug is empty or auto-generated.
	 */
	public static function build_shortcode( int $post_id ): string {
		$post = get_post( $post_id );
		if ( ! $post instanceof \WP_Post ) {
			return '';
		}
		$slug = (string) $post->post_name;
		// `wp_insert_post` may not have a slug yet for very fresh posts — fall back to id.
		$identifier = '' !== $slug ? $slug : (string) $post_id;
		return sprintf( '[boldslider id="%s"]', esc_attr( $identifier ) );
	}
}
