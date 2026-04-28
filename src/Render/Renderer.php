<?php
/**
 * @package BoldSlider
 */

declare(strict_types=1);

namespace BoldSlider\Render;

use BoldSlider\Models\SliderRepository;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Renderer {

	public function render( int $slider_id ): string {
		$data = SliderRepository::get( $slider_id );

		if ( empty( $data['slides'] ) ) {
			return '';
		}

		$template = TemplateLoader::locate( 'slider.php' );
		if ( ! is_readable( $template ) ) {
			return '';
		}

		$settings = $data['settings'];
		$slides   = $data['slides'];

		ob_start();
		include $template;
		return (string) ob_get_clean();
	}

	/**
	 * Render a static (non-interactive) preview of the first slide.
	 * Used in Gutenberg ServerSideRender and Elementor editor — no Swiper JS needed.
	 * Mirrors the real slider.php HTML structure so all existing CSS applies correctly.
	 */
	public function render_preview( int $slider_id ): string {
		$data = SliderRepository::get( $slider_id );

		if ( empty( $data['slides'] ) ) {
			return '<div style="padding:24px;border:1px dashed #c0c4cc;border-radius:6px;color:#646970;text-align:center;">'
				. esc_html__( 'BoldSlider — no slides found.', 'boldslider' )
				. '</div>';
		}

		// Ensure frontend CSS is loaded in any context (editor iframes, etc.).
		\BoldSlider\Frontend\AssetsFrontend::ensure_enqueued();

		$settings      = $data['settings'];
		$slide         = $data['slides'][0];
		$canvas_w      = (int) $settings['canvas_width'];
		$canvas_h      = (int) $settings['canvas_height'];
		$aspect_ratio  = $canvas_w > 0 ? ( $canvas_w . ' / ' . $canvas_h ) : '16 / 9';
		$is_fullscreen = ! empty( $settings['full_screen'] );
		$show_nav      = ! empty( $settings['navigation'] );

		// Use the same DOM ID as the real render so build_responsive_css scoping works.
		// Safe in editor context because the frontend render never runs here.
		$dom_id = 'boldslider-' . $slider_id;

		// Match all classes from the real slider template.
		$wrap_classes = array(
			'boldslider-wrap',
			'boldslider-preview',
			'is-effect-' . sanitize_html_class( (string) ( $settings['effect'] ?? 'slide' ) ),
			'is-direction-' . sanitize_html_class( (string) ( $settings['direction'] ?? 'horizontal' ) ),
			'bs-nav-' . sanitize_html_class( (string) ( $settings['nav_placement'] ?? 'inside' ) ),
			'bs-nav-pos-' . sanitize_html_class( (string) ( $settings['nav_position'] ?? 'middle' ) ),
		);

		$nav_color = (string) ( $settings['nav_color'] ?? '#ffffff' );
		$pag_color = (string) ( $settings['pagination_color'] ?? '#ffffff' );

		$vars = '--boldslider-canvas-w:' . $canvas_w . 'px;'
			. '--boldslider-canvas-h:' . $canvas_h . 'px;'
			. '--boldslider-scale:1;'
			. '--swiper-navigation-color:' . esc_attr( $nav_color ) . ';'
			. '--swiper-pagination-color:' . esc_attr( $pag_color ) . ';'
			. '--bs-nav-size:' . (int) ( $settings['nav_size'] ?? 44 ) . 'px;'
			. '--bs-nav-offset:' . (int) ( $settings['nav_offset'] ?? 12 ) . 'px;';

		$wrap_style = ( $is_fullscreen ? 'height:400px;' : 'aspect-ratio:' . esc_attr( $aspect_ratio ) . ';' ) . $vars;

		// Slide background — same logic as slider.php.
		$slide_image_id  = (int) ( $slide['image_id'] ?? 0 );
		$slide_image_url = $slide_image_id > 0 ? (string) wp_get_attachment_image_url( $slide_image_id, 'large' ) : '';
		$slide_bg_color  = (string) ( $slide['bg_color'] ?? '' );

		$bg_fit      = (string) ( $slide['bg_fit'] ?? 'cover' );
		$bg_repeat   = (string) ( $slide['bg_repeat'] ?? 'no-repeat' );
		$bg_position = (string) ( $slide['bg_position'] ?? 'middle-center' );
		$bg_size     = 'cover';
		if ( 'percentage' === $bg_fit ) {
			$bg_size = (int) ( $slide['bg_size_x'] ?? 100 ) . '% ' . (int) ( $slide['bg_size_y'] ?? 100 ) . '%';
		} elseif ( in_array( $bg_fit, array( 'contain', 'auto' ), true ) ) {
			$bg_size = $bg_fit;
		}
		$pos_map = array(
			'top-left' => '0% 0%', 'top-center' => '50% 0%', 'top-right' => '100% 0%',
			'middle-left' => '0% 50%', 'middle-center' => '50% 50%', 'middle-right' => '100% 50%',
			'bottom-left' => '0% 100%', 'bottom-center' => '50% 100%', 'bottom-right' => '100% 100%',
		);
		$bg_pos_css = 'custom' === $bg_position
			? ( (int) ( $slide['bg_position_x'] ?? 50 ) . '% ' . (int) ( $slide['bg_position_y'] ?? 50 ) . '%' )
			: ( $pos_map[ $bg_position ] ?? '50% 50%' );

		$slide_inline = $slide_bg_color ? 'background-color:' . esc_attr( $slide_bg_color ) . ';' : '';

		// Scoped CSS for nav colors, layer responsive overrides, etc.
		$responsive_css = self::build_responsive_css( array( $slide ), $canvas_w, $canvas_h, $slider_id, $settings );

		ob_start();
		?>
		<div class="<?php echo esc_attr( implode( ' ', $wrap_classes ) ); ?>" id="<?php echo esc_attr( $dom_id ); ?>" style="<?php echo esc_attr( $wrap_style ); ?>">

			<?php // Inline CSS: make the Swiper-less inner container fill the wrap, and force layers
			// into their visible "in" state since no JS runs to add .bs-anim-in.
			// esc_html() is the correct escaper for content inside <style> tags. ?>
			<style>
			#<?php echo esc_html( $dom_id ); ?>.boldslider-preview > .boldslider-preview-inner {
				position: absolute;
				inset: 0;
				overflow: hidden;
			}
			#<?php echo esc_html( $dom_id ); ?>.boldslider-preview > .boldslider-preview-inner > .boldslider-slide {
				position: absolute;
				inset: 0;
				width: 100%;
				height: 100%;
			}
			#<?php echo esc_html( $dom_id ); ?>.boldslider-preview .boldslider-layer {
				--bs-opacity: 1;
				--bs-tx: 0px;
				--bs-ty: 0px;
				--bs-scale: 1;
			}
			</style>

			<div class="boldslider-preview-inner">
				<div class="boldslider-slide"<?php echo $slide_inline ? ' style="' . esc_attr( $slide_inline ) . '"' : ''; ?>>

					<?php if ( '' !== $slide_image_url ) :
						$visual_style = 'background-image:url(' . esc_url( $slide_image_url ) . ');'
							. 'background-size:' . esc_attr( $bg_size ) . ';'
							. 'background-repeat:' . esc_attr( $bg_repeat ) . ';'
							. 'background-position:' . esc_attr( $bg_pos_css ) . ';';
					?>
						<div class="boldslider-slide__bg-visual" style="<?php echo esc_attr( $visual_style ); ?>" aria-hidden="true"></div>
					<?php endif; ?>

					<?php if ( ! empty( $slide['layers'] ) ) : ?>
						<div class="boldslider-slide__canvas" aria-hidden="false">
							<?php foreach ( $slide['layers'] as $layer ) : ?>
								<?php self::render_layer( $layer, array( 'canvas_w' => $canvas_w, 'canvas_h' => $canvas_h, 'preview' => true ) ); ?>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>

				</div>
			</div>

			<?php if ( $show_nav ) : ?>
				<button type="button" class="swiper-button-prev" style="pointer-events:none;" aria-hidden="true"></button>
				<button type="button" class="swiper-button-next" style="pointer-events:none;" aria-hidden="true"></button>
			<?php endif; ?>

			<?php if ( '' !== $responsive_css ) : ?>
				<style class="boldslider-responsive-css"><?php echo $responsive_css; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></style>
			<?php endif; ?>

		</div>
		<?php
		return (string) ob_get_clean();
	}

	/**
	 * Output a small CSS file the editor can load directly (no Swiper, no JS).
	 * Used by Gutenberg block iframe and Elementor preview to force layer
	 * visibility and ensure the static-preview wrapper geometry works even when
	 * inline <style> tags inside server-rendered content get filtered out.
	 */
	public static function preview_css(): string {
		return '
.boldslider-wrap.boldslider-preview { position: relative; }
.boldslider-wrap.boldslider-preview > .boldslider-preview-inner { position: absolute; inset: 0; overflow: hidden; }
.boldslider-wrap.boldslider-preview > .boldslider-preview-inner > .boldslider-slide { position: absolute; inset: 0; width: 100%; height: 100%; }
.boldslider-wrap.boldslider-preview .boldslider-layer { --bs-opacity: 1 !important; --bs-tx: 0px !important; --bs-ty: 0px !important; --bs-scale: 1 !important; }
';
	}

	/**
	 * Build the Swiper options object passed to `new Swiper()`.
	 */
	public static function build_swiper_options( array $settings, int $slider_id = 0 ): array {
		$options = array(
			'loop'           => (bool) $settings['loop'],
			'speed'          => (int) $settings['speed'],
			'direction'      => ( ( $settings['direction'] ?? 'horizontal' ) === 'vertical' ) ? 'vertical' : 'horizontal',
			'slidesPerView'  => max( 1, (int) ( $settings['slides_per_view'] ?? 1 ) ),
			'spaceBetween'   => max( 0, (int) ( $settings['space_between'] ?? 0 ) ),
			'centeredSlides' => ! empty( $settings['centered_slides'] ),
			'autoHeight'     => ! empty( $settings['auto_height'] ),
			'grabCursor'     => ! empty( $settings['grab_cursor'] ),
		);

		if ( ! empty( $settings['keyboard'] ) ) {
			$options['keyboard'] = array( 'enabled' => true, 'onlyInViewport' => true );
		}
		if ( ! empty( $settings['mousewheel'] ) ) {
			$options['mousewheel'] = array( 'forceToAxis' => true, 'thresholdDelta' => 6 );
		}
		if ( ! empty( $settings['free_mode'] ) ) {
			$options['freeMode'] = array( 'enabled' => true, 'momentum' => true );
		}
		if ( ! empty( $settings['scrollbar'] ) ) {
			$options['scrollbar'] = array( 'el' => '.swiper-scrollbar', 'draggable' => true );
		}

		$effect = (string) ( $settings['effect'] ?? 'slide' );
		switch ( $effect ) {
			case 'fade':
				$options['effect']     = 'fade';
				$options['fadeEffect'] = array( 'crossFade' => true );
				break;
			case 'cube':
				$options['effect']     = 'cube';
				$options['cubeEffect'] = array(
					'shadow'      => true,
					'slideShadows' => true,
					'shadowOffset' => 20,
					'shadowScale'  => 0.94,
				);
				break;
			case 'coverflow':
				$options['effect']          = 'coverflow';
				$options['centeredSlides']  = true;
				$options['slidesPerView']   = 'auto';
				$options['coverflowEffect'] = array(
					'rotate'       => 40,
					'stretch'      => 0,
					'depth'        => 120,
					'modifier'     => 1,
					'slideShadows' => true,
				);
				break;
			case 'flip':
				$options['effect']     = 'flip';
				$options['flipEffect'] = array( 'slideShadows' => true, 'limitRotation' => true );
				break;
			default:
				$options['effect'] = 'slide';
				break;
		}

		if ( ! empty( $settings['autoplay'] ) ) {
			$options['autoplay'] = array(
				'delay'                => (int) $settings['autoplay_delay'],
				'disableOnInteraction' => false,
				'pauseOnMouseEnter'    => ! empty( $settings['autoplay_pause_hover'] ),
			);
		}

		if ( ! empty( $settings['navigation'] ) ) {
			// Buttons live outside .swiper container so we use unique IDs to scope them
			// to this specific slider on pages that have multiple sliders.
			if ( $slider_id > 0 ) {
				$dom_id = 'boldslider-' . $slider_id;
				$options['navigation'] = array(
					'nextEl' => '#' . $dom_id . '-next',
					'prevEl' => '#' . $dom_id . '-prev',
				);
			} else {
				$options['navigation'] = array(
					'nextEl' => '.swiper-button-next',
					'prevEl' => '.swiper-button-prev',
				);
			}
		}

		if ( ! empty( $settings['pagination'] ) ) {
			if ( $slider_id > 0 ) {
				$options['pagination'] = array(
					'el'        => '#boldslider-' . $slider_id . '-pag',
					'type'      => (string) $settings['pagination_type'],
					'clickable' => ! empty( $settings['pagination_clickable'] ),
				);
			} else {
				$options['pagination'] = array(
					'el'        => '.swiper-pagination',
					'type'      => (string) $settings['pagination_type'],
					'clickable' => ! empty( $settings['pagination_clickable'] ),
				);
			}
		}

		return $options;
	}

	/**
	 * Render one absolutely-positioned layer inside a slide's canvas.
	 *
	 * Pass `preview => true` in $ctx for static editor previews — this forces
	 * `data-bs-anim="none"` so the from-state CSS rules (which would hide the
	 * layer until JS adds .bs-anim-in) never match.
	 */
	public static function render_layer( array $layer, array $ctx = array() ): void {
		$canvas_w = (int) ( $ctx['canvas_w'] ?? 1200 );
		$canvas_h = (int) ( $ctx['canvas_h'] ?? 600 );
		$preview  = ! empty( $ctx['preview'] );

		$left_pct = $canvas_w > 0 ? ( 100 * (float) $layer['position']['x'] / $canvas_w ) : 0;
		$top_pct  = $canvas_h > 0 ? ( 100 * (float) $layer['position']['y'] / $canvas_h ) : 0;
		$w_pct    = $canvas_w > 0 ? ( 100 * (float) $layer['size']['width'] / $canvas_w ) : 0;
		$h_pct    = $canvas_h > 0 ? ( 100 * (float) $layer['size']['height'] / $canvas_h ) : 0;

		$ff = (string) ( $layer['style']['font_family'] ?? '' );
		$font_family_decl = '' !== $ff ? 'font-family:' . esc_attr( Fonts::stack( $ff ) ) . ';' : '';

		$rotation = self::fmt( (float) $layer['rotation'] );

		$anim_in = isset( $layer['animation']['in'] ) && is_array( $layer['animation']['in'] )
			? $layer['animation']['in']
			: array();
		$preset   = $preview ? 'none' : (string) ( $anim_in['preset'] ?? 'none' );
		$duration = self::fmt( (float) ( $anim_in['duration'] ?? 0.6 ) );
		$delay    = self::fmt( (float) ( $anim_in['delay'] ?? 0 ) );
		$ease     = (string) ( $anim_in['ease'] ?? 'ease-out' );

		// Anim vars + base layer styles. Transform/opacity are driven by the
		// CSS class .bs-anim-in (added by JS when slide becomes active).
		$style = sprintf(
			'left:%1$s%%;top:%2$s%%;width:%3$s%%;height:%4$s%%;' .
			'--bs-rot:rotate(%5$sdeg);' .
			'--bs-anim-d:%17$ss;--bs-anim-delay:%18$ss;--bs-anim-ease:%19$s;' .
			'color:%6$s;background:%7$s;%16$s' .
			'font-size:calc(%8$spx * var(--boldslider-scale,1));font-weight:%9$s;text-align:%10$s;' .
			'padding:%11$spx;border-radius:%12$spx;line-height:%13$s;letter-spacing:%14$spx;z-index:%15$s;',
			self::fmt( $left_pct ),
			self::fmt( $top_pct ),
			self::fmt( $w_pct ),
			self::fmt( $h_pct ),
			$rotation,
			esc_attr( (string) $layer['style']['color'] ),
			esc_attr( (string) $layer['style']['background'] ),
			self::fmt( (float) $layer['style']['font_size'] ),
			(int) $layer['style']['font_weight'],
			esc_attr( (string) $layer['style']['text_align'] ),
			self::fmt( (float) $layer['style']['padding'] ),
			self::fmt( (float) $layer['style']['border_radius'] ),
			self::fmt( (float) $layer['style']['line_height'] ),
			self::fmt( (float) $layer['style']['letter_spacing'] ),
			(int) $layer['z_index'],
			$font_family_decl,
			$duration,
			$delay,
			esc_attr( $ease )
		);

		$type  = (string) $layer['type'];
		$class = 'boldslider-layer boldslider-layer--' . sanitize_html_class( $type );
		?>
		<div
			class="<?php echo esc_attr( $class ); ?>"
			data-layer-id="<?php echo esc_attr( (string) $layer['id'] ); ?>"
			data-bs-anim="<?php echo esc_attr( $preset ); ?>"
			style="<?php echo esc_attr( $style ); ?>"
		><?php self::render_layer_body( $layer ); ?></div>
		<?php
	}

	private static function render_layer_body( array $layer ): void {
		$type = (string) $layer['type'];
		$href = (string) ( $layer['content']['href'] ?? '' );

		$open_link  = '';
		$close_link = '';
		if ( '' !== $href && in_array( $type, array( 'button', 'image', 'text' ), true ) ) {
			$target = (string) ( $layer['content']['target'] ?? '_self' );
			$rel    = '_blank' === $target ? ' rel="noopener noreferrer"' : '';
			$open_link  = sprintf(
				'<a href="%1$s" target="%2$s"%3$s>',
				esc_url( $href ),
				esc_attr( $target ),
				$rel
			);
			$close_link = '</a>';
		}

		switch ( $type ) {
			case 'image':
				$image_id = (int) ( $layer['content']['image_id'] ?? 0 );
				echo $open_link;
				if ( $image_id > 0 ) {
					echo wp_get_attachment_image(
						$image_id,
						'large',
						false,
						array(
							'style' => 'width:100%;height:100%;object-fit:cover;display:block;',
							'alt'   => '',
						)
					);
				}
				echo $close_link;
				break;

			case 'button':
				$btn_text = (string) ( $layer['content']['text'] ?? '' );
				$icon_id  = (string) ( $layer['content']['icon'] ?? 'none' );
				$icon_pos = (string) ( $layer['content']['icon_position'] ?? 'right' );
				$svg      = 'none' !== $icon_id ? Icons::svg( $icon_id ) : '';

				echo $open_link;
				echo '<span class="boldslider-btn-inner">';
				if ( $svg && 'left' === $icon_pos ) {
					echo '<span class="boldslider-btn-icon">' . $svg . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				}
				echo '<span>' . esc_html( $btn_text ) . '</span>';
				if ( $svg && 'right' === $icon_pos ) {
					echo '<span class="boldslider-btn-icon">' . $svg . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				}
				echo '</span>';
				echo $close_link;
				break;

			case 'shape':
				// Solid-fill rectangle; style already applied on wrapper.
				break;

			case 'heading':
				$tag = (string) ( $layer['content']['tag'] ?? 'h2' );
				if ( ! in_array( $tag, array( 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'p', 'span', 'div' ), true ) ) {
					$tag = 'h2';
				}
				echo $open_link;
				echo '<' . $tag . ' class="boldslider-heading">';
				echo wp_kses_post( (string) ( $layer['content']['text'] ?? '' ) );
				echo '</' . $tag . '>';
				echo $close_link;
				break;

			case 'youtube':
				$yt_url = (string) ( $layer['content']['video_url'] ?? '' );
				$yt_id  = self::extract_youtube_id( $yt_url );
				if ( '' !== $yt_id ) {
					printf(
						'<iframe class="boldslider-video-iframe" src="https://www.youtube.com/embed/%s?rel=0&modestbranding=1" frameborder="0" allow="autoplay; encrypted-media; picture-in-picture" allowfullscreen loading="lazy"></iframe>',
						esc_attr( $yt_id )
					);
				} else {
					echo '<div class="boldslider-video-placeholder">' . esc_html__( 'YouTube URL needed', 'boldslider' ) . '</div>';
				}
				break;

			case 'vimeo':
				$vm_url = (string) ( $layer['content']['video_url'] ?? '' );
				$vm_id  = self::extract_vimeo_id( $vm_url );
				if ( '' !== $vm_id ) {
					printf(
						'<iframe class="boldslider-video-iframe" src="https://player.vimeo.com/video/%s" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen loading="lazy"></iframe>',
						esc_attr( $vm_id )
					);
				} else {
					echo '<div class="boldslider-video-placeholder">' . esc_html__( 'Vimeo URL needed', 'boldslider' ) . '</div>';
				}
				break;

			case 'text':
			default:
				echo $open_link;
				echo wp_kses_post( (string) ( $layer['content']['text'] ?? '' ) );
				echo $close_link;
				break;
		}
	}

	/**
	 * Build a <style>-block body with @media overrides for per-viewport layer
	 * position/size. Desktop values come from the inline style on each layer;
	 * tablet/mobile overrides are applied via media queries.
	 */
	public static function build_responsive_css( array $slides, int $canvas_w, int $canvas_h, int $slider_id, array $settings = array() ): string {
		$scope = '#boldslider-' . $slider_id;
		$base_rules   = self::build_chrome_css( $scope, $settings );
		$tablet_rules = self::build_canvas_aspect_rule( $settings['canvas_responsive']['tablet'] ?? null, $scope );
		$mobile_rules = self::build_canvas_aspect_rule( $settings['canvas_responsive']['mobile'] ?? null, $scope );
		$hover_rules  = '';

		foreach ( $slides as $slide ) {
			foreach ( $slide['layers'] ?? array() as $layer ) {
				$resp = $layer['responsive'] ?? array();
				$id   = (string) ( $layer['id'] ?? '' );
				if ( '' === $id ) {
					continue;
				}
				$sel = $scope . ' [data-layer-id="' . esc_attr( $id ) . '"]';

				// Desktop hidden — emitted in base scope (no @media).
				if ( ! empty( $layer['hidden'] ) ) {
					$base_rules .= $sel . '{display:none!important;}';
				}

				$tablet_rules .= self::build_override_rule( $sel, $resp['tablet'] ?? null, $canvas_w, $canvas_h );
				$mobile_rules .= self::build_override_rule( $sel, $resp['mobile'] ?? null, $canvas_w, $canvas_h );

				// Hover CSS for buttons.
				if ( ( $layer['type'] ?? '' ) === 'button' ) {
					$hover_rules .= self::build_hover_rule( $sel, $layer['style'] ?? array() );
				}
			}
		}

		$css = $base_rules . $hover_rules;
		if ( '' !== $tablet_rules ) {
			$css .= '@media (max-width:1024px){' . $tablet_rules . '}';
		}
		if ( '' !== $mobile_rules ) {
			$css .= '@media (max-width:767px){' . $mobile_rules . '}';
		}
		return $css;
	}

	/**
	 * Navigation + pagination chrome CSS. Always emits hard rules with !important
	 * because Swiper's own stylesheet (loaded later in some configs) and CSS-var
	 * fallbacks aren't reliable across versions.
	 */
	private static function build_chrome_css( string $scope, array $settings ): string {
		$css = '';

		$nav_color = (string) ( $settings['nav_color'] ?? '' );
		$nav_bg    = (string) ( $settings['nav_bg'] ?? '' );
		$nh_color  = (string) ( $settings['nav_hover_color'] ?? '' );
		$nh_bg     = (string) ( $settings['nav_hover_bg'] ?? '' );

		// Base arrow styles. Always emit color (so it overrides Swiper) when set.
		$nav_decls = array();
		if ( '' !== $nav_color ) {
			$nav_decls[] = 'color:' . esc_attr( $nav_color ) . '!important';
		}
		if ( '' !== $nav_bg ) {
			$nav_decls[] = 'background:' . esc_attr( $nav_bg ) . '!important';
			$nav_decls[] = 'border-radius:50%';
			$nav_decls[] = 'width:44px';
			$nav_decls[] = 'height:44px';
		}
		if ( '' !== $nav_color || '' !== $nav_bg ) {
			$nav_decls[] = 'transition:background .2s,color .2s';
		}
		// Arrows are now direct children of .boldslider-wrap (which has the ID),
		// so we use a `>` combinator-equivalent selector.
		$nav_sel       = $scope . ' > .swiper-button-prev,' . $scope . ' > .swiper-button-next';
		$nav_after_sel = $scope . ' > .swiper-button-prev::after,' . $scope . ' > .swiper-button-next::after';
		$nav_hover_sel = $scope . ' > .swiper-button-prev:hover,' . $scope . ' > .swiper-button-next:hover';
		$nav_hover_after_sel = $scope . ' > .swiper-button-prev:hover::after,' . $scope . ' > .swiper-button-next:hover::after';

		if ( ! empty( $nav_decls ) ) {
			$css .= $nav_sel . '{' . implode( ';', $nav_decls ) . ';}';
		}
		if ( '' !== $nav_color ) {
			$css .= $nav_after_sel . '{color:' . esc_attr( $nav_color ) . '!important;}';
		}
		if ( '' !== $nav_bg ) {
			$css .= $nav_after_sel . '{font-size:16px!important;}';
		}

		// Hover.
		$hover_decls = array();
		if ( '' !== $nh_color ) {
			$hover_decls[] = 'color:' . esc_attr( $nh_color ) . '!important';
		}
		if ( '' !== $nh_bg ) {
			$hover_decls[] = 'background:' . esc_attr( $nh_bg ) . '!important';
		}
		if ( ! empty( $hover_decls ) ) {
			$css .= $nav_hover_sel . '{' . implode( ';', $hover_decls ) . ';}';
			if ( '' !== $nh_color ) {
				$css .= $nav_hover_after_sel . '{color:' . esc_attr( $nh_color ) . '!important;}';
			}
		}

		// Pagination — active color.
		$pa = (string) ( $settings['pagination_color'] ?? '' );
		$pi = (string) ( $settings['pagination_inactive_color'] ?? '' );
		if ( '' !== $pa ) {
			// Active bullet
			$css .= $scope . ' .swiper-pagination-bullet-active{background:' . esc_attr( $pa ) . '!important;opacity:1;}';
			// Fraction text + progress bar fill
			$css .= $scope . ' .swiper-pagination-fraction{color:' . esc_attr( $pa ) . '!important;}';
			$css .= $scope . ' .swiper-pagination-progressbar-fill{background:' . esc_attr( $pa ) . '!important;}';
		}
		if ( '' !== $pi ) {
			$css .= $scope . ' .swiper-pagination-bullet{background:' . esc_attr( $pi ) . '!important;opacity:1;}';
			$css .= $scope . ' .swiper-pagination-progressbar{background:' . esc_attr( $pi ) . '!important;}';
		}

		return $css;
	}

	/**
	 * Build a CSS rule that overrides the wrap aspect-ratio when a per-viewport
	 * canvas size is configured. Caller wraps the result in the right @media block.
	 */
	private static function build_canvas_aspect_rule( $size, string $scope ): string {
		if ( ! is_array( $size ) ) {
			return '';
		}
		$w = $size['width']  ?? null;
		$h = $size['height'] ?? null;
		if ( ! $w || ! $h ) {
			return '';
		}
		return $scope . '{aspect-ratio:' . (int) $w . '/' . (int) $h . ' !important;}';
	}

	private static function build_hover_rule( string $selector, array $style ): string {
		$decls = array();
		$hc = (string) ( $style['hover_color'] ?? '' );
		$hb = (string) ( $style['hover_background'] ?? '' );
		// `!important` is required because the layer carries inline color/background,
		// which would otherwise beat this :hover rule on specificity.
		if ( '' !== $hc ) {
			$decls[] = 'color:' . esc_attr( $hc ) . ' !important';
		}
		if ( '' !== $hb ) {
			$decls[] = 'background:' . esc_attr( $hb ) . ' !important';
		}
		if ( empty( $decls ) ) {
			return '';
		}
		$base = $selector . '{transition:background .2s,color .2s;}';
		return $base . $selector . ':hover{' . implode( ';', $decls ) . ';}';
	}

	private static function build_override_rule( string $selector, $override, int $canvas_w, int $canvas_h ): string {
		if ( ! is_array( $override ) ) {
			return '';
		}
		$decls = array();

		$pos = $override['position'] ?? null;
		if ( is_array( $pos ) && isset( $pos['x'], $pos['y'] ) ) {
			$left = $canvas_w > 0 ? ( 100 * (float) $pos['x'] / $canvas_w ) : 0;
			$top  = $canvas_h > 0 ? ( 100 * (float) $pos['y'] / $canvas_h ) : 0;
			$decls[] = 'left:' . self::fmt( $left ) . '%';
			$decls[] = 'top:'  . self::fmt( $top )  . '%';
		}

		$size = $override['size'] ?? null;
		if ( is_array( $size ) && isset( $size['width'], $size['height'] ) ) {
			$w = $canvas_w > 0 ? ( 100 * (float) $size['width']  / $canvas_w ) : 0;
			$h = $canvas_h > 0 ? ( 100 * (float) $size['height'] / $canvas_h ) : 0;
			$decls[] = 'width:'  . self::fmt( $w ) . '%';
			$decls[] = 'height:' . self::fmt( $h ) . '%';
		}

		$style = $override['style'] ?? null;
		if ( is_array( $style ) ) {
			if ( isset( $style['font_size'] ) ) {
				$decls[] = 'font-size:' . self::fmt( (float) $style['font_size'] ) . 'px';
			}
			if ( isset( $style['font_weight'] ) ) {
				$decls[] = 'font-weight:' . (int) $style['font_weight'];
			}
			if ( isset( $style['text_align'] ) ) {
				$decls[] = 'text-align:' . sanitize_html_class( (string) $style['text_align'] );
			}
			if ( isset( $style['color'] ) ) {
				$decls[] = 'color:' . esc_attr( (string) $style['color'] );
			}
			if ( isset( $style['background'] ) ) {
				$decls[] = 'background:' . esc_attr( (string) $style['background'] );
			}
			if ( isset( $style['padding'] ) ) {
				$decls[] = 'padding:' . self::fmt( (float) $style['padding'] ) . 'px';
			}
			if ( isset( $style['border_radius'] ) ) {
				$decls[] = 'border-radius:' . self::fmt( (float) $style['border_radius'] ) . 'px';
			}
			if ( isset( $style['line_height'] ) ) {
				$decls[] = 'line-height:' . self::fmt( (float) $style['line_height'] );
			}
			if ( isset( $style['letter_spacing'] ) ) {
				$decls[] = 'letter-spacing:' . self::fmt( (float) $style['letter_spacing'] ) . 'px';
			}
		}

		// Per-breakpoint hidden override. true = force hide, false = force show.
		if ( is_array( $override ) && array_key_exists( 'hidden', $override ) && null !== $override['hidden'] ) {
			if ( true === $override['hidden'] ) {
				$decls[] = 'display:none!important';
			} else {
				$decls[] = 'display:block!important';
			}
		}

		if ( empty( $decls ) ) {
			return '';
		}
		return $selector . '{' . implode( ';', $decls ) . ';}';
	}

	/**
	 * Lightweight layer payload for the JS runtime (animation + timing only).
	 */
	public static function layer_for_js( array $layer ): array {
		return array(
			'id'        => (string) $layer['id'],
			'animation' => array(
				'in'  => $layer['animation']['in'],
				'out' => $layer['animation']['out'],
			),
			'timing'    => $layer['timing'],
		);
	}

	public static function extract_youtube_id( string $url ): string {
		if ( '' === $url ) {
			return '';
		}
		if ( preg_match( '~(?:youtube\.com/(?:watch\?v=|embed/|v/|shorts/)|youtu\.be/)([a-zA-Z0-9_-]{11})~', $url, $m ) ) {
			return $m[1];
		}
		return '';
	}

	public static function extract_vimeo_id( string $url ): string {
		if ( '' === $url ) {
			return '';
		}
		if ( preg_match( '~vimeo\.com/(?:video/)?(\d+)~', $url, $m ) ) {
			return $m[1];
		}
		return '';
	}

	private static function fmt( float $value ): string {
		$value = round( $value, 4 );
		$s = rtrim( rtrim( number_format( $value, 4, '.', '' ), '0' ), '.' );
		return '' === $s ? '0' : $s;
	}
}
