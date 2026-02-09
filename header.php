<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package storefront
 */

?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">


<?php wp_head(); ?>


<!-- SqualoMail Popup -->
<!--
<script type="text/javascript" src="https://6096.squalomail.net/forms/1/popup.js" async></script>
-->

<script>
document.addEventListener('DOMContentLoaded', function () {
  // Try to scope to the product summary if available; fall back to document
  const root = document.querySelector('.product form.cart') || document;

  const qtyInput = root.querySelector('input.qty');
  const insPrice = root.querySelector('p.price ins .amount bdi'); // sale price (discounted)
  const delPrice = root.querySelector('p.price del .amount bdi'); // regular price (strikethrough)

  // If any are missing, bail out quietly
  if (!qtyInput || !insPrice || !delPrice) return;

  // Helper: parse a localized CZK price out of a bdi’s text
  function parsePriceFromElement(el) {
    if (!el) return NaN;
    const raw = el.textContent || '';

    // Normalize:
    //  - remove spaces including NBSP (\u00A0) and narrow NBSP (\u202F)
    //  - keep digits, comma, dot, minus
    //  - convert decimal comma to dot
    const normalized = raw
      .replace(/[\u00A0\u202F\s]/g, '')      // remove all kinds of spaces
      .replace(/[^\d,.\-]/g, '')             // strip currency and other symbols
      .replace(',', '.');                    // decimal comma -> dot

    const num = parseFloat(normalized);
    return isNaN(num) ? NaN : num;
  }

  // Formatter for Czech koruna with 0 decimals
  const czk = new Intl.NumberFormat('cs-CZ', {
    style: 'currency',
    currency: 'CZK',
    minimumFractionDigits: 0,
    maximumFractionDigits: 0
  });

  function formatPrice(amount) {
    // Woo is set to 0 decimals; round to avoid 123.999 from FP math
    return czk.format(Math.round(amount));
  }

  // Get base unit prices once
  const baseSale = parsePriceFromElement(insPrice);
  const baseRegular = parsePriceFromElement(delPrice);

  if (isNaN(baseSale) || isNaN(baseRegular)) return;

  function getDiscount(qty) {
    if (qty === 2) return 0.05;
    if (qty >= 3 && qty < 9) return 0.10;
    if (qty >= 9 && qty < 12) return 0.20;
    if (qty >= 12) return 0.30;
    return 0;
  }

  function updatePrice() {
    const qty = parseInt(qtyInput.value, 10);
    if (isNaN(qty) || qty < 1) return;

    const totalRegular = baseRegular * qty;
    const discount = getDiscount(qty);

    const discountedUnit = baseSale * (1 - discount);
    const totalSale = discountedUnit * qty;

    // Write formatted totals back into <bdi>
    delPrice.textContent = formatPrice(totalRegular);
    insPrice.textContent = formatPrice(totalSale);
  }

  // Listen for quantity changes (typing and +/- buttons)
  qtyInput.addEventListener('input', updatePrice);
  qtyInput.addEventListener('change', updatePrice);

  // Fallback for other scripts changing the input’s value
  let lastQty = qtyInput.value;
  setInterval(() => {
    if (qtyInput.value !== lastQty) {
      lastQty = qtyInput.value;
      updatePrice();
    }
  }, 150);

  // Initial calculation
  updatePrice();
});
</script>






</head>

<body <?php body_class(); ?>>

<?php wp_body_open(); ?>

<?php do_action( 'storefront_before_site' ); ?>

<div id="page" class="hfeed site">
	<?php do_action( 'storefront_before_header' ); ?>
	
	
	
	<div class="top-header">
  <div class="marquee">
    <div class="marquee-content">
      <span><a href="/cz/shop">Doprava zdarma pro objednávky nad 1700 Kč</a></span>
      <span><a href="/cz/shop">30 dní bez rizika – vyzkoušej bez obav</a></span>
      <!--<span><a href="/hr/shop">Zimska ponuda: Do 70% popusta!</a></span>-->

      <!-- DUPLICATED for seamless infinite loop -->
      <span><a href="/cz/shop">Doprava zdarma pro objednávky nad 1700 Kč</a></span>
      <span><a href="/cz/shop">30 dní bez rizika – vyzkoušej bez obav</a></span>
     <!-- <span><a href="/hr/shop">Zimska ponuda: Do 70% popusta!</a></span>-->
      
       <!-- DUPLICATED for seamless infinite loop -->
      <span><a href="/cz/shop">Doprava zdarma pro objednávky nad 1700 Kč</a></span>
      <span><a href="/cz/shop">30 dní bez rizika – vyzkoušej bez obav</a></span>
     <!-- <span><a href="/hr/shop">Zimska ponuda: Do 70% popusta!</a></span>-->
    </div>
  </div>
