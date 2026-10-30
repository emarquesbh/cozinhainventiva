<?php
/**
 * Template Name: Minha Geladeira
 *
 * @package Cozinha_Inventiva
 * @since 1.0.0
 * 
 * Arquivo: /Templates/Pages/page-minha-geladeira.php
 * Localização: Templates/Pages/page-minha-geladeira.php
 * Linhas: 240
 * 
 * FUNÇÃO: Template da página "Minha Geladeira". Interface interativa onde usuário adiciona
 * ingredientes disponíveis e o sistema sugere receitas baseadas nesses ingredientes. Usa
 * AJAX para buscar receitas, localStorage para salvar ingredientes, interface de tags,
 * botões de ação e área de resultados dinâmica. Inclui CSS inline completo.
 */

// ARQUIVO 26/42 - PAGE-MINHA-GELADEIRA.PHP
// Localização: /Templates/Pages/page-minha-geladeira.php
// Linhas: 240

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>

<div class="container">
    <div class="minha-geladeira-page">
        <header class="page-header">
            <h1><?php esc_html_e('Minha Geladeira', 'cozinha-inventiva'); ?></h1>
            <p class="page-description">
                <?php esc_html_e('Adicione os ingredientes que você tem disponível e descubra receitas incríveis!', 'cozinha-inventiva'); ?>
            </p>
        </header>

        <div class="geladeira-content">
            <!-- Input de Ingredientes -->
            <div class="ingredient-input-section">
                <div class="input-wrapper">
                    <input 
                        type="text" 
                        id="ingredient-input" 
                        class="ingredient-field" 
                        placeholder="<?php esc_attr_e('Digite um ingrediente...', 'cozinha-inventiva'); ?>"
                        autocomplete="off"
                    >
                    <button id="add-ingredient-btn" class="btn btn-primary">
                        <?php esc_html_e('Adicionar', 'cozinha-inventiva'); ?>
                    </button>
                </div>
                
                <div class="quick-add-section">
                    <p><?php esc_html_e('Adicionar rapidamente:', 'cozinha-inventiva'); ?></p>
                    <div class="quick-ingredients">
                        <button class="quick-ingredient" data-ingredient="cascas de frutas">Cascas de frutas</button>
                        <button class="quick-ingredient" data-ingredient="talos">Talos</button>
                        <button class="quick-ingredient" data-ingredient="pão velho">Pão velho</button>
                        <button class="quick-ingredient" data-ingredient="arroz">Arroz</button>
                        <button class="quick-ingredient" data-ingredient="feijão">Feijão</button>
                    </div>
                </div>
            </div>

            <!-- Lista de Ingredientes Adicionados -->
            <div class="ingredients-list-section">
                <div class="section-header">
                    <h3><?php esc_html_e('Seus Ingredientes', 'cozinha-inventiva'); ?></h3>
                    <button id="clear-ingredients-btn" class="btn btn-text">
                        <?php esc_html_e('Limpar tudo', 'cozinha-inventiva'); ?>
                    </button>
                </div>
                
                <div id="ingredients-list" class="ingredients-tags">
                    <p class="empty-message"><?php esc_html_e('Nenhum ingrediente adicionado ainda', 'cozinha-inventiva'); ?></p>
                </div>
            </div>

            <!-- Botão de Busca -->
            <div class="search-recipes-section">
                <button id="search-recipes-btn" class="btn btn-primary btn-large" disabled>
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" stroke="currentColor">
                        <path d="M9 17C13.4183 17 17 13.4183 17 9C17 4.58172 13.4183 1 9 1C4.58172 1 1 4.58172 1 9C1 13.4183 4.58172 17 9 17Z" stroke-width="2"/>
                        <path d="M19 19L14.65 14.65" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                    <?php esc_html_e('Buscar Receitas', 'cozinha-inventiva'); ?>
                </button>
            </div>

            <!-- Resultados -->
            <div id="recipes-results" class="recipes-results" style="display: none;">
                <h3><?php esc_html_e('Receitas Sugeridas', 'cozinha-inventiva'); ?></h3>
                <div id="recipes-grid" class="recipes-grid"></div>
            </div>
        </div>
    </div>
</div>

<style>
.minha-geladeira-page {
    padding: 2rem 0;
}

.page-header {
    text-align: center;
    margin-bottom: 3rem;
}

.page-header h1 {
    font-size: 2.5rem;
    color: #1a202c;
    margin-bottom: 1rem;
}

.page-description {
    font-size: 1.125rem;
    color: #718096;
}

.geladeira-content {
    max-width: 900px;
    margin: 0 auto;
}

.ingredient-input-section {
    background-color: #f7fafc;
    padding: 2rem;
    border-radius: 12px;
    margin-bottom: 2rem;
}

.input-wrapper {
    display: flex;
    gap: 1rem;
    margin-bottom: 1.5rem;
}

.ingredient-field {
    flex: 1;
    padding: 0.75rem 1rem;
    border: 2px solid #e2e8f0;
    border-radius: 8px;
    font-size: 1rem;
}

.ingredient-field:focus {
    outline: none;
    border-color: #48bb78;
}

.quick-add-section {
    margin-top: 1rem;
}

.quick-add-section p {
    font-size: 0.875rem;
    color: #718096;
    margin-bottom: 0.75rem;
}

.quick-ingredients {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
}

.quick-ingredient {
    padding: 0.5rem 1rem;
    background-color: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 6px;
    font-size: 0.875rem;
    cursor: pointer;
    transition: all 0.3s ease;
}

.quick-ingredient:hover {
    background-color: #48bb78;
    color: #ffffff;
    border-color: #48bb78;
}

.ingredients-list-section {
    margin-bottom: 2rem;
}

.section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
}

.section-header h3 {
    font-size: 1.25rem;
    color: #1a202c;
}

.ingredients-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 0.75rem;
    min-height: 60px;
    padding: 1rem;
    background-color: #ffffff;
    border: 2px dashed #e2e8f0;
    border-radius: 8px;
}

.ingredient-tag {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    background-color: #48bb78;
    color: #ffffff;
    border-radius: 6px;
    font-size: 0.875rem;
}

.ingredient-tag .remove-ingredient {
    background: none;
    border: none;
    color: #ffffff;
    cursor: pointer;
    font-size: 1.25rem;
    line-height: 1;
    padding: 0;
    margin-left: 0.25rem;
}

.empty-message {
    color: #a0aec0;
    font-style: italic;
    margin: 0;
}

.search-recipes-section {
    text-align: center;
    margin-bottom: 3rem;
}

.btn-large {
    padding: 1rem 2rem;
    font-size: 1.125rem;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.btn-large:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

.recipes-results {
    margin-top: 3rem;
    padding-top: 2rem;
    border-top: 2px solid #e2e8f0;
}

.recipes-results h3 {
    font-size: 1.75rem;
    margin-bottom: 2rem;
    text-align: center;
}

@media (max-width: 768px) {
    .input-wrapper {
        flex-direction: column;
    }
    
    .section-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.5rem;
    }
}
</style>

<script>
// JavaScript será carregado do arquivo assets/js/main.js
</script>

<?php
get_footer();
