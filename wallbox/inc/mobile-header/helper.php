<?php

if ( ! function_exists( 'esmee_load_page_mobile_header' ) ) {
	/**
	 * Function which loads page template module
	 */
	function esmee_load_page_mobile_header() {
		// Include mobile header template
		echo apply_filters( 'esmee_filter_mobile_header_template', esmee_get_template_part( 'mobile-header', 'templates/mobile-header' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	add_action( 'esmee_action_page_header_template', 'esmee_load_page_mobile_header' );
}

if ( ! function_exists( 'esmee_register_mobile_navigation_menus' ) ) {
	/**
	 * Function which registers navigation menus
	 */
	function esmee_register_mobile_navigation_menus() {
		$navigation_menus = apply_filters( 'esmee_filter_register_mobile_navigation_menus', array( 'mobile-navigation' => esc_html__( 'Mobile Navigation', 'esmee' ) ) );

		if ( ! empty( $navigation_menus ) ) {
			register_nav_menus( $navigation_menus );
		}
	}

	add_action( 'esmee_action_after_include_modules', 'esmee_register_mobile_navigation_menus' );
}
