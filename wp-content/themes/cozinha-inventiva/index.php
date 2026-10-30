<?php
/**
 * ARQUIVO 5/36
 * LOCALIZAÇÃO: /wp-content/themes/cozinha-inventiva/index.php
 * LINHAS: ~155
 * 
 * FUNÇÃO COMPLETA:
 * - Template fallback padrão do WordPress
 * - Loop completo do WordPress (have_posts / the_post)
 * - Detecção de contexto (home, archive, search)
 * - Títulos contextuais apropriados
 * - Grid responsivo de posts/receitas
 * - Paginação completa e funcional
 * - Mensagem quando não há conteúdo
 * - Calls para sidebar e footer
 */

if ( ! defined( 'ABSPATH' ) ) exit;

get_header();
?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">

        <?php if ( have_posts() ) : ?>

            <header class="page-header">
                <?php
                if ( is_home() && ! is_front_page() ) :
                    ?>
                    <h1 class="page-title"><?php single_post_title(); ?></h1>
                    <?php
                elseif ( is_archive() ) :
                    the_archive_title( '<h1 class="page-title">', '</h1>' );
                    the_archive_description( '<div class="archive-description">', '</div>' );
                elseif ( is_search() ) :
                    ?>
                    <h1 class="page-title">
                        <?php
                        printf(
                            __( 'Resultados da busca por: %s', 'cozinha-inventiva' ),
                            '<span>' . get_search_query() . '</span>'
                        );
                        ?>
                    </h1>
                    <?php
                else :
                    ?>
                    <h1 class="page-title"><?php _e( 'Blog', 'cozinha-inventiva' ); ?></h1>
                    <?php
                endif;
                ?>
            </header><!-- .page-header -->

            <div class="ci-posts-grid">
                <?php
                while ( have_posts() ) :
                    the_post();
                    ?>

                    <article id="post-<?php the_ID(); ?>" <?php post_class( 'ci-post-card' ); ?>>
                        
                        <?php if ( has_post_thumbnail() ) : ?>
                            <div class="post-thumbnail">
                                <a href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
                                    <?php 
                                    the_post_thumbnail( 'ci-recipe-card', array(
                                        'alt' => the_title_attribute( array( 'echo' => false ) ),
                                    ) ); 
                                    ?>
                                </a>
                            </div>
                        <?php endif; ?>

                        <div class="post-content">
                            
                            <h2 class="entry-title">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_title(); ?>
                                </a>
                            </h2>

                            <div class="entry-meta">
                                <span class="posted-on">
                                    <time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
                                        <?php echo esc_html( get_the_date() ); ?>
                                    </time>
                                </span>
                                
                                <?php if ( has_category() ) : ?>
                                    <span class="cat-links">
                                        <?php _e( 'em', 'cozinha-inventiva' ); ?> 
                                        <?php the_category( ', ' ); ?>
                                    </span>
                                <?php endif; ?>
                            </div><!-- .entry-meta -->

                            <div class="entry-excerpt">
                                <?php the_excerpt(); ?>
                            </div>

                            <a href="<?php the_permalink(); ?>" class="ci-btn ci-btn-primary">
                                <?php _e( 'Ler mais', 'cozinha-inventiva' ); ?>
                            </a>
                            
                        </div><!-- .post-content -->
                        
                    </article><!-- #post-<?php the_ID(); ?> -->

                    <?php
                endwhile;
                ?>
            </div><!-- .ci-posts-grid -->

            <?php
            the_posts_pagination(
                array(
                    'mid_size'           => 2,
                    'prev_text'          => __( '&laquo; Anterior', 'cozinha-inventiva' ),
                    'next_text'          => __( 'Próxima &raquo;', 'cozinha-inventiva' ),
                    'screen_reader_text' => __( 'Navegação de posts', 'cozinha-inventiva' ),
                )
            );
            ?>

        <?php else : ?>

            <section class="no-results not-found">
                <header class="page-header">
                    <h1 class="page-title"><?php _e( 'Nenhum conteúdo encontrado', 'cozinha-inventiva' ); ?></h1>
                </header>

                <div class="page-content">
                    <?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

                        <p>
                            <?php
                            printf(
                                __( 'Pronto para publicar seu primeiro post? <a href="%1$s">Comece aqui</a>.', 'cozinha-inventiva' ),
                                esc_url( admin_url( 'post-new.php' ) )
                            );
                            ?>
                        </p>

                    <?php elseif ( is_search() ) : ?>

                        <p><?php _e( 'Desculpe, nada foi encontrado com esses termos. Tente buscar com outras palavras-chave.', 'cozinha-inventiva' ); ?></p>
                        <?php get_search_form(); ?>

                    <?php else : ?>

                        <p><?php _e( 'Parece que não conseguimos encontrar o que você procura. Que tal usar a busca?', 'cozinha-inventiva' ); ?></p>
                        <?php get_search_form(); ?>

                    <?php endif; ?>
                </div><!-- .page-content -->
            </section><!-- .no-results -->

        <?php endif; ?>

    </main><!-- #main -->
</div><!-- #primary -->

<?php
get_sidebar();
get_footer();
?>

<!-- FIM DO ARQUIVO 5/36 -->
