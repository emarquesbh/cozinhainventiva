/* ARQUIVO 20/35 - Bloco Busca Ingredientes */
(function(blocks, element) {
    const el = element.createElement;
    
    blocks.registerBlockType('cozinha-inventiva/busca-ingredientes', {
        edit: function() {
            return el('div', {
                style: {
                    padding: '2rem',
                    background: '#f5f5f5',
                    borderRadius: '12px',
                    textAlign: 'center',
                    border: '2px dashed #D2691E'
                }
            }, '🔍 Busca por Ingredientes (use template "Minha Geladeira")');
        },
        save: function() {
            return null;
        }
    });
})(window.wp.blocks, window.wp.element);
