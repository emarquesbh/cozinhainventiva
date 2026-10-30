<?php
/**
 * Header do tema Cozinha Inventiva
 *
 * @package Cozinha_Inventiva
 * @since 1.0.0
 * 
 * Arquivo: /header.php
 * Localização: Raiz do tema
 * Linhas: 145
 * 
 * FUNÇÃO: Cabeçalho HTML do tema. Contém DOCTYPE, meta tags, wp_head(), logo/branding,
 * menu de navegação principal com fallback, botão mobile, modal de busca avançada com
 * sugestões e ícones SVG.
 */

// ARQUIVO 3/42 - HEADER.PHP
// Localização: /header.php
// Linhas: 145

if (!defined('ABSPATH')) {
    exit;
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site-wrapper">
    <a class="skip-link screen-reader-text" href="#content">
        <?php esc_html_e('Pular para o conteúdo', 'cozinha-inventiva'); ?>
    </a>

    <header id="masthead" class="site-header">
        <div class="header-inner container-wide">
            <div class="site-branding">
                <?php
                if (has_custom_logo()) {
                    the_custom_logo();
                } else {
                    ?>
                    <h1 class="site-title">
                        <a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
                            <?php bloginfo('name'); ?>
                        </a>
                    </h1>
                    <?php
                    $description = get_bloginfo('description', 'display');
                    if ($description || is_customize_preview()) {
                        ?>
                        <p class="site-description"><?php echo $description; ?></p>
                        <?php
                    }
                }
                ?>
            </div>

            <button class="mobile-menu-toggle" aria-controls="primary-menu" aria-expanded="false">
                <span class="screen-reader-text"><?php esc_html_e('Menu', 'cozinha-inventiva'); ?></span>
                <span class="menu-icon">☰</span>
            </button>

            <nav id="site-navigation" class="main-navigation">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'primary',
                    'menu_id'        => 'primary-menu',
                    'menu_class'     => 'primary-menu-list',
                    'container'      => false,
                    'fallback_cb'    => function() {
                        echo '<ul class="primary-menu-list">';
                        echo '<li><a href="' . esc_url(home_url('/')) . '">' . esc_html__('Início', 'cozinha-inventiva') . '</a></li>';
                        echo '<li><a href="' . esc_url(home_url('/receitas')) . '">' . esc_html__('Receitas', 'cozinha-inventiva') . '</a></li>';
                        echo '<li><a href="' . esc_url(home_url('/tecnicas')) . '">' . esc_html__('Técnicas', 'cozinha-inventiva') . '</a></li>';
                        echo '<li><a href="' . esc_url(home_url('/guias')) . '">' . esc_html__('Guias', 'cozinha-inventiva') . '</a></li>';
                        echo '<li><a href="' . esc_url(home_url('/sobre')) . '">' . esc_html__('Sobre', 'cozinha-inventiva') . '</a></li>';
                        echo '<li><a href="' . esc_url(home_url('/contato')) . '">' . esc_html__('Contato', 'cozinha-inventiva') . '</a></li>';
                        echo '</ul>';
                    }
                ));
                ?>
                
                <div class="header-search">
                    <button class="search-toggle" aria-label="<?php esc_attr_e('Abrir busca', 'cozinha-inventiva'); ?>">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9 17C13.4183 17 17 13.4183 17 9C17 4.58172 13.4183 1 9 1C4.58172 1 1 4.58172 1 9C1 13.4183 4.58172 17 9 17Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M19 19L14.65 14.65" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                </div>
            </nav>
        </div>

        <div class="search-modal" id="searchModal" style="display: none;">
            <div class="search-modal-overlay"></div>
            <div class="search-modal-content">
                <button class="search-modal-close" aria-label="<?php esc_attr_e('Fechar busca', 'cozinha-inventiva'); ?>">
                    <span aria-hidden="true">×</span>
                </button>
                
                <div class="search-modal-inner">
                    <h2 class="search-modal-title"><?php esc_html_e('O que você quer cozinhar hoje?', 'cozinha-inventiva'); ?></h2>
                    
                    <form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
                        <div class="search-input-wrapper">
                            <input 
                                type="search" 
                                class="search-field" 
                                placeholder="<?php esc_attr_e('Buscar receitas, ingredientes, técnicas...', 'cozinha-inventiva'); ?>" 
                                value="<?php echo get_search_query(); ?>" 
                                name="s" 
                                id="search-input"
                                autocomplete="off"
                            />
                            <button type="submit" class="search-submit">
                                <span class="screen-reader-text"><?php esc_html_e('Buscar', 'cozinha-inventiva'); ?></span>
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path d="M11 19C15.4183 19 19 15.4183 19 11C19 6.58172 15.4183 3 11 3C6.58172 3 3 6.58172 3 11C3 15.4183 6.58172 19 11 19Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M21 21L16.65 16.65" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </button>
                        </div>
                    </form>
                    
                    <div class="search-suggestions">
                        <h3><?php esc_html_e('Sugestões populares:', 'cozinha-inventiva'); ?></h3>
                        <div class="search-tags">
                            <a href="<?php echo esc_url(home_url('/?s=cascas')); ?>" class="search-tag">Cascas de frutas</a>
                            <a href="<?php echo esc_url(home_url('/?s=talos')); ?>" class="search-tag">Talos</a>
                            <a href="<?php echo esc_url(home_url('/?s=sobras')); ?>" class="search-tag">Sobras</a>
                            <a href="<?php echo esc_url(home_url('/?s=fermenta%C3%A7%C3%A3o')); ?>" class="search-tag">Fermentação</a>
                            <a href="<?php echo esc_url(home_url('/?s=caldos')); ?>" class="search-tag">Caldos</a>
                        </div>
                    </div>
                    
                    <div id="search-results-live" class="search-results-live"></div>
                </div>
            </div>
        </div>
    </header>

    <main id="content" class="site-content">
