<?php
/**
 * Storefront engine room
 *
 * @package storefront
 */

include(get_template_directory() . '/functions/checkout_mods.php');
include(get_template_directory() . '/functions/cpts.php');
include(get_template_directory() . '/functions/options.php');
include(get_template_directory() . '/functions/single_product_mods.php');
include(get_template_directory() . '/functions/discounts.php');



add_filter( 'woocommerce_gallery_image_size', function() {
    return 'full';
});




/**
 * Force redirect to Cart after add-to-cart on single product pages
 * and neutralize any upsell modal JS.
 */
add_action('init', function () {
	// Server-side redirect for NON-AJAX adds (highest priority wins)
	add_filter('woocommerce_add_to_cart_redirect', function ($url) {
		return home_url('/hr/cart/'); // or wc_get_cart_url()
	}, 9999);
});





$webshop_language = get_field("webshop_language", "options");

if( $webshop_language == null  || $webshop_language == false  || $webshop_language == "" ) {
  $webshop_language = "EN";
}

/*  include language specific files */
if ($webshop_language == "EN") {
  include(get_template_directory() . '/functions/lang/en.php');
} else if ($webshop_language == "HR") {
  include(get_template_directory() . '/functions/lang/hr.php');
}
/*  include language specific files */

/**
 * Assign the Storefront version to a var
 */
$theme              = wp_get_theme( 'storefront' );
$storefront_version = $theme['Version'];

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 980; /* pixels */
}

$storefront = (object) array(
	'version'    => $storefront_version,

	/**
	 * Initialize all the things.
	 */
	'main'       => require 'inc/class-storefront.php',
	'customizer' => require 'inc/customizer/class-storefront-customizer.php',
);

require 'inc/storefront-functions.php';
require 'inc/storefront-template-hooks.php';
require 'inc/storefront-template-functions.php';
require 'inc/wordpress-shims.php';

if ( class_exists( 'Jetpack' ) ) {
	$storefront->jetpack = require 'inc/jetpack/class-storefront-jetpack.php';
}

if ( storefront_is_woocommerce_activated() ) {
	$storefront->woocommerce            = require 'inc/woocommerce/class-storefront-woocommerce.php';
	$storefront->woocommerce_customizer = require 'inc/woocommerce/class-storefront-woocommerce-customizer.php';

	require 'inc/woocommerce/class-storefront-woocommerce-adjacent-products.php';

	require 'inc/woocommerce/storefront-woocommerce-template-hooks.php';
	require 'inc/woocommerce/storefront-woocommerce-template-functions.php';
	require 'inc/woocommerce/storefront-woocommerce-functions.php';
}

if ( is_admin() ) {
	$storefront->admin = require 'inc/admin/class-storefront-admin.php';

	require 'inc/admin/class-storefront-plugin-install.php';
}

/**
 * NUX
 * Only load if wp version is 4.7.3 or above because of this issue;
 * https://core.trac.wordpress.org/ticket/39610?cversion=1&cnum_hist=2
 */
if ( version_compare( get_bloginfo( 'version' ), '4.7.3', '>=' ) && ( is_admin() || is_customize_preview() ) ) {
	require 'inc/nux/class-storefront-nux-admin.php';
	require 'inc/nux/class-storefront-nux-guided-tour.php';
	require 'inc/nux/class-storefront-nux-starter-content.php';
}

/**
 * Note: Do not add any custom code here. Please use a custom plugin so that your customizations aren't lost during updates.
 * https://github.com/woocommerce/theme-customisations
 */

