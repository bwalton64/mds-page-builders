<?php
/**
 * Bricks Builder element: Release Links.
 *
 * @package MDS\PageBuilders
 */

declare(strict_types=1);

namespace MDS\PageBuilders\Bricks\Elements;

use MDS\ReleaseManager\Blocks\ReleaseLinks;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( '\Bricks\Element' ) ) {
	return;
}

/**
 * Renders MDS Release Links inside Bricks Builder.
 *
 * @since 1.0.0
 */
class ReleaseLinksElement extends \Bricks\Element {

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
	public $name = 'mds-release-links';

	/**
	 * Element icon.
	 *
	 * @var string
	 */
	public $icon = 'ti-link';

	/**
	 * Returns the element label in the Bricks panel.
	 *
	 * @return string
	 */
	public function get_label() {
		return esc_html__( 'Release Links', 'mds-page-builders' );
	}

	/** Defines Bricks inspector controls. */
	public function set_controls() {
		$this->controls['upc'] = array(
			'tab'         => 'content',
			'label'       => esc_html__( 'UPC/EAN Override', 'mds-page-builders' ),
			'type'        => 'text',
			'description' => esc_html__( 'Leave blank to use the current release context.', 'mds-page-builders' ),
		);

		$this->controls['buy_now_mode'] = array(
			'tab'         => 'content',
			'label'       => esc_html__( 'Buy Now Behavior', 'mds-page-builders' ),
			'type'        => 'select',
			'options'     => array(
				''       => esc_html__( 'Inherit Site / Release Default', 'mds-page-builders' ),
				'picker' => esc_html__( 'Choose Format Modal', 'mds-page-builders' ),
				'direct' => esc_html__( 'Primary Direct Link', 'mds-page-builders' ),
			),
			'placeholder' => esc_html__( 'Inherit Default', 'mds-page-builders' ),
		);
	}

	/** Renders the Release Links HTML. */
	public function render() {
		$attrs = array(
			'upc' => trim( (string) ( $this->settings['upc'] ?? '' ) ),
		);
		if ( ! empty( $this->settings['buy_now_mode'] ) ) {
			$attrs['buyNowMode'] = (string) $this->settings['buy_now_mode'];
		}

		echo '<div ' . $this->render_attributes( '_root' ) . '>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Escaped by Bricks render_attributes().
		echo ReleaseLinks::render( $attrs ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Escaped by ReleaseLinks::render().
		echo '</div>';
	}
}
