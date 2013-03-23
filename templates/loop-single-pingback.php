<?php do_action( 'bbp_template_before_single_pingback' ); ?>

	<div class="bbp-topic-pingback">

		<?php do_action( 'bbp_theme_before_pingback_content' ); ?>

		<p><?php _e( 'Pingback:', 'bbpress-pingbacks' ); ?> <?php comment_author_link(); ?></p>

		<section class="comment-content comment">
			<?php comment_text(); ?>
		</section>

		<?php do_action( 'bbp_theme_after_pingback_content' ); ?>
	</div>

<?php do_action( 'bbp_template_after_single_pingback' ); ?>