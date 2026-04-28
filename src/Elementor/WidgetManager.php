<?php
/**
 * @package BoldSlider
 */

declare(strict_types=1);

namespace BoldSlider\Elementor;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Manages Elementor widget registration for BoldSlider.
 */
final class WidgetManager {

	public function register(): void {
		add_action( 'elementor/widgets/register', array( $this, 'register_widgets' ) );
		// Load frontend CSS inside Elementor's canvas iframe so the preview renders correctly.
		add_action( 'elementor/preview/enqueue_styles', array( $this, 'enqueue_preview_assets' ) );
	}

	public function register_widgets( $widgets_manager ): void {
		if ( ! did_action( 'elementor/loaded' ) ) {
			return;
		}
		$widgets_manager->register( new SliderWidget() );
	}

	public function enqueue_preview_assets(): void {
		\BoldSlider\Frontend\AssetsFrontend::ensure_enqueued();
		// Editor-only overrides: force layers into their visible "in" state and
		// reinforce the static-preview wrapper geometry inside Elementor's canvas.
		wp_add_inline_style(
			\BoldSlider\Frontend\AssetsFrontend::HANDLE,
			\BoldSlider\Render\Renderer::preview_css()
		);
	}
}
