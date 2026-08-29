<?php
/**
 * Jhontra PLO5 — Calculadoras de equity
 *
 * Un motor, ocho paginas: cuatro variantes por dos idiomas. Cada una vive en su
 * propia URL con su H1, su contenido y su FAQ, porque Google indexa URLs y no
 * estados de JavaScript.
 *
 *   /calculadoras/poker-texas-holdem/      /pt/calculadoras/poker-texas-holdem/
 *   /calculadoras/omaha-plo4/              /pt/calculadoras/omaha-plo4/
 *   /calculadoras/omaha-plo5/              /pt/calculadoras/omaha-plo5/
 *   /calculadoras/omaha-plo6/              /pt/calculadoras/omaha-plo6/
 *
 * @package jhontra-theme
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Configuracion de cada variante, por idioma.
 */
function jt_calc_config() {

	$es = array(
		'holdem' => array(
			'v' => 2, 'slug' => 'poker-texas-holdem', 'tab' => "HOLD'EM", 'nombre' => "Texas Hold'em",
			'h1a' => 'Calculadora de equity de ', 'h1b' => "Texas Hold'em",
			'lede' => 'Calcula la probabilidad exacta de ganar una mano de Hold\'em contra uno o varios rivales. Enumeración completa en flop, turn y river. Gratis, sin registro y en tu navegador.',
			'title' => "Calculadora de Poker Texas Hold'em | Equity y Probabilidades",
			'desc' => "Calculadora de poker gratis para Texas Hold'em. Equity exacta en flop, turn y river, hasta 6 jugadores. Sin registro y funciona en el celular.",
		),
		'plo4' => array(
			'v' => 4, 'slug' => 'omaha-plo4', 'tab' => 'PLO4', 'nombre' => 'Omaha PLO4',
			'h1a' => 'Calculadora de equity de ', 'h1b' => 'Omaha PLO4',
			'lede' => 'Cuatro cartas en mano, dos obligatorias en la jugada. Calcula la equity real de tu mano de Omaha contra tus rivales, con enumeración exacta desde el flop.',
			'title' => 'Calculadora de Omaha PLO4 | Equity y Probabilidades',
			'desc' => 'Calculadora de equity de Omaha PLO4 gratis y en español. Resultado exacto en flop, turn y river. Sin registro y optimizada para celular.',
		),
		'plo5' => array(
			'v' => 5, 'slug' => 'omaha-plo5', 'tab' => 'PLO5', 'nombre' => 'Omaha PLO5',
			'h1a' => 'Calculadora de equity de ', 'h1b' => 'Omaha 5 Cartas',
			'lede' => 'La única calculadora de PLO5 en español. Cinco cartas en mano, dos obligatorias en la jugada, cien combinaciones por rival y por mesa. Resultado exacto desde el flop.',
			'title' => 'Calculadora de Omaha 5 Cartas (PLO5) | Equity Gratis',
			'desc' => 'Calculadora de equity de Omaha 5 cartas (PLO5) gratis y en español. Cálculo exacto en flop, turn y river, análisis de bloqueadores y sin registro.',
		),
		'plo6' => array(
			'v' => 6, 'slug' => 'omaha-plo6', 'tab' => 'PLO6', 'nombre' => 'Omaha PLO6',
			'h1a' => 'Calculadora de equity de ', 'h1b' => 'Omaha PLO6',
			'lede' => 'Seis cartas en mano y quince combinaciones posibles por mesa. La variante donde la intuición falla más y la calculadora se vuelve imprescindible.',
			'title' => 'Calculadora de Omaha 6 Cartas (PLO6) | Equity Gratis',
			'desc' => 'Calculadora de equity de Omaha PLO6 gratis y en español. Cálculo exacto en flop, turn y river. Sin registro, lista para el celular.',
		),
	);

	$pt = array(
		'holdem' => array(
			'v' => 2, 'slug' => 'poker-texas-holdem', 'tab' => "HOLD'EM", 'nombre' => "Texas Hold'em",
			'h1a' => 'Calculadora de equity de ', 'h1b' => "Texas Hold'em",
			'lede' => 'Calcule a probabilidade exata de ganhar uma mão de Hold\'em contra um ou vários adversários. Enumeração completa no flop, turn e river. Grátis, sem cadastro e direto no navegador.',
			'title' => "Calculadora de Poker Texas Hold'em | Equity e Probabilidades",
			'desc' => "Calculadora de poker grátis para Texas Hold'em. Equity exata no flop, turn e river, até 6 jogadores. Sem cadastro e funciona no celular.",
		),
		'plo4' => array(
			'v' => 4, 'slug' => 'omaha-plo4', 'tab' => 'PLO4', 'nombre' => 'Omaha PLO4',
			'h1a' => 'Calculadora de equity de ', 'h1b' => 'Omaha PLO4',
			'lede' => 'Quatro cartas na mão, duas obrigatórias na jogada. Calcule a equity real da sua mão de Omaha contra os adversários, com enumeração exata a partir do flop.',
			'title' => 'Calculadora de Omaha PLO4 | Equity e Probabilidades',
			'desc' => 'Calculadora de equity de Omaha PLO4 grátis e em português. Resultado exato no flop, turn e river. Sem cadastro e otimizada para celular.',
		),
		'plo5' => array(
			'v' => 5, 'slug' => 'omaha-plo5', 'tab' => 'PLO5', 'nombre' => 'Omaha PLO5',
			'h1a' => 'Calculadora de equity de ', 'h1b' => 'Omaha 5 Cartas',
			'lede' => 'A única calculadora de PLO5 em português. Cinco cartas na mão, duas obrigatórias na jogada, cem combinações por adversário e por mesa. Resultado exato a partir do flop.',
			'title' => 'Calculadora de Omaha 5 Cartas (PLO5) | Equity Grátis',
			'desc' => 'Calculadora de equity de Omaha 5 cartas (PLO5) grátis e em português. Cálculo exato no flop, turn e river, análise de bloqueadores e sem cadastro.',
		),
		'plo6' => array(
			'v' => 6, 'slug' => 'omaha-plo6', 'tab' => 'PLO6', 'nombre' => 'Omaha PLO6',
			'h1a' => 'Calculadora de equity de ', 'h1b' => 'Omaha PLO6',
			'lede' => 'Seis cartas na mão e quinze combinações possíveis por mesa. A variante onde a intuição erra mais e a calculadora se torna indispensável.',
			'title' => 'Calculadora de Omaha 6 Cartas (PLO6) | Equity Grátis',
			'desc' => 'Calculadora de equity de Omaha PLO6 grátis e em português. Cálculo exato no flop, turn e river. Sem cadastro, pronta para o celular.',
		),
	);

	return jt_is_pt() ? $pt : $es;
}

