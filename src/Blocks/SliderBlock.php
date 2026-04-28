<?php
/**
 * @package BoldSlider
 */

declare(strict_types=1);

namespace BoldSlider\Blocks;

use BoldSlider\Frontend\Shortcode;
use BoldSlider\PostType;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Gutenberg block — wraps the [boldslider] shortcode with a slider picker.
 *
 * The edit UI is intentionally simple: a SelectControl listing all sliders.
 * The block renders server-side by calling the shortcode, so it stays in sync
 * with whatever the slider builder produces.
 */
final class SliderBlock {

	public const NAME = 'boldslider/slider';

	public function register(): void {
		add_action( 'init', array( $this, 'register_block' ) );
		add_action( 'enqueue_block_editor_assets', array( $this, 'enqueue_editor_assets' ) );
	}

	public function enqueue_editor_assets(): void {
		// Load the slider CSS inside the block editor iframe so previews look correct.
		$asset_file = BOLDSLIDER_PATH . 'assets/dist/frontend.asset.php';
		$version    = file_exists( $asset_file )
			? ( include $asset_file )['version'] ?? BOLDSLIDER_VERSION
			: BOLDSLIDER_VERSION;

		wp_enqueue_style(
			'boldslider-frontend',
			BOLDSLIDER_URL . 'assets/dist/frontend.css',
			array(),
			$version
		);

		// Editor-only overrides: force layers into their visible "in" state and
		// reinforce the static-preview wrapper geometry. We attach this to the
		// frontend handle so it loads inside Gutenberg's editor iframe.
		wp_add_inline_style( 'boldslider-frontend', \BoldSlider\Render\Renderer::preview_css() );
	}

	public function register_block(): void {
		if ( ! function_exists( 'register_block_type' ) ) {
			return;
		}

		// Block-edit JS is bundled with the editor entry — see editor/src/blocks/slider.js
		wp_register_script(
			'boldslider-block',
			BOLDSLIDER_URL . 'assets/dist/block.js',
			array( 'wp-blocks', 'wp-element', 'wp-components', 'wp-i18n', 'wp-block-editor', 'wp-server-side-render' ),
			BOLDSLIDER_VERSION,
			true
		);

		// Expose builder URL so the block's Edit button can link to the correct slider.
		wp_localize_script( 'boldslider-block', 'boldslider_block_data', self::block_editor_data() );

		register_block_type( self::NAME, array(
			'api_version'     => 3,
			'title'           => __( 'BoldSlider', 'boldslider' ),
			'description'     => __( 'Embed a BoldSlider in any post or page.', 'boldslider' ),
			'category'        => 'media',
			'icon'            => 'images-alt2',
			'editor_script'   => 'boldslider-block',
			'attributes'      => array(
				'sliderId' => array(
					'type'    => 'integer',
					'default' => 0,
				),
				// align is handled by supports.align in JS; declare it here so the
				// REST API doesn't reject it as an unknown parameter when the block
				// is set to wide or full width.
				'align'    => array(
					'type'    => 'string',
					'enum'    => array( '', 'wide', 'full' ),
					'default' => '',
				),
			),
			'render_callback' => array( $this, 'render_block' ),
		) );
	}

	public function render_block( array $attributes ): string {
		$id       = (int) ( $attributes['sliderId'] ?? 0 );
		$in_editor = defined( 'REST_REQUEST' ) && REST_REQUEST;

		if ( $id <= 0 ) {
			if ( $in_editor ) {
				return '<div style="padding:24px;border:1px dashed #c0c4cc;border-radius:6px;color:#646970;text-align:center;">'
					. esc_html__( 'BoldSlider — pick a slider in the block sidebar.', 'boldslider' )
					. '</div>';
			}
			return '';
		}

		if ( $in_editor ) {
			return ( new \BoldSlider\Render\Renderer() )->render_preview( $id );
		}

		return do_shortcode( '[' . Shortcode::TAG . ' id="' . $id . '"]' );
	}

	/**
	 * Helper for the block's edit JS — exposes a simple list of sliders + the editor URL.
	 */
	public static function block_editor_data(): array {
		$sliders = array();
		$query = new \WP_Query( array(
			'post_type'      => PostType::SLUG,
			'post_status'    => array( 'publish', 'draft' ),
			'posts_per_page' => 200,
			'orderby'        => 'date',
			'order'          => 'DESC',
			'no_found_rows'  => true,
		) );
		foreach ( $query->posts as $post ) {
			$sliders[] = array(
				'id'    => (int) $post->ID,
				'title' => (string) $post->post_title,
			);
		}
		return array(
			'sliders'    => $sliders,
			'listUrl'    => admin_url( 'admin.php?page=boldslider' ),
			'newUrl'     => admin_url( 'admin.php?page=boldslider' ),
			'builderUrl' => admin_url( 'admin.php?page=boldslider-builder' ),
		);
	}
}
