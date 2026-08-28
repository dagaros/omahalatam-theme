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
	echo '<a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html( jt_t( 'crumb_inicio' ) ) . '</a>';
	echo '<span class="jt-crumbs__sep">›</span>';

	if ( is_single() ) {

		echo '<a href="' . esc_url( home_url( '/blog/' ) ) . '">' . esc_html( jt_t( 'crumb_blog' ) ) . '</a>';
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

		echo '<a href="' . esc_url( home_url( '/blog/' ) ) . '">' . esc_html( jt_t( 'crumb_blog' ) ) . '</a>';
		echo '<span class="jt-crumbs__sep">›</span>';
		echo '<span class="jt-crumbs__current">' . single_cat_title( '', false ) . '</span>';

	} elseif ( is_search() ) {

		echo '<a href="' . esc_url( home_url( '/blog/' ) ) . '">' . esc_html( jt_t( 'crumb_blog' ) ) . '</a>';
		echo '<span class="jt-crumbs__sep">›</span>';
		echo '<span class="jt-crumbs__current">' . esc_html( jt_t( 'crumb_busca' ) ) . '</span>';

	} elseif ( is_404() ) {

		echo '<span class="jt-crumbs__current">' . esc_html( jt_t( 'crumb_404' ) ) . '</span>';

	} else {

		echo '<span class="jt-crumbs__current">' . esc_html( jt_t( 'crumb_blog' ) ) . '</span>';
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
 * Tarjetas de las últimas entradas para la sección "Contenido" de la portada.
 *
 * Reproduce EXACTAMENTE el marcado de las tarjetas del export estático: mismos
 * estilos, mismo marcador de vídeo, mismo badge. Lo único que cambia es que los
 * datos salen de la base de datos en vez de estar escritos a mano.
 *
 * Si no hay entradas publicadas devuelve cadena vacía y front-page.php deja
 * las tarjetas estáticas intactas.
 *
 * @param int $cantidad Número de tarjetas.
 * @return string HTML, o '' si no hay entradas.
 */
function jt_front_page_cards( $cantidad = 3 ) {

	$q = new WP_Query( array(
		'posts_per_page'      => (int) $cantidad,
		'post_status'         => 'publish',
		'ignore_sticky_posts' => true,
		'no_found_rows'       => true,
	) );

	if ( ! $q->have_posts() ) {
		wp_reset_postdata();
		return '';
	}

	$out = '';

	while ( $q->have_posts() ) : $q->the_post();

		$cat   = jt_primary_cat();
		$fecha = strtoupper( get_the_date( 'd M Y' ) );
		$img   = get_the_post_thumbnail_url( get_the_ID(), 'jt-featured' );

		/*
		 * Miniatura: la portada del artículo si existe. Si no, se conserva el
		 * marcador de rayas del diseño original para que la tarjeta no se
		 * desarme. El botón de play solo aparece sin portada: sobre una
		 * portada real prometería un vídeo donde hay un artículo.
		 */
		if ( $img ) {
			$miniatura = '
          <div style="position:absolute;inset:0;background-image:url(' . esc_url( $img ) . ');background-size:cover;background-position:center;"></div>
          <div style="position:absolute;inset:0;background:linear-gradient(180deg,rgba(0,0,0,0) 55%,rgba(0,0,0,0.55) 100%);"></div>';
		} else {
			$miniatura = '
          <div style="position:absolute;inset:0;background:radial-gradient(circle at center,rgba(212,175,84,0.08),transparent 60%);"></div>
          <div style="position:relative;width:56px;height:56px;border-radius:50%;background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.16);display:grid;place-items:center;color:#fff;font-size:18px;padding-left:4px;">&#9654;</div>';
		}

		$out .= '
      <article data-reveal class="card-hover" style="background:linear-gradient(180deg,#141417,#0e0e10);border:1px solid rgba(255,255,255,0.08);border-radius:18px;overflow:hidden;">
        <a href="' . esc_url( get_permalink() ) . '" style="display:block;aspect-ratio:16/9;background:repeating-linear-gradient(45deg,#131316 0 12px,#0f0f11 12px 24px);position:relative;display:grid;place-items:center;">' . $miniatura . '
          <div style="position:absolute;bottom:10px;right:10px;font-family:\'IBM Plex Mono\',monospace;font-size:10px;color:#9AA0AA;background:rgba(0,0,0,0.6);padding:3px 7px;border-radius:5px;">' . esc_html( $cat ) . '</div>
        </a>
        <div style="padding:20px;">
          <div style="font-family:\'IBM Plex Mono\',monospace;font-size:11px;letter-spacing:1px;color:#7A808A;margin-bottom:9px;">' . esc_html( $fecha ) . '</div>
          <h3 style="margin:0 0 16px;font-size:17px;font-weight:600;line-height:1.35;color:#fff;">' . esc_html( get_the_title() ) . '</h3>
          <a href="' . esc_url( get_permalink() ) . '" style="display:inline-flex;align-items:center;gap:8px;font-size:14px;font-weight:600;color:#E7C877;">Ver an&aacute;lisis <span>&rarr;</span></a>
        </div>
      </article>';

	endwhile;

	wp_reset_postdata();

	return $out . "\n    ";
}

/**
 * Anclas de las secciones de la portada.
 *
 * La portada (front-page.html) numera sus secciones s2…s6. Este mapa traduce
 * nombres legibles a esos ids para que las plantillas no dependan de la
 * numeración. Si algún día la portada cambia sus ids, se corrige aquí y punto.
 *
 * @return array<string,string>
 */
function jt_home_anchors() {
	return apply_filters( 'jt_home_anchors', array(
		'metodo'    => 's2', // El método / por qué PLO5
		'jhontra'   => 's3', // Sobre el coach
		'clubes'    => 's4', // Suprema y PPPoker
		'contenido' => 's5', // Videos y análisis
		'empezar'   => 's6', // Onboarding / contacto
	) );
}

/**
 * URL absoluta a una sección de la portada.
 *
 * @param string $key Clave de jt_home_anchors().
 * @return string
 */
function jt_anchor_url( $key ) {
	$anchors = jt_home_anchors();
	return home_url( '/#' . ( isset( $anchors[ $key ] ) ? $anchors[ $key ] : 'top' ) );
}

/**
 * Menú principal del sitio.
 *
 * Es el MISMO menú que la portada estática (front-page.html). Si tocas uno,
 * toca el otro: la portada no puede leer esta función porque se sirve fuera
 * de WordPress.
 *
 * @return array<int,array{label:string,url:string,active:bool}>
 */
function jt_nav_items() {
	$en_blog = is_home() || is_archive() || is_single() || is_search();

	$blog = function_exists( 'pll_home_url' ) && jt_is_pt()
		? trailingslashit( pll_home_url( 'pt' ) ) . 'blog/'
		: home_url( '/blog/' );

	return apply_filters( 'jt_nav_items', array(
		array( 'label' => jt_t( 'nav_metodo' ),    'url' => jt_anchor_url( 'metodo' ),    'active' => false ),
		array( 'label' => jt_t( 'nav_jhontra' ),   'url' => jt_anchor_url( 'jhontra' ),   'active' => false ),
		array( 'label' => jt_t( 'nav_clubes' ),    'url' => jt_anchor_url( 'clubes' ),    'active' => false ),
		array( 'label' => jt_t( 'nav_contenido' ), 'url' => jt_anchor_url( 'contenido' ), 'active' => false ),
		array( 'label' => jt_t( 'nav_blog' ),      'url' => $blog,                        'active' => $en_blog ),
		array( 'label' => jt_t( 'nav_empezar' ),   'url' => jt_anchor_url( 'empezar' ),   'active' => false ),
	) );
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