function enqueue_main_styles() {
    // Enqueue main.css (load everywhere)
    wp_enqueue_style(
        'main-style',
        get_template_directory_uri() . '/css/main.css',
        array(),
        filemtime(get_template_directory() . '/css/main.css'),
        'all'
    );

    // Enqueue product.css only on WooCommerce single product pages
    if (function_exists('is_product') && is_product()) {
        wp_enqueue_style(
            'product-style',
            get_template_directory_uri() . '/css/product.css',
            array(),
            filemtime(get_template_directory() . '/css/product.css'),
            'all'
        );
    }

    // Enqueue homepage.css on front page
    if (is_front_page()) {
        wp_enqueue_style(
            'homepage-style',
            get_template_directory_uri() . '/css/homepage.css',
            array(),
            filemtime(get_template_directory() . '/css/homepage.css'),
            'all'
        );
    }

    // Enqueue checkout.css on checkout
    if (function_exists('is_checkout') && is_checkout()) {
        wp_enqueue_style(
            'checkout-style',
            get_template_directory_uri() . '/css/checkout.css',
            array(),
            filemtime(get_template_directory() . '/css/checkout.css'),
            'all'
        );
    }
    
    
   
        if ( function_exists( 'is_cart' ) && is_cart() ) {
        wp_enqueue_style(
            'cart-style',
            get_template_directory_uri() . '/css/cart.css',
            array(),
            filemtime( get_template_directory() . '/css/cart.css' ),
            'all'
        );
    }
    
    
    
}
add_action('wp_enqueue_scripts', 'enqueue_main_styles');

