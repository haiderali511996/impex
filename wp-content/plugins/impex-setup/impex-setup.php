<?php
/**
 * Plugin Name:       IMPEX Football Store Setup
 * Plugin URI:        https://impexfootball.com
 * Description:       One-click setup for the IMPEX Football WooCommerce store. Creates product categories, sample products, pages, and configures store settings.
 * Version:           1.0.0
 * Author:            IMPEX Football Manufacturing
 * Author URI:        https://impexfootball.com
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       impex-setup
 * Requires at least: 6.0
 * Requires PHP:      8.0
 * WC requires at least: 7.0
 * WC tested up to: 8.0
 */

defined( 'ABSPATH' ) || exit;

define( 'IMPEX_SETUP_VERSION',  '1.0.0' );
define( 'IMPEX_SETUP_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'IMPEX_SETUP_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

/* =========================================================
   PLUGIN ACTIVATION HOOK
========================================================= */

register_activation_hook( __FILE__, 'impex_setup_on_activate' );

function impex_setup_on_activate() {
    if ( ! current_user_can( 'activate_plugins' ) ) {
        return;
    }

    // Schedule a one-time setup action to run after WooCommerce loads
    if ( ! wp_next_scheduled( 'impex_run_setup' ) ) {
        wp_schedule_single_event( time() + 5, 'impex_run_setup' );
    }

    // Also set a transient to trigger setup on next admin page load
    set_transient( 'impex_run_setup_now', true, 60 * 60 );

    flush_rewrite_rules();
}

/* =========================================================
   ADMIN NOTICE WITH MANUAL TRIGGER
========================================================= */

add_action( 'admin_notices', 'impex_setup_admin_notice' );

function impex_setup_admin_notice() {
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }

    // Check if setup has already been completed
    if ( get_option( 'impex_setup_complete' ) ) {
        echo '<div class="notice notice-success is-dismissible"><p>';
        echo '<strong>IMPEX Football Store:</strong> Setup complete! ';
        echo '<a href="' . esc_url( admin_url( 'edit.php?post_type=product' ) ) . '">View Products</a> | ';
        echo '<a href="' . esc_url( admin_url( 'edit-tags.php?taxonomy=product_cat&post_type=product' ) ) . '">View Categories</a>';
        echo '</p></div>';
        return;
    }

    // Show setup button
    echo '<div class="notice notice-warning"><p>';
    echo '<strong>IMPEX Football Setup:</strong> Click the button to create categories, sample products, and configure your store. ';
    echo '<a href="' . esc_url( wp_nonce_url( admin_url( 'admin.php?page=impex-setup' ), 'impex_run_setup' ) ) . '" class="button button-primary">Run Setup Now</a>';
    echo '</p></div>';
}

/* =========================================================
   ADMIN PAGE
========================================================= */

add_action( 'admin_menu', 'impex_setup_add_admin_menu' );

function impex_setup_add_admin_menu() {
    add_menu_page(
        __( 'IMPEX Store Setup', 'impex-setup' ),
        __( 'IMPEX Setup', 'impex-setup' ),
        'manage_options',
        'impex-setup',
        'impex_setup_admin_page',
        'dashicons-football',
        58
    );
}

