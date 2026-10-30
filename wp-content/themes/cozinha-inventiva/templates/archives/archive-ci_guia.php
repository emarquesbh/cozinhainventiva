<?php
/**
 * Template de arquivo para guias
 *
 * @package Cozinha_Inventiva
 * @since 1.0.0
 * 
 * Arquivo: /Templates/archives/archive-ci_guia.php
 * Localização: Templates/archives/archive-ci_guia.php
 * Linhas: 106
 * 
 * FUNÇÃO: Template de arquivo para todos os guias. Exibe título "Guias Completos",
 * descrição, grid de guias usando template-part para cards, paginação e fallback para
 * "nenhum guia encontrado". Inclui CSS inline para estilização do header com gradiente
 * diferenciado.
 */

// ARQUIVO 15/42 - ARCHIVE-CI_GUIA.PHP
// Localização: /Templates/archives/archive-ci_guia.php
// Linhas: 106

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>

<div class="container">
    <?php if (have_posts()) : ?>

        <header class="archive-header">
            <h1 class="archive-title"><?php esc_html_e('Guias Completos', 'cozinha-inventiva'); ?></h1>
            <p class="archive-description">
                <?php esc_html_e('Guias detalhados para aproveitar cada parte dos alimentos sem desperdício', 'cozinha-inventiva'); ?>
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
            <h1><?php esc_html_e('Nenhum guia encontrado', 'cozinha-inventiva'); ?></h1>
            <p><?php esc_html_e('Desculpe, mas ainda não temos guias cadastrados.', 'cozinha-inventiva'); ?></p>
        </div>

    <?php endif; ?>
</div>

<style>
.archive-header {
    text-align: center;
    margin-bottom: 3rem;
    padding: 3rem 1rem;
    background: linear-gradient(135deg, #ebf8ff 0%, #bee3f8 100%);
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
