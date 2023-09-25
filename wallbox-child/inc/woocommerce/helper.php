<?php

if ( ! function_exists( 'esmee_enqueue_woocommerce_css_assets' ) ) {
	/**
	 * Function that enqueue 3rd party plugins script
	 */
	function esmee_enqueue_woocommerce_css_assets() {

		if ( esmee_is_woo_page( 'single' ) && esmee_get_post_value_through_levels( 'qodef_woo_single_enable_image_lightbox' ) === 'magnific-popup' ) {
			wp_enqueue_style( 'magnific-popup' );
			wp_enqueue_script( 'jquery-magnific-popup' );
		}
	}

	add_action( 'esmee_action_before_main_css', 'esmee_enqueue_woocommerce_css_assets' );
}

if ( ! function_exists( 'esmee_is_woo_page' ) ) {
	/**
	 * Function that check WooCommerce pages
	 *
	 * @param string $page
	 *
	 * @return bool
	 */
	function esmee_is_woo_page( $page ) {
		switch ( $page ) {
			case 'shop':
				return function_exists( 'is_shop' ) && is_shop();
			case 'single':
				return is_singular( 'product' );
			case 'cart':
				return function_exists( 'is_cart' ) && is_cart();
			case 'checkout':
				return function_exists( 'is_checkout' ) && is_checkout();
			case 'account':
				return function_exists( 'is_account_page' ) && is_account_page();
			case 'category':
				return function_exists( 'is_product_category' ) && is_product_category();
			case 'tag':
				return function_exists( 'is_product_tag' ) && is_product_tag();
			case 'any':
				return (
					function_exists( 'is_shop' ) && is_shop() ||
					is_singular( 'product' ) ||
					function_exists( 'is_cart' ) && is_cart() ||
					function_exists( 'is_checkout' ) && is_checkout() ||
					function_exists( 'is_account_page' ) && is_account_page() ||
					function_exists( 'is_product_category' ) && is_product_category() ||
					function_exists( 'is_product_tag' ) && is_product_tag()
				);
			case 'archive':
				return ( function_exists( 'is_shop' ) && is_shop() ) || ( function_exists( 'is_product_category' ) && is_product_category() ) || ( function_exists( 'is_product_tag' ) && is_product_tag() );
			default:
				return false;
		}
	}
}

if ( ! function_exists( 'esmee_get_woo_main_page_classes' ) ) {
	/**
	 * Function that return current WooCommerce page class name
	 *
	 * @return string
	 */
	function esmee_get_woo_main_page_classes() {
		$classes = array();

		if ( esmee_is_woo_page( 'shop' ) ) {
			$classes[] = 'qodef--list';
		}

		if ( esmee_is_woo_page( 'single' ) ) {
			$classes[] = 'qodef--single';

			if ( esmee_get_post_value_through_levels( 'qodef_woo_single_enable_image_lightbox' ) === 'photo-swipe' ) {
				$classes[] = 'qodef-popup--photo-swipe';
			}

			if ( esmee_get_post_value_through_levels( 'qodef_woo_single_enable_image_lightbox' ) === 'magnific-popup' ) {
				$classes[] = 'qodef-popup--magnific-popup';
				// add classes to initialize lightbox from theme
				$classes[] = 'qodef-magnific-popup';
				$classes[] = 'qodef-popup-gallery';
			}

			$woo_product_info_position = get_post_meta( get_the_ID(), 'qodef_single_product_additional_info_position_meta', true );

			if ( empty( $woo_product_info_position ) ) {
				$woo_product_info_position_main = esmee_get_post_value_through_levels( 'single_product_additional_info_position' );

				if ( ! empty( $woo_product_info_position_main ) ) {
					$classes[] = 'qodef-woo-single-info-' . $woo_product_info_position_main;
				}
			} else {
				$classes[] = 'qodef-woo-single-info-' . $woo_product_info_position;
			}
		}
		if ( esmee_is_woo_page( 'cart' ) ) {
			$classes[] = 'qodef--cart';
		}

		if ( esmee_is_woo_page( 'checkout' ) ) {
			$classes[] = 'qodef--checkout';
		}

		if ( esmee_is_woo_page( 'account' ) ) {
			$classes[] = 'qodef--account';
		}

		return apply_filters( 'esmee_filter_main_page_classes', implode( ' ', $classes ) );
	}
}

