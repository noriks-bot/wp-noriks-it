<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package storefront
 */

?>

		</div><!-- .col-full -->
	</div><!-- #content -->
	
	
	
<!-- suport section -->
	
	<section class="info-banner">
	     <div class="info-items-container">
  <div class="info-item">
    <img src="<?php echo get_field("footer_top_icon_1","option"); ?>" alt="Shirt Icon" class="info-icon">
    <h3><?php echo get_field("footer_top_heading_1", "option"); ?></h3>
    <p><?php echo get_field("footer_top_text_1", "option"); ?></p>
  </div>
  <div style="" class="info-item">
    <img src="<?php echo get_field("footer_top_icon_2","option"); ?>" alt="Customer Support Icon" class="info-icon">
    <h3><?php echo get_field("footer_top_heading_2", "option"); ?></h3>
    <p><?php echo get_field("footer_top_text_2", "option"); ?></p>
    
    
  </div>
  <div style="" class="info-item">
    <img src="<?php echo get_field("footer_top_icon_3","option"); ?>" alt="Shipping Icon" class="info-icon">
    <h3><?php echo get_field("footer_top_heading_3", "option"); ?></h3>
    <p><?php echo get_field("footer_top_text_3", "option"); ?></p>
  </div>
  </div>
</section>
	
	
<style>

.phone-footer-checkout {
    
text-align: left;
    justify-content: center;
}

.info-items-container {
 max-width: 1800px;
    margin: 0 auto;
    padding-left: 0px;
    padding-right: 0px;
 display: flex;
  justify-content: space-between;
  background-color: #f4f4f4;
  padding: 40px 20px 40px 20px;
}
    
    .info-banner {

  background-color: #f4f4f4;
}

.info-item {
  flex: 1;
  text-align: center;
  padding: 0 20px 0 20px;
  border-right: 1px solid #ddd;
  margin-bottom: 10px;
}

.info-item:last-child {
  border-right: none;
}

.info-icon {
  width: 50px;
 margin:0 auto;
 display: block;
  margin-bottom: 10px;
}

.info-item h3 {
  font-size: 1.25rem;
  font-weight: 700;
  color: #222223;
  margin-bottom: 10px;
}

.info-item p {
  font-size: 1rem;
  color: #333;
  margin: 0;
}


@media (max-width: 768px) {
    
    .info-items-container {
 flex-direction: column;
    align-items: center; /* optional: centers items horizontally */
}
    
    .info-item {

  border-right: none;
}
}

@media (max-width: 991px) {
    
    
.footer-brand-dec {
        padding-right:50px !important;

}}
</style>








<!-- suport section -->	
	

	<?php do_action( 'storefront_before_footer' ); ?>
	
	
	<footer class="footer">
	    
	    
	    			<?php
			/**
			 * Functions hooked in to storefront_footer action
			 *
			 * @hooked storefront_footer_widgets - 10
			 * @hooked storefront_credit         - 20
			 */
			//do_action( 'storefront_footer' );
			?>
	    
	    
  <div style="display:none;" class="footer-top">
    <h2 style="display: inline; color: white; "class="footer-slogan"><?php echo get_field("footer_midle_socialtext", "option"); ?></h2>
   
   
   <ul style="display: inline; " class="social-icons inline-list justify-content-center" role="list">
       
       <?php 
       $social_links = get_field("social_list","options");
       //var_dump($social_links);
       ?>
       
       <?php if($social_links): ?>
       <?php foreach( $social_links as $item ): ?>
       
       <li role="listitem">
           
            <a target="_blank" rel="noreferrer noopener" href="<?php echo $item['link']; ?>" title="">
            <img src="<?php echo $item['icon']; ?>">
            </a>
            
       </li>
       
       <?php endforeach; ?>
       <?php endif; ?>
        
        </ul>
  </div>

  <div class="footer-main">
      
  <div class="footer-container">
  <div class="footer-row">
    
    
    
    <!-- Column 1: Newsletter (larger) -->
    <!-- Column 2: More Info -->
    <div class="footer-col">
      <div class="link-section">

        <a style="margin-top:-10px;" href="https://devhr.noriks.com?dsd33">
        <span style="color: white; font-family: 'Roboto', sans-serif; font-size: 33px; font-weight: bold; letter-spacing: 1.75px;">NORIKS</span>
       
      </a>
        
              <p class="footer-brand-dec" style="padding-right: 100px; font-size:12px;" >NORIKS vznikl, aby vyřešil jednoduchý, ale často přehlížený problém: většina mužů nemá oblečení, které jim opravdu sedí. Z frustrace z krátkých, úzkých a špatně střižených základních kousků navrhuje NORIKS nadčasové oblečení pro silnější postavu – delší, pohodlnější a promyšlené tam, kde je to nejdůležitější.