function custom_quantity_buttons() {
    if (is_product()) {

        /****** here we add logic to select which qty buttons we show if any ******/
        $post_id = get_the_ID(); // Get current post ID
        $show_qty_options = get_field('show_qty_options', $post_id);
        $show_qty_options_123     = false;
        $show_qty_options_369     = false;
        $show_qty_options_6912    = false;
        $show_qty_options_248     = false;
        $show_qty_options_122436  = false;

        // Check if it's true
        if ($show_qty_options) {
            /****** here we add which buttons logic ******/
            if (get_field('show_123', $post_id) == true)  {
                $show_qty_options_123 = true;
            }
            if (get_field('show_369', $post_id) == true)  {
                $show_qty_options_369 = true;
            }
            if (get_field('show_6912', $post_id) == true) {
                $show_qty_options_6912 = true;
            }
            if (get_field('show_248', $post_id) == true)  {
                $show_qty_options_248 = true;
            }
            if (get_field('show_122446', $post_id) == true)  {
                 $show_qty_options_122436 = true;
            }
            /****** here we add which buttons logic ******/
        } else {
            // just skip, and do not show qty buttons at all
        }

        /****** we will make if else statemes which buttons we show ******/
        ?>

        <?php if ($show_qty_options && $show_qty_options_123): ?>
        <?php
        // get all dynamic discount and values here
        $show_123_qty_1_t1 =  get_field("show_123_qty_1_t1","options");
        $show_123_qty_1_t2 =  get_field("show_123_qty_1_t2","options");
        $show_123_qty_1_t3 =  get_field("show_123_qty_1_t3","options");
        $show_123_qty_2_t1 =  get_field("show_123_qty_2_t1","options");
        $show_123_qty_2_t2 =  get_field("show_123_qty_2_t2","options");
        $show_123_qty_2_t3 =  get_field("show_123_qty_2_t3","options");
        $show_123_qty_3_t1 =  get_field("show_123_qty_3_t1","options");
        $show_123_qty_3_t2 =  get_field("show_123_qty_3_t2","options");
        $show_123_qty_3_t3 =  get_field("show_123_qty_3_t3","options");

        // calculate here price per one
        $product = wc_get_product( $post_id );
        $sale_price    = null;
        $regular_price = null;

        if ( $product ) {
            if ( $product->is_type('simple') ) {
                $sale_price    = $product->get_sale_price();
                $regular_price = $product->get_regular_price();
            } elseif ( $product->is_type('variable') ) {
                // For variable products, get the lowest prices from variations
                $variations = $product->get_children(); // variation IDs

                $lowest_sale    = null;
                $lowest_regular = null;

                foreach ( $variations as $variation_id ) {
                    $variation = wc_get_product( $variation_id );
                    if ( $variation ) {
                        $sale    = floatval( $variation->get_sale_price() );
                        $regular = floatval( $variation->get_regular_price() );

                        if ( $sale && ( is_null($lowest_sale) || $sale < $lowest_sale ) ) {
                            $lowest_sale = $sale;
                        }

                        if ( $regular && ( is_null($lowest_regular) || $regular < $lowest_regular ) ) {
                            $lowest_regular = $regular;
                        }
                    }
                }

                $sale_price    = $lowest_sale;
                $regular_price = $lowest_regular;
            }
        }

        // Quantities
        $__qty_1 = 1;
        $__qty_2 = 2;
        $__qty_3 = 3;

        $price_per_one_1 = $__qty_1 ? $sale_price / $__qty_1 : 0;
        $price_per_one_2 = $__qty_2 ? ( ( $sale_price * 2 ) / $__qty_2 ) * 0.95 : 0;
        $price_per_one_3 = $__qty_3 ? ( ( $sale_price * 3 ) / $__qty_3 ) * 0.9 : 0;

        $regular_price_1 = $regular_price * 1;
        $regular_price_2 = $regular_price * 2;
        $regular_price_3 = $regular_price * 3;

        $discount_1 = $regular_price > 0 ? round( ( ( $regular_price - $sale_price ) / $regular_price ) * 100 ) : 0;
        $discount_2 = $regular_price_2 > 0 ? round( ( ( $regular_price_2 - ($price_per_one_2 * 2) ) / $regular_price_2 ) * 100 ) : 0;
        $discount_3 = $regular_price_3 > 0 ? round( ( ( $regular_price_3 - ($price_per_one_3 * 3) ) / $regular_price_3 ) * 100 ) : 0;
        ?>
        <script>
            jQuery(document).ready(function($) {
                let qtyField = $("input.qty");
                let qtyWrapper = qtyField.parent();
                // Hide default WooCommerce input
                qtyField.hide();
                // Add custom quantity buttons
                qtyWrapper.append(`
                    <div class="label choose-your-pack"><label for="choose-your-pack">Odaberite svoj paket</label></div>
                    <div class="custom-qty-buttons">
                        <button type="button" class="qty-btn" data-qty="1"><?php echo esc_html($show_123_qty_1_t1); ?>  <br/><span class="qty-off">-<?php echo esc_html($discount_1); ?><?php echo esc_html($show_123_qty_2_t2); ?> </span> <span class="qty-off-text"><?php echo wc_price($price_per_one_1); ?> <?php echo esc_html($show_123_qty_1_t3); ?></span> </button>
                        <button type="button" class="qty-btn" data-qty="2"><?php echo esc_html($show_123_qty_2_t1); ?> <br/><span class="qty-off">-<?php echo esc_html($discount_2); ?><?php echo esc_html($show_123_qty_2_t2); ?></span><span class="qty-off-text"><?php echo wc_price($price_per_one_2); ?> <?php echo esc_html($show_123_qty_2_t3); ?></span></button>
                        <button type="button" class="qty-btn" data-qty="3"><?php echo esc_html($show_123_qty_3_t1); ?> <br/><span class="qty-off">-<?php echo esc_html($discount_3); ?><?php echo esc_html($show_123_qty_3_t2); ?></span><span class="qty-off-text"><?php echo wc_price($price_per_one_3); ?> <?php echo esc_html($show_123_qty_3_t3); ?></span></button>
                    </div>
                     <style>.first-qty {
                            display: block !important;
                    }</style>
                `);
                $(".qty-btn").on("click", function() {
                    let qty = $(this).data("qty");
                    qtyField.val(qty).change();
                    $(".qty-btn").removeClass("active");
                    $(this).addClass("active");
                });
            });
        </script>
        <?php endif; ?>

        <?php if ($show_qty_options && $show_qty_options_369): ?>
        <script>
            jQuery(document).ready(function($) {
                let qtyField = $("input.qty");
                let qtyWrapper = qtyField.parent();
                // Hide default WooCommerce input
                qtyField.hide();
                // Add custom quantity buttons
                qtyWrapper.append(`
                    <div class="label choose-your-pack"><label for="choose-your-pack">Odaberite svoj paket</label></div>
                    <div class="custom-qty-buttons">
                        <button type="button" class="qty-btn" data-qty="1">3 pack  <br/><span class="qty-off">39% OFF</span> <span class="qty-off-text">€15,75 per item</span> </button>
                        <button type="button" class="qty-btn" data-qty="2">6 pack <br/><span class="qty-off"> 49% OFF</span><span class="qty-off-text">€15,75 per item</span></button>
                        <button type="button" class="qty-btn" data-qty="3">9 pack <br/><span class="qty-off"> 59% OFF</span><span class="qty-off-text">€15,75 per item</span></button>
                    </div>
                     <style>.first-qty {
                            display: block !important;
                    }</style>
                `);
                $(".qty-btn").on("click", function() {
                    let qty = $(this).data("qty");
                    qtyField.val(qty).change();
                    $(".qty-btn").removeClass("active");
                    $(this).addClass("active");
                });
            });
        </script>
        <?php endif; ?>

        <?php if ($show_qty_options && $show_qty_options_6912): ?>
        <?php
        // get all dynamic discount and values here
        $show_6912_qty_1_t1 =  get_field("show_6912_qty_1_t1","options");
        $show_6912_qty_1_t2 =  get_field("show_6912_qty_1_t2","options");
        $show_6912_qty_1_t3 =  get_field("show_6912_qty_1_t3","options");
        $show_6912_qty_2_t1 =  get_field("show_6912_qty_2_t1","options");
        $show_6912_qty_2_t2 =  get_field("show_6912_qty_2_t2","options");
        $show_6912_qty_2_t3 =  get_field("show_6912_qty_2_t3","options");
        $show_6912_qty_3_t1 =  get_field("show_6912_qty_3_t1","options");
        $show_6912_qty_3_t2 =  get_field("show_6912_qty_3_t2","options");
        $show_6912_qty_3_t3 =  get_field("show_6912_qty_3_t3","options");

        // calculate here price per one
        $product = wc_get_product( $post_id );
        $sale_price    = null;
        $regular_price = null;

        if ( $product ) {
            if ( $product->is_type('simple') ) {
                $sale_price    = $product->get_sale_price();
                $regular_price = $product->get_regular_price();
            } elseif ( $product->is_type('variable') ) {
                // For variable products, get the lowest prices from variations
                $variations = $product->get_children(); // variation IDs

                $lowest_sale    = null;
                $lowest_regular = null;

                foreach ( $variations as $variation_id ) {
                    $variation = wc_get_product( $variation_id );
                    if ( $variation ) {
                        $sale    = floatval( $variation->get_sale_price() );
                        $regular = floatval( $variation->get_regular_price() );

                        if ( $sale && ( is_null($lowest_sale) || $sale < $lowest_sale ) ) {
                            $lowest_sale = $sale;
                        }

                        if ( $regular && ( is_null($lowest_regular) || $regular < $lowest_regular ) ) {
                            $lowest_regular = $regular;
                        }
                    }
                }

                $sale_price    = $lowest_sale;
                $regular_price = $lowest_regular;
            }
        }

        // Quantities
        $__qty_1 = 6;
        $__qty_2 = 9;
        $__qty_3 = 12;

        $price_per_one_1 = $__qty_1 ? ( ( $sale_price * 6 ) / $__qty_1 ) * 0.9 : 0;
        $price_per_one_2 = $__qty_2 ? ( ( $sale_price * 9 ) / $__qty_2 ) * 0.8 : 0;
        $price_per_one_3 = $__qty_3 ? ( ( $sale_price * 12 ) / $__qty_3 ) * 0.7 : 0;

        $regular_price_1 = $regular_price * 6;
        $regular_price_2 = $regular_price * 9;
        $regular_price_3 = $regular_price * 12;

        $discount_1 = $regular_price_1 > 0 ? round( ( ( $regular_price_1 - ($price_per_one_2 * 6) ) / $regular_price_1 ) * 100 ) : 0;
        $discount_2 = $regular_price_2 > 0 ? round( ( ( $regular_price_2 - ($price_per_one_2 * 9) ) / $regular_price_2 ) * 100 ) : 0;
        $discount_3 = $regular_price_3 > 0 ? round( ( ( $regular_price_3 - ($price_per_one_3 * 12) ) / $regular_price_3 ) * 100 ) : 0;
        ?>
        <script>
            jQuery(document).ready(function($) {
                let qtyField = $("input.qty");
                let qtyWrapper = qtyField.parent();
                // Hide default WooCommerce input
                qtyField.hide();
                // Add custom quantity buttons
                qtyWrapper.append(`
                    <div class="label choose-your-pack"><label for="choose-your-pack">Odaberite svoj paket</label></div>
                    <div class="custom-qty-buttons">
                        <button type="button" class="qty-btn" data-qty="6"><?php echo esc_html($show_6912_qty_1_t1); ?>  <br/><span class="qty-off">-<?php echo esc_html($discount_1); ?><?php echo esc_html($show_6912_qty_2_t2); ?> </span> <span class="qty-off-text"><?php echo wc_price($price_per_one_1); ?> <?php echo esc_html($show_6912_qty_1_t3); ?></span> </button>
                        <button type="button" class="qty-btn" data-qty="9"><?php echo esc_html($show_6912_qty_2_t1); ?> <br/><span class="qty-off">-<?php echo esc_html($discount_2); ?><?php echo esc_html($show_6912_qty_2_t2); ?></span><span class="qty-off-text"><?php echo wc_price($price_per_one_2); ?> <?php echo esc_html($show_6912_qty_2_t3); ?></span></button>
                        <button type="button" class="qty-btn" data-qty="12"><?php echo esc_html($show_6912_qty_3_t1); ?> <br/><span class="qty-off">-<?php echo esc_html($discount_3); ?><?php echo esc_html($show_6912_qty_3_t2); ?></span><span class="qty-off-text"><?php echo wc_price($price_per_one_3); ?> <?php echo esc_html($show_6912_qty_3_t3); ?></span></button>
                   </div>
                    <style>.first-qty {
                            display: block !important;
                    }</style>
                `);
                $(".qty-btn").on("click", function() {
                    let qty = $(this).data("qty");
                    qtyField.val(qty).change();
                    $(".qty-btn").removeClass("active");
                    $(this).addClass("active");
                });
            });
        </script>
        <?php endif; ?>

        <?php if ($show_qty_options && $show_qty_options_248): ?>
        <script>
            jQuery(document).ready(function($) {
                let qtyField = $("input.qty");
                let qtyWrapper = qtyField.parent();
                // Hide default WooCommerce input
                qtyField.hide();
                // Add custom quantity buttons
                qtyWrapper.append(`
                    <div class="label choose-your-pack"><label for="choose-your-pack">Odaberite svoj paket</label></div>
                    <div class="custom-qty-buttons">
                        <button type="button" class="qty-btn" data-qty="1">2 pack  <br/><span class="qty-off">39% OFF</span> <span class="qty-off-text">€15,75 per item</span> </button>
                        <button type="button" class="qty-btn" data-qty="2">4 pack <br/><span class="qty-off"> 49% OFF</span><span class="qty-off-text">€15,75 per item</span></button>
                        <button type="button" class="qty-btn" data-qty="3">8 pack <br/><span class="qty-off"> 59% OFF</span><span class="qty-off-text">€15,75 per item</span></button>
                    </div>
                     <style>.first-qty {
                            display: block !important;
                    }</style>
                `);
                $(".qty-btn").on("click", function() {
                    let qty = $(this).data("qty");
                    qtyField.val(qty).change();
                    $(".qty-btn").removeClass("active");
                    $(this).addClass("active");
                });
            });
        </script>
        <?php endif; ?>

        <?php if ($show_qty_options && $show_qty_options_122436): ?>
        <script>
            jQuery(document).ready(function($) {
                let qtyField = $("input.qty");
                let qtyWrapper = qtyField.parent();
                // Hide default WooCommerce input
                qtyField.hide();
                // Add custom quantity buttons
                qtyWrapper.append(`
                    <div class="label choose-your-pack"><label for="choose-your-pack">Odaberite svoj paket</label></div>
                    <div class="custom-qty-buttons">
                        <button type="button" class="qty-btn" data-qty="1">12 pack  <br/><span class="qty-off">39% OFF</span> <span class="qty-off-text">€15,75 per item</span> </button>
                        <button type="button" class="qty-btn" data-qty="2">24 pack <br/><span class="qty-off"> 49% OFF</span><span class="qty-off-text">€15,75 per item</span></button>
                        <button type="button" class="qty-btn" data-qty="3">36 pack <br/><span class="qty-off"> 59% OFF</span><span class="qty-off-text">€15,75 per item</span></button>
                    </div>
                     <style>.first-qty {
                            display: block !important;
                    }</style>
                `);
                $(".qty-btn").on("click", function() {
                    let qty = $(this).data("qty");
                    qtyField.val(qty).change();
                    $(".qty-btn").removeClass("active");
                    $(this).addClass("active");
                });
            });
        </script>
        <?php endif; ?>

        <?php /****** style is generel, i will move into css from here  ******/ ?>
        <style>
            .choose-your-pack label  {
              font-family: 'Roboto', sans-serif;
              font-size: 16.5px !important;
              font-weight: 700 !important;
              line-height: 1.4 !important;
              color: #222 !important;
            }
            .quantity  { display: block; }
            .qty-off {
               background-color: #971b1b26;
               color: #971b1b;
               font-size: 12px;
               font-weight: 700;
               line-height: 120%;
               padding: 4px 8px;
               border-radius: 2px;
               display: inline-block;
               margin-top: 10px;
               font-size: 12px !important;
            }
            .qty-off-text {
               font-weight: 500;
               color: #11121399;
               text-align: center;
               display: block;
               margin-top: 10px;
               font-size: 15px;
            }
            .custom-qty-buttons {
                display: flex;
                gap: 10px;
                margin-top: 8px;
            }
            .qty-btn span  { font-size: 12px; }
            .qty-btn {
                background: white;
                border: 1px solid #ccc;
                flex: 1;
                padding: 12px;
                text-align: center;
                color: #333;
                border-radius: 1px;
                font-size: 16px;
                font-weight: bold !important;
                cursor: pointer;
            }
            .qty-btn.active { background: #F4F4F4; border: 1px solid black; }
            .storefront-breadcrumb { display: none; }
            #main .product { margin-top: 20px; }
            .storefront-product-pagination  { display: none; }
            .quantity  { width: 100%; display: block; margin-bottom: 20px; }
            .single_add_to_cart_button  { width: 100%; background: #f39c12; }
            .product .product_meta { display: none; }
            .edit-link { display: none; }
            .first-qty .quantity { display: block !important; }
        </style>
        <?php
    }
}
add_action('wp_footer', 'custom_quantity_buttons');

// Replace variation dropdowns with buttons on product page
add_filter('woocommerce_dropdown_variation_attribute_options_args', function($args) {
    $args['class'] .= ' hidden-select'; // Add class to hide later with CSS
    return $args;
}, 10, 1);

add_action('woocommerce_before_variations_form', function() {
    // Open wrapper if needed, optional
});

add_action('wp_footer', function() {
    if (!is_product()) return;
    ?>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Grab variations JSON from WooCommerce
        const variationsJson = window.product_variations_json || null;
        if (!variationsJson && typeof wc_add_to_cart_variation_params !== 'undefined') {
            if (document.querySelector('form.variations_form')) {
                const form = document.querySelector('form.variations_form');
                const variationsData = form.getAttribute('data-product_variations');
                if (variationsData) {
                    window.product_variations_json = JSON.parse(variationsData);
                }
            }
        }

        const variations = window.product_variations_json || [];
        const selects = document.querySelectorAll('.variations select');

        selects.forEach(select => {
            if (!select.name.startsWith('attribute_')) return;

            const attribute = select.name.replace('attribute_', '');
            const wrapper = document.createElement('div');
            wrapper.classList.add('variation-buttons');
            wrapper.dataset.attributeName = attribute;

            let firstAvailableButton = null;

            Array.from(select.options).forEach(option => {
                if (!option.value) return;

                const button = document.createElement('button');
                button.type = 'button';
                button.className = 'variation-button';
                button.dataset.value = option.value;
                button.innerText = option.innerText;

                // Check if option is available
                const available = variations.some(variation => {
                    return variation.attributes['attribute_' + attribute] === option.value && variation.is_in_stock;
                });

                if (!available) {
                    button.disabled = true;
                    button.classList.add('disabled');
                } else {
                    if (!firstAvailableButton) {
                        firstAvailableButton = button;
                    }
                    button.addEventListener('click', function() {
                        select.value = option.value;
                        jQuery(select).trigger('change');

                        wrapper.querySelectorAll('.variation-button').forEach(btn => btn.classList.remove('active'));
                        button.classList.add('active');
                    });
                }

                wrapper.appendChild(button);
            });

            select.parentNode.insertBefore(wrapper, select.nextSibling);

            // Auto-select first available option
            if (firstAvailableButton) {
                firstAvailableButton.click();
            }
        });
    });
    </script>
    <?php
});

