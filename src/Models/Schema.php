<?php
/**
 * @package BoldSlider
 */

declare(strict_types=1);

namespace BoldSlider\Models;

use BoldSlider\Render\Fonts;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Schema {

	public const VERSION = 1;

	private const EFFECTS          = array( 'slide', 'fade', 'cube', 'coverflow', 'flip', 'cards' );
	private const DIRECTIONS       = array( 'horizontal', 'vertical' );
	private const PAGINATION_TYPES = array( 'bullets', 'fraction', 'progressbar' );
	private const NAV_PLACEMENT    = array( 'inside', 'outside' );
	private const NAV_POSITION     = array( 'top', 'middle', 'bottom' );
	private const PAG_PLACEMENT    = array( 'inside', 'outside' );
	private const PAG_POSITION     = array( 'top', 'bottom' );
	private const BG_ANIMATIONS    = array( 'none', 'kenburns', 'zoom-in', 'zoom-out', 'pan-left', 'pan-right' );
	private const BG_FITS          = array( 'cover', 'contain', 'auto', 'percentage' );
	private const BG_REPEATS       = array( 'no-repeat', 'repeat', 'repeat-x', 'repeat-y', 'round', 'space' );
	private const BG_POSITIONS     = array(
		'top-left', 'top-center', 'top-right',
		'middle-left', 'middle-center', 'middle-right',
		'bottom-left', 'bottom-center', 'bottom-right',
		'custom',
	);
	private const ATTR_SOURCES     = array( 'media', 'custom' );
	private const LINK_TARGETS     = array( '_self', '_blank' );
	private const SLIDE_TYPES      = array( 'image', 'video', 'custom' );
	private const LAYER_TYPES      = array( 'text', 'heading', 'image', 'button', 'shape', 'youtube', 'vimeo' );
	private const HEADING_TAGS     = array( 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'p', 'span', 'div' );
	private const BUTTON_ICONS     = array( 'none', 'arrow-right', 'arrow-left', 'chevron-right', 'chevron-left', 'play', 'download', 'external', 'check', 'plus', 'cart', 'mail', 'phone' );
	private const ICON_POSITIONS   = array( 'left', 'right' );
	private const EASES            = array( 'linear', 'ease', 'ease-in', 'ease-out', 'ease-in-out' );

	public static function defaults(): array {
		return array(
			'version'  => self::VERSION,
			'settings' => self::default_settings(),
			'slides'   => array( self::default_slide() ),
		);
	}

	public static function default_settings(): array {
		return array(
			'effect'              => 'slide',
			'direction'           => 'horizontal',
			'bg_animation'        => 'none',
			'full_screen'         => false,
			'autoplay'            => false,
			'autoplay_delay'      => 5000,
			'autoplay_pause_hover' => true,
			'loop'                => false,
			'speed'               => 600,
			'slides_per_view'     => 1,
			'space_between'       => 0,
			'centered_slides'     => false,
			'auto_height'         => false,
			'grab_cursor'         => true,
			'keyboard'            => false,
			'mousewheel'          => false,
			'free_mode'           => false,
			'scrollbar'           => false,
			'lazy_load'           => true,
			'navigation'                 => true,
			'nav_placement'              => 'inside',
			'nav_position'               => 'middle',
			'nav_size'                   => 44,
			'nav_offset'                 => 12,
			'nav_color'                  => '#ffffff',
			'nav_bg'                     => '',
			'nav_hover_color'            => '',
			'nav_hover_bg'               => '',

			'pagination'                 => true,
			'pagination_type'            => 'bullets',
			'pagination_placement'       => 'inside',
			'pagination_position'        => 'bottom',
			'pagination_offset'          => 16,
			'pagination_bullet_size'     => 10,
			'pagination_bullet_gap'      => 8,
			'pagination_clickable'       => true,
			'pagination_color'           => '#ffffff',
			'pagination_inactive_color'  => '',

			'thumbnails'                 => false,
			'thumbnails_height'          => 80,
			'thumbnails_gap'             => 8,

			'canvas_width'               => 1200,
			'canvas_height'              => 600,
			'canvas_responsive'          => self::default_canvas_responsive(),
		);
	}

	public static function default_canvas_responsive(): array {
		return array(
			'tablet' => array( 'width' => null, 'height' => null ),
			'mobile' => array( 'width' => null, 'height' => null ),
		);
	}

	public static function default_slide(): array {
		return array(
			'id'             => '',
			'type'           => 'image',
			'image_id'       => 0,
			'image_alt'      => '',
			'image_title'    => '',
			'alt_source'     => 'media',
			'title_source'   => 'media',
			'bg_fit'         => 'cover',
			'bg_size_x'      => 100,
			'bg_size_y'      => 100,
			'bg_repeat'      => 'no-repeat',
			'bg_position'    => 'middle-center',
			'bg_position_x'  => 50,
			'bg_position_y'  => 50,
			'video_id'       => 0,
			'bg_color'       => '',
			'heading'        => '',
			'content'        => '',
			'link_url'       => '',
			'link_target'    => '_self',
			'layers'         => array(),
		);
	}

	public static function default_layer(): array {
		return array(
			'id'        => '',
			'name'      => '',
			'type'      => 'text',
			'position'  => array( 'x' => 0, 'y' => 0 ),
			'size'      => array( 'width' => 240, 'height' => 60 ),
			'rotation'  => 0,
			'z_index'   => 0,
			'content'   => array(
				'text'          => '',
				'image_id'      => 0,
				'href'          => '',
				'target'        => '_self',
				'icon'          => 'none',
				'icon_position' => 'right',
				'video_url'     => '',
				'tag'           => 'h2',
			),
			'style'     => array(
				'color'            => '#000000',
				'background'       => 'transparent',
				'font_family'      => '',
				'font_size'        => 24,
				'font_weight'      => 400,
				'text_align'       => 'left',
				'padding'          => 0,
				'border_radius'    => 0,
				'line_height'      => 1.3,
				'letter_spacing'   => 0,
				'hover_color'      => '',
				'hover_background' => '',
			),
			'animation' => array(
				'in'  => self::default_animation_step( 'fade-up' ),
				'out' => self::default_animation_step( 'none' ),
			),
			'timing'    => array(
				'start' => 0.0,
				'end'   => null,
			),
			'responsive' => self::default_responsive(),
		);
	}

	public static function default_responsive(): array {
		return array(
			'tablet' => array( 'position' => null, 'size' => null, 'style' => null, 'hidden' => null ),
			'mobile' => array( 'position' => null, 'size' => null, 'style' => null, 'hidden' => null ),
		);
	}

	public static function default_animation_step( string $preset = 'none' ): array {
		return array(
			'preset'   => $preset,
			'x'        => 0,
			'y'        => 0,
			'opacity'  => 1,
			'scale'    => 1,
			'rotation' => 0,
			'duration' => 0.6,
			'delay'    => 0.0,
			'ease'     => 'ease-out',
		);
	}

	public static function sanitize( $data ): array {
		$data = is_array( $data ) ? $data : array();

		$settings_input = is_array( $data['settings'] ?? null ) ? $data['settings'] : array();
		$slides_input   = is_array( $data['slides'] ?? null ) ? $data['slides'] : array();

		return array(
			'version'  => self::VERSION,
			'settings' => self::sanitize_settings( $settings_input ),
			'slides'   => self::sanitize_slides( $slides_input ),
		);
	}

	private static function sanitize_settings( array $input ): array {
		$defaults = self::default_settings();

		return array(
			'effect'          => self::enum( $input['effect'] ?? $defaults['effect'], self::EFFECTS, $defaults['effect'] ),
			'direction'       => self::enum( $input['direction'] ?? $defaults['direction'], self::DIRECTIONS, $defaults['direction'] ),
			'bg_animation'        => self::enum( $input['bg_animation'] ?? $defaults['bg_animation'], self::BG_ANIMATIONS, $defaults['bg_animation'] ),
			'autoplay_pause_hover' => self::boolish( $input['autoplay_pause_hover'] ?? $defaults['autoplay_pause_hover'] ),
			'lazy_load'           => self::boolish( $input['lazy_load'] ?? $defaults['lazy_load'] ),
			'full_screen'     => self::boolish( $input['full_screen'] ?? $defaults['full_screen'] ),
			'autoplay'        => self::boolish( $input['autoplay'] ?? $defaults['autoplay'] ),
			'autoplay_delay' => self::clamp_int( $input['autoplay_delay'] ?? $defaults['autoplay_delay'], 500, 60000, $defaults['autoplay_delay'] ),
			'loop'            => self::boolish( $input['loop'] ?? $defaults['loop'] ),
			'speed'           => self::clamp_int( $input['speed'] ?? $defaults['speed'], 100, 10000, $defaults['speed'] ),
			'slides_per_view' => self::clamp_int( $input['slides_per_view'] ?? $defaults['slides_per_view'], 1, 12, $defaults['slides_per_view'] ),
			'space_between'   => self::clamp_int( $input['space_between'] ?? $defaults['space_between'], 0, 200, $defaults['space_between'] ),
			'centered_slides' => self::boolish( $input['centered_slides'] ?? $defaults['centered_slides'] ),
			'auto_height'     => self::boolish( $input['auto_height'] ?? $defaults['auto_height'] ),
			'grab_cursor'     => self::boolish( $input['grab_cursor'] ?? $defaults['grab_cursor'] ),
			'keyboard'        => self::boolish( $input['keyboard'] ?? $defaults['keyboard'] ),
			'mousewheel'      => self::boolish( $input['mousewheel'] ?? $defaults['mousewheel'] ),
			'free_mode'       => self::boolish( $input['free_mode'] ?? $defaults['free_mode'] ),
			'scrollbar'       => self::boolish( $input['scrollbar'] ?? $defaults['scrollbar'] ),
			'navigation'                => self::boolish( $input['navigation'] ?? $defaults['navigation'] ),
			'nav_placement'             => self::enum( $input['nav_placement'] ?? $defaults['nav_placement'], self::NAV_PLACEMENT, $defaults['nav_placement'] ),
			'nav_position'              => self::enum( $input['nav_position'] ?? $defaults['nav_position'], self::NAV_POSITION, $defaults['nav_position'] ),
			'nav_size'                  => self::clamp_int( $input['nav_size'] ?? $defaults['nav_size'], 20, 120, $defaults['nav_size'] ),
			'nav_offset'                => self::clamp_int( $input['nav_offset'] ?? $defaults['nav_offset'], 0, 200, $defaults['nav_offset'] ),
			'nav_color'                 => self::color( $input['nav_color'] ?? $defaults['nav_color'], $defaults['nav_color'] ),
			'nav_bg'                    => self::color_or_empty( $input['nav_bg'] ?? '', true ),
			'nav_hover_color'           => self::color_or_empty( $input['nav_hover_color'] ?? '' ),
			'nav_hover_bg'              => self::color_or_empty( $input['nav_hover_bg'] ?? '', true ),

			'pagination'                => self::boolish( $input['pagination'] ?? $defaults['pagination'] ),
			'pagination_type'           => self::enum( $input['pagination_type'] ?? $defaults['pagination_type'], self::PAGINATION_TYPES, $defaults['pagination_type'] ),
			'pagination_placement'      => self::enum( $input['pagination_placement'] ?? $defaults['pagination_placement'], self::PAG_PLACEMENT, $defaults['pagination_placement'] ),
			'pagination_position'       => self::enum( $input['pagination_position'] ?? $defaults['pagination_position'], self::PAG_POSITION, $defaults['pagination_position'] ),
			'pagination_offset'         => self::clamp_int( $input['pagination_offset'] ?? $defaults['pagination_offset'], 0, 200, $defaults['pagination_offset'] ),
			'pagination_bullet_size'    => self::clamp_int( $input['pagination_bullet_size'] ?? $defaults['pagination_bullet_size'], 4, 40, $defaults['pagination_bullet_size'] ),
			'pagination_bullet_gap'     => self::clamp_int( $input['pagination_bullet_gap'] ?? $defaults['pagination_bullet_gap'], 0, 40, $defaults['pagination_bullet_gap'] ),
			'pagination_clickable'      => self::boolish( $input['pagination_clickable'] ?? $defaults['pagination_clickable'] ),
			'pagination_color'          => self::color( $input['pagination_color'] ?? $defaults['pagination_color'], $defaults['pagination_color'] ),
			'pagination_inactive_color' => self::color_or_empty( $input['pagination_inactive_color'] ?? '', true ),

			'thumbnails'                => self::boolish( $input['thumbnails'] ?? $defaults['thumbnails'] ),
			'thumbnails_height'         => self::clamp_int( $input['thumbnails_height'] ?? $defaults['thumbnails_height'], 30, 300, $defaults['thumbnails_height'] ),
			'thumbnails_gap'            => self::clamp_int( $input['thumbnails_gap'] ?? $defaults['thumbnails_gap'], 0, 40, $defaults['thumbnails_gap'] ),

			'canvas_width'              => self::clamp_int( $input['canvas_width'] ?? $defaults['canvas_width'], 320, 4000, $defaults['canvas_width'] ),
			'canvas_height'             => self::clamp_int( $input['canvas_height'] ?? $defaults['canvas_height'], 180, 4000, $defaults['canvas_height'] ),
			'canvas_responsive'         => self::sanitize_canvas_responsive( is_array( $input['canvas_responsive'] ?? null ) ? $input['canvas_responsive'] : array() ),
		);
	}

	private static function sanitize_canvas_responsive( array $input ): array {
		$out = array();
		foreach ( array( 'tablet', 'mobile' ) as $bp ) {
			$data = is_array( $input[ $bp ] ?? null ) ? $input[ $bp ] : array();
			$out[ $bp ] = array(
				'width'  => self::sanitize_opt_canvas_dim( $data['width']  ?? null, 320, 4000 ),
				'height' => self::sanitize_opt_canvas_dim( $data['height'] ?? null, 180, 4000 ),
			);
		}
		return $out;
	}

	private static function sanitize_opt_canvas_dim( $v, int $min, int $max ): ?int {
		if ( null === $v || '' === $v ) {
			return null;
		}
		if ( ! is_numeric( $v ) ) {
			return null;
		}
		return self::clamp_int( $v, $min, $max, $min );
	}

	private static function sanitize_slides( array $input ): array {
		$out = array();
		foreach ( $input as $slide ) {
			if ( ! is_array( $slide ) ) {
				continue;
			}
			$out[] = self::sanitize_slide( $slide );
		}
		return $out;
	}

	private static function sanitize_slide( array $input ): array {
		$defaults = self::default_slide();

		$id = self::stable_id( $input['id'] ?? '', 's_' );

		$layers_input = isset( $input['layers'] ) && is_array( $input['layers'] ) ? $input['layers'] : array();
		$layers       = array();
		foreach ( $layers_input as $layer ) {
			if ( ! is_array( $layer ) ) {
				continue;
			}
			$layers[] = self::sanitize_layer( $layer );
		}

		return array(
			'id'             => $id,
			'type'           => self::enum( $input['type'] ?? $defaults['type'], self::SLIDE_TYPES, $defaults['type'] ),
			'image_id'       => max( 0, (int) ( $input['image_id'] ?? 0 ) ),
			'image_alt'      => sanitize_text_field( (string) ( $input['image_alt'] ?? '' ) ),
			'image_title'    => sanitize_text_field( (string) ( $input['image_title'] ?? '' ) ),
			'alt_source'     => self::enum( $input['alt_source'] ?? $defaults['alt_source'], self::ATTR_SOURCES, $defaults['alt_source'] ),
			'title_source'   => self::enum( $input['title_source'] ?? $defaults['title_source'], self::ATTR_SOURCES, $defaults['title_source'] ),
			'bg_fit'         => self::enum( $input['bg_fit'] ?? $defaults['bg_fit'], self::BG_FITS, $defaults['bg_fit'] ),
			'bg_size_x'      => self::clamp_int( $input['bg_size_x'] ?? $defaults['bg_size_x'], 1, 1000, $defaults['bg_size_x'] ),
			'bg_size_y'      => self::clamp_int( $input['bg_size_y'] ?? $defaults['bg_size_y'], 1, 1000, $defaults['bg_size_y'] ),
			'bg_repeat'      => self::enum( $input['bg_repeat'] ?? $defaults['bg_repeat'], self::BG_REPEATS, $defaults['bg_repeat'] ),
			'bg_position'    => self::enum( $input['bg_position'] ?? $defaults['bg_position'], self::BG_POSITIONS, $defaults['bg_position'] ),
			'bg_position_x'  => self::clamp_int( $input['bg_position_x'] ?? $defaults['bg_position_x'], -100, 200, $defaults['bg_position_x'] ),
			'bg_position_y'  => self::clamp_int( $input['bg_position_y'] ?? $defaults['bg_position_y'], -100, 200, $defaults['bg_position_y'] ),
			'video_id'       => max( 0, (int) ( $input['video_id'] ?? 0 ) ),
			'bg_color'       => self::color_or_empty( $input['bg_color'] ?? '', true ),
			'heading'        => sanitize_text_field( (string) ( $input['heading'] ?? '' ) ),
			'content'        => wp_kses_post( (string) ( $input['content'] ?? '' ) ),
			'link_url'       => esc_url_raw( (string) ( $input['link_url'] ?? '' ) ),
			'link_target'    => self::enum( $input['link_target'] ?? $defaults['link_target'], self::LINK_TARGETS, $defaults['link_target'] ),
			'layers'         => $layers,
		);
	}

	private static function sanitize_layer( array $input ): array {
		$defaults = self::default_layer();

		$type = self::enum( $input['type'] ?? $defaults['type'], self::LAYER_TYPES, $defaults['type'] );

		$position_in   = is_array( $input['position'] ?? null ) ? $input['position'] : array();
		$size_in       = is_array( $input['size'] ?? null ) ? $input['size'] : array();
		$content_in    = is_array( $input['content'] ?? null ) ? $input['content'] : array();
		$style_in      = is_array( $input['style'] ?? null ) ? $input['style'] : array();
		$anim_in       = is_array( $input['animation'] ?? null ) ? $input['animation'] : array();
		$timing_in     = is_array( $input['timing'] ?? null ) ? $input['timing'] : array();
		$responsive_in = is_array( $input['responsive'] ?? null ) ? $input['responsive'] : array();

		return array(
			'id'         => self::stable_id( $input['id'] ?? '', 'l_' ),
			'name'       => sanitize_text_field( (string) ( $input['name'] ?? '' ) ),
			'type'       => $type,
			'position'   => array(
				'x' => (float) ( $position_in['x'] ?? 0 ),
				'y' => (float) ( $position_in['y'] ?? 0 ),
			),
			'size'       => array(
				'width'  => max( 1, (float) ( $size_in['width'] ?? $defaults['size']['width'] ) ),
				'height' => max( 1, (float) ( $size_in['height'] ?? $defaults['size']['height'] ) ),
			),
			'rotation'   => (float) ( $input['rotation'] ?? 0 ),
			'z_index'    => (int) ( $input['z_index'] ?? 0 ),
			'content'    => self::sanitize_layer_content( $type, $content_in, $defaults['content'] ),
			'style'      => self::sanitize_layer_style( $style_in, $defaults['style'] ),
			'animation'  => array(
				'in'  => self::sanitize_animation_step( is_array( $anim_in['in'] ?? null ) ? $anim_in['in'] : array() ),
				'out' => self::sanitize_animation_step( is_array( $anim_in['out'] ?? null ) ? $anim_in['out'] : array(), 'none' ),
			),
			'timing'     => array(
				'start' => max( 0.0, (float) ( $timing_in['start'] ?? 0 ) ),
				'end'   => isset( $timing_in['end'] ) && is_numeric( $timing_in['end'] ) ? (float) $timing_in['end'] : null,
			),
			'responsive' => self::sanitize_responsive( $responsive_in ),
			'hidden'     => self::boolish( $input['hidden'] ?? false ),
		);
	}

	private static function sanitize_responsive( array $input ): array {
		$out = array();
		foreach ( array( 'tablet', 'mobile' ) as $bp ) {
			$data = is_array( $input[ $bp ] ?? null ) ? $input[ $bp ] : array();
			$out[ $bp ] = array(
				'position' => self::sanitize_opt_position( $data['position'] ?? null ),
				'size'     => self::sanitize_opt_size( $data['size'] ?? null ),
				'style'    => self::sanitize_opt_style( $data['style'] ?? null ),
				'hidden'   => self::sanitize_opt_bool( array_key_exists( 'hidden', $data ) ? $data['hidden'] : null ),
			);
		}
		return $out;
	}

	private static function sanitize_opt_bool( $v ): ?bool {
		if ( null === $v ) {
			return null;
		}
		return self::boolish( $v );
	}

	private static function sanitize_opt_style( $v ): ?array {
		if ( ! is_array( $v ) ) {
			return null;
		}
		$out = array();
		if ( isset( $v['color'] ) ) {
			$out['color'] = self::color( $v['color'], '#000000' );
		}
		if ( isset( $v['background'] ) ) {
			$out['background'] = self::color( $v['background'], 'transparent', true );
		}
		if ( isset( $v['font_size'] ) && is_numeric( $v['font_size'] ) ) {
			$out['font_size'] = self::clamp_float( $v['font_size'], 4, 400, 16.0 );
		}
		if ( isset( $v['font_weight'] ) && is_numeric( $v['font_weight'] ) ) {
			$out['font_weight'] = self::clamp_int( $v['font_weight'], 100, 900, 400 );
		}
		if ( isset( $v['text_align'] ) && is_string( $v['text_align'] ) ) {
			$out['text_align'] = self::enum( $v['text_align'], array( 'left', 'center', 'right', 'justify' ), 'left' );
		}
		if ( isset( $v['padding'] ) && is_numeric( $v['padding'] ) ) {
			$out['padding'] = self::clamp_float( $v['padding'], 0, 200, 0.0 );
		}
		if ( isset( $v['border_radius'] ) && is_numeric( $v['border_radius'] ) ) {
			$out['border_radius'] = self::clamp_float( $v['border_radius'], 0, 1000, 0.0 );
		}
		if ( isset( $v['line_height'] ) && is_numeric( $v['line_height'] ) ) {
			$out['line_height'] = self::clamp_float( $v['line_height'], 0.5, 5.0, 1.3 );
		}
		if ( isset( $v['letter_spacing'] ) && is_numeric( $v['letter_spacing'] ) ) {
			$out['letter_spacing'] = self::clamp_float( $v['letter_spacing'], -10, 50, 0.0 );
		}
		if ( isset( $v['font_family'] ) ) {
			$out['font_family'] = self::font_family_value( $v['font_family'] );
		}
		if ( isset( $v['hover_color'] ) ) {
			$out['hover_color'] = self::color_or_empty( $v['hover_color'] );
		}
		if ( isset( $v['hover_background'] ) ) {
			$out['hover_background'] = self::color_or_empty( $v['hover_background'], true );
		}
		return empty( $out ) ? null : $out;
	}

	private static function sanitize_opt_position( $v ): ?array {
		if ( ! is_array( $v ) ) {
			return null;
		}
		if ( ! isset( $v['x'] ) || ! isset( $v['y'] ) ) {
			return null;
		}
		if ( ! is_numeric( $v['x'] ) || ! is_numeric( $v['y'] ) ) {
			return null;
		}
		return array(
			'x' => (float) $v['x'],
			'y' => (float) $v['y'],
		);
	}

	private static function sanitize_opt_size( $v ): ?array {
		if ( ! is_array( $v ) ) {
			return null;
		}
		if ( ! isset( $v['width'] ) || ! isset( $v['height'] ) ) {
			return null;
		}
		if ( ! is_numeric( $v['width'] ) || ! is_numeric( $v['height'] ) ) {
			return null;
		}
		return array(
			'width'  => max( 1, (float) $v['width'] ),
			'height' => max( 1, (float) $v['height'] ),
		);
	}

	private static function sanitize_layer_content( string $type, array $input, array $defaults ): array {
		$out = $defaults;
		if ( isset( $input['text'] ) ) {
			$out['text'] = wp_kses_post( (string) $input['text'] );
		}
		if ( isset( $input['image_id'] ) ) {
			$out['image_id'] = max( 0, (int) $input['image_id'] );
		}
		if ( isset( $input['href'] ) ) {
			$out['href'] = esc_url_raw( (string) $input['href'] );
		}
		if ( isset( $input['target'] ) ) {
			$out['target'] = self::enum( $input['target'], self::LINK_TARGETS, $defaults['target'] );
		}
		if ( isset( $input['icon'] ) ) {
			$out['icon'] = self::enum( (string) $input['icon'], self::BUTTON_ICONS, 'none' );
		}
		if ( isset( $input['icon_position'] ) ) {
			$out['icon_position'] = self::enum( (string) $input['icon_position'], self::ICON_POSITIONS, 'right' );
		}
		if ( isset( $input['video_url'] ) ) {
			$out['video_url'] = esc_url_raw( (string) $input['video_url'] );
		}
		if ( isset( $input['tag'] ) ) {
			$out['tag'] = self::enum( (string) $input['tag'], self::HEADING_TAGS, 'h2' );
		}
		return $out;
	}

	private static function sanitize_layer_style( array $input, array $defaults ): array {
		return array(
			'color'            => self::color( $input['color'] ?? $defaults['color'], $defaults['color'] ),
			'background'       => self::color( $input['background'] ?? $defaults['background'], $defaults['background'], true ),
			'font_family'      => self::font_family_value( $input['font_family'] ?? '' ),
			'font_size'        => self::clamp_float( $input['font_size'] ?? $defaults['font_size'], 4, 400, (float) $defaults['font_size'] ),
			'font_weight'      => self::clamp_int( $input['font_weight'] ?? $defaults['font_weight'], 100, 900, (int) $defaults['font_weight'] ),
			'text_align'       => self::enum( $input['text_align'] ?? $defaults['text_align'], array( 'left', 'center', 'right', 'justify' ), $defaults['text_align'] ),
			'padding'          => self::clamp_float( $input['padding'] ?? $defaults['padding'], 0, 200, (float) $defaults['padding'] ),
			'border_radius'    => self::clamp_float( $input['border_radius'] ?? $defaults['border_radius'], 0, 1000, (float) $defaults['border_radius'] ),
			'line_height'      => self::clamp_float( $input['line_height'] ?? $defaults['line_height'], 0.5, 5.0, (float) $defaults['line_height'] ),
			'letter_spacing'   => self::clamp_float( $input['letter_spacing'] ?? $defaults['letter_spacing'], -10, 50, (float) $defaults['letter_spacing'] ),
			'hover_color'      => self::color_or_empty( $input['hover_color'] ?? '' ),
			'hover_background' => self::color_or_empty( $input['hover_background'] ?? '', true ),
		);
	}

	private static function font_family_value( $value ): string {
		if ( ! is_string( $value ) ) {
			return '';
		}
		$value = trim( $value );
		return Fonts::is_known( $value ) ? $value : '';
	}

	private static function color_or_empty( $value, bool $allow_transparent = false ): string {
		if ( ! is_string( $value ) ) {
			return '';
		}
		$value = trim( $value );
		if ( '' === $value ) {
			return '';
		}
		if ( $allow_transparent && 'transparent' === $value ) {
			return 'transparent';
		}
		if ( preg_match( '/^#([0-9a-fA-F]{3}|[0-9a-fA-F]{6}|[0-9a-fA-F]{8})$/', $value ) ) {
			return strtolower( $value );
		}
		if ( preg_match( '/^rgba?\(\s*[\d.\s,%\/]+\)$/i', $value ) ) {
			return $value;
		}
		return '';
	}

	private static function sanitize_animation_step( array $input, string $fallback_preset = 'fade-up' ): array {
		$defaults = self::default_animation_step( $fallback_preset );
		return array(
			'preset'   => sanitize_key( (string) ( $input['preset'] ?? $defaults['preset'] ) ),
			'x'        => (float) ( $input['x'] ?? $defaults['x'] ),
			'y'        => (float) ( $input['y'] ?? $defaults['y'] ),
			'opacity'  => self::clamp_float( $input['opacity'] ?? $defaults['opacity'], 0, 1, (float) $defaults['opacity'] ),
			'scale'    => self::clamp_float( $input['scale'] ?? $defaults['scale'], 0, 10, (float) $defaults['scale'] ),
			'rotation' => (float) ( $input['rotation'] ?? $defaults['rotation'] ),
			'duration' => self::clamp_float( $input['duration'] ?? $defaults['duration'], 0, 30, (float) $defaults['duration'] ),
			'delay'    => self::clamp_float( $input['delay'] ?? $defaults['delay'], 0, 60, (float) $defaults['delay'] ),
			'ease'     => self::enum( $input['ease'] ?? $defaults['ease'], self::EASES, $defaults['ease'] ),
		);
	}

	private static function stable_id( $value, string $prefix ): string {
		$value = preg_replace( '/[^a-zA-Z0-9_\-]/', '', (string) $value ) ?? '';
		if ( '' === $value ) {
			$value = $prefix . substr( md5( (string) wp_rand() . (string) microtime( true ) ), 0, 10 );
		}
		return $value;
	}

	private static function enum( $value, array $allowed, string $fallback ): string {
		$value = is_string( $value ) ? $value : (string) $value;
		return in_array( $value, $allowed, true ) ? $value : $fallback;
	}

	private static function boolish( $value ): bool {
		if ( is_bool( $value ) ) {
			return $value;
		}
		if ( is_string( $value ) ) {
			return in_array( strtolower( $value ), array( '1', 'true', 'yes', 'on' ), true );
		}
		return (bool) $value;
	}

	private static function clamp_int( $value, int $min, int $max, int $fallback ): int {
		if ( ! is_numeric( $value ) ) {
			return $fallback;
		}
		$int = (int) $value;
		if ( $int < $min ) {
			return $min;
		}
		if ( $int > $max ) {
			return $max;
		}
		return $int;
	}

	private static function clamp_float( $value, float $min, float $max, float $fallback ): float {
		if ( ! is_numeric( $value ) ) {
			return $fallback;
		}
		$float = (float) $value;
		if ( $float < $min ) {
			return $min;
		}
		if ( $float > $max ) {
			return $max;
		}
		return $float;
	}

	private static function color( $value, string $fallback, bool $allow_transparent = false ): string {
		$value = is_string( $value ) ? trim( $value ) : '';
		if ( $allow_transparent && 'transparent' === $value ) {
			return 'transparent';
		}
		if ( preg_match( '/^#([0-9a-fA-F]{3}|[0-9a-fA-F]{6}|[0-9a-fA-F]{8})$/', $value ) ) {
			return strtolower( $value );
		}
		if ( preg_match( '/^rgba?\(\s*[\d.\s,%\/]+\)$/i', $value ) ) {
			return $value;
		}
		return $fallback;
	}
}
