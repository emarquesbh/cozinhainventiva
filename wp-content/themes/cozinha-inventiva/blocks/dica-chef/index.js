/* ARQUIVO 22/35 - Bloco Dica do Chef */
(function(blocks, element, blockEditor) {
    const el = element.createElement;
    const RichText = blockEditor.RichText;
    
    blocks.registerBlockType('cozinha-inventiva/dica-chef', {
        attributes: {
            content: {type: 'string', default: '👨‍🍳 Dica do Chef: Digite sua dica aqui...'}
        },
        edit: function(props) {
            return el(RichText, {
                tagName: 'div',
                value: props.attributes.content,
                onChange: function(newContent) {
                    props.setAttributes({content: newContent});
                },
                placeholder: 'Digite a dica do chef...',
                style: {
                    background: 'linear-gradient(135deg, #9ACD32, #7BA428)',
                    color: 'white',
                    padding: '1.5rem',
                    borderRadius: '8px',
                    fontWeight: 'bold'
                }
            });
        },
        save: function(props) {
            return el(RichText.Content, {
                tagName: 'div',
                value: props.attributes.content,
                style: {
                    background: 'linear-gradient(135deg, #9ACD32, #7BA428)',
                    color: 'white',
                    padding: '1.5rem',
                    borderRadius: '8px',
                    fontWeight: 'bold',
                    margin: '2rem 0'
                }
            });
        }
    });
})(window.wp.blocks, window.wp.element, window.wp.blockEditor);
