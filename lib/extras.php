<?php
/**
 * Clean up the_excerpt()
 */
function forward_excerpt_more($more) {
  return ' &hellip; <a href="' . get_permalink() . '">' . __('Continued', LANG_DOMAIN) . '</a>';
}
add_filter('excerpt_more', 'forward_excerpt_more');


/**
 * Fix Wordpress Administration Bar overlapping
 */
function admin_bar_fix() {
  if( is_admin_bar_showing() ) {
    $output  = '<style type="text/css">'."\n\t";
    $output .= '@media screen and (max-width: 600px) {#wpadminbar { position: fixed !important; } }'."\n";
    $output .= '</style>'."\n";
    echo $output;
  }
}
add_action('wp_head', 'admin_bar_fix', 5);


/**
 * Foundation Flex Video container
 * @link: http://foundation.zurb.com/docs/components/flex_video.html
 */
function forward_flex_video($html, $url, $attr, $post_id) {
  return '<div class="flex-video">' . $html . '</div>';
}
add_filter('embed_oembed_html', 'forward_flex_video', 99, 4);


/**
 * Foundation classes to next/prev buttons
 */
function forward_link_attributes() {
    return 'class="button tiny"';
}
add_filter('next_posts_link_attributes', 'forward_link_attributes');
add_filter('previous_posts_link_attributes', 'forward_link_attributes');


/**
 * Load Livereload script for Gulp to testing devices on same network as web server
 * Modify the IP Address to the computer's IP thats running the "gulp" command
 */
function livereload() {
  wp_register_script('livereload', 'http://localhost:35729/livereload.js?snipver=1', array(), null, true);
  wp_enqueue_script('livereload');
}

// Runs the livereload function if domain contains .dev — edit to fit your own needs
$host = $_SERVER['HTTP_HOST'];
if (strpos($host,'.dev') !== false) {
    add_action('wp_enqueue_scripts', 'livereload');
}


/**
 * Removes dashboard widgets.
 * Uncomment to hide unused widgets
 */
function forward_remove_dashboard_widgets() {
  global $wp_meta_boxes;
  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
  unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
  unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
  update_user_meta( get_current_user_id(), 'show_welcome_panel', false );
  remove_meta_box( 'dashboard_activity', 'dashboard', 'normal');
}
//add_action('wp_dashboard_setup', 'forward_remove_dashboard_widgets' );


/**
 * Removes meta boxes from post & pages.
 * Uncomment for cleaner admin pages
 */
function forward_remove_meta_boxes() {
  remove_meta_box('pageparentdiv' , 'page', 'normal'); // Removes attributes page
  remove_meta_box('tagsdiv-post_tag', 'post', 'normal'); // Removes tags for post
  remove_meta_box('categorydiv', 'post', 'normal'); // Removes category for posts
}
//add_action('admin_menu', 'forward_remove_meta_boxes');


/**
 * Removes comments menu
 * Uncomment If you don't care about comments
 */
function remove_menus(){
  remove_menu_page( 'edit-comments.php' );
}
//add_action( 'admin_menu', 'remove_menus' );
