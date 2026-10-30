<?php
/**
 * Template part para card de receita
 *
 * @package Cozinha_Inventiva
 * @since 1.0.0
 * 
 * Arquivo: /template-parts/content-recipe-card.php
 * Localização: template-parts/content-recipe-card.php
 * Linhas: 125
 * 
 * FUNÇÃO: Componente reutilizável de card de receita. Exibe imagem thumbnail com link,
 * título linkado, excerpt (resumo), meta dados (tempo/porções) com ícones SVG, tags de
 * tipo de aproveitamento e link "Ver Receita". Usado em loops de arquivo, taxonomias,
 * relacionadas, etc. Suporta posts de qualquer tipo.
 */

// ARQUIVO 17/42 - CONTENT-RECIPE-CARD.PHP
// Localização: /template-parts/content-recipe-card.php
// Linhas: 125

if (!defined('ABSPATH')) {
    exit;
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('recipe-card'); ?>>
    
    <?php if (has_post_thumbnail()) : ?>
        <div class="recipe-card-image-wrapper">
            <a href="<?php the_permalink(); ?>" class="recipe-card-image-link">
                <?php the_post_thumbnail('recipe-card', array('class' => 'recipe-card-image')); ?>
            </a>
        </div>
    <?php endif; ?>
    
    <div class="recipe-card-content">
        <h3 class="recipe-card-title">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h3>
        
        <?php if (has_excerpt()) : ?>
            <div class="recipe-card-excerpt">
                <?php echo wp_trim_words(get_the_excerpt(), 20, '...'); ?>
            </div>
        <?php endif; ?>
        
        <?php if (get_post_type() === 'wprm_recipe') : ?>
            <div class="recipe-card-meta">
                <?php
                $prep_time = get_post_meta(get_the_ID(), 'wprm_recipe_prep_time', true);
                if ($prep_time) :
                    ?>
                    <span class="recipe-meta-item">
                        <svg width="16" height="16" viewBox="0 0 20 20" fill="none" stroke="currentColor">
                            <circle cx="10" cy="10" r="8" stroke-width="2"/>
                            <path d="M10 6v4l3 2" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                        <?php echo esc_html($prep_time); ?> min
                    </span>
                <?php endif; ?>
                
                <?php
                $servings = get_post_meta(get_the_ID(), 'wprm_recipe_servings', true);
                if ($servings) :
                    ?>
                    <span class="recipe-meta-item">
                        <svg width="16" height="16" viewBox="0 0 20 20" fill="none" stroke="currentColor">
                            <path d="M16 11c0 2.761-2.686 5-6 5s-6-2.239-6-5c0-2.761 2.686-5 6-5s6 2.239 6 5z" stroke-width="2"/>
                            <path d="M10 4v12" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                        <?php echo esc_html($servings); ?> porções
                    </span>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        
        <?php
        $tipos = get_the_terms(get_the_ID(), 'tipo_aproveitamento');
        if ($tipos && !is_wp_error($tipos)) :
            ?>
            <div class="recipe-card-tags">
                <?php foreach (array_slice($tipos, 0, 3) as $tipo) : ?>
                    <a href="<?php echo esc_url(get_term_link($tipo)); ?>" class="recipe-tag">
                        <?php echo esc_html($tipo->name); ?>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        
        <div class="recipe-card-footer">
            <a href="<?php the_permalink(); ?>" class="recipe-card-link">
                <?php esc_html_e('Ver Receita', 'cozinha-inventiva'); ?> →
            </a>
        </div>
    </div>
    
</article>

<style>
.recipe-card {
    background-color: #ffffff;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease;
    display: flex;
    flex-direction: column;
    height: 100%;
}

.recipe-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
}

.recipe-card-image-wrapper {
    width: 100%;
    height: 240px;
    overflow: hidden;
}

.recipe-card-image-link {
    display: block;
    width: 100%;
    height: 100%;
}

.recipe-card-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.recipe-card:hover .recipe-card-image {
    transform: scale(1.1);
}

.recipe-card-content {
    padding: 1.5rem;
    flex: 1;
    display: flex;
    flex-direction: column;
}

.recipe-card-title {
    font-size: 1.25rem;
    margin-bottom: 0.75rem;
    color: #1a202c;
}

.recipe-card-title a {
    color: inherit;
    transition: color 0.3s ease;
}

.recipe-card-title a:hover {
    color: #48bb78;
}

.recipe-card-excerpt {
    font-size: 0.9375rem;
    color: #718096;
    margin-bottom: 1rem;
    line-height: 1.6;
    flex: 1;
}

.recipe-card-meta {
    display: flex;
    gap: 1rem;
    font-size: 0.875rem;
    color: #a0aec0;
    margin-bottom: 1rem;
    padding-top: 1rem;
    border-top: 1px solid #e2e8f0;
}

.recipe-meta-item svg {
    color: #48bb78;
}

.recipe-card-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
    margin-bottom: 1rem;
}

.recipe-card-footer {
    margin-top: auto;
}

.recipe-card-link {
    color: #48bb78;
    font-weight: 600;
    font-size: 0.9375rem;
    transition: color 0.3s ease;
}

.recipe-card-link:hover {
    color: #38a169;
}
</style>
