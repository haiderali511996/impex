<?php
/**
 * Front Page Template — IMPEX Football
 *
 * @package ImpexFootball
 */

get_header();
?>

<!-- =============================================
     HERO SECTION
============================================= -->
<section class="hero-section" aria-label="<?php esc_attr_e( 'Homepage hero', 'impex-football' ); ?>">
  <div class="hero-bg"></div>
  <div class="hero-pattern"></div>

  <div class="container">
    <div class="hero-content">

      <div class="hero-text">
        <div class="hero-badge">
          <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
          <?php esc_html_e( 'FIFA Quality Pro Certified', 'impex-football' ); ?>
        </div>

        <h1 class="hero-title">
          <?php esc_html_e( 'Precision', 'impex-football' ); ?>
          <span class="gold-text"><?php esc_html_e( 'Engineered', 'impex-football' ); ?></span>
          <?php esc_html_e( 'Footballs', 'impex-football' ); ?>
        </h1>

        <p class="hero-description">
          <?php esc_html_e( 'IMPEX delivers world-class footballs trusted by professional clubs, national teams, and grassroots players across 60+ countries. From match-day perfection to custom branded orders.', 'impex-football' ); ?>
        </p>

        <div class="hero-actions">
          <a href="<?php echo esc_url( function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/shop' ) ); ?>" class="btn btn-primary btn-lg">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg>
            <?php esc_html_e( 'Shop Now', 'impex-football' ); ?>
          </a>
          <a href="<?php echo esc_url( home_url( '/product-category/custom-branded-balls' ) ); ?>" class="btn btn-outline btn-lg">
            <?php esc_html_e( 'Custom Orders', 'impex-football' ); ?>
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
          </a>
        </div>

        <div class="hero-stats">
          <div class="stat-item">
            <div class="stat-number">30+</div>
            <div class="stat-label"><?php esc_html_e( 'Years Experience', 'impex-football' ); ?></div>
          </div>
          <div class="stat-item">
            <div class="stat-number">60+</div>
            <div class="stat-label"><?php esc_html_e( 'Countries Served', 'impex-football' ); ?></div>
          </div>
          <div class="stat-item">
            <div class="stat-number">2M+</div>
            <div class="stat-label"><?php esc_html_e( 'Balls Produced', 'impex-football' ); ?></div>
          </div>
          <div class="stat-item">
            <div class="stat-number">FIFA</div>
            <div class="stat-label"><?php esc_html_e( 'Quality Approved', 'impex-football' ); ?></div>
          </div>
        </div>
      </div><!-- .hero-text -->

      <!-- Hero Visual — SVG Football -->
      <div class="hero-visual" aria-hidden="true">
        <div class="hero-football-wrapper">
          <div class="glow-ring"></div>
          <svg class="hero-football-svg" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
            <!-- Outer glow circle -->
            <circle cx="100" cy="100" r="95" fill="rgba(255,215,0,0.04)" stroke="rgba(255,215,0,0.12)" stroke-width="1"/>
            <!-- Main ball -->
            <circle cx="100" cy="100" r="85" fill="url(#heroGrad)" stroke="#444" stroke-width="2"/>
            <defs>
              <radialGradient id="heroGrad" cx="35%" cy="30%" r="70%">
                <stop offset="0%" stop-color="#ffffff"/>
                <stop offset="60%" stop-color="#e0e0e0"/>
                <stop offset="100%" stop-color="#bbbbbb"/>
              </radialGradient>
            </defs>
            <!-- Pentagon patches -->
            <polygon points="100,44 117,58 112,78 88,78 83,58" fill="#111111" stroke="#555" stroke-width="1"/>
            <polygon points="50,60 68,50 83,58 74,76 54,76" fill="#111111" stroke="#555" stroke-width="1"/>
            <polygon points="150,60 132,50 117,58 126,76 146,76" fill="#111111" stroke="#555" stroke-width="1"/>
            <polygon points="46,116 60,108 74,76 66,94 52,104" fill="#111111" stroke="#555" stroke-width="1"/>
            <polygon points="154,116 140,108 126,76 134,94 148,104" fill="#111111" stroke="#555" stroke-width="1"/>
            <polygon points="70,152 88,78 112,78 130,152 100,162" fill="#111111" stroke="#555" stroke-width="1"/>
            <!-- Shine highlight -->
            <ellipse cx="75" cy="65" rx="18" ry="12" fill="rgba(255,255,255,0.25)" transform="rotate(-20,75,65)"/>
            <!-- Gold accent ring -->
            <circle cx="100" cy="100" r="85" fill="none" stroke="rgba(255,215,0,0.2)" stroke-width="3"/>
          </svg>
        </div>
      </div><!-- .hero-visual -->

    </div><!-- .hero-content -->
  </div><!-- .container -->
