# MDS Page Builders — Technical Blueprint

## Overview

- **Plugin Name:** `MDS Page Builders`
- **Slug / Text Domain:** `mds-page-builders`
- **PHP Root Namespace:** `MDS\PageBuilders` (PSR-4 → `src/`)
- **Minimum Requirements:** WordPress `7.0+`, PHP `8.0+`, `MDS Release Manager` active.
- **Tier:** Paid Extension (`mds-product-tiers.md` Tier 2 Page Builders).

## Architecture

1. **Bootstrap (`mds-page-builders.php`):**
   - Defines `MDS_PB_VERSION`, `MDS_PB_FILE`, `MDS_PB_PATH`, `MDS_PB_URL`, `MDS_PB_BASENAME`.
   - Loads Composer PSR-4 autoloader (`vendor/autoload.php`).
   - Hooks `mds_rm_loaded` so it boots only when `MDS Release Manager` is active.
   - Registers GitHub updates via `MDS\ReleaseManager\Api\ExtensionApi::register_github_updater()` using `bwalton64/mds-page-builders` and optional `MDS_PB_GITHUB_TOKEN`.
2. **Orchestrator (`src/Plugin.php`):**
   - Singleton entry point that loads text domain and boots each builder adapter (`BricksIntegration::init()`).
3. **Bricks Builder Adapter (`src/Bricks/`):**
   - `BricksIntegration.php`: Guards on `class_exists( '\Bricks\Elements' )`, registers all 5 element files on `init` (priority `11`), and initializes `DynamicData`.
   - `DynamicData.php`: Hooks `bricks/dynamic_tags_list`, `bricks/dynamic_data/render_tag`, and `bricks/dynamic_data/render_content` to expose 8 release/artist fields.
   - `Elements/*.php`: Five `\Bricks\Element` subclasses (`ReleaseMetaElement`, `ReleaseLinksElement`, `ReleasePlayerElement`, `ArtistDiscographyElement`, `CatalogExplorerElement`) that map Bricks controls directly onto core `MDS\ReleaseManager` renderers.

## File Map

```text
mds-page-builders/
├── .agents/
│   ├── rules/project-config.md
│   └── technical-blueprint.md
├── .github/workflows/release.yml
├── .vscode/settings.json
├── src/
│   ├── Plugin.php
│   └── Bricks/
│       ├── BricksIntegration.php
│       ├── DynamicData.php
│       └── Elements/
│           ├── ArtistDiscographyElement.php
│           ├── CatalogExplorerElement.php
│           ├── ReleaseLinksElement.php
│           ├── ReleaseMetaElement.php
│           └── ReleasePlayerElement.php
├── tests/
│   └── bricks-dynamic-data.php
├── composer.json
├── mds-page-builders.php
├── phpcs.xml.dist
├── README.md
├── readme.txt
├── changelog.md
├── uninstall.php
└── wpml-config.xml
```