</div>

<style>
.top-header {
  width: 100%;
  background: #d5d5d5;
  padding: 2px 0;
  overflow: hidden;
}

.marquee {
  width: 100%;
  overflow: hidden;
  white-space: nowrap;
  color: black;
}

.marquee-content {
  display: inline-flex;
  align-items: center;
   color: black;
  gap: 70px;
  animation: marqueeScroll 28s linear infinite; /* adjust speed here */
}

.marquee-content span {
  display: inline-block;
    color: black;
}

.marquee-content a {
  color: black;
  font-size: 13px;
  font-weight: normal;
  text-decoration: none;
    color: black;
    text-transform: uppercase;
}

/* Perfect infinite sliding with no jumps */
@keyframes marqueeScroll {
  0%   { transform: translateX(0); }
  100% { transform: translateX(-50%); }
}
</style>




	
	
	
	<header class="navbar header">
	    
	    	<?php
	    	
	    //	die();
		/**
		 * Functions hooked into storefront_header action
		 *
		 * @hooked storefront_header_container                 - 0
		 * @hooked storefront_skip_links                       - 5
		 * @hooked storefront_social_icons                     - 10
		 * @hooked storefront_site_branding                    - 20
		 * @hooked storefront_secondary_navigation             - 30
		 * @hooked storefront_product_search                   - 40
		 * @hooked storefront_header_container_close           - 41
		 * @hooked storefront_primary_navigation_wrapper       - 42
		 * @hooked storefront_primary_navigation               - 50
		 * @hooked storefront_header_cart                      - 60
		 * @hooked storefront_primary_navigation_wrapper_close - 68
		 */
		//do_action( 'storefront_header' );

?>


 <div class="container container-header">
     
      <!-- Hamburger Icon (Visible on mobile only) -->
    <div class="mobile-menu-toggle" onclick="toggleMobileMenu()">
      ☰
    </div>
     
     
    <div class="navbar-left">
      <a href="<?php echo get_home_url(); ?>">
        <span style="color: white; font-family: 'Roboto', sans-serif; font-size: 33px; font-weight: bold; letter-spacing: 1.75px;">NORIKS</span>
       
      </a>
    </div>

 
 
 

   <!-- Mobile + Desktop Navigation -->
<?php $header_nav = get_field("mainheader_menu", "option"); ?>
<nav class="navbar-center mobile-hidden" id="mobileMenu">
    <button class="mobile-menu-close mobile-only" onclick="toggleMobileMenu()">×</button>

    <?php if ($header_nav): ?>
        <?php $i = 0; ?>
        <?php foreach ($header_nav as $item): ?>
            <?php $link = $item['link']; $text = $item['text']; ?>


            <?php if ($i === 0): ?>
                <!-- FIRST ITEM WITH DROPDOWN -->
                <div class="nav-item has-dropdown">
                    <a href="<?php echo esc_url($link); ?>" class="nav-link">
                        <?php echo esc_html($text); ?>
                    </a>
                        
                    <!--
                    <div class="dropdown-menu">
                        <a href="/hr/shop">Sastavi svoj paket</a>
                        <a href="/hr/product-category/bundles/">Gotovi paketi</a>
                    </div>
                    -->
                </div>
                
            <?php elseif ($i === 1): ?>

                <div class="nav-item has-dropdown">
                    <a href="<?php echo esc_url($link); ?>" class="nav-link">
                        <?php echo esc_html($text); ?>
                    </a>
                    <!--
                    <div class="dropdown-menu">
                        <a href="/hr/product-category/bokserice-sastavi-paket/">Sastavi svoj paket</a>
                        <a href="/hr/product-category/bokserice/">Gotovi paketi</a>
                    </div>
                    -->
                </div>
                
            <?php else: ?>
                <!-- NORMAL ITEMS -->
                <a href="<?php echo esc_url($link); ?>" class="nav-link">
                    <?php echo esc_html($text); ?>
                </a>
            <?php endif; ?>

            <?php $i++; ?>
        <?php endforeach; ?>
    <?php endif; ?>


    <a class="mobile-only-menu-item" href="mailto:info@noriks.com" style="color: white;">
        <i class="fas fa-envelope" style="margin-right: 8px;"></i>info@noriks.com
    </a>

    <div class="language-selector mobile-only" onclick="openLanguageModal()">
        <img src="https://static.devit.software/countries/flags/rectangle/<?php echo get_field("webshop_icon", "options"); ?>" alt="" class="flag">
        <span><?php echo get_field("webshop_language", "options"); ?></span>
    </div>
