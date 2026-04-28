<?php
/**
 * @package BoldSlider
 */

declare(strict_types=1);

namespace BoldSlider\Frontend;

use BoldSlider\PostType;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Full-screen preview page for a slider, rendered via the shortcode.
 *
 * URL: /?boldslider_preview=<post_id>
 */
final class PreviewRoute {

	public const QUERY_VAR = 'boldslider_preview';

	public function register(): void {
		add_action( 'template_redirect', array( $this, 'maybe_render' ) );
	}

	public function maybe_render(): void {
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- read-only preview gated by capability check below
		if ( empty( $_GET[ self::QUERY_VAR ] ) ) {
			return;
		}
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- read-only preview gated by capability check below
		$id = isset( $_GET[ self::QUERY_VAR ] ) ? absint( wp_unslash( $_GET[ self::QUERY_VAR ] ) ) : 0;
		if ( $id <= 0 ) {
			return;
		}

		$post = get_post( $id );
		if ( ! $post instanceof \WP_Post || PostType::SLUG !== $post->post_type ) {
			wp_die( esc_html__( 'Slider not found.', 'boldslider' ), '', array( 'response' => 404 ) );
		}
		if ( ! current_user_can( 'edit_post', $id ) ) {
			wp_die( esc_html__( 'You cannot preview this slider.', 'boldslider' ), '', array( 'response' => 403 ) );
		}

		nocache_headers();
		AssetsFrontend::ensure_enqueued();

		$html = do_shortcode( '[boldslider id="' . $id . '"]' );
		?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<title><?php echo esc_html( sprintf( /* translators: %s: slider title */ __( 'Preview — %s', 'boldslider' ), $post->post_title ) ); ?></title>
	<?php wp_head(); ?>
	<style>
		html, body { margin: 0; padding: 0; background: #0f1114; color: #f0f0f1; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; }
		.bs-preview-bar { position: fixed; top: 0; left: 0; right: 0; z-index: 99999; display: flex; align-items: center; justify-content: space-between; padding: 10px 20px; background: rgba( 28, 32, 38, 0.95 ); backdrop-filter: blur( 8px ); border-bottom: 1px solid #2d3136; font-size: 13px; }
		.bs-preview-bar__title { font-weight: 600; display: flex; align-items: center; gap: 8px; }
		.bs-preview-bar__title .dot { width: 8px; height: 8px; border-radius: 50%; background: #46b450; }
		.bs-preview-bar__actions { display: flex; gap: 10px; }
		.bs-preview-bar a, .bs-preview-bar button { color: #c8d2dd; text-decoration: none; background: transparent; border: 1px solid #2d3136; border-radius: 4px; padding: 5px 12px; font-size: 12px; cursor: pointer; font-family: inherit; }
		.bs-preview-bar a:hover, .bs-preview-bar button:hover { color: #fff; border-color: #4a5566; }
		.bs-preview-stage { padding-top: 56px; min-height: 100vh; box-sizing: border-box; display: flex; align-items: center; justify-content: center; padding-left: 20px; padding-right: 20px; padding-bottom: 40px; }
		.bs-preview-stage > * { width: 100%; max-width: 1400px; }
	</style>
</head>
<body>
	<div class="bs-preview-bar">
		<div class="bs-preview-bar__title">
			<span class="dot"></span>
			<?php echo esc_html( __( 'Preview:', 'boldslider' ) . ' ' . $post->post_title ); ?>
		</div>
		<div class="bs-preview-bar__actions">
			<a href="<?php echo esc_url( admin_url( 'admin.php?page=boldslider-builder&id=' . $id ) ); ?>"><?php esc_html_e( 'Back to Builder', 'boldslider' ); ?></a>
			<button type="button" onclick="window.close()"><?php esc_html_e( 'Close', 'boldslider' ); ?></button>
		</div>
	</div>
	<div class="bs-preview-stage">
		<?php echo $html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
	</div>
	<?php wp_footer(); ?>
</body>
</html>
		<?php
		exit;
	}
}
