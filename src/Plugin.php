<?php
/**
 * Main plugin coordinator for MDS Page Builders.
 *
 * @package MDS\PageBuilders
 */

declare(strict_types=1);

namespace MDS\PageBuilders;

use MDS\PageBuilders\Bricks\BricksIntegration;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Boots active page-builder adapters once MDS Release Manager is loaded.
 *
 * @since 1.0.0
 */
final class Plugin {

	/**
	 * Prevents duplicate hook registration.
	 *
	 * @var bool
	 */
	private static bool $booted = false;

	/**
	 * Registers builder integration hooks.
	 *
	 * @since 1.0.0
	 */
	public static function boot(): void {
		if ( self::$booted ) {
			return;
		}
		self::$booted = true;

		BricksIntegration::register_hooks();
	}
}