if ( ! function_exists( 'esmee_select_woo_single_product_body_class' ) ) {
	function esmee_select_woo_single_product_body_class( $classes ) {
		if ( esmee_is_woo_page( 'single' ) ) {

			$woo_product_layout = get_post_meta( get_the_ID(), 'qodef_product_layout_woo_meta', true );

			if ( empty( $woo_product_layout ) ) {
				$woo_product_layout_main = esmee_get_post_value_through_levels( 'product_layout_woo' );

				if ( ! empty( $woo_product_layout_main ) ) {
					$classes[] = 'qodef-woo-single-layout-' . $woo_product_layout_main;
				}
			} else {
				$classes[] = 'qodef-woo-single-layout-' . $woo_product_layout;
			}
		}

		return $classes;
	}

	add_filter( 'esmee_filter_add_body_classes', 'esmee_select_woo_single_product_body_class' );
}

if ( ! function_exists( 'esmee_select_empty_cart_body_class' ) ) {
	function esmee_select_empty_cart_body_class( $classes ) {

		global $woocommerce;
		if ( is_cart() && WC()->cart->cart_contents_count == 0 ) {
			$classes[] = 'qodef-page-empty-cart';
		}

		return $classes;
	}

	add_filter( 'esmee_filter_add_body_classes', 'esmee_select_empty_cart_body_class' );
}


if ( ! function_exists( 'esmee_select_single_product_show_product_thumbnails' ) ) {
	function esmee_select_single_product_show_product_thumbnails() {
		global $product;

		$attachment_ids = $product->get_gallery_image_ids();

		if ( $attachment_ids && has_post_thumbnail() ) {
			foreach ( $attachment_ids as $attachment_id ) {
				$full_size_image = wp_get_attachment_image_src( $attachment_id, 'full' );
				$thumbnail       = wp_get_attachment_image_src( $attachment_id, 'woocommerce_thumbnail' );
				$attributes      = array(
					'title'                   => get_post_field( 'post_title', $attachment_id ),
					'data-caption'            => get_post_field( 'post_excerpt', $attachment_id ),
					'data-src'                => $full_size_image[0],
					'data-large_image'        => $full_size_image[0],
					'data-large_image_width'  => $full_size_image[1],
					'data-large_image_height' => $full_size_image[2],
				);

				$html = '<div data-thumb="' . esc_url( $thumbnail[0] ) . '" class="woocommerce-product-gallery__image"><a href="' . esc_url( $full_size_image[0] ) . '">';
				$html .= wp_get_attachment_image( $attachment_id, 'woocommerce_single', false, $attributes );
				$html .= '</a></div>';

				echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, $attachment_id );
			}
		}
	}
}

if ( ! function_exists( 'esmee_select_woo_output_product_data_tabs_full_width' ) ) {
	function esmee_select_woo_output_product_data_tabs_full_width() {

		$product_additional_info_position = get_post_meta( get_the_ID(), 'qodef_single_product_additional_info_position_meta', true );
		if ( 'below-featured-image' === $product_additional_info_position ) {
			return woocommerce_output_product_data_tabs();
		}
	}
}

if ( ! function_exists( 'esmee_select_woo_output_product_data_tabs_inside_summary' ) ) {
	function esmee_select_woo_output_product_data_tabs_inside_summary() {

		$product_additional_info_position = get_post_meta( get_the_ID(), 'qodef_single_product_additional_info_position_meta', true );

		if ( 'inside-summary' === $product_additional_info_position ) {

			return woocommerce_output_product_data_tabs();
		}
	}
}


if ( ! function_exists( 'esmee_select_single_product_summary_additional_tag_before' ) ) {
	function esmee_select_single_product_summary_additional_tag_before() {

		print '<div class="qodef-single-product-summary">';
	}
}

