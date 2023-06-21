<article <?php post_class( 'qodef-blog-item qodef-e' ); ?>>
	<div class="qodef-e-inner">
		<?php
		// Include post date info
		esmee_template_part( 'blog', 'templates/parts/post-info/custom-date' );

		// Include post media
		esmee_template_part( 'blog', 'templates/parts/post-info/media' );
		?>
		<div class="qodef-e-content">
			<div class="qodef-e-top-holder">
				<div class="qodef-e-info">
					<?php
					// Include post category info
					esmee_template_part( 'blog', 'templates/parts/post-info/categories' );
					?>
				</div>
			</div>
			<div class="qodef-e-text">
				<?php
				// Include post title
				esmee_template_part( 'blog', 'templates/parts/post-info/title', '', array( 'title_tag' => 'h1' ) );

				// Include post content
				the_content();

				// Hook to include additional content after blog single content
				do_action( 'esmee_action_after_blog_single_content' );
				?>
			</div>
			<div class="qodef-e-bottom-holder">
				<div class="qodef-e-left qodef-e-info">
					<?php
					// Include post author info
					esmee_template_part( 'blog', 'templates/parts/post-info/tags' );

					?>
				</div>
				<div class="qodef-e-right qodef-e-info">
					<?php
					// Include post tags info
					esmee_template_part( 'blog', 'templates/parts/post-info/share' );
					?>
				</div>
			</div>
		</div>
	</div>
</article>
