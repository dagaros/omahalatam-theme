<?php
/**
 * Jhontra PLO5 — functions.php
 *
 * Este archivo solo carga módulos. Toda la lógica vive en /inc.
 * Si necesitas cambiar algo, busca el módulo correspondiente:
 *
 *   inc/setup.php          Soportes del tema, tamaños de imagen, menús.
 *   inc/enqueue.php        CSS y JS (ojo con el ORDEN de carga del CSS).
 *   inc/template-tags.php  jt_reading_time(), jt_breadcrumbs(), jt_whatsapp()…
 *   inc/schema.php         JSON-LD (Article / WebSite).
 *   inc/cleanup.php        Head, extractos, comentarios, query, buscador.
 *
 * @package jhontra-theme
 * @link    https://omahalatam.com
 */

if ( ! defined( 'ABSPATH' ) ) exit;

define( 'JT_THEME_DIR', get_template_directory() );
define( 'JT_THEME_URI', get_template_directory_uri() );

foreach ( array( 'setup', 'enqueue', 'template-tags', 'schema', 'cleanup' ) as $jt_module ) {
	$jt_file = JT_THEME_DIR . '/inc/' . $jt_module . '.php';
	if ( file_exists( $jt_file ) ) {
		require_once $jt_file;
	}
}
unset( $jt_module, $jt_file );
