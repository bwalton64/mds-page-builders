<?php
/**
 * Bricks Builder element: Catalog / Discography Explorer.
 *
 * @package MDS\PageBuilders
 */

declare(strict_types=1);

namespace MDS\PageBuilders\Bricks\Elements;

use MDS\ReleaseManager\Blocks\CatalogExplorer;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( '\Bricks\Element' ) ) {
	return;
}

/**
 * Renders the searchable, filterable MDS Catalog / Discography Explorer inside Bricks Builder.
 *
 * @since 1.0.0
 */
class CatalogExplorerElement extends \Bricks\Element {

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
	public $name = 'mds-catalog-explorer';

	/**
	 * Element icon.
	 *
	 * @var string
	 */
	public $icon = 'ti-layout-grid3';

	/**
	 * Returns the element label in the Bricks panel.
	 *
	 * @return string
	 */
	public function get_label() {
		return esc_html__( 'Catalog / Discography Explorer', 'mds-page-builders' );
	}

	/** Defines Bricks inspector controls. */
	public function set_controls() {
		$this->controls['artist_id'] = array(
			'tab'         => 'content',
			'label'       => esc_html__( 'Scope to Artist (Optional)', 'mds-page-builders' ),
			'type'        => 'text',
			'description' => esc_html__( 'Leave blank for the full catalog, or enter an Artist Post ID or UUID.', 'mds-page-builders' ),
		);

		$this->controls['columns'] = array(
			'tab'     => 'content',
			'label'   => esc_html__( 'Grid Columns (Desktop)', 'mds-page-builders' ),
			'type'    => 'select',
			'options' => array(
				'2' => '2',
				'3' => '3',
				'4' => '4',
			),
			'default' => '3',
		);

		$this->controls['per_page'] = array(
			'tab'     => 'content',
			'label'   => esc_html__( 'Releases Per Page', 'mds-page-builders' ),
			'type'    => 'number',
			'default' => 12,
			'min'     => 1,
			'max'     => 48,
		);

		$this->controls['pagination'] = array(
			'tab'     => 'content',
			'label'   => esc_html__( 'Pagination Style', 'mds-page-builders' ),
			'type'    => 'select',
			'options' => array(
				'numbered'  => esc_html__( 'Numbered Pagination', 'mds-page-builders' ),
				'load_more' => esc_html__( 'Load More Button', 'mds-page-builders' ),
			),
			'default' => 'numbered',
		);

		$this->controls['default_sort'] = array(
			'tab'     => 'content',
			'label'   => esc_html__( 'Default Sort Order', 'mds-page-builders' ),
			'type'    => 'select',
			'options' => array(
				'date_desc'  => esc_html__( 'Newest First', 'mds-page-builders' ),
				'date_asc'   => esc_html__( 'Oldest First', 'mds-page-builders' ),
				'title_asc'  => esc_html__( 'Title (A–Z)', 'mds-page-builders' ),
				'artist_asc' => esc_html__( 'Artist (A–Z)', 'mds-page-builders' ),
			),
			'default' => 'date_desc',
		);

		$this->controls['show_search'] = array(
			'tab'     => 'content',
			'label'   => esc_html__( 'Show Search Box', 'mds-page-builders' ),
			'type'    => 'checkbox',
			'default' => true,
		);

		$this->controls['show_filters'] = array(
			'tab'     => 'content',
			'label'   => esc_html__( 'Show Faceted Filters', 'mds-page-builders' ),
			'type'    => 'checkbox',
			'default' => true,
		);

		$this->controls['show_sort'] = array(
			'tab'     => 'content',
			'label'   => esc_html__( 'Show Sort Selector', 'mds-page-builders' ),
			'type'    => 'checkbox',
			'default' => true,
		);

		$this->controls['show_audio'] = array(
			'tab'     => 'content',
			'label'   => esc_html__( 'Show Inline Audio Preview Button', 'mds-page-builders' ),
			'type'    => 'checkbox',
			'default' => true,
		);

		$this->controls['show_links'] = array(
			'tab'     => 'content',
			'label'   => esc_html__( 'Show Quick Buy Now / Streaming Links', 'mds-page-builders' ),
			'type'    => 'checkbox',
			'default' => true,
		);
	}

	/** Renders the Catalog Explorer HTML. */
	public function render() {
		$attrs = array(
			'artistId'    => trim( (string) ( $this->settings['artist_id'] ?? '' ) ),
			'columns'     => absint( $this->settings['columns'] ?? 3 ),
			'perPage'     => absint( $this->settings['per_page'] ?? 12 ),
			'pagination'  => (string) ( $this->settings['pagination'] ?? 'numbered' ),
			'defaultSort' => (string) ( $this->settings['default_sort'] ?? 'date_desc' ),
			'showSearch'  => ! isset( $this->settings['show_search'] ) || ! empty( $this->settings['show_search'] ),
			'showFilters' => ! isset( $this->settings['show_filters'] ) || ! empty( $this->settings['show_filters'] ),
			'showSort'    => ! isset( $this->settings['show_sort'] ) || ! empty( $this->settings['show_sort'] ),
			'showAudio'   => ! isset( $this->settings['show_audio'] ) || ! empty( $this->settings['show_audio'] ),
			'showLinks'   => ! isset( $this->settings['show_links'] ) || ! empty( $this->settings['show_links'] ),
		);

		echo '<div ' . $this->render_attributes( '_root' ) . '>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Escaped by Bricks render_attributes().
		echo CatalogExplorer::render( $attrs ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Escaped by CatalogExplorer::render().
		echo '</div>';
	}
}
