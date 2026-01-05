(function(blocks, element) {
    blocks.registerBlockType('cozinha-inventiva/impacto', {
        edit: function() {
            return element.createElement('div', {style: {padding: '2rem', background: '#f5f5f5', borderRadius: '12px', textAlign: 'center'}}, '✨ Bloco impacto');
        },
        save: function() { return null; }
    });
})(window.wp.blocks, window.wp.element);
