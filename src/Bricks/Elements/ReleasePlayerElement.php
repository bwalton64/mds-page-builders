<?php
/**
 * Bricks Builder element: Release Player.
 *
 * @package MDS\PageBuilders
 */

declare(strict_types=1);

namespace MDS\PageBuilders\Bricks\Elements;

use MDS\ReleaseManager\Blocks\ReleasePlayer;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( '\Bricks\Element' ) ) {
	return;
}

/**
 * Renders the unified mobile-first MDS Release Player inside Bricks Builder.
 *
 * @since 1.0.0
 */
class ReleasePlayerElement extends \Bricks\Element {

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
	public $name = 'mds-release-player';

	/**
	 * Element icon.
	 *
	 * @var string
	 */
	public $icon = 'ti-control-play';

	/**
	 * Returns the element label in the Bricks panel.
	 *
	 * @return string
	 */
	public function get_label() {
		return esc_html__( 'Release Player', 'mds-page-builders' );
	}

	/** Defines Bricks inspector controls. */
	public function set_controls() {
		$this->controls['upc'] = array(
			'tab'         => 'content',
			'label'       => esc_html__( 'UPC/EAN Override', 'mds-page-builders' ),
			'type'        => 'text',
			'description' => esc_html__( 'Leave blank to use the current release context.', 'mds-page-builders' ),
		);

		$this->controls['show_artwork'] = array(
			'tab'     => 'content',
			'label'   => esc_html__( 'Show Cover Artwork', 'mds-page-builders' ),
			'type'    => 'checkbox',
			'default' => true,
		);

		$this->controls['show_tracklist'] = array(
			'tab'     => 'content',
			'label'   => esc_html__( 'Show Tracklist', 'mds-page-builders' ),
			'type'    => 'checkbox',
			'default' => true,
		);

		$this->controls['show_attribution'] = array(
			'tab'     => 'content',
			'label'   => esc_html__( 'Show Provider Attribution', 'mds-page-builders' ),
			'type'    => 'checkbox',
			'default' => true,
		);
	}

	/** Renders the Release Player HTML. */
	public function render() {
		$attrs = array(
			'upc'             => trim( (string) ( $this->settings['upc'] ?? '' ) ),
			'showArtwork'     => ! isset( $this->settings['show_artwork'] ) || ! empty( $this->settings['show_artwork'] ),
			'showTracklist'   => ! isset( $this->settings['show_tracklist'] ) || ! empty( $this->settings['show_tracklist'] ),
			'showAttribution' => ! isset( $this->settings['show_attribution'] ) || ! empty( $this->settings['show_attribution'] ),
		);

		echo '<div ' . $this->render_attributes( '_root' ) . '>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Escaped by Bricks render_attributes().
		echo ReleasePlayer::render( $attrs ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Escaped by ReleasePlayer::render().
		echo '</div>';
	}
}
