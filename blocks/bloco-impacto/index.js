(function(blocks, element) {
    blocks.registerBlockType('cozinha-inventiva/impacto', {
        edit: function() {
            return element.createElement('div', {
                style: {
                    background: 'linear-gradient(135deg, #9ACD32, #7BA428)',
                    color: 'white',
                    padding: '2rem',
                    borderRadius: '12px',
                    textAlign: 'center'
                }
            }, '♻️ Impacto do Upcycling (preencha ACF)');
        },
        save: function() { return null; }
    });
})(window.wp.blocks, window.wp.element);