if ( ! function_exists( 'esmee_select_single_product_summary_additional_tag_after' ) ) {
	function esmee_select_single_product_summary_additional_tag_after() {

		print '</div>';
	}
}
if ( ! function_exists( 'esmee_woo_get_global_product' ) ) {
	/**
	 * Function that return global WooCommerce object
	 *
	 * @return object
	 */
	function esmee_woo_get_global_product() {
		global $product;

		return $product;
	}
}

if ( ! function_exists( 'esmee_woo_get_main_shop_page_id' ) ) {
	/**
	 * Function that return main shop page ID
	 *
	 * @return int
	 */
	function esmee_woo_get_main_shop_page_id() {
		// Get page id from options table
		$shop_id = get_option( 'woocommerce_shop_page_id' );

		if ( ! empty( $shop_id ) ) {
			return $shop_id;
		}

		return false;
	}
}

if ( ! function_exists( 'esmee_woo_set_main_shop_page_id' ) ) {
	/**
	 * Function that set main shop page ID for get_post_meta options
	 *
	 * @param int $post_id
	 *
	 * @return int
	 */
	function esmee_woo_set_main_shop_page_id( $post_id ) {

		if ( esmee_is_woo_page( 'archive' ) || esmee_is_woo_page( 'single' ) ) {
			$shop_id = esmee_woo_get_main_shop_page_id();

			if ( ! empty( $shop_id ) ) {
				$post_id = $shop_id;
			}
		}

		return $post_id;
	}

	add_filter( 'esmee_filter_page_id', 'esmee_woo_set_main_shop_page_id' );
	add_filter( 'qode_framework_filter_page_id', 'esmee_woo_set_main_shop_page_id' );
}

if ( ! function_exists( 'esmee_woo_set_page_title_text' ) ) {
	/**
	 * Function that returns current page title text for WooCommerce pages
	 *
	 * @param string $title
	 *
	 * @return string
	 */
	function esmee_woo_set_page_title_text( $title ) {

		if ( esmee_is_woo_page( 'shop' ) || esmee_is_woo_page( 'single' ) ) {
			$shop_id = esmee_woo_get_main_shop_page_id();

			$title = ! empty( $shop_id ) ? get_the_title( $shop_id ) : esc_html__( 'Shop', 'esmee' );
		} elseif ( esmee_is_woo_page( 'category' ) || esmee_is_woo_page( 'tag' ) ) {
			$taxonomy_slug = esmee_is_woo_page( 'tag' ) ? 'product_tag' : 'product_cat';
			$taxonomy      = get_term( get_queried_object_id(), $taxonomy_slug );

			if ( ! empty( $taxonomy ) ) {
				$title = esc_html( $taxonomy->name );
			}
		}

		return $title;
	}

	add_filter( 'esmee_filter_page_title_text', 'esmee_woo_set_page_title_text' );
}

if ( ! function_exists( 'esmee_woo_breadcrumbs_title' ) ) {
	/**
	 * Improve main breadcrumbs template with additional cases
	 *
	 * @param string $wrap_child
	 * @param array $settings
	 *
	 * @return string
	 */
	function esmee_woo_breadcrumbs_title( $wrap_child, $settings ) {

		if ( esmee_is_woo_page( 'category' ) || esmee_is_woo_page( 'tag' ) ) {
			$wrap_child    = '';
			$taxonomy_slug = esmee_is_woo_page( 'tag' ) ? 'product_tag' : 'product_cat';
			$taxonomy      = get_term( get_queried_object_id(), $taxonomy_slug );

			if ( isset( $taxonomy->parent ) && 0 !== $taxonomy->parent ) {
				$parent     = get_term( $taxonomy->parent );
				$wrap_child .= sprintf( $settings['link'], get_term_link( $parent->term_id ), $parent->name ) . $settings['separator'];
			}

			if ( ! empty( $taxonomy ) ) {
				$wrap_child .= sprintf( $settings['current_item'], esc_attr( $taxonomy->name ) );
			}
		} elseif ( esmee_is_woo_page( 'shop' ) ) {
			$shop_id    = esmee_woo_get_main_shop_page_id();
			$shop_title = ! empty( $shop_id ) ? get_the_title( $shop_id ) : esc_html__( 'Shop', 'esmee' );

			$wrap_child .= sprintf( $settings['current_item'], $shop_title );

		} elseif ( esmee_is_woo_page( 'single' ) ) {
			$wrap_child = '';
			$post_terms = wp_get_post_terms( get_the_ID(), 'product_cat' );

			if ( ! empty( $post_terms ) ) {
				$post_term = $post_terms[0];

				if ( isset( $post_term->parent ) && 0 !== $post_term->parent ) {
					$parent     = get_term( $post_term->parent );
					$wrap_child .= sprintf( $settings['link'], get_term_link( $parent->term_id ), $parent->name ) . $settings['separator'];
				}
				$wrap_child .= sprintf( $settings['link'], get_term_link( $post_term ), $post_term->name ) . $settings['separator'];
			}

			$wrap_child .= sprintf( $settings['current_item'], get_the_title() );
		}

		return $wrap_child;
	}

	add_filter( 'esmee_core_filter_breadcrumbs_content', 'esmee_woo_breadcrumbs_title', 10, 2 );
}

