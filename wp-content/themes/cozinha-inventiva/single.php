<?php
/**
 * Template para posts únicos
 *
 * @package Cozinha_Inventiva
 * @since 1.0.0
 * 
 * Arquivo: /single.php
 * Localização: Raiz do tema
 * Linhas: 219
 * 
 * FUNÇÃO: Template para posts únicos (blog posts padrão). Exibe cabeçalho com título e meta
 * (data, autor), imagem destacada, conteúdo completo com the_content(), paginação de páginas,
 * footer com categorias/tags, navegação prev/next entre posts e área de comentários.
 */

// ARQUIVO 9/42 - SINGLE.PHP
// Localização: /single.php
// Linhas: 219

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>

<div class="container">
    <?php
    while (have_posts()) :
        the_post();
        ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class('single-post'); ?>>
            <header class="entry-header">
                <?php the_title('<h1 class="entry-title">', '</h1>'); ?>

                <div class="entry-meta">
                    <span class="posted-on">
                        <time datetime="<?php echo get_the_date('c'); ?>">
                            <?php echo get_the_date(); ?>
                        </time>
                    </span>
                    <span class="byline">
                        <?php
                        printf(
                            esc_html__('por %s', 'cozinha-inventiva'),
                            '<span class="author vcard">' . get_the_author() . '</span>'
                        );
                        ?>
                    </span>
                </div>
            </header>

            <?php if (has_post_thumbnail()) : ?>
                <div class="entry-featured-image">
                    <?php the_post_thumbnail('large'); ?>
                </div>
            <?php endif; ?>

            <div class="entry-content">
                <?php
                the_content();

                wp_link_pages(array(
                    'before' => '<div class="page-links">' . esc_html__('Páginas:', 'cozinha-inventiva'),
                    'after'  => '</div>',
                ));
                ?>
            </div>

            <footer class="entry-footer">
                <?php
                $categories_list = get_the_category_list(', ');
                if ($categories_list) {
                    printf(
                        '<span class="cat-links">' . esc_html__('Categorias: %s', 'cozinha-inventiva') . '</span>',
                        $categories_list
                    );
                }

                $tags_list = get_the_tag_list('', ', ');
                if ($tags_list) {
                    printf(
                        '<span class="tags-links">' . esc_html__('Tags: %s', 'cozinha-inventiva') . '</span>',
                        $tags_list
                    );
                }
                ?>
            </footer>
        </article>

        <?php
        // Navegação entre posts
        the_post_navigation(array(
            'prev_text' => '<span class="nav-subtitle">' . esc_html__('Anterior:', 'cozinha-inventiva') . '</span> <span class="nav-title">%title</span>',
            'next_text' => '<span class="nav-subtitle">' . esc_html__('Próximo:', 'cozinha-inventiva') . '</span> <span class="nav-title">%title</span>',
        ));

        // Comentários
        if (comments_open() || get_comments_number()) :
            comments_template();
        endif;

    endwhile;
    ?>
</div>

<style>
.single-post {
    max-width: 800px;
    margin: 0 auto;
}

.entry-header {
    text-align: center;
    margin-bottom: 2rem;
}

.entry-title {
    font-size: 2.5rem;
    margin-bottom: 1rem;
    color: #1a202c;
}

.entry-meta {
    display: flex;
    justify-content: center;
    gap: 1.5rem;
    font-size: 0.9375rem;
    color: #718096;
}

.entry-featured-image {
    margin-bottom: 2rem;
    border-radius: 12px;
    overflow: hidden;
}

.entry-featured-image img {
    width: 100%;
    height: auto;
}

.entry-content {
    line-height: 1.8;
    font-size: 1.0625rem;
    color: #2d3748;
}

.entry-content p {
    margin-bottom: 1.5rem;
}

.entry-content h2,
.entry-content h3,
.entry-content h4 {
    margin-top: 2rem;
    margin-bottom: 1rem;
}

.entry-content ul,
.entry-content ol {
    margin-bottom: 1.5rem;
    padding-left: 2rem;
}

.entry-content li {
    margin-bottom: 0.5rem;
}

.entry-footer {
    margin-top: 3rem;
    padding-top: 2rem;
    border-top: 1px solid #e2e8f0;
}

.entry-footer span {
    display: block;
    margin-bottom: 0.75rem;
    color: #718096;
}

.entry-footer a {
    color: #48bb78;
}

.entry-footer a:hover {
    color: #38a169;
}

.post-navigation {
    margin-top: 3rem;
    padding-top: 2rem;
    border-top: 1px solid #e2e8f0;
}

.nav-subtitle {
    display: block;
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
    .entry-title {
        font-size: 2rem;
    }
    
    .entry-meta {
        flex-direction: column;
        gap: 0.5rem;
    }
}
</style>

<?php
get_footer();
