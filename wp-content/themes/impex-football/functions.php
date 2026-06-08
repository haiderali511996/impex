<?php
/**
 * IMPEX Football Theme Functions
 *
 * @package ImpexFootball
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Theme version constant
define( 'IMPEX_THEME_VERSION', '1.0.0' );
define( 'IMPEX_THEME_DIR', get_template_directory() );
define( 'IMPEX_THEME_URI', get_template_directory_uri() );

/* =========================================================
   THEME SETUP
========================================================= */

if ( ! function_exists( 'impex_theme_setup' ) ) :
    function impex_theme_setup() {

        // Make theme translatable
        load_theme_textdomain( 'impex-football', IMPEX_THEME_DIR . '/languages' );

        // Automatic feed links
        add_theme_support( 'automatic-feed-links' );

        // Title tag support
        add_theme_support( 'title-tag' );

        // Post thumbnails
        add_theme_support( 'post-thumbnails' );
        set_post_thumbnail_size( 600, 600, true );
        add_image_size( 'impex-product-card', 400, 400, true );
        add_image_size( 'impex-product-single', 700, 700, false );
        add_image_size( 'impex-hero', 1280, 720, true );

        // HTML5 support
        add_theme_support( 'html5', array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
            'style',
            'script',
        ) );

        // Custom logo
        add_theme_support( 'custom-logo', array(
            'height'      => 80,
            'width'       => 250,
            'flex-height' => true,
            'flex-width'  => true,
        ) );

        // Custom background
        add_theme_support( 'custom-background', array(
            'default-color' => '0a0a0a',
        ) );

        // WooCommerce support
        add_theme_support( 'woocommerce', array(
            'thumbnail_image_width' => 400,
            'single_image_width'    => 700,
            'product_grid'          => array(
                'default_rows'    => 3,
                'min_rows'        => 2,
                'max_rows'        => 8,
                'default_columns' => 4,
                'min_columns'     => 2,
                'max_columns'     => 5,
            ),
        ) );
        add_theme_support( 'wc-product-gallery-zoom' );
        add_theme_support( 'wc-product-gallery-lightbox' );
        add_theme_support( 'wc-product-gallery-slider' );

        // Register nav menus
        register_nav_menus( array(
            'primary'  => __( 'Primary Navigation', 'impex-football' ),
            'footer-1' => __( 'Footer Column 1', 'impex-football' ),
            'footer-2' => __( 'Footer Column 2', 'impex-football' ),
        ) );

        // Selective refresh for widgets
        add_theme_support( 'customize-selective-refresh-widgets' );
    }
endif;
add_action( 'after_setup_theme', 'impex_theme_setup' );

/* =========================================================
   ENQUEUE SCRIPTS & STYLES
========================================================= */

function impex_enqueue_assets() {

    // Main stylesheet
    wp_enqueue_style(
        'impex-style',
        get_stylesheet_uri(),
        array(),
        IMPEX_THEME_VERSION
    );

    // Additional CSS
    wp_enqueue_style(
        'impex-main-css',
        IMPEX_THEME_URI . '/assets/css/main.css',
        array( 'impex-style' ),
        IMPEX_THEME_VERSION
    );

    // Google Fonts (optional – loaded locally via CSS fallback)
    // wp_enqueue_style( 'impex-fonts', 'https://fonts.googleapis.com/...', array(), null );

    // Main JS
    wp_enqueue_script(
        'impex-main-js',
        IMPEX_THEME_URI . '/assets/js/main.js',
        array( 'jquery' ),
        IMPEX_THEME_VERSION,
        true
    );

    // Pass AJAX URL to JS
    wp_localize_script( 'impex-main-js', 'impexData', array(
        'ajaxUrl'  => admin_url( 'admin-ajax.php' ),
        'nonce'    => wp_create_nonce( 'impex_nonce' ),
        'currency' => function_exists( 'get_woocommerce_currency_symbol' ) ? get_woocommerce_currency_symbol() : '$',
        'siteUrl'  => home_url(),
    ) );

    // Comment reply script on single posts
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}
add_action( 'wp_enqueue_scripts', 'impex_enqueue_assets' );

/* =========================================================
   WIDGET AREAS
========================================================= */

