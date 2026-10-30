<?php
/**
 * Template para receita individual (WP Recipe Maker)
 *
 * @package Cozinha_Inventiva
 * @since 1.0.0
 * 
 * Arquivo: /Templates/singles/single-wprm_recipe.php
 * Localização: Templates/singles/single-wprm_recipe.php
 * Linhas: 410
 * 
 * FUNÇÃO: Template específico para receitas individuais (WP Recipe Maker). Exibe título,
 * meta dados (tempo preparo/cozimento/porções) com ícones SVG, tags de aproveitamento,
 * imagem principal, descrição, botões de ação (imprimir/favoritar), renderiza conteúdo
 * WP Recipe Maker, dicas de aproveitamento, benefícios, navegação entre receitas, receitas
 * relacionadas aleatórias (3) e comentários. Inclui CSS inline completo.
 */

// ARQUIVO 10/42 - SINGLE-WPRM_RECIPE.PHP
// Localização: /Templates/singles/single-wprm_recipe.php
// Linhas: 410

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>

<div class="container-narrow">
    <?php
    while (have_posts()) :
        the_post();
        $recipe_id = get_the_ID();
        ?>

        <article id="recipe-<?php the_ID(); ?>" <?php post_class('single-recipe'); ?>>
            
            <!-- Cabeçalho da Receita -->
            <header class="single-recipe-header">
                <?php the_title('<h1 class="single-recipe-title">', '</h1>'); ?>
                
                <div class="single-recipe-meta">
                    <?php
                    // Tempo de preparo
                    $prep_time = get_post_meta($recipe_id, 'wprm_recipe_prep_time', true);
                    if ($prep_time) :
                        ?>
                        <span class="recipe-meta-item">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" stroke="currentColor">
                                <circle cx="10" cy="10" r="8" stroke-width="2"/>
                                <path d="M10 6v4l3 2" stroke-width="2" stroke-linecap="round"/>
                            </svg>
                            <?php echo esc_html($prep_time); ?> min
                        </span>
                    <?php endif; ?>

                    <?php
                    // Tempo de cozimento
                    $cook_time = get_post_meta($recipe_id, 'wprm_recipe_cook_time', true);
                    if ($cook_time) :
                        ?>
                        <span class="recipe-meta-item">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" stroke="currentColor">
                                <path d="M3 10h14M3 6h14M3 14h14" stroke-width="2" stroke-linecap="round"/>
                            </svg>
                            <?php echo esc_html($cook_time); ?> min cozimento
                        </span>
                    <?php endif; ?>

                    <?php
                    // Porções
                    $servings = get_post_meta($recipe_id, 'wprm_recipe_servings', true);
                    if ($servings) :
                        ?>
                        <span class="recipe-meta-item">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" stroke="currentColor">
                                <path d="M16 11c0 2.761-2.686 5-6 5s-6-2.239-6-5c0-2.761 2.686-5 6-5s6 2.239 6 5z" stroke-width="2"/>
                                <path d="M10 4v12" stroke-width="2" stroke-linecap="round"/>
                            </svg>
                            <?php echo esc_html($servings); ?> porções
                        </span>
                    <?php endif; ?>
                </div>

                <?php
                // Tipo de aproveitamento
                $tipos = get_the_terms($recipe_id, 'tipo_aproveitamento');
                if ($tipos && !is_wp_error($tipos)) :
                    ?>
                    <div class="recipe-aproveitamento">
                        <?php foreach ($tipos as $tipo) : ?>
                            <a href="<?php echo esc_url(get_term_link($tipo)); ?>" class="recipe-tag">
                                <?php echo esc_html($tipo->name); ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </header>

            <!-- Imagem Principal -->
            <?php if (has_post_thumbnail()) : ?>
                <div class="single-recipe-image">
                    <?php the_post_thumbnail('recipe-featured'); ?>
                </div>
            <?php endif; ?>

            <!-- Descrição da Receita -->
            <?php if (has_excerpt()) : ?>
                <div class="recipe-summary">
                    <?php the_excerpt(); ?>
                </div>
            <?php endif; ?>

            <!-- Botões de Ação -->
            <div class="recipe-actions">
                <button class="btn btn-primary" onclick="window.print()">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" stroke="currentColor">
                        <path d="M5 7V3a1 1 0 011-1h8a1 1 0 011 1v4" stroke-width="2"/>
                        <path d="M5 13H3a1 1 0 01-1-1V9a1 1 0 011-1h14a1 1 0 011 1v3a1 1 0 01-1 1h-2" stroke-width="2"/>
                        <path d="M5 13v5h10v-5H5z" stroke-width="2"/>
                    </svg>
                    Imprimir Receita
                </button>
                <button class="btn btn-secondary recipe-favorite" data-recipe-id="<?php echo esc_attr($recipe_id); ?>">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" stroke="currentColor">
                        <path d="M10 17l-1.45-1.32C3.4 11.36 0 8.28 0 4.5 0 1.42 2.42 0 4.5 0c1.74 0 3.41.81 4.5 2.09C10.09.81 11.76 0 13.5 0 15.58 0 18 1.42 18 4.5c0 3.78-3.4 6.86-8.55 11.18L10 17z" stroke-width="2"/>
                    </svg>
                    Salvar Favorito
                </button>
            </div>

            <!-- Conteúdo Principal da Receita -->
            <div class="recipe-content">
                <?php
                // WP Recipe Maker renderiza o conteúdo automaticamente
                the_content();
                ?>
            </div>

            <!-- Informações Adicionais -->
            <?php
            $dicas_aproveitamento = get_post_meta($recipe_id, 'dicas_aproveitamento', true);
            if ($dicas_aproveitamento) :
                ?>
                <div class="recipe-tips">
                    <h3><?php esc_html_e('Dicas de Aproveitamento', 'cozinha-inventiva'); ?></h3>
                    <div class="tips-content">
                        <?php echo wp_kses_post($dicas_aproveitamento); ?>
                    </div>
                </div>
            <?php endif; ?>

            <?php
            $beneficios = get_post_meta($recipe_id, 'beneficios', true);
            if ($beneficios) :
                ?>
                <div class="recipe-benefits">
                    <h3><?php esc_html_e('Benefícios', 'cozinha-inventiva'); ?></h3>
                    <div class="benefits-content">
                        <?php echo wp_kses_post($beneficios); ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Navegação entre Receitas -->
            <nav class="recipe-navigation">
                <?php
                $prev_post = get_previous_post();
                $next_post = get_next_post();
                ?>
                
                <?php if ($prev_post) : ?>
                    <a href="<?php echo get_permalink($prev_post); ?>" class="recipe-nav-prev">
                        <span class="nav-label"><?php esc_html_e('← Receita Anterior', 'cozinha-inventiva'); ?></span>
                        <span class="nav-title"><?php echo get_the_title($prev_post); ?></span>
                    </a>
                <?php endif; ?>

                <?php if ($next_post) : ?>
                    <a href="<?php echo get_permalink($next_post); ?>" class="recipe-nav-next">
                        <span class="nav-label"><?php esc_html_e('Próxima Receita →', 'cozinha-inventiva'); ?></span>
                        <span class="nav-title"><?php echo get_the_title($next_post); ?></span>
                    </a>
                <?php endif; ?>
            </nav>

            <!-- Receitas Relacionadas -->
            <?php
            $related_recipes = new WP_Query(array(
                'post_type'      => 'wprm_recipe',
                'posts_per_page' => 3,
                'post__not_in'   => array($recipe_id),
                'orderby'        => 'rand',
            ));

            if ($related_recipes->have_posts()) :
                ?>
                <section class="related-recipes">
                    <h2><?php esc_html_e('Você Também Pode Gostar', 'cozinha-inventiva'); ?></h2>
                    <div class="recipes-grid">
                        <?php
                        while ($related_recipes->have_posts()) :
                            $related_recipes->the_post();
                            get_template_part('template-parts/content', 'recipe-card');
                        endwhile;
                        wp_reset_postdata();
                        ?>
                    </div>
                </section>
            <?php endif; ?>

            <!-- Comentários -->
            <?php
            if (comments_open() || get_comments_number()) :
                comments_template();
            endif;
            ?>

        </article>

    <?php endwhile; ?>
