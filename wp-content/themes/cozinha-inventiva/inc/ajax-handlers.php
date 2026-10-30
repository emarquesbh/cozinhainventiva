<?php
/**
 * AJAX Handlers
 *
 * @package Cozinha_Inventiva
 * @since 1.0.0
 * 
 * Arquivo: /inc/ajax-handlers.php
 * Localização: inc/ajax-handlers.php
 * Linhas: 155
 * 
 * FUNÇÃO: Handlers AJAX para funcionalidades dinâmicas do tema:
 * - ci_ajax_search() - Busca ao vivo (live search) de receitas
 * - ci_ajax_filter_recipes() - Filtrar receitas por taxonomia/tipo
 * - ci_ajax_save_favorite() - Salvar receita como favorita (localStorage)
 * - Validação de nonce para segurança
 * - Retorna JSON para JavaScript processar
 */


if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * 1. BUSCA AVANÇADA POR INGREDIENTES (Upcycling Search)
 * Permite encontrar receitas com base no que o usuário tem na geladeira.
 */
function ci_ajax_search_by_ingredients() {
    check_ajax_referer( 'ci_ajax_nonce', 'nonce' );
    
    $ingredients = isset( $_POST['ingredients'] ) ? array_map( 'sanitize_text_field', $_POST['ingredients'] ) : array();
    $exact_match = isset( $_POST['exact_match'] ) && $_POST['exact_match'] === 'true';
    
    if ( empty( $ingredients ) || count( $ingredients ) < 1 ) {
        wp_send_json_error( 'Adicione pelo menos um ingrediente para transformar!' );
    }
    
    $args = array(
        'post_type'      => 'wprm_recipe',
        'posts_per_page' => 20,
        'post_status'    => 'publish',
        // A busca usa os termos para filtrar no conteúdo e títulos
        's'              => implode( ' ', $ingredients ), 
    );
    
    $query = new WP_Query( $args );
    $results = array();
    
    if ( $query->have_posts() ) {
        while ( $query->have_posts() ) {
            $query->the_post();
            $results[] = array(
                'id'        => get_the_ID(),
                'title'     => get_the_title(),
                'url'       => get_permalink(),
                'thumbnail' => get_the_post_thumbnail_url( get_the_ID(), 'medium' ),
                'impacto'   => get_field( 'ci_lixo_evitado' ) . 'g evitados', // Integração com ACF
            );
        }
        wp_reset_postdata();
    }
    
    wp_send_json_success( array( 'recipes' => $results ) );
}
add_action( 'wp_ajax_ci_search_ingredients', 'ci_ajax_search_by_ingredients' );
add_action( 'wp_ajax_nopriv_ci_search_ingredients', 'ci_ajax_search_by_ingredients' );

/**
 * 2. FAVORITOS (Salvar para depois)
 */
function ci_ajax_toggle_favorite() {
    check_ajax_referer( 'ci_ajax_nonce', 'nonce' );
    $recipe_id = isset($_POST['recipe_id']) ? intval($_POST['recipe_id']) : 0;
    
    // Lógica para salvar em User Meta ou Cookie/LocalStorage via JS
    wp_send_json_success( array( 'message' => 'Lista de desejos atualizada!' ) );
}
add_action( 'wp_ajax_ci_toggle_favorite', 'ci_ajax_toggle_favorite' );
add_action( 'wp_ajax_nopriv_ci_toggle_favorite', 'ci_ajax_toggle_favorite' );

/**
 * 3. SUBMISSÃO DE RECEITAS PELO USUÁRIO
 * Fomenta a comunidade de upcycling permitindo que leitores enviem suas ideias.
 */
function ci_ajax_submit_user_recipe() {
    check_ajax_referer( 'ci_ajax_nonce', 'nonce' );
    
    $title = sanitize_text_field( $_POST['recipe_title'] );
    $content = wp_kses_post( $_POST['recipe_content'] );
    
    $post_id = wp_insert_post( array(
        'post_title'   => $title,
        'post_content' => $content,
        'post_type'    => 'wprm_recipe',
        'post_status'  => 'pending', // Para revisão do admin
    ) );
    
    if ( ! is_wp_error( $post_id ) ) {
        wp_send_json_success( array( 'message' => 'Sua ideia de upcycling foi enviada para revisão!' ) );
    } else {
        wp_send_json_error( 'Erro ao processar envio.' );
    }
}
add_action( 'wp_ajax_ci_submit_recipe', 'ci_ajax_submit_user_recipe' );
add_action( 'wp_ajax_nopriv_ci_submit_recipe', 'ci_ajax_submit_user_recipe' );