<div class="qodef-e-media">
	<?php
	switch ( get_post_format() ) {
		case 'gallery':
			esmee_template_part( 'blog', 'templates/parts/post-format/gallery' );
			break;
		case 'video':
			esmee_template_part( 'blog', 'templates/parts/post-format/video' );
			break;
		case 'audio':
			esmee_template_part( 'blog', 'templates/parts/post-format/audio' );
			break;
		default:
			esmee_template_part( 'blog', 'templates/parts/post-info/image' );
			break;
	}
	?>
</div>
