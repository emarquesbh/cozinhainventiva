<?php
/**
 * FRONT PAGE COM HERO PARALLAX
 * Template da página inicial
 */

get_header();
?>

<!-- HERO PARALLAX COM IMAGEM -->
<section class="hero-parallax">
    <div class="hero-parallax-bg" style="background-image: url('<?php echo get_stylesheet_directory_uri(); ?>/assets/images/hero-01.png');"></div>
    <div class="hero-parallax-overlay"></div>
    <div class="hero-content">
        <h1>Onde Nada se Perde, Tudo se Transforma</h1>
        <p>Descubra a arte do Upcycling Culinário</p>
        <a href="#receitas" class="hero-btn">Explorar Receitas</a>
    </div>
</section>

<!-- SEÇÃO DE RECEITAS -->
<div id="receitas" class="container" style="max-width: 1200px; margin: 4rem auto; padding: 0 1rem;">
    
    <h2 style="text-align: center; font-size: 2.5rem; margin-bottom: 3rem; font-family: var(--font-headings);">
        Receitas em Destaque
    </h2>

    <?php
    // Query para buscar receitas (WP Recipe Maker)
    $recipes_query = new WP_Query( array(
        'post_type'      => 'wprm_recipe',
        'posts_per_page' => 6,
        'orderby'        => 'date',
        'order'          => 'DESC',
    ) );

    if ( $recipes_query->have_posts() ) :
        ?>
        <div class="ci-posts-grid">
            <?php while ( $recipes_query->have_posts() ) : $recipes_query->the_post(); ?>
                <article class="ci-post-card">
                    <?php if ( has_post_thumbnail() ) : ?>
                        <a href="<?php the_permalink(); ?>">
                            <?php the_post_thumbnail( 'ci-recipe-card' ); ?>
                        </a>
                    <?php endif; ?>
                    <div class="post-content">
                        <h3 style="font-size: 1.5rem; margin-bottom: 0.5rem;">
                            <a href="<?php the_permalink(); ?>" style="color: var(--ci-preto); text-decoration: none;">
                                <?php the_title(); ?>
                            </a>
                        </h3>
                        <p style="color: #666; margin-bottom: 1rem;">
                            <?php echo wp_trim_words( get_the_excerpt(), 15 ); ?>
                        </p>
                        <a href="<?php the_permalink(); ?>" class="ci-btn-primary">
                            Ver Receita
                        </a>
                    </div>
                </article>
            <?php endwhile; ?>
        </div>
        <?php
        wp_reset_postdata();
    else :
        ?>
        <p style="text-align: center; font-size: 1.2rem; color: #666;">
            Nenhuma receita encontrada. Comece adicionando sua primeira receita!
        </p>
        <?php
    endif;
    ?>

</div>

<!-- SEÇÃO SOBRE -->
<section style="background: linear-gradient(135deg, #9ACD32 0%, #7BA428 100%); padding: 4rem 1rem; margin-top: 4rem;">
    <div style="max-width: 800px; margin: 0 auto; text-align: center; color: white;">
        <h2 style="font-size: 2.5rem; margin-bottom: 1.5rem; font-family: var(--font-headings);">
            O Que é Upcycling Culinário?
        </h2>
        <p style="font-size: 1.2rem; line-height: 1.8; margin-bottom: 2rem;">
            É a arte de transformar sobras, cascas, talos e ingredientes esquecidos em pratos incríveis. 
            Menos desperdício, mais criatividade, economia e sustentabilidade na sua cozinha.
        </p>
        <a href="<?php echo home_url( '/sobre/' ); ?>" class="hero-btn">
            Saiba Mais
        </a>
    </div>
</section>

<?php
get_footer();
?>
