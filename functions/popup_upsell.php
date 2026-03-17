<?php
/**
 * Post-Purchase Upsell Popup on Thank You Page
 * 
 * Shows a single product offer first. When user clicks "Ne želim" or adds 1 item,
 * a second popup appears with 6 products in a 3x2 grid.
 * 
 * Requirements:
 * 1. Red background
 * 2. No border-radius anywhere
 * 3. Red buttons (matching site style)
 * 4. Two-step flow: single offer → 6-product grid
 */

if (!defined('ABSPATH')) exit;

// ─── AJAX: Add upsell product to existing order ─────────────────────────
add_action('wp_ajax_noriks_upsell_add_to_order', 'noriks_upsell_add_to_order');
add_action('wp_ajax_nopriv_noriks_upsell_add_to_order', 'noriks_upsell_add_to_order');

function noriks_upsell_add_to_order() {
    check_ajax_referer('noriks_upsell_nonce', 'security');

    $order_id    = absint($_POST['order_id'] ?? 0);
    $product_id  = absint($_POST['product_id'] ?? 0);
    $quantity    = absint($_POST['quantity'] ?? 1);
    $variation   = sanitize_text_field($_POST['variation'] ?? '');

    if (!$order_id || !$product_id) {
        wp_send_json_error('Missing data');
    }

    $order   = wc_get_order($order_id);
    $product = wc_get_product($product_id);

    if (!$order || !$product) {
        wp_send_json_error('Invalid order or product');
    }

    // Calculate discounted price (50% off)
    $regular_price = (float) $product->get_regular_price();
    $upsell_price  = round($regular_price * 0.5, 2);

    // Add item to order
    $item = new WC_Order_Item_Product();
    $item->set_product($product);
    $item->set_quantity($quantity);
    $item->set_subtotal($upsell_price * $quantity);
    $item->set_total($upsell_price * $quantity);

    if ($variation) {
        $item->add_meta_data('pa_variation', $variation, true);
    }

    $item->add_meta_data('_upsell_item', 'yes', true);
    $order->add_item($item);
    $order->calculate_totals();
    $order->save();

    $order->add_order_note(sprintf(
        'Upsell: %s x%d added at %s (50%% off)',
        $product->get_name(),
        $quantity,
        wc_price($upsell_price)
    ));

    wp_send_json_success([
        'message'   => 'Product added',
        'new_total' => $order->get_formatted_order_total(),
    ]);
}


// ─── Render popup on Thank You page ─────────────────────────────────────
add_action('woocommerce_thankyou', 'noriks_render_upsell_popup', 5);

