<?php
/**
 * Standalone unit tests for Bricks Dynamic Data tags.
 *
 * Run: php tests/bricks-dynamic-data.php
 *
 * @package MDS\PageBuilders
 */

declare(strict_types=1);

// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals, WordPress.WP.AlternativeFunctions, WordPress.Security.EscapeOutput

if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __DIR__ ) . '/' );
}

// Minimal WordPress function stubs for standalone CLI execution.
$GLOBALS['mds_pb_test_meta'] = array(
	42 => array(
		'upc_ean'        => '198704123456',
		'record_label'   => 'Blue Ridge Records',
		'distributor'    => 'DistroKid',
		'buy_now_link'   => 'https://store.example.com/album/42',
		'artist_website' => 'https://artist.example.com',
	),
);

if ( ! function_exists( '__' ) ) {
	function __( string $text, string $domain = 'default' ): string {
		unset( $domain );
		return $text;
	}
}

if ( ! function_exists( 'get_post_meta' ) ) {
	function get_post_meta( int $post_id, string $key = '', bool $single = false ): mixed {
		$value = $GLOBALS['mds_pb_test_meta'][ $post_id ][ $key ] ?? '';
		return $single ? $value : array( $value );
	}
}

if ( ! function_exists( 'esc_url_raw' ) ) {
	function esc_url_raw( string $url ): string {
		return filter_var( $url, FILTER_SANITIZE_URL ) ?: '';
	}
}

if ( ! function_exists( 'get_the_date' ) ) {
	function get_the_date( string $format = '', int $post_id = 0 ): string {
		unset( $format );
		return 42 === $post_id ? '2026' : '';
	}
}

require_once dirname( __DIR__ ) . '/src/Bricks/DynamicData.php';

use MDS\PageBuilders\Bricks\DynamicData;

$assertions = 0;

/**
 * Simple assertion helper.
 *
 * @param mixed  $expected Expected value.
 * @param mixed  $actual   Actual value.
 * @param string $label    Test label.
 */
function mds_pb_assert_same( mixed $expected, mixed $actual, string $label ): void {
	global $assertions;
	++$assertions;
	if ( $expected !== $actual ) {
		fwrite(
			STDERR,
			sprintf(
				"FAIL [%s]: expected %s, got %s\n",
				$label,
				var_export( $expected, true ),
				var_export( $actual, true )
			)
		);
		exit( 1 );
	}
}

// 1. Tag definitions count & structure.
$defs = DynamicData::tag_definitions();
mds_pb_assert_same( 8, count( $defs ), 'tag_definitions returns 8 tags' );
mds_pb_assert_same( '{mds_release_upc}', $defs[0]['name'], 'first tag is {mds_release_upc}' );
mds_pb_assert_same( 'MDS Release Manager', $defs[0]['group'], 'tag group is MDS Release Manager' );

// 2. register_tags appends to existing array.
$registered = DynamicData::register_tags( array( array( 'name' => '{post_title}' ) ) );
mds_pb_assert_same( 9, count( $registered ), 'register_tags appends all 8 tags' );

// 3. resolve_tag values.
mds_pb_assert_same( '198704123456', DynamicData::resolve_tag( 'mds_release_upc', 42 ), 'resolves UPC' );
mds_pb_assert_same( 'Blue Ridge Records', DynamicData::resolve_tag( 'mds_release_label', 42 ), 'resolves record label' );
mds_pb_assert_same( 'DistroKid', DynamicData::resolve_tag( 'mds_release_distributor', 42 ), 'resolves distributor' );
mds_pb_assert_same( '2026', DynamicData::resolve_tag( 'mds_release_year', 42 ), 'resolves release year' );
mds_pb_assert_same( 'https://store.example.com/album/42', DynamicData::resolve_tag( 'mds_release_buy_now_url', 42 ), 'resolves buy_now_link fallback' );
mds_pb_assert_same( 'https://artist.example.com', DynamicData::resolve_tag( 'mds_artist_website', 42 ), 'resolves artist_website' );
mds_pb_assert_same( '', DynamicData::resolve_tag( 'mds_release_upc', 0 ), 'invalid post ID returns empty string' );
mds_pb_assert_same( null, DynamicData::resolve_tag( 'mds_unknown_tag', 42 ), 'unknown tag returns null' );

// 4. render_tag & render_content.
$post = (object) array( 'ID' => 42 );
mds_pb_assert_same( '198704123456', DynamicData::render_tag( '{mds_release_upc}', $post ), 'render_tag resolves braced tag' );
mds_pb_assert_same( '{other_tag}', DynamicData::render_tag( '{other_tag}', $post ), 'render_tag ignores non-mds tags' );
mds_pb_assert_same(
	'Label: Blue Ridge Records (2026) — UPC 198704123456 — {mds_unknown_tag}',
	DynamicData::render_content(
		'Label: {mds_release_label} ({mds_release_year}) — UPC {mds_release_upc} — {mds_unknown_tag}',
		$post
	),
	'render_content substitutes known tags and leaves unknown tags intact'
);

echo sprintf( "PASS: %d Bricks Dynamic Data assertions succeeded.\n", $assertions );
