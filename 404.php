<?php get_template_part('templates/page', 'header'); ?>

<div data-alert class="alert-box warning">
  <?php _e('Sorry, but the page you were trying to view does not exist.', 'forward'); ?>
</div>

<p><?php _e('It looks like this was the result of either:', 'forward'); ?></p>
<ul>
  <li><?php _e('a mistyped address', 'forward'); ?></li>
  <li><?php _e('an out-of-date link', 'forward'); ?></li>
</ul>

<?php get_search_form(); ?>