</section><!-- .hero-section -->


<!-- =============================================
     PRODUCT CATEGORIES
============================================= -->
<section class="categories-section section" id="categories" aria-labelledby="categories-heading">
  <div class="container">
    <div class="section-header">
      <h2 id="categories-heading"><?php esc_html_e( 'Shop by Category', 'impex-football' ); ?></h2>
      <div class="gold-line"></div>
      <p><?php esc_html_e( 'Explore our complete range of premium footballs for every level of play.', 'impex-football' ); ?></p>
    </div>

    <?php
    $categories = array(
        array(
            'name'  => __( 'Professional Match Balls', 'impex-football' ),
            'slug'  => 'professional-match-balls',
            'desc'  => __( 'FIFA approved for elite competition', 'impex-football' ),
        ),
        array(
            'name'  => __( 'Training Balls', 'impex-football' ),
            'slug'  => 'training-balls',
            'desc'  => __( 'Durable balls for daily sessions', 'impex-football' ),
        ),
        array(
            'name'  => __( 'Youth & Junior Balls', 'impex-football' ),
            'slug'  => 'youth-junior-balls',
            'desc'  => __( 'Perfect size for young players', 'impex-football' ),
        ),
        array(
            'name'  => __( 'Futsal Balls', 'impex-football' ),
            'slug'  => 'futsal-balls',
            'desc'  => __( 'Low-bounce indoor futsal balls', 'impex-football' ),
        ),
        array(
            'name'  => __( 'Beach Soccer Balls', 'impex-football' ),
            'slug'  => 'beach-soccer-balls',
            'desc'  => __( 'Water-resistant for sand play', 'impex-football' ),
        ),
        array(
            'name'  => __( 'Custom & Branded', 'impex-football' ),
            'slug'  => 'custom-branded-balls',
            'desc'  => __( 'Personalised club & team balls', 'impex-football' ),
        ),
    );
    ?>

    <div class="categories-grid">
      <?php foreach ( $categories as $cat ) :
        $cat_url = home_url( '/product-category/' . $cat['slug'] );

        // Try to get the actual WooCommerce term
        if ( function_exists( 'get_term_by' ) ) {
            $term = get_term_by( 'slug', $cat['slug'], 'product_cat' );
            if ( $term ) {
                $cat_url = get_term_link( $term );
            }
        }
      ?>
      <article class="category-card" onclick="window.location='<?php echo esc_url( $cat_url ); ?>'">
        <div class="category-icon">
          <?php echo impex_category_icon( $cat['slug'] ); // phpcs:ignore ?>
        </div>
        <h3><?php echo esc_html( $cat['name'] ); ?></h3>
        <p><?php echo esc_html( $cat['desc'] ); ?></p>
        <a class="category-link" href="<?php echo esc_url( $cat_url ); ?>">
          <?php esc_html_e( 'Browse →', 'impex-football' ); ?>
        </a>
      </article>
      <?php endforeach; ?>
    </div><!-- .categories-grid -->
  </div><!-- .container -->
</section><!-- .categories-section -->


<!-- =============================================
     WHY CHOOSE US
============================================= -->
<section class="why-section section" aria-labelledby="why-heading">
  <div class="container">
    <div class="section-header">
      <h2 id="why-heading"><?php esc_html_e( 'Why Choose IMPEX?', 'impex-football' ); ?></h2>
      <div class="gold-line"></div>
      <p><?php esc_html_e( 'Three decades of football manufacturing expertise, trusted worldwide.', 'impex-football' ); ?></p>
    </div>

    <div class="features-grid">
      <div class="feature-item">
        <div class="feature-icon" aria-hidden="true">🏆</div>
        <h3><?php esc_html_e( 'FIFA Approved', 'impex-football' ); ?></h3>
        <p><?php esc_html_e( 'Our Professional Match Balls carry FIFA Quality Pro certification — the gold standard in football manufacturing.', 'impex-football' ); ?></p>
      </div>

      <div class="feature-item">
        <div class="feature-icon" aria-hidden="true">⚙️</div>
        <h3><?php esc_html_e( 'Precision Engineering', 'impex-football' ); ?></h3>
        <p><?php esc_html_e( 'Every ball is crafted with thermally bonded panels and multi-layer construction for perfect roundness and consistent flight.', 'impex-football' ); ?></p>
      </div>

      <div class="feature-item">
        <div class="feature-icon" aria-hidden="true">🌍</div>
        <h3><?php esc_html_e( 'Global Delivery', 'impex-football' ); ?></h3>
        <p><?php esc_html_e( 'We ship worldwide. Orders are dispatched within 48 hours from our Sialkot facility with full tracking provided.', 'impex-football' ); ?></p>
      </div>

      <div class="feature-item">
        <div class="feature-icon" aria-hidden="true">🎨</div>
        <h3><?php esc_html_e( 'Custom Branding', 'impex-football' ); ?></h3>
        <p><?php esc_html_e( 'Order branded balls for your club, school, or corporate event with your logo from as low as 50 units.', 'impex-football' ); ?></p>
      </div>

      <div class="feature-item">
        <div class="feature-icon" aria-hidden="true">✅</div>
        <h3><?php esc_html_e( 'Quality Guarantee', 'impex-football' ); ?></h3>
        <p><?php esc_html_e( 'Every product comes with a 12-month manufacturer warranty. Not satisfied? We offer a hassle-free return policy.', 'impex-football' ); ?></p>
      </div>

      <div class="feature-item">
        <div class="feature-icon" aria-hidden="true">💼</div>
        <h3><?php esc_html_e( 'Wholesale & B2B', 'impex-football' ); ?></h3>
        <p><?php esc_html_e( 'Volume pricing available for distributors, clubs, and retailers. Contact our sales team for custom quotes.', 'impex-football' ); ?></p>
      </div>
    </div><!-- .features-grid -->
  </div><!-- .container -->
