<?php
/**
 * WooCommerce Single Product Template — IMPEX Football
 *
 * @package ImpexFootball
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );
?>

<div class="single-product-wrapper">
  <div class="container">

    <?php woocommerce_breadcrumb(); ?>

    <?php while ( have_posts() ) : ?>
      <?php the_post(); ?>
      <?php wc_get_template_part( 'content', 'single-product' ); ?>
    <?php endwhile; ?>

    <!-- Related Products -->
    <?php
    global $product;
    if ( $product ) :
      $related_ids = wc_get_related_products( $product->get_id(), 4 );
      if ( ! empty( $related_ids ) ) :
    ?>
    <section class="related-products" style="margin-top:4rem; padding-top:3rem; border-top:1px solid var(--color-dark-3);" aria-labelledby="related-heading">
      <div class="section-header" style="margin-bottom:2rem; text-align:left;">
        <h2 id="related-heading" style="font-size:1.4rem;"><?php esc_html_e( 'Related Products', 'impex-football' ); ?></h2>
      </div>
      <div class="products-grid">
        <?php foreach ( $related_ids as $related_id ) :
          $related = wc_get_product( $related_id );
          if ( ! $related ) continue;
          $r_img   = get_the_post_thumbnail_url( $related_id, 'impex-product-card' );
          $r_cats  = wp_get_post_terms( $related_id, 'product_cat', array( 'fields' => 'names' ) );
          $r_cat   = ! empty( $r_cats ) ? $r_cats[0] : '';
        ?>
        <article class="product-card">
          <a href="<?php echo esc_url( get_permalink( $related_id ) ); ?>" class="product-image-wrap">
            <?php if ( $r_img ) : ?>
              <img src="<?php echo esc_url( $r_img ); ?>" alt="<?php echo esc_attr( $related->get_name() ); ?>" loading="lazy">
            <?php else : ?>
              <?php echo impex_get_football_svg( 120, 'product-placeholder-svg' ); // phpcs:ignore ?>
            <?php endif; ?>
          </a>
          <div class="product-info">
            <?php if ( $r_cat ) : ?>
              <div class="product-category"><?php echo esc_html( $r_cat ); ?></div>
            <?php endif; ?>
            <h3 class="product-title">
              <a href="<?php echo esc_url( get_permalink( $related_id ) ); ?>"><?php echo esc_html( $related->get_name() ); ?></a>
            </h3>
            <div class="product-price-row">
              <div class="product-price"><?php echo $related->get_price_html(); // phpcs:ignore ?></div>
              <?php if ( $related->is_purchasable() && $related->is_in_stock() ) : ?>
                <a href="<?php echo esc_url( get_permalink( $related_id ) ); ?>" class="add-to-cart-btn" aria-label="<?php echo esc_attr( $related->get_name() ); ?>">
                  <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg>
                </a>
              <?php endif; ?>
            </div>
          </div>
        </article>
        <?php endforeach; ?>
      </div>
    </section>
    <?php endif; endif; ?>

  </div><!-- .container -->
</div><!-- .single-product-wrapper -->

<?php get_footer( 'shop' );
