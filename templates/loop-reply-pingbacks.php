<?php if ( bbp_have_pingbacks() ): ?>

<?php do_action( 'bbp_template_before_topic_pingbacks_loop' ); ?>

<h2><?php _e( 'Reply pingbacks:', 'bbpress-pingbacks' ); ?></h2>

<ul id="reply-<?php bbp_reply_id(); ?>-pingbacks" class="bbp-reply-pingbacks">
		<?php while ( bbp_have_pingbacks() ) : bbp_the_pingback(); ?>

		<?php 	bbp_get_template_part( 'loop', 'single-reply-pingback' ); ?>

		<?php endwhile; ?>
</ul>

<?php do_action( 'bbp_template_after_topic_pingbacks_loop' ); ?>

<?php endif; ?>