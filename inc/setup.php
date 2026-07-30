<?php
/**
 * Jhontra PLO5 — Setup del tema
 * Soportes, tamaños de imagen y menús.
 *
 * @package jhontra-theme
 */

if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'after_setup_theme', function () {

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'custom-logo' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
		'style',
		'script',
	) );

	// Tamaños de imagen del tema.
	add_image_size( 'jt-featured', 1200, 675, true ); // Destacada / hero de post.
	add_image_size( 'jt-card', 640, 400, true );      // Tarjeta de grid.
	add_image_size( 'jt-thumb', 112, 112, true );     // Miniatura del sidebar.

	register_nav_menus( array(
		'primary' => 'Menú Principal',
		'footer'  => 'Menú del Footer',
	) );
} );

/**
 * Etiquetas legibles para los tamaños de imagen en el selector de medios.
 */
add_filter( 'image_size_names_choose', function ( $sizes ) {
	return array_merge( $sizes, array(
		'jt-featured' => 'Destacada (1200×675)',
		'jt-card'     => 'Tarjeta (640×400)',
		'jt-thumb'    => 'Miniatura (112×112)',
	) );
} );
