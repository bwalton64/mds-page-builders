<?php
/**
 * Bricks Builder element: Artist Discography.
 *
 * @package MDS\PageBuilders
 */

declare(strict_types=1);

namespace MDS\PageBuilders\Bricks\Elements;

use MDS\ReleaseManager\Frontend\Discography;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( '\Bricks\Element' ) ) {
	return;
}

/**
 * Renders the paginated MDS Artist Discography table inside Bricks Builder.
 *
 * @since 1.0.0
 */
class ArtistDiscographyElement extends \Bricks\Element {

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
	public $name = 'mds-artist-discography';

	/**
	 * Element icon.
	 *
	 * @var string
	 */
	public $icon = 'ti-layout-list-thumb';

	/**
	 * Returns the element label in the Bricks panel.
	 *
	 * @return string
	 */
	public function get_label() {
		return esc_html__( 'Artist Discography', 'mds-page-builders' );
	}

	/** Defines Bricks inspector controls. */
	public function set_controls() {
		$this->controls['artist_id'] = array(
			'tab'         => 'content',
			'label'       => esc_html__( 'Artist Post ID (Optional)', 'mds-page-builders' ),
			'type'        => 'number',
			'description' => esc_html__( 'Leave blank to use the current Artist page context.', 'mds-page-builders' ),
		);

		$this->controls['per_page'] = array(
			'tab'     => 'content',
			'label'   => esc_html__( 'Releases Per Page', 'mds-page-builders' ),
			'type'    => 'number',
			'default' => 10,
			'min'     => 1,
			'max'     => 100,
		);

		$this->controls['striped'] = array(
			'tab'     => 'content',
			'label'   => esc_html__( 'Striped Rows', 'mds-page-builders' ),
			'type'    => 'checkbox',
			'default' => true,
		);
	}

	/** Renders the Artist Discography HTML. */
	public function render() {
		$atts = array(
			'artist_id' => absint( $this->settings['artist_id'] ?? 0 ),
			'per_page'  => max( 1, absint( $this->settings['per_page'] ?? 10 ) ),
			'striped'   => ( ! isset( $this->settings['striped'] ) || ! empty( $this->settings['striped'] ) ) ? '1' : '0',
		);

		echo '<div ' . $this->render_attributes( '_root' ) . '>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Escaped by Bricks render_attributes().
		echo Discography::shortcode( $atts ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Escaped by Discography::shortcode().
		echo '</div>';
	}
}
