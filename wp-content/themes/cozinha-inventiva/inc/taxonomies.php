<?php
/**
 * Taxonomias Personalizadas
 *
 * @package Cozinha_Inventiva
 * @since 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Taxonomia: Tipo de Aproveitamento
 * Usado para categorizar receitas por tipo de sobra/ingrediente reaproveitado
 */
function ci_register_tipo_aproveitamento() {
    $labels = array(
        'name'                       => _x( 'Tipos de Aproveitamento', 'Taxonomy General Name', 'cozinha-inventiva' ),
        'singular_name'              => _x( 'Tipo de Aproveitamento', 'Taxonomy Singular Name', 'cozinha-inventiva' ),
        'menu_name'                  => __( 'Tipos de Aproveitamento', 'cozinha-inventiva' ),
        'all_items'                  => __( 'Todos os Tipos', 'cozinha-inventiva' ),
        'parent_item'                => __( 'Tipo Pai', 'cozinha-inventiva' ),
        'parent_item_colon'          => __( 'Tipo Pai:', 'cozinha-inventiva' ),
        'new_item_name'              => __( 'Novo Tipo', 'cozinha-inventiva' ),
        'add_new_item'               => __( 'Adicionar Novo Tipo', 'cozinha-inventiva' ),
        'edit_item'                  => __( 'Editar Tipo', 'cozinha-inventiva' ),
        'update_item'                => __( 'Atualizar Tipo', 'cozinha-inventiva' ),
        'view_item'                  => __( 'Ver Tipo', 'cozinha-inventiva' ),
        'separate_items_with_commas' => __( 'Separar tipos com vírgulas', 'cozinha-inventiva' ),
        'add_or_remove_items'        => __( 'Adicionar ou remover tipos', 'cozinha-inventiva' ),
        'choose_from_most_used'      => __( 'Escolher dos mais usados', 'cozinha-inventiva' ),
        'popular_items'              => __( 'Tipos Populares', 'cozinha-inventiva' ),
        'search_items'               => __( 'Buscar Tipos', 'cozinha-inventiva' ),
        'not_found'                  => __( 'Nenhum tipo encontrado', 'cozinha-inventiva' ),
    );
    
    $args = array(
        'labels'                     => $labels,
        'hierarchical'               => true,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => true,
        'show_in_rest'               => true,
        'rest_base'                  => 'tipos-aproveitamento',
        'rewrite'                    => array( 'slug' => 'aproveitamento' ),
    );
    
    register_taxonomy( 'tipo_aproveitamento', array( 'wprm_recipe' ), $args );
}
add_action( 'init', 'ci_register_tipo_aproveitamento', 0 );

/**
 * Taxonomia: Dificuldade
 */
function ci_register_dificuldade() {
    $labels = array(
        'name'                       => _x( 'Dificuldades', 'Taxonomy General Name', 'cozinha-inventiva' ),
        'singular_name'              => _x( 'Dificuldade', 'Taxonomy Singular Name', 'cozinha-inventiva' ),
        'menu_name'                  => __( 'Dificuldade', 'cozinha-inventiva' ),
        'all_items'                  => __( 'Todas as Dificuldades', 'cozinha-inventiva' ),
        'new_item_name'              => __( 'Nova Dificuldade', 'cozinha-inventiva' ),
        'add_new_item'               => __( 'Adicionar Nova Dificuldade', 'cozinha-inventiva' ),
        'edit_item'                  => __( 'Editar Dificuldade', 'cozinha-inventiva' ),
        'update_item'                => __( 'Atualizar Dificuldade', 'cozinha-inventiva' ),
        'view_item'                  => __( 'Ver Dificuldade', 'cozinha-inventiva' ),
        'popular_items'              => __( 'Dificuldades Populares', 'cozinha-inventiva' ),
        'search_items'               => __( 'Buscar Dificuldade', 'cozinha-inventiva' ),
        'not_found'                  => __( 'Nenhuma dificuldade encontrada', 'cozinha-inventiva' ),
    );
    
    $args = array(
        'labels'                     => $labels,
        'hierarchical'               => false,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => false,
        'show_in_rest'               => true,
        'rest_base'                  => 'dificuldade',
        'rewrite'                    => array( 'slug' => 'dificuldade' ),
    );
    
    register_taxonomy( 'dificuldade', array( 'wprm_recipe', 'ci_tecnica' ), $args );
}
add_action( 'init', 'ci_register_dificuldade', 0 );

/**
 * Taxonomia: Método de Preparo
 */