</nav>



<style>

/*
    .navbar-center {
    display: flex;
    align-items: center;
    gap: 24px; 
}


.nav-item.has-dropdown {
    position: relative;
}


.nav-item.has-dropdown .dropdown-menu {
    position: absolute;
    top: 100%;
    left: 0;
    min-width: 180px;
    background: #ffffff;
    padding: 8px 0;
    border-radius: 0px;
    box-shadow: 0 8px 16px rgba(0,0,0,0.15);
    opacity: 0;
    visibility: hidden;
    transform: translateY(10px);
    transition: opacity 0.2s ease, transform 0.2s ease, visibility 0.2s ease;
    z-index: 1000;
    padding: 0;
    


}

.nav-item.has-dropdown .dropdown-menu a {
    display: block;
    padding: 8px 16px;
    white-space: nowrap;
    color: #000;  
    text-decoration: none;
    font-size: 15px;
    margin-left: 0;
    margin-right: 0;
}

.nav-item.has-dropdown .dropdown-menu a:hover {
    background: #d9d9d9;  
    text-decoration: none;
}


.nav-item.has-dropdown:hover .dropdown-menu {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
}



@media (max-width: 768px) {
  .navbar-center {
    flex-direction: column;
    align-items: flex-start;
  }

  .nav-item.has-dropdown {
    width: 100%;
  }

  .nav-item.has-dropdown > .nav-link {
    cursor: default;
    pointer-events: none;  
    margin-bottom: 8px;
  }

  .nav-item.has-dropdown .dropdown-menu {
    position: static;           
    box-shadow: none;          
    background: transparent;   
    padding: 0;
    opacity: 1;                
    visibility: visible;      
    transform: none;
  }

  .nav-item.has-dropdown .dropdown-menu a {
    display: block;
    padding: 10px 0 10px 24px;  
    width: 100%;
    text-decoration: none;
    color: #fff;  
    background: transparent;
  }

  .nav-item.has-dropdown .dropdown-menu a:hover {
    background: transparent;
  }
}


.nav-item.has-dropdown > .nav-link {
    position: relative;
    padding-right: 14px;  
}

.nav-item.has-dropdown > .nav-link::after {

    content: "";
    position: absolute;
    right: 0;
    top: 50%;
    transform: translateY(-50%);
    border-left: 4px solid transparent;
    border-right: 4px solid transparent;
    border-top: 5px solid #ffffff; 
    opacity: 0.9;
    
}


@media (min-width: 769px) {
    .nav-item.has-dropdown:hover > .nav-link::after {
        opacity: 1;
    }
}

@media (max-width: 768px) {
    .nav-item.has-dropdown > .nav-link::after {
        border-top-color: #ffffff; 
        opacity: 1;
    }
}
*/

</style>
    
    
    <!-- old nav without dropdown 
    

    <?php $header_nav = get_field("mainheader_menu", "option"); ?>
    <nav class="navbar-center mobile-hidden" id="mobileMenu">
        <button class="mobile-menu-close mobile-only " onclick="toggleMobileMenu()">×</button>
      <?php if ($header_nav): ?>
        <?php foreach ($header_nav as $item): ?>
          <?php $link = $item['link']; $text = $item['text']; ?>
          <a href="<?php echo esc_url($link); ?>"><?php echo esc_html($text); ?></a>
        <?php endforeach; ?>
      <?php endif; ?>
      
            <a class="mobile-only-menu-item" href="tel:+38518801114" style="color: white;">
  <i class="fas fa-phone" style="margin-right: 8px;"></i>+385 188 011 14
</a>
<a class="mobile-only-menu-item" href="mailto:info@noriks.com" style="color: white;">
  <i class="fas fa-envelope" style="margin-right: 8px;"></i>info@noriks.com
