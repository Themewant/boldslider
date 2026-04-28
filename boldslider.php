<?php
/**
 * Plugin Name:       BoldSlider
 * Plugin URI:        https://themewant.com
 * Description:       A fast, modern WordPress slider plugin with a visual layer editor. Powered by Swiper.
 * Version:           0.1.0
 * Requires at least: 6.0
 * Requires PHP:      7.4
 * Author:            maha25
 * Author URI:        https://themewant.com
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       boldslider
 * Domain Path:       /languages
 *
 * @package BoldSlider
 */

declare(strict_types=1);

if (!defined('ABSPATH')) {
	exit;
}

define('BOLDSLIDER_VERSION', '0.1.0');
define('BOLDSLIDER_FILE', __FILE__);
define('BOLDSLIDER_PATH', plugin_dir_path(__FILE__));
define('BOLDSLIDER_URL', plugin_dir_url(__FILE__));
define('BOLDSLIDER_BASENAME', plugin_basename(__FILE__));

$boldslider_autoload = BOLDSLIDER_PATH . 'vendor/autoload.php';
if (file_exists($boldslider_autoload)) {
	require_once $boldslider_autoload;
} else {
	spl_autoload_register(
		static function (string $class): void {
			if (strpos($class, 'BoldSlider\\') !== 0) {
				return;
			}
			$relative = substr($class, strlen('BoldSlider\\'));
			$path = BOLDSLIDER_PATH . 'src/' . str_replace('\\', '/', $relative) . '.php';
			if (file_exists($path)) {
				require_once $path;
			}
		}
	);
}

register_activation_hook(__FILE__, array(\BoldSlider\Activator::class, 'activate'));
register_deactivation_hook(__FILE__, array(\BoldSlider\Activator::class, 'deactivate'));

add_action(
	'plugins_loaded',
	static function (): void {
		\BoldSlider\Plugin::instance()->boot();
	}
);

function boldslider(): \BoldSlider\Plugin
{
	return \BoldSlider\Plugin::instance();
}
