<?php
/**
 * Template de arquivo para técnicas
 *
 * @package Cozinha_Inventiva
 * @since 1.0.0
 * 
 * Arquivo: /Templates/archives/archive-ci_tecnica.php
 * Localização: Templates/archives/archive-ci_tecnica.php
 * Linhas: 107
 * 
 * FUNÇÃO: Template de arquivo para todas as técnicas. Exibe título "Técnicas de
 * Aproveitamento", descrição, grid de técnicas usando template-part para cards, paginação
 * e fallback para "nenhuma técnica encontrada". Inclui CSS inline para estilização do header.
 */
/**
 * Template: Archive - Técnicas de Aproveitamento
 * Localização: /archive-ci_tecnica.php
 * * FUNÇÃO: Listagem de todas as técnicas culinárias para evitar desperdício.
 * @package Cozinha_Inventiva
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>

<div class="container ci-archive-tecnica">
    <?php if (have_posts()) : ?>

        <header class="archive-header tecnica-header">
            <h1 class="archive-title">
                <?php esc_html_e('Técnicas de Aproveitamento', 'cozinha-inventiva'); ?>
            </h1>
            <p class="archive-description">
                <?php esc_html_e('Aprenda métodos fundamentais para transformar sobras e partes não convencionais em ingredientes versáteis.', 'cozinha-inventiva'); ?>
            </p>
        </header>

        <div class="archive-content">
            <div class="ci-posts-grid tecnicas-grid">
                <?php
                while (have_posts()) :
                    the_post();
                    /**
                     * Reutilizamos o card padrão. 
                     * O CSS cuidará de diferenciar a cor/estilo via classe do grid.
                     */
                    get_template_part('template-parts/content', 'card');
                endwhile;
                ?>
            </div>

            <div class="ci-pagination-wrapper">
                <?php
                if (function_exists('cozinha_inventiva_pagination')) {
                    cozinha_inventiva_pagination();
                } else {
                    the_posts_pagination();
                }
                ?>
            </div>
        </div>

    <?php else : ?>

        <section class="no-results not-found">
            <header class="page-header">
                <h1 class="page-title"><?php esc_html_e('Nenhuma técnica encontrada', 'cozinha-inventiva'); ?></h1>
            </header>
            <div class="page-content">
                <p><?php esc_html_e('Nossas técnicas de cozinha estão sendo preparadas. Volte em breve!', 'cozinha-inventiva'); ?></p>
                <?php get_search_form(); ?>
            </div>
        </section>

    <?php endif; ?>
</div>

<?php
get_footer();