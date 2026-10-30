<?php
/**
 * Template Name: Cook Mode
 *
 * @package Cozinha_Inventiva
 * @since 1.0.0
 * 
 * Arquivo: /Templates/Pages/cook-mode.php
 * Localização: Templates/Pages/cook-mode.php
 * Linhas: 185
 * 
 * FUNÇÃO: Template "Modo Cozinheiro" para receitas. Modo fullscreen step-by-step que exibe
 * instruções de receita em tela cheia, navegação por etapas (anterior/próximo), timer
 * integrado, ingredientes visíveis, botão de voz (opcional), fonte grande e controles de
 * navegação. Ideal para seguir receita enquanto cozinha. Usa CSS e JS específicos
 * (cook-mode.css e cook-mode.js).
 */

// ARQUIVO 29/42 - COOK-MODE.PHP
// Localização: /Templates/Pages/cook-mode.php
// Linhas: 185

if (!defined('ABSPATH')) {
    exit;
}

// Obter ID da receita da URL
$recipe_id = isset($_GET['recipe_id']) ? intval($_GET['recipe_id']) : 0;

if (!$recipe_id || get_post_type($recipe_id) !== 'wprm_recipe') {
    wp_redirect(home_url('/'));
    exit;
}

// Buscar dados da receita
$recipe = get_post($recipe_id);
$recipe_meta = ci_get_recipe_meta($recipe_id);
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo esc_html(get_the_title($recipe_id)); ?> - <?php esc_html_e('Modo Cozinheiro', 'cozinha-inventiva'); ?></title>
    <?php wp_head(); ?>
</head>
<body class="cook-mode-body">

<div id="cook-mode-container" class="cook-mode-container">
    
    <!-- Header -->
    <header class="cook-mode-header">
        <div class="header-left">
            <a href="<?php echo esc_url(get_permalink($recipe_id)); ?>" class="close-cook-mode">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path d="M18 6L6 18M6 6l12 12" stroke-width="2" stroke-linecap="round"/>
                </svg>
                <?php esc_html_e('Sair', 'cozinha-inventiva'); ?>
            </a>
        </div>
        
        <div class="header-center">
            <h1 class="recipe-title"><?php echo esc_html(get_the_title($recipe_id)); ?></h1>
        </div>
        
        <div class="header-right">
            <button id="toggle-ingredients-btn" class="btn-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" stroke-width="2"/>
                </svg>
            </button>
        </div>
    </header>

    <!-- Sidebar de Ingredientes -->
    <aside id="ingredients-sidebar" class="ingredients-sidebar">
        <h2><?php esc_html_e('Ingredientes', 'cozinha-inventiva'); ?></h2>
        <div class="ingredients-list">
            <?php
            // WP Recipe Maker renderiza ingredientes automaticamente
            // Aqui você pode adicionar lógica customizada se necessário
            echo do_shortcode('[wprm-recipe-ingredients id="' . $recipe_id . '"]');
            ?>
        </div>
    </aside>

    <!-- Área Principal de Instruções -->
    <main class="cook-mode-main">
        <div class="step-container">
            <div id="current-step" class="current-step">
                <div class="step-number">
                    <span id="step-current">1</span> / <span id="step-total">-</span>
                </div>
                
                <div id="step-content" class="step-content">
                    <!-- JavaScript irá popular com as instruções -->
                </div>
            </div>
            
            <!-- Timer -->
            <div id="step-timer" class="step-timer" style="display: none;">
                <div class="timer-display">
                    <span id="timer-minutes">00</span>:<span id="timer-seconds">00</span>
                </div>
                <div class="timer-controls">
                    <button id="timer-start-btn" class="btn btn-secondary"><?php esc_html_e('Iniciar', 'cozinha-inventiva'); ?></button>
                    <button id="timer-pause-btn" class="btn btn-secondary" style="display: none;"><?php esc_html_e('Pausar', 'cozinha-inventiva'); ?></button>
                    <button id="timer-reset-btn" class="btn btn-text"><?php esc_html_e('Resetar', 'cozinha-inventiva'); ?></button>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer com Navegação -->
    <footer class="cook-mode-footer">
        <button id="prev-step-btn" class="nav-btn nav-btn-prev" disabled>
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                <path d="M15 18l-6-6 6-6" stroke-width="2" stroke-linecap="round"/>
            </svg>
            <?php esc_html_e('Anterior', 'cozinha-inventiva'); ?>
        </button>
        
        <div class="progress-indicator">
            <div id="progress-bar" class="progress-bar"></div>
        </div>
        
        <button id="next-step-btn" class="nav-btn nav-btn-next">
            <?php esc_html_e('Próximo', 'cozinha-inventiva'); ?>
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                <path d="M9 18l6-6-6-6" stroke-width="2" stroke-linecap="round"/>
            </svg>
        </button>
    </footer>

</div>

<script>
// Dados da receita para JavaScript
var cookModeData = {
    recipeId: <?php echo esc_js($recipe_id); ?>,
    steps: <?php
        // Buscar instruções WP Recipe Maker
        $recipe_data = get_post_meta($recipe_id, 'wprm_recipe', true);
        $instructions = isset($recipe_data['instructions']) ? $recipe_data['instructions'] : array();
        
        $steps_array = array();
        if (is_array($instructions)) {
            foreach ($instructions as $instruction_group) {
                if (isset($instruction_group['instructions']) && is_array($instruction_group['instructions'])) {
                    foreach ($instruction_group['instructions'] as $step) {
                        if (isset($step['text'])) {
                            $steps_array[] = array(
                                'text' => wp_strip_all_tags($step['text']),
                                'image' => isset($step['image']) ? $step['image'] : '',
                            );
                        }
                    }
                }
            }
        }
        
        echo json_encode($steps_array);
    ?>
};
</script>

<?php wp_footer(); ?>

<style>
/* Estilos básicos - O resto está em /assets/css/cook-mode.css */
.cook-mode-body {
    margin: 0;
    padding: 0;
    overflow: hidden;
    font-family: -apple-system, BlinkMacSystemFont, 'Inter', sans-serif;
}

.cook-mode-container {
    display: flex;
    flex-direction: column;
    height: 100vh;
    background-color: #ffffff;
}

.cook-mode-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem 2rem;
    background-color: #48bb78;
    color: #ffffff;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.recipe-title {
    font-size: 1.5rem;
    margin: 0;
    color: #ffffff;
}

.cook-mode-main {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 2rem;
    overflow-y: auto;
}

.step-content {
    font-size: 2rem;
    line-height: 1.6;
    color: #1a202c;
    text-align: center;
    max-width: 800px;
}

.cook-mode-footer {
    display: flex;
    gap: 2rem;
    padding: 1.5rem 2rem;
    background-color: #f7fafc;
    box-shadow: 0 -2px 8px rgba(0, 0, 0, 0.05);
}

.nav-btn {
    padding: 1rem 2rem;
    font-size: 1.125rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.progress-indicator {
    flex: 1;
    height: 8px;
    background-color: #e2e8f0;
    border-radius: 4px;
    align-self: center;
}

.progress-bar {
    height: 100%;
    background-color: #48bb78;
    border-radius: 4px;
    transition: width 0.3s ease;
}
</style>

</body>
</html>
