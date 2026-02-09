<?php
/**
 * Customer processing order email
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/customer-processing-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates\Emails
 * @version 9.9.0
 */

use Automattic\WooCommerce\Utilities\FeaturesUtil;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$email_improvements_enabled = FeaturesUtil::feature_is_enabled( 'email_improvements' );

/*
 * @hooked WC_Emails::email_header() Output the email header
 */
do_action( 'woocommerce_email_header', $email_heading, $email ); ?>

<?php echo $email_improvements_enabled ? '<div class="email-introduction">' : ''; ?>
<p style="color:black;" >
<?php
if ( ! empty( $order->get_billing_first_name() ) ) {
	/* translators: %s: Customer first name */
	printf( esc_html__( 'Hej  %s,', 'woocommerce' ), esc_html( $order->get_billing_first_name() ) );
} else {
	printf( esc_html__( 'Hej ,', 'woocommerce' ) );
}
?>
</p>
<?php if ( $email_improvements_enabled ) : ?>


	<p style="color:black;">Tvoja narudžba je uspješno zaprimljena – hvala ti što si odabrao NORIKS!
	<br/>	<br/>
	Sad pripremamo tvoj NORIKS proizvod i uskoro kreće na put.
    <br/><br/>
    Samo udobnost i dobar osjećaj – cijeli dan.<br/><br/>
    
    Javit ćemo ti čim tvoj paket krene prema tebi.<br/>
    Ako ti bilo što zatreba – tu smo. 🙂<br/><br/>
    
    
    <strong>Ako ste se zabunili oko veličine, količine ili boje u narudžbi – bez brige!</strong><br/>
    Odgovorite direktno na ovaj e-mail i javite nam što treba promijeniti prije slanja paketa. Rado ćemo sve brzo srediti.<br/><br/>
    
    NORIKS tim
    </p>

	
	
	
<?php else : ?>
	<?php /* translators: %s: Order number */ ?>
	
		
	<p style="color:black;">Tvoja narudžba je uspješno zaprimljena – hvala ti što si odabrao NORIKS!
	<br/>	<br/>
Sad pripremamo tvoj NORIKS proizvod i uskoro kreće na put.
    <br/><br/>
    Samo udobnost i dobar osjećaj – cijeli dan.<br/><br/>
    
    Javit ćemo ti čim tvoj paket krene prema tebi.<br/>
    Ako ti bilo što zatreba – tu smo. 🙂<br/><br/>
    
    
    <strong>Ako ste se zabunili oko veličine, količine ili boje u narudžbi – bez brige!</strong><br/>
    Odgovorite direktno na ovaj e-mail i javite nam što treba promijeniti prije slanja paketa. Rado ćemo sve brzo srediti.<br/><br/>
    
    NORIKS tim
    </p>


	
<?php endif; ?>
<?php echo $email_improvements_enabled ? '</div>' : ''; ?>

<?php

/*
 * @hooked WC_Emails::order_details() Shows the order details table.
 * @hooked WC_Structured_Data::generate_order_data() Generates structured data.
 * @hooked WC_Structured_Data::output_structured_data() Outputs structured data.
 * @since 2.5.0
 */
do_action( 'woocommerce_email_order_details', $order, $sent_to_admin, $plain_text, $email );

/*
 * @hooked WC_Emails::order_meta() Shows order meta data.
 */
do_action( 'woocommerce_email_order_meta', $order, $sent_to_admin, $plain_text, $email );

/*
 * @hooked WC_Emails::customer_details() Shows customer details
 * @hooked WC_Emails::email_address() Shows email address
 */
do_action( 'woocommerce_email_customer_details', $order, $sent_to_admin, $plain_text, $email );

/**
 * Show user-defined additional content - this is set in each email's settings.
 */
if ( $additional_content ) {
	echo $email_improvements_enabled ? '<table border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td class="email-additional-content">' : '';
	echo wp_kses_post( wpautop( wptexturize( $additional_content ) ) );
	echo $email_improvements_enabled ? '</td></tr></table>' : '';
}

/*
 * @hooked WC_Emails::email_footer() Output the email footer
 */
do_action( 'woocommerce_email_footer', $email );
