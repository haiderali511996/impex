<?php
/**
 * Archive Template — IMPEX Football
 *
 * @package ImpexFootball
 */

get_header();
?>

<div class="page-hero">
  <div class="container">
    <div style="font-size:0.78rem; color:var(--color-gold); letter-spacing:3px; text-transform:uppercase; margin-bottom:0.75rem;">
      <?php esc_html_e( 'Archive', 'impex-football' ); ?>
    </div>
    <h1><?php the_archive_title(); ?></h1>
    <?php the_archive_description( '<p style="color:var(--color-grey-light); margin-top:0.75rem;">', '</p>' ); ?>
  </div>
</div>

<div class="archive-wrapper">
  <div class="container">

    <?php if ( have_posts() ) : ?>

      <div style="display:grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap:2rem;">
        <?php while ( have_posts() ) : the_post(); ?>

          <article id="post-<?php the_ID(); ?>" <?php post_class( '' ); ?>
                   style="background:var(--color-dark-2); border:1px solid var(--color-dark-3); border-radius:12px; overflow:hidden; transition: all 0.3s ease;">
            <?php if ( has_post_thumbnail() ) : ?>
              <a href="<?php the_permalink(); ?>" style="display:block; overflow:hidden;">
                <?php the_post_thumbnail( 'medium', array( 'style' => 'width:100%; height:200px; object-fit:cover; transition: transform 0.4s;' ) ); ?>
              </a>
            <?php endif; ?>
            <div style="padding:1.5rem;">
              <div style="font-size:0.75rem; color:var(--color-gold); letter-spacing:2px; text-transform:uppercase; margin-bottom:0.5rem;">
                <?php echo get_the_date(); ?> &mdash; <?php the_category( ', ' ); ?>
              </div>
              <h2 style="font-size:1.1rem; margin-bottom:0.75rem; line-height:1.3;">
                <a href="<?php the_permalink(); ?>" style="color:var(--color-white); text-decoration:none;"><?php the_title(); ?></a>
              </h2>
              <div style="font-size:0.88rem; color:var(--color-grey-light);"><?php the_excerpt(); ?></div>
              <div style="display:flex; align-items:center; justify-content:space-between; margin-top:1rem;">
                <a href="<?php the_permalink(); ?>" class="btn btn-outline btn-sm">
                  <?php esc_html_e( 'Read More', 'impex-football' ); ?>
                </a>
                <span style="font-size:0.78rem; color:var(--color-grey);">
                  <?php echo esc_html( get_the_author() ); ?>
                </span>
              </div>
            </div>
          </article>

        <?php endwhile; ?>
      </div>

      <div style="margin-top:3rem;">
        <?php the_posts_navigation( array(
            'prev_text' => __( '&larr; Older Posts', 'impex-football' ),
            'next_text' => __( 'Newer Posts &rarr;', 'impex-football' ),
        ) ); ?>
      </div>

    <?php else : ?>
      <div class="text-center" style="padding:4rem 0;">
        <h2 style="color:var(--color-white);"><?php esc_html_e( 'No posts found.', 'impex-football' ); ?></h2>
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn-primary" style="margin-top:1.5rem;">
          <?php esc_html_e( 'Back to Home', 'impex-football' ); ?>
        </a>
      </div>
    <?php endif; ?>

  </div>
</div>

<?php get_footer(); ?>