</p>
      </div>
    </div>
    
    

    <!-- Column 2: More Info -->
    <div class="footer-col">
      <div class="link-section">
        <h4><?php echo get_field("footer_midle_col2_header", "option"); ?></h4>
        
         <?php 
            $col2_links = get_field("footer_midle_col2_links", "option");
          ?>
        
              <?php if ($col2_links): ?>
            <?php foreach ($col2_links as $item): ?>
        
                      <a href="<?php echo $item['link']; ?>"><?php echo $item['text']; ?></a>
 
                <?php endforeach; ?>
        <?php endif; ?>
      </div>
    </div>

    <!-- Column 3: Support -->
    <div class="footer-col">
      <div class="link-section">
        <h4><?php echo get_field("footer_midle_col3_header", "option"); ?></h4>
        
             <?php 
            $col3_links = get_field("footer_midle_col3_links", "option");
          ?>
            
        
          <?php if ($col3_links): ?>
            <?php foreach ($col3_links as $item): ?>
        
                      <a href="<?php echo $item['link']; ?>"><?php echo $item['text']; ?></a>
 
                <?php endforeach; ?>
        <?php endif; ?>
        
      </div>
    </div>

    <!-- Column 4: Company Details -->
    <div class="footer-col">
      <div class="link-section">
        <h4><?php echo get_field("footer_midle_col4_header", "option"); ?></h4>
        
        <?php echo get_field("footer_midle_col4_content", "option"); ?>
        
      </div>
    </div>

  </div>
</div>
  

  
    
    
    
  </div>

  <div style="display:none;" class="footer-bottom">
    <p style="display: inline;
    text-align: left; color: white;
    float: left;">Copyright © 2025 NORIKS BRAND</p>
<div style="display: inline;
    float: right;" class="payment-icons">
    <ul class="inline-list justify-content-center justify-content-md-end">
    
      <li><svg class="payment-icon" xmlns="http://www.w3.org/2000/svg" role="img" aria-labelledby="pi-american_express" viewBox="0 0 38 24" width="38" height="24"><title id="pi-american_express">American Express</title><path fill="#000" d="M35 0H3C1.3 0 0 1.3 0 3v18c0 1.7 1.4 3 3 3h32c1.7 0 3-1.3 3-3V3c0-1.7-1.4-3-3-3Z" opacity=".07"></path><path fill="#006FCF" d="M35 1c1.1 0 2 .9 2 2v18c0 1.1-.9 2-2 2H3c-1.1 0-2-.9-2-2V3c0-1.1.9-2 2-2h32Z"></path><path fill="#FFF" d="M22.012 19.936v-8.421L37 11.528v2.326l-1.732 1.852L37 17.573v2.375h-2.766l-1.47-1.622-1.46 1.628-9.292-.02Z"></path><path fill="#006FCF" d="M23.013 19.012v-6.57h5.572v1.513h-3.768v1.028h3.678v1.488h-3.678v1.01h3.768v1.531h-5.572Z"></path><path fill="#006FCF" d="m28.557 19.012 3.083-3.289-3.083-3.282h2.386l1.884 2.083 1.89-2.082H37v.051l-3.017 3.23L37 18.92v.093h-2.307l-1.917-2.103-1.898 2.104h-2.321Z"></path><path fill="#FFF" d="M22.71 4.04h3.614l1.269 2.881V4.04h4.46l.77 2.159.771-2.159H37v8.421H19l3.71-8.421Z"></path><path fill="#006FCF" d="m23.395 4.955-2.916 6.566h2l.55-1.315h2.98l.55 1.315h2.05l-2.904-6.566h-2.31Zm.25 3.777.875-2.09.873 2.09h-1.748Z"></path><path fill="#006FCF" d="M28.581 11.52V4.953l2.811.01L32.84 9l1.456-4.046H37v6.565l-1.74.016v-4.51l-1.644 4.494h-1.59L30.35 7.01v4.51h-1.768Z"></path></svg>
