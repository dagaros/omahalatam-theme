<?php
/**
 * Post individual.
 *
 * Barra de progreso, TOC lateral, CTA in-content, etiquetas, compartir,
 * bio del autor y relacionados.
 *
 * El script del TOC vive en assets/js/single-toc.js (se encola desde
 * inc/enqueue.php solo en is_single()).
 *
 * @package jhontra-theme
 */
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();

$cats     = get_the_category();
$cat_name = ! empty($cats) ? $cats[0]->name : 'Blog';
$cat_link = ! empty($cats) ? get_category_link($cats[0]->term_id) : jt_home_url('/blog/');
$tags     = get_the_tags();
?>

<!-- Reading progress bar -->
<div class="jt-progress"><div class="jt-progress__bar" data-progress></div></div>

<article>
  <!-- Post header -->
  <header class="jt-post-header">
    <div class="jt-post-header__glow"></div>
    <div class="jt-post-header__inner">
      <?php jt_breadcrumbs(); ?>
      <a href="<?php echo esc_url( $cat_link ); ?>" class="jt-post-cat"><?php echo esc_html( strtoupper($cat_name) ); ?></a>
      <h1><?php the_title(); ?></h1>
      <div class="jt-author">
        <div style="display:flex;align-items:center;gap:11px;">
          <div class="jt-author__avatar">J</div>
          <div>
            <div class="jt-author__name">Jhontra</div>
            <div class="jt-author__role">Coach PLO5</div>
          </div>
        </div>
        <div class="jt-author__divider"></div>
        <div class="jt-author__details">
          <span><?php echo strtoupper( get_the_date('d M Y') ); ?></span>
          <span class="jt-dot"></span>
          <span><?php echo jt_reading_time(); ?> de lectura</span>
        </div>
      </div>
    </div>
  </header>

  <!-- Featured image -->
  <?php if ( has_post_thumbnail() ) : ?>
  <div class="jt-post-featured">
    <div class="jt-post-featured__wrap">
      <?php the_post_thumbnail( 'jt-featured' ); ?>
    </div>
  </div>
  <?php endif; ?>

  <!-- Content + Sidebar -->
  <div class="jt-post-layout">
    <div class="jt-post-grid-layout" data-single-grid>

      <!-- Main content -->
      <div style="min-width:0;max-width:760px;">
        <div class="jt-prose">
          <?php the_content(); ?>
        </div>

        <!-- In-content CTA -->
        <div class="jt-inline-cta">
          <div class="jt-inline-cta__glow"></div>
          <div class="jt-inline-cta__content">
            <div class="jt-inline-cta__label"><?php echo esc_html( jt_t('s_cta_h') ); ?></div>
            <h3><?php echo esc_html( jt_t('s_cta_p') ); ?></h3>
            <p>Rakeback competitivo, material de estudio exclusivo y una comunidad activa que juega, estudia y gana en equipo.</p>
            <div style="display:flex;gap:12px;justify-content:center;flex-wrap:wrap;">
              <a href="<?php echo esc_url( jt_whatsapp_url() ); ?>" class="jt-btn-gold jt-btn-sweep" style="padding:15px 28px;border-radius:13px;font-size:15.5px;" target="_blank" rel="noopener"><span>✆</span> <?php echo esc_html( jt_t('s_cta_b') ); ?></a>
              <a href="<?php echo esc_url( jt_anchor_url('clubes') ); ?>" class="jt-btn-ghost" style="padding:15px 24px;border-radius:13px;font-size:15.5px;"><?php echo esc_html( jt_t('cta_clubes') ); ?></a>
            </div>
          </div>
        </div>

        <!-- Tags -->
        <?php if ( $tags ) : ?>
        <div class="jt-tags">
          <span class="jt-tags__label"><?php echo esc_html( jt_t('s_etiquetas') ); ?></span>
          <?php foreach ( $tags as $tag ) : ?>
            <a href="<?php echo esc_url( get_tag_link( $tag->term_id ) ); ?>"><?php echo esc_html( $tag->name ); ?></a>
          <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <!-- Share -->
        <div class="jt-share">
          <span class="jt-share__title"><?php echo esc_html( jt_t('s_compartir') ); ?></span>
          <div class="jt-share__icons">
            <a href="https://wa.me/?text=<?php echo urlencode( get_the_title() . ' ' . get_permalink() ); ?>" class="jt-share__btn jt-share__btn--wa" aria-label="<?php echo esc_attr( jt_t('s_sh_wa') ); ?>" target="_blank" rel="noopener">✆</a>
            <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode(get_permalink()); ?>&text=<?php echo urlencode(get_the_title()); ?>" class="jt-share__btn" aria-label="<?php echo esc_attr( jt_t('s_sh_x') ); ?>" target="_blank" rel="noopener" style="font-weight:700;font-size:15px;">X</a>
            <a href="https://t.me/share/url?url=<?php echo urlencode(get_permalink()); ?>&text=<?php echo urlencode(get_the_title()); ?>" class="jt-share__btn" aria-label="<?php echo esc_attr( jt_t('s_sh_tg') ); ?>" target="_blank" rel="noopener">✈</a>
            <button type="button" class="jt-share__btn" aria-label="<?php echo esc_attr( jt_t('s_sh_copy') ); ?>" onclick="navigator.clipboard.writeText('<?php echo esc_url(get_permalink()); ?>');this.textContent='✓';setTimeout(()=>this.textContent='⧉',1500)">⧉</button>
          </div>
        </div>

        <!-- Author bio -->
        <div class="jt-author-bio">
          <div class="jt-author-bio__avatar">J</div>
          <div style="min-width:0;">
            <div class="jt-author-bio__label"><?php echo esc_html( jt_t('s_autor') ); ?></div>
            <div class="jt-author-bio__name">Jhontra</div>
            <p>Coach y jugador profesional de Omaha 5 Cartas, referente del PLO5 en Latinoamérica. Enseña a ganar con matemática, disciplina y gestión de bankroll.</p>
            <a href="<?php echo esc_url( jt_whatsapp_url() ); ?>" target="_blank" rel="noopener"><?php echo esc_html( jt_t('s_entrenar') ); ?> <span>→</span></a>
          </div>
        </div>
      </div>

      <!-- Sidebar -->
      <aside class="jt-sidebar">
        <!-- TOC -->
        <div class="jt-toc" data-toc-wrap>
          <div class="jt-sidebar__heading"><?php echo esc_html( jt_t('s_toc') ); ?></div>
          <nav id="jt-toc-nav"></nav>
        </div>

        <!-- Suprema CTA -->
        <div class="jt-aff">
          <div class="jt-aff__glow"></div>
          <span class="jt-sidebar__label"><?php echo esc_html( jt_t('s_sala') ); ?></span>
          <div class="jt-aff__name" style="font-size:24px;">Suprema Poker</div>
          <div class="jt-aff__perk" style="font-size:18px;"><span style="font-size:20px;">★</span><?php echo esc_html( jt_t('s_bono') ); ?></div>
          <a href="<?php echo esc_url( jt_whatsapp_url() ); ?>" class="jt-btn-gold jt-btn-sweep jt-btn-sm jt-btn-full" target="_blank" rel="noopener"><?php echo esc_html( jt_t('s_verbono') ); ?></a>
        </div>

        <!-- Ad slot -->
        <div class="jt-ad-slot">
          <div class="jt-ad-slot__label"><?php echo esc_html( jt_t('s_ad1') ); ?></div>
          <div class="jt-ad-slot__desc"><?php echo esc_html( jt_t('s_ad2') ); ?></div>
        </div>
      </aside>
    </div>
  </div>
</article>

<!-- Related posts -->
<?php
$related = new WP_Query( array(
    'posts_per_page' => 3,
    'post__not_in'   => array( get_the_ID() ),
    'category__in'   => ! empty($cats) ? array($cats[0]->term_id) : array(),
    'orderby'        => 'rand',
) );
if ( $related->have_posts() ) : ?>
<section class="jt-related">
  <div class="jt-related__inner">
    <div class="jt-related__header">
      <h2><?php echo esc_html( jt_t('s_sigue') ); ?></h2>
      <a href="<?php echo esc_url( jt_home_url('/blog/') ); ?>" class="jt-related__all"><?php echo esc_html( jt_t('ver_todo') ); ?> →</a>
    </div>
    <div class="jt-related__grid" data-related-grid>
      <?php while ( $related->have_posts() ) : $related->the_post();
        get_template_part( 'template-parts/card', 'post', array( 'variant' => 'compact' ) );
      endwhile; wp_reset_postdata(); ?>
    </div>
  </div>
</section>
<?php endif; ?>


<?php get_footer(); ?>
