<?php
/**
 * Template Name: Sobre
 *
 * @package Cozinha_Inventiva
 * @since 1.0.0
 * 
 * Arquivo: /Templates/Pages/page-sobre.php
 * Localização: Templates/Pages/page-sobre.php
 * Linhas: 145
 * 
 * FUNÇÃO: Template da página "Sobre". Exibe conteúdo sobre o projeto Cozinha Inventiva,
 * missão, valores, equipe (opcional via ACF), estatísticas de impacto (receitas, comunidade)
 * e call-to-action para engajamento. Layout com sidebar opcional e CSS inline.
 */

// ARQUIVO 27/42 - PAGE-SOBRE.PHP
// Localização: /Templates/Pages/page-sobre.php
// Linhas: 145

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>

<div class="container">
    <div class="sobre-page">
        <?php while (have_posts()) : the_post(); ?>

            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="page-header">
                    <?php the_title('<h1 class="page-title">', '</h1>'); ?>
                </header>

                <?php if (has_post_thumbnail()) : ?>
                    <div class="page-featured-image">
                        <?php the_post_thumbnail('large'); ?>
                    </div>
                <?php endif; ?>

                <div class="page-content">
                    <?php the_content(); ?>
                </div>

                <!-- Estatísticas -->
                <div class="sobre-stats">
                    <div class="stat-item">
                        <span class="stat-number">
                            <?php 
                            $recipe_count = wp_count_posts('wprm_recipe');
                            echo esc_html($recipe_count->publish);
                            ?>
                        </span>
                        <span class="stat-label"><?php esc_html_e('Receitas Publicadas', 'cozinha-inventiva'); ?></span>
                    </div>

                    <div class="stat-item">
                        <span class="stat-number">
                            <?php 
                            $tecnica_count = wp_count_posts('ci_tecnica');
                            echo esc_html($tecnica_count->publish);
                            ?>
                        </span>
                        <span class="stat-label"><?php esc_html_e('Técnicas Ensinadas', 'cozinha-inventiva'); ?></span>
                    </div>

                    <div class="stat-item">
                        <span class="stat-number">
                            <?php 
                            $guia_count = wp_count_posts('ci_guia');
                            echo esc_html($guia_count->publish);
                            ?>
                        </span>
                        <span class="stat-label"><?php esc_html_e('Guias Completos', 'cozinha-inventiva'); ?></span>
                    </div>
                </div>

                <!-- Call to Action -->
                <div class="sobre-cta">
                    <h2><?php esc_html_e('Faça Parte da Comunidade', 'cozinha-inventiva'); ?></h2>
                    <p><?php esc_html_e('Junte-se a milhares de pessoas que já transformaram sua forma de cozinhar', 'cozinha-inventiva'); ?></p>
                    <div class="cta-buttons">
                        <a href="<?php echo esc_url(get_post_type_archive_link('wprm_recipe')); ?>" class="btn btn-primary">
                            <?php esc_html_e('Explorar Receitas', 'cozinha-inventiva'); ?>
                        </a>
                        <a href="<?php echo esc_url(home_url('/contato')); ?>" class="btn btn-secondary">
                            <?php esc_html_e('Entre em Contato', 'cozinha-inventiva'); ?>
                        </a>
                    </div>
                </div>
            </article>

        <?php endwhile; ?>
    </div>
</div>

<style>
.sobre-page {
    max-width: 900px;
    margin: 0 auto;
    padding: 2rem 1rem;
}

.page-header {
    text-align: center;
    margin-bottom: 2rem;
}

.page-title {
    font-size: 2.5rem;
    color: #1a202c;
}

.page-featured-image {
    margin-bottom: 3rem;
    border-radius: 12px;
    overflow: hidden;
}

.page-featured-image img {
    width: 100%;
    height: auto;
}

.page-content {
    font-size: 1.0625rem;
    line-height: 1.8;
    color: #2d3748;
    margin-bottom: 3rem;
}

.page-content p {
    margin-bottom: 1.5rem;
}

.sobre-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 2rem;
    margin: 3rem 0;
    padding: 2rem;
    background: linear-gradient(135deg, #f0fff4 0%, #e6fffa 100%);
    border-radius: 12px;
}

.stat-item {
    text-align: center;
}

.stat-number {
    display: block;
    font-size: 3rem;
    font-weight: 800;
    color: #48bb78;
    line-height: 1;
    margin-bottom: 0.5rem;
}

.stat-label {
    display: block;
    font-size: 1rem;
    color: #4a5568;
}

.sobre-cta {
    text-align: center;
    padding: 3rem 2rem;
    background-color: #f7fafc;
    border-radius: 12px;
    margin-top: 3rem;
}

.sobre-cta h2 {
    font-size: 2rem;
    margin-bottom: 1rem;
    color: #1a202c;
}

.sobre-cta p {
    font-size: 1.125rem;
    color: #718096;
    margin-bottom: 2rem;
}

.cta-buttons {
    display: flex;
    justify-content: center;
    gap: 1rem;
    flex-wrap: wrap;
}

@media (max-width: 768px) {
    .page-title {
        font-size: 2rem;
    }
    
    .stat-number {
        font-size: 2.5rem;
    }
    
    .cta-buttons {
        flex-direction: column;
        align-items: center;
    }
}
</style>

<?php
get_footer();