function impex_register_widgets() {

    $widget_defaults = array(
        'before_widget' => '<div id="%1$s" class="sidebar-widget widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title">',
        'after_title'   => '</h4>',
    );

    register_sidebar( array_merge( $widget_defaults, array(
        'name'        => __( 'Shop Sidebar', 'impex-football' ),
        'id'          => 'shop-sidebar',
        'description' => __( 'Sidebar shown on WooCommerce shop and category pages.', 'impex-football' ),
    ) ) );

    register_sidebar( array_merge( $widget_defaults, array(
        'name'        => __( 'Footer Widget Area 1', 'impex-football' ),
        'id'          => 'footer-1',
        'description' => __( 'Footer column 1 widgets.', 'impex-football' ),
    ) ) );

    register_sidebar( array_merge( $widget_defaults, array(
        'name'        => __( 'Footer Widget Area 2', 'impex-football' ),
        'id'          => 'footer-2',
        'description' => __( 'Footer column 2 widgets.', 'impex-football' ),
    ) ) );

    register_sidebar( array_merge( $widget_defaults, array(
        'name'        => __( 'Blog Sidebar', 'impex-football' ),
        'id'          => 'blog-sidebar',
        'description' => __( 'Sidebar shown on blog/archive pages.', 'impex-football' ),
    ) ) );
}
add_action( 'widgets_init', 'impex_register_widgets' );

/* =========================================================
   WOOCOMMERCE HOOKS & CUSTOMIZATIONS
========================================================= */

// WooCommerce-specific hooks — only register when WooCommerce is active
add_action( 'plugins_loaded', function() {
    if ( ! class_exists( 'WooCommerce' ) ) {
        return;
    }

    // Remove default WooCommerce styles (we use our own)
    add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

    // Change number of products per row
    add_filter( 'loop_shop_columns', function() {
        return 4;
    } );

    // Change number of products per page
    add_filter( 'loop_shop_per_page', function() {
        return 12;
    } );

    // Add custom wrapper to WooCommerce main content
    add_action( 'woocommerce_before_main_content', function() {
        echo '<div class="container">';
    }, 10 );

    add_action( 'woocommerce_after_main_content', function() {
        echo '</div>';
    }, 10 );

    // Custom product loop wrapper
    remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
    remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );

    // Add custom badge for featured products
    add_action( 'woocommerce_before_shop_loop_item_title', function() {
        global $product;
        if ( $product->is_featured() ) {
            echo '<span class="product-badge badge-hot">' . esc_html__( 'HOT', 'impex-football' ) . '</span>';
        }
        if ( $product->is_on_sale() ) {
            echo '<span class="product-badge badge-sale">' . esc_html__( 'SALE', 'impex-football' ) . '</span>';
        }
    }, 5 );

    // Custom WooCommerce "add to cart" button text
    add_filter( 'woocommerce_product_add_to_cart_text', function( $text, $product ) {
        if ( $product->is_type( 'simple' ) && $product->is_purchasable() && $product->is_in_stock() ) {
            return __( 'Add to Cart', 'impex-football' );
        }
        return $text;
    }, 10, 2 );

    // Custom placeholder image
    add_filter( 'woocommerce_placeholder_img_src', function() {
        return get_template_directory_uri() . '/assets/images/product-placeholder.svg';
    } );
} );

// Add custom class to body on WooCommerce pages
add_filter( 'body_class', function( $classes ) {
    if ( function_exists( 'is_woocommerce' ) && ( is_woocommerce() || is_cart() || is_checkout() ) ) {
        $classes[] = 'impex-woo-page';
    }
    if ( is_front_page() ) {
        $classes[] = 'impex-homepage';
    }
    return $classes;
} );

/* =========================================================
   CUSTOM PRODUCT CATEGORIES SETUP
========================================================= */

/**
 * Create IMPEX football product categories on theme activation.
 * Called via impex_setup plugin or manually.
 */
function impex_create_product_categories() {
    if ( ! taxonomy_exists( 'product_cat' ) ) {
        return;
    }

    $categories = array(
        array(
            'name'        => 'Professional Match Balls',
            'slug'        => 'professional-match-balls',
            'description' => 'FIFA approved and elite match balls for professional competitions. Built to the highest standards.',
        ),
        array(
            'name'        => 'Training Balls',
            'slug'        => 'training-balls',
            'description' => 'Durable training footballs designed for daily practice sessions and club training.',
        ),
        array(
            'name'        => 'Youth & Junior Balls',
            'slug'        => 'youth-junior-balls',
            'description' => 'Size 3 and Size 4 footballs designed for young players and junior leagues.',
        ),
        array(
            'name'        => 'Futsal Balls',
            'slug'        => 'futsal-balls',
            'description' => 'Low-bounce futsal balls designed specifically for indoor futsal courts.',
        ),
        array(
            'name'        => 'Beach Soccer Balls',
            'slug'        => 'beach-soccer-balls',
            'description' => 'Bright, water-resistant beach soccer balls built for sand play.',
        ),
        array(
            'name'        => 'Custom & Branded Balls',
            'slug'        => 'custom-branded-balls',
            'description' => 'Custom logo and branded footballs for clubs, teams, and corporate orders.',
        ),
    );

    foreach ( $categories as $cat ) {
        if ( ! term_exists( $cat['slug'], 'product_cat' ) ) {
            wp_insert_term(
                $cat['name'],
                'product_cat',
                array(
                    'slug'        => $cat['slug'],
                    'description' => $cat['description'],
                )
            );
        }
    }
}

