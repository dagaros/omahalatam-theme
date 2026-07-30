<?php
/**
 * Jhontra PLO5 — Template tags
 * Funciones reutilizables desde las plantillas.
 *
 * @package jhontra-theme
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Tiempo estimado de lectura (200 palabras por minuto).
 *
 * @param int|null $id ID del post. Por defecto el post actual.
 * @return string Ej. "6 min".
 */
function jt_reading_time( $id = null ) {
	$content = get_post_field( 'post_content', $id ?: get_the_ID() );
	$words   = str_word_count( strip_tags( $content ) );
	return max( 1, ceil( $words / 200 ) ) . ' min';
}

/**
 * Ruta de navegación (breadcrumbs). No se imprime en la portada.
 */
function jt_breadcrumbs() {

	if ( is_front_page() ) return;

	echo '<nav aria-label="Ruta de navegación" class="jt-crumbs">';
	echo '<a href="' . esc_url( home_url( '/' ) ) . '">Inicio</a>';
	echo '<span class="jt-crumbs__sep">›</span>';

	if ( is_single() ) {

		echo '<a href="' . esc_url( home_url( '/blog/' ) ) . '">Blog</a>';
		$cats = get_the_category();
		if ( ! empty( $cats ) ) {
			echo '<span class="jt-crumbs__sep">›</span>';
			echo '<a href="' . esc_url( get_category_link( $cats[0]->term_id ) ) . '">' . esc_html( $cats[0]->name ) . '</a>';
		}
		echo '<span class="jt-crumbs__sep">›</span>';
		$title = get_the_title();
		echo '<span class="jt-crumbs__current">' . esc_html( mb_strlen( $title ) > 42 ? mb_substr( $title, 0, 40 ) . '…' : $title ) . '</span>';

	} elseif ( is_page() ) {

		echo '<span class="jt-crumbs__current">' . esc_html( get_the_title() ) . '</span>';

	} elseif ( is_category() ) {

		echo '<a href="' . esc_url( home_url( '/blog/' ) ) . '">Blog</a>';
		echo '<span class="jt-crumbs__sep">›</span>';
		echo '<span class="jt-crumbs__current">' . single_cat_title( '', false ) . '</span>';

	} elseif ( is_search() ) {

		echo '<a href="' . esc_url( home_url( '/blog/' ) ) . '">Blog</a>';
		echo '<span class="jt-crumbs__sep">›</span>';
		echo '<span class="jt-crumbs__current">Búsqueda</span>';

	} elseif ( is_404() ) {

		echo '<span class="jt-crumbs__current">Página no encontrada</span>';

	} else {

		echo '<span class="jt-crumbs__current">Blog</span>';
	}

	echo '</nav>';
}

/**
 * Nombre de la categoría principal de un post, en mayúsculas.
 * Devuelve "BLOG" si el post no tiene categoría.
 *
 * @param int|null $id ID del post.
 * @return string
 */
function jt_primary_cat( $id = null ) {
	$cats = get_the_category( $id ?: get_the_ID() );
	return ! empty( $cats ) ? strtoupper( $cats[0]->name ) : 'BLOG';
}

/**
 * Número de WhatsApp del equipo de Jhontra.
 * Punto único de cambio: si cambia el número, se cambia aquí y se propaga
 * a nav, footer, FAB, CTAs y sidebar.
 *
 * @return string Número en formato internacional sin signos.
 */
function jt_whatsapp() {
	return apply_filters( 'jt_whatsapp_number', '573107114689' );
}

/**
 * URL de contacto por WhatsApp, con mensaje opcional.
 *
 * @param string $mensaje Texto prellenado.
 * @return string
 */
function jt_whatsapp_url( $mensaje = '' ) {
	$url = 'https://wa.me/' . jt_whatsapp();
	if ( $mensaje ) {
		$url .= '?text=' . rawurlencode( $mensaje );
	}
	return $url;
}
