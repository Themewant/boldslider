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

	/** Google fonts → wght axis. */
	private const GOOGLE = array(
		'Inter'              => '300;400;500;600;700',
		'Roboto'             => '300;400;500;700',
		'Open Sans'          => '300;400;600;700',
		'Lato'               => '300;400;700;900',
		'Montserrat'         => '300;400;500;600;700;800',
		'Poppins'            => '300;400;500;600;700',
		'Raleway'            => '300;400;500;600;700',
		'Oswald'             => '300;400;500;600;700',
		'Nunito'             => '300;400;600;700',
		'Playfair Display'   => '400;500;600;700',
		'Merriweather'       => '300;400;700;900',
		'Source Sans 3'      => '300;400;600;700',
		'PT Sans'            => '400;700',
		'Ubuntu'             => '300;400;500;700',
		'Bebas Neue'         => '400',
		'DM Sans'            => '300;400;500;700',
		'DM Serif Display'   => '400',
		'Work Sans'          => '300;400;500;600;700',
		'Rubik'              => '300;400;500;600;700',
		'Lora'               => '400;500;600;700',
		'Manrope'            => '300;400;500;600;700',
		'Karla'              => '400;500;600;700',
		'Mulish'             => '300;400;500;600;700',
		'Quicksand'          => '400;500;600;700',
		'Anton'              => '400',
		'Archivo'            => '300;400;500;600;700',
		'Cormorant Garamond' => '400;500;600;700',
	);

	public static function is_known( string $name ): bool {
		if ( '' === $name ) {
			return true;
		}
		return isset( self::STACKS[ $name ] ) || isset( self::GOOGLE[ $name ] );
	}

	public static function is_google( string $name ): bool {
		return '' !== $name && isset( self::GOOGLE[ $name ] );
	}

	public static function stack( string $name ): string {
		if ( '' === $name ) {
			return 'inherit';
		}
		if ( isset( self::STACKS[ $name ] ) ) {
			return self::STACKS[ $name ];
		}
		if ( isset( self::GOOGLE[ $name ] ) ) {
			return '"' . $name . '", sans-serif';
		}
		return 'inherit';
	}

	/**
	 * Build a Google Fonts CSS2 URL for the given families.
	 * Returns '' if no valid Google fonts are passed.
	 */
	public static function google_url( array $families ): string {
		$pairs = array();
		foreach ( array_unique( array_filter( $families ) ) as $name ) {
			if ( ! self::is_google( $name ) ) {
				continue;
			}
			$pairs[] = str_replace( ' ', '+', $name ) . ':wght@' . self::GOOGLE[ $name ];
		}
		if ( empty( $pairs ) ) {
			return '';
		}
		return 'https://fonts.googleapis.com/css2?family=' . implode( '&family=', $pairs ) . '&display=swap';
	}

	/**
	 * URL with every Google font in the registry — used by the builder so the
	 * preview matches the dropdown.
	 */
	public static function google_url_all(): string {
		return self::google_url( array_keys( self::GOOGLE ) );
	}

	/**
	 * Walk a slider's data and collect every Google font referenced
	 * (in base style + per-viewport responsive overrides).
	 */
	public static function collect_used( array $data ): array {
		$used = array();
		foreach ( $data['slides'] ?? array() as $slide ) {
			foreach ( $slide['layers'] ?? array() as $layer ) {
				$f = (string) ( $layer['style']['font_family'] ?? '' );
				if ( self::is_google( $f ) ) {
					$used[ $f ] = true;
				}
				foreach ( array( 'tablet', 'mobile' ) as $bp ) {
					$f = (string) ( $layer['responsive'][ $bp ]['style']['font_family'] ?? '' );
					if ( self::is_google( $f ) ) {
						$used[ $f ] = true;
					}
				}
			}
		}
		return array_keys( $used );
	}
}
