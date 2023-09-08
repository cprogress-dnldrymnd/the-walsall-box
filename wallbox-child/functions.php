<?php

if (!function_exists('esmee_child_theme_enqueue_scripts')) {
	/**
	 * Function that enqueue theme's child style
	 */
	function esmee_child_theme_enqueue_scripts()
	{
		$main_style = 'esmee-main';

		wp_enqueue_style('esmee-child-style', get_stylesheet_directory_uri() . '/style.css', array($main_style));
	}

	add_action('wp_enqueue_scripts', 'esmee_child_theme_enqueue_scripts');
}


add_filter('gettext', 'change_valiance_text');
add_filter('ngettext', 'change_valiance_text');

function change_valiance_text($translated)
{
	$translated = str_replace('Esmee', 'Walsall Box', $translated);
	$translated = str_replace('esmee', 'Walsall Box', $translated);
	return $translated;
}

/**
 * @snippet       Hide SKU, Cats, Tags @ Single Product Page - WooCommerce
 * @how-to        Get CustomizeWoo.com FREE
 * @author        Rodolfo Melogli
 * @compatible    WC 3.8
 * @donate $9     https://businessbloomer.com/bloomer-armada/
 */

remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);



remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart');



function action_woocommerce_after_add_to_cart_form()
{
	?>
	<div class="button-group">
		<a class="qodef-shortcode qodef-m  qodef-button qodef-layout--filled  qodef-html--link" href="#tab-enquire_tab"
			target="_self">
			<span class="qodef-m-text">GET A QUOTE</span>
		</a>

		<a class="button-link" target="_self" href="#product-tabs">
			<span class="qodef-m-text">MORE INFORMATION</span>
		</a>
	</div>
	<?php
}

add_action('woocommerce_share', 'action_woocommerce_after_add_to_cart_form');


/**
 * Rename product data tabs
 */
add_filter('woocommerce_product_tabs', 'woo_rename_tabs', 98);
function woo_rename_tabs($tabs)
{

	$tabs['additional_information']['title'] = __('TECHNICAL SPECIFICATION'); // Rename the additional information tab

	return $tabs;
}

/**
 * Add a custom product data tab
 */
add_filter('woocommerce_product_tabs', 'woo_enquire_tab');
function woo_enquire_tab($tabs)
{

	// Adds the new tab

	$tabs['enquire_tab'] = array(
		'title'    => __('ENQUIRE ABOUT THIS PRODUCT', 'woocommerce'),
		'priority' => 50,
		'callback' => 'woo_enquire_tab_content'
	);

	return $tabs;
}
function woo_enquire_tab_content()
{

	// The new tab content

	echo do_shortcode('[contact-form-7 id="5878" title="Contact form 1"]');
}

function action_custom_pricing_table()
{
	$pricing_rules = get_post_meta(get_the_ID(), '_pricing_rules', true);
	if ($pricing_rules) {
		global $product;
		$variations = $product->get_children();

		$min_quantity = array();
		foreach ($pricing_rules as $pricing_rule) {
			foreach ($pricing_rule['rules'] as $rule) {
				$min_quantity[] = $rule['from'];
			}
		}
		$min_quantity = array_unique($min_quantity);
		asort($min_quantity);
		?>
		<style>
			.variations,
			.single_variation_wrap {
				display: none !important;
			}
		</style>
		<table class="table-product-pricing">
			<tr class="table-row-header">
				<th>PRODUCT REFERENCE</th>
				<th>DIMENSIONS</th>
				<th>
					MINUMUM NUMBER OF PACKS
					<table class="table-quantity-price table-quantity">
						<tr>
							<?php foreach ($min_quantity as $qty) { ?>
								<td class="min-quantity" data-qty="<?= $qty ?>">
									<?= $qty ?>
								</td>
							<?php } ?>
						</tr>
					</table>
				</th>
				<th>NUMBER OF PACKS</th>

				<th>PRICE</th>

			</tr>
			<?php foreach ($variations as $variation) { ?>
				<?php
				$product_variation = wc_get_product($variation);
				$price_arr = array();
				foreach ($pricing_rules as $pricing_rule) {
					if ($pricing_rule['variation_rules']['args']['variations'][0] == $product_variation->get_id()) {
						foreach ($pricing_rule['rules'] as $rule) {
							$price_arr[$rule['from']] = $rule['amount'];
						}
					}
				}
				?>
				<tr class="table-row-variation" id="variation-<?= $product_variation->get_id() ?>">
					<td class="product-ref">
						<div class="hide-desktop"><strong>PRODUCT REFERENCE</strong></div>
						<div><?= get_the_title($product_variation->get_id()) ?></div>
					</td>
					<td lass="product-dimension">
						<div class="hide-desktop"><strong>DIMENSIONS</strong></div>
						<div><?= $product_variation->get_dimensions(); ?></div>
					</td>
					<td class="td-pricing">
						<table class="table-quantity-price">
							<tr>
								<?php foreach ($min_quantity as $qty) { ?>
									<?php $price = number_format((float) $price_arr[$qty], 2, '.', ''); ?>
									<td data-qty="<?= $qty ?>" data-price="<?= $price ?>">
										<span class="hide-desktop"><strong><?= $qty ?> PACK:</strong> </span>
										<?php
										if ($price_arr[$qty]) {
											echo '£' . $price;
										}
										else {
											echo '-';
										}
										?>
									</td>
								<?php } ?>
							</tr>
						</table>
					</td>
					<td>
						<div>
							<div class="qodef-quantity-buttons quantity">
								<label class="screen-reader-text" for="quantity_64ee8192f3cb5">FEFCO 0201 – plain glued case quantity</label>
								<span class="qodef-quantity-minus"></span>
								<input type="text" id="quantity_64ee8192f3cb5" class="input-text variation-qty qty text qodef-quantity-input"
									value="0" data-step="1" data-min="1" data-max="" name="quantity"
									for="#variation-<?= $product_variation->get_id() ?>">
								<span class="qodef-quantity-plus"></span>
							</div>
						</div>
					</td>
					<td>
						<div class="total-price">£0.00</div>
						<?= do_shortcode('[add_to_cart id=' . $product_variation->get_id() . ' quantity="0" show_price="FALSE"]') ?>
					</td>
				</tr>
			<?php } ?>
		</table>
		<?php
	?>
	<?php
	}
}

