<?php
/**
 * Fired when the plugin is deleted (not just deactivated).
 *
 * Removes all sliders (custom post type + post meta) and the plugin
 * version option that was set on activation.
 *
 * @package BoldSlider
 */

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

// Delete all slider posts and their meta.
$slider_ids = get_posts( array(
	'post_type'      => 'boldslider',
	'post_status'    => 'any',
	'posts_per_page' => -1,
	'fields'         => 'ids',
	'no_found_rows'  => true,
) );

foreach ( $slider_ids as $id ) {
	wp_delete_post( (int) $id, true ); // force-delete, skip trash
}

// Remove plugin options.
delete_option( 'boldslider_version' );
