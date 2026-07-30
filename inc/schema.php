<?php
/**
 * Jhontra PLO5 — Datos estructurados (JSON-LD)
 * Article en posts, Organization + WebSite en el resto.
 *
 * @package jhontra-theme
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Imprime un bloque JSON-LD.
 *
 * @param array $data Grafo de schema.org.
 */
function jt_print_schema( array $data ) {
	echo '<script type="application/ld+json">'
		. wp_json_encode( $data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE )
		. "</script>\n";
}

add_action( 'wp_head', function () {

	// La portada estática no pasa por wp_head(); trae su propio schema embebido.
	if ( is_front_page() ) return;

	if ( is_single() ) {

		$schema = array(
			'@context'         => 'https://schema.org',
			'@type'            => 'Article',
			'headline'         => get_the_title(),
			'datePublished'    => get_the_date( 'c' ),
			'dateModified'     => get_the_modified_date( 'c' ),
			'author'           => array(
				'@type' => 'Person',
				'name'  => 'Jhontra',
				'url'   => home_url( '/' ),
			),
			'publisher'        => array(
				'@type' => 'Organization',
				'name'  => 'Jhontra PLO5',
				'url'   => home_url( '/' ),
			),
			'mainEntityOfPage' => get_permalink(),
			'inLanguage'       => 'es',
		);

		$img = get_the_post_thumbnail_url( get_the_ID(), 'jt-featured' );
		if ( $img ) $schema['image'] = $img;

		jt_print_schema( $schema );
		return;
	}

	// Blog, categorías y páginas.
	jt_print_schema( array(
		'@context'    => 'https://schema.org',
		'@type'       => 'WebSite',
		'name'        => get_bloginfo( 'name' ),
		'url'         => home_url( '/' ),
		'inLanguage'  => 'es',
		'publisher'   => array(
			'@type' => 'Organization',
			'name'  => 'Jhontra PLO5',
			'url'   => home_url( '/' ),
		),
		'potentialAction' => array(
			'@type'       => 'SearchAction',
			'target'      => array(
				'@type'       => 'EntryPoint',
				'urlTemplate' => home_url( '/?s={search_term_string}' ),
			),
			'query-input' => 'required name=search_term_string',
		),
	) );
} );