function ci_register_metodo_preparo() {
    $labels = array(
        'name'                       => _x( 'Métodos de Preparo', 'Taxonomy General Name', 'cozinha-inventiva' ),
        'singular_name'              => _x( 'Método de Preparo', 'Taxonomy Singular Name', 'cozinha-inventiva' ),
        'menu_name'                  => __( 'Métodos de Preparo', 'cozinha-inventiva' ),
        'all_items'                  => __( 'Todos os Métodos', 'cozinha-inventiva' ),
        'new_item_name'              => __( 'Novo Método', 'cozinha-inventiva' ),
        'add_new_item'               => __( 'Adicionar Novo Método', 'cozinha-inventiva' ),
        'edit_item'                  => __( 'Editar Método', 'cozinha-inventiva' ),
        'update_item'                => __( 'Atualizar Método', 'cozinha-inventiva' ),
        'view_item'                  => __( 'Ver Método', 'cozinha-inventiva' ),
        'popular_items'              => __( 'Métodos Populares', 'cozinha-inventiva' ),
        'search_items'               => __( 'Buscar Método', 'cozinha-inventiva' ),
        'not_found'                  => __( 'Nenhum método encontrado', 'cozinha-inventiva' ),
    );
    
    $args = array(
        'labels'                     => $labels,
        'hierarchical'               => false,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => true,
        'show_in_rest'               => true,
        'rest_base'                  => 'metodo-preparo',
        'rewrite'                    => array( 'slug' => 'metodo' ),
    );
    
    register_taxonomy( 'metodo_preparo', array( 'wprm_recipe' ), $args );
}
add_action( 'init', 'ci_register_metodo_preparo', 0 );

/**
 * Taxonomia: Dieta
 */
function ci_register_dieta() {
    $labels = array(
        'name'                       => _x( 'Dietas', 'Taxonomy General Name', 'cozinha-inventiva' ),
        'singular_name'              => _x( 'Dieta', 'Taxonomy Singular Name', 'cozinha-inventiva' ),
        'menu_name'                  => __( 'Dietas', 'cozinha-inventiva' ),
        'all_items'                  => __( 'Todas as Dietas', 'cozinha-inventiva' ),
        'new_item_name'              => __( 'Nova Dieta', 'cozinha-inventiva' ),
        'add_new_item'               => __( 'Adicionar Nova Dieta', 'cozinha-inventiva' ),
        'edit_item'                  => __( 'Editar Dieta', 'cozinha-inventiva' ),
        'update_item'                => __( 'Atualizar Dieta', 'cozinha-inventiva' ),
        'view_item'                  => __( 'Ver Dieta', 'cozinha-inventiva' ),
        'popular_items'              => __( 'Dietas Populares', 'cozinha-inventiva' ),
        'search_items'               => __( 'Buscar Dieta', 'cozinha-inventiva' ),
        'not_found'                  => __( 'Nenhuma dieta encontrada', 'cozinha-inventiva' ),
    );
    
    $args = array(
        'labels'                     => $labels,
        'hierarchical'               => false,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => true,
        'show_in_rest'               => true,
        'rest_base'                  => 'dieta',
        'rewrite'                    => array( 'slug' => 'dieta' ),
    );
    
    register_taxonomy( 'dieta', array( 'wprm_recipe' ), $args );
}
add_action( 'init', 'ci_register_dieta', 0 );

/**
 * Taxonomia: Ocasião
 */
function ci_register_ocasiao() {
    $labels = array(
        'name'                       => _x( 'Ocasiões', 'Taxonomy General Name', 'cozinha-inventiva' ),
        'singular_name'              => _x( 'Ocasião', 'Taxonomy Singular Name', 'cozinha-inventiva' ),
        'menu_name'                  => __( 'Ocasiões', 'cozinha-inventiva' ),
        'all_items'                  => __( 'Todas as Ocasiões', 'cozinha-inventiva' ),
        'new_item_name'              => __( 'Nova Ocasião', 'cozinha-inventiva' ),
        'add_new_item'               => __( 'Adicionar Nova Ocasião', 'cozinha-inventiva' ),
        'edit_item'                  => __( 'Editar Ocasião', 'cozinha-inventiva' ),
        'update_item'                => __( 'Atualizar Ocasião', 'cozinha-inventiva' ),
        'view_item'                  => __( 'Ver Ocasião', 'cozinha-inventiva' ),
        'popular_items'              => __( 'Ocasiões Populares', 'cozinha-inventiva' ),
        'search_items'               => __( 'Buscar Ocasião', 'cozinha-inventiva' ),
        'not_found'                  => __( 'Nenhuma ocasião encontrada', 'cozinha-inventiva' ),
    );
    
    $args = array(
        'labels'                     => $labels,
        'hierarchical'               => true,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => true,
        'show_in_rest'               => true,
        'rest_base'                  => 'ocasiao',
        'rewrite'                    => array( 'slug' => 'ocasiao' ),
    );
    
    register_taxonomy( 'ocasiao', array( 'wprm_recipe' ), $args );
}
add_action( 'init', 'ci_register_ocasiao', 0 );

