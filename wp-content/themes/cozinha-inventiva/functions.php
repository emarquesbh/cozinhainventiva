<?php
/**
 * Cozinha Inventiva - Functions and definitions
 *
 * @package Cozinha_Inventiva
 * @since 1.0.0
 * 
 * Arquivo: /functions.php
 * Localização: Raiz do tema
 * Linhas: 483
 * 
 * FUNÇÃO: Arquivo principal de configuração do tema. Registra suporte a recursos do WordPress
 * (thumbnails, menus, HTML5), define constantes, enfileira CSS/JS, registra sidebars/widgets,
 * inclui arquivos de funcionalidades (CPTs, taxonomias, AJAX) e configura funções auxiliares.
 */

// ARQUIVO 2/42 - FUNCTIONS.PHP
// Localização: /functions.php
// Linhas: 483

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Define constantes do tema
 */
define('COZINHA_INVENTIVA_VERSION', '1.0.0');
define('COZINHA_INVENTIVA_THEME_DIR', get_template_directory());
define('COZINHA_INVENTIVA_THEME_URI', get_template_directory_uri());

/**
 * Configuração do tema
 */
function cozinha_inventiva_setup() {
    // Suporte a tradução
    load_theme_textdomain('cozinha-inventiva', COZINHA_INVENTIVA_THEME_DIR . '/languages');
    
    // Suporte a feeds automáticos
    add_theme_support('automatic-feed-links');
    
    // Suporte a title tag gerenciado pelo WordPress
    add_theme_support('title-tag');
    
    // Suporte a imagens destacadas
    add_theme_support('post-thumbnails');
    
    // Tamanhos de imagem customizados
    add_image_size('recipe-card', 400, 300, true);
    add_image_size('recipe-featured', 1200, 600, true);
    add_image_size('recipe-thumbnail', 150, 150, true);
    add_image_size('hero-image', 1920, 800, true);
    
    // Suporte a HTML5
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script'
    ));
    
    // Suporte a logo customizado
    add_theme_support('custom-logo', array(
        'height'      => 100,
        'width'       => 400,
        'flex-height' => true,
        'flex-width'  => true,
    ));
    
    // Suporte a refresh seletivo para widgets
    add_theme_support('customize-selective-refresh-widgets');
    
    // Registrar menus de navegação
    register_nav_menus(array(
        'primary' => __('Menu Principal', 'cozinha-inventiva'),
        'footer'  => __('Menu Rodapé', 'cozinha-inventiva'),
    ));
    
    // Suporte a editor de blocos
    add_theme_support('wp-block-styles');
    add_theme_support('align-wide');
    add_theme_support('responsive-embeds');
}
add_action('after_setup_theme', 'cozinha_inventiva_setup');

/**
 * Definir largura de conteúdo
 */
function cozinha_inventiva_content_width() {
    $GLOBALS['content_width'] = apply_filters('cozinha_inventiva_content_width', 1200);
}
add_action('after_setup_theme', 'cozinha_inventiva_content_width', 0);

/**
 * Registrar áreas de widgets
 */
