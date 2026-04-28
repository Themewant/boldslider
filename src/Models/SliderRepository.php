<?php
/**
 * @package BoldSlider
 */

declare(strict_types=1);

namespace BoldSlider\Models;

use BoldSlider\PostType;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class SliderRepository {

	public static function get( int $post_id ): array {
		$raw = get_post_meta( $post_id, PostType::META_KEY, true );

		// Back-compat: if an earlier save wrote a JSON string, decode it.
		if ( is_string( $raw ) && '' !== $raw ) {
			$decoded = json_decode( $raw, true );
			$raw     = is_array( $decoded ) ? $decoded : array();
		}

		$data = is_array( $raw ) ? $raw : array();

		return Schema::sanitize( $data );
	}

	public static function save( int $post_id, array $data ): void {
		$clean = Schema::sanitize( $data );
		update_post_meta( $post_id, PostType::META_KEY, wp_slash( $clean ) );
	}
}
