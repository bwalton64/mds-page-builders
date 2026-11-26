<?php
/**
 * Bricks Builder element: Release Meta.
 *
 * @package MDS\PageBuilders
 */

declare(strict_types=1);

namespace MDS\PageBuilders\Bricks\Elements;

use MDS\ReleaseManager\Blocks\ReleaseMeta;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( '\Bricks\Element' ) ) {
	return;
}

/**
 * Renders MDS Release Meta inside Bricks Builder.
 *
 * @since 1.0.0
 */
class ReleaseMetaElement extends \Bricks\Element {

	/**
	 * Element category.
	 *
	 * @var string
	 */
	public $category = 'MDS Release Manager';

	/**
	 * Element slug.
	 *
	 * @var string
	 */
	public $name = 'mds-release-meta';

	/**
	 * Element icon.
	 *
	 * @var string
	 */
	public $icon = 'ti-tag';

	/**
	 * Returns the element label in the Bricks panel.
	 *
	 * @return string
	 */
	public function get_label() {
		return esc_html__( 'Release Meta', 'mds-page-builders' );
	}

	/** Defines Bricks inspector controls. */
	public function set_controls() {
		$this->controls['upc'] = array(
			'tab'         => 'content',
			'label'       => esc_html__( 'UPC/EAN Override', 'mds-page-builders' ),
			'type'        => 'text',
			'description' => esc_html__( 'Leave blank to use the current release context.', 'mds-page-builders' ),
		);
	}

	/** Renders the Release Meta HTML. */
	public function render() {
		$upc = trim( (string) ( $this->settings['upc'] ?? '' ) );
		echo '<div ' . $this->render_attributes( '_root' ) . '>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Escaped by Bricks render_attributes().
		echo ReleaseMeta::render( array( 'upc' => $upc ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Escaped by ReleaseMeta::render().
		echo '</div>';
	}
}
