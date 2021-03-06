<?php
/**
 * Scripts and stylesheets
 *
 * Enqueue stylesheets in the following order:
 * 1. /theme/assets/dist/css/main.css
 *
 * Enqueue scripts in the following order:
 * 1. jquery-2.1.1.min.js via Google CDN
 * 2. /theme/assets/dist/js/modernizr.min.js
 * 3. /theme/assets/dist/js/scripts.js
 *
 * Google Analytics is loaded after enqueued scripts if:
 * - An ID has been defined in config.php
 * - You're not logged in as an administrator
 */
function forward_asset_path($filename_dev, $filename) {
  if (WP_ENV === 'development') {
    return get_template_directory_uri() . '/assets/dist/' . $filename_dev;
  }

  $manifest_path = get_template_directory() . '/assets/dist/rev-manifest.json';

  if (file_exists($manifest_path)) {
    $manifest = json_decode(file_get_contents($manifest_path), true);
  } else {
    $manifest = [];
  }

  if (array_key_exists($filename, $manifest)) {
    return get_template_directory_uri() . '/assets/dist/' . $manifest[$filename];
  }
}

function forward_assets() {
  wp_enqueue_style('forward_css', forward_asset_path('css/main.css', 'css/main.min.css'), false, null);

  /**
   * jQuery is loaded using the same method from HTML5 Boilerplate:
   * Grab Google CDN's latest jQuery with a protocol relative URL; fallback to local if offline
   * It's kept in the header instead of footer to avoid conflicts with plugins.
   */
  if (!is_admin() && current_theme_supports('jquery-cdn')) {
    wp_deregister_script('jquery');

    if (WP_ENV === 'development') {
      wp_register_script('jquery', '//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.js', array(), null, true);
    } else {
      wp_register_script('jquery', '//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js', array(), null, true);
    }

    add_filter('script_loader_src', 'forward_jquery_local_fallback', 10, 2);
  }

  if (is_single() && comments_open() && get_option('thread_comments')) {
    wp_enqueue_script('comment-reply');
  }

  wp_enqueue_script('modernizr', forward_asset_path('../vendor/modernizr/modernizr.js', 'js/modernizr.min.js'), array(), null, true);
  wp_enqueue_script('jquery');
  wp_enqueue_script('forward_js', forward_asset_path('js/scripts.js', 'js/scripts.min.js'), array(), null, true);
}
add_action('wp_enqueue_scripts', 'forward_assets', 100);

// http://wordpress.stackexchange.com/a/12450
function forward_jquery_local_fallback($src, $handle = null) {
  static $add_jquery_fallback = false;

  if ($add_jquery_fallback) {
    echo '<script>window.jQuery || document.write(\'<script src="' . get_template_directory_uri() . '/assets/dist/js/jquery-2.1.1.min.js"><\/script>\')</script>' . "\n";
    $add_jquery_fallback = false;
  }

  if ($handle === 'jquery') {
    $add_jquery_fallback = true;
  }

  return $src;
}
add_action('wp_head', 'forward_jquery_local_fallback');

/**
 * Google Analytics snippet from HTML5 Boilerplate
 *
 * Cookie domain is 'auto' configured. See: http://goo.gl/VUCHKM
 */
function forward_google_analytics() { ?>
<script>
  <?php if (WP_ENV === 'production') : ?>
    (function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
    function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
    e=o.createElement(i);r=o.getElementsByTagName(i)[0];
    e.src='//www.google-analytics.com/analytics.js';
    r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
  <?php else : ?>
    function ga() {
      console.log('GoogleAnalytics: ' + [].slice.call(arguments));
    }
  <?php endif; ?>
  ga('create','<?php echo GOOGLE_ANALYTICS_ID; ?>','auto');ga('send','pageview');
</script>

<?php }
if (GOOGLE_ANALYTICS_ID && (WP_ENV !== 'production' || !current_user_can('manage_options'))) {
  add_action('wp_footer', 'forward_google_analytics', 20);
}
