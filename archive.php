<?php
/**
 * Archivo del blog — listado de /blog/, categorías y búsqueda.
 *
 * Estructura: hero + barra de categorías + post destacado + grid + sidebar.
 * La tarjeta vive en template-parts/card-post.php y el sidebar en
 * template-parts/sidebar-blog.php.
 *
 * Lo usan también home.php y search.php vía require.
 *
 * @package jhontra-theme
 */
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();
?>

<!-- Archive header -->
<section class="jt-archive-hero">
  <div class="jt-archive-hero__glow"></div>
  <div class="jt-archive-hero__inner">
    <?php jt_breadcrumbs(); ?>
    <div data-reveal style="max-width:760px;">
      <div class="jt-pill"><?php echo esc_html( jt_t('a_kicker') ); ?></div>
      <?php if ( is_category() ) : ?>
        <h1><?php echo esc_html( jt_t('a_blogde2') ); ?> <span class="jt-gold"><?php single_cat_title(); ?></span></h1>
        <?php if ( category_description() ) : ?>
          <p><?php echo esc_html( strip_tags( category_description() ) ); ?></p>
        <?php endif; ?>
      <?php elseif ( is_search() ) : ?>
        <h1><?php echo esc_html( jt_t('a_result2') ); ?> <span class="jt-gold"><?php echo esc_html( get_search_query() ); ?></span></h1>
      <?php else : ?>
        <h1><?php echo esc_html( jt_t('a_blogde2') ); ?> <span class="jt-gold">Omaha 5</span></h1>
        <p>Estrategia aplicada, análisis de manos, noticias de las salas y guías de rakeback. Todo lo que necesitas para dejar de depender de la suerte y ganar con matemática.</p>
      <?php endif; ?>
    </div>
    <?php get_search_form(); ?>
  </div>
</section>

<!-- Category filter bar (sticky) -->
<?php
$categories = get_categories( array( 'orderby' => 'count', 'order' => 'DESC', 'hide_empty' => true ) );
if ( ! empty( $categories ) ) : ?>
<div class="jt-cat-bar">
  <div class="jt-cat-bar__inner">
    <a href="<?php echo esc_url( jt_home_url('/blog/') ); ?>"
       class="jt-cat-tag <?php if ( is_home() && ! is_category() ) echo 'jt-cat-tag--active'; ?>">
      Todos <span class="jt-cat-tag__count"><?php echo wp_count_posts()->publish; ?></span>
    </a>
    <?php foreach ( $categories as $cat ) : ?>
      <a href="<?php echo esc_url( get_category_link( $cat->term_id ) ); ?>"
         class="jt-cat-tag <?php if ( is_category( $cat->term_id ) ) echo 'jt-cat-tag--active'; ?>">
        <?php echo esc_html( $cat->name ); ?> <span class="jt-cat-tag__count"><?php echo $cat->count; ?></span>
      </a>
    <?php endforeach; ?>
  </div>
</div>
<?php endif; ?>

<!-- Main grid -->
<div class="jt-archive">
  <div class="jt-archive__grid" data-archive-grid>

    <!-- Main column -->
    <main>
      <?php if ( have_posts() ) : ?>

        <?php
        /* Featured post (first post, only on page 1 and not on category pages) */
        $paged = get_query_var('paged') ? get_query_var('paged') : 1;
        if ( $paged === 1 && ! is_category() && ! is_search() ) :
          the_post();
          $fcat = jt_primary_cat();
        ?>
        <article class="jt-feat" data-reveal>
          <a href="<?php the_permalink(); ?>" class="jt-feat__link">
            <div class="jt-feat__img">
              <?php if ( has_post_thumbnail() ) : ?>
                <?php the_post_thumbnail( 'jt-featured' ); ?>
              <?php endif; ?>
              <span class="jt-feat__badge">DESTACADO · <?php echo esc_html( $fcat ); ?></span>
            </div>
            <div class="jt-feat__body">
              <div class="jt-feat__meta">
                <span><?php echo strtoupper( get_the_date('d M Y') ); ?></span>
                <span class="jt-dot"></span>
                <span><?php echo jt_reading_time(); ?> de lectura</span>
                <span class="jt-dot"></span>
                <span><?php echo esc_html( jt_t('a_por2') ); ?></span>
              </div>
              <h2><?php the_title(); ?></h2>
              <p><?php echo get_the_excerpt(); ?></p>
              <span class="jt-feat__cta"><?php echo esc_html( jt_t('a_leer') ); ?> <span>→</span></span>
            </div>
          </a>
        </article>
        <?php endif; ?>

        <!-- Post grid -->
        <div class="jt-post-grid" data-post-grid>
          <?php while ( have_posts() ) : the_post();
            get_template_part( 'template-parts/card', 'post' );
          endwhile; ?>
        </div>

        <!-- Pagination -->
        <?php
        $plinks = paginate_links( array( 'type' => 'array', 'prev_text' => '← Anterior', 'next_text' => 'Siguiente →' ) );
        if ( $plinks ) : ?>
        <nav class="jt-pagination" aria-label="<?php echo esc_attr( jt_t('a_pag') ); ?>">
          <?php foreach ( $plinks as $link ) echo $link; ?>
        </nav>
        <?php endif; ?>

      <?php else : ?>
        <div style="text-align:center;padding:80px 0;color:#7A808A;">
          <p style="font-size:48px;margin-bottom:16px;">♠</p>
          <h2 style="font-family:'Bricolage Grotesque',sans-serif;color:#fff;margin-bottom:12px;"><?php echo esc_html( jt_t('a_prox') ); ?></h2>
          <p><?php echo esc_html( jt_t('a_prox_p') ); ?></p>
        </div>
      <?php endif; ?>
    </main>

    <!-- Sidebar -->
    <?php get_template_part( 'template-parts/sidebar', 'blog' ); ?>

  </div>
</div>

<?php get_footer(); ?>
