<?php
/**
 * Portada — omahalatam.com
 *
 * IMPORTANTE
 * ----------
 * La portada es un export estático (front-page.html) y se sirve TAL CUAL,
 * sin pasar por get_header() / wp_head() / get_footer(). Trae su propio
 * CSS y su propio JS embebidos.
 *
 * Motivo: el diseño está aprobado pixel a pixel y cualquier inyección de
 * WordPress (emojis, estilos de plugins, barra de admin) lo alteraría.
 *
 * Para editar la portada se edita front-page.html directamente. Si algún día
 * se migra a Elementor o a plantilla PHP, se borra el readfile() y se construye
 * aquí con get_header() / get_footer().
 *
 * @package jhontra-theme
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Portada por idioma. La version brasilena vive en front-page-pt.html, con el
 * mismo marcado y el texto adaptado a pt-BR. Si el archivo no existe, cae a la
 * version en espanol en vez de dejar la portada en blanco.
 */
$jt_static_home = get_template_directory() . '/front-page.html';

if ( function_exists( 'jt_is_pt' ) && jt_is_pt() ) {
	$jt_home_pt = get_template_directory() . '/front-page-pt.html';
	if ( file_exists( $jt_home_pt ) ) {
		$jt_static_home = $jt_home_pt;
	}
}

if ( file_exists( $jt_static_home ) ) {

	$jt_html = file_get_contents( $jt_static_home );

	/**
	 * Sección "Contenido": las 3 tarjetas salen de las últimas entradas.
	 *
	 * El HTML entre <!-- jt:ultimas-entradas --> y su cierre se sustituye por
	 * tarjetas generadas desde la base de datos, con el mismo marcado del
	 * diseño. Si faltan los marcadores o no hay entradas publicadas, el
	 * archivo se sirve tal cual y quedan las tarjetas estáticas.
	 */
	$jt_ini = '<!-- jt:ultimas-entradas -->';
	$jt_fin = '<!-- /jt:ultimas-entradas -->';
	$jt_a   = strpos( $jt_html, $jt_ini );
	$jt_b   = strpos( $jt_html, $jt_fin );

	if ( false !== $jt_a && false !== $jt_b && $jt_b > $jt_a ) {
		$jt_cards = jt_front_page_cards( 3 );
		if ( $jt_cards ) {
			$jt_a += strlen( $jt_ini );
			$jt_html = substr( $jt_html, 0, $jt_a ) . $jt_cards . substr( $jt_html, $jt_b );
		}
	}

	/**
	 * Medición: la portada no pasa por wp_head() ni por wp_body_open(), así que
	 * el contenedor de Google Tag Manager se inyecta aquí a mano. Sin esto la
	 * página más visitada del sitio quedaría fuera de GA4.
	 */
	if ( function_exists( 'jt_gtm_head' ) && false === strpos( $jt_html, JT_GTM_ID ) ) {
		$jt_html = preg_replace( '/<head>/i', '<head>' . "\n" . jt_gtm_head(), $jt_html, 1 );
		$jt_html = preg_replace( '/<body([^>]*)>/i', '<body$1>' . "\n" . jt_gtm_noscript(), $jt_html, 1 );
	}

	/**
	 * Multiidioma: la portada tampoco pasa por language_attributes() ni por
	 * el hreflang que Polylang imprime en wp_head(), asi que se inyecta aqui.
	 */
	if ( function_exists( 'jt_lang' ) ) {

		$jt_locale = str_replace( '_', '-', get_locale() );
		$jt_html   = preg_replace( '/<html([^>]*)\\slang="[^"]*"/i', '<html$1 lang="' . $jt_locale . '"', $jt_html, 1 );

		$jt_alt = '';
		foreach ( jt_languages() as $jt_l ) {
			$jt_alt .= '<link rel="alternate" hreflang="' . esc_attr( $jt_l['slug'] ) . '" href="' . esc_url( $jt_l['url'] ) . '">' . "\n";
			if ( 'es' === $jt_l['slug'] ) {
				$jt_alt .= '<link rel="alternate" hreflang="x-default" href="' . esc_url( $jt_l['url'] ) . '">' . "\n";
			}
		}

		if ( $jt_alt && false === strpos( $jt_html, 'hreflang=' ) ) {
			$jt_html = preg_replace( '/<\\/head>/i', $jt_alt . '</head>', $jt_html, 1 );
		}

		if ( jt_is_pt() ) {
			$jt_html = preg_replace(
				'/<link rel="canonical" href="[^"]*">/i',
				'<link rel="canonical" href="' . esc_url( home_url( '/' ) ) . '">',
				$jt_html, 1
			);
		}

		ob_start();
		jt_language_switcher( 'jt-lang--nav' );
		$jt_sw = trim( ob_get_clean() );

		if ( $jt_sw && false !== strpos( $jt_html, '<!-- jt:lang -->' ) ) {
			$jt_html = str_replace( '<!-- jt:lang -->', $jt_sw, $jt_html );
		}
	}

	echo $jt_html; // phpcs:ignore WordPress.Security.EscapeOutput — export estático propio del tema.
	exit;
}

/* Fallback: si el export estático no existe, no dejamos la portada en blanco. */
get_header();
?>
<section class="jt-archive-hero">
	<div class="jt-archive-hero__glow"></div>
	<div class="jt-archive-hero__inner" style="text-align:center;padding:80px 0;">
		<div class="jt-pill">Jhontra · PLO5</div>
		<h1>Omaha 5 Cartas, <span class="jt-gold">con matemática</span></h1>
		<p style="margin:0 auto;">La portada estática no está disponible en este momento. Mientras tanto, entra al blog o escríbenos.</p>
		<div style="display:flex;gap:12px;justify-content:center;flex-wrap:wrap;margin-top:28px;">
			<a href="<?php echo esc_url( jt_whatsapp_url() ); ?>" class="jt-btn-gold jt-btn-sweep" target="_blank" rel="noopener"><span>✆</span> Hablar con Jhontra</a>
			<a href="<?php echo esc_url( home_url( '/blog/' ) ); ?>" class="jt-btn-ghost">Ir al blog</a>
		</div>
	</div>
</section>
<?php
get_footer();
