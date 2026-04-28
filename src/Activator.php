<?php
/**
 * @package BoldSlider
 */

declare(strict_types=1);

namespace BoldSlider;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Activator {

	public static function activate(): void {
		( new PostType() )->register_cpt();
		flush_rewrite_rules();
		update_option( 'boldslider_version', BOLDSLIDER_VERSION );
	}

	public static function deactivate(): void {
		flush_rewrite_rules();
	}
}
