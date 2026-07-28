<?php
/**
 * Blog archive — Faithful to Claude Design export.
 * Featured post + grid + sidebar (Suprema, categories, recent, PPPoker, ad).
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
      <div class="jt-pill">Análisis · Noticias · Estrategia</div>
      <?php if ( is_category() ) : ?>
        <h1>El Blog de <span class="jt-gold"><?php single_cat_title(); ?></span></h1>
        <?php if ( category_description() ) : ?>
          <p><?php echo esc_html( strip_tags( category_description() ) ); ?></p>
        <?php endif; ?>
      <?php elseif ( is_search() ) : ?>
        <h1>Resultados: <span class="jt-gold"><?php echo esc_html( get_search_query() ); ?></span></h1>
      <?php else : ?>
        <h1>El Blog de <span class="jt-gold">Omaha 5</span></h1>
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
    <a href="<?php echo esc_url( home_url('/blog/') ); ?>"
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
          $fcats = get_the_category();
          $fcat  = ! empty($fcats) ? strtoupper($fcats[0]->name) : 'BLOG';
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
                <span>Por Jhontra</span>
              </div>
              <h2><?php the_title(); ?></h2>
              <p><?php echo get_the_excerpt(); ?></p>
              <span class="jt-feat__cta">Leer artículo completo <span>→</span></span>
            </div>
          </a>
        </article>
        <?php endif; ?>

        <!-- Post grid -->
        <div class="jt-post-grid" data-post-grid>
          <?php while ( have_posts() ) : the_post();
            $pcats = get_the_category();
            $pcat  = ! empty($pcats) ? strtoupper($pcats[0]->name) : 'BLOG';
          ?>
          <article class="jt-card" data-reveal>
            <a href="<?php the_permalink(); ?>" class="jt-card__link">
              <div class="jt-card__img">
                <?php if ( has_post_thumbnail() ) : ?>
                  <?php the_post_thumbnail( 'jt-card' ); ?>
                <?php else : ?>
                  <div class="jt-card__placeholder">♠</div>
                <?php endif; ?>
                <span class="jt-card__badge"><?php echo esc_html( $pcat ); ?></span>
              </div>
              <div class="jt-card__body">
                <div class="jt-card__meta">
                  <span><?php echo strtoupper( get_the_date('d M Y') ); ?></span>
                  <span class="jt-dot"></span>
                  <span><?php echo jt_reading_time(); ?></span>
                </div>
                <h3><?php the_title(); ?></h3>
                <p><?php echo get_the_excerpt(); ?></p>
                <span class="jt-card__cta">Leer más <span>→</span></span>
              </div>
            </a>
          </article>
          <?php endwhile; ?>
        </div>

        <!-- Pagination -->
        <?php
        $plinks = paginate_links( array( 'type' => 'array', 'prev_text' => '← Anterior', 'next_text' => 'Siguiente →' ) );
        if ( $plinks ) : ?>
        <nav class="jt-pagination" aria-label="Paginación">
          <?php foreach ( $plinks as $link ) echo $link; ?>
        </nav>
        <?php endif; ?>

      <?php else : ?>
        <div style="text-align:center;padding:80px 0;color:#7A808A;">
          <p style="font-size:48px;margin-bottom:16px;">♠</p>
          <h2 style="font-family:'Bricolage Grotesque',sans-serif;color:#fff;margin-bottom:12px;">Próximamente</h2>
          <p>Estamos preparando contenido de alto nivel sobre PLO5.</p>
        </div>
      <?php endif; ?>
    </main>

    <!-- Sidebar -->
    <aside class="jt-sidebar">
      <!-- Suprema CTA -->
      <div class="jt-aff" data-reveal>
        <div class="jt-aff__glow"></div>
        <span class="jt-sidebar__label">Sala afiliada</span>
        <div class="jt-aff__name">Suprema Poker</div>
        <p>El club con más tráfico de PLO5 en LATAM. Únete con el código de Jhontra y accede a las mejores condiciones.</p>
        <div class="jt-aff__perk"><span>★</span>Mejor bono de bienvenida</div>
        <a href="https://wa.me/573107114689" class="jt-btn-gold jt-btn-sweep jt-btn-sm jt-btn-full" target="_blank" rel="noopener">Ver mi bono</a>
      </div>

      <!-- Categories -->
      <div class="jt-sidebar-widget" data-reveal>
        <div class="jt-sidebar__heading">Categorías</div>
        <?php
        $all_cats = get_categories( array( 'orderby' => 'count', 'order' => 'DESC', 'hide_empty' => true ) );
        foreach ( $all_cats as $acat ) : ?>
          <a href="<?php echo esc_url( get_category_link( $acat->term_id ) ); ?>" class="jt-sidebar-widget__item">
            <span><?php echo esc_html( $acat->name ); ?></span>
            <span class="jt-sidebar-widget__count"><?php echo $acat->count; ?></span>
          </a>
        <?php endforeach; ?>
      </div>

      <!-- Recent posts -->
      <div class="jt-sidebar-widget" data-reveal>
        <div class="jt-sidebar__heading">Lo más reciente</div>
        <div class="jt-recent">
          <?php
          $recent = new WP_Query( array( 'posts_per_page' => 3, 'orderby' => 'date', 'order' => 'DESC' ) );
          while ( $recent->have_posts() ) : $recent->the_post(); ?>
            <a href="<?php the_permalink(); ?>" class="jt-recent__item">
              <div class="jt-recent__thumb">
                <?php if ( has_post_thumbnail() ) the_post_thumbnail( 'jt-thumb' ); ?>
              </div>
              <div>
                <div class="jt-recent__date"><?php echo strtoupper( get_the_date('d M Y') ); ?></div>
                <div class="jt-recent__title"><?php the_title(); ?></div>
              </div>
            </a>
          <?php endwhile; wp_reset_postdata(); ?>
        </div>
      </div>

      <!-- PPPoker CTA -->
      <div class="jt-aff jt-aff--secondary" data-reveal>
        <span class="jt-sidebar__label">Sala afiliada</span>
        <div class="jt-aff__name">PPPoker</div>
        <p>Mesas activas 24/7 y bono de bienvenida para nuevos jugadores del club.</p>
        <a href="https://wa.me/573107114689" class="jt-btn-outline jt-btn-full" target="_blank" rel="noopener">Ver promoción</a>
      </div>

      <!-- Ad slot -->
      <div class="jt-ad-slot">
        <div class="jt-ad-slot__label">ESPACIO PUBLICITARIO · 300×250</div>
        <div class="jt-ad-slot__desc">Banner de sala afiliada (widget WordPress)</div>
      </div>
    </aside>

  </div>
</div>

<?php get_footer(); ?>
