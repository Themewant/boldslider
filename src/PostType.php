<?php
/**
 * @package BoldSlider
 */

declare(strict_types=1);

namespace BoldSlider;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class PostType {

	public const SLUG = 'boldslider';

	public const META_KEY = '_boldslider_data';

	public function register(): void {
		add_action( 'init', array( $this, 'register_cpt' ) );
		add_action( 'init', array( $this, 'register_meta' ) );
	}

	public function register_cpt(): void {
		$labels = array(
			'name'               => _x( 'Sliders', 'post type general name', 'boldslider' ),
			'singular_name'      => _x( 'Slider', 'post type singular name', 'boldslider' ),
			'menu_name'          => _x( 'BoldSlider', 'admin menu', 'boldslider' ),
			'name_admin_bar'     => _x( 'Slider', 'add new on admin bar', 'boldslider' ),
			'add_new'            => _x( 'Add New', 'slider', 'boldslider' ),
			'add_new_item'       => __( 'Add New Slider', 'boldslider' ),
			'new_item'           => __( 'New Slider', 'boldslider' ),
			'edit_item'          => __( 'Edit Slider', 'boldslider' ),
			'view_item'          => __( 'View Slider', 'boldslider' ),
			'all_items'          => __( 'All Sliders', 'boldslider' ),
			'search_items'       => __( 'Search Sliders', 'boldslider' ),
			'not_found'          => __( 'No sliders found.', 'boldslider' ),
			'not_found_in_trash' => __( 'No sliders found in Trash.', 'boldslider' ),
		);

		register_post_type(
			self::SLUG,
			array(
				'labels'              => $labels,
				'public'              => false,
				'show_ui'             => false,
				'show_in_menu'        => false,
				'show_in_admin_bar'   => false,
				'show_in_nav_menus'   => false,
				'exclude_from_search' => true,
				'publicly_queryable'  => false,
				'has_archive'         => false,
				'rewrite'             => false,
				'query_var'           => false,
				'capability_type'     => 'post',
				'menu_icon'           => 'dashicons-images-alt2',
				'menu_position'       => 30,
				'supports'            => array( 'title' ),
			)
		);
	}

	public function register_meta(): void {
		register_post_meta(
			self::SLUG,
			self::META_KEY,
			array(
				'single'        => true,
				'type'          => 'object',
				'show_in_rest'  => false,
				'auth_callback' => static function ( $allowed, $meta_key, $post_id ): bool {
					return current_user_can( 'edit_post', (int) $post_id );
				},
			)
		);
	}
}
