<?php
/**
 * Medición — Google Tag Manager.
 *
 * El contenedor GTM-TPV5K8W3 (cuenta Omaha Latam) carga la etiqueta de Google
 * de la propiedad GA4 G-1FKBMZLMJD y el evento clic_whatsapp. Toda etiqueta
 * nueva se añade desde Tag Manager, no desde el tema.
 *
 * Dos rutas de inyección, porque el sitio tiene dos formas de renderizar:
 *
 *   1. Páginas de WordPress  →  header.php llama a jt_gtm_head() y
 *      jt_gtm_noscript() directamente.
 *   2. Portada estática      →  front-page.php se sirve con readfile() y nunca
 *      pasa por wp_head(), así que inyecta estos mismos fragmentos en
 *      front-page.html con str_replace() antes de imprimir.
 *
 * Para cambiar de contenedor basta con tocar JT_GTM_ID.
 *
 * @package jhontra-theme
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/** ID del contenedor de Google Tag Manager. */
define( 'JT_GTM_ID', 'GTM-TPV5K8W3' );

/**
 * Fragmento de GTM para el <head>. Va lo más arriba posible.
 *
 * @return string HTML listo para imprimir.
 */
function jt_gtm_head() {
	$id = JT_GTM_ID;

	return <<<HTML
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','{$id}');</script>
<!-- End Google Tag Manager -->

HTML;
}

/**
 * Fragmento de GTM sin JavaScript. Va justo después de <body>.
 *
 * @return string HTML listo para imprimir.
 */
function jt_gtm_noscript() {
	$id = JT_GTM_ID;

	return <<<HTML
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id={$id}"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

HTML;
}
