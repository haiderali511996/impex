<?php
/**
 * WooCommerce Content Product Template — IMPEX Football
 * Used in product loops (shop page, category pages).
 *
 * @package ImpexFootball
 */

defined( 'ABSPATH' ) || exit;

global $product;

// Ensure visibility
if ( empty( $product ) || ! $product->is_visible() ) {
    return;
}

$product_id    = $product->get_id();
$product_name  = $product->get_name();
$product_url   = get_permalink( $product_id );
$product_sku   = $product->get_sku();
$product_cats  = wp_get_post_terms( $product_id, 'product_cat', array( 'fields' => 'names' ) );
$cat_name      = ! empty( $product_cats ) && ! is_wp_error( $product_cats ) ? $product_cats[0] : '';
$img_url       = get_the_post_thumbnail_url( $product_id, 'impex-product-card' );
?>

<li <?php wc_product_class( 'product-card', $product ); ?>>

  <!-- Product Image -->
  <a href="<?php echo esc_url( $product_url ); ?>" class="product-image-wrap woocommerce-LoopProduct-link woocommerce-loop-product__link">

    <?php if ( $img_url ) : ?>
      <img src="<?php echo esc_url( $img_url ); ?>"
           alt="<?php echo esc_attr( $product_name ); ?>"
           loading="lazy"
           width="400" height="400"
           class="attachment-impex-product-card size-impex-product-card wp-post-image">
    <?php else : ?>
      <div class="product-placeholder-svg" aria-hidden="true">
        <?php echo impex_get_football_svg( 120 ); // phpcs:ignore ?>
      </div>
    <?php endif; ?>

    <!-- Badges -->
    <?php if ( $product->is_featured() ) : ?>
      <span class="product-badge badge-hot onsale"><?php esc_html_e( 'HOT', 'impex-football' ); ?></span>
    <?php elseif ( $product->is_on_sale() ) : ?>
      <span class="product-badge badge-sale onsale"><?php esc_html_e( 'SALE', 'impex-football' ); ?></span>
    <?php elseif ( strtotime( $product->get_date_created() ) > strtotime( '-30 days' ) ) : ?>
      <span class="product-badge badge-new"><?php esc_html_e( 'NEW', 'impex-football' ); ?></span>
    <?php endif; ?>

  </a><!-- .product-image-wrap -->

  <!-- Product Info -->
  <div class="product-info">

    <?php if ( $cat_name ) : ?>
      <div class="product-category"><?php echo esc_html( $cat_name ); ?></div>
    <?php endif; ?>

    <h2 class="product-title woocommerce-loop-product__title">
      <a href="<?php echo esc_url( $product_url ); ?>"><?php echo esc_html( $product_name ); ?></a>
    </h2>

    <?php if ( $product_sku ) : ?>
      <div class="product-sku"><?php echo esc_html( 'SKU: ' . $product_sku ); ?></div>
    <?php endif; ?>

    <div class="product-price-row">
      <div class="product-price">
        <?php echo $product->get_price_html(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
      </div>

      <?php
      echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
          'woocommerce_loop_add_to_cart_link',
          sprintf(
              '<button class="add-to-cart-btn button %s" data-product_id="%d" data-product_sku="%s" aria-label="%s" rel="nofollow">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/>
                  <line x1="3" y1="6" x2="21" y2="6"/>
                  <path d="M16 10a4 4 0 01-8 0"/>
                </svg>
              </button>',
              esc_attr( $product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button ajax_add_to_cart' : '' ),
              esc_attr( $product_id ),
              esc_attr( $product_sku ),
              esc_attr( sprintf( __( 'Add "%s" to your cart', 'impex-football' ), $product_name ) )
          ),
          $product
      );
      ?>
    </div><!-- .product-price-row -->

  </div><!-- .product-info -->

</li>