// Change number of products per row to 4
add_filter('loop_shop_columns', 'custom_loop_columns', 999);
function custom_loop_columns() {
    return 4; // 4 products per row
}




add_action( 'woocommerce_before_shop_loop_item_title', 'add_second_product_thumbnail', 11 );
function add_second_product_thumbnail() {
    global $product;
    $gallery = $product->get_gallery_image_ids();
    if ( ! empty( $gallery ) ) {
        $second = wp_get_attachment_image_src( $gallery[0], 'woocommerce_thumbnail' );
        if ( $second ) {
            echo '<img class="secondary-image" src="' . esc_url( $second[0] ) . '" alt="" />';
        }
    }
}





function enqueue_custom_carousels_assets() {
    // Slick Carousel CSS
    wp_enqueue_style(
        'slick-carousel-css',
        'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css',
        array(),
        '1.8.1'
    );

    // Glide.js CSS
    wp_enqueue_style(
        'glidejs-css',
        'https://cdn.jsdelivr.net/npm/@glidejs/glide/dist/css/glide.core.min.css',
        array(),
        null
    );

    // jQuery (Slick requires jQuery and WordPress includes jQuery by default)
    wp_enqueue_script('jquery');

    // Slick Carousel JS
    wp_enqueue_script(
        'slick-carousel-js',
        'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js',
        array('jquery'),
        '1.8.1',
        true
    );

    // Glide.js JS
    wp_enqueue_script(
        'glidejs-js',
        'https://cdn.jsdelivr.net/npm/@glidejs/glide/dist/glide.min.js',
        array(),
        null,
        true
    );
}
add_action('wp_enqueue_scripts', 'enqueue_custom_carousels_assets');

