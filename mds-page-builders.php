<?php
/**
 * Plugin Name: MDS Page Builders
 * Description: Pro page builder elements and Dynamic Data integrations (Bricks Builder, with future Divi 5 support) for MDS Release Manager.
 * Version: 1.0.0
 * Requires at least: 7.0
 * Requires PHP: 8.0
 * Requires Plugins: mds-release-manager
 * Update URI: https://github.com/bwalton64/mds-page-builders
 * Text Domain: mds-page-builders
 * Domain Path: /languages
 * Author: Musty Dungeon Studios
 * Author URI: https://mustydungeon.com
 * License: GPL-2.0-or-later
 * License URI: https://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 *
 * @package MDS\PageBuilders
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
		if ( class_exists( \MDS\ReleaseManager\Api\ExtensionApi::class ) ) {
			\MDS\ReleaseManager\Api\ExtensionApi::register_github_updater(
				array(
					'basename'       => MDS_PB_BASENAME,
					'slug'           => 'mds-page-builders',
					'repo'           => 'bwalton64/mds-page-builders',
					'version'        => MDS_PB_VERSION,
					'name'           => 'MDS Page Builders',
					'author'         => 'Musty Dungeon Studios',
					'homepage'       => 'https://mustydungeon.com',
					'token_constant' => 'MDS_PB_GITHUB_TOKEN',
					'requires'       => '7.0',
					'tested'         => '7.0',
					'requires_php'   => '8.0',
				)
			);
		}

		if ( class_exists( \MDS\PageBuilders\Plugin::class ) ) {
			\MDS\PageBuilders\Plugin::boot();
		}
	}
);
