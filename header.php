<?php
/**
 * Header global: age gate 18+, nav sticky con logo J♠ y menú móvil.
 * El JS de comportamiento está en assets/js/theme.js.
 *
 * @package jhontra-theme
 */
if ( ! defined( 'ABSPATH' ) ) exit;
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php echo jt_gtm_head(); // phpcs:ignore WordPress.Security.EscapeOutput — fragmento fijo de Google Tag Manager. ?>
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php echo jt_gtm_noscript(); // phpcs:ignore WordPress.Security.EscapeOutput — fragmento fijo de Google Tag Manager. ?>
<?php wp_body_open(); ?>

<!-- Age Gate -->
<div id="jt-age-gate" class="jt-age" role="dialog" aria-modal="true" aria-label="<?php echo esc_attr( jt_t('h_edad_lbl') ); ?>" style="display:none;">
  <div class="jt-age__card">
    <div class="jt-age__badge">18+</div>
    <h2><?php echo esc_html( jt_t('h_edad_q') ); ?></h2>
    <p>Este sitio contiene contenido sobre poker destinado únicamente a personas adultas. Juega con responsabilidad.</p>
    <button type="button" id="jt-age-yes" class="jt-age__btn-yes"><?php echo esc_html( jt_t('h_edad_si') ); ?></button>
    <a href="https://www.google.com" class="jt-age__btn-no"><?php echo esc_html( jt_t('h_edad_no') ); ?></a>
  </div>
</div>

<!-- Sticky Nav -->
<header class="jt-nav" id="jt-nav">
  <nav class="jt-nav__inner">
    <!-- Logo: J♠ card -->
    <a href="<?php echo esc_url( jt_home_url('/') ); ?>" class="jt-logo" aria-label="<?php echo esc_attr( jt_t('h_inicio') ); ?>">
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
      <?php foreach ( jt_nav_items() as $jt_item ) : ?>
        <a href="<?php echo esc_url( $jt_item['url'] ); ?>" class="<?php echo $jt_item['active'] ? 'jt-nav__active ' : ''; ?><?php echo empty( $jt_item['cta'] ) ? '' : 'jt-nav__pill'; ?>"><?php echo esc_html( $jt_item['label'] ); ?></a>
      <?php endforeach; ?>
    </div>

    <!-- Actions -->
    <div class="jt-nav__actions">
      <?php jt_language_switcher( 'jt-lang--nav' ); ?>
      <a href="<?php echo esc_url( jt_whatsapp_url() ); ?>" class="jt-nav__cta" id="jt-desktop-cta" target="_blank" rel="noopener">
        <span>✆</span> WhatsApp
      </a>
      <button type="button" id="jt-mobile-btn" class="jt-nav__hamburger" aria-label="<?php echo esc_attr( jt_t('h_menu') ); ?>" aria-expanded="false">☰</button>
    </div>
  </nav>

  <!-- Mobile menu -->
  <div class="jt-nav__mobile" id="jt-mobile-menu" style="display:none;">
    <?php foreach ( jt_nav_items() as $jt_item ) : ?>
      <a href="<?php echo esc_url( $jt_item['url'] ); ?>" class="<?php echo $jt_item['active'] ? 'jt-nav__active ' : ''; ?><?php echo empty( $jt_item['cta'] ) ? '' : 'jt-nav__pill'; ?>"><?php echo esc_html( $jt_item['label'] ); ?></a>
    <?php endforeach; ?>
    <a href="<?php echo esc_url( jt_whatsapp_url() ); ?>" class="jt-nav__mobile-cta" target="_blank" rel="noopener"><?php echo esc_html( jt_t('h_wa_mob') ); ?></a>
  </div>
</header>

<main id="main-content">