add_action( 'woocommerce_before_variations_form', function() {
    get_template_part( 'template_parts/size-chart-modal' );
});

add_filter('woocommerce_get_image_size_thumbnail', 'custom_large_shop_thumbnail');
function custom_large_shop_thumbnail($size) {
    return array(
        'width'  => 600, // Increase this number
        'height' => 600,
        'crop'   => 1,
    );
}

add_action('wp_footer', function () {
    ?>
    <script>
    jQuery(document).ready(function($) {
        function closeYithQuickView() {
            var $closeBtn = $('.yith-quick-view-close');
            if ($closeBtn.length) {
                $closeBtn.trigger('click');
            }
        }

        // ✅ Use YITH's custom event (best)
        $(document).on('yith_wcqv_product_added_to_cart', function() {
            closeYithQuickView();
        });

        // ✅ Fallback for WooCommerce's native event
        $(document.body).on('added_to_cart', function() {
            if ($('.yith-wcqv-main').length) {
                closeYithQuickView();
            }
        });
    });
    </script>
    <?php
});

add_filter('woocommerce_get_price_html', 'custom_price_for_specific_product', 20, 2);
function custom_price_for_specific_product($price, $product) {
    $target_product_id = 423;  // <-- Replace this with your actual product ID

    if (is_shop() || is_product_category()) {
        if ($product->get_id() == $target_product_id) {
            // Custom price display
            $custom_price = "<span class='special-multipack-price' style='color: red;   
    font-size: 18px !important;
    color: #f83a3a;
    letter-spacing: -0.5px !important;'>Od 13.99€</span>";
            $regular_price = $product->get_regular_price();

            if ($custom_price < $regular_price) {
                $price = '<del>' . wc_price($regular_price) . '</del> <ins>' . wc_price($custom_price) . '</ins>';
            } else {
                $price = ($custom_price);
            }
        }
    }
    return $price;
}


   
   
   add_filter( 'woocommerce_add_to_cart_fragments', function( $fragments ) {
    ob_start(); ?>
    <span class="cart-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
    <?php
    $fragments['.cart-count'] = ob_get_clean();
    return $fragments;
});
   
   
   
   
   
   
   
   // Replace product thumbnail on archive/category pages with ACF image
