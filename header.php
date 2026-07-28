<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
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
      <a href="<?php echo esc_url( home_url('/') ); ?>">Inicio</a>
      <a href="<?php echo esc_url( home_url('/#acerca') ); ?>">Acerca de</a>
      <a href="<?php echo esc_url( home_url('/#clubes') ); ?>">Clubes</a>
      <a href="<?php echo esc_url( home_url('/blog/') ); ?>" <?php if ( is_home() || is_archive() || is_single() ) echo 'class="jt-nav__active"'; ?>>Blog / Noticias</a>
      <a href="<?php echo esc_url( home_url('/#contacto') ); ?>">Contacto</a>
    </div>

    <!-- Actions -->
    <div class="jt-nav__actions">
      <a href="https://wa.me/573107114689" class="jt-nav__cta" id="jt-desktop-cta" target="_blank" rel="noopener">
        <span>✆</span> WhatsApp
      </a>
      <button type="button" id="jt-mobile-btn" class="jt-nav__hamburger" aria-label="Abrir menú" aria-expanded="false">☰</button>
    </div>
  </nav>

  <!-- Mobile menu -->
  <div class="jt-nav__mobile" id="jt-mobile-menu" style="display:none;">
    <a href="<?php echo esc_url( home_url('/') ); ?>">Inicio</a>
    <a href="<?php echo esc_url( home_url('/#acerca') ); ?>">Acerca de</a>
    <a href="<?php echo esc_url( home_url('/#clubes') ); ?>">Clubes</a>
    <a href="<?php echo esc_url( home_url('/blog/') ); ?>" <?php if ( is_home() || is_archive() || is_single() ) echo 'class="jt-nav__active"'; ?>>Blog / Noticias</a>
    <a href="<?php echo esc_url( home_url('/#contacto') ); ?>">Contacto</a>
    <a href="https://wa.me/573107114689" class="jt-nav__mobile-cta" target="_blank" rel="noopener">Escríbenos por WhatsApp</a>
  </div>
</header>

<main id="main-content">
