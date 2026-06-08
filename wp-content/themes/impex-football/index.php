<?php
/**
 * Main Index Template — IMPEX Football
 * Fallback template for all content.
 *
 * @package ImpexFootball
 */

get_header();
?>

<div class="page-hero">
  <div class="container">
    <?php if ( is_home() ) : ?>
      <h1><?php esc_html_e( 'Latest News', 'impex-football' ); ?></h1>
    <?php elseif ( is_search() ) : ?>
      <h1>
        <?php
        /* translators: %s: search query */
        printf( esc_html__( 'Search Results for: %s', 'impex-football' ), '<span>' . get_search_query() . '</span>' );
        ?>
      </h1>
    <?php else : ?>
      <h1><?php the_archive_title(); ?></h1>
    <?php endif; ?>
  </div>
</div>

<div class="archive-wrapper">
  <div class="container">
    <?php if ( have_posts() ) : ?>

      <div class="posts-grid" style="display:grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap:2rem;">
        <?php while ( have_posts() ) : the_post(); ?>

          <article id="post-<?php the_ID(); ?>" <?php post_class( 'post-card' ); ?> style="background:var(--color-dark-2); border:1px solid var(--color-dark-3); border-radius:12px; overflow:hidden;">
            <?php if ( has_post_thumbnail() ) : ?>
              <a href="<?php the_permalink(); ?>">
                <?php the_post_thumbnail( 'medium', array( 'style' => 'width:100%; height:200px; object-fit:cover;' ) ); ?>
              </a>
            <?php endif; ?>
            <div style="padding:1.5rem;">
              <div style="font-size:0.75rem; color:var(--color-gold); text-transform:uppercase; letter-spacing:2px; margin-bottom:0.5rem;">
                <?php echo esc_html( get_the_date() ); ?>
              </div>
              <h2 style="font-size:1.1rem; margin-bottom:0.75rem;">
                <a href="<?php the_permalink(); ?>" style="color:var(--color-white); text-decoration:none;"><?php the_title(); ?></a>
              </h2>
              <div style="font-size:0.88rem; color:var(--color-grey-light);"><?php the_excerpt(); ?></div>
              <a href="<?php the_permalink(); ?>" class="btn btn-outline btn-sm" style="margin-top:1rem; display:inline-flex;">
                <?php esc_html_e( 'Read More', 'impex-football' ); ?>
              </a>
            </div>
          </article>

        <?php endwhile; ?>
      </div>

      <div style="margin-top:3rem;">
        <?php the_posts_navigation(); ?>
      </div>

    <?php else : ?>

      <div class="text-center" style="padding:4rem 0;">
        <div style="font-size:4rem; margin-bottom:1rem;" aria-hidden="true">⚽</div>
        <h2 style="color:var(--color-white); margin-bottom:1rem;"><?php esc_html_e( 'Nothing Found', 'impex-football' ); ?></h2>
        <p style="color:var(--color-grey-light);"><?php esc_html_e( 'It looks like nothing was found here. Try a search or browse our product categories.', 'impex-football' ); ?></p>
        <?php get_search_form(); ?>
        <a href="<?php echo esc_url( home_url( '/shop' ) ); ?>" class="btn btn-primary" style="margin-top:1.5rem;">
          <?php esc_html_e( 'Browse Products', 'impex-football' ); ?>
        </a>
      </div>

    <?php endif; ?>
  </div><!-- .container -->
</div><!-- .archive-wrapper -->

<?php get_footer(); ?>
