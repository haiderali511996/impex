<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="profile" href="https://gmpg.org/xfn/11">
  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="skip-link screen-reader-text" href="#main-content"><?php esc_html_e( 'Skip to content', 'impex-football' ); ?></a>

<header id="site-header" role="banner">
  <div class="container">
    <div class="header-inner">

      <!-- Logo -->
      <div class="site-logo">
        <?php impex_the_logo(); ?>
      </div>

      <!-- Primary Navigation -->
      <nav id="primary-nav" role="navigation" aria-label="<?php esc_attr_e( 'Primary Navigation', 'impex-football' ); ?>">
        <?php
        wp_nav_menu( array(
            'theme_location' => 'primary',
            'menu_class'     => 'primary-menu',
            'container'      => false,
            'walker'         => new Impex_Nav_Walker(),
            'fallback_cb'    => function() {
                // Fallback menu when no menu is assigned
                echo '<ul class="primary-menu">';
                echo '<li><a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html__( 'Home', 'impex-football' ) . '</a></li>';
                echo '<li><a href="' . esc_url( home_url( '/shop' ) ) . '">' . esc_html__( 'Shop', 'impex-football' ) . '</a>
                    <ul>
                        <li><a href="' . esc_url( home_url( '/product-category/professional-match-balls' ) ) . '">' . esc_html__( 'Professional Match Balls', 'impex-football' ) . '</a></li>
                        <li><a href="' . esc_url( home_url( '/product-category/training-balls' ) ) . '">' . esc_html__( 'Training Balls', 'impex-football' ) . '</a></li>
                        <li><a href="' . esc_url( home_url( '/product-category/youth-junior-balls' ) ) . '">' . esc_html__( 'Youth & Junior Balls', 'impex-football' ) . '</a></li>
                        <li><a href="' . esc_url( home_url( '/product-category/futsal-balls' ) ) . '">' . esc_html__( 'Futsal Balls', 'impex-football' ) . '</a></li>
                        <li><a href="' . esc_url( home_url( '/product-category/beach-soccer-balls' ) ) . '">' . esc_html__( 'Beach Soccer Balls', 'impex-football' ) . '</a></li>
                        <li><a href="' . esc_url( home_url( '/product-category/custom-branded-balls' ) ) . '">' . esc_html__( 'Custom & Branded', 'impex-football' ) . '</a></li>
                    </ul>
                </li>';
                echo '<li><a href="' . esc_url( home_url( '/about' ) ) . '">' . esc_html__( 'About', 'impex-football' ) . '</a></li>';
                echo '<li><a href="' . esc_url( home_url( '/contact' ) ) . '">' . esc_html__( 'Contact', 'impex-football' ) . '</a></li>';
                echo '</ul>';
            },
        ) );
        ?>
      </nav>

      <!-- Header Actions -->
      <div class="header-actions">

        <!-- Search -->
        <button class="header-search-toggle" id="searchToggle" aria-label="<?php esc_attr_e( 'Toggle search', 'impex-football' ); ?>">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="11" cy="11" r="8"></circle>
            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
          </svg>
        </button>

        <?php if ( function_exists( 'WC' ) ) : ?>
        <!-- Cart -->
        <a href="<?php echo esc_url( impex_cart_url() ); ?>" class="header-cart" aria-label="<?php esc_attr_e( 'Shopping cart', 'impex-football' ); ?>">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="9" cy="21" r="1"></circle>
            <circle cx="20" cy="21" r="1"></circle>
            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
          </svg>
          <?php
          $cart_count = impex_cart_count();
          if ( $cart_count > 0 ) :
          ?>
          <span class="cart-count" id="cartCount"><?php echo esc_html( $cart_count ); ?></span>
          <?php endif; ?>
        </a>
        <?php endif; ?>

        <!-- Mobile Toggle -->
        <button class="mobile-menu-toggle" id="mobileMenuToggle" aria-label="<?php esc_attr_e( 'Toggle mobile menu', 'impex-football' ); ?>" aria-expanded="false" aria-controls="primary-nav">
          <span></span>
          <span></span>
          <span></span>
        </button>
      </div><!-- .header-actions -->

    </div><!-- .header-inner -->
  </div><!-- .container -->

  <!-- Search Dropdown -->
  <div class="header-search-bar" id="headerSearchBar" hidden>
    <div class="container">
      <?php get_search_form(); ?>
    </div>
  </div>
</header>

<main id="main-content" role="main">