</a>
      
        <div class="language-selector mobile-only" onclick="openLanguageModal()">
          <img src="https://static.devit.software/countries/flags/rectangle/<?php echo get_field("webshop_icon", "options"); ?>" alt="" class="flag">
          <span><?php echo get_field("webshop_language", "options"); ?></span>
        </div>

    </nav>
    
    -->
    
    
    
    
    
    
    




    <div class="navbar-right">
      <div class="language-selector hidden-mobile" onclick="openLanguageModal()">
        <img src="https://static.devit.software/countries/flags/rectangle/<?php echo get_field("webshop_icon", "options"); ?>" alt="" class="flag">
        <span><?php echo get_field("webshop_language", "options"); ?></span>
      </div>

      <div class="cart-auto-icon">
          
          
          
        <?php if ( class_exists( 'WooCommerce' ) ) : ?>
            <a class="header-cart" href="/cz/cart">
                <div class="cart-icon">
                   <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="26" height="23" viewBox="0 0 26 23">
                    <image xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABoAAAAXCAYAAAAV1F8QAAACM0lEQVR4AbRVPYsaURS9M07AXgURixR+dbtbS9ZSEIv8AbUTxb+w6exFLURQWxUUooWi4AciiDGdFoqIhE2tVVZEcDLngUM2mxlnwjrMee+8e8+9h3m84fGk83l4uBfv7+5EnWWky8jn84mzbzOafZ8RuB4zXUaFQoEMgkCC8IHAb2KUzWZFh8NBx+ORARwxrWaavujx8ZMYj8dZz2QySQAWiCEHfg2ajAqFIhkMBppOpzDhJCMOHDHkrpkgf9UonU6LTqeTXl5+USgUQg0DOGLIQcOCKoOqkdfrFROJBCt/evpC6/WaYwtpAEdMogQNtOBKUDUqlUpsy5bLJaVSKdnk0gwx5LCFxWLxEv7nzFerVVHpcblcrMjj8ZCSBjmI3G63ogYevN1uh+6msFgsxPf7/ZuaoPlwOCS+1WqB3xSdTof4yWTC7XY7TUbn85m63S4DuJai/X6P/49jp240GmmpoWAwSH6/nwMCgYCmmvF4zHTMqNfrsYXasFgsqN1uy0dc2g5uPp+rlbDcpTczajS+NlhUZbBarW+yNpvtTezvQLPZ/IEYM3p+/vlZ+tOxVoTZbKZcLocLT5BEQj6fF00mk0SV381mQ9vt9iMUzAgERxCzGmKxGB0OhxMQjUbVpCw3GAzYjEE2kvYc66swGo0EXBVKgj97ykb1ep07nU5S+n1e9KrVavLhkY3QvlwuY3oXVCqVV31eGUUiEU66WwjHdrVa0f8AtZlMhsLhsPw1cPwNAAD//6RURXgAAAAGSURBVAMAUxNB668Ak78AAAAASUVORK5CYII=" x="0" y="0" width="26" height="23"/>
                  </svg>
                    <span class="cart-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
                </div>
            </a>
        <?php endif; ?>
                
        
        
        
        
        <style>
          .xoo-wsc-sc-bki {
            color: white !important;
          }
          .xoo-wsc-sc-count {
            background-color: #971b1b !important;
            color: white !important;
          }
        </style>
      </div>
    </div>
  </div>
</header>


<!-- mobile nav styling -->
<style>

.xoo-wsc-sc-subt  {
        display: none !important;
  }

.language-selector {
  display: none; /* Hide by default */
}


@media (min-width: 769px) {
      .mobile-only  {
        display: none !important;
  }
    
}

@media (max-width: 768px) {
    
   .hidden-mobile  {
        display: none !important;
  }
    
    
  .language-selector {
    display: flex;
    align-items: center;
    margin-top: 30px;
    gap: 10px;
    color: white;
    cursor: pointer;
  }

  .language-selector img {
    width: 24px;
    height: auto;
  }

  .language-selector span {
    font-size: 14px;
    font-family: 'Roboto', sans-serif;
  }
}


@media (max-width: 768px) {
  .mobile-menu-close {
    position: absolute;
    top: 0;
    right: 0;
    font-size: 14.8px;
    background: white;
    border: none;
    color: black;
    cursor: pointer;
    z-index: 10000;
  }

  .mobile-menu-close:hover {
    color: #ccc;
  }
}


/* Hide hamburger by default */
.mobile-menu-toggle {
  display: none;
  font-size: 33px;
  color: white;
  cursor: pointer;
}

