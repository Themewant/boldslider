=== BoldSlider ===
Contributors: maha25
Tags: slider, carousel, swiper, slideshow, hero
Requires at least: 6.0
Tested up to: 6.9
Requires PHP: 7.4
Stable tag: 0.1.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

A fast, modern WordPress slider plugin with a visual layer editor. Powered by Swiper. No jQuery, no external CDN.

== Description ==

BoldSlider is a lightweight, fully-responsive slider builder for WordPress with a real visual editor — drag layers on a canvas, set per-device overrides, and embed via shortcode or Gutenberg block.

= Free version highlights =

* **Visual builder** — drag, resize, rotate layers on a real canvas. Eight resize handles. Keyboard nudge + delete.
* **Per-device responsive** — override layer position, size, font size, color, and visibility separately for Desktop / Tablet / Mobile.
* **Layer types (7 free):** Heading, Paragraph, Image, Button, Shape, YouTube embed, Vimeo embed.
* **Slider effects:** Slide, Fade, Cube, Coverflow, Flip, Cards.
* **Backgrounds:** image (with cover/contain/percentage/auto fit, repeat, 9-grid + custom position), color, uploaded MP4 video.
* **Background animations:** Ken Burns, Zoom In, Zoom Out, Pan Left, Pan Right.
* **Navigation arrows** with placement (inside/outside) + position (top/middle/bottom) + size + offset + colors + hover styles.
* **Pagination** (bullets / fraction / progress bar) with placement, position, bullet size/gap, clickable, active + inactive colors.
* **Thumbnail strip** (Swiper Thumbs).
* **Autoplay** with delay + pause-on-hover.
* **Layer animations** — 8 CSS-based entrance presets (fade, fade-up/down/left/right, zoom-in/out).
* **Button hover styles** + 12 built-in arrow icons.
* **Free templates:** Simple slider (more templates in the BoldSlider Pro add-on).
* **Embed** via `[boldslider id="your-slider-slug"]` shortcode or Gutenberg block.
* **Import / Export** sliders as JSON.
* **Duplicate** sliders + slides in one click.
* **Slider library page** with thumbnail previews + search.
* **Performance:** lazy-load images, no jQuery, no external CDN, deferred JS.
* **SEO friendly:** semantic `<h1>`–`<h6>` headings, `alt` and `title` attributes (Media Library or custom).
* **Accessibility:** keyboard navigation, proper ARIA labels.

= External services =

This free version of BoldSlider does not call out to any external services or CDNs. All assets are bundled locally inside the plugin.

= Pro add-on (sold separately) =

The Pro add-on plugin adds: Carousel/multi-slide layouts, advanced effects (Cube/Coverflow extensions, Panorama, Carousel, Shutters, Slicer, GL, Tinder, Material, Cards Stack, Expo, Super Flow, Creative), GSAP-powered animations, animation OUT, post slider, WooCommerce slider, Lottie & form layers, YouTube/Vimeo background videos, hash navigation, scrollbar, mouse wheel control, free mode, dynamic bullets, custom navigation icons, slide template library, and more.

== Installation ==

1. Upload the `boldslider` folder to `/wp-content/plugins/`, or install via the Plugins screen.
2. Activate the plugin.
3. Go to **BoldSlider** in the admin menu.
4. Click **+ New Slider**, pick a template, name it, then click **Create & Edit**.
5. Drag layers, set styling, save.
6. Embed in any post or page using the shortcode shown in the slider list, or the BoldSlider Gutenberg block.

== Frequently Asked Questions ==

= Does the plugin require jQuery? =

No. BoldSlider is built with vanilla JavaScript and Swiper. jQuery is not enqueued or required.

= Does the plugin call any external services? =

No. The free version does not call any third-party CDNs or APIs. All assets (Swiper, fonts, etc.) are served from your own site.

= Why are some features locked with a "PRO" badge? =

Those features ship with the BoldSlider Pro add-on plugin. The free version is fully usable on its own.

= How do I embed a slider? =

Two options:

* Shortcode: `[boldslider id="your-slider-slug"]` — the slug is shown in the slider's edit screen and on each card in the slider list.
* Gutenberg: add the **BoldSlider** block and pick your slider from the dropdown.

= Can I import a slider from another site? =

Yes. On the slider list page, hover any card and click **Export** to download a JSON file. On the destination site, click **Import** and pick the JSON file.

== Screenshots ==

1. Visual layer editor with drag & resize handles.
2. Slider list page with templates picker.
3. Per-device responsive overrides.
4. Settings panel with effects, navigation and pagination controls.

== Changelog ==

= 0.1.0 =
* Initial release.

== Upgrade Notice ==

= 0.1.0 =
First public release.
