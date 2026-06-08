<?php
/**
 * Single Post Template — IMPEX Football
 *
 * @package ImpexFootball
 */

get_header();
?>

<div class="page-hero">
  <div class="container">
    <?php while ( have_posts() ) : the_post(); ?>
      <div style="font-size:0.8rem; color:var(--color-gold); letter-spacing:2px; text-transform:uppercase; margin-bottom:0.75rem;">
        <?php echo get_the_date(); ?>
        &mdash;
        <?php the_category( ', ' ); ?>
      </div>
      <h1 style="max-width:800px;"><?php the_title(); ?></h1>
    <?php endwhile; ?>
  </div>
</div>

<div class="single-post-wrapper">
  <div class="container">
    <div style="display:grid; grid-template-columns:1fr 300px; gap:3rem; align-items:start;">

      <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <?php while ( have_posts() ) : the_post(); ?>

          <?php if ( has_post_thumbnail() ) : ?>
            <div style="border-radius:12px; overflow:hidden; margin-bottom:2.5rem; border:1px solid var(--color-dark-3);">
              <?php the_post_thumbnail( 'large', array( 'style' => 'width:100%; height:auto;' ) ); ?>
            </div>
          <?php endif; ?>

          <div class="entry-content" style="color:var(--color-grey-light); line-height:1.9; font-size:1.02rem;">
            <?php the_content(); ?>
          </div>

          <div style="margin-top:3rem; padding-top:2rem; border-top:1px solid var(--color-dark-3);">
            <div style="display:flex; align-items:center; gap:1.5rem; flex-wrap:wrap;">
              <div>
                <span style="font-size:0.78rem; color:var(--color-grey); text-transform:uppercase; letter-spacing:1px;">
                  <?php esc_html_e( 'Written by', 'impex-football' ); ?>
                </span>
                <span style="color:var(--color-gold); font-weight:700;"><?php the_author(); ?></span>
              </div>
              <div>
                <?php the_tags( '<span style="font-size:0.8rem; color:var(--color-grey);">' . esc_html__( 'Tags: ', 'impex-football' ) . '</span>', ', ' ); ?>
              </div>
            </div>
          </div>

          <nav class="post-navigation" style="display:flex; justify-content:space-between; margin-top:2.5rem; gap:1rem;">
            <?php
            $prev = get_previous_post();
            $next = get_next_post();
            if ( $prev ) :
            ?>
            <a href="<?php echo esc_url( get_permalink( $prev ) ); ?>" class="btn btn-outline btn-sm">
              &larr; <?php echo esc_html( get_the_title( $prev ) ); ?>
            </a>
            <?php endif; if ( $next ) : ?>
            <a href="<?php echo esc_url( get_permalink( $next ) ); ?>" class="btn btn-outline btn-sm" style="margin-left:auto;">
              <?php echo esc_html( get_the_title( $next ) ); ?> &rarr;
            </a>
            <?php endif; ?>
          </nav>

          <?php if ( comments_open() || get_comments_number() ) : ?>
            <div style="margin-top:3rem; padding-top:2rem; border-top:1px solid var(--color-dark-3);">
              <?php comments_template(); ?>
            </div>
          <?php endif; ?>

        <?php endwhile; ?>
      </article>

      <!-- Sidebar -->
      <aside class="shop-sidebar">
        <?php if ( is_active_sidebar( 'blog-sidebar' ) ) : ?>
          <?php dynamic_sidebar( 'blog-sidebar' ); ?>
        <?php else : ?>
          <div class="sidebar-widget">
            <h4><?php esc_html_e( 'Our Products', 'impex-football' ); ?></h4>
            <ul>
              <li><a href="<?php echo esc_url( home_url( '/product-category/professional-match-balls' ) ); ?>"><?php esc_html_e( 'Professional Match Balls', 'impex-football' ); ?></a></li>
              <li><a href="<?php echo esc_url( home_url( '/product-category/training-balls' ) ); ?>"><?php esc_html_e( 'Training Balls', 'impex-football' ); ?></a></li>
              <li><a href="<?php echo esc_url( home_url( '/product-category/youth-junior-balls' ) ); ?>"><?php esc_html_e( 'Youth & Junior Balls', 'impex-football' ); ?></a></li>
              <li><a href="<?php echo esc_url( home_url( '/product-category/futsal-balls' ) ); ?>"><?php esc_html_e( 'Futsal Balls', 'impex-football' ); ?></a></li>
              <li><a href="<?php echo esc_url( home_url( '/product-category/beach-soccer-balls' ) ); ?>"><?php esc_html_e( 'Beach Soccer Balls', 'impex-football' ); ?></a></li>
              <li><a href="<?php echo esc_url( home_url( '/product-category/custom-branded-balls' ) ); ?>"><?php esc_html_e( 'Custom & Branded', 'impex-football' ); ?></a></li>
            </ul>
          </div>
          <div class="sidebar-widget">
            <h4><?php esc_html_e( 'Quick Links', 'impex-football' ); ?></h4>
            <ul>
              <li><a href="<?php echo esc_url( home_url( '/shop' ) ); ?>"><?php esc_html_e( 'Shop', 'impex-football' ); ?></a></li>
              <li><a href="<?php echo esc_url( home_url( '/about' ) ); ?>"><?php esc_html_e( 'About IMPEX', 'impex-football' ); ?></a></li>
              <li><a href="<?php echo esc_url( home_url( '/contact' ) ); ?>"><?php esc_html_e( 'Contact', 'impex-football' ); ?></a></li>
            </ul>
          </div>
        <?php endif; ?>
      </aside>

    </div>
  </div>
</div>

<?php get_footer(); ?>
