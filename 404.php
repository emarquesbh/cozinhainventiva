<?php
/**
 * Arquivo: 404.php
 * Template 404 Estratégico - Foco em Upcycling e Recuperação de Tráfego
 * * Compilação de funcionalidades de busca avançada e sugestões curadas.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<main id="primary" class="site-main error-404 container">

	<section class="error-hero text-center">
		<h1 class="error-404-title">404</h1>
		<h2 class="error-404-subtitle"><?php esc_html_e('Ops! Esta casca não deu caldo.', 'cozinha-inventiva'); ?></h2>
		<p class="error-404-text">
			<?php esc_html_e('A página que você procura sumiu, mas nada se perde, tudo se transforma! Que tal aproveitar para descobrir uma nova receita de upcycling?', 'cozinha-inventiva'); ?>
		</p>
	</section>

	<section class="error-404-search text-center">
		<h3><?php esc_html_e('Busque por um ingrediente ou técnica:', 'cozinha-inventiva'); ?></h3>
		<form role="search" method="get" class="search-form-404" action="<?php echo esc_url( home_url( '/' ) ); ?>">
			<input type="search" name="s" placeholder="Ex: Cascas, Talos, Sementes..." value="<?php echo get_search_query(); ?>" required />
			
			<select name="dificuldade" class="select-dificuldade">
				<option value=""><?php esc_html_e('Dificuldade', 'cozinha-inventiva'); ?></option>
				<option value="facil"><?php esc_html_e('Fácil', 'cozinha-inventiva'); ?></option>
				<option value="media"><?php esc_html_e('Média', 'cozinha-inventiva'); ?></option>
				<option value="dificil"><?php esc_html_e('Difícil', 'cozinha-inventiva'); ?></option>
			</select>

			<button type="submit" class="btn btn-primary"><?php esc_html_e('Transformar', 'cozinha-inventiva'); ?></button>
		</form>
	</section>

	<section class="error-404-suggestions text-center">
		<div class="error-404-links">
			<a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn-outline"><?php esc_html_e('Página Inicial', 'cozinha-inventiva'); ?></a>
			<a href="<?php echo esc_url(home_url('/receitas')); ?>" class="btn btn-secondary"><?php esc_html_e('Todas as Receitas', 'cozinha-inventiva'); ?></a>
			<a href="<?php echo esc_url(home_url('/culinaria-circular')); ?>" class="btn btn-secondary"><?php esc_html_e('Guia de Reaproveitamento', 'cozinha-inventiva'); ?></a>
		</div>
	</section>

	<hr>

	<section class="error-content-curated">
		
		<div class="recipes-grid">
			<div class="error-card">
				<h3><i class="fas fa-leaf"></i> <?php esc_html_e('Saído do forno', 'cozinha-inventiva'); ?></h3>
				<?php
				$recent = new WP_Query([
					'post_type'      => 'wprm_recipe',
					'posts_per_page' => 1
				]);
				if ( $recent->have_posts() ) :
					while ( $recent->have_posts() ) : $recent->the_post();
						get_template_part( 'template-parts/content', 'recipe-card' );
					endwhile;
					wp_reset_postdata();
				endif;
				?>
			</div>

			<div class="error-card">
				<h3><i class="fas fa-chart-line"></i> <?php esc_html_e('Mais lixo evitado', 'cozinha-inventiva'); ?></h3>
				<?php
				$impact = new WP_Query([
					'post_type'      => 'wprm_recipe',
					'posts_per_page' => 1,
					'meta_key'       => 'ci_lixo_evitado',
					'orderby'        => 'meta_value_num',
					'order'          => 'DESC'
				]);
				if ( $impact->have_posts() ) :
					while ( $impact->have_posts() ) : $impact->the_post();
						get_template_part( 'template-parts/content', 'recipe-card' );
					endwhile;
					wp_reset_postdata();
				endif;
				?>
			</div>
		</div>

	</section>

</main>

<style>
/* Estilização consolidada e responsiva baseada no seu projeto */
.error-404-content { text-align: center; padding: 4rem 1rem; }
.error-404-title { font-size: 8rem; font-weight: 800; color: #48bb78; margin-bottom: 0; }
.error-404-subtitle { font-size: 2rem; margin-bottom: 1rem; color: #1a202c; }
.error-404-text { font-size: 1.125rem; color: #718096; max-width: 600px; margin: 0 auto 3rem; }

.search-form-404 { display: flex; gap: 0.5rem; justify-content: center; max-width: 800px; margin: 0 auto 2rem; }
.search-form-404 input, .search-form-404 select { padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 8px; }

.error-404-links { display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap; margin-bottom: 3rem; }
.recipes-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem; margin-top: 2rem; }

@media (max-width: 768px) {
    .error-404-title { font-size: 5rem; }
    .search-form-404 { flex-direction: column; padding: 0 1rem; }
}
</style>

<?php get_footer(); ?>