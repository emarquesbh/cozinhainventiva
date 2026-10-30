/**
 * ARQUIVO 18/36 - Bloco Impacto Upcycling
 */
(function(blocks, element, blockEditor) {
    var el = element.createElement;
    var InspectorControls = blockEditor.InspectorControls;
    var TextControl = wp.components.TextControl;
    
    blocks.registerBlockType('cozinha-inventiva/impacto-upcycling', {
        edit: function(props) {
            return el('div', { 
                style: { 
                    background: 'linear-gradient(135deg, #9ACD32 0%, #7BA428 100%)',
                    color: 'white',
                    padding: '2rem',
                    borderRadius: '12px'
                }
            }, '♻️ Box de Impacto do Upcycling (use ACF fields para preencher)');
        },
        save: function() {
            return null; // Render via PHP
        }
    });
})(window.wp.blocks, window.wp.element, window.wp.blockEditor);
