/* ARQUIVO 24/35 - Bloco Antes e Depois */
(function(blocks, element) {
    const el = element.createElement;
    
    blocks.registerBlockType('cozinha-inventiva/antes-depois', {
        edit: function() {
            return el('div', {
                style: {
                    display: 'grid',
                    gridTemplateColumns: '1fr 1fr',
                    gap: '1rem',
                    padding: '2rem',
                    background: '#f5f5f5',
                    borderRadius: '12px'
                }
            }, [
                el('div', {
                    key: 'antes',
                    style: {
                        textAlign: 'center',
                        padding: '2rem',
                        background: 'white',
                        borderRadius: '8px'
                    }
                }, '⬅️ ANTES (adicione imagem)'),
                el('div', {
                    key: 'depois',
                    style: {
                        textAlign: 'center',
                        padding: '2rem',
                        background: 'white',
                        borderRadius: '8px'
                    }
                }, '➡️ DEPOIS (adicione imagem)')
            ]);
        },
        save: function() {
            return null;
        }
    });
})(window.wp.blocks, window.wp.element);
