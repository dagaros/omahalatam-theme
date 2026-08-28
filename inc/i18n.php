<?php
/**
 * Jhontra PLO5 — Multiidioma (Polylang)
 *
 * El sitio corre en espanol (es, principal) y portugues de Brasil (pt).
 * Centraliza la deteccion de idioma, las cadenas de la interfaz del tema y
 * el selector. Si Polylang se desactiva, todo cae a espanol sin romper nada.
 *
 * @package jhontra-theme
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Idioma actual como slug corto: 'es' o 'pt'.
 */
function jt_lang() {
	$slug = function_exists( 'pll_current_language' ) ? pll_current_language( 'slug' ) : '';
	if ( ! $slug ) {
		$slug = substr( (string) get_locale(), 0, 2 );
	}
	return in_array( $slug, array( 'es', 'pt' ), true ) ? $slug : 'es';
}

/**
 * Estamos en la version en portugues.
 */
function jt_is_pt() {
	return 'pt' === jt_lang();
}

/**
 * Diccionario de la interfaz del tema.
 *
 * Solo cubre las cadenas que el tema imprime a mano. El contenido de las
 * entradas ya se escribe en cada idioma.
 *
 * @param string $key Clave.
 * @return string
 */
function jt_t( $key ) {

	$dict = array(
		'nav_metodo'    => array( 'es' => 'Método',           'pt' => 'Método' ),
		'nav_jhontra'   => array( 'es' => 'Jhontra',          'pt' => 'Jhontra' ),
		'nav_clubes'    => array( 'es' => 'Clubes',           'pt' => 'Clubes' ),
		'nav_contenido' => array( 'es' => 'Contenido',        'pt' => 'Conteúdo' ),
		'nav_blog'      => array( 'es' => 'Blog / Noticias',  'pt' => 'Blog / Notícias' ),
		'nav_empezar'   => array( 'es' => 'Empezar',          'pt' => 'Começar' ),

		'crumb_inicio'  => array( 'es' => 'Inicio',               'pt' => 'Início' ),
		'crumb_blog'    => array( 'es' => 'Blog',                 'pt' => 'Blog' ),
		'crumb_busca'   => array( 'es' => 'Búsqueda',             'pt' => 'Busca' ),
		'crumb_404'     => array( 'es' => 'Página no encontrada', 'pt' => 'Página não encontrada' ),

		'lectura'       => array( 'es' => 'min de lectura', 'pt' => 'min de leitura' ),
		'idioma'        => array( 'es' => 'Idioma',         'pt' => 'Idioma' ),
	);

	$lang = jt_lang();

	if ( ! isset( $dict[ $key ] ) ) {
		return $key;
	}

	return isset( $dict[ $key ][ $lang ] ) ? $dict[ $key ][ $lang ] : $dict[ $key ]['es'];
}

/**
 * Idiomas disponibles para el selector.
 *
 * Devuelve array vacio si Polylang no esta activo, para que el selector
 * simplemente no se imprima.
 */
function jt_languages() {

	if ( ! function_exists( 'pll_the_languages' ) ) {
		return array();
	}

	$raw = pll_the_languages( array(
		'raw'                    => 1,
		'hide_if_no_translation' => 0,
		'display_names_as'       => 'slug',
	) );

	if ( ! is_array( $raw ) || count( $raw ) < 2 ) {
		return array();
	}

	$labels = array( 'es' => 'ES', 'pt' => 'PT' );
	$out    = array();

	foreach ( $raw as $l ) {
		$slug  = isset( $l['slug'] ) ? $l['slug'] : '';
		$out[] = array(
			'slug'    => $slug,
			'label'   => isset( $labels[ $slug ] ) ? $labels[ $slug ] : strtoupper( $slug ),
			'url'     => isset( $l['url'] ) ? $l['url'] : home_url( '/' ),
			'current' => ! empty( $l['current_lang'] ),
		);
	}

	return $out;
}

/**
 * Imprime el selector de idioma.
 *
 * @param string $clase Clase extra para el contenedor.
 */
function jt_language_switcher( $clase = '' ) {

	$langs = jt_languages();
	if ( ! $langs ) return;

	echo '<div class="jt-lang ' . esc_attr( $clase ) . '" role="group" aria-label="' . esc_attr( jt_t( 'idioma' ) ) . '">';

	foreach ( $langs as $l ) {
		printf(
			'<a href="%s" class="jt-lang__item%s" hreflang="%s" lang="%s">%s</a>',
			esc_url( $l['url'] ),
			$l['current'] ? ' is-active' : '',
			esc_attr( $l['slug'] ),
			esc_attr( $l['slug'] ),
			esc_html( $l['label'] )
		);
	}

	echo '</div>';
}
