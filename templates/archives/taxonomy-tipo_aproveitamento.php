<?php
/**
 * Template de taxonomia para tipo de aproveitamento
 *
 * @package Cozinha_Inventiva
 * @since 1.0.0
 * 
 * Arquivo: /Templates/archives/taxonomy-tipo_aproveitamento.php
 * Localização: Templates/archives/taxonomy-tipo_aproveitamento.php
 * Linhas: 135
 * 
 * FUNÇÃO: Template de taxonomia para "Tipo de Aproveitamento". Exibe nome da categoria
 * (ex: Cascas e Talos, Sobras, Fermentação), descrição da taxonomia, imagem da categoria
 * (ACF), grid de receitas filtradas por esta taxonomia, paginação e fallback. Inclui CSS
 * inline para header com imagem de fundo.
 */

// ARQUIVO 16/42 - TAXONOMY-TIPO_APROVEITAMENTO.PHP
// Localização: /Templates/archives/taxonomy-tipo_aproveitamento.php
// Linhas: 135

if (!defined('ABSPATH')) {
    exit;
}

get_header();

$term = get_queried_object();
$term_image = get_field('imagem_categoria', $term);
?>

<div class="container">
    <?php if (have_posts()) : ?>

        <header class="taxonomy-header" <?php if ($term_image) : ?>style="background-image: url('<?php echo esc_url($term_image['url']); ?>');"<?php endif; ?>>
            <div class="taxonomy-header-overlay">
                <div class="taxonomy-header-content">
                    <h1 class="taxonomy-title"><?php single_term_title(); ?></h1>
                    
                    <?php if ($term->description) : ?>
                        <div class="taxonomy-description">
                            <?php echo wpautop($term->description); ?>
                        </div>
                    <?php endif; ?>
                    
                    <div class="taxonomy-count">
                        <?php
                        printf(
                            _n('%s receita', '%s receitas', $term->count, 'cozinha-inventiva'),
                            number_format_i18n($term->count)
                        );
                        ?>
                    </div>
                </div>
            </div>
        </header>

        <div class="taxonomy-content">
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
            <p>
                <?php
                printf(
                    esc_html__('Não encontramos receitas na categoria %s.', 'cozinha-inventiva'),
                    '<strong>' . single_term_title('', false) . '</strong>'
                );
                ?>
            </p>
        </div>

    <?php endif; ?>
</div>

<style>
.taxonomy-header {
    position: relative;
    min-height: 400px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 3rem;
    border-radius: 12px;
    overflow: hidden;
    background-size: cover;
    background-position: center;
    background-color: #f7fafc;
}

.taxonomy-header-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, rgba(72, 187, 120, 0.85) 0%, rgba(56, 161, 105, 0.75) 100%);
    display: flex;
    align-items: center;
    justify-content: center;
}

.taxonomy-header-content {
    position: relative;
    z-index: 2;
    text-align: center;
    color: #ffffff;
    padding: 2rem;
    max-width: 800px;
}

.taxonomy-title {
    font-size: 3rem;
    color: #ffffff;
    margin-bottom: 1.5rem;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
}

.taxonomy-description {
    font-size: 1.25rem;
    line-height: 1.8;
    margin-bottom: 1rem;
    color: #f7fafc;
}

.taxonomy-description p {
    margin-bottom: 0.5rem;
}

.taxonomy-count {
    font-size: 1rem;
    font-weight: 600;
    color: #ffffff;
    opacity: 0.9;
}

.taxonomy-content {
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

@media (max-width: 768px) {
    .taxonomy-header {
        min-height: 300px;
    }
    
    .taxonomy-title {
        font-size: 2rem;
    }
    
    .taxonomy-description {
        font-size: 1rem;
    }
}
</style>

<?php
get_footer();
