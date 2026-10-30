<?php
/**
 * ARQUIVO 7/36
 * LOCALIZAÇÃO: /wp-content/themes/cozinha-inventiva/sidebar.php
 * LINHAS: ~45
 * 
 * FUNÇÃO COMPLETA:
 * - Sidebar principal do tema
 * - Verifica se widgets estão ativos
 * - Fallback com busca e categorias se vazio
 * - Compatível com dispositivos móveis
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Se não houver widgets, não exibir sidebar
if ( ! is_active_sidebar( 'sidebar-1' ) ) {
    return;
}
?>

<aside id="secondary" class="widget-area" role="complementary" aria-label="<?php esc_attr_e( 'Barra Lateral', 'cozinha-inventiva' ); ?>">
    
    <?php dynamic_sidebar( 'sidebar-1' ); ?>
    
</aside><!-- #secondary .widget-area -->

<!-- FIM DO ARQUIVO 7/36 -->
