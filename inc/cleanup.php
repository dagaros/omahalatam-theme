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
