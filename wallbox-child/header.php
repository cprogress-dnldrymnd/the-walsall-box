<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>

	<!-- Google tag (gtag.js) -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=AW-1052367982"></script>
	<script>
		window.dataLayer = window.dataLayer || [];

		function gtag() {
			dataLayer.push(arguments);
		}
		gtag('js', new Date());
		gtag('config', 'AW-1052367982');
	</script>
</head>


<body <?php body_class(); ?> itemscope itemtype="https://schema.org/WebPage">
	<?php
	// Hook to include default WordPress hook after body tag open
	if (function_exists('wp_body_open')) {
		wp_body_open();
	}

	// Hook to include additional content after body tag open
	do_action('esmee_action_after_body_tag_open');
	?>
	<div id="qodef-page-wrapper" class="<?php echo esc_attr(esmee_get_page_wrapper_classes()); ?>">
		<?php
		// Hook to include page header template
		do_action('esmee_action_page_header_template');
		?>
		<div id="qodef-page-outer">
			<?php
			// Include title template
			get_template_part('title');
			get_template_part('template-parts/page-banner');

			// Hook to include additional content before page inner content
			do_action('esmee_action_before_page_inner');
			?>
			<div id="qodef-page-inner" class="<?php echo esc_attr(esmee_get_page_inner_classes()); ?>">