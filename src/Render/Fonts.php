<?php
/**
 * @package BoldSlider
 */

declare(strict_types=1);

namespace BoldSlider\Render;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Font registry. Mirrors `editor/src/fonts.js`.
 */
final class Fonts {

	private const STACKS = array(
		''                 => 'inherit',
		'system-sans'      => '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif',
		'system-serif'     => 'Georgia, "Times New Roman", serif',
		'system-mono'      => 'ui-monospace, SFMono-Regular, Menlo, Consolas, monospace',
		'Arial'            => 'Arial, sans-serif',
		'Helvetica'        => 'Helvetica, Arial, sans-serif',
		'Times New Roman'  => '"Times New Roman", Times, serif',
		'Georgia'          => 'Georgia, serif',
		'Verdana'          => 'Verdana, sans-serif',
		'Tahoma'           => 'Tahoma, sans-serif',
		'Courier New'      => '"Courier New", monospace',
	);

	/**
	 * Additional font family names that can be selected in the builder.
	 * These fall back to the browser's stack — they only render correctly
	 * if the user's theme already loads the font.
	 */
	private const EXTRA_FAMILIES = array(
		'Inter', 'Roboto', 'Open Sans', 'Lato', 'Montserrat', 'Poppins',
		'Raleway', 'Oswald', 'Nunito', 'Playfair Display', 'Merriweather',
		'Source Sans 3', 'PT Sans', 'Ubuntu', 'Bebas Neue', 'DM Sans',
		'DM Serif Display', 'Work Sans', 'Rubik', 'Lora', 'Manrope',
		'Karla', 'Mulish', 'Quicksand', 'Anton', 'Archivo', 'Cormorant Garamond',
	);

	public static function is_known( string $name ): bool {
		if ( '' === $name ) {
			return true;
		}
		return isset( self::STACKS[ $name ] ) || in_array( $name, self::EXTRA_FAMILIES, true );
	}

	public static function stack( string $name ): string {
		if ( '' === $name ) {
			return 'inherit';
		}
		if ( isset( self::STACKS[ $name ] ) ) {
			return self::STACKS[ $name ];
		}
		if ( in_array( $name, self::EXTRA_FAMILIES, true ) ) {
			return '"' . $name . '", sans-serif';
		}
		return 'inherit';
	}
}