/** Cadenas de la interfaz de la calculadora. */
function jt_calc_i18n() {
	$es = array(
		'mesa'=>'MESA','carta'=>'carta','completo'=>'completo','gana'=>'Gana','empata'=>'Empata',
		'metodo'=>'Método','exacto'=>'enumeración exacta','precision'=>'Precisión',
		'sinmargen'=>'exacta, sin margen de error','puntos'=>'puntos (95%)','tiempo'=>'Tiempo',
		'bloqueadores'=>'Bloqueadores',
		'blk_texto'=>'Bloqueas %1 de %2 combinaciones que hacen la mejor mano posible en esta mesa.',
		'blk_aprox'=>'En flop y turn se calcula contra las cartas visibles.',
		'faltan'=>'Faltan cartas: se necesitan dos manos completas',
		'mesa345'=>'La mesa va vacía, con 3, 4 o 5 cartas',
		'repetida'=>'Esa carta ya está en juego','sinsitio'=>'No queda espacio libre',
		'cambio'=>'La mano cambió. Vuelve a calcular.','copiado'=>'Enlace copiado',
		'retirar'=>'Retirar posición','activar'=>'Activar posición',
	);
	$pt = array(
		'mesa'=>'MESA','carta'=>'carta','completo'=>'completo','gana'=>'Ganha','empata'=>'Empata',
		'metodo'=>'Método','exacto'=>'enumeração exata','precision'=>'Precisão',
		'sinmargen'=>'exata, sem margem de erro','puntos'=>'pontos (95%)','tiempo'=>'Tempo',
		'bloqueadores'=>'Bloqueadores',
		'blk_texto'=>'Você bloqueia %1 de %2 combinações que fazem a melhor mão possível nesta mesa.',
		'blk_aprox'=>'No flop e no turn o cálculo usa as cartas visíveis.',
		'faltan'=>'Faltam cartas: são necessárias duas mãos completas',
		'mesa345'=>'A mesa vai vazia, com 3, 4 ou 5 cartas',
		'repetida'=>'Essa carta já está em jogo','sinsitio'=>'Não há espaço livre',
		'cambio'=>'A mão mudou. Calcule de novo.','copiado'=>'Link copiado',
		'retirar'=>'Retirar posição','activar'=>'Ativar posição',
	);
	return jt_is_pt() ? $pt : $es;
}

