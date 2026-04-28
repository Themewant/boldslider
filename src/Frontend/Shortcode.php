<?php
/**
 * @package BoldSlider
 */

declare(strict_types=1);

namespace BoldSlider\Frontend;

use BoldSlider\PostType;
use BoldSlider\Render\Renderer;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Shortcode {

	public const TAG = 'boldslider';

	public function register(): void {
		add_shortcode( self::TAG, array( $this, 'render' ) );
	}

	public function render( $atts ): string {
		$atts = shortcode_atts(
			array(
				'id'   => '',  // slug (alias) — recommended
				'slug' => '',  // explicit alias attribute (alternative spelling)
			),
			is_array( $atts ) ? $atts : array(),
			self::TAG
		);

		$post = $this->resolve_post( $atts );
		if ( ! $post instanceof \WP_Post || PostType::SLUG !== $post->post_type ) {
			return '';
		}
		if ( 'publish' !== $post->post_status && ! current_user_can( 'edit_post', $post->ID ) ) {
			return '';
		}

		AssetsFrontend::ensure_enqueued();

		return ( new Renderer() )->render( (int) $post->ID );
	}

	/**
	 * Resolve the slider post from `id` or `slug` attributes.
	 * Accepts either a numeric ID (legacy) or a slug like `home-hero`.
	 */
	private function resolve_post( array $atts ): ?\WP_Post {
		$id_attr   = trim( (string) $atts['id'] );
		$slug_attr = trim( (string) $atts['slug'] );

		// Slug attribute always wins when both given.
		if ( '' !== $slug_attr ) {
			return $this->find_by_slug( $slug_attr );
		}
		if ( '' === $id_attr ) {
			return null;
		}
		// Numeric → look up by ID for backwards compat.
		if ( ctype_digit( $id_attr ) ) {
			$post = get_post( (int) $id_attr );
			return $post instanceof \WP_Post ? $post : null;
		}
		// Otherwise treat as a slug.
		return $this->find_by_slug( $id_attr );
	}

	private function find_by_slug( string $slug ): ?\WP_Post {
		$slug = sanitize_title( $slug );
		if ( '' === $slug ) {
			return null;
		}
		// Query only published sliders to prevent unauthenticated callers from
		// learning whether a private/draft slug exists (information disclosure).
		// The caller checks edit_post capability before rendering non-published posts,
		// but the query itself would reveal the slug's existence, so restrict here.
		$query = new \WP_Query( array(
			'post_type'      => PostType::SLUG,
			'name'           => $slug,
			'posts_per_page' => 1,
			'post_status'    => 'publish',
			'no_found_rows'  => true,
		) );
		if ( ! $query->have_posts() ) {
			return null;
		}
		return $query->posts[0];
	}
}
