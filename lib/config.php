<?php
/**
 * Enable theme features
 */
add_theme_support('soil-clean-up');         // Enable clean up from Soil
add_theme_support('soil-relative-urls');    // Enable relative URLs from Soil
add_theme_support('soil-nice-search');      // Enable /?s= to /search/ redirect from Soil
add_theme_support('foundation-gallery');    // Enable Foundation thumbnails component on [gallery]
add_theme_support('jquery-cdn');            // Enable to load jQuery from the Google CDN

/**
 * Configuration values
 */
define('LANG_DOMAIN', 'forward'); // Text Domain name for translations
define('GOOGLE_ANALYTICS_ID', ''); // UA-XXXXX-Y (Note: Universal Analytics only, not Classic Analytics)

if (!defined('WP_ENV')) {
  define('WP_ENV', 'production');  // scripts.php checks for values 'production' or 'development'
}

/**
 * Add body class if sidebar is active
 */
function forward_sidebar_body_class($classes) {
  if (forward_display_sidebar()) {
    $classes[] = 'main-sidebar';
  }
  return $classes;
}
add_filter('body_class', 'forward_sidebar_body_class');

/**
 * Define which pages shouldn't have the sidebar
 *
 * See lib/sidebar.php for more details
 */
function forward_display_sidebar() {
  $sidebar_config = new Forward_Sidebar(
    /**
     * Conditional tag checks (http://codex.wordpress.org/Conditional_Tags)
     * Any of these conditional tags that return true won't show the sidebar
     *
     * To use a function that accepts arguments, use the following format:
     *
     * array('function_name', array('arg1', 'arg2'))
     *
     * The second element must be an array even if there's only 1 argument.
     */
    array(
      'is_404',
      'is_front_page'
    ),
    /**
     * Page template checks (via is_page_template())
     * Any of these page templates that return true won't show the sidebar
     */
    array(
      'template-custom.php'
    )
  );

  return apply_filters('forward/display_sidebar', $sidebar_config->display);
}

/**
 * $content_width is a global variable used by WordPress for max image upload sizes
 * and media embeds (in pixels).
 * Foundation automatically resizes the images to fit the container.
 *
 * Note: This option affects on 'large' size, not the 'full' size uploaded image.
 * Default: 970px is the default Foundation container width.
 */
if (!isset($content_width)) { $content_width = 970; }
