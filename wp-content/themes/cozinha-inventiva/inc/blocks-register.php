<?php
/**
 * ARQUIVO 12/36 - inc/blocks-register.php
 * Registra blocos Gutenberg customizados
 */

if (!defined('ABSPATH')) exit;

function ci_register_blocks() {
    // Registrar blocos aqui (serão criados nos próximos arquivos)
    $blocks = array(
        'antes',
        'antes-depois',
        'bloco-antes',
        'bloco-busca',
        'bloco-dica',
        'bloco-impcto',
        'busca',
        'busca-ingredientes',
        'dica',
        'dica-chef',
        'impacto',
        'impacto-upcycling', 
    );
    
    foreach ($blocks as $block) {
        $block_path = CI_THEME_DIR . '/blocks/' . $block;
        if (file_exists($block_path . '/block.json')) {
            register_block_type($block_path);
        }
    }
}
add_action('init', 'ci_register_blocks');