function noriks_render_upsell_popup($order_id) {
    $order = wc_get_order($order_id);
    if (!$order) return;

    // Don't show if already has upsell items
    foreach ($order->get_items() as $item) {
        if ($item->get_meta('_upsell_item') === 'yes') return;
    }

    // Get upsell products — bokserice (category slug: bokserice)
    // Fallback: get recent products if category doesn't exist
    $upsell_products = noriks_get_upsell_products($order);
    if (empty($upsell_products)) return;

    $first_product = $upsell_products[0];
    $grid_products = array_slice($upsell_products, 0, 6);

    $currency_symbol = get_woocommerce_currency_symbol();
    $nonce = wp_create_nonce('noriks_upsell_nonce');
    ?>

    <style>
    /* ═══ UPSELL POPUP BASE ═══ */
    .noriks-upsell-overlay {
        position: fixed;
        top: 0; left: 0;
        width: 100%; height: 100%;
        background: rgba(0,0,0,0.6);
        z-index: 99999;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 15px;
        box-sizing: border-box;
    }
    .noriks-upsell-overlay.hidden { display: none; }

    .noriks-upsell-popup {
        background: #C62828;
        color: #fff;
        width: 100%;
        max-width: 520px;
        max-height: 90vh;
        overflow-y: auto;
        border-radius: 0 !important;
        box-shadow: 0 20px 60px rgba(0,0,0,0.4);
        position: relative;
    }

    /* ═══ HEADER ═══ */
    .noriks-upsell-header {
        padding: 18px 20px 14px;
        text-align: center;
        border-radius: 0 !important;
    }
    .noriks-upsell-header .badge {
        display: inline-block;
        background: rgba(255,255,255,0.2);
        color: #fff;
        padding: 3px 12px;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-radius: 0 !important;
        margin-left: 8px;
        vertical-align: middle;
    }
    .noriks-upsell-header h3 {
        color: #fff !important;
        font-size: 15px;
        font-weight: 400;
        margin: 0 0 6px 0;
        padding: 0;
    }
    .noriks-upsell-header h2 {
        color: #fff !important;
        font-size: 20px;
        font-weight: 700;
        margin: 0;
        padding: 0;
        line-height: 1.3;
    }

    /* ═══ TRUST BADGES ═══ */
    .noriks-upsell-trust {
        text-align: center;
        padding: 10px 20px;
        font-size: 13px;
    }
    .noriks-upsell-trust p {
        margin: 3px 0;
        color: #fff;
    }
    .noriks-upsell-trust .icon { margin-right: 5px; }

    /* ═══ PRODUCT CARD (single) ═══ */
    .noriks-upsell-body {
        background: #fff;
        color: #222;
        margin: 0 15px;
        padding: 15px;
        border-radius: 0 !important;
    }
    .noriks-upsell-product {
        display: flex;
        gap: 15px;
        align-items: flex-start;
    }
    .noriks-upsell-product img {
        width: 100px;
        height: auto;
        object-fit: contain;
        border-radius: 0 !important;
        background: #f5f5f5;
    }
    .noriks-upsell-product-info {
        flex: 1;
    }
    .noriks-upsell-product-info .qty {
        font-size: 18px;
        font-weight: 700;
        color: #222;
    }
    .noriks-upsell-product-info .name {
        font-size: 14px;
        color: #555;
        margin: 2px 0 8px;
    }
    .noriks-upsell-product-info .price-old {
        text-decoration: line-through;
        color: #999;
        font-size: 14px;
        margin-right: 5px;
    }
    .noriks-upsell-product-info .price-new {
        color: #C62828;
        font-size: 20px;
        font-weight: 700;
    }

    /* ═══ VARIANT SELECTOR ═══ */
    .noriks-upsell-select {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #ddd;
        border-radius: 0 !important;
        font-size: 14px;
        margin-top: 12px;
        background: #fff;
        color: #222;
        appearance: auto;
    }

    /* ═══ BUTTONS ═══ */
    .noriks-upsell-actions {
        display: flex;
        gap: 10px;
        padding: 15px;
    }
    .noriks-upsell-btn {
        flex: 1;
        padding: 14px 10px;
        font-size: 14px;
        font-weight: 700;
        text-transform: uppercase;
        cursor: pointer;
        border: none;
        border-radius: 0 !important;
        letter-spacing: 0.5px;
        transition: opacity 0.2s;
        text-align: center;
    }
    .noriks-upsell-btn:hover { opacity: 0.85; }
    .noriks-upsell-btn:disabled { opacity: 0.5; cursor: not-allowed; }

    .noriks-upsell-btn--decline {
        background: #C62828;
        color: #fff;
        border: 2px solid #fff;
    }
    .noriks-upsell-btn--accept {
        background: #C62828;
        color: #fff;
        border: 2px solid #fff;
    }

    /* ═══ COUNTDOWN ═══ */
    .noriks-upsell-countdown {
        text-align: center;
        padding: 0 15px 15px;
    }
    .noriks-upsell-countdown span {
        background: rgba(255,255,255,0.2);
        color: #fff;
        padding: 6px 14px;
        font-size: 18px;
        font-weight: 700;
        font-family: monospace;
        border-radius: 0 !important;
        letter-spacing: 2px;
    }

    /* ═══ GRID POPUP (step 2) ═══ */
    .noriks-upsell-grid-popup {
        max-width: 620px;
    }
    .noriks-upsell-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 10px;
        padding: 15px;
        background: #fff;
        margin: 0 15px;
        border-radius: 0 !important;
    }
    .noriks-upsell-grid-item {
        text-align: center;
        padding: 10px;
        border: 1px solid #eee;
        border-radius: 0 !important;
        background: #fff;
        cursor: pointer;
        transition: border-color 0.2s;
    }
    .noriks-upsell-grid-item:hover {
        border-color: #C62828;
    }
    .noriks-upsell-grid-item img {
        width: 100%;
        max-width: 120px;
        height: auto;
        object-fit: contain;
        border-radius: 0 !important;
        margin-bottom: 8px;
    }
    .noriks-upsell-grid-item .grid-name {
        font-size: 12px;
        color: #333;
        margin-bottom: 5px;
        line-height: 1.3;
        min-height: 32px;
    }
    .noriks-upsell-grid-item .grid-price-old {
        text-decoration: line-through;
        color: #999;
        font-size: 12px;
    }
    .noriks-upsell-grid-item .grid-price-new {
        color: #C62828;
        font-size: 16px;
        font-weight: 700;
    }
    .noriks-upsell-grid-item select {
        width: 100%;
        padding: 6px;
        font-size: 12px;
        border: 1px solid #ddd;
        border-radius: 0 !important;
        margin-top: 6px;
    }
    .noriks-upsell-grid-item .grid-add-btn {
        display: block;
        width: 100%;
        margin-top: 8px;
        padding: 8px;
        background: #C62828;
        color: #fff;
        border: none;
        border-radius: 0 !important;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        cursor: pointer;
        transition: opacity 0.2s;
    }
    .noriks-upsell-grid-item .grid-add-btn:hover { opacity: 0.85; }
    .noriks-upsell-grid-item .grid-add-btn.added {
        background: #2E7D32;
        pointer-events: none;
    }

    .noriks-upsell-grid-close {
        display: block;
        width: calc(100% - 30px);
        margin: 0 15px 15px;
        padding: 14px;
        background: transparent;
        color: #fff;
        border: 2px solid #fff;
        border-radius: 0 !important;
        font-size: 14px;
        font-weight: 700;
        text-transform: uppercase;
        cursor: pointer;
        text-align: center;
    }
    .noriks-upsell-grid-close:hover { background: rgba(255,255,255,0.1); }

    /* ═══ RESPONSIVE ═══ */
    @media (max-width: 480px) {
        .noriks-upsell-grid {
            grid-template-columns: repeat(2, 1fr);
        }
        .noriks-upsell-popup {
            max-width: 100%;
        }
        .noriks-upsell-header h2 { font-size: 17px; }
        .noriks-upsell-product img { width: 80px; }
    }

    /* ═══ GLOBAL OVERRIDE: kill all border-radius ═══ */
    .noriks-upsell-overlay *,
    .noriks-upsell-overlay *::before,
    .noriks-upsell-overlay *::after {
        border-radius: 0 !important;
    }
    </style>

    <!-- ═══ STEP 1: Single Product Offer ═══ -->
    <div id="noriks-upsell-step1" class="noriks-upsell-overlay">
        <div class="noriks-upsell-popup">

            <div class="noriks-upsell-header">
                <h3>Posebna ponudba poteče
                    <span class="badge" id="noriks-upsell-badge">
                        <span id="noriks-countdown-display">05:00</span>
                    </span>
                </h3>
                <h2>Dodajte še en izdelek s 50% dodatnega popusta</h2>
            </div>

            <div class="noriks-upsell-trust">
                <p>✔ Poslali ga bomo v istem paketu</p>
                <p>⭐ Pomislite, komu bi lahko izdelek podarili</p>
            </div>

            <div class="noriks-upsell-body">
                <div class="noriks-upsell-product">
                    <img src="<?php echo esc_url(wp_get_attachment_url($first_product->get_image_id())); ?>" 
                         alt="<?php echo esc_attr($first_product->get_name()); ?>">
                    <div class="noriks-upsell-product-info">
                        <span class="qty">1 x</span>
                        <p class="name"><?php echo esc_html($first_product->get_name()); ?></p>
                        <span class="price-old"><?php echo wc_price($first_product->get_regular_price()); ?></span>
                        <span class="price-new"><?php echo wc_price(round((float)$first_product->get_regular_price() * 0.5, 2)); ?></span>
                    </div>
                </div>

                <?php if ($first_product->is_type('variable')): ?>
                    <?php $variations = $first_product->get_available_variations(); ?>
                    <select class="noriks-upsell-select" id="noriks-upsell-variation">
                        <?php foreach ($variations as $v): 
                            $attrs = [];
                            foreach ($v['attributes'] as $key => $val) {
                                $attrs[] = $val;
                            }
                            $label = implode(', ', $attrs);
                        ?>
                            <option value="<?php echo esc_attr($v['variation_id']); ?>"><?php echo esc_html($label); ?></option>
                        <?php endforeach; ?>
                    </select>
                <?php endif; ?>
            </div>

            <div class="noriks-upsell-actions">
                <button class="noriks-upsell-btn noriks-upsell-btn--decline" id="noriks-upsell-decline">Ne želim</button>
                <button class="noriks-upsell-btn noriks-upsell-btn--accept" id="noriks-upsell-accept"
                        data-product-id="<?php echo esc_attr($first_product->get_id()); ?>"
                        data-order-id="<?php echo esc_attr($order_id); ?>">
                    DODAJ V NAROČILO
                </button>
            </div>

            <div class="noriks-upsell-countdown">
                <span id="noriks-countdown-bar">05:00</span>
            </div>
        </div>
    </div>

    <!-- ═══ STEP 2: 6-Product Grid ═══ -->
    <div id="noriks-upsell-step2" class="noriks-upsell-overlay hidden">
        <div class="noriks-upsell-popup noriks-upsell-grid-popup">

            <div class="noriks-upsell-header">
                <h3>Še več izdelkov s popustom</h3>
                <h2>Dodajte katerikoli izdelek s 50% popustom</h2>
            </div>

            <div class="noriks-upsell-trust">
                <p>✔ Vse pošljemo v istem paketu</p>
            </div>

            <div class="noriks-upsell-grid">
                <?php foreach ($grid_products as $gp): 
                    $regular = (float) $gp->get_regular_price();
                    $upsell  = round($regular * 0.5, 2);
                    $img_url = wp_get_attachment_url($gp->get_image_id());
                ?>
                <div class="noriks-upsell-grid-item">
                    <img src="<?php echo esc_url($img_url); ?>" alt="<?php echo esc_attr($gp->get_name()); ?>">
                    <div class="grid-name"><?php echo esc_html($gp->get_name()); ?></div>
                    <div class="grid-price-old"><?php echo wc_price($regular); ?></div>
                    <div class="grid-price-new"><?php echo wc_price($upsell); ?></div>

                    <?php if ($gp->is_type('variable')): ?>
                        <select class="grid-variation" data-product-id="<?php echo esc_attr($gp->get_id()); ?>">
                            <?php foreach ($gp->get_available_variations() as $v):
                                $attrs = [];
                                foreach ($v['attributes'] as $key => $val) $attrs[] = $val;
                            ?>
                                <option value="<?php echo esc_attr($v['variation_id']); ?>"><?php echo esc_html(implode(', ', $attrs)); ?></option>
                            <?php endforeach; ?>
                        </select>
                    <?php endif; ?>

                    <button class="grid-add-btn"
                            data-product-id="<?php echo esc_attr($gp->get_id()); ?>"
                            data-order-id="<?php echo esc_attr($order_id); ?>">
                        DODAJ
                    </button>
                </div>
                <?php endforeach; ?>
            </div>

            <button class="noriks-upsell-grid-close" id="noriks-upsell-close">Zaključi</button>
        </div>
    </div>

    <script>
    (function() {
        var nonce = '<?php echo $nonce; ?>';
        var ajaxUrl = '<?php echo admin_url("admin-ajax.php"); ?>';
        var countdownSeconds = 300; // 5 minutes

        // ─── Countdown ───
        var timerEl = document.getElementById('noriks-countdown-display');
        var barEl = document.getElementById('noriks-countdown-bar');
        var badgeEl = document.getElementById('noriks-upsell-badge');

        var timer = setInterval(function() {
            countdownSeconds--;
            if (countdownSeconds <= 0) {
                clearInterval(timer);
                // Auto-show grid when time expires
                showStep2();
                return;
            }
            var m = Math.floor(countdownSeconds / 60);
            var s = countdownSeconds % 60;
            var display = (m < 10 ? '0' + m : m) + ':' + (s < 10 ? '0' + s : s);
            if (timerEl) timerEl.textContent = display;
            if (barEl) barEl.textContent = display;
        }, 1000);

        // ─── Step transitions ───
        function showStep2() {
            document.getElementById('noriks-upsell-step1').classList.add('hidden');
            document.getElementById('noriks-upsell-step2').classList.remove('hidden');
        }

        function closeAll() {
            document.getElementById('noriks-upsell-step1').classList.add('hidden');
            document.getElementById('noriks-upsell-step2').classList.add('hidden');
            clearInterval(timer);
        }

        // ─── Decline → show grid ───
        document.getElementById('noriks-upsell-decline').addEventListener('click', function() {
            showStep2();
        });

        // ─── Accept single → add to order, then show grid ───
        document.getElementById('noriks-upsell-accept').addEventListener('click', function() {
            var btn = this;
            btn.disabled = true;
            btn.textContent = '...';

            var productId = btn.getAttribute('data-product-id');
            var orderId = btn.getAttribute('data-order-id');
            var variationSelect = document.getElementById('noriks-upsell-variation');
            var variation = variationSelect ? variationSelect.value : '';

            var formData = new FormData();
            formData.append('action', 'noriks_upsell_add_to_order');
            formData.append('security', nonce);
            formData.append('order_id', orderId);
            formData.append('product_id', variation || productId);
            formData.append('quantity', 1);
            formData.append('variation', variationSelect ? variationSelect.options[variationSelect.selectedIndex].text : '');

            fetch(ajaxUrl, { method: 'POST', body: formData })
                .then(function(r) { return r.json(); })
                .then(function(data) {
                    // Show grid for more products
                    showStep2();
                })
                .catch(function() {
                    btn.disabled = false;
                    btn.textContent = 'DODAJ V NAROČILO';
                });
        });

        // ─── Grid: add individual items ───
        document.querySelectorAll('.grid-add-btn').forEach(function(btn) {
            btn.addEventListener('click', function() {
                var el = this;
                el.disabled = true;
                el.textContent = '...';

                var productId = el.getAttribute('data-product-id');
                var orderId = el.getAttribute('data-order-id');
                var variationSelect = el.parentElement.querySelector('.grid-variation');
                var variation = variationSelect ? variationSelect.value : '';

                var formData = new FormData();
                formData.append('action', 'noriks_upsell_add_to_order');
                formData.append('security', nonce);
                formData.append('order_id', orderId);
                formData.append('product_id', variation || productId);
                formData.append('quantity', 1);
                formData.append('variation', variationSelect ? variationSelect.options[variationSelect.selectedIndex].text : '');

                fetch(ajaxUrl, { method: 'POST', body: formData })
                    .then(function(r) { return r.json(); })
                    .then(function(data) {
                        el.textContent = '✔ DODANO';
                        el.classList.add('added');
                    })
                    .catch(function() {
                        el.disabled = false;
                        el.textContent = 'DODAJ';
                    });
            });
        });

        // ─── Close grid ───
        document.getElementById('noriks-upsell-close').addEventListener('click', closeAll);

        // ─── Close on overlay click ───
        document.querySelectorAll('.noriks-upsell-overlay').forEach(function(overlay) {
            overlay.addEventListener('click', function(e) {
                if (e.target === overlay) {
                    // On step 1 overlay click → show step 2
                    if (overlay.id === 'noriks-upsell-step1') {
                        showStep2();
                    } else {
                        closeAll();
                    }
                }
            });
        });
    })();
    </script>

    <?php
}


/**
 * Get upsell products for the popup.
 * Tries to get bokserice first, then falls back to recent products.
 */
function noriks_get_upsell_products($order) {
    $ordered_product_ids = [];
    foreach ($order->get_items() as $item) {
        $ordered_product_ids[] = $item->get_product_id();
    }

    // Try getting from 'bokserice' or 'boxerice' category
    $args = [
        'status'  => 'publish',
        'limit'   => 6,
        'exclude' => $ordered_product_ids,
        'orderby' => 'rand',
    ];

    // Try category slugs
    foreach (['bokserice', 'boxerice', 'majice', 'majica'] as $cat_slug) {
        $cat = get_term_by('slug', $cat_slug, 'product_cat');
        if ($cat) {
            $args['category'] = [$cat_slug];
            break;
        }
    }

    $products = wc_get_products($args);

    // Fallback: get any products if category search returned nothing
    if (empty($products)) {
        unset($args['category']);
        $products = wc_get_products($args);
    }

    return $products;
}
