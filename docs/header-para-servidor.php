<?php
/**
 * Header global — age gate 18+, nav sticky con logo J♠ y menú móvil.
 *
 * La nav es la MISMA que la de la portada estática (front-page.html).
 * Si tocas una, toca la otra: la portada se sirve fuera de WordPress y no
 * puede leer este archivo.
 *
 * Anclas de la portada: s2 Método · s3 Jhontra · s4 Clubes · s5 Contenido · s6 Empezar
 *
 * @package jhontra-theme
 */
if ( ! defined( 'ABSPATH' ) ) exit;

$jt_wa  = 'https://wa.me/573136593208';
$jt_home = trailingslashit( home_url( '/' ) );
$jt_en_blog = ( is_home() || is_archive() || is_single() || is_search() );

$jt_nav = array(
	array( 'Método',          $jt_home . '#s2', false ),
	array( 'Jhontra',         $jt_home . '#s3', false ),
	array( 'Clubes',          $jt_home . '#s4', false ),
	array( 'Contenido',       $jt_home . '#s5', false ),
	array( 'Blog / Noticias', home_url( '/blog/' ), $jt_en_blog ),
	array( 'Empezar',         $jt_home . '#s6', false ),
);
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<!-- Age Gate -->
<div id="jt-age-gate" class="jt-age" role="dialog" aria-modal="true" aria-label="Verificación de edad" style="display:none;">
  <div class="jt-age__card">
    <div class="jt-age__badge">18+</div>
    <h2>¿Eres mayor de 18 años?</h2>
    <p>Este sitio contiene contenido sobre poker destinado únicamente a personas adultas. Juega con responsabilidad.</p>
    <button type="button" id="jt-age-yes" class="jt-age__btn-yes">Sí, soy mayor de 18</button>
    <a href="https://www.google.com" class="jt-age__btn-no">Salir del sitio</a>
  </div>
</div>

<!-- Sticky Nav -->
<header class="jt-nav" id="jt-nav">
  <nav class="jt-nav__inner">
    <!-- Logo: J♠ card -->
    <a href="<?php echo esc_url( home_url('/') ); ?>" class="jt-logo" aria-label="Jhontra — Inicio">
      <div class="jt-logo__card">
        <div class="jt-logo__shadow"></div>
        <div class="jt-logo__face">
          <span class="jt-logo__corner jt-logo__corner--tl">J<br>♠</span>
          <span class="jt-logo__corner jt-logo__corner--br">J<br>♠</span>
          <svg viewBox="0 0 60 84" class="jt-logo__knave" aria-hidden="true">
            <line x1="10" y1="42" x2="50" y2="42" stroke="#2A2005" stroke-width="1.6"/>
            <g fill="#2A2005">
              <g id="knaveNav"><path d="M24 13 h12 v3 l-2 -2 -2 2 -2 -2 -2 2 -2 -2 z"/><rect x="24" y="16" width="12" height="2.4"/><circle cx="30" cy="24" r="4.6"/><path d="M24.5 30 q5.5 -3 11 0 l2 10 h-15 z"/><path d="M40 40 l-3.5 -9 5 2.5 z"/></g>
              <use href="#knaveNav" transform="rotate(180 30 42)"/>
            </g>
          </svg>
        </div>
      </div>
      <span class="jt-logo__name">Jhontra</span>
    </a>

    <!-- Desktop nav -->
    <div class="jt-nav__links" id="jt-desktop-nav">
      <?php foreach ( $jt_nav as $jt_i ) : ?>
        <a href="<?php echo esc_url( $jt_i[1] ); ?>"<?php echo $jt_i[2] ? ' class="jt-nav__active"' : ''; ?>><?php echo esc_html( $jt_i[0] ); ?></a>
      <?php endforeach; ?>
    </div>

    <!-- Actions -->
    <div class="jt-nav__actions">
      <a href="<?php echo esc_url( $jt_wa ); ?>" class="jt-nav__cta" id="jt-desktop-cta" target="_blank" rel="noopener">
        <span>✆</span> WhatsApp
      </a>
      <button type="button" id="jt-mobile-btn" class="jt-nav__hamburger" aria-label="Abrir menú" aria-expanded="false">☰</button>
    </div>
  </nav>

  <!-- Mobile menu -->
  <div class="jt-nav__mobile" id="jt-mobile-menu" style="display:none;">
    <?php foreach ( $jt_nav as $jt_i ) : ?>
      <a href="<?php echo esc_url( $jt_i[1] ); ?>"<?php echo $jt_i[2] ? ' class="jt-nav__active"' : ''; ?>><?php echo esc_html( $jt_i[0] ); ?></a>
    <?php endforeach; ?>
    <a href="<?php echo esc_url( $jt_wa ); ?>" class="jt-nav__mobile-cta" target="_blank" rel="noopener">Escríbenos por WhatsApp</a>
  </div>
</header>

<main id="main-content">