</li><li><svg class="payment-icon" version="1.1" xmlns="http://www.w3.org/2000/svg" role="img" x="0" y="0" width="38" height="24" viewBox="0 0 165.521 105.965" xml:space="preserve" aria-labelledby="pi-apple_pay"><title id="pi-apple_pay">Apple Pay</title><path fill="#000" d="M150.698 0H14.823c-.566 0-1.133 0-1.698.003-.477.004-.953.009-1.43.022-1.039.028-2.087.09-3.113.274a10.51 10.51 0 0 0-2.958.975 9.932 9.932 0 0 0-4.35 4.35 10.463 10.463 0 0 0-.975 2.96C.113 9.611.052 10.658.024 11.696a70.22 70.22 0 0 0-.022 1.43C0 13.69 0 14.256 0 14.823v76.318c0 .567 0 1.132.002 1.699.003.476.009.953.022 1.43.028 1.036.09 2.084.275 3.11a10.46 10.46 0 0 0 .974 2.96 9.897 9.897 0 0 0 1.83 2.52 9.874 9.874 0 0 0 2.52 1.83c.947.483 1.917.79 2.96.977 1.025.183 2.073.245 3.112.273.477.011.953.017 1.43.02.565.004 1.132.004 1.698.004h135.875c.565 0 1.132 0 1.697-.004.476-.002.952-.009 1.431-.02 1.037-.028 2.085-.09 3.113-.273a10.478 10.478 0 0 0 2.958-.977 9.955 9.955 0 0 0 4.35-4.35c.483-.947.789-1.917.974-2.96.186-1.026.246-2.074.274-3.11.013-.477.02-.954.022-1.43.004-.567.004-1.132.004-1.699V14.824c0-.567 0-1.133-.004-1.699a63.067 63.067 0 0 0-.022-1.429c-.028-1.038-.088-2.085-.274-3.112a10.4 10.4 0 0 0-.974-2.96 9.94 9.94 0 0 0-4.35-4.35A10.52 10.52 0 0 0 156.939.3c-1.028-.185-2.076-.246-3.113-.274a71.417 71.417 0 0 0-1.431-.022C151.83 0 151.263 0 150.698 0z"></path><path fill="#FFF" d="M150.698 3.532l1.672.003c.452.003.905.008 1.36.02.793.022 1.719.065 2.583.22.75.135 1.38.34 1.984.648a6.392 6.392 0 0 1 2.804 2.807c.306.6.51 1.226.645 1.983.154.854.197 1.783.218 2.58.013.45.019.9.02 1.36.005.557.005 1.113.005 1.671v76.318c0 .558 0 1.114-.004 1.682-.002.45-.008.9-.02 1.35-.022.796-.065 1.725-.221 2.589a6.855 6.855 0 0 1-.645 1.975 6.397 6.397 0 0 1-2.808 2.807c-.6.306-1.228.511-1.971.645-.881.157-1.847.2-2.574.22-.457.01-.912.017-1.379.019-.555.004-1.113.004-1.669.004H14.801c-.55 0-1.1 0-1.66-.004a74.993 74.993 0 0 1-1.35-.018c-.744-.02-1.71-.064-2.584-.22a6.938 6.938 0 0 1-1.986-.65 6.337 6.337 0 0 1-1.622-1.18 6.355 6.355 0 0 1-1.178-1.623 6.935 6.935 0 0 1-.646-1.985c-.156-.863-.2-1.788-.22-2.578a66.088 66.088 0 0 1-.02-1.355l-.003-1.327V14.474l.002-1.325a66.7 66.7 0 0 1 .02-1.357c.022-.792.065-1.717.222-2.587a6.924 6.924 0 0 1 .646-1.981c.304-.598.7-1.144 1.18-1.623a6.386 6.386 0 0 1 1.624-1.18 6.96 6.96 0 0 1 1.98-.646c.865-.155 1.792-.198 2.586-.22.452-.012.905-.017 1.354-.02l1.677-.003h135.875"></path><g><g><path fill="#000" d="M43.508 35.77c1.404-1.755 2.356-4.112 2.105-6.52-2.054.102-4.56 1.355-6.012 3.112-1.303 1.504-2.456 3.959-2.156 6.266 2.306.2 4.61-1.152 6.063-2.858"></path><path fill="#000" d="M45.587 39.079c-3.35-.2-6.196 1.9-7.795 1.9-1.6 0-4.049-1.8-6.698-1.751-3.447.05-6.645 2-8.395 5.1-3.598 6.2-.95 15.4 2.55 20.45 1.699 2.5 3.747 5.25 6.445 5.151 2.55-.1 3.549-1.65 6.647-1.65 3.097 0 3.997 1.65 6.696 1.6 2.798-.05 4.548-2.5 6.247-5 1.95-2.85 2.747-5.6 2.797-5.75-.05-.05-5.396-2.101-5.446-8.251-.05-5.15 4.198-7.6 4.398-7.751-2.399-3.548-6.147-3.948-7.447-4.048"></path></g><g><path fill="#000" d="M78.973 32.11c7.278 0 12.347 5.017 12.347 12.321 0 7.33-5.173 12.373-12.529 12.373h-8.058V69.62h-5.822V32.11h14.062zm-8.24 19.807h6.68c5.07 0 7.954-2.729 7.954-7.46 0-4.73-2.885-7.434-7.928-7.434h-6.706v14.894z"></path><path fill="#000" d="M92.764 61.847c0-4.809 3.665-7.564 10.423-7.98l7.252-.442v-2.08c0-3.04-2.001-4.704-5.562-4.704-2.938 0-5.07 1.507-5.51 3.82h-5.252c.157-4.86 4.731-8.395 10.918-8.395 6.654 0 10.995 3.483 10.995 8.89v18.663h-5.38v-4.497h-.13c-1.534 2.937-4.914 4.782-8.579 4.782-5.406 0-9.175-3.222-9.175-8.057zm17.675-2.417v-2.106l-6.472.416c-3.64.234-5.536 1.585-5.536 3.95 0 2.288 1.975 3.77 5.068 3.77 3.95 0 6.94-2.522 6.94-6.03z"></path><path fill="#000" d="M120.975 79.652v-4.496c.364.051 1.247.103 1.715.103 2.573 0 4.029-1.09 4.913-3.899l.52-1.663-9.852-27.293h6.082l6.863 22.146h.13l6.862-22.146h5.927l-10.216 28.67c-2.34 6.577-5.017 8.735-10.683 8.735-.442 0-1.872-.052-2.261-.157z"></path></g></g></svg>
</li><li><svg class="payment-icon" xmlns="http://www.w3.org/2000/svg" role="img" width="38" height="24" viewBox="0 0 38 24" aria-labelledby="pi-klarna"><title id="pi-klarna">Klarna</title><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><path d="M35 0H3C1.3 0 0 1.3 0 3v18c0 1.7 1.4 3 3 3h32c1.7 0 3-1.3 3-3V3c0-1.7-1.4-3-3-3z" fill="#FFB3C7"></path><path d="M35 1c1.1 0 2 .9 2 2v18c0 1.1-.9 2-2 2H3c-1.1 0-2-.9-2-2V3c0-1.1.9-2 2-2h32" fill="#FFB3C7"></path><path d="M34.117 13.184c-.487 0-.882.4-.882.892 0 .493.395.893.882.893.488 0 .883-.4.883-.893a.888.888 0 00-.883-.892zm-2.903-.69c0-.676-.57-1.223-1.274-1.223-.704 0-1.274.547-1.274 1.222 0 .675.57 1.223 1.274 1.223.704 0 1.274-.548 1.274-1.223zm.005-2.376h1.406v4.75h-1.406v-.303a2.446 2.446 0 01-1.394.435c-1.369 0-2.478-1.122-2.478-2.507 0-1.384 1.11-2.506 2.478-2.506.517 0 .996.16 1.394.435v-.304zm-11.253.619v-.619h-1.44v4.75h1.443v-2.217c0-.749.802-1.15 1.359-1.15h.016v-1.382c-.57 0-1.096.247-1.378.618zm-3.586 1.756c0-.675-.57-1.222-1.274-1.222-.703 0-1.274.547-1.274 1.222 0 .675.57 1.223 1.274 1.223.704 0 1.274-.548 1.274-1.223zm.005-2.375h1.406v4.75h-1.406v-.303A2.446 2.446 0 0114.99 15c-1.368 0-2.478-1.122-2.478-2.507 0-1.384 1.11-2.506 2.478-2.506.517 0 .997.16 1.394.435v-.304zm8.463-.128c-.561 0-1.093.177-1.448.663v-.535H22v4.75h1.417v-2.496c0-.722.479-1.076 1.055-1.076.618 0 .973.374.973 1.066v2.507h1.405v-3.021c0-1.106-.87-1.858-2.002-1.858zM10.465 14.87h1.472V8h-1.472v6.868zM4 14.87h1.558V8H4v6.87zM9.45 8a5.497 5.497 0 01-1.593 3.9l2.154 2.97H8.086l-2.341-3.228.604-.458A3.96 3.96 0 007.926 8H9.45z" fill="#0A0B09" fill-rule="nonzero"></path></g></svg></li><li><svg class="payment-icon" viewBox="0 0 38 24" xmlns="http://www.w3.org/2000/svg" width="38" height="24" role="img" aria-labelledby="pi-maestro"><title id="pi-maestro">Maestro</title><path opacity=".07" d="M35 0H3C1.3 0 0 1.3 0 3v18c0 1.7 1.4 3 3 3h32c1.7 0 3-1.3 3-3V3c0-1.7-1.4-3-3-3z"></path><path fill="#fff" d="M35 1c1.1 0 2 .9 2 2v18c0 1.1-.9 2-2 2H3c-1.1 0-2-.9-2-2V3c0-1.1.9-2 2-2h32"></path><circle fill="#EB001B" cx="15" cy="12" r="7"></circle><circle fill="#00A2E5" cx="23" cy="12" r="7"></circle><path fill="#7375CF" d="M22 12c0-2.4-1.2-4.5-3-5.7-1.8 1.3-3 3.4-3 5.7s1.2 4.5 3 5.7c1.8-1.2 3-3.3 3-5.7z"></path></svg></li><li><svg class="payment-icon" viewBox="0 0 38 24" xmlns="http://www.w3.org/2000/svg" role="img" width="38" height="24" aria-labelledby="pi-master"><title id="pi-master">Mastercard</title><path opacity=".07" d="M35 0H3C1.3 0 0 1.3 0 3v18c0 1.7 1.4 3 3 3h32c1.7 0 3-1.3 3-3V3c0-1.7-1.4-3-3-3z"></path><path fill="#fff" d="M35 1c1.1 0 2 .9 2 2v18c0 1.1-.9 2-2 2H3c-1.1 0-2-.9-2-2V3c0-1.1.9-2 2-2h32"></path><circle fill="#EB001B" cx="15" cy="12" r="7"></circle><circle fill="#F79E1B" cx="23" cy="12" r="7"></circle><path fill="#FF5F00" d="M22 12c0-2.4-1.2-4.5-3-5.7-1.8 1.3-3 3.4-3 5.7s1.2 4.5 3 5.7c1.8-1.2 3-3.3 3-5.7z"></path></svg></li><li><svg class="payment-icon" viewBox="0 0 38 24" xmlns="http://www.w3.org/2000/svg" width="38" height="24" role="img" aria-labelledby="pi-paypal"><title id="pi-paypal">PayPal</title><path opacity=".07" d="M35 0H3C1.3 0 0 1.3 0 3v18c0 1.7 1.4 3 3 3h32c1.7 0 3-1.3 3-3V3c0-1.7-1.4-3-3-3z"></path><path fill="#fff" d="M35 1c1.1 0 2 .9 2 2v18c0 1.1-.9 2-2 2H3c-1.1 0-2-.9-2-2V3c0-1.1.9-2 2-2h32"></path><path fill="#003087" d="M23.9 8.3c.2-1 0-1.7-.6-2.3-.6-.7-1.7-1-3.1-1h-4.1c-.3 0-.5.2-.6.5L14 15.6c0 .2.1.4.3.4H17l.4-3.4 1.8-2.2 4.7-2.1z"></path><path fill="#3086C8" d="M23.9 8.3l-.2.2c-.5 2.8-2.2 3.8-4.6 3.8H18c-.3 0-.5.2-.6.5l-.6 3.9-.2 1c0 .2.1.4.3.4H19c.3 0 .5-.2.5-.4v-.1l.4-2.4v-.1c0-.2.3-.4.5-.4h.3c2.1 0 3.7-.8 4.1-3.2.2-1 .1-1.8-.4-2.4-.1-.5-.3-.7-.5-.8z"></path><path fill="#012169" d="M23.3 8.1c-.1-.1-.2-.1-.3-.1-.1 0-.2 0-.3-.1-.3-.1-.7-.1-1.1-.1h-3c-.1 0-.2 0-.2.1-.2.1-.3.2-.3.4l-.7 4.4v.1c0-.3.3-.5.6-.5h1.3c2.5 0 4.1-1 4.6-3.8v-.2c-.1-.1-.3-.2-.5-.2h-.1z"></path></svg></li><li><svg class="payment-icon" xmlns="http://www.w3.org/2000/svg" role="img" viewBox="0 0 38 24" width="38" height="24" aria-labelledby="pi-shopify_pay"><title id="pi-shopify_pay">Shop Pay</title><path opacity=".07" d="M35 0H3C1.3 0 0 1.3 0 3v18c0 1.7 1.4 3 3 3h32c1.7 0 3-1.3 3-3V3c0-1.7-1.4-3-3-3z" fill="#000"></path><path d="M35.889 0C37.05 0 38 .982 38 2.182v19.636c0 1.2-.95 2.182-2.111 2.182H2.11C.95 24 0 23.018 0 21.818V2.182C0 .982.95 0 2.111 0H35.89z" fill="#5A31F4"></path><path d="M9.35 11.368c-1.017-.223-1.47-.31-1.47-.705 0-.372.306-.558.92-.558.54 0 .934.238 1.225.704a.079.079 0 00.104.03l1.146-.584a.082.082 0 00.032-.114c-.475-.831-1.353-1.286-2.51-1.286-1.52 0-2.464.755-2.464 1.956 0 1.275 1.15 1.597 2.17 1.82 1.02.222 1.474.31 1.474.705 0 .396-.332.582-.993.582-.612 0-1.065-.282-1.34-.83a.08.08 0 00-.107-.035l-1.143.57a.083.083 0 00-.036.111c.454.92 1.384 1.437 2.627 1.437 1.583 0 2.539-.742 2.539-1.98s-1.155-1.598-2.173-1.82v-.003zM15.49 8.855c-.65 0-1.224.232-1.636.646a.04.04 0 01-.069-.03v-2.64a.08.08 0 00-.08-.081H12.27a.08.08 0 00-.08.082v8.194a.08.08 0 00.08.082h1.433a.08.08 0 00.081-.082v-3.594c0-.695.528-1.227 1.239-1.227.71 0 1.226.521 1.226 1.227v3.594a.08.08 0 00.081.082h1.433a.08.08 0 00.081-.082v-3.594c0-1.51-.981-2.577-2.355-2.577zM20.753 8.62c-.778 0-1.507.24-2.03.588a.082.082 0 00-.027.109l.632 1.088a.08.08 0 00.11.03 2.5 2.5 0 011.318-.366c1.25 0 2.17.891 2.17 2.068 0 1.003-.736 1.745-1.669 1.745-.76 0-1.288-.446-1.288-1.077 0-.361.152-.657.548-.866a.08.08 0 00.032-.113l-.596-1.018a.08.08 0 00-.098-.035c-.799.299-1.359 1.018-1.359 1.984 0 1.46 1.152 2.55 2.76 2.55 1.877 0 3.227-1.313 3.227-3.195 0-2.018-1.57-3.492-3.73-3.492zM28.675 8.843c-.724 0-1.373.27-1.845.746-.026.027-.069.007-.069-.029v-.572a.08.08 0 00-.08-.082h-1.397a.08.08 0 00-.08.082v8.182a.08.08 0 00.08.081h1.433a.08.08 0 00.081-.081v-2.683c0-.036.043-.054.069-.03a2.6 2.6 0 001.808.7c1.682 0 2.993-1.373 2.993-3.157s-1.313-3.157-2.993-3.157zm-.271 4.929c-.956 0-1.681-.768-1.681-1.783s.723-1.783 1.681-1.783c.958 0 1.68.755 1.68 1.783 0 1.027-.713 1.783-1.681 1.783h.001z" fill="#fff"></path></svg>
</li><li><svg class="payment-icon" viewBox="0 0 38 24" xmlns="http://www.w3.org/2000/svg" role="img" width="38" height="24" aria-labelledby="pi-visa"><title id="pi-visa">Visa</title><path opacity=".07" d="M35 0H3C1.3 0 0 1.3 0 3v18c0 1.7 1.4 3 3 3h32c1.7 0 3-1.3 3-3V3c0-1.7-1.4-3-3-3z"></path><path fill="#fff" d="M35 1c1.1 0 2 .9 2 2v18c0 1.1-.9 2-2 2H3c-1.1 0-2-.9-2-2V3c0-1.1.9-2 2-2h32"></path><path d="M28.3 10.1H28c-.4 1-.7 1.5-1 3h1.9c-.3-1.5-.3-2.2-.6-3zm2.9 5.9h-1.7c-.1 0-.1 0-.2-.1l-.2-.9-.1-.2h-2.4c-.1 0-.2 0-.2.2l-.3.9c0 .1-.1.1-.1.1h-2.1l.2-.5L27 8.7c0-.5.3-.7.8-.7h1.5c.1 0 .2 0 .2.2l1.4 6.5c.1.4.2.7.2 1.1.1.1.1.1.1.2zm-13.4-.3l.4-1.8c.1 0 .2.1.2.1.7.3 1.4.5 2.1.4.2 0 .5-.1.7-.2.5-.2.5-.7.1-1.1-.2-.2-.5-.3-.8-.5-.4-.2-.8-.4-1.1-.7-1.2-1-.8-2.4-.1-3.1.6-.4.9-.8 1.7-.8 1.2 0 2.5 0 3.1.2h.1c-.1.6-.2 1.1-.4 1.7-.5-.2-1-.4-1.5-.4-.3 0-.6 0-.9.1-.2 0-.3.1-.4.2-.2.2-.2.5 0 .7l.5.4c.4.2.8.4 1.1.6.5.3 1 .8 1.1 1.4.2.9-.1 1.7-.9 2.3-.5.4-.7.6-1.4.6-1.4 0-2.5.1-3.4-.2-.1.2-.1.2-.2.1zm-3.5.3c.1-.7.1-.7.2-1 .5-2.2 1-4.5 1.4-6.7.1-.2.1-.3.3-.3H18c-.2 1.2-.4 2.1-.7 3.2-.3 1.5-.6 3-1 4.5 0 .2-.1.2-.3.2M5 8.2c0-.1.2-.2.3-.2h3.4c.5 0 .9.3 1 .8l.9 4.4c0 .1 0 .1.1.2 0-.1.1-.1.1-.1l2.1-5.1c-.1-.1 0-.2.1-.2h2.1c0 .1 0 .1-.1.2l-3.1 7.3c-.1.2-.1.3-.2.4-.1.1-.3 0-.5 0H9.7c-.1 0-.2 0-.2-.2L7.9 9.5c-.2-.2-.5-.5-.9-.6-.6-.3-1.7-.5-1.9-.5L5 8.2z" fill="#142688"></path></svg></li></ul>
  </div>
  </div>