/** Base de URL de las calculadoras en el idioma actual. */
function jt_calc_base() {
	return trailingslashit( jt_home_url( '/' ) ) . 'calculadoras/';
}

/** Devuelve la clave de variante de la pagina actual, o '' si no es una calculadora. */
function jt_calc_current() {
	if ( ! is_page() ) return '';
	$slug = get_post_field( 'post_name', get_queried_object_id() );
	foreach ( jt_calc_config() as $k => $c ) {
		if ( $c['slug'] === $slug ) return $k;
	}
	return '';
}

/**
 * Carga CSS y JS solo en las paginas de calculadora.
 *
 * El worker se pasa por URL en vez de inline porque un Worker necesita su
 * propio archivo y asi se cachea aparte del resto del tema.
 */
function jt_calc_assets() {

	$key = jt_calc_current();
	if ( ! $key ) return;

	$cfg = jt_calc_config();
	$C   = $cfg[ $key ];
	$uri = get_template_directory_uri();

	wp_enqueue_style( 'jt-calculadora', $uri . '/assets/css/calculadora.css', array( 'jt-layout' ), JT_ASSET_VER );
	wp_enqueue_script( 'jt-calculadora', $uri . '/assets/js/calculadora.js', array(), JT_ASSET_VER, true );

	wp_localize_script( 'jt-calculadora', 'JT_CALC', array(
		'variant'   => $C['v'],
		'nombre'    => $C['nombre'],
		'lang'      => jt_lang(),
		'workerUrl' => $uri . '/assets/js/equity-worker.js?ver=' . JT_ASSET_VER,
		'i18n'      => jt_calc_i18n(),
	) );
}
add_action( 'wp_enqueue_scripts', 'jt_calc_assets' );

/**
 * Title y meta description propios de cada calculadora.
 *
 * Rank Math gana por defecto, asi que estos filtros solo actuan si el campo
 * esta vacio en la pagina. Asi Daniel puede sobreescribirlos desde el editor.
 */
function jt_calc_title( $title ) {
	$key = jt_calc_current();
	if ( ! $key ) return $title;
	$cfg = jt_calc_config();
	return $cfg[ $key ]['title'] . ' | OmahaLatam';
}
add_filter( 'pre_get_document_title', 'jt_calc_title', 20 );

/**
 * Schema WebApplication + FAQPage de la calculadora.
 *
 * Se imprime en wp_head porque estas paginas si pasan por la plantilla PHP,
 * a diferencia de la portada.
 */
