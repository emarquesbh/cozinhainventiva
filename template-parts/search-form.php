<?php
/**
 * Search Form Template Part
 *
 * @package Cozinha_Inventiva
 * @since 1.0.0
 * 
 * Arquivo: /template-parts/search-form.php
 * Localização: template-parts/search-form.php
 * Linhas: 120
 * 
 * FUNÇÃO: Template do formulário de busca. Modal interativo com campo de busca,
 * sugestões de termos populares e resultados ao vivo.
 */

if (!defined('ABSPATH')) {
    exit;
}
?>

<div id="searchModal" class="search-modal" style="display: none;">
    <div class="search-modal-overlay"></div>
    
    <div class="search-modal-content">
        <button class="search-modal-close" aria-label="<?php esc_attr_e('Fechar busca', 'cozinha-inventiva'); ?>">
            &times;
        </button>
        
        <div class="search-modal-inner">
            <h2 class="search-modal-title">
                <?php esc_html_e('O que você procura?', 'cozinha-inventiva'); ?>
            </h2>
            
            <form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
                <div class="search-input-wrapper">
                    <input 
                        type="search" 
                        id="search-input"
                        class="search-field" 
                        placeholder="<?php echo esc_attr_x('Digite sua busca...', 'placeholder', 'cozinha-inventiva'); ?>" 
                        value="<?php echo get_search_query(); ?>" 
                        name="s"
                        autocomplete="off"
                    >
                    <button type="submit" class="search-submit" aria-label="<?php esc_attr_e('Buscar', 'cozinha-inventiva'); ?>">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" stroke="currentColor">
                            <path d="M9 17C13.4183 17 17 13.4183 17 9C17 4.58172 13.4183 1 9 1C4.58172 1 1 4.58172 1 9C1 13.4183 4.58172 17 9 17Z" stroke-width="2"/>
                            <path d="M19 19L14.65 14.65" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                    </button>
                </div>
            </form>
            
            <!-- Sugestões de Busca -->
            <div class="search-suggestions">
                <h3><?php esc_html_e('Sugestões Populares', 'cozinha-inventiva'); ?></h3>
                <div class="search-tags">
                    <?php
                    $popular_terms = array(
                        'Cascas de Frutas',
                        'Pão Amanhecido',
                        'Talos',
                        'Fermentação',
                        'Caldos',
                        'Sobremesas',
                    );
                    
                    foreach ($popular_terms as $term) :
                        $search_url = add_query_arg('s', urlencode($term), home_url('/'));
                    ?>
                        <a href="<?php echo esc_url($search_url); ?>" class="search-tag">
                            <?php echo esc_html($term); ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
            
            <!-- Categorias de Busca -->
            <div class="search-suggestions">
                <h3><?php esc_html_e('Buscar por Categoria', 'cozinha-inventiva'); ?></h3>
                <div class="search-tags">
                    <?php
                    $terms = get_terms(array(
                        'taxonomy' => 'tipo_aproveitamento',
                        'hide_empty' => true,
                        'number' => 6,
                    ));
                    
                    if (!is_wp_error($terms) && !empty($terms)) :
                        foreach ($terms as $term) :
                    ?>
                            <a href="<?php echo esc_url(get_term_link($term)); ?>" class="search-tag">
                                <?php echo esc_html($term->name); ?>
                            </a>
                    <?php
                        endforeach;
                    endif;
                    ?>
                </div>
            </div>
            
            <!-- Resultados ao Vivo -->
            <div id="search-results-live" class="search-results-live"></div>
        </div>
    </div>
</div>

<!-- Fim do arquivo search-form.php - Linha 120 -->
