<?php
/**
 * Template Name: Calculadora de equity
 *
 * Una sola plantilla para las ocho paginas. La variante se deduce del slug,
 * asi que anadir una nueva es crear la pagina y anadirla a jt_calc_config().
 *
 * @package jhontra-theme
 */

get_header();

$jt_key = jt_calc_current();
$jt_cfg = jt_calc_config();

if ( ! $jt_key ) {
	// Slug que no corresponde a ninguna variante: se muestra el contenido normal.
	while ( have_posts() ) { the_post(); the_content(); }
	get_footer();
	return;
}

$C   = $jt_cfg[ $jt_key ];
$i18 = jt_calc_i18n();
$pt  = jt_is_pt();
$uri = get_template_directory_uri();
$base = jt_calc_base();
?>

<div class="jt-wrap jt-calc-wrap">

  <?php jt_breadcrumbs(); ?>

  <nav class="jt-calc-tabs" aria-label="Variantes">
    <?php foreach ( $jt_cfg as $k => $c ) : ?>
      <a href="<?php echo esc_url( $base . $c['slug'] . '/' ); ?>"
         class="<?php echo $k === $jt_key ? 'is-active' : ''; ?>"
         <?php echo $k === $jt_key ? 'aria-current="page"' : 'rel="prefetch"'; ?>><?php echo esc_html( $c['tab'] ); ?></a>
    <?php endforeach; ?>
  </nav>

  <header class="jt-calc-head">
    <span class="jt-calc-eyebrow"><?php echo $pt ? 'Ferramenta gratuita' : 'Herramienta gratuita'; ?> · <?php echo esc_html( $C['nombre'] ); ?></span>
    <h1><?php echo esc_html( $C['h1a'] ); ?><i><?php echo esc_html( $C['h1b'] ); ?></i></h1>
    <p><?php echo esc_html( $C['lede'] ); ?></p>
  </header>

  <div class="jt-calc" id="jt-calc">
    <section>
      <div class="jt-felt-outer">
        <div class="jt-felt">
          <div class="jt-board-zone">
            <div class="jt-feltmark"><span>Omaha<i>Latam</i><em>.com</em></span></div>
            <div class="jt-zone-label">Mesa</div>
            <div class="jt-board-slots"></div>
            <div class="jt-board-tag"><span class="is-flop">FLOP</span><i></i><span class="is-turn">TURN</span><i></i><span class="is-river">RIVER</span></div>
          </div>
        </div>
      </div>

      <div class="jt-picker">
        <div class="jt-picker-head">
          <span class="lab"><?php echo $pt ? 'Atribuindo a' : 'Asignando a'; ?></span>
          <span class="jt-target"></span>
          <div class="jt-picker-actions">
            <button type="button" class="jt-cbtn jt-calc-random"><?php echo $pt ? 'Aleatório' : 'Aleatorio'; ?></button>
            <button type="button" class="jt-cbtn jt-calc-clear"><?php echo $pt ? 'Limpar' : 'Limpiar'; ?></button>
          </div>
        </div>
        <div class="jt-deck"></div>
      </div>
    </section>

    <aside class="jt-panel">
      <h2>Resultado</h2>
      <div class="jt-results">
        <div class="jt-res-empty"><?php
          echo $pt
            ? 'Distribua cartas para duas ou mais posições e clique em calcular.<br><br>A mesa é opcional: sem ela o cálculo é preflop.'
            : 'Reparte cartas a dos o más posiciones y pulsa calcular.<br><br>La mesa es opcional: sin ella el cálculo es preflop.';
        ?></div>
      </div>
      <div class="jt-prog"><i></i></div>
      <button type="button" class="jt-cbtn is-gold is-wide jt-calc-go" style="margin-top:14px">Calcular equity</button>
      <div class="jt-tools">
        <button type="button" class="jt-cbtn jt-calc-share"><?php echo $pt ? 'Copiar link' : 'Copiar enlace'; ?></button>
        <a class="jt-cbtn" style="text-align:center;text-decoration:none" href="<?php echo esc_url( jt_whatsapp_url() ); ?>" target="_blank" rel="noopener"><?php
          echo $pt ? 'Tirar dúvida' : 'Preguntar'; ?></a>
      </div>
      <div class="jt-meta"></div>
      <div class="jt-kbd"><?php echo $pt
        ? 'Teclado: digite <b>As</b>, <b>Td</b> · <b>←→</b> mover · <b>⌫</b> apagar · <b>Enter</b> calcular'
        : 'Teclado: escribe <b>As</b>, <b>Td</b> · <b>←→</b> mover · <b>⌫</b> borrar · <b>Enter</b> calcular'; ?></div>
    </aside>
  </div>

  <div class="jt-toast" id="jt-toast"></div>

  <div class="jt-calc-article">
    <?php while ( have_posts() ) { the_post(); the_content(); } ?>
  </div>

</div>

<?php get_footer(); ?>
