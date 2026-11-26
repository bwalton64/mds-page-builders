# Changelog

All notable changes to **MDS Page Builders** will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [1.0.0] - 2026-11-26

### Added
- Initial release of **MDS Page Builders** (`mds-page-builders`), the paid Tier 2 page-builder companion plugin for **MDS Release Manager**.
- **Bricks Builder Integration** (`src/Bricks/BricksIntegration.php`):
  - Registers 5 native Bricks elements under the `MDS Release Manager` category:
    - **Release Metadata** (`mds-release-meta`)
    - **Release Streaming Links** (`mds-release-links`)
    - **Release Player** (`mds-release-player`)
    - **Artist Discography** (`mds-artist-discography`)
    - **Catalog Explorer** (`mds-catalog-explorer`)
  - Registers 8 Bricks Dynamic Data tags (`src/Bricks/DynamicData.php`): `{mds_release_upc}`, `{mds_release_type}`, `{mds_release_label}`, `{mds_release_distributor}`, `{mds_release_year}`, `{mds_release_artist}`, `{mds_release_buy_now_url}`, and `{mds_artist_website}`.
- GitHub release updater registration via `MDS\ReleaseManager\Api\ExtensionApi::register_github_updater()` with optional `MDS_PB_GITHUB_TOKEN` constant for private repositories.
- Standalone PHP unit test suite (`tests/bricks-dynamic-data.php`) and GitHub Actions release workflow (`.github/workflows/release.yml`).
