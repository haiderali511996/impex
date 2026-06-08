<?php
/**
 * Generic Page Template — IMPEX Football
 *
 * @package ImpexFootball
 */

get_header();
?>

<div class="page-hero">
  <div class="container">
    <?php while ( have_posts() ) : the_post(); ?>
      <h1><?php the_title(); ?></h1>
    <?php endwhile; ?>
  </div>
</div>

<div class="page-content-wrapper">
  <div class="container">
    <div style="max-width:800px; margin:0 auto;">
      <?php while ( have_posts() ) : the_post(); ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
          <div class="entry-content">
            <?php the_content(); ?>
          </div>
          <?php
          wp_link_pages( array(
              'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'impex-football' ),
              'after'  => '</div>',
          ) );
          ?>
        </article>
      <?php endwhile; ?>
    </div>
  </div>
</div>

<?php get_footer(); ?>