// Hook to run on theme activation (also callable from plugin)
function impex_theme_activation() {
    impex_create_product_categories();
    flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'impex_theme_activation' );

/* =========================================================
   CUSTOM EXCERPT LENGTH
========================================================= */

add_filter( 'excerpt_length', function() {
    return 25;
} );

add_filter( 'excerpt_more', function() {
    return '&hellip; <a class="read-more" href="' . get_permalink() . '">' . __( 'Read More', 'impex-football' ) . '</a>';
} );

/* =========================================================
   CUSTOM WALKER FOR NAVIGATION
========================================================= */

class Impex_Nav_Walker extends Walker_Nav_Menu {

    public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
        $classes   = empty( $item->classes ) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;
        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
        $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';
        $id          = apply_filters( 'nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args );
        $id          = $id ? ' id="' . esc_attr( $id ) . '"' : '';

        $output .= '<li' . $id . $class_names . '>';

        $atts           = array();
        $atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
        $atts['target'] = ! empty( $item->target ) ? $item->target : '';
        $atts['rel']    = ! empty( $item->xfn ) ? $item->xfn : '';
        $atts['href']   = ! empty( $item->url ) ? $item->url : '';
        $atts           = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args );

        $attributes = '';
        foreach ( $atts as $attr => $value ) {
            if ( ! empty( $value ) ) {
                $attributes .= ' ' . $attr . '="' . esc_attr( $value ) . '"';
            }
        }

        $item_output  = isset( $args->before ) ? $args->before : '';
        $item_output .= '<a' . $attributes . '>';
        $item_output .= ( isset( $args->link_before ) ? $args->link_before : '' );
        $item_output .= apply_filters( 'the_title', $item->title, $item->ID );
        $item_output .= ( isset( $args->link_after ) ? $args->link_after : '' );
        $item_output .= '</a>';
        $item_output .= isset( $args->after ) ? $args->after : '';

        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }
}

/* =========================================================
   HELPER FUNCTIONS
========================================================= */

/**
 * Get football SVG icon for use in templates.
 */
function impex_get_football_svg( $size = 60, $class = '' ) {
    $w = intval( $size );
    $h = intval( $size );
    ob_start();
    ?>
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" width="<?php echo $w; ?>" height="<?php echo $h; ?>" class="football-svg <?php echo esc_attr( $class ); ?>" aria-hidden="true">
      <circle cx="50" cy="50" r="48" fill="#ffffff" stroke="#cccccc" stroke-width="1.5"/>
      <polygon points="50,20 64,32 59,48 41,48 36,32" fill="#1a1a1a" stroke="#fff" stroke-width="1"/>
      <polygon points="18,28 32,22 36,32 24,42 12,36" fill="#1a1a1a" stroke="#fff" stroke-width="1"/>
      <polygon points="82,28 68,22 64,32 76,42 88,36" fill="#1a1a1a" stroke="#fff" stroke-width="1"/>
      <polygon points="16,64 28,58 41,48 38,64 24,70" fill="#1a1a1a" stroke="#fff" stroke-width="1"/>
      <polygon points="84,64 72,58 59,48 62,64 76,70" fill="#1a1a1a" stroke="#fff" stroke-width="1"/>
      <polygon points="38,64 62,64 65,78 50,84 35,78" fill="#1a1a1a" stroke="#fff" stroke-width="1"/>
      <circle cx="50" cy="50" r="48" fill="none" stroke="#aaaaaa" stroke-width="1.5"/>
    </svg>
    <?php
    return ob_get_clean();
}

/**
 * Render category icon SVG based on slug.
 */