if ( ! function_exists( 'esmee_woo_single_add_theme_supports' ) ) {
	/**
	 * Function that add native WooCommerce supports
	 */
	function esmee_woo_single_add_theme_supports() {
		// Add featured image zoom functionality on product single page
		$is_zoom_enabled = esmee_get_post_value_through_levels( 'qodef_woo_single_enable_image_zoom' ) !== 'no';

		if ( $is_zoom_enabled ) {
			add_theme_support( 'wc-product-gallery-zoom' );
		}

		// Add photo swipe lightbox functionality on product single images page
		$is_photo_swipe_enabled = esmee_get_post_value_through_levels( 'qodef_woo_single_enable_image_lightbox' ) === 'photo-swipe';

		if ( $is_photo_swipe_enabled ) {
			add_theme_support( 'wc-product-gallery-lightbox' );
		}
	}

	add_action( 'wp_loaded', 'esmee_woo_single_add_theme_supports', 11 ); // permission 11 is set because options are init with permission 10 inside framework plugin
}

if ( ! function_exists( 'esmee_woo_single_disable_page_title' ) ) {
	/**
	 * Function that disable page title area for single product page
	 *
	 * @param bool $enable_page_title
	 *
	 * @return bool
	 */
	function esmee_woo_single_disable_page_title( $enable_page_title ) {
		$is_enabled = esmee_get_post_value_through_levels( 'qodef_woo_single_enable_page_title' ) !== 'no';

		if ( ! $is_enabled && esmee_is_woo_page( 'single' ) ) {
			$enable_page_title = false;
		}

		return $enable_page_title;
	}

	add_filter( 'esmee_filter_enable_page_title', 'esmee_woo_single_disable_page_title' );
}

if ( ! function_exists( 'esmee_woo_single_thumb_images_position' ) ) {
	/**
	 * Function that changes the layout of thumbnails on single product page
	 *
	 * @param array $classes
	 *
	 * @return array
	 */
	function esmee_woo_single_thumb_images_position( $classes ) {
		$product_thumbnail_position = esmee_is_installed( 'core' ) ? esmee_get_post_value_through_levels( 'qodef_woo_single_thumb_images_position' ) : 'left';

		if ( ! empty( $product_thumbnail_position ) ) {
			$classes[] = 'qodef-position--' . $product_thumbnail_position;
		}

		return $classes;
	}

	add_filter( 'woocommerce_single_product_image_gallery_classes', 'esmee_woo_single_thumb_images_position' );
}

if ( ! function_exists( 'esmee_set_woo_custom_sidebar_name' ) ) {
	/**
	 * Function that return sidebar name
	 *
	 * @param string $sidebar_name
	 *
	 * @return string
	 */
	function esmee_set_woo_custom_sidebar_name( $sidebar_name ) {

		if ( esmee_is_woo_page( 'archive' ) ) {
			$option = esmee_get_post_value_through_levels( 'qodef_woo_product_list_custom_sidebar' );

			if ( isset( $option ) && ! empty( $option ) ) {
				$sidebar_name = $option;
			}
		}

		return $sidebar_name;
	}

	add_filter( 'esmee_filter_sidebar_name', 'esmee_set_woo_custom_sidebar_name' );
}


