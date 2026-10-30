<?php
/**
 * ARQUIVO 32/32
 * PASTA: /wp-content/themes/cozinha-inventiva/
 * NOME: search.php
 */

get_header();
?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">
        <?php if ( have_posts() ) : ?>
            <header class="page-header">
                <h1 class="page-title">
                    <?php printf( esc_html__( 'Resultados da busca por: %s', 'cozinha-inventiva' ), '<span>' . get_search_query() . '</span>' ); ?>
                </h1>
            </header>

            <div class="search-results-grid">
                <?php while ( have_posts() ) : the_post(); ?>
                    <article <?php post_class( 'search-result-item' ); ?>>
                        <?php if ( has_post_thumbnail() ) : ?>
                            <div class="result-thumbnail">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail( 'medium' ); ?>
                                </a>
                            </div>
                        <?php endif; ?>
                        
                        <div class="result-content">
                            <h2 class="result-title">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_title(); ?>
                                </a>
                            </h2>
                            
                            <div class="result-excerpt">
                                <?php the_excerpt(); ?>
                            </div>
                            
                            <a href="<?php the_permalink(); ?>" class="ci-btn ci-btn-small ci-btn-primary">
                                Ver mais
                            </a>
                        </div>
                    </article>
                <?php endwhile; ?>
            </div>

            <?php the_posts_pagination(); ?>

        <?php else : ?>
            <section class="no-results not-found">
                <header class="page-header">
                    <h1 class="page-title">Nenhum resultado encontrado</h1>
                </header>

                <div class="page-content">
                    <p>Desculpe, nenhum resultado foi encontrado para sua busca. Tente outras palavras-chave.</p>
                    
                    <div class="search-again">
                        <?php get_search_form(); ?>
                    </div>

                    <div class="popular-categories">
                        <h2>Explore nossas categorias</h2>
                        <ul>
                            <?php
                            $categories = get_categories( array(
                                'orderby' => 'count',
                                'order'   => 'DESC',
                                'number'  => 5,
                            ) );
                            
                            foreach ( $categories as $category ) {
                                echo '<li><a href="' . get_category_link( $category->term_id ) . '">' . $category->name . '</a></li>';
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </section>
        <?php endif; ?>
    </main>
</div>

<?php
get_sidebar();
get_footer();
