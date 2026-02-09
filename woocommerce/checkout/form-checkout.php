<?php
/**
 * Checkout Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


?>







<style>

.kl_newsletter_checkbox_field  {
    
  display: none !important;
}

@media (min-width: 768px) {
    
    #order_review  #place_order {
             display: none !important;
 
    }
}


@media (max-width: 767px) {
    #customer_details #place_order {
        display: none !important;
 
    }
    
    #payment .place-order {
            margin-top: 0 !important;
 
    }
    
    #order_review  #place_order {
            margin-top: 0px !important;
 
    }
}




#order_review .woocommerce-shipping-methods .amount {
   
}

#order_review .woocommerce-shipping-methods  {
    font-size: 12px !important;
}

#order_review .shipping_method li {
    font-size: 12px !important;
}

#order_review .shipping_method label {
    font-size: 12px !important;
}


.checkout-inline-error-message  {
    color: #a91b0c;
    margin-top: 4px;
    font-size: 13px;
    margin-bottom: 0px;
}

.entry-header   {
     display: none;
}

.xoo-wsc-markup {
     display: none !important;
}

.hentry {
    margin: 0 0 0 0 !important;
}

.site-main {
    margin-bottom: 0;
}

.woocommerce-form-coupon-toggle  {
    
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


#payment .place-order {
    padding: 0 !important;
    }

.checkout-col-right  {
    background: #fbfbfb;
    }
#order_review {
     background: #fbfbfb;
}
    
    
table:not( .has-background ) tbody td, td, th, tr, table {
   
}


table:not( .has-background ) th {
     
}


.has-background  th {
    
}


table:not( .has-background ) th {
    background-color: #fbfbfb;
}

.woocommerce-privacy-policy-text {
     display: none !important;
}
    




@media (min-width: 768px) {
    #order_review_heading, #order_review {
        width: 45%
 
    }
}


</style>

<div class="checkout--my-header">
    <a style="color:black; text-decoration: none;" href="<?php echo get_home_url(); ?>">
 <span style="color: black;
    font-family: 'Roboto', sans-serif;
    font-size: 33px;
    font-weight: bold;
    letter-spacing: 1.75px;">NORIKS</span>
    
  
  
    </a>
</div>


<?php 

do_action( 'woocommerce_before_checkout_form', $checkout );

// If checkout registration is disabled and not logged in, the user cannot checkout.
if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
	echo esc_html( apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) ) );
	return;
}

?>


<style>
 .my-checkout-section {
  width: 100%;
  box-sizing: border-box;
  padding: 0; /* remove padding so background touches edge */
}

.my-checkout-container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 0px 20px 20px 20px;
  box-sizing: border-box;
}

.checkout-row {
  display: flex;
  flex-direction: column;
}

.checkout-column {
  padding: 15px;
  box-sizing: border-box;
}

.left-column {
  background-color: #fff;
}

.right-column {
  background-color: transparent;
}

/* Desktop: two columns with full-height right background */
@media (min-width: 768px) {
  .checkout-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    position: relative;
  }

  .my-checkout-section {
    background: linear-gradient(to right, white 50%, #fbfbfb 50%);
  }
  
  .col2-set {
      width: 45%;
  }
}





</style>


<section class="my-checkout-section"; >


    
    
<div class="my-checkout-container">

 <div class="checkout-row">
      <div class="checkout-column left-column">
   
      </div>
      <div style="" class="checkout-column right-column">
       
      </div>
    </div>





