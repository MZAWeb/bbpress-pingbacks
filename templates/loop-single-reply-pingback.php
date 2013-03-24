<?php do_action( 'bbp_template_before_single_pingback' ); ?>

<li id='pingback-<?php bbp_pingback_id(); ?>' class="bbp-topic-pingback">

	<?php do_action( 'bbp_theme_before_pingback_content' ); ?>

	<p><?php comment_author_link(); ?></p>

	<?php do_action( 'bbp_theme_after_pingback_content' ); ?>
</li>

<?php do_action( 'bbp_template_after_single_pingback' ); ?>