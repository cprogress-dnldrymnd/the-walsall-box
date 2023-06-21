<?php

if ( ! function_exists( 'esmee_register_justified_gallery_scripts' ) ) {
	/**
	 * Function that register module 3rd party scripts
	 */
	function esmee_register_justified_gallery_scripts() {
		wp_register_script( 'jquery-justified-gallery', ESMEE_INC_ROOT . '/justified-gallery/assets/js/plugins/jquery.justifiedGallery.min.js', array( 'jquery' ), true );
	}

	add_action( 'esmee_action_before_main_js', 'esmee_register_justified_gallery_scripts' );
}

if ( ! function_exists( 'esmee_include_justified_gallery_scripts' ) ) {
	/**
	 * Function that enqueue modules 3rd party scripts
	 *
	 * @param array $atts
	 */
	function esmee_include_justified_gallery_scripts( $atts ) {

		if ( isset( $atts['behavior'] ) && 'justified-gallery' === $atts['behavior'] ) {
			wp_enqueue_script( 'jquery-justified-gallery' );
		}
	}

	add_action( 'esmee_core_action_list_shortcodes_load_assets', 'esmee_include_justified_gallery_scripts' );
}

if ( ! function_exists( 'esmee_register_justified_gallery_scripts_for_list_shortcodes' ) ) {
	/**
	 * Function that set module 3rd party scripts for list shortcodes
	 *
	 * @param array $scripts
	 *
	 * @return array
	 */
	function esmee_register_justified_gallery_scripts_for_list_shortcodes( $scripts ) {

		$scripts['jquery-justified-gallery'] = array(
			'registered' => true,
		);

		return $scripts;
	}

	add_filter( 'esmee_core_filter_register_list_shortcode_scripts', 'esmee_register_justified_gallery_scripts_for_list_shortcodes' );
}
