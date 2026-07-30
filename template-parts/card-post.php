<?php
/**
 * Tarjeta de post para grids.
 *
 * Uso:
 *   get_template_part( 'template-parts/card', 'post' );                        // completa
 *   get_template_part( 'template-parts/card', 'post', array( 'variant' => 'compact' ) ); // relacionados
 *
 * Variantes:
 *   full     — imagen, badge, meta, título, extracto y CTA. (por defecto)
 *   compact  — imagen, badge, meta y título. Sin extracto ni CTA.
 *
 * El marcado es idéntico al del diseño aprobado. No añadir clases nuevas
 * sin actualizar assets/css/blog.css.
 *
 * @package jhontra-theme
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$jt_variant = isset( $args['variant'] ) ? $args['variant'] : 'full';
$jt_compact = ( 'compact' === $jt_variant );
$jt_cat     = jt_primary_cat();
?>
<article<?php echo $jt_compact ? '' : ' class="jt-card" data-reveal'; ?>>
	<a href="<?php the_permalink(); ?>" class="jt-card__link">
		<div class="jt-card__img">
			<?php if ( has_post_thumbnail() ) : ?>
				<?php the_post_thumbnail( 'jt-card' ); ?>
			<?php elseif ( ! $jt_compact ) : ?>
				<div class="jt-card__placeholder">♠</div>
			<?php endif; ?>
			<span class="jt-card__badge"><?php echo esc_html( $jt_cat ); ?></span>
		</div>
		<div class="jt-card__body">
			<div class="jt-card__meta">
				<span><?php echo strtoupper( get_the_date( 'd M Y' ) ); ?></span>
				<span class="jt-dot"></span>
				<span><?php echo jt_reading_time(); ?></span>
			</div>
			<h3<?php echo $jt_compact ? ' style="font-size:18px;"' : ''; ?>><?php the_title(); ?></h3>
			<?php if ( ! $jt_compact ) : ?>
				<p><?php echo get_the_excerpt(); ?></p>
				<span class="jt-card__cta">Leer más <span>→</span></span>
			<?php endif; ?>
		</div>
	</a>
</article>