if ( ! function_exists( 'esmee_set_woo_sidebar_layout' ) ) {
	/**
	 * Function that return sidebar layout
	 *
	 * @param string $layout
	 *
	 * @return string
	 */
	function esmee_set_woo_sidebar_layout( $layout ) {

		if ( esmee_is_woo_page( 'archive' ) ) {
			$option = esmee_get_post_value_through_levels( 'qodef_woo_product_list_sidebar_layout' );

			if ( isset( $option ) && ! empty( $option ) ) {
				$layout = $option;
			}
		}

		return $layout;
	}

	add_filter( 'esmee_filter_sidebar_layout', 'esmee_set_woo_sidebar_layout' );
}

if ( ! function_exists( 'esmee_set_woo_sidebar_grid_gutter_classes' ) ) {
	/**
	 * Function that returns grid gutter classes
	 *
	 * @param string $classes
	 *
	 * @return string
	 */
	function esmee_set_woo_sidebar_grid_gutter_classes( $classes ) {

		if ( esmee_is_woo_page( 'archive' ) ) {
			$option = esmee_get_post_value_through_levels( 'qodef_woo_product_list_sidebar_grid_gutter' );

			if ( isset( $option ) && ! empty( $option ) ) {
				$classes = 'qodef-gutter--' . esc_attr( $option );
			}
		}

		return $classes;
	}

	add_filter( 'esmee_filter_grid_gutter_classes', 'esmee_set_woo_sidebar_grid_gutter_classes' );
}

if ( ! function_exists( 'esmee_set_woo_review_form_fields' ) ) {
	/**
	 * Function that add woo rating to WordPress comment form fields
	 *
	 * @param array $args
	 *
	 * @return array
	 */
	function esmee_set_woo_review_form_fields( $args ) {
		$comment_args = esmee_get_comment_form_args( array( 'comment_placeholder' => esc_attr__( 'Your Review *', 'esmee' ) ) );

		if ( key_exists( 'comment_field', $comment_args ) ) {

			if ( wc_review_ratings_enabled() ) {
				$ratings_html = '<p class="stars qodef-comment-form-ratings">';
				for ( $i = 1; $i <= 5; $i ++ ) {
					$ratings_html .= '<a class="star-' . intval( $i ) . '" href="#">' . intval( $i ) . esmee_get_svg_icon( 'star' ) . '</a>';
				}
				$ratings_html .= '</p>';

				// add rating stuff before textarea element
				// copied from wp-content/plugins/woocommerce/templates/single-product-reviews.php
				$comment_args['comment_field'] = '<div class="comment-form-rating">
					<label for="rating">' . esc_html__( 'Your Rating ', 'esmee' ) . ( wc_review_ratings_required() ? '<span class="required">*</span>' : '' ) . '</label>
					' . $ratings_html . '
					<select name="rating" id="rating" required>
						<option value="">' . esc_html__( 'Rate&hellip;', 'esmee' ) . '</option>
						<option value="5">' . esc_html__( 'Perfect', 'esmee' ) . '</option>
						<option value="4">' . esc_html__( 'Good', 'esmee' ) . '</option>
						<option value="3">' . esc_html__( 'Average', 'esmee' ) . '</option>
						<option value="2">' . esc_html__( 'Not that bad', 'esmee' ) . '</option>
						<option value="1">' . esc_html__( 'Very poor', 'esmee' ) . '</option>
					</select>
				</div>' . $comment_args['comment_field'];
			}
		}

		// Removed url field from form
		if ( isset( $comment_args['fields']['url'] ) ) {
			unset( $comment_args['fields']['url'] );
		}

		// Override WooCommerce review arguments with ours
		$args = array_merge( $args, $comment_args );

		return $args;
	}

	add_filter( 'woocommerce_product_review_comment_form_args', 'esmee_set_woo_review_form_fields' );
}
