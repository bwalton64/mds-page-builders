<?php
/**
 * Registers Bricks Builder elements and Dynamic Data tags for MDS Release Manager.
 *
 * @package MDS\PageBuilders
 */

declare(strict_types=1);

namespace MDS\PageBuilders\Bricks;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Coordinates Bricks Builder element registration and Dynamic Data integration.
 *
 * @since 1.0.0
 */
final class BricksIntegration {

	/**
	 * Registers Bricks hooks cleanly (no-op when Bricks is not active).
	 *
	 * @since 1.0.0
	 */
	public static function register_hooks(): void {
		add_action( 'init', array( self::class, 'register_elements' ), 11 );
		DynamicData::register_hooks();
	}

	/**
	 * Registers all 5 thin MDS Bricks elements when Bricks Builder is active.
	 *
	 * @since 1.0.0
	 */
	public static function register_elements(): void {
		if ( ! class_exists( '\Bricks\Elements' ) ) {
			return;
		}

		$element_files = array(
			MDS_PB_PATH . 'src/Bricks/Elements/ReleaseMetaElement.php',
			MDS_PB_PATH . 'src/Bricks/Elements/ReleaseLinksElement.php',
			MDS_PB_PATH . 'src/Bricks/Elements/ReleasePlayerElement.php',
			MDS_PB_PATH . 'src/Bricks/Elements/ArtistDiscographyElement.php',
			MDS_PB_PATH . 'src/Bricks/Elements/CatalogExplorerElement.php',
		);

		foreach ( $element_files as $file ) {
			if ( file_exists( $file ) ) {
				\Bricks\Elements::register_element( $file );
			}
		}
	}
}
