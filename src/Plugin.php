<?php
/**
 * @package BoldSlider
 */

declare(strict_types=1);

namespace BoldSlider;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Plugin {

	private static ?Plugin $instance = null;

	private bool $booted = false;

	public static function instance(): Plugin {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	private function __construct() {}

	public function boot(): void {
		if ( $this->booted ) {
			return;
		}
		$this->booted = true;

		( new PostType() )->register();
		( new Admin\ListPage() )->register();
		( new Admin\BuilderPage() )->register();
		( new Rest\Controller() )->register();
		( new Frontend\AssetsFrontend() )->register();
		( new Frontend\Shortcode() )->register();
		( new Frontend\PreviewRoute() )->register();
		( new Blocks\SliderBlock() )->register();
		( new Elementor\WidgetManager() )->register();
	}
}