<form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data" aria-label="<?php echo esc_attr__( 'Checkout', 'woocommerce' ); ?>">



	<?php if ( $checkout->get_checkout_fields() ) : ?>

		<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

		<div class="col2-set" id="customer_details">
			<div class="col-1">
			    
			    
				<?php do_action( 'woocommerce_checkout_billing' ); ?>
				
				
				<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>
				
			</div>

			<div class="col-2">
				<?php do_action( 'woocommerce_checkout_shipping' ); ?>
			</div>
		</div>



	<?php endif; ?>
	
	<?php do_action( 'woocommerce_checkout_before_order_review_heading' ); ?>
	
	
	

	
    <div class="checkout-col-right">
        
        
        <style>
  /* ===== Coupon Inline (namespaced) ===== */
  /* Unique root to avoid clashes */
  #cci-inline-coupon-1 { /* container hook, no visual styles by default */ }

  /* Keep your original global tweak (left unchanged) */
  @media (min-width: 768px) {
    #order_review .shop_table {
      margin-bottom: 25px !important;
    }
  }

  /* Notices (scoped) */
  #cci-inline-coupon-1 .cci-notices .woocommerce-error {
    font-size: 12px !important;
    padding: 8px 10px 6px 10px !important;
    border: none !important;
    border-radius: 3px !important;
  }
  #cci-inline-coupon-1 .cci-notices .woocommerce-error:before { display: none; }

  #cci-inline-coupon-1 .cci-notices .woocommerce-message {
    font-size: 12px !important;
    padding: 8px 10px 6px 10px !important;
    border: none !important;
    border-radius: 3px !important;
  }
  #cci-inline-coupon-1 .cci-notices .woocommerce-message:before { display: none; }

  /* Layout (scoped) */
  #cci-inline-coupon-1 .cci-form-row-first {
    width: 77% !important;
    float: left;
    margin-right: 10px !important;
    clear: none !important;
    margin-bottom: 5px !important;
  }
  #cci-inline-coupon-1 .cci-form-row-last {
    width: 20% !important;
    float: right;
    margin-right: 0 !important;
    clear: none !important;
    margin-bottom: 5px !important;
  }

  @media (max-width: 767px) {
    #cci-inline-coupon-1 .form-row input {
      font-size: 13px;
      height: 40px;
    }
    #cci-inline-coupon-1 .form-row button {
      font-size: 14px !important;
      height: 40px !important;
      width: 100%;
    }
    #cci-inline-coupon-1 .cci-form-row-first {
      width: 68% !important;
      margin-right: 5px !important;
    }
    #cci-inline-coupon-1 .cci-form-row-last {
      width: 30% !important;
      float: right !important;
      text-align: right !important;
      margin-left: 0 !important;
    }
  }

  /* Button (scoped) */
  #cci-inline-coupon-1 .cci-apply-btn {
    border-radius: 4px;
    letter-spacing: -0.1px;
    font-weight: 600;
    font-size: 16px;
    line-height: 1.318 !important;
    border: 1px solid #dedede !important;
  }

  /* Cart discount row (these target Woo output; safe to keep global, but
     we’ll scope where possible to our widget’s vicinity) */
  #cci-inline-coupon-1 ~ .cart-discount .woocommerce-remove-coupon {
    display: none;
    color: black;
  }
  #cci-inline-coupon-1 ~ .cart-discount td {
    text-align: right !important;
    font-weight: 400 !important;
    font-size: 12px !important;
    color: #11a664 !important;
  }
</style>

<!-- Coupon: namespaced -->
<section id="cci-inline-coupon-1" class="coupon-code-section coupon-code-section-mobile">
  <div class="checkout-coupon-inline">
    <p class="form-row cci-form-row-first">
      <label for="cci-coupon-input" class="screen-reader-text">
        <?php esc_html_e( 'Coupon:', 'woocommerce' ); ?>
      </label>
      <input
        type="text"
        id="cci-coupon-input"
        class="input-text"
        placeholder="<?php esc_attr_e( 'Slevový kód nebo dárková karta', 'woocommerce' ); ?>"
      />
    </p>

    <p class="form-row cci-form-row-last">
      <button
        type="button"
        id="cci-apply-btn"
        class="cci-apply-btn button"
      >
        <?php esc_html_e( 'Apply', 'woocommerce' ); ?>
      </button>
    </p>

    <div class="clear"></div>

    <!-- Notification area -->
    <div class="cci-notices inline-coupon-notices" aria-live="polite"></div>
  </div>
</section>

