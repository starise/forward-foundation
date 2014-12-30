<?php
  if (post_password_required()) {
    return;
  }
?>

<section id="comments">
  <?php if (have_comments()) : ?>
    <h3><?php printf(_n('One Response to &ldquo;%2$s&rdquo;', '%1$s Responses to &ldquo;%2$s&rdquo;', get_comments_number(), LANG_DOMAIN), number_format_i18n(get_comments_number()), get_the_title()); ?></h3>

    <ul class="media-list">
      <?php wp_list_comments(array('walker' => new Forward_Walker_Comment)); ?>
    </ul>

    <?php if (get_comment_pages_count() > 1 && get_option('page_comments')) : ?>
      <nav>
        <ul class="pager">
          <?php if (get_previous_comments_link()) : ?>
            <li class="previous"><?php previous_comments_link(__('&larr; Older comments', LANG_DOMAIN)); ?></li>
          <?php endif; ?>
          <?php if (get_next_comments_link()) : ?>
            <li class="next"><?php next_comments_link(__('Newer comments &rarr;', LANG_DOMAIN)); ?></li>
          <?php endif; ?>
        </ul>
      </nav>
    <?php endif; ?>

    <?php if (!comments_open() && !is_page() && post_type_supports(get_post_type(), 'comments')) : ?>
      <div class="alert-box warning">
        <?php _e('Comments are closed.', LANG_DOMAIN); ?>
      </div>
    <?php endif; ?>
  <?php elseif(!comments_open() && !is_page() && post_type_supports(get_post_type(), 'comments')) : ?>
    <div class="alert-box warning">
      <?php _e('Comments are closed.', LANG_DOMAIN); ?>
    </div>
  <?php endif; ?>
</section><!-- /#comments -->

<section id="respond">
  <?php if (comments_open()) : ?>
    <h3><?php comment_form_title(__('Leave a Reply', LANG_DOMAIN), __('Leave a Reply to %s', LANG_DOMAIN)); ?></h3>
    <p class="cancel-comment-reply"><?php cancel_comment_reply_link(); ?></p>
    <?php if (get_option('comment_registration') && !is_user_logged_in()) : ?>
      <p><?php printf(__('You must be <a href="%s">logged in</a> to post a comment.', LANG_DOMAIN), wp_login_url(get_permalink())); ?></p>
    <?php else : ?>
      <form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform" data-abide>
        <?php if (is_user_logged_in()) : ?>
          <h5 class="subheader">
            <?php printf(__('Logged in as <a href="%s/wp-admin/profile.php">%s</a>.', LANG_DOMAIN), get_option('siteurl'), $user_identity); ?>
            <a href="<?php echo wp_logout_url(get_permalink()); ?>" title="<?php _e('Log out of this account', LANG_DOMAIN); ?>"><?php _e('Log out &raquo;', LANG_DOMAIN); ?></a>
          </h5>
        <?php else : ?>
          <div class="form-group row">
            <div class="name">
              <label for="author"><?php _e('Name', LANG_DOMAIN); if ($req) _e(' <small>required</small>', LANG_DOMAIN); ?></label>
              <input placeholder="<?php _e('Your Name', LANG_DOMAIN);?>" type="text" name="author" id="author" value="<?php echo esc_attr($comment_author); ?>" size="22" <?php if ($req) echo 'aria-required="true" required pattern="[a-åA-Å][a-åA-Å ]+"'; ?>>
              <?php if ($req) echo '<small class="error">Name is required, and can only contain characters.</small>'; ?>
            </div>
            <div class="email">
              <label for="email"><?php _e('Email', LANG_DOMAIN); if ($req) _e(' <small>required</small>', LANG_DOMAIN); ?></label>
              <input placeholder="<?php _e('name@email.com', LANG_DOMAIN);?>" type="email" name="email" id="email" value="<?php echo esc_attr($comment_author_email); ?>" size="22" <?php if ($req) echo 'aria-required="true" required'; ?>>
              <?php if ($req) echo '<small class="error">An email address is required.</small>'; ?>
            </div>
          </div>
          <div class="row collapse">
            <label for="url"><?php _e('Website', LANG_DOMAIN); ?></label>
            <input placeholder="<?php _e('http://example.com', LANG_DOMAIN);?>"  type="url" name="url" id="url" value="<?php echo esc_attr($comment_author_url); ?>" size="22">
            <small class="error"><?php _e('Not a valid URL. (http://example.com)', LANG_DOMAIN);?></small>
          </div>
        <?php endif; ?>
        <div class="row collapse">
          <label for="comment"><?php _e('Comment', LANG_DOMAIN); ?></label>
          <textarea placeholder="<?php _e('Insert a comment...', LANG_DOMAIN); ?>" name="comment" id="comment" class="form-control" rows="5" aria-required="true"></textarea>
        </div>
        <p><input name="submit" class="button small" type="submit" id="submit" value="<?php _e('Submit Comment', LANG_DOMAIN); ?>"></p>
        <?php comment_id_fields(); ?>
        <?php do_action('comment_form', $post->ID); ?>
      </form>
    <?php endif; ?>
  <?php endif; ?>
</section><!-- /#respond -->
