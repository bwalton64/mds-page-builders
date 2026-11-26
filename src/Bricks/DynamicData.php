<?php
/**
 * Bricks Builder Dynamic Data tags for MDS Release Manager posts.
 *
 * @package MDS\PageBuilders
 */

declare(strict_types=1);

namespace MDS\PageBuilders\Bricks;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Exposes `{mds_release_*}` and `{mds_artist_*}` Dynamic Data tags inside Bricks Builder.
 *
 * @since 1.0.0
 */
final class DynamicData {

	/**
	 * Registers Bricks Dynamic Data filters.
	 *
	 * @since 1.0.0
	 */
	public static function register_hooks(): void {
		add_filter( 'bricks/dynamic_tags_list', array( self::class, 'register_tags' ) );
		add_filter( 'bricks/dynamic_data/render_tag', array( self::class, 'render_tag' ), 10, 3 );
		add_filter( 'bricks/dynamic_data/render_content', array( self::class, 'render_content' ), 10, 3 );
		add_filter( 'bricks/frontend/render_data', array( self::class, 'render_content' ), 10, 2 );
	}

	/**
	 * Returns all supported MDS Dynamic Data tag definitions.
	 *
	 * @since 1.0.0
	 * @return array<int, array{name:string,label:string,group:string}>
	 */
	public static function tag_definitions(): array {
		$group = __( 'MDS Release Manager', 'mds-page-builders' );

		return array(
			array(
				'name'  => '{mds_release_upc}',
				'label' => __( 'Release UPC / EAN', 'mds-page-builders' ),
				'group' => $group,
			),
			array(
				'name'  => '{mds_release_type}',
				'label' => __( 'Release Type (Single / EP / Album)', 'mds-page-builders' ),
				'group' => $group,
			),
			array(
				'name'  => '{mds_release_label}',
				'label' => __( 'Record Label', 'mds-page-builders' ),
				'group' => $group,
			),
			array(
				'name'  => '{mds_release_distributor}',
				'label' => __( 'Distributor', 'mds-page-builders' ),
				'group' => $group,
			),
			array(
				'name'  => '{mds_release_year}',
				'label' => __( 'Release Year', 'mds-page-builders' ),
				'group' => $group,
			),
			array(
				'name'  => '{mds_release_artist}',
				'label' => __( 'Release Artist Name', 'mds-page-builders' ),
				'group' => $group,
			),
			array(
				'name'  => '{mds_release_buy_now_url}',
				'label' => __( 'Release Primary Buy Now URL', 'mds-page-builders' ),
				'group' => $group,
			),
			array(
				'name'  => '{mds_artist_website}',
				'label' => __( 'Artist Website URL', 'mds-page-builders' ),
				'group' => $group,
			),
		);
	}

	/**
	 * Appends MDS tags to the Bricks Dynamic Data picker.
	 *
	 * @since 1.0.0
	 * @param array<int, array<string, mixed>> $tags Existing Bricks tags.
	 * @return array<int, array<string, mixed>>
	 */
	public static function register_tags( array $tags ): array {
		return array_merge( $tags, self::tag_definitions() );
	}

	/**
	 * Renders a single Bricks Dynamic Data tag.
	 *
	 * @since 1.0.0
	 * @param mixed  $tag     Tag name (with or without braces).
	 * @param mixed  $post    Current WP_Post context (may be null).
	 * @param string $context Render context (`text`, `link`, `image`, etc.).
	 * @return mixed Resolved value or original `$tag`.
	 */
	public static function render_tag( mixed $tag, mixed $post, string $context = 'text' ) {
		unset( $context );
		if ( ! is_string( $tag ) ) {
			return $tag;
		}

		$normalized = trim( $tag, '{}' );
		if ( ! str_starts_with( $normalized, 'mds_' ) ) {
			return $tag;
		}

		$post_id = ( is_object( $post ) && isset( $post->ID ) ) ? (int) $post->ID : ( function_exists( 'get_the_ID' ) ? (int) get_the_ID() : 0 );
		$value   = self::resolve_tag( $normalized, $post_id );

		return null !== $value ? $value : $tag;
	}

	/**
	 * Replaces any `{mds_*}` tokens inside a Bricks content string.
	 *
	 * @since 1.0.0
	 * @param string $content Content string possibly containing `{mds_*}` tags.
	 * @param mixed  $post    Current WP_Post context.
	 * @param string $context Render context.
	 * @return string Rendered content.
	 */
	public static function render_content( string $content, mixed $post, string $context = 'text' ): string {
		if ( ! str_contains( $content, '{mds_' ) ) {
			return $content;
		}

		return (string) preg_replace_callback(
			'/\{(mds_[a-z0-9_]+)\}/',
			static function ( array $matches ) use ( $post, $context ): string {
				$resolved = self::render_tag( $matches[1], $post, $context );
				return ( $resolved === $matches[1] ) ? $matches[0] : (string) $resolved;
			},
			$content
		);
	}

	/**
	 * Resolves a single `mds_*` tag slug for a given post ID.
	 *
	 * @since 1.0.0
	 * @param string $tag_slug Tag slug without braces (e.g. `mds_release_upc`).
	 * @param int    $post_id  Post ID.
	 * @return string|null Resolved value, or null if tag is unknown.
	 */
	public static function resolve_tag( string $tag_slug, int $post_id ): ?string {
		if ( $post_id <= 0 ) {
			return '';
		}

		switch ( $tag_slug ) {
			case 'mds_release_upc':
				return (string) get_post_meta( $post_id, 'upc_ean', true );

			case 'mds_release_type':
				if ( class_exists( \MDS\ReleaseManager\Core\ReleaseModel::class ) ) {
					$fmt = \MDS\ReleaseManager\Core\ReleaseModel::format_name( $post_id );
					return is_string( $fmt ) ? $fmt : '';
				}
				return '';

			case 'mds_release_label':
				return (string) get_post_meta( $post_id, 'record_label', true );

			case 'mds_release_distributor':
				return (string) get_post_meta( $post_id, 'distributor', true );

			case 'mds_release_year':
				return function_exists( 'get_the_date' ) ? (string) get_the_date( 'Y', $post_id ) : '';

			case 'mds_release_artist':
				$artist_uuid = (string) get_post_meta( $post_id, 'artist_id', true );
				if ( '' === $artist_uuid || ! function_exists( 'get_posts' ) ) {
					return '';
				}
				$artists = get_posts(
					array(
						'post_type'      => 'artist',
						'post_status'    => 'publish',
						'posts_per_page' => 1,
						'no_found_rows'  => true,
						'meta_key'       => '_mds_artist_uuid', // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key -- Resolves artist name for Bricks Dynamic Data tag.
						'meta_value'     => $artist_uuid, // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_value
					)
				);
				return ( ! empty( $artists ) && isset( $artists[0]->post_title ) ) ? (string) $artists[0]->post_title : '';

			case 'mds_release_buy_now_url':
				if ( class_exists( \MDS\ReleaseManager\Core\ReleaseModel::class ) ) {
					return esc_url_raw( \MDS\ReleaseManager\Core\ReleaseModel::get_primary_buy_now_url( $post_id ) );
				}
				return esc_url_raw( (string) get_post_meta( $post_id, 'buy_now_link', true ) );

			case 'mds_artist_website':
				return esc_url_raw( (string) get_post_meta( $post_id, 'artist_website', true ) );
		}

		return null;
	}
}