</div>

<style>
/* Single Recipe Styles */
.single-recipe {
    padding: 2rem 0;
}

.single-recipe-header {
    text-align: center;
    margin-bottom: 2rem;
}

.single-recipe-title {
    font-size: 2.5rem;
    margin-bottom: 1.5rem;
    color: #1a202c;
}

.single-recipe-meta {
    display: flex;
    justify-content: center;
    gap: 2rem;
    flex-wrap: wrap;
    margin-bottom: 1.5rem;
}

.recipe-meta-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #718096;
    font-size: 1rem;
}

.recipe-meta-item svg {
    color: #48bb78;
}

.recipe-aproveitamento {
    display: flex;
    justify-content: center;
    gap: 0.75rem;
    flex-wrap: wrap;
}

.single-recipe-image {
    margin-bottom: 2rem;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
}

.single-recipe-image img {
    width: 100%;
    height: auto;
}

.recipe-summary {
    font-size: 1.125rem;
    color: #4a5568;
    line-height: 1.8;
    margin-bottom: 2rem;
    padding: 1.5rem;
    background-color: #f7fafc;
    border-radius: 8px;
    border-left: 4px solid #48bb78;
}

.recipe-actions {
    display: flex;
    gap: 1rem;
    margin-bottom: 2rem;
    justify-content: center;
    flex-wrap: wrap;
}

