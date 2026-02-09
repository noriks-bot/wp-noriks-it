<?php
/**
 * Thankyou page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/thankyou.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.1.0
 *
 * @var WC_Order $order
 */

defined( 'ABSPATH' ) || exit;
?>



<style>

.woocommerce {
        padding-bottom: 50px !important;
    }

.site-main {
        margin: 0 !important;
    }
    
.hentry {
    margin: 0 !important;
}

@media (max-width: 700px) {
    .woocommerce-order {
        margin: 0 !important;
    }
    
       .woocommerce-order {
        padding: 1.3rem 1rem;
    }
}



.xoo-wsc-markup {
      display: none !important;
}


table:not( .has-background ) tbody td {
     background-color: transparent;
}


 /* === My styles === */
 .entry-header {
      display: none;
}

.hentry .entry-content a {
      color: black;
}
 

.checkout--my-header {
    background: white;
    display: flex;
    justify-content: center;
    align-items: center;
 height: auto;
    padding-top: 10px;
    padding-bottom: 15px;
    border: 1px solid #dedede;

}

.checkout--my-header a {
    display: inline-block;
}

.checkout--my-header img {
    max-width: 200px;
    height: auto !important;
}


.my-checkout-container {
    max-width: 1100px;
    display: block;
    margin: 0 auto;
}


.woocommerce  {
     background: #fcfbfb;
}
 
 
 ul.order_details {
    margin: 20px 0 !important;
    padding: 0.9rem 1.5rem;
}

ul.order_details::before, ul.order_details::after  {
    display: none !important;
}
 
.woocommerce-order-details form   {
    display: none !important;
}


.woocommerce-order .woocommerce-notice  {
    background: #e9f7f0 !important;
    margin-bottom: 0 !important;
}

ul.order_details li  {
    padding: 5px 0 2px 0 !important;
}


.woocommerce-column--shipping-address {
    display: none !important;
}

 /* === My styles === */






 /* === WooCommerce Thank You Page Styling === */

.woocommerce-order {
max-width: 800px;
    margin: 2rem auto 0 auto;
    padding: 1.5rem;
    background: #ffffff;
    border-radius: 4px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.05);
    font-family: 'Schibsted Grotesk', sans-serif;
    color: #222;

}

.woocommerce-order h2,
.woocommerce-order h3 {
  font-weight: 600;
  color: #111;
  margin-bottom: 1rem;
}

.woocommerce-order .woocommerce-notice {
  background-color: #f5f5f5;
  padding: 1rem 1.5rem;
  border-left: 4px solid #27ae60;
  font-size: 1rem;
  font-weight: 500;
  color: #222;
  border-radius: 4px;
  margin-bottom: 2rem;
}

.woocommerce-order-overview,
.woocommerce-order-details,
.woocommerce-customer-details {
  background: #fafafa;
  border-radius: 4px;
  padding: 1.5rem;
  margin-bottom: 2rem;
  border: 1px solid #eee;
}

.woocommerce-order-overview li,
.woocommerce-order-details .woocommerce-table__line-item,
.woocommerce-customer-details address {
  font-size: 0.95rem;
  line-height: 1.6;
  color: #444;
}

.woocommerce-order-details table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 1rem;
}

.woocommerce-order-details th,
.woocommerce-order-details td {
  padding: 0.75rem 0.5rem;
  border-bottom: 1px solid #eaeaea;
  font-size: 0.95rem;
  text-align: left;
}

.woocommerce-order-details th {
  color: #888;
  font-weight: 500;
}

.woocommerce-order-details tfoot th {
  font-weight: 600;
  color: #000;
}

.woocommerce-order-details tfoot td {
  font-weight: 600;
  color: #333;
}

/* Buttons */
.woocommerce a.button,
.woocommerce button.button {
  background: #158000;
  color: #fff;
  padding: 0.8rem 1.6rem;
  border-radius: 4px;
  text-decoration: none;
  font-weight: 600;
  display: inline-block;
  transition: background 0.3s ease;
  border: none;
}

.woocommerce a.button:hover,
.woocommerce button.button:hover {
  background: #106600;
}

/* Responsive */
@media (max-width: 600px) {
  .woocommerce-order {
    padding: 1.5rem 1rem;
  }

  .woocommerce-order-details th,
  .woocommerce-order-details td {
    font-size: 0.9rem;
  }
}

</style>


<!--  my header -->


<div class="checkout--my-header">
   <a style="color:black; text-decoration: none;" href="<?php echo get_home_url(); ?>">
 <span style="color: black;
    font-family: 'Roboto', sans-serif;
    font-size: 33px;
    font-weight: bold;
    letter-spacing: 1.75px;">NORIKS</span>
    
    <span style="    color: black;
    display: block;
    font-size: 10px;
    font-family: 'Roboto', sans-serif;
    margin-top: -14px;
    letter-spacing: 0.38px;
    margin-left: 1px;">Simple Shirts, Done Better</span>
    </a>
</div>

<!-- my header -->

<div class="woocommerce-order">

	<?php
	if ( $order ) :

		do_action( 'woocommerce_before_thankyou', $order->get_id() );
		?>

		<?php if ( $order->has_status( 'failed' ) ) : ?>

			<p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed"><?php esc_html_e( 'Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction. Please attempt your purchase again.', 'woocommerce' ); ?></p>

			<p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed-actions">
				<a href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>" class="button pay"><?php esc_html_e( 'Pay', 'woocommerce' ); ?></a>
				<?php if ( is_user_logged_in() ) : ?>
					<a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="button pay"><?php esc_html_e( 'My account', 'woocommerce' ); ?></a>
				<?php endif; ?>
			</p>

		<?php else : ?>

			<?php wc_get_template( 'checkout/order-received.php', array( 'order' => $order ) ); ?>

			<ul class="woocommerce-order-overview woocommerce-thankyou-order-details order_details">

				<li class="woocommerce-order-overview__order order">
					<?php esc_html_e( 'Order number:', 'woocommerce' ); ?>
					<strong><?php echo $order->get_order_number(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></strong>
				</li>

				<li class="woocommerce-order-overview__date date">
					<?php esc_html_e( 'Date:', 'woocommerce' ); ?>
					<strong><?php echo wc_format_datetime( $order->get_date_created() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></strong>
				</li>

				<?php if ( is_user_logged_in() && $order->get_user_id() === get_current_user_id() && $order->get_billing_email() ) : ?>
					<li class="woocommerce-order-overview__email email">
						<?php esc_html_e( 'Email:', 'woocommerce' ); ?>
						<strong><?php echo $order->get_billing_email(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></strong>
					</li>
				<?php endif; ?>

				<li class="woocommerce-order-overview__total total">
					<?php esc_html_e( 'Total:', 'woocommerce' ); ?>
					<strong><?php echo $order->get_formatted_order_total(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></strong>
				</li>

				<?php if ( $order->get_payment_method_title() ) : ?>
					<li class="woocommerce-order-overview__payment-method method">
						<?php esc_html_e( 'Payment method:', 'woocommerce' ); ?>
						<strong><?php echo wp_kses_post( $order->get_payment_method_title() ); ?></strong>
					</li>
				<?php endif; ?>

			</ul>

		<?php endif; ?>

		<?php do_action( 'woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id() ); ?>
		<?php do_action( 'woocommerce_thankyou', $order->get_id() ); ?>

	<?php else : ?>

		<?php wc_get_template( 'checkout/order-received.php', array( 'order' => false ) ); ?>

	<?php endif; ?>

</div>