</section><!-- .why-section -->


<!-- =============================================
     FEATURED PRODUCTS
============================================= -->
<section class="products-section section" aria-labelledby="products-heading">
  <div class="container">
    <div class="section-header">
      <h2 id="products-heading"><?php esc_html_e( 'Featured Products', 'impex-football' ); ?></h2>
      <div class="gold-line"></div>
      <p><?php esc_html_e( 'Our best-selling footballs across all categories.', 'impex-football' ); ?></p>
    </div>

    <?php
    if ( function_exists( 'wc_get_products' ) ) :
        $featured_products = wc_get_products( array(
            'status'   => 'publish',
            'limit'    => 8,
            'orderby'  => 'date',
            'order'    => 'DESC',
        ) );

        if ( ! empty( $featured_products ) ) :
    ?>
    <div class="products-grid">
      <?php foreach ( $featured_products as $product ) :
        $product_id    = $product->get_id();
        $product_name  = $product->get_name();
        $product_price = $product->get_price_html();
        $product_url   = get_permalink( $product_id );
        $product_sku   = $product->get_sku();
        $product_cats  = wp_get_post_terms( $product_id, 'product_cat', array( 'fields' => 'names' ) );
        $cat_name      = ! empty( $product_cats ) ? $product_cats[0] : '';
        $img_url       = get_the_post_thumbnail_url( $product_id, 'impex-product-card' );
      ?>
      <article class="product-card">
        <a href="<?php echo esc_url( $product_url ); ?>" class="product-image-wrap">
          <?php if ( $img_url ) : ?>
            <img src="<?php echo esc_url( $img_url ); ?>" alt="<?php echo esc_attr( $product_name ); ?>" loading="lazy">
          <?php else : ?>
            <?php echo impex_get_football_svg( 120, 'product-placeholder-svg' ); // phpcs:ignore ?>
          <?php endif; ?>
          <?php if ( $product->is_featured() ) : ?>
            <span class="product-badge badge-hot"><?php esc_html_e( 'HOT', 'impex-football' ); ?></span>
          <?php elseif ( $product->is_on_sale() ) : ?>
            <span class="product-badge badge-sale"><?php esc_html_e( 'SALE', 'impex-football' ); ?></span>
          <?php endif; ?>
        </a>
        <div class="product-info">
          <?php if ( $cat_name ) : ?>
            <div class="product-category"><?php echo esc_html( $cat_name ); ?></div>
          <?php endif; ?>
          <h3 class="product-title">
            <a href="<?php echo esc_url( $product_url ); ?>"><?php echo esc_html( $product_name ); ?></a>
          </h3>
          <?php if ( $product_sku ) : ?>
            <div class="product-sku"><?php echo esc_html( 'SKU: ' . $product_sku ); ?></div>
          <?php endif; ?>
          <div class="product-price-row">
            <div class="product-price"><?php echo $product_price; // phpcs:ignore ?></div>
            <?php if ( $product->is_purchasable() && $product->is_in_stock() ) : ?>
              <button class="add-to-cart-btn"
                      data-product-id="<?php echo esc_attr( $product_id ); ?>"
                      aria-label="<?php echo esc_attr( sprintf( __( 'Add %s to cart', 'impex-football' ), $product_name ) ); ?>">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg>
              </button>
            <?php endif; ?>
          </div>
        </div>
      </article>
      <?php endforeach; ?>
    </div><!-- .products-grid -->

    <?php else : ?>
    <!-- Fallback static product display if WooCommerce not installed -->
    <div class="products-grid">
      <?php
      $static_products = array(
          array( 'name' => 'IMPEX Pro Match Ball FIFA Approved', 'price' => '$89.99', 'sku' => 'IMP-PRO-001', 'cat' => 'Professional Match Balls', 'badge' => 'HOT' ),
          array( 'name' => 'IMPEX Elite Match Ball',             'price' => '$74.99', 'sku' => 'IMP-ELT-002', 'cat' => 'Professional Match Balls', 'badge' => 'NEW' ),
          array( 'name' => 'IMPEX Training Pro',                 'price' => '$45.99', 'sku' => 'IMP-TRN-003', 'cat' => 'Training Balls',           'badge' => ''    ),
          array( 'name' => 'IMPEX Club Trainer',                 'price' => '$34.99', 'sku' => 'IMP-CLB-004', 'cat' => 'Training Balls',           'badge' => ''    ),
          array( 'name' => 'IMPEX Youth Star',                   'price' => '$29.99', 'sku' => 'IMP-YTH-005', 'cat' => 'Youth & Junior Balls',     'badge' => 'NEW' ),
          array( 'name' => 'IMPEX Junior League',                'price' => '$24.99', 'sku' => 'IMP-JNR-006', 'cat' => 'Youth & Junior Balls',     'badge' => ''    ),
          array( 'name' => 'IMPEX Futsal Master',                'price' => '$49.99', 'sku' => 'IMP-FUT-007', 'cat' => 'Futsal Balls',             'badge' => 'HOT' ),
          array( 'name' => 'IMPEX Beach King',                   'price' => '$44.99', 'sku' => 'IMP-BCH-009', 'cat' => 'Beach Soccer Balls',       'badge' => ''    ),
      );
      foreach ( $static_products as $p ) :
      ?>
      <article class="product-card">
        <div class="product-image-wrap">
          <?php echo impex_get_football_svg( 120, 'product-placeholder-svg' ); // phpcs:ignore ?>
          <?php if ( $p['badge'] ) : ?>
            <span class="product-badge badge-<?php echo esc_attr( strtolower( $p['badge'] ) ); ?>"><?php echo esc_html( $p['badge'] ); ?></span>
          <?php endif; ?>
        </div>
        <div class="product-info">
          <div class="product-category"><?php echo esc_html( $p['cat'] ); ?></div>
          <h3 class="product-title"><?php echo esc_html( $p['name'] ); ?></h3>
          <div class="product-sku"><?php echo esc_html( 'SKU: ' . $p['sku'] ); ?></div>
          <div class="product-price-row">
            <div class="product-price"><?php echo esc_html( $p['price'] ); ?></div>
            <button class="add-to-cart-btn" aria-label="<?php echo esc_attr( sprintf( __( 'Add %s to cart', 'impex-football' ), $p['name'] ) ); ?>">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg>
            </button>
          </div>
        </div>
      </article>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>
    <?php else : ?>
    <!-- WooCommerce not active — static display -->
    <p class="text-grey text-center"><?php esc_html_e( 'Install WooCommerce to display live products.', 'impex-football' ); ?></p>
    <?php endif; ?>

    <div class="text-center" style="margin-top:3rem;">
      <a href="<?php echo esc_url( function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/shop' ) ); ?>" class="btn btn-primary btn-lg">
        <?php esc_html_e( 'View All Products', 'impex-football' ); ?>
      </a>
    </div>
  </div><!-- .container -->
