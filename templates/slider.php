<?php
/**
 * Frontend slider template.
 *
 * Override: copy to <active-theme>/boldslider/slider.php.
 *
 * @package BoldSlider
 *
 * @var int   $slider_id Slider post ID.
 * @var array $settings  Sanitized settings.
 * @var array $slides    Sanitized slides.
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$options = \BoldSlider\Render\Renderer::build_swiper_options( $settings, (int) $slider_id );
$dom_id  = 'boldslider-' . (int) $slider_id;
$canvas_w = (int) $settings['canvas_width'];
$canvas_h = (int) $settings['canvas_height'];
$aspect_ratio = $canvas_w > 0 ? ( $canvas_w . ' / ' . $canvas_h ) : '16 / 9';

$is_fullscreen  = ! empty( $settings['full_screen'] );
$wrap_classes   = array( 'boldslider-wrap' );
$wrap_classes[] = 'is-effect-' . sanitize_html_class( (string) $settings['effect'] );
$wrap_classes[] = 'is-direction-' . sanitize_html_class( (string) ( $settings['direction'] ?? 'horizontal' ) );
$wrap_classes[] = 'bs-nav-' . sanitize_html_class( (string) ( $settings['nav_placement'] ?? 'inside' ) );
$wrap_classes[] = 'bs-nav-pos-' . sanitize_html_class( (string) ( $settings['nav_position'] ?? 'middle' ) );
$wrap_classes[] = 'bs-pag-' . sanitize_html_class( (string) ( $settings['pagination_placement'] ?? 'inside' ) );
$wrap_classes[] = 'bs-pag-pos-' . sanitize_html_class( (string) ( $settings['pagination_position'] ?? 'bottom' ) );
$bg_anim = (string) ( $settings['bg_animation'] ?? 'none' );
if ( 'none' !== $bg_anim ) {
	$wrap_classes[] = 'bs-bg-anim-' . sanitize_html_class( $bg_anim );
}
if ( $is_fullscreen ) {
	$wrap_classes[] = 'is-fullscreen';
}
if ( ! empty( $settings['thumbnails'] ) ) {
	$wrap_classes[] = 'has-thumbs';
}

$nav_color = esc_attr( (string) ( $settings['nav_color'] ?? '#ffffff' ) );
$pag_color = esc_attr( (string) ( $settings['pagination_color'] ?? '#ffffff' ) );

$vars = '--boldslider-canvas-w:' . (int) $canvas_w . 'px;'
	. '--boldslider-canvas-h:' . (int) $canvas_h . 'px;'
	. '--swiper-navigation-color:' . $nav_color . ';'
	. '--swiper-pagination-color:' . $pag_color . ';'
	. '--bs-nav-size:' . (int) ( $settings['nav_size'] ?? 44 ) . 'px;'
	. '--bs-nav-offset:' . (int) ( $settings['nav_offset'] ?? 12 ) . 'px;'
	. '--bs-pag-offset:' . (int) ( $settings['pagination_offset'] ?? 16 ) . 'px;'
	. '--bs-bullet-size:' . (int) ( $settings['pagination_bullet_size'] ?? 10 ) . 'px;'
	. '--bs-bullet-gap:' . (int) ( $settings['pagination_bullet_gap'] ?? 8 ) . 'px;'
	. '--bs-thumbs-h:' . (int) ( $settings['thumbnails_height'] ?? 80 ) . 'px;'
	. '--bs-thumbs-gap:' . (int) ( $settings['thumbnails_gap'] ?? 8 ) . 'px;';

$wrap_style = $is_fullscreen
	? $vars
	: 'aspect-ratio:' . esc_attr( $aspect_ratio ) . ';' . $vars;
?>
<div class="<?php echo esc_attr( implode( ' ', $wrap_classes ) ); ?>" id="<?php echo esc_attr( $dom_id ); ?>" style="<?php echo esc_attr( $wrap_style ); ?>">
	<div class="boldslider swiper" data-boldslider data-slider-id="<?php echo esc_attr( (string) $slider_id ); ?>">
		<div class="swiper-wrapper">
			<?php foreach ( $slides as $i => $slide ) :
				$slide_video_id  = (int) ( $slide['video_id'] ?? 0 );
				$slide_video_url = $slide_video_id > 0 ? wp_get_attachment_url( $slide_video_id ) : '';
				$slide_video_mime = $slide_video_id > 0 ? (string) get_post_mime_type( $slide_video_id ) : '';
				$slide_image_id  = (int) $slide['image_id'];
				$slide_image_url = $slide_image_id > 0 ? wp_get_attachment_image_url( $slide_image_id, 'large' ) : '';
				$slide_bg_color  = (string) ( $slide['bg_color'] ?? '' );
				$is_first        = ( 0 === $i );
				$lazy_attr       = ( ! empty( $settings['lazy_load'] ) && ! $is_first ) ? 'lazy' : 'eager';

				// Resolve alt + title — either from media library or custom override.
				$alt_source   = (string) ( $slide['alt_source'] ?? 'media' );
				$title_source = (string) ( $slide['title_source'] ?? 'media' );
				$resolved_alt   = '';
				$resolved_title = '';
				if ( $slide_image_id > 0 ) {
					if ( 'custom' === $alt_source ) {
						$resolved_alt = (string) ( $slide['image_alt'] ?? '' );
					} else {
						$resolved_alt = (string) get_post_meta( $slide_image_id, '_wp_attachment_image_alt', true );
					}
					if ( 'custom' === $title_source ) {
						$resolved_title = (string) ( $slide['image_title'] ?? '' );
					} else {
						$att_post = get_post( $slide_image_id );
						$resolved_title = $att_post instanceof \WP_Post ? (string) $att_post->post_title : '';
					}
				}

				// Build slide background CSS (size / repeat / position) for the visual layer.
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

				$slide_style_parts = array();
				if ( '' !== $slide_bg_color ) {
					$slide_style_parts[] = 'background-color:' . $slide_bg_color;
				}
				$slide_inline = ! empty( $slide_style_parts ) ? implode( ';', $slide_style_parts ) . ';' : '';
			?>
				<div class="swiper-slide boldslider-slide" data-slide-id="<?php echo esc_attr( (string) $slide['id'] ); ?>"<?php echo $slide_inline ? ' style="' . esc_attr( $slide_inline ) . '"' : ''; ?>>
					<?php if ( $slide_video_url ) : ?>
						<video
							class="boldslider-slide__video"
							autoplay
							muted
							loop
							playsinline
							<?php if ( $slide_image_url ) : ?>poster="<?php echo esc_url( $slide_image_url ); ?>"<?php endif; ?>
							preload="<?php echo esc_attr( $is_first ? 'auto' : 'metadata' ); ?>"
						>
							<source src="<?php echo esc_url( $slide_video_url ); ?>"<?php echo $slide_video_mime ? ' type="' . esc_attr( $slide_video_mime ) . '"' : ''; ?>>
						</video>
					<?php elseif ( $slide_image_url ) : ?>
						<?php
						// Visual: CSS background with full fit/repeat/position control.
						$visual_style = 'background-image:url(' . esc_url( $slide_image_url ) . ');'
							. 'background-size:' . esc_attr( $bg_size ) . ';'
							. 'background-repeat:' . esc_attr( $bg_repeat ) . ';'
							. 'background-position:' . esc_attr( $bg_pos_css ) . ';';
						?>
						<div class="boldslider-slide__bg-visual" style="<?php echo esc_attr( $visual_style ); ?>" aria-hidden="true"></div>
						<?php // SEO: the actual <img> is in the DOM but visually hidden so alt + title are crawlable. ?>
						<img
							class="boldslider-slide__bg-img"
							src="<?php echo esc_url( $slide_image_url ); ?>"
							alt="<?php echo esc_attr( $resolved_alt ); ?>"
							<?php if ( '' !== $resolved_title ) : ?>title="<?php echo esc_attr( $resolved_title ); ?>"<?php endif; ?>
							loading="<?php echo esc_attr( $lazy_attr ); ?>"
							decoding="async"
						/>
					<?php endif; ?>

					<?php if ( ! empty( $slide['layers'] ) ) : ?>
						<div class="boldslider-slide__canvas" aria-hidden="false">
							<?php foreach ( $slide['layers'] as $layer ) : ?>
								<?php \BoldSlider\Render\Renderer::render_layer( $layer, array( 'canvas_w' => $canvas_w, 'canvas_h' => $canvas_h ) ); ?>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>

					<?php if ( '' !== $slide['heading'] || '' !== $slide['content'] ) : ?>
						<div class="boldslider-caption">
							<?php if ( '' !== $slide['heading'] ) : ?>
								<h3 class="boldslider-caption__heading"><?php echo esc_html( $slide['heading'] ); ?></h3>
							<?php endif; ?>
							<?php if ( '' !== $slide['content'] ) : ?>
								<div class="boldslider-caption__content"><?php echo wp_kses_post( $slide['content'] ); ?></div>
							<?php endif; ?>
						</div>
					<?php endif; ?>
				</div>
			<?php endforeach; ?>
		</div>

		<?php if ( ! empty( $settings['pagination'] ) ) : ?>
			<div class="swiper-pagination" id="<?php echo esc_attr( $dom_id . '-pag' ); ?>"></div>
		<?php endif; ?>

		<?php if ( ! empty( $settings['scrollbar'] ) ) : ?>
			<div class="swiper-scrollbar"></div>
		<?php endif; ?>
	</div>

	<?php // Navigation buttons live OUTSIDE .boldslider so they can sit inside or outside
	// the slider area without being clipped by Swiper's overflow:hidden. They are
	// found by Swiper via unique element IDs (per slider). ?>
	<?php if ( ! empty( $settings['navigation'] ) ) : ?>
		<button type="button" id="<?php echo esc_attr( $dom_id . '-prev' ); ?>" class="swiper-button-prev" aria-label="<?php esc_attr_e( 'Previous slide', 'boldslider' ); ?>"></button>
		<button type="button" id="<?php echo esc_attr( $dom_id . '-next' ); ?>" class="swiper-button-next" aria-label="<?php esc_attr_e( 'Next slide', 'boldslider' ); ?>"></button>
	<?php endif; ?>

	<?php if ( ! empty( $settings['thumbnails'] ) ) : ?>
		<div class="boldslider-thumbs swiper" data-boldslider-thumbs>
			<div class="swiper-wrapper">
				<?php foreach ( $slides as $i => $slide ) :
					$thumb_id  = (int) ( $slide['image_id'] ?? 0 );
					$thumb_url = $thumb_id > 0 ? wp_get_attachment_image_url( $thumb_id, 'thumbnail' ) : '';
				?>
					<div class="swiper-slide boldslider-thumb">
						<?php if ( $thumb_url ) : ?>
							<img src="<?php echo esc_url( $thumb_url ); ?>" alt="" loading="lazy">
						<?php else : ?>
							<span class="boldslider-thumb__num"><?php echo (int) $i + 1; ?></span>
						<?php endif; ?>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	<?php endif; ?>

	<?php
	$responsive_css = \BoldSlider\Render\Renderer::build_responsive_css( $slides, $canvas_w, $canvas_h, (int) $slider_id, $settings );
	if ( '' !== $responsive_css ) :
	?>
	<style class="boldslider-responsive-css"><?php echo $responsive_css; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></style>
	<?php endif; ?>

	<?php
	/**
	 * Filter: boldslider/extra_head
	 * The free version intentionally does NOT call out to Google Fonts CDN.
	 * The Pro add-on (or any other plugin) can hook here to enqueue
	 * self-hosted fonts via the WPTT WebFont Loader pattern, etc.
	 */
	if ( function_exists( 'apply_filters' ) ) {
		echo wp_kses_post( (string) apply_filters( 'boldslider/extra_head', '', $slider_id, $settings, $slides ) );
	}
	?>

	<script type="application/json" class="boldslider-config"><?php echo wp_json_encode( $options ); ?></script>
</div>
