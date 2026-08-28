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
 * Home del idioma actual.
 *
 * home_url() siempre devuelve la raiz en espanol, asi que cualquier ancla o
 * enlace construido con ella saca al visitante brasileno de /pt/.
 */
function jt_home_url( $path = '/' ) {

	if ( function_exists( 'pll_home_url' ) ) {
		$base = pll_home_url( jt_lang() );
		if ( $base ) {
			return trailingslashit( $base ) . ltrim( $path, '/' );
		}
	}

	return home_url( $path );
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

		// Banda de CTA
		'cta_pill'      => array( 'es' => 'Promociones exclusivas', 'pt' => 'Promoções exclusivas' ),
		'cta_h2_a'      => array( 'es' => '¿Quieres los ',          'pt' => 'Quer os ' ),
		'cta_h2_gold'   => array( 'es' => 'mejores bonos',          'pt' => 'melhores bônus' ),
		'cta_h2_b'      => array( 'es' => ' en las salas donde ya juegas?', 'pt' => ' nas salas onde você já joga?' ),
		'cta_texto'     => array(
			'es' => 'Escríbele a Jhontra y accede a las condiciones y bonos de bienvenida más competitivos de LATAM en Suprema, PPPoker y más clubes asociados. Sin costo, sin letra pequeña.',
			'pt' => 'Fale com o Jhontra e tenha acesso às condições e aos bônus de boas-vindas mais competitivos da América Latina na Suprema, no PPPoker e nos demais clubes parceiros. Sem custo e sem letra miúda.' ),
		'cta_wa'        => array( 'es' => 'Hablar con Jhontra',   'pt' => 'Falar com o Jhontra' ),
		'cta_clubes'    => array( 'es' => 'Ver clubes asociados', 'pt' => 'Ver clubes parceiros' ),

		// Footer
		'f_desc'        => array(
			'es' => 'Autoridad de Omaha 5 Cartas en Latinoamérica. Contenido gratuito, rakeback competitivo y comunidad.',
			'pt' => 'Autoridade em Omaha 5 Cartas na América Latina. Conteúdo gratuito, rakeback competitivo e comunidade.' ),
		'f_enlaces'     => array( 'es' => 'Enlaces rápidos',             'pt' => 'Links rápidos' ),
		'f_acerca'      => array( 'es' => 'Acerca de Jhontra',           'pt' => 'Sobre o Jhontra' ),
		'f_blog'        => array( 'es' => 'Blog · Análisis y Contenido', 'pt' => 'Blog · Análises e conteúdo' ),
		'f_contacto'    => array( 'es' => 'Contacto',                    'pt' => 'Contato' ),
		'f_redes'       => array( 'es' => 'Redes sociales',              'pt' => 'Redes sociais' ),
		'f_legal'       => array( 'es' => 'Legal',                       'pt' => 'Jurídico' ),
		'f_terminos'    => array( 'es' => 'Términos y Condiciones',      'pt' => 'Termos e Condições' ),
		'f_privacidad'  => array( 'es' => 'Política de Privacidad',      'pt' => 'Política de Privacidade' ),
		'f_cookies'     => array( 'es' => 'Política de Cookies',         'pt' => 'Política de Cookies' ),
		'f_edad'        => array(
			'es' => 'El poker es un juego para mayores de 18 años. Juega con responsabilidad. Recursos de ayuda:',
			'pt' => 'Poker é um jogo para maiores de 18 anos. Jogue com responsabilidade. Canais de ajuda:' ),
		'f_afiliado'    => array(
			'es' => 'Este sitio contiene enlaces de afiliado. Jhontra recibe una comisión por los jugadores que se registran a través de sus códigos de referido. Esto no tiene costo adicional para ti.',
			'pt' => 'Este site contém links de afiliado. O Jhontra recebe uma comissão pelos jogadores que se cadastram pelos códigos de indicação. Isso não tem custo adicional nenhum para você.' ),
		'f_copy'        => array( 'es' => 'Todos los derechos reservados.', 'pt' => 'Todos os direitos reservados.' ),

		// Botones sueltos
		'ir_portada'    => array( 'es' => 'Ir a la portada', 'pt' => 'Ir para a página inicial' ),
		'ver_blog'      => array( 'es' => 'Ver el blog',     'pt' => 'Ver o blog' ),
		'ver_todo'      => array( 'es' => 'Ver todo',        'pt' => 'Ver tudo' ),
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

/**
 * Idiomas que SI tienen traduccion del contenido actual.
 *
 * A diferencia de jt_languages(), aqui se ocultan los idiomas sin traduccion,
 * porque un hreflang que apunta a la portada en vez de a la traduccion real
 * es una senal falsa para Google.
 */
function jt_languages_translated() {

	if ( ! function_exists( 'pll_the_languages' ) ) {
		return array();
	}

	$raw = pll_the_languages( array(
		'raw'                    => 1,
		'hide_if_no_translation' => 1,
		'display_names_as'       => 'slug',
	) );

	return is_array( $raw ) ? $raw : array();
}

/**
 * Emite hreflang reciproco + x-default en todas las plantillas PHP.
 *
 * Polylang free no lo esta imprimiendo en este sitio, asi que el tema se hace
 * cargo. La portada no pasa por aqui: lleva su propia inyeccion en
 * front-page.php, porque se sirve con readfile() y nunca llega a wp_head().
 */
function jt_hreflang_tags() {

	if ( is_404() || is_search() || is_paged() ) {
		return;
	}

	$langs = jt_languages_translated();
	if ( count( $langs ) < 2 ) {
		return;
	}

	$default = function_exists( 'pll_default_language' ) ? pll_default_language( 'slug' ) : 'es';

	foreach ( $langs as $l ) {
		$slug = isset( $l['slug'] ) ? $l['slug'] : '';
		$url  = isset( $l['url'] ) ? $l['url'] : '';
		if ( ! $slug || ! $url ) {
			continue;
		}

		printf( '<link rel="alternate" hreflang="%s" href="%s">' . "\n", esc_attr( $slug ), esc_url( $url ) );

		if ( $slug === $default ) {
			printf( '<link rel="alternate" hreflang="x-default" href="%s">' . "\n", esc_url( $url ) );
		}
	}
}
add_action( 'wp_head', 'jt_hreflang_tags', 4 );