</section><!-- .products-section -->


<!-- =============================================
     PROMO BANNER — CUSTOM ORDERS
============================================= -->
<section class="section" aria-label="<?php esc_attr_e( 'Custom orders CTA', 'impex-football' ); ?>" style="background: var(--color-black);">
  <div class="container">
    <div class="promo-banner">
      <div style="font-size:3rem; margin-bottom:1rem;" aria-hidden="true">⚽</div>
      <h2><?php esc_html_e( 'Custom Branded Footballs for Your Club', 'impex-football' ); ?></h2>
      <p><?php esc_html_e( 'Order minimum 50 balls with your club logo, team colours, or sponsor branding. Perfect for academies, leagues, and corporate gifting. Volume discounts available.', 'impex-football' ); ?></p>
      <div style="display:flex; gap:1rem; justify-content:center; flex-wrap:wrap;">
        <a href="<?php echo esc_url( home_url( '/product-category/custom-branded-balls' ) ); ?>" class="btn btn-primary btn-lg">
          <?php esc_html_e( 'Get a Quote', 'impex-football' ); ?>
        </a>
        <a href="<?php echo esc_url( home_url( '/contact' ) ); ?>" class="btn btn-outline btn-lg">
          <?php esc_html_e( 'Contact Sales', 'impex-football' ); ?>
        </a>
      </div>
    </div>
  </div>
</section>

<?php get_footer(); ?>