.recipe-actions .btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.recipe-content {
    margin: 3rem 0;
}

.recipe-tips,
.recipe-benefits {
    background-color: #f0fff4;
    padding: 2rem;
    border-radius: 12px;
    margin: 2rem 0;
    border-left: 4px solid #48bb78;
}

.recipe-tips h3,
.recipe-benefits h3 {
    color: #38a169;
    margin-bottom: 1rem;
}

.tips-content,
.benefits-content {
    color: #2d3748;
    line-height: 1.8;
}

.recipe-navigation {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
    margin: 3rem 0;
    padding: 2rem 0;
    border-top: 1px solid #e2e8f0;
}

.recipe-nav-prev,
.recipe-nav-next {
    display: flex;
    flex-direction: column;
    padding: 1.5rem;
    background-color: #f7fafc;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.recipe-nav-prev:hover,
.recipe-nav-next:hover {
    background-color: #edf2f7;
    transform: translateY(-2px);
}

.nav-label {
    font-size: 0.875rem;
    color: #718096;
    margin-bottom: 0.5rem;
}

.nav-title {
    font-size: 1.125rem;
    font-weight: 600;
    color: #1a202c;
}

.related-recipes {
    margin-top: 4rem;
    padding-top: 3rem;
    border-top: 2px solid #e2e8f0;
}

.related-recipes h2 {
    text-align: center;
    font-size: 2rem;
    margin-bottom: 2rem;
    color: #1a202c;
}

@media print {
    .recipe-actions,
    .recipe-navigation,
    .related-recipes,
    .site-header,
    .site-footer,
    #comments {
        display: none !important;
    }
    
    .single-recipe {
        max-width: 100%;
    }
}

@media (max-width: 768px) {
    .single-recipe-title {
        font-size: 2rem;
    }
    
    .single-recipe-meta {
        flex-direction: column;
        gap: 0.75rem;
    }
    
    .recipe-actions {
        flex-direction: column;
    }
    
    .recipe-actions .btn {
        width: 100%;
    }
}
</style>

<?php
get_footer();
