<?php
/**
 * Plantilla de respaldo de la jerarquía de WordPress.
 *
 * En la práctica casi nunca se usa: la portada la resuelve front-page.php,
 * el listado del blog home.php / archive.php, el post single.php, las páginas
 * page.php, la búsqueda search.php y los errores 404.php.
 *
 * @package jhontra-theme
 */

if ( ! defined( 'ABSPATH' ) ) exit;

get_header();
?>

<div class="jt-post-layout">
	<div style="max-width:760px;margin:0 auto;padding:60px 24px;">
		<?php jt_breadcrumbs(); ?>

		<?php if ( have_posts() ) : ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<article class="jt-prose">
					<h1><?php the_title(); ?></h1>
					<?php the_content(); ?>
				</article>
			<?php endwhile; ?>
		<?php else : ?>
			<div style="text-align:center;padding:80px 0;color:#7A808A;">
				<p style="font-size:48px;margin-bottom:16px;">♠</p>
				<h2 style="font-family:'Bricolage Grotesque',sans-serif;color:#fff;margin-bottom:12px;">Nada por aquí</h2>
				<p>No encontramos contenido en esta dirección.</p>
			</div>
		<?php endif; ?>
	</div>
</div>

<?php
get_footer();
