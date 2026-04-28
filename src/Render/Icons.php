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
 * Predefined button icons. Each SVG is sized 16×16 and uses currentColor.
 *
 * IMPORTANT: Keep in sync with `editor/src/icons.js`.
 */
final class Icons {

	public static function svg( string $id ): string {
		switch ( $id ) {
			case 'arrow-right':
				return '<svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 8h10M9 4l4 4-4 4"/></svg>';
			case 'arrow-left':
				return '<svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M13 8H3M7 4L3 8l4 4"/></svg>';
			case 'chevron-right':
				return '<svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M6 3l5 5-5 5"/></svg>';
			case 'chevron-left':
				return '<svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M10 3L5 8l5 5"/></svg>';
			case 'play':
				return '<svg viewBox="0 0 16 16" fill="currentColor"><path d="M5 3l9 5-9 5V3z"/></svg>';
			case 'download':
				return '<svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M8 2v10M4 8l4 4 4-4M3 14h10"/></svg>';
			case 'external':
				return '<svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M9 3h4v4M13 3L7 9M11 9v3a1 1 0 01-1 1H4a1 1 0 01-1-1V6a1 1 0 011-1h3"/></svg>';
			case 'check':
				return '<svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 8l3 3 7-7"/></svg>';
			case 'plus':
				return '<svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M8 3v10M3 8h10"/></svg>';
			case 'cart':
				return '<svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="6" cy="13" r="1"/><circle cx="12" cy="13" r="1"/><path d="M2 2h2l2 8h8l1-5H5"/></svg>';
			case 'mail':
				return '<svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="12" height="8" rx="1"/><path d="M2 5l6 4 6-4"/></svg>';
			case 'phone':
				return '<svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 4c0 5 4 9 9 9l1-3-3-1-1 1a5 5 0 01-3-3l1-1-1-3-3 1z"/></svg>';
			case 'none':
			default:
				return '';
		}
	}
}