/* Base styles */
.navbar-center {
  display: flex;
  gap: 5px;
}

@media (max-width: 768px) {
  .mobile-menu-toggle {
    display: block;
  }

  .navbar-center {
    flex-direction: column;
    position: fixed;
    top: 0;
    left: -350px; /* Hidden by default */
    width: 350px;
    height: 100vh;
    background-color: #111;
    padding: 40px 20px;
    transition: left 0.3s ease-in-out;
    z-index: 999999999;
    box-shadow: 2px 0 8px rgba(0,0,0,0.4);
  }

  .navbar-center a {
    color: white;
    font-size: 18px;
    margin: 10px 0;
    text-decoration: none;
  }

  .navbar-center.active {
    left: 0; /* Slide in */
  }

  .navbar-right {
    display: none; /* Optional: hide cart/lang */
  }
}

</style>


<script>
  function toggleMobileMenu() {
    const menu = document.getElementById('mobileMenu');
    menu.classList.toggle('active');
  }
</script>

<!-- mobile nov styling -->





<!-- 🌐 Language Modal -->
<div id="languageModal" class="language-modal">
  <div class="language-modal-content">
    <span class="language-close" onclick="closeLanguageModal()">&times;</span>
    <h3><?php  echo get_field("country_shop_list_POPUP_t1","options"); ?></h3>
   <div class="language-options">
 
 
      
  <a href="/" class="language-option">
    <img src="https://static.devit.software/countries/flags/rectangle/eu.svg"><span>English (Europe)</span>
  </a>
  
<a href="/hr" class="language-option">
    <img src="https://static.devit.software/countries/flags/rectangle/hr.svg"><span>Croatia (HR)</span>
  </a>
  
  <!--
   <a disabled href="/hu" class="language-option">
    <img src="https://static.devit.software/countries/flags/rectangle/hu.svg"><span>Hungary (HU)</span>
  </a>
    <a href="/de" class="language-option">
    <img src="https://static.devit.software/countries/flags/rectangle/de.svg"><span>Germany (DE)</span>
  </a>
  -->

  <a href="/pl" class="language-option">
    <img src="https://static.devit.software/countries/flags/rectangle/pl.svg"><span>Poland (PL)</span>
  </a>
  <a href="/sk" class="language-option">
    <img src="https://static.devit.software/countries/flags/rectangle/sk.svg"><span>Slovakia (SK)</span>
  </a>
  <a href="/cz" class="language-option">
    <img src="https://static.devit.software/countries/flags/rectangle/cz.svg"><span>Czech Republic (CZ)</span>
  </a>
  <!--
  <a href="/ro" class="language-option">
    <img src="https://static.devit.software/countries/flags/rectangle/ro.svg"><span>Romania (RO)</span>
  </a>
  -->
  <a href="/gr" class="language-option">
    <img src="https://static.devit.software/countries/flags/rectangle/gr.svg"><span>Greece (GR)</span>
  </a>
  <!--
  <a href="/si" class="language-option">
    <img src="https://static.devit.software/countries/flags/rectangle/si.svg"><span>Slovenia (SI)</span>
  </a>
  -->
  
    <a href="https://www.noriksofficial.com/" class="language-option">
    <img src="https://static.devit.software/countries/flags/rectangle/us.svg"><span>English (USA)</span>
  </a>
  
  
</div>
  </div>
</div>

<style>

a:focus, input:focus, textarea:focus, button:focus {
    outline: none !important;
}


  .language-modal {
  display: none;
  position: fixed;
  z-index: 9999999998;
  top: 0; left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.6);
  justify-content: center;
  align-items: center;
  font-family: 'Inter', sans-serif;
}

.language-modal-content {
  background: #fff;
  border-radius: 4px;
  padding: 40px 30px;
  max-width: 900px;
  width: 90%;
  box-shadow: 0 10px 40px rgba(0,0,0,0.2);
  text-align: center;
  position: relative;
}

.language-close {
  position: absolute;
  top: 15px;
  right: 20px;
  font-size: 28px;
  cursor: pointer;
  color: #444;
}

.language-modal-content h3 {
  font-size: 22px;
  font-weight: 800;
  margin-bottom: 30px;
  color: #111;
}

.language-options {
  display: grid;
  grid-template-columns: 1fr 1fr; /* Two columns */
  gap: 16px 20px; /* row-gap | column-gap */
  align-items: start;
}

