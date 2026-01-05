(function(blocks, element) {
    blocks.registerBlockType('cozinha-inventiva/antes-depois', {
        edit: function() {
            return element.createElement('div', {
                style: {
                    display: 'grid',
                    gridTemplateColumns: '1fr 1fr',
                    gap: '1rem',
                    padding: '2rem',
                    background: '#f5f5f5',
                    borderRadius: '12px'
                }
            }, [
                element.createElement('div', {key: 'antes', style: {textAlign: 'center', padding: '2rem', background: 'white', borderRadius: '8px'}}, '⬅️ ANTES'),
                element.createElement('div', {key: 'depois', style: {textAlign: 'center', padding: '2rem', background: 'white', borderRadius: '8px'}}, '➡️ DEPOIS')
            ]);
        },
        save: function() { return null; }
    });
})(window.wp.blocks, window.wp.element);
