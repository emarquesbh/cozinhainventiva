<?php
/**
 * Template part para card de artigo
 *
 * @package Cozinha_Inventiva
 * @since 1.0.0
 * 
 * Arquivo: /template-parts/content-article.php
 * Localização: template-parts/content-article.php
 * Linhas: 125
 * 
 * FUNÇÃO: Template part para card de artigo genérico (posts, técnicas, guias). Similar ao
 * recipe-card mas mais simples, sem meta dados de receita. Exibe imagem thumbnail, título
 * linkado, excerpt, data de publicação e link "Ler mais". Usado para posts que não são receitas.
 */

// ARQUIVO 19/42 - CONTENT-ARTICLE.PHP
// Localização: /template-parts/content-article.php
// Linhas: 125

if (!defined('ABSPATH')) {
    exit;
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('article-card'); ?>>
    
    <?php if (has_post_thumbnail()) : ?>
        <div class="article-card-image-wrapper">
            <a href="<?php the_permalink(); ?>" class="article-card-image-link">
                <?php the_post_thumbnail('recipe-card', array('class' => 'article-card-image')); ?>
            </a>
        </div>
    <?php endif; ?>
    
    <div class="article-card-content">
        <h3 class="article-card-title">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h3>
        
        <div class="article-card-meta">
            <time datetime="<?php echo get_the_date('c'); ?>" class="article-date">
                <?php echo get_the_date(); ?>
            </time>
        </div>
        
        <?php if (has_excerpt()) : ?>
            <div class="article-card-excerpt">
                <?php echo wp_trim_words(get_the_excerpt(), 25, '...'); ?>
            </div>
        <?php endif; ?>
        
        <div class="article-card-footer">
            <a href="<?php the_permalink(); ?>" class="article-card-link">
                <?php esc_html_e('Ler mais', 'cozinha-inventiva'); ?> →
            </a>
        </div>
    </div>
    
</article>

<style>
.article-card {
    background-color: #ffffff;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease;
    display: flex;
    flex-direction: column;
    height: 100%;
}

.article-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
}

.article-card-image-wrapper {
    width: 100%;
    height: 220px;
    overflow: hidden;
}

.article-card-image-link {
    display: block;
    width: 100%;
    height: 100%;
}

.article-card-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.article-card:hover .article-card-image {
    transform: scale(1.05);
}

.article-card-content {
    padding: 1.5rem;
    flex: 1;
    display: flex;
    flex-direction: column;
}

.article-card-title {
    font-size: 1.25rem;
    margin-bottom: 0.75rem;
    color: #1a202c;
}

.article-card-title a {
    color: inherit;
    transition: color 0.3s ease;
}

.article-card-title a:hover {
    color: #48bb78;
}

.article-card-meta {
    font-size: 0.875rem;
    color: #a0aec0;
    margin-bottom: 1rem;
}

.article-date {
    color: inherit;
}

.article-card-excerpt {
    font-size: 0.9375rem;
    color: #718096;
    margin-bottom: 1rem;
    line-height: 1.6;
    flex: 1;
}

.article-card-footer {
    margin-top: auto;
}

.article-card-link {
    color: #48bb78;
    font-weight: 600;
    font-size: 0.9375rem;
    transition: color 0.3s ease;
}

.article-card-link:hover {
    color: #38a169;
}
</style>
