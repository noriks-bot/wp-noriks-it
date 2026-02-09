<?php 



add_filter( 'gettext', 'translate_attribute_labels', 20, 3 );

function translate_attribute_labels( $translated_text, $text, $domain ) {
    if ( $text === 'Choose your size' ) {
        $translated_text = 'Taglia';
    }
    return $translated_text;
}




add_filter( 'woocommerce_checkout_fields', 'custom_billing_phone_placeholder' );
function custom_billing_phone_placeholder( $fields ) {
    // Change the placeholder text for the billing phone field
    $fields['billing']['billing_phone']['placeholder'] = 'Cellulare (esempio: 3331234567)';
    
    return $fields;
}







add_filter( 'woocommerce_order_number', 'change_woocommerce_order_number' );
function change_woocommerce_order_number( $order_id ) {
    $prefix = 'NORIKS-IT-';
    $new_order_id = $prefix . $order_id;
    return $new_order_id;
}

// Force country in case above doesn't fully apply (safety net)
add_filter( 'default_checkout_billing_country', '__return_it' );
add_filter( 'default_checkout_shipping_country', '__return_it' );
function __return_it() {
    return 'IT';
}


// Force country to Italy and hide the country fields
add_filter( 'woocommerce_checkout_fields', 'fix_country_to_italy_and_hide' );
function fix_country_to_italy_and_hide( $fields ) {
    // Set default country to IT (Italy)
    WC()->customer->set_billing_country( 'IT' );
    WC()->customer->set_shipping_country( 'IT' );

    // Remove country fields
    unset( $fields['billing']['billing_country'] );
    unset( $fields['shipping']['shipping_country'] );

    return $fields;
}

add_filter( 'woocommerce_checkout_fields', 'hide_checkout_fields' );
function hide_checkout_fields( $fields ) {
    // Remove billing fields
  //  unset( $fields['billing']['billing_country'] );
    unset( $fields['billing']['billing_state'] );
   // unset( $fields['billing']['billing_address_2'] );

    // Optional: Remove shipping fields
    //unset( $fields['shipping']['shipping_country'] );
    unset( $fields['shipping']['shipping_state'] );
     unset( $fields['shipping']['shipping_address_2'] );


    return $fields;
}


/*
add_filter( 'default_checkout_billing_country', 'set_default_checkout_country' );
add_filter( 'default_checkout_shipping_country', 'set_default_checkout_country' );

function set_default_checkout_country( $country ) {
    return 'IT'; // Change 'IT' to Italy country code
}
*/


