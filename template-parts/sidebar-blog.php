<?php
/**
 * Sidebar del blog (archivo y categorías).
 * Suprema · Categorías · Recientes · PPPoker · Espacio publicitario.
 *
 * @package jhontra-theme
 */

if ( ! defined( 'ABSPATH' ) ) exit;
?>
<aside class="jt-sidebar">

	<!-- Suprema CTA -->
	<div class="jt-aff" data-reveal>
		<div class="jt-aff__glow"></div>
		<span class="jt-sidebar__label">Sala afiliada</span>
		<div class="jt-aff__name">Suprema Poker</div>
		<p>El club con más tráfico de PLO5 en LATAM. Únete con el código de Jhontra y accede a las mejores condiciones.</p>
		<div class="jt-aff__perk"><span>★</span>Mejor bono de bienvenida</div>
		<a href="<?php echo esc_url( jt_whatsapp_url() ); ?>" class="jt-btn-gold jt-btn-sweep jt-btn-sm jt-btn-full" target="_blank" rel="noopener">Ver mi bono</a>
	</div>

	<!-- Categorías -->
	<?php $jt_all_cats = get_categories( array( 'orderby' => 'count', 'order' => 'DESC', 'hide_empty' => true ) ); ?>
	<?php if ( ! empty( $jt_all_cats ) ) : ?>
	<div class="jt-sidebar-widget" data-reveal>
		<div class="jt-sidebar__heading">Categorías</div>
		<?php foreach ( $jt_all_cats as $jt_cat ) : ?>
			<a href="<?php echo esc_url( get_category_link( $jt_cat->term_id ) ); ?>" class="jt-sidebar-widget__item">
				<span><?php echo esc_html( $jt_cat->name ); ?></span>
				<span class="jt-sidebar-widget__count"><?php echo (int) $jt_cat->count; ?></span>
			</a>
		<?php endforeach; ?>
	</div>
	<?php endif; ?>

	<!-- Recientes -->
	<?php $jt_recent = new WP_Query( array( 'posts_per_page' => 3, 'orderby' => 'date', 'order' => 'DESC', 'ignore_sticky_posts' => true ) ); ?>
	<?php if ( $jt_recent->have_posts() ) : ?>
	<div class="jt-sidebar-widget" data-reveal>
		<div class="jt-sidebar__heading">Lo más reciente</div>
		<div class="jt-recent">
			<?php while ( $jt_recent->have_posts() ) : $jt_recent->the_post(); ?>
				<a href="<?php the_permalink(); ?>" class="jt-recent__item">
					<div class="jt-recent__thumb">
						<?php if ( has_post_thumbnail() ) the_post_thumbnail( 'jt-thumb' ); ?>
					</div>
					<div>
						<div class="jt-recent__date"><?php echo strtoupper( get_the_date( 'd M Y' ) ); ?></div>
						<div class="jt-recent__title"><?php the_title(); ?></div>
					</div>
				</a>
			<?php endwhile; wp_reset_postdata(); ?>
		</div>
	</div>
	<?php endif; ?>

	<!-- PPPoker CTA -->
	<div class="jt-aff jt-aff--secondary" data-reveal>
		<span class="jt-sidebar__label">Sala afiliada</span>
		<div class="jt-aff__name">PPPoker</div>
		<p>Mesas activas 24/7 y bono de bienvenida para nuevos jugadores del club.</p>
		<a href="<?php echo esc_url( jt_whatsapp_url() ); ?>" class="jt-btn-outline jt-btn-full" target="_blank" rel="noopener">Ver promoción</a>
	</div>

	<!-- Espacio publicitario -->
	<div class="jt-ad-slot">
		<div class="jt-ad-slot__label">ESPACIO PUBLICITARIO · 300×250</div>
		<div class="jt-ad-slot__desc">Banner de sala afiliada (widget WordPress)</div>
	</div>

</aside>
