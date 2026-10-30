<?php
/**
 * Custom Post Types: Técnicas e Guias
 * Consolidado a partir das versões 01, 03, 5, 6, 168 e (1).
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Registra os Custom Post Types do projeto Cozinha Inventiva
 */
function ci_register_custom_post_types() {

    // 1. CPT: TÉCNICAS (Focado em métodos de conservação e preparo)
    $tecnica_labels = array(
        'name'                  => _x( 'Técnicas', 'Post Type General Name', 'cozinha-inventiva' ),
        'singular_name'         => _x( 'Técnica', 'Post Type Singular Name', 'cozinha-inventiva' ),
        'menu_name'             => __( 'Técnicas Upcycling', 'cozinha-inventiva' ),
        'add_new'               => __( 'Adicionar Nova', 'cozinha-inventiva' ),
        'add_new_item'          => __( 'Adicionar Nova Técnica', 'cozinha-inventiva' ),
        'edit_item'             => __( 'Editar Técnica', 'cozinha-inventiva' ),
        'all_items'             => __( 'Todas as Técnicas', 'cozinha-inventiva' ),
        'view_item'             => __( 'Ver Técnica', 'cozinha-inventiva' ),
    );

    $tecnica_args = array(
        'labels'             => $tecnica_labels,
        'public'             => true,
        'has_archive'        => 'tecnicas',
        'menu_icon'          => 'dashicons-lightbulb', // Ícone de ideia/lâmpada (versão 01/168)
        'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt', 'revisions', 'custom-fields' ),
        'show_in_rest'       => true, // Essencial para suporte ao editor Gutenberg
        'rewrite'            => array( 'slug' => 'tecnicas' ),
        'capability_type'    => 'post',
    );
    register_post_type( 'ci_tecnica', $tecnica_args );

    // 2. CPT: GUIAS (Focado em manuais completos de ingredientes específicos)
    $guia_labels = array(
        'name'                  => _x( 'Guias', 'Post Type General Name', 'cozinha-inventiva' ),
        'singular_name'         => _x( 'Guia', 'Post Type Singular Name', 'cozinha-inventiva' ),
        'menu_name'             => __( 'Guias de Aproveitamento', 'cozinha-inventiva' ),
        'add_new_item'          => __( 'Adicionar Novo Guia', 'cozinha-inventiva' ),
        'all_items'             => __( 'Todos os Guias', 'cozinha-inventiva' ),
    );

    $guia_args = array(
        'labels'             => $guia_labels,
        'public'             => true,
        'has_archive'        => 'guias',
        'menu_icon'          => 'dashicons-book-alt', // Ícone de livro (versão (1))
        'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments', 'revisions' ),
        'show_in_rest'       => true,
        'rewrite'            => array( 'slug' => 'guias' ),
    );
    register_post_type( 'ci_guia', $guia_args );
}
add_action( 'init', 'ci_register_custom_post_types' );

/**
 * Melhoria de UX: Adiciona a coluna de Imagem Destacada no Admin
 * (Aproveitado do arquivo custom-post-types168.php)
 */
function ci_set_tecnica_columns($columns) {
    $new_columns = array();
    foreach($columns as $key => $value) {
        if ($key === 'title') {
            $new_columns['ci_post_thumbs'] = __('Imagem', 'cozinha-inventiva');
        }
        $new_columns[$key] = $value;
    }
    return $new_columns;
}

function ci_custom_tecnica_columns( $column, $post_id ) {
    if ( $column === 'ci_post_thumbs' ) {
        if ( has_post_thumbnail( $post_id ) ) {
            echo get_the_post_thumbnail( $post_id, array( 50, 50 ) );
        } else {
            echo '—';
        }
    }
}
add_filter( 'manage_ci_tecnica_posts_columns', 'ci_set_tecnica_columns' );
add_action( 'manage_ci_tecnica_posts_custom_column' , 'ci_custom_tecnica_columns', 10, 2 );
add_filter( 'manage_ci_guia_posts_columns', 'ci_set_tecnica_columns' );
add_action( 'manage_ci_guia_posts_custom_column' , 'ci_custom_tecnica_columns', 10, 2 );