function impex_setup_admin_page() {
    // Handle run setup button
    if ( isset( $_GET['run'] ) && $_GET['run'] === '1' && wp_verify_nonce( $_GET['_wpnonce'] ?? '', 'impex_do_setup' ) ) {
        $result = impex_run_full_setup();
        echo '<div class="wrap">';
        echo '<h1>⚽ IMPEX Football Store Setup</h1>';
        if ( $result['success'] ) {
            echo '<div class="notice notice-success"><p><strong>Setup complete!</strong> ' . esc_html( $result['message'] ) . '</p></div>';
        } else {
            echo '<div class="notice notice-error"><p><strong>Setup encountered issues:</strong> ' . esc_html( $result['message'] ) . '</p></div>';
        }
        echo '<p><a href="' . esc_url( admin_url( 'edit.php?post_type=product' ) ) . '" class="button button-primary">View Products</a>&nbsp;';
        echo '<a href="' . esc_url( home_url( '/shop' ) ) . '" class="button" target="_blank">View Shop</a></p>';
        echo '</div>';
        return;
    }

    $setup_done = get_option( 'impex_setup_complete' );
    ?>
    <div class="wrap">
      <h1>⚽ IMPEX Football Store Setup</h1>
      <p>This plugin sets up your IMPEX Football WooCommerce store with:</p>
      <ul style="list-style:disc; margin-left:2rem;">
        <li>6 product categories (Professional, Training, Youth, Futsal, Beach, Custom)</li>
        <li>12 sample football products with full descriptions, SKUs, and pricing</li>
        <li>WooCommerce pages (Shop, Cart, Checkout, My Account)</li>
        <li>Basic store settings (currency, measurement units, etc.)</li>
      </ul>

      <?php if ( $setup_done ) : ?>
        <div class="notice notice-success inline"><p><strong>Setup was already completed.</strong> You can re-run it to refresh sample data.</p></div>
      <?php endif; ?>

      <p>
        <a href="<?php echo esc_url( wp_nonce_url( admin_url( 'admin.php?page=impex-setup&run=1' ), 'impex_do_setup' ) ); ?>" class="button button-primary button-large">
          <?php echo $setup_done ? 'Re-run Setup' : 'Run Setup Now'; ?>
        </a>
      </p>

      <?php if ( ! class_exists( 'WooCommerce' ) ) : ?>
        <div class="notice notice-warning inline"><p><strong>Note:</strong> WooCommerce is not active. Please install and activate WooCommerce before running setup.</p></div>
      <?php endif; ?>
    </div>
    <?php
}

/* =========================================================
   TRANSIENT-TRIGGERED AUTO-SETUP
========================================================= */

add_action( 'admin_init', function() {
    if ( get_transient( 'impex_run_setup_now' ) && current_user_can( 'manage_options' ) ) {
        delete_transient( 'impex_run_setup_now' );
        if ( class_exists( 'WooCommerce' ) && ! get_option( 'impex_setup_complete' ) ) {
            impex_run_full_setup();
        }
    }
} );

add_action( 'impex_run_setup', function() {
    if ( class_exists( 'WooCommerce' ) ) {
        impex_run_full_setup();
    }
} );

/* =========================================================
   MAIN SETUP FUNCTION
========================================================= */

function impex_run_full_setup() {
    if ( ! class_exists( 'WooCommerce' ) ) {
        return array(
            'success' => false,
            'message' => 'WooCommerce is not active. Please install WooCommerce first.',
        );
    }

    $messages = array();

    // 1. Configure store settings
    $messages[] = impex_configure_store_settings();

    // 2. Create WooCommerce pages
    $messages[] = impex_create_woocommerce_pages();

    // 3. Create product categories
    $cat_ids = impex_create_product_categories();
    $messages[] = 'Created ' . count( $cat_ids ) . ' product categories.';

    // 4. Create sample products
    $product_count = impex_create_sample_products( $cat_ids );
    $messages[] = 'Created ' . $product_count . ' sample products.';

    // 5. Mark as complete
    update_option( 'impex_setup_complete', current_time( 'mysql' ) );
    update_option( 'impex_setup_version', IMPEX_SETUP_VERSION );

    flush_rewrite_rules();

    return array(
        'success' => true,
        'message' => implode( ' ', $messages ),
    );
}

/* =========================================================
   STORE SETTINGS
========================================================= */

function impex_configure_store_settings() {
    $settings = array(
        'woocommerce_store_address'          => '123 Football Drive',
        'woocommerce_store_city'             => 'Sialkot',
        'woocommerce_default_country'        => 'PK',
        'woocommerce_store_postcode'         => '51310',
        'woocommerce_currency'               => 'USD',
        'woocommerce_currency_pos'           => 'left',
        'woocommerce_price_thousand_sep'     => ',',
        'woocommerce_price_decimal_sep'      => '.',
        'woocommerce_price_num_decimals'     => '2',
        'woocommerce_weight_unit'            => 'g',
        'woocommerce_dimension_unit'         => 'cm',
        'woocommerce_manage_stock'           => 'yes',
        'woocommerce_notify_low_stock'       => 'yes',
        'woocommerce_notify_no_stock'        => 'yes',
        'woocommerce_stock_email_recipient'  => get_option( 'admin_email' ),
        'woocommerce_enable_reviews'         => 'yes',
        'woocommerce_review_rating_required' => 'no',
        'woocommerce_enable_shipping_calc'   => 'yes',
        'woocommerce_ship_to_destination'    => 'billing',
        'woocommerce_calc_taxes'             => 'no',
        'woocommerce_enable_coupon'          => 'yes',
        'blogname'                           => 'IMPEX Football',
        'blogdescription'                    => 'Premium Football Manufacturer — Shop Professional, Training & Custom Footballs',
    );

    foreach ( $settings as $key => $value ) {
        update_option( $key, $value );
    }

    return 'Store settings configured.';
}

