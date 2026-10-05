<?php
/**
 * Jhontra PLO5 — Limpieza del <head>, comentarios, extractos, query y buscador
 *
 * @package jhontra-theme
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/* ── Cabecera ────────────────────────────────────────────────── */

remove_action( 'wp_head', 'wp_generator' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'rsd_link' );

/* ── Extractos ───────────────────────────────────────────────── */

add_filter( 'excerpt_length', function () { return 30; } );
add_filter( 'excerpt_more',   function () { return '…'; } );

/* ── Comentarios desactivados en todo el sitio ───────────────── */

add_filter( 'comments_open',  '__return_false' );
add_filter( 'pings_open',     '__return_false' );
add_filter( 'comments_array', '__return_empty_array' );

/* ── Query principal ─────────────────────────────────────────── */

add_action( 'pre_get_posts', function ( $q ) {
	if ( is_admin() || ! $q->is_main_query() ) return;

	if ( $q->is_home() || $q->is_archive() || $q->is_search() ) {
		$q->set( 'posts_per_page', 9 );
	}
} );

/* ── Buscador ────────────────────────────────────────────────── */

add_filter( 'get_search_form', function () {
	return '<form role="search" method="get" action="' . esc_url( jt_home_url( '/' ) ) . '" class="jt-search">
        <div class="jt-search__field"><span class="jt-search__icon">⌕</span>
        <input type="search" name="s" placeholder="Buscar artículos, manos, clubes…" aria-label="Buscar en el blog" value="' . esc_attr( get_search_query() ) . '" /></div>
        <button type="submit">Buscar</button></form>';
} );

/* ── /llms.txt ───────────────────────────────────────────────── */

/**
 * Sirve /llms.txt (guía del sitio para ChatGPT, Claude, Perplexity…) desde
 * el llms.txt del tema. Así se publica con el tema, sin tocar la raíz del
 * hosting. Para cambiar el texto se edita ese archivo.
 */
add_action( 'init', function () {
	$path = wp_parse_url( isset( $_SERVER['REQUEST_URI'] ) ? $_SERVER['REQUEST_URI'] : '', PHP_URL_PATH );
	$file = JT_THEME_DIR . '/llms.txt';

	if ( '/llms.txt' !== $path || ! is_readable( $file ) ) return;

	header( 'Content-Type: text/plain; charset=utf-8' );
	readfile( $file );
	exit;
} );