add_action( 'after_setup_theme', function() {
    // Remove default thumbnail output in product loops
    remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
    // Add our custom thumbnail
    add_action( 'woocommerce_before_shop_loop_item_title', 'my_alt_loop_product_thumbnail', 10 );
}, 20 );

function my_alt_loop_product_thumbnail() {
    global $product;

    if ( ! $product ) {
        return;
    }

    // IMPORTANT: don't affect images on single product page (incl. related/upsells)
    if ( is_product() ) {
        woocommerce_template_loop_product_thumbnail();
        return;
    }

    $product_id = $product->get_id();

    // Get your ACF image field (adjust field name if needed)
    // If the field returns an image ID:
    $alt_image_id = get_field( '_singlepp_alternative_primary_image', $product_id );

    // If your field is stored as plain meta instead, use this instead of get_field():
    // $alt_image_id = get_post_meta( $product_id, '_singlepp_alternative_primary_image', true );

    if ( $alt_image_id ) {
        // Output alternative image in archive/category loop
        echo wp_get_attachment_image(
            $alt_image_id,
            'woocommerce_thumbnail',
            false,
            array(
                'class'   => 'attachment-woocommerce_thumbnail size-woocommerce_thumbnail',
                'loading' => 'lazy',
                'alt'     => esc_attr( $product->get_name() ),
            )
        );
    } else {
        // Fallback to normal product thumbnail
        woocommerce_template_loop_product_thumbnail();
    }
}
   
   
   
   
   
   
   
   add_filter( 'woocommerce_ajax_variation_threshold', 'wc_ninja_ajax_threshold' );
function wc_ninja_ajax_threshold() {
    return 50;
}
   
   
   
   
   
   
   
   
   add_action( 'pre_get_posts', 'show_all_products_on_shop_page' );
function show_all_products_on_shop_page( $query ) {

    if (
        ! is_admin() &&
        $query->is_main_query() &&
        is_shop()
    ) {
        $query->set( 'posts_per_page', -1 );
    }
}




add_filter('loop_shop_per_page', function($per_page) {
    if (is_product_category()) {
        return -1; // show ALL products in category
    }
    return $per_page;
}, 20);


// Disable WordPress emoji conversion
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('admin_print_scripts', 'print_emoji_detection_script');
remove_action('wp_print_styles', 'print_emoji_styles');
remove_action('admin_print_styles', 'print_emoji_styles');
remove_filter('the_content_feed', 'wp_staticize_emoji');
remove_filter('comment_text_rss', 'wp_staticize_emoji');
remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
add_filter('tiny_mce_plugins', function ($plugins) {
    return is_array($plugins) ? array_diff($plugins, ['wpemoji']) : [];
});