/* =========================================================
   CREATE WOOCOMMERCE PAGES
========================================================= */

function impex_create_woocommerce_pages() {
    $pages = array(
        'shop'       => array( 'post_title' => 'Shop',       'slug' => 'shop' ),
        'cart'       => array( 'post_title' => 'Cart',       'slug' => 'cart' ),
        'checkout'   => array( 'post_title' => 'Checkout',   'slug' => 'checkout' ),
        'myaccount'  => array( 'post_title' => 'My Account', 'slug' => 'my-account' ),
    );

    $created = 0;

    foreach ( $pages as $key => $data ) {
        $option_key = 'woocommerce_' . $key . '_page_id';
        $existing   = get_option( $option_key );

        if ( $existing && get_post( $existing ) ) {
            continue; // Already exists
        }

        // Find by slug first
        $existing_page = get_page_by_path( $data['slug'] );

        if ( $existing_page ) {
            update_option( $option_key, $existing_page->ID );
            continue;
        }

        // Create it
        $content = '';
        if ( $key === 'cart' )      $content = '[woocommerce_cart]';
        if ( $key === 'checkout' )  $content = '[woocommerce_checkout]';
        if ( $key === 'myaccount' ) $content = '[woocommerce_my_account]';

        $page_id = wp_insert_post( array(
            'post_title'   => $data['post_title'],
            'post_name'    => $data['slug'],
            'post_status'  => 'publish',
            'post_type'    => 'page',
            'post_content' => $content,
            'post_author'  => 1,
        ) );

        if ( $page_id && ! is_wp_error( $page_id ) ) {
            update_option( $option_key, $page_id );
            $created++;
        }
    }

    return "WooCommerce pages: {$created} created.";
}

/* =========================================================
   CREATE PRODUCT CATEGORIES
========================================================= */

function impex_create_product_categories() {
    $categories = array(
        'professional-match-balls' => array(
            'name'        => 'Professional Match Balls',
            'description' => 'FIFA approved and elite match balls for professional competitions. Built to the highest international standards with premium materials.',
            'display'     => 'default',
        ),
        'training-balls' => array(
            'name'        => 'Training Balls',
            'description' => 'Durable training footballs designed for daily practice sessions, club training, and intensive drill use.',
            'display'     => 'default',
        ),
        'youth-junior-balls' => array(
            'name'        => 'Youth & Junior Balls',
            'description' => 'Size 3 and Size 4 footballs designed specifically for young players, academies, and junior leagues.',
            'display'     => 'default',
        ),
        'futsal-balls' => array(
            'name'        => 'Futsal Balls',
            'description' => 'Low-bounce futsal balls designed specifically for indoor futsal courts. Approved for official futsal competitions.',
            'display'     => 'default',
        ),
        'beach-soccer-balls' => array(
            'name'        => 'Beach Soccer Balls',
            'description' => 'Bright, water-resistant beach soccer balls built for sand play. Soft outer panels for barefoot comfort.',
            'display'     => 'default',
        ),
        'custom-branded-balls' => array(
            'name'        => 'Custom & Branded Balls',
            'description' => 'Custom logo and branded footballs for clubs, teams, schools, and corporate orders. MOQ applies.',
            'display'     => 'default',
        ),
    );

    $cat_ids = array();

    foreach ( $categories as $slug => $data ) {
        $existing = get_term_by( 'slug', $slug, 'product_cat' );

        if ( $existing ) {
            $cat_ids[ $slug ] = $existing->term_id;
            continue;
        }

        $result = wp_insert_term(
            $data['name'],
            'product_cat',
            array(
                'slug'        => $slug,
                'description' => $data['description'],
            )
        );

        if ( ! is_wp_error( $result ) ) {
            $term_id = $result['term_id'];
            $cat_ids[ $slug ] = $term_id;

            // Set display type meta
            update_term_meta( $term_id, 'display_type', $data['display'] );
        }
    }

    return $cat_ids;
}

