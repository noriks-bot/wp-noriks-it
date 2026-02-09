<?php


// 1) Tell Woo’s default chooser to prefer COD when available.
add_filter('default_checkout_payment_method', function($method, $available_gateways) {
    return isset($available_gateways['cod']) ? 'cod' : $method;
}, 10, 2);

// 2) On first render (no prior choice in session), set COD as chosen.
add_action('woocommerce_before_checkout_form', function () {
    if (is_admin() && !defined('DOING_AJAX')) {
        return;
    }
    if (!function_exists('WC') || !WC()->session) {
        return;
    }

    $chosen = WC()->session->get('chosen_payment_method');
    if (empty($chosen)) {
        $available = WC()->payment_gateways()->get_available_payment_gateways();
        if (isset($available['cod'])) {
            WC()->session->set('chosen_payment_method', 'cod');
        }
    }
}, 5);

/**
 * Optional (front-end safety net):
 * If your theme/JS wipes the selection on first paint, precheck COD once.
 * Remove this block if you don’t need it.
 */
add_action('wp_footer', function () {
    if (!is_checkout() || is_wc_endpoint_url('order-received')) {
        return;
    } ?>
    <script>
    jQuery(function($){
        var $checked = $('input[name="payment_method"]:checked');
        if (!$checked.length && $('#payment_method_cod').length) {
            $('#payment_method_cod').prop('checked', true).trigger('change');
        }
    });
    </script>
<?php });


//  we need to move order now button bellow shop table on mobile only


/**
 * Move WooCommerce "Place order" button after the order review table on mobile only.
 * We hide the default button (only the button, not payments) and print our own copy later.
 */
add_action( 'wp', function () {

    // Only on the checkout page (not the thank-you page) and only on mobile.
    if ( ! function_exists( 'is_checkout' ) || ! is_checkout() || ( function_exists( 'is_order_received_page' ) && is_order_received_page() ) ) {
        return;
    }
    if ( ! function_exists( 'wp_is_mobile' ) || ! wp_is_mobile() ) {
        return;
    }

    // 1) Suppress only the default "Place order" button output.
    add_filter( 'woocommerce_order_button_html', 'mytheme_hide_default_place_order_button', 999 );

    // 2) Re-output a button after the order review table.
    add_action( 'woocommerce_checkout_after_order_review', 'mytheme_mobile_place_order_button_after_review', 20 );
});

/**
 * Filter callback to hide the default button.
 */
function mytheme_hide_default_place_order_button( $html ) {
    return '';
}

/**
 * Our custom button after the order review table (inside the checkout form).
 */
function mytheme_mobile_place_order_button_after_review() {

    // Use WooCommerce’s default translatable text (filters will still run on the TEXT, which is safe).
    $order_button_text = apply_filters(
        'woocommerce_order_button_text',
        __( 'Place order', 'woocommerce' )
    );

    // IMPORTANT: do NOT pass this HTML back through 'woocommerce_order_button_html' (it would be blanked).
    echo sprintf(
        '<button type="submit" class="button alt" name="woocommerce_checkout_place_order" id="place_order" value="%1$s" data-value="%1$s">%2$s</button>',
        esc_attr( $order_button_text ),
        esc_html( $order_button_text )
    );
}






//  we need to move order now button bellow shop table on mobile only












add_action( 'wp', function() {
    // Remove coupon form from its default location
    remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10 );

    // Add coupon form after order review
   // add_action( 'woocommerce_review_order_after_order_total', 'woocommerce_checkout_coupon_form' );
});





add_filter('woocommerce_billing_fields', 'no_billing_phone_validation' );
function no_billing_phone_validation( $fields ) {
    $fields['billing_phone']['required'] = true;
    return $fields;
}

// we hide ship to different address
add_filter( 'woocommerce_cart_needs_shipping_address', '__return_false' );


// we hide order extra notes
add_filter( 'woocommerce_checkout_fields', 'remove_order_notes_field' );
function remove_order_notes_field( $fields ) {
    if ( isset( $fields['order']['order_comments'] ) ) {
        unset( $fields['order']['order_comments'] );
    }
    return $fields;
}



// Move email field to top of billing fields
/*
add_filter( 'woocommerce_checkout_fields', 'custom_move_email_field_first', 20, 1 );
function custom_move_email_field_first( $fields ) {
    if ( isset( $fields['billing']['billing_email'] ) ) {
        $fields['billing']['billing_email']['priority'] = 1; // Ensure it's first
    }
    return $fields;
}
*/


