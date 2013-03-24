<?php do_action( 'bbp_template_before_topic_pingbacks_loop' ); ?>
<h2><?php _e( 'Topic pingbacks:', 'bbpress-pingbacks' ); ?></h2>
<ul id="topic-<?php bbp_topic_id(); ?>-pingbacks" class="forums bbp-replies">
	<li class="bbp-body">

		<?php while ( bbp_have_pingbacks() ) : bbp_the_pingback(); ?>

		<?php bbp_get_template_part( 'loop', 'single-pingback' ); ?>

		<?php endwhile; ?>
	</li>
</ul>

<?php do_action( 'bbp_template_after_topic_pingbacks_loop' ); ?>
