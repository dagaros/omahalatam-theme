<?php
/**
 * Error 404.
 * En vez de un callejón sin salida, devuelve al blog y ofrece WhatsApp.
 *
 * @package jhontra-theme
 */

if ( ! defined( 'ABSPATH' ) ) exit;

get_header();
?>

<section class="jt-archive-hero">
	<div class="jt-archive-hero__glow"></div>
	<div class="jt-archive-hero__inner">
		<?php jt_breadcrumbs(); ?>
		<div data-reveal style="max-width:680px;">
			<div class="jt-pill">Error 404</div>
			<h1>Esta mano <span class="jt-gold">no existe</span></h1>
			<p>La página que buscas se movió o nunca estuvo aquí. Prueba con el buscador o vuelve al blog.</p>
		</div>
		<?php get_search_form(); ?>
	</div>
</section>

<div class="jt-archive">
	<div style="max-width:1240px;margin:0 auto;padding:0 24px 40px;">

		<div style="display:flex;gap:12px;flex-wrap:wrap;margin-bottom:48px;">
			<a href="<?php echo esc_url( jt_home_url( '/' ) ); ?>" class="jt-btn-gold jt-btn-sweep"><?php echo esc_html( jt_t('ir_portada') ); ?></a>
			<a href="<?php echo esc_url( jt_home_url( '/blog/' ) ); ?>" class="jt-btn-ghost"><?php echo esc_html( jt_t('ver_blog') ); ?></a>
			<a href="<?php echo esc_url( jt_whatsapp_url( 'Hola Jhontra, no encontré lo que buscaba en la web.' ) ); ?>" class="jt-btn-ghost" target="_blank" rel="noopener"><span>✆</span> Escribir por WhatsApp</a>
		</div>

		<?php
		$jt_404_recent = new WP_Query( array( 'posts_per_page' => 3, 'ignore_sticky_posts' => true ) );
		if ( $jt_404_recent->have_posts() ) : ?>
			<div class="jt-sidebar__heading" style="margin-bottom:18px;">Lo más reciente del blog</div>
			<div class="jt-post-grid" data-post-grid>
				<?php while ( $jt_404_recent->have_posts() ) : $jt_404_recent->the_post();
					get_template_part( 'template-parts/card', 'post' );
				endwhile; wp_reset_postdata(); ?>
			</div>
		<?php endif; ?>

	</div>
</div>

<?php
get_footer();