/**
 * Taxonomia: Categoria de Técnica
 */
function ci_register_categoria_tecnica() {
    $labels = array(
        'name'                       => _x( 'Categorias de Técnica', 'Taxonomy General Name', 'cozinha-inventiva' ),
        'singular_name'              => _x( 'Categoria de Técnica', 'Taxonomy Singular Name', 'cozinha-inventiva' ),
        'menu_name'                  => __( 'Categorias', 'cozinha-inventiva' ),
        'all_items'                  => __( 'Todas as Categorias', 'cozinha-inventiva' ),
        'parent_item'                => __( 'Categoria Pai', 'cozinha-inventiva' ),
        'parent_item_colon'          => __( 'Categoria Pai:', 'cozinha-inventiva' ),
        'new_item_name'              => __( 'Nova Categoria', 'cozinha-inventiva' ),
        'add_new_item'               => __( 'Adicionar Nova Categoria', 'cozinha-inventiva' ),
        'edit_item'                  => __( 'Editar Categoria', 'cozinha-inventiva' ),
        'update_item'                => __( 'Atualizar Categoria', 'cozinha-inventiva' ),
        'view_item'                  => __( 'Ver Categoria', 'cozinha-inventiva' ),
        'popular_items'              => __( 'Categorias Populares', 'cozinha-inventiva' ),
        'search_items'               => __( 'Buscar Categoria', 'cozinha-inventiva' ),
        'not_found'                  => __( 'Nenhuma categoria encontrada', 'cozinha-inventiva' ),
    );
    
    $args = array(
        'labels'                     => $labels,
        'hierarchical'               => true,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => true,
        'show_in_rest'               => true,
        'rest_base'                  => 'categoria-tecnica',
        'rewrite'                    => array( 'slug' => 'categoria-tecnica' ),
    );
    
    register_taxonomy( 'categoria-tecnica', array( 'ci_tecnica' ), $args );
}
add_action( 'init', 'ci_register_categoria_tecnica', 0 );

/**
 * Inserir termos padrão nas taxonomias
 */
function ci_insert_default_terms() {
    // Verificar se já foram inseridos
    if ( get_option( 'ci_default_terms_inserted' ) ) {
        return;
    }
    
    // Tipos de Aproveitamento
    $tipos_aproveitamento = array(
        'Cascas' => 'Receitas que aproveitam cascas de vegetais e frutas',
        'Talos' => 'Receitas que aproveitam talos de verduras',
        'Sementes' => 'Receitas que aproveitam sementes',
        'Pão Amanhecido' => 'Receitas que aproveitam pão velho',
        'Arroz Dormido' => 'Receitas que aproveitam arroz do dia anterior',
        'Sobras de Proteína' => 'Receitas que aproveitam sobras de carnes e aves',
        'Folhas' => 'Receitas que aproveitam folhas normalmente descartadas',
    );
    
    foreach ( $tipos_aproveitamento as $term => $description ) {
        if ( ! term_exists( $term, 'tipo_aproveitamento' ) ) {
            wp_insert_term( $term, 'tipo_aproveitamento', array( 'description' => $description ) );
        }
    }
    
    // Dificuldades
    $dificuldades = array( 'Fácil', 'Média', 'Difícil' );
    foreach ( $dificuldades as $dificuldade ) {
        if ( ! term_exists( $dificuldade, 'dificuldade' ) ) {
            wp_insert_term( $dificuldade, 'dificuldade' );
        }
    }
    
    // Métodos de Preparo
    $metodos = array( 'Forno', 'Fogão', 'Air Fryer', 'Micro-ondas', 'Processador', 'Liquidificador', 'Sem Fogo' );
    foreach ( $metodos as $metodo ) {
        if ( ! term_exists( $metodo, 'metodo_preparo' ) ) {
            wp_insert_term( $metodo, 'metodo_preparo' );
        }
    }
    
    // Dietas
    $dietas = array( 'Vegano', 'Vegetariano', 'Low Carb', 'Sem Glúten', 'Sem Lactose', 'Flexível' );
    foreach ( $dietas as $dieta ) {
        if ( ! term_exists( $dieta, 'dieta' ) ) {
            wp_insert_term( $dieta, 'dieta' );
        }
    }
    
    // Ocasiões
    $ocasioes = array( 'Café da Manhã', 'Almoço', 'Jantar', 'Lanche', 'Sobremesa', 'Festas', 'Dia a Dia' );
    foreach ( $ocasioes as $ocasiao ) {
        if ( ! term_exists( $ocasiao, 'ocasiao' ) ) {
            wp_insert_term( $ocasiao, 'ocasiao' );
        }
    }
    
    // Marcar como inserido
    update_option( 'ci_default_terms_inserted', true );
}
add_action( 'init', 'ci_insert_default_terms', 20 );
