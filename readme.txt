=== MDS Page Builders ===
Contributors: bwalton64
Tags: music, discography, bricks, page-builder, release-manager
Requires at least: 7.0
Tested up to: 7.x
Requires PHP: 8.0
Stable tag: 1.0.0
License: GPLv3 or later
License URI: https://www.gnu.org/licenses/gpl-3.0.html

Native Tier 2 page-builder elements and Dynamic Data integrations (Bricks Builder) for MDS Release Manager.

== Description ==

**MDS Page Builders** is an official paid companion plugin for **MDS Release Manager** that provides native page-builder elements and Dynamic Data tags for power-user builders starting with **Bricks Builder**.

= Bricks Builder Elements =

* **Release Metadata** (`mds-release-meta`) — Displays UPC, release type, release date, label, and distributor.
* **Release Streaming Links** (`mds-release-links`) — Displays Buy Now CTA and streaming platform buttons.
* **Release Player** (`mds-release-player`) — Embeds the interactive audio player for the current release.
* **Artist Discography** (`mds-artist-discography`) — Displays a responsive release grid for the current or selected artist.
* **Catalog Explorer** (`mds-catalog-explorer`) — Filterable, searchable, paginated full-catalog explorer.

= Bricks Dynamic Data Tags =

* `{mds_release_upc}`
* `{mds_release_type}`
* `{mds_release_label}`
* `{mds_release_distributor}`
* `{mds_release_year}`
* `{mds_release_artist}`
* `{mds_release_buy_now_url}`
* `{mds_artist_website}`

== Installation ==

1. Ensure **MDS Release Manager** is installed and activated.
2. Upload the `mds-page-builders` folder to `/wp-content/plugins/` or install the ZIP via **Plugins > Add New**.
3. Activate **MDS Page Builders**.
4. Open any template or page in **Bricks Builder** to access the **MDS Release Manager** element category and Dynamic Data group.

== Changelog ==

= 1.0.0 =
* Initial release with 5 native Bricks Builder elements and 8 Bricks Dynamic Data tags.