</footer>

<style>

.social-icons svg {
   width: 20px;
   height: 20px;
   color: white;
}

.footer {
  background-color: black;
  color: white;
  padding: 40px 20px 80px 20px;
  font-family: 'Inter', sans-serif;
}

.footer-top {
  text-align: center;
  margin-bottom: 30px;
  border-bottom: 1px solid white;
  padding-bottom: 33px;
}

.footer-slogan {
  font-size: 18px;
  font-weight: 800;
  margin-bottom: 10px;
      margin-right: 6px;
   color: white !important;
}

.social-icons img {
width: 22px;
    height: 22px;
    margin: 0 2px;
    vertical-align: sub;
    display: inline-block;
}

.footer-main {
  display: flex;
  flex-wrap: wrap;
  justify-content: space-between;
  margin-top: 30px;
}

.newsletter {
  flex: 1;
padding-right: 100px;
  margin-bottom: 40px;
  color: white !important;
}

.newsletter h3 {
  font-size: 20px;
  font-weight: 800;
  color: white;
  margin-bottom: 10px;
   color: white !important;
}

.newsletter p {
  font-size: 15px;
  margin-bottom: 20px; color: white !important;
}

.newsletter input {
  width: 100%;
  padding: 12px 15px;
  margin-bottom: 15px;
  border: none;
  border-radius: 6px;
  background: #27405F;
  color: white;
}