function impex_category_icon( $slug ) {
    $icons = array(
        'professional-match-balls' => '<svg viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="25" cy="25" r="22" fill="#fff" stroke="#FFD700" stroke-width="2"/><polygon points="25,10 31,17 29,25 21,25 19,17" fill="#FFD700"/><polygon points="8,16 15,12 19,17 13,22 6,19" fill="#FFD700" opacity=".6"/><polygon points="42,16 35,12 31,17 37,22 44,19" fill="#FFD700" opacity=".6"/></svg>',
        'training-balls'           => '<svg viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="25" cy="25" r="22" fill="#fff" stroke="#aaa" stroke-width="2"/><polygon points="25,10 31,17 29,25 21,25 19,17" fill="#333"/><polygon points="8,16 15,12 19,17 13,22 6,19" fill="#333" opacity=".6"/><polygon points="42,16 35,12 31,17 37,22 44,19" fill="#333" opacity=".6"/></svg>',
        'youth-junior-balls'       => '<svg viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="25" cy="25" r="22" fill="#fff" stroke="#4CAF50" stroke-width="2"/><text x="13" y="31" font-size="14" font-weight="bold" fill="#4CAF50">Jr</text></svg>',
        'futsal-balls'             => '<svg viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="25" cy="25" r="22" fill="#fff" stroke="#2196F3" stroke-width="2"/><circle cx="25" cy="25" r="12" fill="none" stroke="#2196F3" stroke-width="2"/><polygon points="25,10 31,17 29,25 21,25 19,17" fill="#2196F3" opacity=".4"/></svg>',
        'beach-soccer-balls'       => '<svg viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="25" cy="25" r="22" fill="#fff" stroke="#FF9800" stroke-width="2"/><path d="M10 35 Q25 20 40 35" stroke="#FF9800" stroke-width="3" fill="none"/><circle cx="25" cy="15" r="5" fill="#FF9800" opacity=".6"/></svg>',
        'custom-branded-balls'     => '<svg viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="25" cy="25" r="22" fill="#fff" stroke="#9C27B0" stroke-width="2"/><text x="16" y="30" font-size="11" font-weight="bold" fill="#9C27B0">★</text><text x="10" y="38" font-size="8" font-weight="bold" fill="#9C27B0">CUSTOM</text></svg>',
    );
    return $icons[ $slug ] ?? $icons['training-balls'];
}

/**
 * Get WooCommerce cart count.
 */
function impex_cart_count() {
    if ( function_exists( 'WC' ) && WC()->cart ) {
        return WC()->cart->get_cart_contents_count();
    }
    return 0;
}

/**
 * Get WooCommerce cart URL.
 */
function impex_cart_url() {
    if ( function_exists( 'wc_get_cart_url' ) ) {
        return wc_get_cart_url();
    }
    return home_url( '/cart' );
}

/**
 * Render the site logo.
 */
function impex_the_logo() {
    if ( has_custom_logo() ) {
        the_custom_logo();
    } else {
        $logo_path = IMPEX_THEME_URI . '/assets/images/logo.svg';
        echo '<a href="' . esc_url( home_url( '/' ) ) . '" rel="home">';
        echo '<img src="' . esc_url( $logo_path ) . '" alt="' . esc_attr( get_bloginfo( 'name' ) ) . '" width="200" height="60">';
        echo '</a>';
    }
}

/* =========================================================
   AJAX HANDLERS
========================================================= */

// AJAX: Get cart count
add_action( 'wp_ajax_impex_get_cart_count', 'impex_ajax_cart_count' );
add_action( 'wp_ajax_nopriv_impex_get_cart_count', 'impex_ajax_cart_count' );
function impex_ajax_cart_count() {
    check_ajax_referer( 'impex_nonce', 'nonce' );
    wp_send_json_success( array( 'count' => impex_cart_count() ) );
}

/* =========================================================
   SEO & META
========================================================= */

// Add custom meta tags
add_action( 'wp_head', function() {
    echo '<meta name="theme-color" content="#0a0a0a">' . "\n";
    if ( is_front_page() ) {
        echo '<meta name="description" content="IMPEX - Premium Football Manufacturer. Shop professional match balls, training balls, futsal balls, beach soccer balls and custom branded footballs.">' . "\n";
    }
} );

/* =========================================================
   REMOVE UNWANTED DEFAULTS
========================================================= */

// Remove emoji scripts (performance)
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );

// Remove WordPress generator tag
remove_action( 'wp_head', 'wp_generator' );

// Remove RSD link
remove_action( 'wp_head', 'rsd_link' );

// Remove wlwmanifest link
remove_action( 'wp_head', 'wlwmanifest_link' );
