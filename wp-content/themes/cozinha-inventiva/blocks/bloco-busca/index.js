(function(blocks, element) {
    blocks.registerBlockType('cozinha-inventiva/busca', {
        edit: function() {
            return element.createElement('div', {
                style: {
                    padding: '2rem',
                    background: '#f5f5f5',
                    borderRadius: '12px',
                    textAlign: 'center',
                    border: '2px dashed #D2691E'
                }
            }, '🔍 Busca por Ingredientes');
        },
        save: function() { return null; }
    });
})(window.wp.blocks, window.wp.element);
