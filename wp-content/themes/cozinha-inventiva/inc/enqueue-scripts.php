<?php
/**
 * Enqueue Scripts and Styles
 *
 * @package Cozinha_Inventiva
 * @since 1.0.0
 * 
 * Arquivo: /inc/enqueue-scripts.php
 * Localização: inc/enqueue-scripts.php
 * Linhas: 145
 * 
 * FUNÇÃO: Enfileirar (enqueue) todos os CSS e JS do tema de forma organizada:
 * - style.css principal
 * - custom.css, search.css, parallax.css, admin.css, cook-mode.css
 * - main.js, search.js, parallax.js, admin.js, cook-mode.js
 * - Dependências corretas (jQuery)
 * - Localização de scripts (wp_localize_script)
 * - Conditional loading (admin, cook-mode)
 */

// ARQUIVO 41/42 - ENQUEUE-SCRIPTS.PHP
// Localização: /inc/enqueue-scripts.php
// Linhas: 145

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Enfileirar scripts e styles do front-end
 */
function cozinha_inventiva_enqueue_scripts() {
    // CSS Principal
    wp_enqueue_style(
        'cozinha-inventiva-style',
        get_stylesheet_uri(),
        array(),
        COZINHA_INVENTIVA_VERSION
    );

    // Custom CSS
    wp_enqueue_style(
        'cozinha-inventiva-custom',
        COZINHA_INVENTIVA_THEME_URI . '/assets/css/custom.css',
        array('cozinha-inventiva-style'),
        COZINHA_INVENTIVA_VERSION
    );

    // Search CSS
    wp_enqueue_style(
        'cozinha-inventiva-search',
        COZINHA_INVENTIVA_THEME_URI . '/assets/css/search.css',
        array(),
        COZINHA_INVENTIVA_VERSION
    );

    // Parallax CSS
    wp_enqueue_style(
        'cozinha-inventiva-parallax',
        COZINHA_INVENTIVA_THEME_URI . '/assets/css/parallax.css',
        array(),
        COZINHA_INVENTIVA_VERSION
    );

    // Cook Mode CSS (apenas no template cook-mode)
    if (is_page_template('Templates/Pages/cook-mode.php')) {
        wp_enqueue_style(
            'cozinha-inventiva-cook-mode',
            COZINHA_INVENTIVA_THEME_URI . '/assets/css/cook-mode.css',
            array(),
            COZINHA_INVENTIVA_VERSION
        );
    }

    // jQuery (já incluso no WordPress)
    wp_enqueue_script('jquery');

    // Main JavaScript
    wp_enqueue_script(
        'cozinha-inventiva-main',
        COZINHA_INVENTIVA_THEME_URI . '/assets/js/main.js',
        array('jquery'),
        COZINHA_INVENTIVA_VERSION,
        true
    );

    // Search JavaScript
    wp_enqueue_script(
        'cozinha-inventiva-search',
        COZINHA_INVENTIVA_THEME_URI . '/assets/js/search.js',
        array('jquery'),
        COZINHA_INVENTIVA_VERSION,
        true
    );

    // Parallax JavaScript
    wp_enqueue_script(
        'cozinha-inventiva-parallax',
        COZINHA_INVENTIVA_THEME_URI . '/assets/js/parallax.js',
        array(),
        COZINHA_INVENTIVA_VERSION,
        true
    );

    // Cook Mode JavaScript (apenas no template cook-mode)
    if (is_page_template('Templates/Pages/cook-mode.php')) {
        wp_enqueue_script(
            'cozinha-inventiva-cook-mode',
            COZINHA_INVENTIVA_THEME_URI . '/assets/js/cook-mode.js',
            array(),
            COZINHA_INVENTIVA_VERSION,
            true
        );
    }

    // Localizar scripts com dados do WordPress
    wp_localize_script(
        'cozinha-inventiva-main',
        'cozinhaInventivaData',
        array(
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'nonce'   => wp_create_nonce('cozinha-inventiva-nonce'),
            'homeUrl' => home_url('/'),
            'themeUrl' => get_template_directory_uri(),
        )
    );

    // Comment reply script
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'cozinha_inventiva_enqueue_scripts');

/**
 * Enfileirar scripts e styles do admin
 */
function cozinha_inventiva_enqueue_admin_scripts($hook) {
    // Admin CSS
    wp_enqueue_style(
        'cozinha-inventiva-admin',
        COZINHA_INVENTIVA_THEME_URI . '/assets/css/admin.css',
        array(),
        COZINHA_INVENTIVA_VERSION
    );

    // Admin JavaScript
    wp_enqueue_script(
        'cozinha-inventiva-admin',
        COZINHA_INVENTIVA_THEME_URI . '/assets/js/admin.js',
        array('jquery'),
        COZINHA_INVENTIVA_VERSION,
        true
    );

    // Color Picker (WordPress built-in)
    wp_enqueue_style('wp-color-picker');
    wp_enqueue_script('wp-color-picker');

    // Media Uploader
    wp_enqueue_media();
}
add_action('admin_enqueue_scripts', 'cozinha_inventiva_enqueue_admin_scripts');

/**
 * Adicionar preconnect para Google Fonts
 */
function cozinha_inventiva_resource_hints($urls, $relation_type) {
    if ('preconnect' === $relation_type) {
        $urls[] = array(
            'href' => 'https://fonts.googleapis.com',
            'crossorigin',
        );
        $urls[] = array(
            'href' => 'https://fonts.gstatic.com',
            'crossorigin',
        );
    }
    return $urls;
}
add_filter('wp_resource_hints', 'cozinha_inventiva_resource_hints', 10, 2);

// Fim do arquivo enqueue-scripts.php - Linha 145
