<?php
/**
 * Template para guia individual
 *
 * @package Cozinha_Inventiva
 * @since 1.0.0
 * 
 * Arquivo: /Templates/singles/single-ci_guia.php
 * Localização: Templates/singles/single-ci_guia.php
 * Linhas: 238
 * 
 * FUNÇÃO: Template específico para guias de aproveitamento. Exibe título do guia, imagem
 * destacada, conteúdo completo com the_content(), seção de "Receitas relacionadas a este
 * guia" (query de receitas), navegação prev/next entre guias e comentários. Inclui CSS
 * inline para estilização.
 */

// ARQUIVO 12/42 - SINGLE-CI_GUIA.PHP
// Localização: /Templates/singles/single-ci_guia.php
// Linhas: 238

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>

<div class="container">
    <?php
    while (have_posts()) :
        the_post();
        $guia_id = get_the_ID();
        ?>

        <article id="guia-<?php the_ID(); ?>" <?php post_class('single-guia'); ?>>
            
            <header class="guia-header">
                <?php the_title('<h1 class="guia-title">', '</h1>'); ?>
                
                <div class="guia-meta">
                    <span class="posted-on">
                        <time datetime="<?php echo get_the_date('c'); ?>">
                            <?php echo get_the_date(); ?>
                        </time>
                    </span>
                </div>
            </header>

            <?php if (has_post_thumbnail()) : ?>
                <div class="guia-featured-image">
                    <?php the_post_thumbnail('large'); ?>
                </div>
            <?php endif; ?>

            <div class="guia-content">
                <?php the_content(); ?>
            </div>

            <!-- Receitas relacionadas a este guia -->
            <?php
            $related_recipes = new WP_Query(array(
                'post_type'      => 'wprm_recipe',
                'posts_per_page' => 6,
                'meta_query'     => array(
                    array(
                        'key'     => 'guias_relacionados',
                        'value'   => $guia_id,
                        'compare' => 'LIKE',
                    ),
                ),
            ));

            if ($related_recipes->have_posts()) :
                ?>
                <section class="guia-recipes">
                    <h2><?php esc_html_e('Receitas relacionadas a este guia', 'cozinha-inventiva'); ?></h2>
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

            <!-- Navegação entre guias -->
            <nav class="guia-navigation">
                <?php
                $prev_post = get_previous_post();
                $next_post = get_next_post();
                ?>
                
                <?php if ($prev_post) : ?>
                    <a href="<?php echo get_permalink($prev_post); ?>" class="nav-prev">
                        <span class="nav-label"><?php esc_html_e('← Guia Anterior', 'cozinha-inventiva'); ?></span>
                        <span class="nav-title"><?php echo get_the_title($prev_post); ?></span>
                    </a>
                <?php endif; ?>

                <?php if ($next_post) : ?>
                    <a href="<?php echo get_permalink($next_post); ?>" class="nav-next">
                        <span class="nav-label"><?php esc_html_e('Próximo Guia →', 'cozinha-inventiva'); ?></span>
                        <span class="nav-title"><?php echo get_the_title($next_post); ?></span>
                    </a>
                <?php endif; ?>
            </nav>

            <?php
            if (comments_open() || get_comments_number()) :
                comments_template();
            endif;
            ?>

        </article>

    <?php endwhile; ?>
</div>

<style>
.single-guia {
    max-width: 900px;
    margin: 0 auto;
    padding: 2rem 1rem;
}

.guia-header {
    text-align: center;
    margin-bottom: 2rem;
}

.guia-title {
    font-size: 2.5rem;
    color: #1a202c;
    margin-bottom: 1rem;
}

.guia-meta {
    font-size: 0.9375rem;
    color: #718096;
}

.guia-featured-image {
    margin-bottom: 3rem;
    border-radius: 12px;
    overflow: hidden;
}

.guia-featured-image img {
    width: 100%;
    height: auto;
}

.guia-content {
    font-size: 1.0625rem;
    line-height: 1.8;
    color: #2d3748;
}

.guia-content p {
    margin-bottom: 1.5rem;
}

.guia-content h2,
.guia-content h3 {
    margin-top: 2rem;
    margin-bottom: 1rem;
    color: #1a202c;
}

.guia-content ul,
.guia-content ol {
    margin-bottom: 1.5rem;
    padding-left: 2rem;
}

.guia-recipes {
    margin-top: 4rem;
    padding-top: 3rem;
    border-top: 2px solid #e2e8f0;
}

.guia-recipes h2 {
    text-align: center;
    font-size: 2rem;
    margin-bottom: 2rem;
    color: #1a202c;
}

.guia-navigation {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
    margin: 3rem 0;
    padding: 2rem 0;
    border-top: 1px solid #e2e8f0;
}

.nav-prev,
.nav-next {
    display: flex;
    flex-direction: column;
    padding: 1.5rem;
    background-color: #f7fafc;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.nav-prev:hover,
.nav-next:hover {
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

@media (max-width: 768px) {
    .guia-title {
        font-size: 2rem;
    }
}
</style>

<?php
get_footer();
