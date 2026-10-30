(function(blocks, element, editor) {
    blocks.registerBlockType('cozinha-inventiva/dica', {
        attributes: {
            content: {type: 'string', default: '👨‍🍳 Dica do Chef: Digite aqui...'}
        },
        edit: function(props) {
            return element.createElement(editor.RichText, {
                tagName: 'div',
                value: props.attributes.content,
                onChange: function(val) { props.setAttributes({content: val}); },
                placeholder: 'Digite a dica...',
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
            return element.createElement(editor.RichText.Content, {
                tagName: 'div',
                value: props.attributes.content,
                style: {
                    background: 'linear-gradient(135deg, #9ACD32, #7BA428)',
                    color: 'white',
                    padding: '1.5rem',
                    borderRadius: '8px',
                    fontWeight: 'bold'
                }
            });
        }
    });
})(window.wp.blocks, window.wp.element, window.wp.blockEditor);