.newsletter input::placeholder {
  color: #b5c7da;
}

.subscribe-button {
  width: 100%;
  background: #496d8f !important;
  border: none;
  color: white;
  padding: 14px;
  font-size: 16px;
  font-weight: 500;
  border-radius: 6px;
  cursor: pointer;
  display: flex;
  justify-content: center;
  align-items: center;
}

.subscribe-button img {
  width: 18px;
  margin-right: 8px;
}

.footer-links {
  display: flex;
  flex: 2;
  flex-wrap: wrap;
  gap: 50px;
}

.link-section {
  min-width: 150px;
}

.link-section h4 {
  font-size: 16px;
  font-weight: 800;
  margin-bottom: 12px;
  color: white;
  
}

.link-section a {
  display: block;
  font-size: 13px;
  color: white;
  text-decoration: none;
  margin-bottom: 0px;
   color: white !important;
}

.link-section a:hover {
  text-decoration: underline;
}

.link-section p {
  font-size: 14px;
  margin-bottom: 10px;
  line-height: 1.4;
   color: white !important;
}

.footer-bottom {
 border-top: 1px solid white;
    margin-top: -10px;
    padding-top: 40px;
    padding-left: 30px;
    padding-right: 80px;
    text-align: center;
    padding-bottom: 20px !important;
}

