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
	$translated = str_replace('Esmee', 'Wallbox', $translated);
	$translated = str_replace('esmee', 'wallbox', $translated);
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
		<a class="qodef-shortcode qodef-m  qodef-button qodef-layout--filled  qodef-html--link" href="https://esmee.qodeinteractive.com/shop-right-sidebar/" target="_self">
			<span class="qodef-m-text">GET A QUOTE</span>
		</a>

		<a class="button-link" target="_self">
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

	$tabs['test_tab'] = array(
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

function action_woocommerce_single_variation()
{
	$pricing_rules = get_post_meta(get_the_ID(), '_pricing_rules', true);
	if ($pricing_rules) {
		global $product;
		$variations = $product->get_children();
		echo '<pre> ' . var_dump($variations) . ' </pre>';
	?>
		<table>
			<tr>
				<th>PRODUCT REFERENCE</th>
				<th>DIMENSIONS</th>
				<th>MINUMUM NUMBER OF PACKS</th>
				<th>NUMBER OF PACKS</th>
				<th>PRICE</th>

			</tr>
			<?php foreach ($variations as $variation) { ?>
				<tr>
					<td>
						<?= get_the_title($variation) ?>
					</td>
					<td>
						<?php
						$product_variation = wc_get_product($variation);
						?>
						<?= $product_variation->get_dimensions(); ?>
					</td>
					<td>
						<?= do_shortcode('[add_to_cart id=' . $variation . ' quantity="4" show_price="FALSE"]') ?>
					</td>
				</tr>
			<?php } ?>
		</table>
		<?php
		?>
		<pre><?php var_dump($pricing_rules) ?></pre>
<?php
	}
}

add_action('woocommerce_single_variation', 'action_woocommerce_single_variation');