add_filter( 'woocommerce_checkout_fields', 'custom_checkout_reorder_fields' );
function custom_checkout_reorder_fields( $fields ) {
    // Email first
    if ( isset( $fields['billing']['billing_email'] ) ) {
        $fields['billing']['billing_email']['priority'] = 1;
    }
    
      // Email first
    if ( isset( $fields['billing']['billing_phone'] ) ) {
        $fields['billing']['billing_phone']['priority'] = 2;
    }

    // Country next
    if ( isset( $fields['billing']['billing_country'] ) ) {
        $fields['billing']['billing_country']['priority'] = 5;
    }

    // First name
    if ( isset( $fields['billing']['billing_first_name'] ) ) {
        $fields['billing']['billing_first_name']['priority'] = 10;
    }

    // Last name
    if ( isset( $fields['billing']['billing_last_name'] ) ) {
        $fields['billing']['billing_last_name']['priority'] = 20;
    }



     // Ensure address_1 has a priority before address_2
    if ( isset( $fields['billing']['billing_address_1'] ) ) {
        $fields['billing']['billing_address_1']['priority'] = 40;
        $fields['billing']['billing_address_1']['required'] = true; // Keep it required
    }




    // Make sure address_2 exists, is visible, and ordered correctly
    if ( isset( $fields['billing']['billing_address_2'] ) ) {
        $fields['billing']['billing_address_2']['priority'] = 45; // Just after address_1
        $fields['billing']['billing_address_2']['required'] = false; // Usually optional
        $fields['billing']['billing_address_2']['class'] = array( 'form-row-wide' );
        $fields['billing']['billing_address_2']['label'] = __( 'Kućni broj', 'your-textdomain' );
        $fields['billing']['billing_address_2']['placeholder'] = __( 'Kućni broj', 'your-textdomain' );
        $fields['billing']['billing_address_2']['required'] = true; // Keep it required
    }





    return $fields;
}



add_filter( 'woocommerce_checkout_required_field_notice', function( $error, $field_label ) {
    // Remove "Naplata " prefix from the error message
    // Example input: "Naplata Mobitel (primjer: 0912345678)"
    $clean_label = preg_replace( '/^Naplata\s*/i', '', $field_label );

    // Rebuild WooCommerce's required field message
    $error = sprintf( __( '%s je obavezno polje.', 'woocommerce' ), $clean_label );

    return $error;
}, 10, 2 );

// Output a heading above the email field
add_action( 'woocommerce_before_checkout_billing_form', 'add_contact_heading_before_email' );
function add_contact_heading_before_email() {

    
    echo '<h3 class="checkout-section-title">Vaše údaje</h3>';
}


add_filter( 'woocommerce_checkout_fields', 'move_labels_to_placeholders' );
function move_labels_to_placeholders( $fields ) {
    foreach ( $fields as $section_key => $section ) {
        foreach ( $section as $field_key => $field ) {
            if ( isset( $fields[$section_key][$field_key]['label'] ) ) {
                $fields[$section_key][$field_key]['placeholder'] = $fields[$section_key][$field_key]['label'];
                $fields[$section_key][$field_key]['label'] = '';
            }
        }
    }
    return $fields;
}


// Remove default payment section
remove_action( 'woocommerce_checkout_order_review', 'woocommerce_checkout_payment', 20 );

// Re-add payment section right after billing fields
add_action( 'woocommerce_checkout_after_customer_details', 'woocommerce_checkout_payment', 5 );







add_filter( 'woocommerce_checkout_cart_item_quantity', 'add_product_image_to_checkout_review', 10, 3 );
function add_product_image_to_checkout_review( $product_name, $cart_item, $cart_item_key ) {
    if ( is_checkout() ) {
        $product = $cart_item['data'];
        $thumbnail = $product->get_image( [ 40, 40 ], [ 'style' => 'margin-right:10px; vertical-align:middle;' ] );

        // Wrap in span or div for better layout control
        return '<span  style="order: 1; display: flex; align-items: center;">' . $thumbnail . '<span>' . $product_name . '</span></span>';
    }

    return $product_name;
}


add_action( 'woocommerce_checkout_create_order', 'copy_billing_to_shipping_after_order', 10, 2 );
function copy_billing_to_shipping_after_order( $order, $data ) {
    // Copy each billing field to the shipping field
    $fields = [
        'first_name',
        'last_name',
        'company',
        'address_1',
        'address_2',
        'city',
        'state',
        'postcode',
        'country',
        'phone',
    ];

    foreach ( $fields as $field ) {
        $billing_value = $order->{"get_billing_$field"}();
        $order->{"set_shipping_$field"}( $billing_value );
    }
}




add_filter( 'woocommerce_gateway_description', 'remove_payment_method_description', 20, 2 );
function remove_payment_method_description( $description, $payment_id ) {
    return ''; // Return empty description
}



add_filter( 'woocommerce_cart_shipping_method_full_label', 'custom_shipping_label_price_only', 10, 2 );
function custom_shipping_label_price_only( $label, $method ) {
    if ( is_checkout() ) {
        // Get only the cost formatted
        $price = wc_price( $method->cost + array_sum( $method->get_taxes() ) );

        return $price; // Output just the price, like "2,99 €"
    }

    return $label; // Keep default elsewhere (e.g., cart)
}





add_filter( 'woocommerce_package_rates', 'auto_select_and_hide_paid_shipping_when_free', 100, 2 );
function auto_select_and_hide_paid_shipping_when_free( $rates, $package ) {
    $free = [];

    foreach ( $rates as $rate_id => $rate ) {
        if ( 'free_shipping' === $rate->method_id ) {
            $free[ $rate_id ] = $rate;
            break; // only need one free method
        }
    }

    return ! empty( $free ) ? $free : $rates;
}