.language-option {
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 12px 14px;
  border: 1px solid #e2e2e2;
  border-radius: 10px;
  cursor: pointer;
  transition: all 0.25s ease;
  background: #fff;
  text-align: left;
}

.language-option:hover {
  background-color: #f8f8f8;
  border-color: #ccc;
}

.language-options a {
  text-decoration: none;
}

.language-option {
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 12px 14px;
  border: 1px solid #e2e2e2;
  border-radius: 10px;
  cursor: pointer;
  transition: all 0.25s ease;
  background: #fff;
  text-align: left;
}

.language-option:hover {
  background-color: #f8f8f8;
  border-color: #ccc;
}

.language-option img {
  width: 24px;
  height: auto;
  border-radius: 3px;
}

.language-option span {
  font-size: 15px;
  font-weight: 500;
  color: #222;
}

@media (max-width: 768px) {
  .language-options {
    grid-template-columns: 1fr;
    gap: 6px 20px; /* row-gap | column-gap */
  }
  .language-option span {

    font-size: 13px;

}
}
</style>


<script>
function openLanguageModal() {
  document.getElementById("languageModal").style.display = "flex";
}

function closeLanguageModal() {
  document.getElementById("languageModal").style.display = "none";
}

window.addEventListener("click", function(e) {
  const modal = document.getElementById("languageModal");
  if (e.target === modal) {
    closeLanguageModal();
  }
});
</script>


<!-- 🌐 Language Modal -->




<style>
body {
  margin: 0;
  font-family: 'Inter', sans-serif;
}




.navbar {
  background-color: black;
  padding: 5px 20px 5px 10px;
}

.header .container {
  max-width: 1800px;
  margin: 0 auto;
  display: flex;
  align-items: center;
  justify-content: space-between;
      padding-left: 15px;
    padding-right: 15px;
}

.header .navbar-left .logo {
  height: auto;
}

.header .navbar-center a {
color: white;
    text-decoration: none;
    margin: 0 15px;
    font-size: 14px;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.59px !important;
}

.header .navbar-center a:hover {
  text-decoration: underline;
}

.header .navbar-right {
  display: flex;
  align-items: center;
}

.header .language-selector {
  display: flex;
  align-items: center;
  background: rgba(255,255,255,0.05);
  padding: 5px 10px;
  border-radius: 20px;
  margin-right: 20px;
}

.header .language-selector:hover {
    cursor:pointer;
}

.language-selector .flag {
  width: 20px;
  height: 15px;
  margin-right: 5px;
}

.language-selector span {
  color: white;
  font-size: 14px;
  font-weight: 400;
}

.icon {
  margin: 0 10px;
}

.icon img {
  width: 24px;
  height: 24px;
}

.cart-icon {
  position: relative;
}

.cart-count {
  position: absolute;
  top: -6px;
  right: -6px;
  background: #971b1b !important;
  color: white;
  font-size: 12px;
  font-weight: 700;
  width: 18px;
  height: 18px;
  text-align: center;
  line-height: 18px;
  border-radius: 50%;
}
</style>

		<style>
		

		
		  .site-search {
                display: none;
            }
        .site-header-cart {
                display: none;
            }
        .site-branding {
            width: 100% !important;
            float: none;
            margin: 0 auto;
            text-align: center;
        }
        .woocommerce-active .site-header .main-navigation {
        width: 100% !important;
        /* float: left; */
        margin-right: 0;
        clear: both;
        text-align: center;
    }


	@media (min-width: 768px) {
    .col-full {
        max-width: 1400px;
		}
	}



	@media (min-width: 768px) {
    .storefront-full-width-content.single-product div.product .woocommerce-product-gallery {
			width: 48%;
			margin-right: 30px;
		}
	}

	.storefront-full-width-content.single-product div.product .summary {
       width: 48%;
    }

	.woocommerce div.product div.images img {
    width: 100%;
    height: auto;
    object-fit: cover;
    max-width: none;
}
		</style>
	
	

	<?php
	/**
	 * Functions hooked in to storefront_before_content
	 *
	 * @hooked storefront_header_widget_region - 10
	 * @hooked woocommerce_breadcrumb - 10
	 */
	do_action( 'storefront_before_content' );
	?>

	<div id="content" class="site-content" tabindex="-1">
		<div class="col-full2">

		<?php
		do_action( 'storefront_content_top' );
