<footer id="qodef-page-footer" <?php esmee_class_attribute( implode( ' ', apply_filters( 'esmee_filter_footer_holder_classes', array() ) ) ); ?> role="contentinfo">
	<?php
	// Hook to include additional content before page footer content
	do_action( 'esmee_action_before_page_footer_content' );

	// Include module content template
	echo apply_filters( 'esmee_filter_footer_content_template', esmee_get_template_part( 'footer', 'templates/footer-content' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

	// Hook to include additional content after page footer content
	do_action( 'esmee_action_after_page_footer_content' );
	?>
</footer>
