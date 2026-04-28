<?php
/**
 * @package BoldSlider
 */

declare(strict_types=1);

namespace BoldSlider\Elementor;

use BoldSlider\Frontend\Shortcode;
use BoldSlider\PostType;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Elementor widget for embedding BoldSlider sliders.
 */
final class SliderWidget extends Widget_Base {

	public function get_name(): string {
		return 'boldslider_slider';
	}

	public function get_title(): string {
		return __( 'BoldSlider', 'boldslider' );
	}

	public function get_icon(): string {
		return 'eicon-slider-full';
	}

	public function get_categories(): array {
		return [ 'media' ];
	}

	public function get_keywords(): array {
		return [ 'slider', 'carousel', 'boldslider' ];
	}

	protected function register_controls(): void {
		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Content', 'boldslider' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'slider_id',
			[
				'label'       => __( 'Select Slider', 'boldslider' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => $this->get_sliders_options(),
				'default'     => '',
				'label_block' => true,
				'description' => __( 'After selecting, an "Edit in Builder" button appears below the preview.', 'boldslider' ),
			]
		);

		$this->end_controls_section();
	}

	protected function render(): void {
		$settings  = $this->get_settings_for_display();
		$slider_id = (int) $settings['slider_id'];
		$is_edit   = \Elementor\Plugin::$instance->editor->is_edit_mode();

		if ( $slider_id <= 0 ) {
			if ( $is_edit ) {
				echo '<div style="padding:24px;border:1px dashed #c0c4cc;border-radius:6px;color:#646970;text-align:center;">'
					. esc_html__( 'BoldSlider — please select a slider from the panel on the left.', 'boldslider' )
					. '</div>';
			}
			return;
		}

		if ( $is_edit ) {
			// Static first-slide preview — no Swiper JS needed in editor.
			echo ( new \BoldSlider\Render\Renderer() )->render_preview( $slider_id ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

			// "Edit in Builder" button rendered directly with the correct URL.
			// No JS required — the slider ID is known at render time.
			$builder_url = admin_url( 'admin.php?page=boldslider-builder&id=' . $slider_id );
			printf(
				'<div style="text-align:center;padding:6px 8px;background:rgba(0,0,0,0.04);border-top:1px solid rgba(0,0,0,0.1);">'
				. '<a href="%s" target="_blank" '
				. 'style="display:inline-block;padding:5px 16px;background:#2271b1;color:#fff;'
				. 'border-radius:4px;text-decoration:none;font-size:12px;font-weight:600;line-height:1.6;">'
				. '%s &#8599;</a></div>',
				esc_url( $builder_url ),
				esc_html__( 'Edit Slider in Builder', 'boldslider' )
			);
			return;
		}

		echo do_shortcode( '[' . Shortcode::TAG . ' id="' . $slider_id . '"]' );
	}

	public function render_plain_content(): void {
		$settings  = $this->get_settings_for_display();
		$slider_id = (int) $settings['slider_id'];

		if ( $slider_id > 0 ) {
			echo do_shortcode( '[' . Shortcode::TAG . ' id="' . $slider_id . '"]' );
		}
	}

	private function get_sliders_options(): array {
		$options = [ '' => __( '— Select a slider —', 'boldslider' ) ];

		$query = new \WP_Query( [
			'post_type'      => PostType::SLUG,
			'post_status'    => [ 'publish', 'draft' ],
			'posts_per_page' => 200,
			'orderby'        => 'date',
			'order'          => 'DESC',
			'no_found_rows'  => true,
		] );

		foreach ( $query->posts as $post ) {
			$status_label               = 'draft' === $post->post_status ? ' (Draft)' : '';
			$options[ (int) $post->ID ] = ( $post->post_title ?: ( '#' . $post->ID ) ) . $status_label;
		}

		return $options;
	}
}
