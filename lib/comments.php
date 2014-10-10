<?php
/**
 * Adapted Bootstrap's media objects for Foundation
 * @link http://codepen.io/starise/pen/uxvqE
 */
class Forward_Walker_Comment extends Walker_Comment {
  function start_lvl(&$output, $depth = 0, $args = array()) {
    $GLOBALS['comment_depth'] = $depth + 1; ?>
    <ul <?php comment_class('media no-bullet comment-' . get_comment_ID()); ?>>
    <?php
  }

  function end_lvl(&$output, $depth = 0, $args = array()) {
    $GLOBALS['comment_depth'] = $depth + 1;
    echo '</ul>';
  }

  function start_el(&$output, $comment, $depth = 0, $args = array(), $id = 0) {
    $depth++;
    $GLOBALS['comment_depth'] = $depth;
    $GLOBALS['comment'] = $comment;

    if (!empty($args['callback'])) {
      call_user_func($args['callback'], $comment, $args, $depth);
      return;
    }

    extract($args, EXTR_SKIP); ?>

  <li id="comment-<?php comment_ID(); ?>" <?php comment_class('media comment-' . get_comment_ID()); ?>>
    <?php include(locate_template('templates/comment.php')); ?>
  <?php
  }

  function end_el(&$output, $comment, $depth = 0, $args = array()) {
    if (!empty($args['end-callback'])) {
      call_user_func($args['end-callback'], $comment, $args, $depth);
      return;
    }
    // Close ".media-body" <div> located in templates/comment.php, and then the comment's <li>
    echo "</div></li>\n";
  }
}

function forward_get_avatar($avatar, $type) {
  if (!is_object($type)) { return $avatar; }

  $avatar = str_replace("class='avatar", "class='avatar left media-object", $avatar);
  return $avatar;
}
add_filter('get_avatar', 'forward_get_avatar', 10, 2);