add_action('woocommerce_after_single_product_summary', 'action_custom_pricing_table');

function action_wp_footer()
{
	?>
	<script>
		console.log(get_closes([1, 5, 10, 20], 19));

		var theArray = jQuery('.min-quantity').map(function () {
			return parseInt(jQuery.trim(jQuery(this).text()));
		}).get();


		jQuery(".variation-qty").on("change", function () {
			$val = jQuery(this).val();
			$row_id = jQuery(this).attr('for');
			get_total($val, $row_id);
		});

		jQuery(".variation-qty").on("keyup", function () {
			$val = jQuery(this).val();
			$row_id = jQuery(this).attr('for');
			get_total($val, $row_id);

		});

		function get_total($val, $row_id) {
			if ($val != '' && $val != 0) {
				$closest = get_closes(theArray, $val);
				$data_price = jQuery($row_id).find('td[data-qty="' + $closest + '"]').attr('data-price');

				if ($data_price == 0.00) {
					jQuery($row_id).find('.add_to_cart_button').addClass('disabled');
					$minimun_is = jQuery($row_id).find('td[data-price="0.00"]').next().attr('data-qty');
					jQuery($row_id).find('.total-price').html('£0.00 <span> Minimum Quantity is ' + $minimun_is + ' </span>');
				} else {
					$price = $data_price * $val
					jQuery($row_id).find('.total-price').html('£' + $price.toFixed(2));
					jQuery($row_id).find('.add_to_cart_button').attr('data-quantity', $val);
					jQuery($row_id).find('.add_to_cart_button').removeClass('disabled');
				}

			} else {
				jQuery($row_id).find('.total-price').text('£0.00');
				jQuery($row_id).find('.add_to_cart_button').attr('data-quantity', 0);
			}
		}

		function get_closes(theArray, goal) {
			var theArray;
			var goal;
			var closest = null;
			jQuery.each(theArray, function () {
				if (closest == null || Math.abs(this - goal) < Math.abs(closest - goal)) {
					if (Math.abs(goal) >= Math.abs(this)) {
						closest = Math.abs(this);
					}
				}
			});
			return closest;
		}
	</script>
	<?php
}

add_action('wp_footer', 'action_wp_footer');


/**
 * @snippet       Hide Weight, Dimensions @ WooCommerce Single Product
 * @how-to        Get CustomizeWoo.com FREE
 * @author        Rodolfo Melogli
 * @compatible    WooCommerce 6
 * @donate $9     https://businessbloomer.com/bloomer-armada/
 */

add_filter('wc_product_enable_dimensions_display', '__return_false');


function subpages()
{
	ob_start();
	$childPages = get_pages(array('child_of' => get_the_ID(), 'parent' => get_the_ID(), 'sort_column' => 'menu_order'));
	?>
	<div class="subpages">
		<?php if ($childPages) { ?>
			<h3>Click on the boxes below for further details:</h3>
		<?php } ?>
		<div class='product-range-list page-menu'>
			<?php $i = 0; ?>

			<?php foreach ($childPages as $childPage): ?>
				<?php $thumb = wp_get_attachment_image_src(get_post_thumbnail_id($childPage->ID), 'medium'); ?>

				<div class="product-range-list-item product-range-list-item-<?php echo $i; ?>">
					<a class="outer" href="<?php echo get_permalink($childPage->ID); ?>">
						<div class="inner">
							<div class="image-box">
								<img src="<?php echo $thumb[0]; ?>" alt="">
							</div>
							<div class="heading-box">
								<h3><?php echo $childPage->post_title; ?></h3>
							</div>
							<span class="qodef-shortcode qodef-m  qodef-button qodef-layout--textual  qodef-html--link"
								href="https://thewalsallbox.theprogressteam.co.uk/2015/10/09/new-address/" target="_self"> <span
									class="qodef-m-text">Read More</span></span>
						</div>
					</a>
				</div>

				<?php $i++; ?>

			<?php endforeach; ?>

		</div>
	</div>
	<?php
	return ob_get_clean();
}

add_shortcode('subpages', 'subpages');


/**
 * @snippet       Variable Product Price Range: "From: min_price"
 * @how-to        Get CustomizeWoo.com FREE
 * @author        Rodolfo Melogli
 * @compatible    WooCommerce 6
 * @donate $9     https://businessbloomer.com/bloomer-armada/
 */

add_filter('woocommerce_variable_price_html', 'bbloomer_variation_price_format_min', 9999, 2);

function bbloomer_variation_price_format_min($price, $product)
{
	$prices = $product->get_variation_prices(true);
	$min_price = current($prices['price']);
	$max_price = end($prices['price']);
	$min_reg_price = current($prices['regular_price']);
	$max_reg_price = end($prices['regular_price']);

	return '';
}