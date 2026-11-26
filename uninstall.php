<?php
/**
 * Uninstall routine for MDS Page Builders.
 *
 * @package MDS\PageBuilders
 */

declare(strict_types=1);

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

// MDS Page Builders stores no custom database tables or persistent options of its own;
// all release/artist data lives in MDS Release Manager.
