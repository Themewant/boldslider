<?php
/**
 * @package BoldSlider
 */

declare(strict_types=1);

namespace BoldSlider\Rest;

use BoldSlider\Library\LibraryData;
use BoldSlider\Models\Schema;
use BoldSlider\Models\SliderRepository;
use BoldSlider\PostType;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Controller {

	public const NAMESPACE_V1 = 'boldslider/v1';

	public function register(): void {
		add_action( 'rest_api_init', array( $this, 'register_routes' ) );
	}

	public function register_routes(): void {
		// Collection: list + create.
		register_rest_route(
			self::NAMESPACE_V1,
			'/sliders',
			array(
				array(
					'methods'             => \WP_REST_Server::READABLE,
					'callback'            => array( $this, 'list_items' ),
					'permission_callback' => array( $this, 'can_list' ),
				),
				array(
					'methods'             => \WP_REST_Server::CREATABLE,
					'callback'            => array( $this, 'create_item' ),
					'permission_callback' => array( $this, 'can_create' ),
				),
			)
		);

		// Duplicate + import.
		register_rest_route(
			self::NAMESPACE_V1,
			'/sliders/(?P<id>\d+)/duplicate',
			array(
				'methods'             => \WP_REST_Server::CREATABLE,
				'callback'            => array( $this, 'duplicate_item' ),
				'permission_callback' => array( $this, 'can_duplicate_item' ),
				'args'                => array( 'id' => array( 'type' => 'integer', 'required' => true ) ),
			)
		);
		register_rest_route(
			self::NAMESPACE_V1,
			'/sliders/import',
			array(
				'methods'             => \WP_REST_Server::CREATABLE,
				'callback'            => array( $this, 'import_item' ),
				'permission_callback' => array( $this, 'can_create' ),
			)
		);

		// Library: templates + slides. Bundled content used by the builder UI;
		// any user with edit_posts (i.e. who can author a slider) may read them.
		register_rest_route(
			self::NAMESPACE_V1,
			'/library/templates',
			array(
				'methods'             => \WP_REST_Server::READABLE,
				'callback'            => array( $this, 'library_templates' ),
				'permission_callback' => array( $this, 'can_read_library' ),
			)
		);
		register_rest_route(
			self::NAMESPACE_V1,
			'/library/slides',
			array(
				'methods'             => \WP_REST_Server::READABLE,
				'callback'            => array( $this, 'library_slides' ),
				'permission_callback' => array( $this, 'can_read_library' ),
			)
		);

		// Single item: read + update + delete.
		register_rest_route(
			self::NAMESPACE_V1,
			'/sliders/(?P<id>\d+)',
			array(
				array(
					'methods'             => \WP_REST_Server::READABLE,
					'callback'            => array( $this, 'get_item' ),
					'permission_callback' => array( $this, 'can_edit_item' ),
					'args'                => array( 'id' => array( 'type' => 'integer', 'required' => true ) ),
				),
				array(
					'methods'             => \WP_REST_Server::EDITABLE,
					'callback'            => array( $this, 'update_item' ),
					'permission_callback' => array( $this, 'can_edit_item' ),
					'args'                => array( 'id' => array( 'type' => 'integer', 'required' => true ) ),
				),
				array(
					'methods'             => \WP_REST_Server::DELETABLE,
					'callback'            => array( $this, 'delete_item' ),
					'permission_callback' => array( $this, 'can_delete_item' ),
					'args'                => array( 'id' => array( 'type' => 'integer', 'required' => true ) ),
				),
			)
		);
	}

	// ---- Permission callbacks -----------------------------------------------

	public function can_list(): bool {
		// edit_others_posts is required because the list endpoint returns all sliders,
		// including drafts authored by other users.
		return current_user_can( 'edit_others_posts' );
	}

	public function can_create(): bool {
		// Creating a new slider post requires publish_posts capability.
		return current_user_can( 'publish_posts' );
	}

	public function can_read_library(): bool {
		// Library endpoints expose bundled, non-user data used by the builder UI.
		// Any user who can edit posts (i.e. can author a slider) may read them.
		return current_user_can( 'edit_posts' );
	}

	public function can_duplicate_item( \WP_REST_Request $request ) {
		// Duplicate creates a new slider post, so it needs the create capability
		// AND the user must be able to read/edit the source slider.
		if ( ! current_user_can( 'publish_posts' ) ) {
			return new \WP_Error( 'boldslider_forbidden', __( 'You cannot create sliders.', 'boldslider' ), array( 'status' => 403 ) );
		}
		return $this->can_edit_item( $request );
	}

	public function can_edit_item( \WP_REST_Request $request ) {
		$id = (int) $request->get_param( 'id' );
		if ( $id <= 0 ) {
			return new \WP_Error( 'boldslider_invalid_id', __( 'Invalid slider id.', 'boldslider' ), array( 'status' => 400 ) );
		}
		$post = get_post( $id );
		if ( ! $post instanceof \WP_Post || PostType::SLUG !== $post->post_type ) {
			return new \WP_Error( 'boldslider_not_found', __( 'Slider not found.', 'boldslider' ), array( 'status' => 404 ) );
		}
		if ( ! current_user_can( 'edit_post', $id ) ) {
			return new \WP_Error( 'boldslider_forbidden', __( 'You cannot edit this slider.', 'boldslider' ), array( 'status' => 403 ) );
		}
		return true;
	}

	public function can_delete_item( \WP_REST_Request $request ) {
		$id = (int) $request->get_param( 'id' );
		if ( $id <= 0 ) {
			return new \WP_Error( 'boldslider_invalid_id', __( 'Invalid slider id.', 'boldslider' ), array( 'status' => 400 ) );
		}
		$post = get_post( $id );
		if ( ! $post instanceof \WP_Post || PostType::SLUG !== $post->post_type ) {
			return new \WP_Error( 'boldslider_not_found', __( 'Slider not found.', 'boldslider' ), array( 'status' => 404 ) );
		}
		if ( ! current_user_can( 'delete_post', $id ) ) {
			return new \WP_Error( 'boldslider_forbidden', __( 'You cannot delete this slider.', 'boldslider' ), array( 'status' => 403 ) );
		}
		return true;
	}

	// ---- Collection ---------------------------------------------------------

	public function list_items(): \WP_REST_Response {
		$query = new \WP_Query( array(
			'post_type'      => PostType::SLUG,
			'post_status'    => array( 'publish', 'draft' ),
			'posts_per_page' => 100,
			'orderby'        => 'date',
			'order'          => 'DESC',
			'no_found_rows'  => true,
		) );

		$items = array();
		foreach ( $query->posts as $post ) {
			$items[] = $this->format_list_item( $post );
		}

		return new \WP_REST_Response( $items, 200 );
	}

	public function create_item( \WP_REST_Request $request ) {
		$body     = $request->get_json_params() ?: array();
		$title    = isset( $body['title'] ) ? sanitize_text_field( (string) $body['title'] ) : __( 'New Slider', 'boldslider' );
		$template = isset( $body['template'] ) ? sanitize_key( (string) $body['template'] ) : 'simple';

		$post_id = wp_insert_post( array(
			'post_type'   => PostType::SLUG,
			'post_title'  => $title,
			'post_status' => 'publish',
		), true );

		if ( is_wp_error( $post_id ) ) {
			return new \WP_Error( 'boldslider_create_failed', $post_id->get_error_message(), array( 'status' => 500 ) );
		}

		/**
		 * Filter the seed data used when creating a new slider from a template.
		 * Add-on plugins can register additional templates by hooking this filter.
		 *
		 * @param array  $data     Default slider data (from Schema::defaults()).
		 * @param string $template Template id requested by the client.
		 */
		$data = (array) apply_filters( 'boldslider_template_seed', Schema::defaults(), $template );

		SliderRepository::save( $post_id, $data );

		$fake_request = new \WP_REST_Request( 'GET' );
		$fake_request->set_param( 'id', $post_id );
		return $this->get_item( $fake_request );
	}

	// ---- Single item --------------------------------------------------------

	public function get_item( \WP_REST_Request $request ): \WP_REST_Response {
		$id    = (int) $request->get_param( 'id' );
		$post  = get_post( $id );
		// Ensure title is always a non-null string to prevent WordPress strip_tags() deprecation warning.
		$title = $post instanceof \WP_Post ? (string) ( $post->post_title ?? '' ) : '';
		$data  = SliderRepository::get( $id );
		$data  = $this->resolve_image_urls( $data );

		return new \WP_REST_Response( array(
			'id'    => $id,
			'title' => $title,
			'data'  => $data,
		), 200 );
	}

	public function update_item( \WP_REST_Request $request ) {
		$id   = (int) $request->get_param( 'id' );
		$body = $request->get_json_params();
		if ( ! is_array( $body ) ) {
			return new \WP_Error( 'boldslider_bad_body', __( 'Request body must be JSON.', 'boldslider' ), array( 'status' => 400 ) );
		}

		if ( isset( $body['title'] ) && is_string( $body['title'] ) ) {
			wp_update_post( array(
				'ID'         => $id,
				'post_title' => sanitize_text_field( $body['title'] ),
			) );
		}

		$data_in = is_array( $body['data'] ?? null ) ? $body['data'] : array();
		SliderRepository::save( $id, $data_in );

		return $this->get_item( $request );
	}

	public function duplicate_item( \WP_REST_Request $request ) {
		$id   = (int) $request->get_param( 'id' );
		$post = get_post( $id );
		if ( ! $post instanceof \WP_Post ) {
			return new \WP_Error( 'boldslider_not_found', __( 'Slider not found.', 'boldslider' ), array( 'status' => 404 ) );
		}

		$data = SliderRepository::get( $id );

		$new_id = wp_insert_post( array(
			'post_type'   => PostType::SLUG,
			'post_title'  => $post->post_title . ' ' . __( '(copy)', 'boldslider' ),
			'post_status' => 'publish',
		), true );

		if ( is_wp_error( $new_id ) ) {
			return new \WP_Error( 'boldslider_dup_failed', $new_id->get_error_message(), array( 'status' => 500 ) );
		}

		// `save()` re-runs Schema::sanitize, which generates fresh stable IDs for slides + layers.
		// To force regeneration, blank out the existing IDs first.
		if ( isset( $data['slides'] ) && is_array( $data['slides'] ) ) {
			foreach ( $data['slides'] as &$slide ) {
				if ( isset( $slide['id'] ) ) {
					$slide['id'] = '';
				}
				if ( isset( $slide['layers'] ) && is_array( $slide['layers'] ) ) {
					foreach ( $slide['layers'] as &$layer ) {
						if ( isset( $layer['id'] ) ) {
							$layer['id'] = '';
						}
					}
					unset( $layer );
				}
			}
			unset( $slide );
		}

		SliderRepository::save( $new_id, $data );

		$post = get_post( $new_id );
		if ( ! $post instanceof \WP_Post ) {
			return new \WP_Error( 'boldslider_dup_failed', __( 'Failed to retrieve duplicated slider.', 'boldslider' ), array( 'status' => 500 ) );
		}
		return new \WP_REST_Response( $this->format_list_item( $post ), 200 );
	}

	public function import_item( \WP_REST_Request $request ) {
		$body = $request->get_json_params();
		if ( ! is_array( $body ) ) {
			return new \WP_Error( 'boldslider_bad_body', __( 'Request body must be JSON.', 'boldslider' ), array( 'status' => 400 ) );
		}

		// Guard against oversized imports. Schema::sanitize() will strip unknown
		// keys anyway, but a deeply-nested payload could exhaust memory before
		// reaching sanitization. 500 KB covers any realistic slider export.
		$raw_body = $request->get_body();
		if ( strlen( $raw_body ) > 512000 ) {
			return new \WP_Error( 'boldslider_payload_too_large', __( 'Import payload exceeds the 500 KB limit.', 'boldslider' ), array( 'status' => 413 ) );
		}

		$title = isset( $body['title'] ) ? sanitize_text_field( (string) $body['title'] ) : __( 'Imported Slider', 'boldslider' );
		$data  = isset( $body['data'] ) && is_array( $body['data'] ) ? $body['data'] : array();

		$new_id = wp_insert_post( array(
			'post_type'   => PostType::SLUG,
			'post_title'  => $title,
			'post_status' => 'publish',
		), true );

		if ( is_wp_error( $new_id ) ) {
			return new \WP_Error( 'boldslider_import_failed', $new_id->get_error_message(), array( 'status' => 500 ) );
		}

		// Strip stable IDs so the sanitizer regenerates them — avoids collisions with the source slider.
		if ( isset( $data['slides'] ) && is_array( $data['slides'] ) ) {
			foreach ( $data['slides'] as &$slide ) {
				if ( isset( $slide['id'] ) ) {
					$slide['id'] = '';
				}
				if ( isset( $slide['layers'] ) && is_array( $slide['layers'] ) ) {
					foreach ( $slide['layers'] as &$layer ) {
						if ( isset( $layer['id'] ) ) {
							$layer['id'] = '';
						}
					}
					unset( $layer );
				}
			}
			unset( $slide );
		}

		SliderRepository::save( $new_id, $data );

		$post = get_post( $new_id );
		if ( ! $post instanceof \WP_Post ) {
			return new \WP_Error( 'boldslider_import_failed', __( 'Failed to retrieve imported slider.', 'boldslider' ), array( 'status' => 500 ) );
		}
		return new \WP_REST_Response( $this->format_list_item( $post ), 200 );
	}

	public function delete_item( \WP_REST_Request $request ): \WP_REST_Response {
		$id     = (int) $request->get_param( 'id' );
		$result = wp_trash_post( $id );
		if ( ! $result instanceof \WP_Post ) {
			return new \WP_REST_Response( array( 'deleted' => false, 'id' => $id ), 500 );
		}
		return new \WP_REST_Response( array( 'deleted' => true, 'id' => $id ), 200 );
	}

	// ---- Helpers ------------------------------------------------------------

	/**
	 * Inject resolved `image_url` values into the data payload.
	 * These are never persisted — sanitize_slide/layer strips unknown keys.
	 */
	private function resolve_image_urls( array $data ): array {
		$slides = array();
		foreach ( $data['slides'] ?? array() as $slide ) {
			if ( ! empty( $slide['image_id'] ) ) {
				$url = wp_get_attachment_image_url( (int) $slide['image_id'], 'full' );
				$slide['image_url'] = $url ?: '';
			} else {
				$slide['image_url'] = '';
			}

			if ( ! empty( $slide['video_id'] ) ) {
				$vurl = wp_get_attachment_url( (int) $slide['video_id'] );
				$slide['video_url']  = $vurl ?: '';
				$slide['video_mime'] = (string) get_post_mime_type( (int) $slide['video_id'] );
			} else {
				$slide['video_url']  = '';
				$slide['video_mime'] = '';
			}

			$layers = array();
			foreach ( $slide['layers'] ?? array() as $layer ) {
				if ( ( $layer['type'] ?? '' ) === 'image' && ! empty( $layer['content']['image_id'] ) ) {
					$url = wp_get_attachment_image_url( (int) $layer['content']['image_id'], 'full' );
					$layer['content']['image_url'] = $url ?: '';
				} else {
					$layer['content']['image_url'] = $layer['content']['image_url'] ?? '';
				}
				$layers[] = $layer;
			}
			$slide['layers'] = $layers;
			$slides[] = $slide;
		}
		$data['slides'] = $slides;
		return $data;
	}

	// ---- Library endpoints -------------------------------------------------

	public function library_templates(): \WP_REST_Response {
		return new \WP_REST_Response( LibraryData::get_templates(), 200 );
	}

	public function library_slides(): \WP_REST_Response {
		return new \WP_REST_Response( LibraryData::get_slides(), 200 );
	}

	private function format_list_item( \WP_Post $post ): array {
		$data          = SliderRepository::get( $post->ID );
		$slide_count   = count( $data['slides'] );
		$thumbnail_url = '';

		foreach ( $data['slides'] as $slide ) {
			if ( ! empty( $slide['image_id'] ) ) {
				$src = wp_get_attachment_image_url( (int) $slide['image_id'], 'medium' );
				if ( $src ) {
					$thumbnail_url = $src;
					break;
				}
			}
		}

		return array(
			'id'            => $post->ID,
			// Ensure title is always a non-null string to prevent WordPress strip_tags() deprecation warning.
			'title'         => (string) ( $post->post_title ?? '' ),
			'slide_count'   => $slide_count,
			'thumbnail_url' => $thumbnail_url,
			'shortcode'     => \BoldSlider\Admin\BuilderPage::build_shortcode( (int) $post->ID ),
			'preview_url'   => add_query_arg( 'boldslider_preview', $post->ID, home_url( '/' ) ),
		);
	}
}
