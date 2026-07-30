<?php
/**
 * Jhontra PLO5 — Encolado de estilos y scripts
 *
 * ORDEN DE CARGA DEL CSS — NO ALTERAR.
 * base → layout → blog → motion
 * El diseño depende de la cascada en ese orden exacto. `motion.css`
 * (prefers-reduced-motion) debe quedar SIEMPRE al final.
 *
 * La portada (front-page.html) es un export estático que se sirve por
 * readfile() sin pasar por wp_head(), así que no recibe ninguno de estos
 * assets: su CSS y su JS viven embebidos dentro del propio HTML.
 *
 * @package jhontra-theme
 */

if ( ! defined( 'ABSPATH' ) ) exit;

define( 'JT_ASSET_VER', '2.1.0' );

add_action( 'wp_enqueue_scripts', function () {

	$uri = get_template_directory_uri();

	// Tipografías: Bricolage Grotesque (títulos), Hanken Grotesk (texto), IBM Plex Mono (etiquetas).
	wp_enqueue_style(
		'jt-fonts',
		'https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,400..800&family=Hanken+Grotesk:wght@400;500;600;700;800&family=IBM+Plex+Mono:wght@400;500&display=swap',
		array(),
		null
	);

	if ( is_front_page() ) {
		return; // La portada estática se autoabastece.
	}

	wp_enqueue_style( 'jt-base',   $uri . '/assets/css/base.css',   array( 'jt-fonts' ), JT_ASSET_VER );
	wp_enqueue_style( 'jt-layout', $uri . '/assets/css/layout.css', array( 'jt-base' ),  JT_ASSET_VER );
	wp_enqueue_style( 'jt-blog',   $uri . '/assets/css/blog.css',   array( 'jt-layout' ), JT_ASSET_VER );
	wp_enqueue_style( 'jt-motion', $uri . '/assets/css/motion.css', array( 'jt-blog' ),  JT_ASSET_VER );

	// Comportamiento global (age gate, menú móvil, breakpoints, reveal).
	wp_enqueue_script( 'jt-theme', $uri . '/assets/js/theme.js', array(), JT_ASSET_VER, true );

	// Tabla de contenidos: solo en posts individuales.
	if ( is_single() ) {
		wp_enqueue_script( 'jt-single-toc', $uri . '/assets/js/single-toc.js', array(), JT_ASSET_VER, true );
	}
} );

/**
 * Preconnect a Google Fonts (ahorra ~100ms en la primera carga).
 */
add_filter( 'wp_resource_hints', function ( $hints, $relation ) {
	if ( 'preconnect' === $relation ) {
		$hints[] = array( 'href' => 'https://fonts.googleapis.com' );
		$hints[] = array( 'href' => 'https://fonts.gstatic.com', 'crossorigin' => 'anonymous' );
	}
	return $hints;
}, 10, 2 );