.footer-bottom p {
  font-size: 13px;
   color: white !important;
}

.payment-icons img {
  height: 28px;
  margin: 0 5px;
  vertical-align: middle;
}

.inline-list  {
list-style: none;
list-style-type: none;
margin: 0;
}

.inline-list li {
 display: inline;
}
.footer-container {
  max-width: 1800px;
  width: 100%;
  margin: 0 auto;
  padding: 60px 15px  80px 15px;
}

.footer-row {
  display: flex;
  flex-wrap: wrap;
  gap: 50px;
  justify-content: space-between;
}

.footer-col {
  flex: 1 1 220px; /* Default column */
  min-width: 220px;
}

.newsletter-col {
  flex: 2 1 450px; /* Newsletter is bigger */
}

.newsletter h3 {
  font-size: 20px;
  font-weight: 800;
  margin-bottom: 15px;
}

.newsletter p {
  font-size: 15px;
  margin-bottom: 20px;
}

.newsletter input {
  width: 100%;
  padding: 12px 15px;
  margin-bottom: 15px;
  border: none;
  border-radius: 0px;
  background: #27405F;
  color: white;
}

.newsletter input::placeholder {
  color: #b5c7da;
}

.subscribe-button {
  width: 100%;
  background: #496d8f !important;
  border: none;
  padding: 14px;
  font-size: 16px;
  font-weight: 600;
  color: white;
  border-radius: 0px;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
}

