<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * Jhontra PLO5 — functions.php
 * Soporte completo para blog. Fonts: Bricolage Grotesque, Hanken Grotesk, IBM Plex Mono.
 */

remove_action( 'wp_head', 'wp_generator' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'rsd_link' );

add_action( 'after_setup_theme', function () {
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );
    add_theme_support( 'custom-logo' );
    add_image_size( 'jt-featured', 1200, 675, true );
    add_image_size( 'jt-card', 640, 400, true );
    add_image_size( 'jt-thumb', 112, 112, true );
    register_nav_menus( array( 'primary' => 'Menú Principal' ) );
} );

add_action( 'wp_enqueue_scripts', function () {
    wp_enqueue_style( 'jt-fonts',
        'https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,400..800&family=Hanken+Grotesk:wght@400;500;600;700;800&family=IBM+Plex+Mono:wght@400;500&display=swap',
        array(), null
    );
    if ( ! is_front_page() ) {
        wp_enqueue_style( 'jt-blog', get_template_directory_uri() . '/blog-styles.css', array( 'jt-fonts' ), '2.0.0' );
    }
} );

// Excerpt
add_filter( 'excerpt_length', function () { return 30; } );
add_filter( 'excerpt_more', function () { return '…'; } );

// Reading time
function jt_reading_time( $id = null ) {
    $w = str_word_count( strip_tags( get_post_field( 'post_content', $id ?: get_the_ID() ) ) );
    return max( 1, ceil( $w / 200 ) ) . ' min';
}

// Breadcrumbs
function jt_breadcrumbs() {
    if ( is_front_page() ) return;
    echo '<nav aria-label="Ruta de navegación" class="jt-crumbs">';
    echo '<a href="' . esc_url( home_url('/') ) . '">Inicio</a>';
    echo '<span class="jt-crumbs__sep">›</span>';
    if ( is_single() ) {
        echo '<a href="' . esc_url( home_url('/blog/') ) . '">Blog</a>';
        $cats = get_the_category();
        if ( ! empty( $cats ) ) {
            echo '<span class="jt-crumbs__sep">›</span>';
            echo '<a href="' . esc_url( get_category_link( $cats[0]->term_id ) ) . '">' . esc_html( $cats[0]->name ) . '</a>';
        }
        echo '<span class="jt-crumbs__sep">›</span>';
        $t = get_the_title();
        echo '<span class="jt-crumbs__current">' . esc_html( mb_strlen($t) > 42 ? mb_substr($t,0,40) . '…' : $t ) . '</span>';
    } elseif ( is_category() ) {
        echo '<a href="' . esc_url( home_url('/blog/') ) . '">Blog</a>';
        echo '<span class="jt-crumbs__sep">›</span>';
        echo '<span class="jt-crumbs__current">' . single_cat_title('', false) . '</span>';
    } else {
        echo '<span class="jt-crumbs__current">Blog</span>';
    }
    echo '</nav>';
}

// JSON-LD Article
add_action( 'wp_head', function () {
    if ( ! is_single() ) return;
    $s = array(
        '@context' => 'https://schema.org', '@type' => 'Article',
        'headline' => get_the_title(),
        'datePublished' => get_the_date('c'),
        'dateModified' => get_the_modified_date('c'),
        'author' => array( '@type' => 'Person', 'name' => 'Jhontra', 'url' => home_url('/') ),
        'publisher' => array( '@type' => 'Organization', 'name' => 'Jhontra PLO5', 'url' => home_url('/') ),
        'mainEntityOfPage' => get_permalink(),
    );
    $img = get_the_post_thumbnail_url( get_the_ID(), 'jt-featured' );
    if ( $img ) $s['image'] = $img;
    echo '<script type="application/ld+json">' . wp_json_encode($s, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE) . "</script>\n";
} );

// Disable comments
add_filter( 'comments_open', '__return_false' );
add_filter( 'pings_open', '__return_false' );
add_filter( 'comments_array', '__return_empty_array' );

// Blog posts per page
add_action( 'pre_get_posts', function ( $q ) {
    if ( ! is_admin() && $q->is_main_query() && ( $q->is_home() || $q->is_archive() ) ) {
        $q->set( 'posts_per_page', 9 );
    }
} );

// Search form override
add_filter( 'get_search_form', function () {
    return '<form role="search" method="get" action="' . esc_url( home_url('/') ) . '" class="jt-search">
        <div class="jt-search__field"><span class="jt-search__icon">⌕</span>
        <input type="search" name="s" placeholder="Buscar artículos, manos, clubes…" aria-label="Buscar en el blog" value="' . esc_attr( get_search_query() ) . '" /></div>
        <button type="submit">Buscar</button></form>';
} );
