<?php
/**
 * Plugin Name: MDS Page Builders
 * Plugin URI: https://mustydungeon.com
 * Description: Pro page builder elements and Dynamic Data integrations (Bricks Builder, with future Divi 5 support) for MDS Release Manager.
 * Version: 1.0.0
 * Requires at least: 7.0
 * Requires PHP: 8.0
 * Requires Plugins: mds-release-manager
 * Update URI: https://api.mustydungeon.com
 * Text Domain: mds-page-builders
 * Domain Path: /languages
 * Author: Musty Dungeon Studios
 * Author URI: https://mustydungeon.com
 * License: GPL-3.0-or-later
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 *
 * @package   MDS\PageBuilders
 * @copyright 2026 Musty Dungeon Studios (Walton International Business Group LLC)
 * @license   GPL-3.0-or-later
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! defined( 'MDS_PB_VERSION' ) ) {
	define( 'MDS_PB_VERSION', '1.0.0' );
}
if ( ! defined( 'MDS_PB_FILE' ) ) {
	define( 'MDS_PB_FILE', __FILE__ );
}
if ( ! defined( 'MDS_PB_PATH' ) ) {
	define( 'MDS_PB_PATH', plugin_dir_path( __FILE__ ) );
}
if ( ! defined( 'MDS_PB_URL' ) ) {
	define( 'MDS_PB_URL', plugin_dir_url( __FILE__ ) );
}
if ( ! defined( 'MDS_PB_BASENAME' ) ) {
	define( 'MDS_PB_BASENAME', plugin_basename( __FILE__ ) );
}

$mds_pb_autoload = MDS_PB_PATH . 'vendor/autoload.php';
if ( is_readable( $mds_pb_autoload ) ) {
	require_once $mds_pb_autoload;
}

add_action(
	'init',
	static function (): void {
		load_plugin_textdomain( 'mds-page-builders', false, dirname( MDS_PB_BASENAME ) . '/languages' );
	}
);

add_action(
	'mds_rm_loaded',
	static function (): void {
		$mds_pb_gw_sdk = dirname( untrailingslashit( MDS_PB_PATH ) ) . '/mds-cloud-gateway/sdk/GatewayClient.php';
		if ( ! class_exists( \MDS\GatewayClient\GatewayClient::class ) && is_readable( $mds_pb_gw_sdk ) ) {
			require_once $mds_pb_gw_sdk;
		}
		if ( class_exists( \MDS\GatewayClient\GatewayClient::class ) ) {
			\MDS\GatewayClient\GatewayClient::boot_companion( 'mds-page-builders', MDS_PB_BASENAME, MDS_PB_VERSION, MDS_PB_PATH );
		}

		if ( class_exists( \MDS\PageBuilders\Plugin::class ) ) {
			\MDS\PageBuilders\Plugin::boot();
		}
	}
);
