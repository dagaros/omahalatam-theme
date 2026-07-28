<?php
if ( ! defined( 'ABSPATH' ) ) exit;
if ( is_front_page() ) {
    $html = get_template_directory() . '/front-page.html';
    if ( file_exists( $html ) ) { readfile( $html ); exit; }
    get_header();
    echo '<div style="max-width:820px;margin:0 auto;padding:120px 24px 80px;text-align:center;">';
    echo '<div style="font-family:Bricolage Grotesque,sans-serif;font-size:48px;font-weight:800;color:#D4AF54;margin-bottom:16px;">Jhontra</div>';
    echo '<p style="color:#9AA0AA;font-size:17px;">Sitio en construcción. Visita el <a href="' . esc_url( home_url('/blog/') ) . '">blog</a>.</p>';
    echo '</div>';
    get_footer();
} else {
    get_header();
    if ( have_posts() ) { while ( have_posts() ) { the_post();
        echo '<div style="max-width:760px;margin:0 auto;padding:100px 24px 60px;" class="jt-prose">';
        the_content();
        echo '</div>';
    } }
    get_footer();
}
