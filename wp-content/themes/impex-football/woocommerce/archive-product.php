<?php
/**
 * WooCommerce Archive Product Template — IMPEX Football
 * Shop page and product category pages.
 *
 * @package ImpexFootball
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );

/**
 * Hook: woocommerce_before_main_content.
 */
do_action( 'woocommerce_before_main_content' );
?>

<div class="woocommerce-page-wrapper">
  <div class="container">

    <!-- Page header -->
    <div class="shop-header">
      <?php if ( is_shop() ) : ?>
        <h1 class="shop-title"><?php esc_html_e( 'Our Products', 'impex-football' ); ?></h1>
      <?php elseif ( is_product_category() ) : ?>
        <div>
          <div style="font-size:0.78rem; color:var(--color-gold); letter-spacing:3px; text-transform:uppercase; margin-bottom:0.4rem;">
            <?php esc_html_e( 'Category', 'impex-football' ); ?>
          </div>
          <h1 class="shop-title">
            <?php
            $cat = get_queried_object();
            echo esc_html( $cat->name );
            ?>
          </h1>
        </div>
      <?php else : ?>
        <h1 class="shop-title"><?php woocommerce_page_title(); ?></h1>
      <?php endif; ?>

      <div style="display:flex; align-items:center; gap:1rem; flex-wrap:wrap;">
        <?php woocommerce_result_count(); ?>
        <?php woocommerce_catalog_ordering(); ?>
      </div>
    </div>

    <!-- Breadcrumb -->
    <?php woocommerce_breadcrumb(); ?>

    <!-- Category description -->
    <?php if ( is_product_category() ) :
      $cat = get_queried_object();
      if ( $cat->description ) :
    ?>
    <p style="color:var(--color-grey-light); margin-bottom:2rem; max-width:700px; font-size:0.95rem; line-height:1.7;">
      <?php echo esc_html( $cat->description ); ?>
    </p>
    <?php endif; endif; ?>

    <div class="shop-layout">

      <!-- Sidebar Filters -->
      <aside class="shop-sidebar">
        <?php if ( is_active_sidebar( 'shop-sidebar' ) ) : ?>
          <?php dynamic_sidebar( 'shop-sidebar' ); ?>
        <?php else : ?>

          <!-- Category Filter Widget -->
          <div class="sidebar-widget">
            <h4><?php esc_html_e( 'Categories', 'impex-football' ); ?></h4>
            <?php
            $categories = get_terms( array(
                'taxonomy'   => 'product_cat',
                'hide_empty' => true,
                'parent'     => 0,
            ) );
            if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) :
            ?>
            <ul>
              <?php foreach ( $categories as $cat ) : ?>
                <li>
                  <a href="<?php echo esc_url( get_term_link( $cat ) ); ?>">
                    <?php echo esc_html( $cat->name ); ?>
                    <span style="font-size:0.75rem; color:var(--color-grey);">(<?php echo esc_html( $cat->count ); ?>)</span>
                  </a>
                </li>
              <?php endforeach; ?>
            </ul>
            <?php endif; ?>
          </div>

          <!-- Price Range Widget -->
          <div class="sidebar-widget">
            <h4><?php esc_html_e( 'Price Range', 'impex-football' ); ?></h4>
            <?php
            $price_ranges = array(
                array( 'label' => __( 'Under $30', 'impex-football' ),   'min' => 0,  'max' => 30  ),
                array( 'label' => __( '$30 – $50', 'impex-football' ),   'min' => 30, 'max' => 50  ),
                array( 'label' => __( '$50 – $75', 'impex-football' ),   'min' => 50, 'max' => 75  ),
                array( 'label' => __( 'Over $75', 'impex-football' ),    'min' => 75, 'max' => 9999),
            );
            $current_url = esc_url( remove_query_arg( array( 'min_price', 'max_price' ) ) );
            ?>
            <ul>
              <?php foreach ( $price_ranges as $range ) : ?>
                <li>
                  <a href="<?php echo esc_url( add_query_arg( array( 'min_price' => $range['min'], 'max_price' => $range['max'] ), $current_url ) ); ?>">
                    <?php echo esc_html( $range['label'] ); ?>
                  </a>
                </li>
              <?php endforeach; ?>
            </ul>
          </div>

          <!-- Quick Info Widget -->
          <div class="sidebar-widget">
            <h4><?php esc_html_e( 'Why IMPEX', 'impex-football' ); ?></h4>
            <ul style="list-style:none;">
              <?php
              $reasons = array(
                  __( '✅ FIFA Approved Balls', 'impex-football' ),
                  __( '🚚 Free Shipping $100+', 'impex-football' ),
                  __( '🔄 30-Day Returns', 'impex-football' ),
                  __( '⚽ 30+ Years Experience', 'impex-football' ),
                  __( '🎨 Custom Branding', 'impex-football' ),
              );
              foreach ( $reasons as $reason ) :
              ?>
                <li style="font-size:0.85rem; color:var(--color-grey-light); padding:0.4rem 0; border-bottom:1px solid rgba(255,255,255,0.04);">
                  <?php echo esc_html( $reason ); ?>
                </li>
              <?php endforeach; ?>
            </ul>
          </div>

        <?php endif; ?>
      </aside><!-- .shop-sidebar -->

      <!-- Products Main Area -->
      <div class="shop-main">

        <?php if ( woocommerce_product_loop() ) : ?>

          <?php
          /**
           * Hook: woocommerce_before_shop_loop.
           */
          do_action( 'woocommerce_before_shop_loop' );
          ?>

          <?php woocommerce_product_loop_start(); ?>

          <?php if ( wc_get_loop_prop( 'total' ) ) : ?>
            <?php while ( have_posts() ) : ?>
              <?php the_post(); ?>
              <?php wc_get_template_part( 'content', 'product' ); ?>
            <?php endwhile; ?>
          <?php endif; ?>

          <?php woocommerce_product_loop_end(); ?>

          <?php
          /**
           * Hook: woocommerce_after_shop_loop.
           */
          do_action( 'woocommerce_after_shop_loop' );
          ?>

        <?php else : ?>

          <!-- No products found -->
          <div class="text-center" style="padding:4rem 2rem; background:var(--color-dark-2); border-radius:12px; border:1px solid var(--color-dark-3);">
            <div style="font-size:3rem; margin-bottom:1rem;" aria-hidden="true">⚽</div>
            <h2 style="font-size:1.4rem; margin-bottom:0.75rem;"><?php esc_html_e( 'No products found', 'impex-football' ); ?></h2>
            <p style="color:var(--color-grey-light); margin-bottom:1.5rem;">
              <?php esc_html_e( 'Try browsing a different category or use the search.', 'impex-football' ); ?>
            </p>
            <a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="btn btn-primary">
              <?php esc_html_e( 'Back to Shop', 'impex-football' ); ?>
            </a>
          </div>

          <?php do_action( 'woocommerce_no_products_found' ); ?>

        <?php endif; ?>

      </div><!-- .shop-main -->

    </div><!-- .shop-layout -->

  </div><!-- .container -->
</div><!-- .woocommerce-page-wrapper -->

<?php
/**
 * Hook: woocommerce_after_main_content.
 */
do_action( 'woocommerce_after_main_content' );

/**
 * Hook: woocommerce_sidebar.
 */
do_action( 'woocommerce_sidebar' );

get_footer( 'shop' );
