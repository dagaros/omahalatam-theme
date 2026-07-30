<?php
/**
 * Página estática.
 *
 * Base para las páginas del sitio: Acerca de Jhontra, ¿Por qué Suprema?,
 * ¿Por qué PPPoker? y Contacto. Reutiliza el sistema visual del post
 * (jt-post-header + jt-prose) para no introducir CSS nuevo.
 *
 * @package jhontra-theme
 */

if ( ! defined( 'ABSPATH' ) ) exit;

get_header();

while ( have_posts() ) : the_post(); ?>

<article>

	<header class="jt-post-header">
		<div class="jt-post-header__glow"></div>
		<div class="jt-post-header__inner">
			<?php jt_breadcrumbs(); ?>
			<h1><?php the_title(); ?></h1>
			<?php if ( has_excerpt() ) : ?>
				<p style="margin:18px 0 0;font-size:18px;line-height:1.6;color:#9AA0AA;max-width:640px;"><?php echo esc_html( get_the_excerpt() ); ?></p>
			<?php endif; ?>
		</div>
	</header>

	<?php if ( has_post_thumbnail() ) : ?>
		<div class="jt-post-featured">
			<div class="jt-post-featured__wrap">
				<?php the_post_thumbnail( 'jt-featured' ); ?>
			</div>
		</div>
	<?php endif; ?>

	<div class="jt-post-layout">
		<div style="max-width:820px;margin:0 auto;min-width:0;">
			<div class="jt-prose">
				<?php the_content(); ?>
			</div>
		</div>
	</div>

</article>

<?php
endwhile;

get_footer();