function cozinha_inventiva_widgets_init() {
    register_sidebar(array(
        'name'          => __('Sidebar Principal', 'cozinha-inventiva'),
        'id'            => 'sidebar-1',
        'description'   => __('Widgets da sidebar principal', 'cozinha-inventiva'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
    
    register_sidebar(array(
        'name'          => __('Footer - Coluna 1', 'cozinha-inventiva'),
        'id'            => 'footer-1',
        'description'   => __('Primeira coluna do rodapé', 'cozinha-inventiva'),
        'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="footer-widget-title">',
        'after_title'   => '</h3>',
    ));
    
    register_sidebar(array(
        'name'          => __('Footer - Coluna 2', 'cozinha-inventiva'),
        'id'            => 'footer-2',
        'description'   => __('Segunda coluna do rodapé', 'cozinha-inventiva'),
        'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="footer-widget-title">',
        'after_title'   => '</h3>',
    ));
    
    register_sidebar(array(
        'name'          => __('Footer - Coluna 3', 'cozinha-inventiva'),
        'id'            => 'footer-3',
        'description'   => __('Terceira coluna do rodapé', 'cozinha-inventiva'),
        'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="footer-widget-title">',
        'after_title'   => '</h3>',
    ));
    
    register_sidebar(array(
        'name'          => __('Footer - Coluna 4', 'cozinha-inventiva'),
        'id'            => 'footer-4',
        'description'   => __('Quarta coluna do rodapé', 'cozinha-inventiva'),
        'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="footer-widget-title">',
        'after_title'   => '</h3>',
    ));
}
add_action('widgets_init', 'cozinha_inventiva_widgets_init');

/**
 * Enfileirar scripts e estilos
 */
function cozinha_inventiva_scripts() {
    // Google Fonts
    wp_enqueue_style(
        'cozinha-inventiva-fonts',
        'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Poppins:wght@600;700;800&display=swap',
        array(),
        null
    );
    
    // Style principal
    wp_enqueue_style(
        'cozinha-inventiva-style',
        get_stylesheet_uri(),
        array(),
        COZINHA_INVENTIVA_VERSION
    );
    
    // CSS customizado
    wp_enqueue_style(
        'cozinha-inventiva-custom',
        COZINHA_INVENTIVA_THEME_URI . '/assets/css/custom.css',
        array('cozinha-inventiva-style'),
        COZINHA_INVENTIVA_VERSION
    );
    
    // CSS de busca
    wp_enqueue_style(
        'cozinha-inventiva-search',
        COZINHA_INVENTIVA_THEME_URI . '/assets/css/search.css',
        array('cozinha-inventiva-style'),
        COZINHA_INVENTIVA_VERSION
    );
    
    // CSS de parallax
    wp_enqueue_style(
        'cozinha-inventiva-parallax',
        COZINHA_INVENTIVA_THEME_URI . '/assets/css/parallax.css',
        array('cozinha-inventiva-style'),
        COZINHA_INVENTIVA_VERSION
    );
    
    // JavaScript principal
    wp_enqueue_script(
        'cozinha-inventiva-main',
        COZINHA_INVENTIVA_THEME_URI . '/assets/js/main.js',
        array('jquery'),
        COZINHA_INVENTIVA_VERSION,
        true
    );
    
    // JavaScript de busca
    wp_enqueue_script(
        'cozinha-inventiva-search',
        COZINHA_INVENTIVA_THEME_URI . '/assets/js/search.js',
        array('jquery'),
        COZINHA_INVENTIVA_VERSION,
        true
    );
    
    // JavaScript de parallax
    wp_enqueue_script(
        'cozinha-inventiva-parallax',
        COZINHA_INVENTIVA_THEME_URI . '/assets/js/parallax.js',
        array('jquery'),
        COZINHA_INVENTIVA_VERSION,
        true
    );
    
    // Localizar scripts para AJAX
    wp_localize_script('cozinha-inventiva-search', 'cozinhaInventiva', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce'   => wp_create_nonce('cozinha-inventiva-nonce'),
    ));
    
    // Script de comentários se necessário
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'cozinha_inventiva_scripts');

/**
 * Enfileirar scripts e estilos do admin
 */
function cozinha_inventiva_admin_scripts($hook) {
    // CSS do admin
    wp_enqueue_style(
        'cozinha-inventiva-admin',
        COZINHA_INVENTIVA_THEME_URI . '/assets/css/admin.css',
        array(),
        COZINHA_INVENTIVA_VERSION
    );
    
    // JS do admin
    wp_enqueue_script(
        'cozinha-inventiva-admin',
        COZINHA_INVENTIVA_THEME_URI . '/assets/js/admin.js',
        array('jquery'),
        COZINHA_INVENTIVA_VERSION,
        true
    );
}
add_action('admin_enqueue_scripts', 'cozinha_inventiva_admin_scripts');

/**
 * Incluir arquivos necessários
 */


// Custom Post Types
$custom_post_types_file = get_stylesheet_directory() . '/inc/custom-post-types.php';
if (file_exists($custom_post_types_file)) {
    require_once $custom_post_types_file;
} else {
    error_log('Cozinha Inventiva: Arquivo custom-post-types.php não encontrado em ' . $custom_post_types_file);
}

// Taxonomias
require_once COZINHA_INVENTIVA_THEME_DIR . '/inc/taxonomies.php';

// Funções de template
require_once COZINHA_INVENTIVA_THEME_DIR . '/inc/template-functions.php';

// AJAX Handlers
require_once COZINHA_INVENTIVA_THEME_DIR . '/inc/ajax-handlers.php';

// ACF Fields (se ACF estiver ativo)
if (function_exists('acf_add_local_field_group')) {
    require_once COZINHA_INVENTIVA_THEME_DIR . '/inc/acf-fields.php';
}

// Widgets customizados
require_once COZINHA_INVENTIVA_THEME_DIR . '/inc/widgets.php';

/**
 * Adicionar classes ao body
 */
function cozinha_inventiva_body_classes($classes) {
    // Adiciona classe quando não há sidebar
    if (!is_active_sidebar('sidebar-1')) {
        $classes[] = 'no-sidebar';
    }
    
    // Adiciona classe para singular
    if (is_singular()) {
        $classes[] = 'singular';
    }
    
    return $classes;
}
add_filter('body_class', 'cozinha_inventiva_body_classes');

/**
 * Customizar excerpt
 */
function cozinha_inventiva_excerpt_length($length) {
    return 30;
}
add_filter('excerpt_length', 'cozinha_inventiva_excerpt_length');

function cozinha_inventiva_excerpt_more($more) {
    return '...';
}
add_filter('excerpt_more', 'cozinha_inventiva_excerpt_more');

/**
 * Adicionar suporte a SVG upload
 */
function cozinha_inventiva_mime_types($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'cozinha_inventiva_mime_types');

/**
 * Sanitizar SVG upload
 */
function cozinha_inventiva_check_svg($file) {
    if ($file['type'] === 'image/svg+xml') {
        $svg_content = file_get_contents($file['tmp_name']);
        if ($svg_content === false || strpos($svg_content, '<script') !== false) {
            $file['error'] = __('SVG inválido ou contém scripts.', 'cozinha-inventiva');
        }
    }
    return $file;
}
add_filter('wp_check_filetype_and_ext', 'cozinha_inventiva_check_svg', 10, 4);

/**
 * Adicionar meta tags
 */
function cozinha_inventiva_meta_tags() {
    ?>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5">
    <meta name="theme-color" content="#48bb78">
    <?php
}
add_action('wp_head', 'cozinha_inventiva_meta_tags', 1);

/**
 * Remover versão do WordPress do header
 */
remove_action('wp_head', 'wp_generator');

/**
 * Otimizar carregamento de emoji
 */
function cozinha_inventiva_disable_emojis() {
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_styles', 'print_emoji_styles');
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
}
add_action('init', 'cozinha_inventiva_disable_emojis');

/**
 * Customizar login do WordPress
 */
function cozinha_inventiva_login_logo() {
    if (has_custom_logo()) {
        $custom_logo_id = get_theme_mod('custom_logo');
        $logo = wp_get_attachment_image_src($custom_logo_id, 'full');
        ?>
        <style type="text/css">
            #login h1 a,
            .login h1 a {
                background-image: url(<?php echo esc_url($logo[0]); ?>);
                height: 80px;
                width: 320px;
                background-size: contain;
                background-repeat: no-repeat;
                padding-bottom: 30px;
            }
        </style>
        <?php
    }
}
add_action('login_enqueue_scripts', 'cozinha_inventiva_login_logo');

function cozinha_inventiva_login_logo_url() {
    return home_url();
}
add_filter('login_headerurl', 'cozinha_inventiva_login_logo_url');

function cozinha_inventiva_login_logo_url_title() {
    return get_bloginfo('name');
}
add_filter('login_headertext', 'cozinha_inventiva_login_logo_url_title');

/**
 * Adicionar suporte a paginação
 */
function cozinha_inventiva_pagination() {
    global $wp_query;
    
    if ($wp_query->max_num_pages <= 1) {
        return;
    }
    
    $paged = get_query_var('paged') ? absint(get_query_var('paged')) : 1;
    $max   = intval($wp_query->max_num_pages);
    
    if ($paged >= 1) {
        $links[] = $paged;
    }
    
    if ($paged >= 3) {
        $links[] = $paged - 1;
        $links[] = $paged - 2;
    }
    
    if (($paged + 2) <= $max) {
        $links[] = $paged + 2;
        $links[] = $paged + 1;
    }
    
    echo '<nav class="pagination" role="navigation">';
    echo '<div class="pagination-wrapper">';
    
    if (get_previous_posts_link()) {
        printf('<div class="pagination-previous">%s</div>', get_previous_posts_link(__('← Anterior', 'cozinha-inventiva')));
    }
    
    echo '<ul class="pagination-list">';
    
    if (!in_array(1, $links)) {
        $class = 1 == $paged ? ' class="current"' : '';
        printf('<li%s><a href="%s">%s</a></li>', $class, esc_url(get_pagenum_link(1)), '1');
        
        if (!in_array(2, $links)) {
            echo '<li class="pagination-ellipsis">…</li>';
        }
    }
    
    sort($links);
    foreach ((array) $links as $link) {
        $class = $paged == $link ? ' class="current"' : '';
        printf('<li%s><a href="%s">%s</a></li>', $class, esc_url(get_pagenum_link($link)), $link);
    }
    
    if (!in_array($max, $links)) {
        if (!in_array($max - 1, $links)) {
            echo '<li class="pagination-ellipsis">…</li>';
        }
        
        $class = $paged == $max ? ' class="current"' : '';
        printf('<li%s><a href="%s">%s</a></li>', $class, esc_url(get_pagenum_link($max)), $max);
    }
    
    echo '</ul>';
    
    if (get_next_posts_link()) {
        printf('<div class="pagination-next">%s</div>', get_next_posts_link(__('Próximo →', 'cozinha-inventiva')));
    }
    
    echo '</div>';
    echo '</nav>';
}

/**
 * Função para debug (remover em produção)
 */
if (!function_exists('ci_debug')) {
    function ci_debug($data, $die = false) {
        if (defined('WP_DEBUG') && WP_DEBUG) {
            echo '<pre>';
            print_r($data);
            echo '</pre>';
            if ($die) {
                die();
            }
        }
    }
}

// Fim do arquivo functions.php - Linha 483