<script>
(function($){
  var $root = $('#cci-inline-coupon-1');
  var pendingNoticeHtml = '';
  var lastTriedCode = '';

  function ensureNoticeTarget(){
    var $t = $root.find('.cci-notices.inline-coupon-notices');
    if (!$t.length) {
      var $anchor = $root.find('.clear').last();
      $t = $('<div class="cci-notices inline-coupon-notices" aria-live="polite"></div>');
      if ($anchor.length) { $t.insertAfter($anchor); }
      else { $root.append($t); }
    }
    return $t;
  }

  function setNotice(html){
    pendingNoticeHtml = html || '';
    ensureNoticeTarget().html(pendingNoticeHtml);
  }

  function successHtml(){
    return '<div class="woocommerce-message" role="alert">Žádost o kupón.</div>';
  }
  function errorHtml(){
    return '<ul class="woocommerce-error" role="alert"><li>Unesite važeći kod za popust ili poklon karticu.</li></ul>';
  }

  // Mimic Woo's coupon class slug: lowercase, non a-z0-9 -> '-'
  function couponClassFromCode(code){
    return String(code || '')
      .toLowerCase()
      .replace(/[^a-z0-9]/g, '-')
      .replace(/-+/g, '-')
      .replace(/^-|-$/g, '');
  }

  // After fragments refresh, verify if coupon is present in totals
  $(document.body).on('updated_checkout', function(){
    if (!lastTriedCode) return;

    var slug = couponClassFromCode(lastTriedCode);
    var applied =
      $('.cart-discount.coupon-' + slug).length > 0 ||
      $('.cart-discount').filter(function(){
        return $(this).text().toLowerCase().indexOf(lastTriedCode.toLowerCase()) !== -1;
      }).length > 0;

    setNotice(applied ? successHtml() : errorHtml());
  });

  $root.on('click', '#cci-apply-btn', function(e){
    e.preventDefault();

    var code = $.trim($root.find('#cci-coupon-input').val());
    if (!code) return;

    lastTriedCode = code;   // remember which code we’re verifying
    setNotice('');          // clear old notice

    var $btn = $(this).prop('disabled', true);

    // Build Woo AJAX URL + nonce
    var ajaxUrl = (typeof wc_checkout_params !== 'undefined' && wc_checkout_params.wc_ajax_url)
      ? wc_checkout_params.wc_ajax_url
      : (typeof wc_cart_params !== 'undefined' && wc_cart_params.wc_ajax_url ? wc_cart_params.wc_ajax_url : window.location.href);
    ajaxUrl = ajaxUrl.replace('%%endpoint%%', 'apply_coupon');

    var nonce =
      (typeof wc_checkout_params !== 'undefined' && wc_checkout_params.apply_coupon_nonce) ?
        wc_checkout_params.apply_coupon_nonce :
      (typeof wc_cart_params !== 'undefined' && wc_cart_params.apply_coupon_nonce) ?
        wc_cart_params.apply_coupon_nonce :
        '';

    $.post(ajaxUrl, { coupon_code: code, security: nonce })
      .always(function(){
        // Whether success or error, let Woo refresh totals,
        // then our updated_checkout handler will show the correct notice.
        $(document.body).trigger('applied_coupon', [code]);
        $(document.body).trigger('update_checkout');
        $btn.prop('disabled', false);
      });
  });

  // Ensure notice container exists initially
  $(ensureNoticeTarget);
})(jQuery);
</script>

                              

        	<div id="order_review" class="woocommerce-checkout-review-order">
        	    
        	    <h3 class="checkout-section-title">Riepilogo ordine</h3>
        	    
        	    <?php do_action( 'woocommerce_checkout_before_order_review' ); ?>
        	    
        	    
        		<?php do_action( 'woocommerce_checkout_order_review' ); ?>
        		
        		


        		
        		
        		<!-- just some content -->
        		<div class="reviews-wrapper-my" style="background: #fbfbfb;">
        		    
        		 
        		<style>
        		
        		       @media (min-width: 768px) {
        		            #order_review .shop_table {
                                margin-bottom: 25px  !important;
                            }
        		        }
        		
        		.dekstopni .woocommerce-error {
                        font-size: 12px !important;
                        padding: 8px 10px 6px 10px !important;
                        border: none !important;
                        border-radius: 3px  !important;
                        
                }
                .dekstopni .woocommerce-error:before {
                      display:none;
                }
                .dekstopni .woocommerce-message {
                        font-size: 12px !important;
                        padding: 8px 10px 6px 10px !important;
                        border: none !important;
                         border-radius: 3px  !important;
                        
                }
                .dekstopni .woocommerce-message:before {
                      display:none;
                }
                
                
                
                
        		
        		.coupon-code-section .form-row-first {
                        width: 77% !important;
                        float: left;
                        margin-right: 10px !important;
                        clear: none !important;
                        margin-bottom: 5px !important;
                        
                }
                
                .coupon-code-section .form-row-last {
                        width: 20% !important;
                        float: right;
                        margin-right: 0px !important;
                        clear: none !important;
                        margin-bottom: 5px !important;
                }
                
                
                 @media (max-width: 767px) {
                     
                        .coupon-code-section  .form-row input  {
                            font-size: 13px;
                             height: 40px;
                        }
                        
                        .coupon-code-section   .form-row button  {
                            font-size: 14px !important;
                             height: 40px !important;
                             width: 100%;
                        }
                     
                    	.coupon-code-section .form-row-first {
                                width: 68% !important;
                                 margin-right: 5px !important;
                        }
                     
                     
        		            .coupon-code-section .form-row-last {
        		                 width: 30% !important;
                                float: right !important;
                                  text-align: right !important;
                                  margin-left: 0px !important;
                            }
        		        }
                
                
                .coupon-code-section .apply-discount-button {
                        
                        border-radius: 4px;
                        letter-spacing: -0.1px;
                        /* font-family: 'Barlow', sans-serif; */
                        font-weight: 600;
                        font-size: 16px;
                        line-height: 1.318 !important;
                           border: 1px solid #dedede !important;
                }
                
                .cart-discount .woocommerce-remove-coupon {
                         display:none; 
                        color:black;
                }
                
                 .cart-discount td {
                        text-align: right !important;
                        font-weight: 400 !important;
                        font-size: 12px !important;
                        color: #11a664 !important;
                }
        		    
        		    
        		</style>
        		
        		<!--  
        		Kod za popust ili poklon kartica
        		-->
        		    
        		    
                    <section class="coupon-code-section">
                  <div class="checkout-coupon-inline">
                    <p class="form-row form-row-first">
                      <label for="coupon_code_inline" class="screen-reader-text">
                        <?php esc_html_e( 'Coupon:', 'woocommerce' ); ?>
                      </label>
                      <input type="text" id="coupon_code_inline" class="input-text"
                             placeholder="<?php esc_attr_e( 'Slevový kód nebo dárková karta', 'woocommerce' ); ?>" />
                    </p>
                
                    <p class="form-row form-row-last">
                      <button type="button" id="apply_coupon_inline" class="apply-discount-button button">
                        <?php esc_html_e( 'Apply', 'woocommerce' ); ?>
                      </button>
                    </p>
                
                    <div class="clear"></div>
                
                    <!-- Notification area -->
                  
                  </div>
                </section>
                
                 <div class="inline-coupon-notices dekstopni"></div>
                              
              
                   <script>
                    (function($){
                      var pendingNoticeHtml = '';
                      var lastTriedCode = '';
                    
                      function ensureNoticeTarget(){
                        var $t = $('.dekstopni');
                        if (!$t.length) {
                          var $anchor = $('.coupon-code-section .clear').last();
                          $t = $('<div class="inline-coupon-notices" aria-live="polite"></div>');
                          if ($anchor.length) { $t.insertAfter($anchor); }
                          else { $('.coupon-code-section').append($t); }
                        }
                        return $t;
                      }
                    
                      function setNotice(html){
                        pendingNoticeHtml = html || '';
                        ensureNoticeTarget().html(pendingNoticeHtml);
                      }
                    
                      function successHtml(){ return '<div class="woocommerce-message" role="alert">Kupon primijenjen.</div>'; }
                      function errorHtml(){   return '<ul class="woocommerce-error" role="alert"><li>Unesite važeći kod za popust ili poklon karticu.</li></ul>'; }
                    
                      // Mimic Woo's coupon class slug: lowercase, non a-z0-9 -> '-'
                      function couponClassFromCode(code){
                        return String(code || '')
                          .toLowerCase()
                          .replace(/[^a-z0-9]/g, '-')
                          .replace(/-+/g, '-')
                          .replace(/^-|-$/g, '');
                      }
                    
                      // After fragments refresh, verify if coupon is present in totals
                      $(document.body).on('updated_checkout', function(){
                        if (!lastTriedCode) return;
                    
                        var slug = couponClassFromCode(lastTriedCode);
                        var applied =
                          $('.cart-discount.coupon-' + slug).length > 0 ||
                          $('.cart-discount').filter(function(){
                            return $(this).text().toLowerCase().indexOf(lastTriedCode.toLowerCase()) !== -1;
                          }).length > 0;
                    
                        setNotice(applied ? successHtml() : errorHtml());
                      });
                    
                      $(document).on('click', '#apply_coupon_inline', function(e){
                        e.preventDefault();
                    
                        var code = $.trim($('#coupon_code_inline').val());
                        if (!code) return;
                    
                        lastTriedCode = code;       // remember which code we’re verifying
                        setNotice('');              // clear old notice
                    
                        var $btn = $(this).prop('disabled', true);
                    
                        // Build Woo AJAX URL + nonce
                        var ajaxUrl = (typeof wc_checkout_params !== 'undefined' && wc_checkout_params.wc_ajax_url)
                          ? wc_checkout_params.wc_ajax_url
                          : (typeof wc_cart_params !== 'undefined' && wc_cart_params.wc_ajax_url ? wc_cart_params.wc_ajax_url : window.location.href);
                        ajaxUrl = ajaxUrl.replace('%%endpoint%%', 'apply_coupon');
                    
                        var nonce =
                          (typeof wc_checkout_params !== 'undefined' && wc_checkout_params.apply_coupon_nonce) ?
                            wc_checkout_params.apply_coupon_nonce :
                          (typeof wc_cart_params !== 'undefined' && wc_cart_params.apply_coupon_nonce) ?
                            wc_cart_params.apply_coupon_nonce :
                            '';
                    
                        $.post(ajaxUrl, { coupon_code: code, security: nonce })
                          .always(function(){
                            // Whether success or error, let Woo refresh totals,
                            // then our updated_checkout handler will show the correct notice.
                            $(document.body).trigger('applied_coupon', [code]);
                            $(document.body).trigger('update_checkout');
                            $btn.prop('disabled', false);
                          });
                      });
                    
                      // Ensure notice container exists initially
                      $(ensureNoticeTarget);
                    })(jQuery);
                    </script>
                                                    		    
        		    
        		    
                	<?php do_action( 'woocommerce_checkout_after_order_review' ); ?>
	
	
                
                  <style>

                
                    .trust-section {
                      max-width: 100%;
                      margin: 0 auto;
                      margin-top: 30px;
                    }
                
                    .trust-header {
                      display: flex;
                      align-items: center;
                      gap: 8px;
                      font-weight: bold;
                      font-size: 16px;
                        margin-top: 25px;
                      margin-bottom: 20px;
                    }
                
                    .trust-header img {
                      height: 20px;
                    }
                
                    .reviews {
                      display: flex;
                      gap: 16px;
                     
                      margin-bottom: 20px;
                    }
                
                    .review-card {
                      flex: 1;
                      background: #fff;
                      border: 1px solid #ddd;
                      border-radius: 8px;
                      padding: 16px;
                      box-shadow: 0 2px 4px rgba(0,0,0,0.04);
                    }
                
                    .review-stars {
                      margin-bottom: 12px;
                    }
                
                    .review-title {
                      font-weight: bold;
                      margin-bottom: 8px;
                    }
                
                    .review-text {
                      font-size: 14px;
                      line-height: 1.5;
                      margin-bottom: 12px;
                    }
                
                    .review-author {
                      font-weight: bold;
                      font-size: 13px;
                    }
                
                    .features {
                      display: flex;
                      flex-direction: column;
                      gap: 20px;
                    }
                
                    .feature {
                      display: flex;
                      align-items: flex-start;
                      gap: 16px;
                    }
                
                    .feature-icon {
                      flex-shrink: 0;
                      width: 28px;
                      height: 28px;
                    }
                
                    .feature-content {
                      max-width: 540px;
                    }
                
                    .feature-title {
                      font-weight: bold;
                      margin-bottom: 4px;
                      text-transform: uppercase;
                      font-size: 13px;
                    }
                
                    .feature-text {
                      font-size: 14px;
                      line-height: 1.4;
                      color: #333;
                    }
                  </style>
                
                
                
                  <section class="trust-section">
                  
                  
                    <!-- Feature List -->
                    <div class="features">
                      <div class="feature">
                        <img src="<?php echo get_field("footer_top_icon_1","options"); ?>" alt="shirt icon" class="feature-icon">
                        <div class="feature-content">
                          <div class="feature-title"><?php echo get_field("footer_top_heading_1","options"); ?></div>
                          <div class="feature-text"><?php echo get_field("footer_top_text_1","options"); ?></div>
                        </div>
                      </div>
                
                      <div class="feature">
                        <img src="<?php echo get_field("footer_top_icon_2","options"); ?>" alt="support icon" class="feature-icon">
                        <div class="feature-content">
                          <div class="feature-title"><?php echo get_field("footer_top_heading_2","options"); ?></div>
                          <div class="feature-text"><?php echo get_field("footer_top_text_2","options"); ?></div>
                        </div>
                      </div>
                
                      <div class="feature">
                        <img src="<?php echo get_field("footer_top_icon_3","options"); ?>" alt="shipping icon" class="feature-icon">
                        <div class="feature-content">
                          <div class="feature-title"><?php echo get_field("footer_top_heading_3","options"); ?></div>
                          <div class="feature-text"><?php echo get_field("footer_top_text_3","options"); ?></div>
                        </div>
                      </div>
                    </div>
                  
                    <!-- Trustpilot Badge -->
                    <div class="trust-header">
                      <span><?php echo get_field("checkout_option_review_t1","options"); ?></span>
                      <img src="<?php echo get_field("checkout_option_review_img1","options"); ?>" alt="Trustpilot" style="height: 18px;">
                    </div>
                
                    <!-- Reviews -->
                    <div class="reviews">
                      <div class="review-card">
                        <div class="review-stars">
                          <img  src="<?php echo get_field("checkout_option_review_img1","options"); ?>"  alt="5 stars" height="14">
                        </div>
                        <div class="review-title"><?php echo get_field("checkout_option_review_r1_1","options"); ?></div>
                        <div class="review-text">
                        <?php echo get_field("checkout_option_review_r1_2","options"); ?>
                        </div>
                        <div class="review-author"><?php echo get_field("checkout_option_review_r1_3","options"); ?></div>
                      </div>
                
                      <div class="review-card">
                        <div class="review-stars">
                          <img  src="<?php echo get_field("checkout_option_review_img1","options"); ?>"  alt="5 stars" height="14">
                        </div>
                        <div class="review-title"><?php echo get_field("checkout_option_review_r2_1","options"); ?></div>
                        <div class="review-text">
                         <?php echo get_field("checkout_option_review_r2_2","options"); ?>
                        </div>
                        <div class="review-author"><?php echo get_field("checkout_option_review_r3_2","options"); ?></div>
                      </div>
                    </div>
                
                  
                  </section>
                

        		        
        		        
        		    
        		</div>
        		<!-- just some content -->
        		
        		
        	</div>

    </div>




</form>

</div>

</section>

<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>