/* =========================================================
   CREATE SAMPLE PRODUCTS
========================================================= */

function impex_create_sample_products( $cat_ids ) {
    $products = array(

        // ---- Professional Match Balls ----
        array(
            'name'              => 'IMPEX Pro Match Ball FIFA Approved',
            'slug'              => 'impex-pro-match-ball-fifa',
            'sku'               => 'IMP-PRO-001',
            'price'             => '89.99',
            'regular_price'     => '89.99',
            'category'          => 'professional-match-balls',
            'featured'          => true,
            'stock'             => 150,
            'weight'            => '430',
            'description'       => '<p>The IMPEX Pro Match Ball is our flagship FIFA Quality Pro certified football. Constructed with 20-panel thermally bonded PU synthetic leather, this ball offers elite-level performance for international competitions, professional leagues, and top-tier tournaments.</p>
<h3>Key Features</h3>
<ul>
<li>FIFA Quality Pro Certified</li>
<li>20-panel thermally bonded construction</li>
<li>Premium PU synthetic leather outer</li>
<li>Butyl rubber bladder for optimal air retention</li>
<li>Size 5 | Weight: 410–450g | Circumference: 68–70cm</li>
<li>Suitable for all weather conditions</li>
<li>IMPEX exclusive grip texture for superior control</li>
</ul>',
            'short_description' => 'FIFA Quality Pro certified match ball. Premium thermally bonded PU construction for elite-level performance.',
            'tags'              => array( 'fifa', 'professional', 'match ball', 'size 5' ),
        ),

        array(
            'name'              => 'IMPEX Elite Match Ball',
            'slug'              => 'impex-elite-match-ball',
            'sku'               => 'IMP-ELT-002',
            'price'             => '74.99',
            'regular_price'     => '84.99',
            'sale_price'        => '74.99',
            'category'          => 'professional-match-balls',
            'featured'          => true,
            'stock'             => 200,
            'weight'            => '430',
            'description'       => '<p>The IMPEX Elite Match Ball delivers tournament-grade performance at an accessible price point. With 32-panel hand-stitched construction and a high-gloss PU surface, this ball is ideal for semi-professional and amateur leagues.</p>
<h3>Key Features</h3>
<ul>
<li>FIFA Quality Certified</li>
<li>32-panel hand-stitched construction</li>
<li>High-gloss PU outer surface</li>
<li>Latex rubber bladder</li>
<li>Size 5 | Weight: 410–450g</li>
<li>Vibrant IMPEX graphics</li>
</ul>',
            'short_description' => 'FIFA Quality certified elite match ball. 32-panel hand-stitched for tournament and league play.',
            'tags'              => array( 'elite', 'match ball', 'size 5', 'tournament' ),
        ),

        // ---- Training Balls ----
        array(
            'name'              => 'IMPEX Training Pro',
            'slug'              => 'impex-training-pro',
            'sku'               => 'IMP-TRN-003',
            'price'             => '45.99',
            'regular_price'     => '45.99',
            'category'          => 'training-balls',
            'featured'          => false,
            'stock'             => 500,
            'weight'            => '420',
            'description'       => '<p>The IMPEX Training Pro is engineered for heavy-duty daily training. Featuring a durable 32-panel machine-stitched PVC/PU hybrid outer, this ball withstands repeated use on all surface types without losing shape.</p>
<h3>Key Features</h3>
<ul>
<li>Durable PVC/PU hybrid outer</li>
<li>32-panel machine-stitched construction</li>
<li>Butyl bladder for excellent air retention</li>
<li>Suitable for grass, turf, and indoor courts</li>
<li>Size 5 | Weight: 400–440g</li>
<li>Available in bulk training packs</li>
</ul>',
            'short_description' => 'Heavy-duty training football for daily practice on all surfaces. Durable PVC/PU hybrid construction.',
            'tags'              => array( 'training', 'practice', 'durable', 'size 5' ),
        ),

        array(
            'name'              => 'IMPEX Club Trainer',
            'slug'              => 'impex-club-trainer',
            'sku'               => 'IMP-CLB-004',
            'price'             => '34.99',
            'regular_price'     => '34.99',
            'category'          => 'training-balls',
            'featured'          => false,
            'stock'             => 750,
            'weight'            => '410',
            'description'       => '<p>The IMPEX Club Trainer is the go-to choice for clubs looking for reliable training balls at a competitive price. Machine-stitched with a tough PVC outer, this ball is built to survive the rigours of squad training sessions day after day.</p>
<h3>Key Features</h3>
<ul>
<li>Tough PVC outer shell</li>
<li>Machine-stitched 32-panel design</li>
<li>Standard butyl bladder</li>
<li>Excellent value for club bulk orders</li>
<li>Size 5 | Weight: 400–430g</li>
</ul>',
            'short_description' => 'Reliable, durable club training ball. Ideal for bulk orders and squad sessions.',
            'tags'              => array( 'club', 'training', 'budget', 'bulk' ),
        ),

        // ---- Youth & Junior Balls ----
        array(
            'name'              => 'IMPEX Youth Star',
            'slug'              => 'impex-youth-star',
            'sku'               => 'IMP-YTH-005',
            'price'             => '29.99',
            'regular_price'     => '29.99',
            'category'          => 'youth-junior-balls',
            'featured'          => false,
            'stock'             => 400,
            'weight'            => '320',
            'description'       => '<p>The IMPEX Youth Star is designed for players aged 8–12. Size 4 construction with a softer PU outer provides the right feel for developing skills while reducing the risk of injury. Bright graphics inspire young players on the pitch.</p>
<h3>Key Features</h3>
<ul>
<li>Size 4 — ideal for ages 8–12</li>
<li>Soft-touch PU outer for reduced impact</li>
<li>Machine-stitched 32-panel construction</li>
<li>Bright, motivating IMPEX Youth graphics</li>
<li>Weight: 310–340g | Circumference: 63–66cm</li>
</ul>',
            'short_description' => 'Size 4 youth football for ages 8–12. Soft-touch PU outer with bright training graphics.',
            'tags'              => array( 'youth', 'size 4', 'junior', 'kids' ),
        ),

        array(
            'name'              => 'IMPEX Junior League',
            'slug'              => 'impex-junior-league',
            'sku'               => 'IMP-JNR-006',
            'price'             => '24.99',
            'regular_price'     => '24.99',
            'category'          => 'youth-junior-balls',
            'featured'          => false,
            'stock'             => 600,
            'weight'            => '250',
            'description'       => '<p>The IMPEX Junior League ball is perfect for the youngest players starting their football journey. Size 3 construction is lightweight and easy to control, helping under-8 players develop ball skills with confidence.</p>
<h3>Key Features</h3>
<ul>
<li>Size 3 — ideal for under 8 players</li>
<li>Lightweight PVC outer</li>
<li>Colourful, fun graphics</li>
<li>Soft bladder for gentle bounce</li>
<li>Weight: 230–260g | Circumference: 58–60cm</li>
</ul>',
            'short_description' => 'Size 3 junior ball for under-8 players. Lightweight with fun colours.',
            'tags'              => array( 'junior', 'size 3', 'under 8', 'beginner' ),
        ),

        // ---- Futsal Balls ----
        array(
            'name'              => 'IMPEX Futsal Master',
            'slug'              => 'impex-futsal-master',
            'sku'               => 'IMP-FUT-007',
            'price'             => '49.99',
            'regular_price'     => '49.99',
            'category'          => 'futsal-balls',
            'featured'          => true,
            'stock'             => 250,
            'weight'            => '440',
            'description'       => '<p>The IMPEX Futsal Master is approved for official futsal competitions. The low-bounce foam inner provides the characteristic reduced rebound essential for fast-paced indoor futsal. Premium felt outer for controlled touch on hard courts.</p>
<h3>Key Features</h3>
<ul>
<li>FIFA Futsal Approved</li>
<li>Low-bounce foam inner bladder</li>
<li>Premium felt/PU outer surface</li>
<li>32-panel hand-stitched construction</li>
<li>Size 4 Futsal | Weight: 400–440g</li>
<li>Designed for hard indoor courts</li>
</ul>',
            'short_description' => 'FIFA Futsal Approved ball. Low-bounce foam construction for indoor futsal courts.',
            'tags'              => array( 'futsal', 'indoor', 'low bounce', 'size 4' ),
        ),

        array(
            'name'              => 'IMPEX Futsal Club',
            'slug'              => 'impex-futsal-club',
            'sku'               => 'IMP-FUT-008',
            'price'             => '39.99',
            'regular_price'     => '39.99',
            'category'          => 'futsal-balls',
            'featured'          => false,
            'stock'             => 350,
            'weight'            => '430',
            'description'       => '<p>The IMPEX Futsal Club is a durable training futsal ball suitable for regular club and recreational use. Foam-filled bladder delivers consistent low bounce on all indoor surfaces.</p>
<h3>Key Features</h3>
<ul>
<li>Low-bounce foam bladder</li>
<li>Durable PU outer</li>
<li>Machine-stitched 32-panel construction</li>
<li>Great for club training and recreational futsal</li>
<li>Size 4 Futsal | Weight: 400–440g</li>
</ul>',
            'short_description' => 'Durable club-level futsal ball with low-bounce foam bladder for indoor use.',
            'tags'              => array( 'futsal', 'indoor', 'training', 'club' ),
        ),

        // ---- Beach Soccer Balls ----
        array(
            'name'              => 'IMPEX Beach King',
            'slug'              => 'impex-beach-king',
            'sku'               => 'IMP-BCH-009',
            'price'             => '44.99',
            'regular_price'     => '44.99',
            'category'          => 'beach-soccer-balls',
            'featured'          => true,
            'stock'             => 200,
            'weight'            => '400',
            'description'       => '<p>The IMPEX Beach King is our premium beach soccer ball, designed for the sand and sun. Soft, water-resistant PU panels provide a comfortable barefoot experience, while the bright graphics stand out on the beach.</p>
<h3>Key Features</h3>
<ul>
<li>Water-resistant PU outer panels</li>
<li>Soft surface for barefoot play</li>
<li>Bright multi-colour graphics</li>
<li>Latex bladder for lively bounce in sand</li>
<li>Size 5 | Weight: 380–420g</li>
<li>UV-resistant colours</li>
</ul>',
            'short_description' => 'Premium beach soccer ball. Water-resistant PU panels for barefoot sand play.',
            'tags'              => array( 'beach', 'sand', 'outdoor', 'water resistant' ),
        ),

        array(
            'name'              => 'IMPEX Beach Pro',
            'slug'              => 'impex-beach-pro',
            'sku'               => 'IMP-BCH-010',
            'price'             => '37.99',
            'regular_price'     => '37.99',
            'category'          => 'beach-soccer-balls',
            'featured'          => false,
            'stock'             => 300,
            'weight'            => '395',
            'description'       => '<p>The IMPEX Beach Pro is an excellent all-round beach soccer ball for recreational and club beach soccer. Durable water-resistant PVC outer with smooth panels designed for sandy conditions.</p>
<h3>Key Features</h3>
<ul>
<li>Water-resistant PVC outer</li>
<li>Smooth panel design for sand play</li>
<li>Standard latex bladder</li>
<li>Size 5 | Weight: 370–415g</li>
<li>Available in vibrant beach colours</li>
</ul>',
            'short_description' => 'Recreational beach soccer ball. Water-resistant PVC outer for sand play.',
            'tags'              => array( 'beach', 'sand', 'recreational', 'outdoor' ),
        ),

        // ---- Custom & Branded ----
        array(
            'name'              => 'IMPEX Custom Logo Ball (MOQ 50)',
            'slug'              => 'impex-custom-logo-ball',
            'sku'               => 'IMP-CUS-011',
            'price'             => '12.99',
            'regular_price'     => '12.99',
            'category'          => 'custom-branded-balls',
            'featured'          => true,
            'stock'             => 9999,
            'weight'            => '430',
            'description'       => '<p>Order your own custom branded IMPEX football with your club, school, or company logo. Minimum order quantity (MOQ) is 50 balls. Supplied on Size 5 base ball with full-colour logo printing.</p>
<h3>Customisation Options</h3>
<ul>
<li>Full-colour logo printing (up to 6 colours)</li>
<li>Choice of panel colour combinations</li>
<li>Custom text / player name printing available</li>
<li>Choice of ball grade: Training / Elite / Match</li>
<li>MOQ: 50 balls | Delivery: 3–4 weeks</li>
<li>Free artwork check and mockup provided</li>
</ul>
<h3>Price Per Unit (volume discounts)</h3>
<ul>
<li>50–99 units: $12.99/unit</li>
<li>100–249 units: $11.49/unit</li>
<li>250+ units: $10.49/unit</li>
</ul>
<p>Contact us for a custom quote: info@impexfootball.com</p>',
            'short_description' => 'Custom logo footballs with your club/brand. MOQ 50 units from $12.99/unit. 3–4 week delivery.',
            'tags'              => array( 'custom', 'branded', 'logo', 'bulk', 'promotional' ),
        ),

        array(
            'name'              => 'IMPEX Branded Team Ball (MOQ 100)',
            'slug'              => 'impex-branded-team-ball',
            'sku'               => 'IMP-CUS-012',
            'price'             => '10.99',
            'regular_price'     => '10.99',
            'category'          => 'custom-branded-balls',
            'featured'          => false,
            'stock'             => 9999,
            'weight'            => '420',
            'description'       => '<p>The IMPEX Branded Team Ball is perfect for academies, schools, and large club orders. Minimum 100 units with full team / sponsor branding. Great value bulk pricing with fast turnaround.</p>
<h3>Customisation Includes</h3>
<ul>
<li>Team name and badge printing</li>
<li>Sponsor logo placement (up to 2 sponsors)</li>
<li>Season year and player squad numbers (optional)</li>
<li>Choice of 8 base colour combinations</li>
<li>MOQ: 100 balls | Delivery: 4–5 weeks</li>
</ul>
<h3>Price Per Unit (volume discounts)</h3>
<ul>
<li>100–249 units: $10.99/unit</li>
<li>250–499 units: $9.49/unit</li>
<li>500+ units: $8.49/unit</li>
</ul>
<p>Request a quote: info@impexfootball.com</p>',
            'short_description' => 'Bulk branded team footballs. MOQ 100 units from $10.99/unit including team badge and sponsor printing.',
            'tags'              => array( 'branded', 'team', 'bulk', 'academy', 'school' ),
        ),
    );

    $count = 0;

    foreach ( $products as $product_data ) {
        // Skip if a product with this SKU already exists
        $existing_id = wc_get_product_id_by_sku( $product_data['sku'] );
        if ( $existing_id ) {
            continue;
        }

        $product = new WC_Product_Simple();

        $product->set_name( $product_data['name'] );
        $product->set_slug( $product_data['slug'] );
        $product->set_status( 'publish' );
        $product->set_catalog_visibility( 'visible' );
        $product->set_description( $product_data['description'] );
        $product->set_short_description( $product_data['short_description'] );
        $product->set_sku( $product_data['sku'] );
        $product->set_regular_price( $product_data['regular_price'] );

        if ( ! empty( $product_data['sale_price'] ) ) {
            $product->set_sale_price( $product_data['sale_price'] );
            $product->set_price( $product_data['sale_price'] );
        } else {
            $product->set_price( $product_data['price'] );
        }

        $product->set_manage_stock( true );
        $product->set_stock_quantity( $product_data['stock'] );
        $product->set_stock_status( 'instock' );
        $product->set_featured( $product_data['featured'] );
        $product->set_weight( $product_data['weight'] );

        // Assign category
        $cat_slug = $product_data['category'];
        if ( isset( $cat_ids[ $cat_slug ] ) ) {
            $product->set_category_ids( array( $cat_ids[ $cat_slug ] ) );
        }

        // Assign tags
        if ( ! empty( $product_data['tags'] ) ) {
            $tag_ids = array();
            foreach ( $product_data['tags'] as $tag ) {
                $term = get_term_by( 'name', $tag, 'product_tag' );
                if ( $term ) {
                    $tag_ids[] = $term->term_id;
                } else {
                    $result = wp_insert_term( $tag, 'product_tag' );
                    if ( ! is_wp_error( $result ) ) {
                        $tag_ids[] = $result['term_id'];
                    }
                }
            }
            $product->set_tag_ids( $tag_ids );
        }

        $product_id = $product->save();

        if ( $product_id ) {
            $count++;
        }
    }

    return $count;
}

/* =========================================================
   DEACTIVATION
========================================================= */

register_deactivation_hook( __FILE__, function() {
    wp_clear_scheduled_hook( 'impex_run_setup' );
} );
