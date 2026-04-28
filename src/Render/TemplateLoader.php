<?php
/**
 * @package BoldSlider
 */

declare(strict_types=1);

namespace BoldSlider\Render;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class TemplateLoader {

	/**
	 * Resolve a template path. Theme override wins over plugin fallback.
	 */
	public static function locate( string $template ): string {
		$theme_path = locate_template( array( 'boldslider/' . $template ) );
		if ( '' !== $theme_path ) {
			return $theme_path;
		}
		return BOLDSLIDER_PATH . 'templates/' . $template;
	}
}