function jt_calc_schema() {

	$key = jt_calc_current();
	if ( ! $key ) return;

	$cfg = jt_calc_config();
	$C   = $cfg[ $key ];
	$pt  = jt_is_pt();
	$url = jt_calc_base() . $C['slug'] . '/';

	$faq = $pt ? array(
		array( 'A calculadora é grátis?', 'Sim, totalmente. Não há cadastro, não há cartão e não há limite de cálculos. Funciona no celular igual que no computador.' ),
		array( 'Qual é a precisão dos resultados?', 'Com mesa no flop, turn ou river o resultado é exato: todas as combinações possíveis são enumeradas. No preflop usa-se Monte Carlo, e o painel sempre indica o método e a margem.' ),
		array( 'Quantos jogadores posso colocar?', 'Até seis, cada um na sua posição real da mesa. Dá para ativar e retirar posições no botão de cada assento.' ),
		array( 'Posso digitar as cartas pelo teclado?', 'Sim. Digite o valor e o naipe seguidos, por exemplo As ou Td. As setas mudam de posição, o retrocesso apaga e Enter calcula.' ),
	) : array(
		array( '¿La calculadora es gratis?', 'Sí, completamente. No hay registro, no hay tarjeta y no hay límite de cálculos. Funciona en el celular igual que en el computador.' ),
		array( '¿Qué tan precisos son los resultados?', 'Con mesa en el flop, turn o river el resultado es exacto: se enumeran todas las combinaciones posibles. En preflop se usa Monte Carlo, y el panel indica siempre el método y el margen.' ),
		array( '¿Cuántos jugadores puedo poner?', 'Hasta seis, cada uno en su posición real de la mesa. Puedes activar y retirar posiciones con el botón de cada asiento.' ),
		array( '¿Puedo escribir las cartas con el teclado?', 'Sí. Escribe el rango y el palo seguidos, por ejemplo As o Td. Las flechas mueven entre posiciones, el retroceso borra y Enter calcula.' ),
	);

	$preguntas = array();
	foreach ( $faq as $f ) {
		$preguntas[] = array(
			'@type' => 'Question', 'name' => $f[0],
			'acceptedAnswer' => array( '@type' => 'Answer', 'text' => $f[1] ),
		);
	}

	$graph = array(
		array(
			'@type' => 'WebApplication',
			'@id' => $url . '#app',
			'name' => $C['title'],
			'url' => $url,
			'applicationCategory' => 'GameApplication',
			'operatingSystem' => 'Web',
			'inLanguage' => $pt ? 'pt-BR' : 'es',
			'description' => $C['desc'],
			'offers' => array( '@type' => 'Offer', 'price' => '0', 'priceCurrency' => 'USD' ),
			'publisher' => array( '@id' => 'https://omahalatam.com/#org' ),
		),
		array(
			'@type' => 'FAQPage', '@id' => $url . '#faq',
			'inLanguage' => $pt ? 'pt-BR' : 'es',
			'mainEntity' => $preguntas,
		),
	);

	echo '<script type="application/ld+json">'
		. wp_json_encode( array( '@context' => 'https://schema.org', '@graph' => $graph ),
			JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES )
		. '</script>' . "\n";
}
add_action( 'wp_head', 'jt_calc_schema', 6 );

/**
 * Canonical limpio.
 *
 * Compartir una mano genera URLs con parametros (?btn=AsKs&b=...). Sin esto,
 * Google indexaria miles de variantes casi identicas de la misma pagina.
 */
function jt_calc_canonical( $url ) {
	$key = jt_calc_current();
	if ( ! $key ) return $url;
	$cfg = jt_calc_config();
	return jt_calc_base() . $cfg[ $key ]['slug'] . '/';
}
add_filter( 'rank_math/frontend/canonical', 'jt_calc_canonical' );
add_filter( 'get_canonical_url', 'jt_calc_canonical' );
