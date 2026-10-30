<?php
/**
 * Template part para hero section com parallax
 *
 * @package Cozinha_Inventiva
 * @since 1.0.0
 * 
 * Arquivo: /template-parts/hero-section.php
 * Localização: template-parts/hero-section.php
 * Linhas: 80
 * 
 * FUNÇÃO: Hero section com efeito parallax de rolagem. Componente reutilizável que exibe
 * imagem de fundo com data-parallax-speed para efeito parallax, overlay com gradiente verde,
 * título principal "Transformando Sobras em Sabor", subtítulo com chamada e botões CTA.
 * 
 * COMO FUNCIONA O PARALLAX:
 * 1. Este arquivo define HTML com data-parallax-speed="0.5"
 * 2. CSS em /assets/css/parallax.css estiliza o efeito
 * 3. JavaScript em /assets/js/parallax.js anima o scroll
 * 
 * A classe "parallax-bg" é capturada pelo JS que aplica transform: translateY() baseado
 * no scroll da página, criando movimento diferenciado da imagem de fundo.
 */

// ARQUIVO 18/42 - HERO-SECTION.PHP
// Localização: /template-parts/hero-section.php
// Linhas: 80

if (!defined('ABSPATH')) {
    exit;
}

// Pegar imagem do hero (pode ser customizada via ACF ou usar padrão)
$hero_image = get_field('hero_image', 'option');
if (!$hero_image) {
    $hero_image = COZINHA_INVENTIVA_THEME_URI . '/assets/images/hero-default.jpg';
} else {
    $hero_image = $hero_image['url'];
}
?>

<section class="hero-section">
    <!-- Imagem de fundo com parallax -->
    <div class="hero-background parallax-bg" 
         data-parallax-speed="0.5"
         style="background-image: url('<?php echo esc_url($hero_image); ?>');">
    </div>
    
    <!-- Overlay com gradiente -->
    <div class="hero-overlay"></div>
    
    <!-- Conteúdo do hero -->
    <div class="hero-content">
        <h1 class="hero-title">
            <?php esc_html_e('Transformando Sobras em Sabor', 'cozinha-inventiva'); ?>
        </h1>
        
        <p class="hero-subtitle">
            <?php esc_html_e('Descubra o poder do upcycling culinário e aprenda a criar pratos incríveis com ingredientes que você pensava em descartar', 'cozinha-inventiva'); ?>
        </p>
        
        <div class="hero-cta">
            <a href="<?php echo esc_url(get_post_type_archive_link('wprm_recipe')); ?>" class="btn btn-primary">
                <?php esc_html_e('Ver Receitas', 'cozinha-inventiva'); ?>
            </a>
            <a href="<?php echo esc_url(home_url('/tecnicas')); ?>" class="btn btn-secondary">
                <?php esc_html_e('Aprender Técnicas', 'cozinha-inventiva'); ?>
            </a>
        </div>
    </div>
</section>

<style>
/* Hero Section com Parallax */
.hero-section {
    position: relative;
    min-height: 600px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #ffffff;
    overflow: hidden;
}

/* Imagem de fundo com parallax - IMPORTANTE */
.hero-background {
    position: absolute;
    top: -50px;
    left: 0;
    width: 100%;
    height: calc(100% + 100px);
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    z-index: 0;
    will-change: transform;
}

/* Overlay gradiente */
.hero-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, rgba(72, 187, 120, 0.9) 0%, rgba(56, 161, 105, 0.8) 100%);
    z-index: 1;
}

/* Conteúdo do hero */
.hero-content {
    position: relative;
    z-index: 2;
    text-align: center;
    max-width: 800px;
    padding: 2rem;
}

.hero-title {
    font-size: 3.5rem;
    margin-bottom: 1.5rem;
    color: #ffffff;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    font-weight: 800;
}

.hero-subtitle {
    font-size: 1.25rem;
    margin-bottom: 2rem;
    color: #f7fafc;
    line-height: 1.8;
    text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
}

@media (max-width: 768px) {
    .hero-section {
        min-height: 500px;
    }
    
    .hero-title {
        font-size: 2.5rem;
    }
    
    .hero-subtitle {
        font-size: 1.125rem;
    }
    
    .hero-cta {
        flex-direction: column;
        gap: 1rem;
    }
}
</style>