.subscribe-button img {
  width: 18px;
  margin-right: 8px;
}

.link-section h4 {
  font-size: 16px;
  font-weight: 800;
  margin-bottom: 15px;
}

.link-section a, 
.link-section p {
  display: block;
  font-size: 13px;
  margin-bottom: 0px;
  color: white;
  text-decoration: none;
}

.link-section a:hover {
  text-decoration: underline;
}

/* Mobile responsive */

@media (max-width: 768px) {
  .footer-row {
    flex-direction: column;
    align-items: center;
  }

  .footer-col, 
  .newsletter-col {
    width: 100%;
    text-align: left;
      flex: 2;
  }
  
  .newsletter{
       padding-right: 0;
       margin-bottom: 0;
  }
  
  .social-icons {
      display: block !important;
    margin-top: 20px !important;
  }
  
  .footer-container {
           padding: 0 0px 15px 0px;
    }
    
    .newsletter-col {
        flex: 2;
    }
    
    .footer-bottom {
    margin-top: 15px;
    }
    
    .payment-icons {
        display: none !important;
    }
  
    .footer-col {
       text-align:left;
    }
        .footer-col {
       text-align:left;
    }
        .footer-col {
       text-align:left;
    }
    
    .footer-bottom {
 
    padding-left: 7px;
    }
  
}

</style>




	<?php do_action( 'storefront_after_footer' ); ?>

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
