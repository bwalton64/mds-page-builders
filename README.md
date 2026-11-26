# MDS Page Builders

Paid companion extension for **MDS Release Manager** that adds native **Tier 2** page-builder elements and Dynamic Data integrations — starting with **Bricks Builder** — without bloating the free core plugin.

## Requirements

- WordPress `7.0+`
- PHP `8.0+`
- **MDS Release Manager** (`mds-release-manager`) active
- **Bricks Builder** theme active (for Bricks elements and Dynamic Data tags)

## Features

### Bricks Builder Elements (Category: `MDS Release Manager`)

Every Bricks element delegates directly to the canonical server-side renderers in `MDS\ReleaseManager`, preserving CSS, interactivity, and accessibility parity across Gutenberg, Elementor, and Bricks:

| Element | Name | Core Renderer |
| :--- | :--- | :--- |
| **Release Metadata** | `mds-release-meta` | `MDS\ReleaseManager\Blocks\ReleaseMeta::render()` |
| **Release Streaming Links** | `mds-release-links` | `MDS\ReleaseManager\Blocks\ReleaseLinks::render()` |
| **Release Player** | `mds-release-player` | `MDS\ReleaseManager\Blocks\ReleasePlayer::render()` |
| **Artist Discography** | `mds-artist-discography` | `MDS\ReleaseManager\Shortcodes\Discography::shortcode()` |
| **Catalog Explorer** | `mds-catalog-explorer` | `MDS\ReleaseManager\Blocks\CatalogExplorer::render()` |

### Bricks Dynamic Data Tags (Group: `MDS Release Manager`)

Use inside any Bricks heading, text, button, link, or Query Loop template:

- `{mds_release_upc}` — Release UPC / EAN barcode
- `{mds_release_type}` — Release type (Single, EP, Album, etc.)
- `{mds_release_label}` — Record label
- `{mds_release_distributor}` — Music distributor
- `{mds_release_year}` — Four-digit release year
- `{mds_release_artist}` — Primary artist name
- `{mds_release_buy_now_url}` — Resolved Buy Now / Store URL
- `{mds_artist_website}` — Artist official website URL

## GitHub Updates

Automatic updates are wired through `MDS\ReleaseManager\Api\ExtensionApi::register_github_updater()` targeting `bwalton64/mds-page-builders`. For private repositories, define `MDS_PB_GITHUB_TOKEN` in `wp-config.php`.

## Development

```bash
composer dump-autoload
php tests/bricks-dynamic-data.php
```
