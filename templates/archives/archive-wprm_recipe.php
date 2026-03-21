<?php
/**
 * Template de arquivo para receitas
 *
 * @package Cozinha_Inventiva
 * @since 1.0.0
 * 
 * Arquivo: /Templates/archives/archive-wprm_recipe.php
 * Localização: Templates/archives/archive-wprm_recipe.php
 * Linhas: 90
 * 
 * FUNÇÃO: Template de arquivo para todas as receitas (WP Recipe Maker). Exibe título
 * "Todas as Receitas", descrição opcional, grid de receitas usando template-part para
 * cards, paginação e fallback para "nenhuma receita encontrada". Inclui CSS inline para
 * o header do arquivo.
 */

// ARQUIVO 13/42 - ARCHIVE-WPRM_RECIPE.PHP
// Localização: /Templates/archives/archive-wprm_recipe.php
// Linhas: 90

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>

<div class="container">
    <?php if (have_posts()) : ?>

        <header class="archive-header">
            <h1 class="archive-title"><?php esc_html_e('Todas as Receitas', 'cozinha-inventiva'); ?></h1>
            <p class="archive-description">
                <?php esc_html_e('Explore nossa coleção completa de receitas de upcycling culinário', 'cozinha-inventiva'); ?>
            </p>
        </header>

        <div class="archive-content">
            <div class="recipes-grid">
                <?php
                while (have_posts()) :
                    the_post();
                    get_template_part('template-parts/content', 'recipe-card');
                endwhile;
                ?>
            </div>

            <?php cozinha_inventiva_pagination(); ?>
        </div>

    <?php else : ?>

        <div class="no-results">
            <h1><?php esc_html_e('Nenhuma receita encontrada', 'cozinha-inventiva'); ?></h1>
            <p><?php esc_html_e('Desculpe, mas ainda não temos receitas cadastradas.', 'cozinha-inventiva'); ?></p>
        </div>

    <?php endif; ?>
</div>

<style>
.archive-header {
    text-align: center;
    margin-bottom: 3rem;
    padding: 3rem 1rem;
    background: linear-gradient(135deg, #f0fff4 0%, #e6fffa 100%);
    border-radius: 12px;
}

.archive-title {
    font-size: 2.5rem;
    color: #1a202c;
    margin-bottom: 1rem;
}

.archive-description {
    font-size: 1.125rem;
    color: #4a5568;
    max-width: 700px;
    margin: 0 auto;
    line-height: 1.8;
}

.archive-content {
    margin: 2rem 0;
}

.no-results {
    text-align: center;
    padding: 4rem 1rem;
}

.no-results h1 {
    font-size: 2rem;
    color: #1a202c;
    margin-bottom: 1rem;
}

.no-results p {
    font-size: 1.125rem;
    color: #718096;
}
</style>

<?php
get_footer();
