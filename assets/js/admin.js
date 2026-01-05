/**
 * Cozinha Inventiva - Admin JavaScript (Consolidado)
 * * Funcionalidades:
 * - Módulos de Upload, ACF Enhancements, Preview e Validação
 * - Utilitários de UI: Tooltips, Color Picker e Dashboard Stats
 * * @package Cozinha_Inventiva
 * @since 1.0.0
 */

(function($) {
    'use strict';

    /**
     * MÓDULO: Media Upload Helper
     * Gerencia upload de imagens tanto para botões genéricos quanto ACF.
     */
    const MediaUpload = {
        init() {
            this.bindEvents();
        },

        bindEvents() {
            // Suporte para classes dos dois arquivos (ci- e cozinha-)
            $(document).on('click', '.ci-upload-button, .cozinha-upload-image-btn', (e) => {
                e.preventDefault();
                this.openMediaUploader($(e.currentTarget));
            });

            $(document).on('click', '.ci-remove-image, .cozinha-remove-image-btn', (e) => {
                e.preventDefault();
                this.removeImage($(e.currentTarget));
            });
        },

        openMediaUploader($button) {
            const targetInput = $button.data('target') || $button.siblings('.cozinha-image-url');
            const targetPreview = $button.data('preview') || $button.siblings('.cozinha-image-preview');

            const mediaUploader = wp.media({
                title: 'Selecionar Imagem',
                button: { text: 'Usar esta imagem' },
                multiple: false
            });

            mediaUploader.on('select', () => {
                const attachment = mediaUploader.state().get('selection').first().toJSON();
                $(targetInput).val(attachment.url);
                
                if (targetPreview) {
                    const previewEl = $(targetPreview).length ? $(targetPreview) : targetPreview;
                    previewEl.html(`<img src="${attachment.url}" style="max-width: 200px; display:block; margin-top:10px;">`);
                }
            });

            mediaUploader.open();
        },

        removeImage($button) {
            const targetInput = $button.data('target') || $button.siblings('.cozinha-image-url');
            const targetPreview = $button.data('preview') || $button.siblings('.cozinha-image-preview');

            $(targetInput).val('');
            if (targetPreview) {
                $(targetPreview).html('');
            }
        }
    };

    /**
     * MÓDULO: ACF & UI Enhancements
     * Melhora a experiência de edição de receitas e campos personalizados.
     */
    const UIEnhancements = {
        init() {
            this.setupIngredientRepeater();
            this.setupInstructionRepeater();
            this.initColorPicker();
            this.initTooltips();
            this.updateDashboardStats();
        },

        setupIngredientRepeater() {
            if (typeof acf === 'undefined') return;
            acf.addAction('append remove', ($el) => {
                if ($el.data('name') === 'ingredientes') this.updateIngredientCount();
            });
        },

        updateIngredientCount() {
            const count = $('.acf-field[data-name="ingredientes"] .acf-row').length;
            $('.ingredient-count').text(`${count} ingrediente(s)`);
        },

        setupInstructionRepeater() {
            if (typeof acf === 'undefined') return;
            acf.addAction('append sortstop', ($el) => {
                if ($el.data('name') === 'modo_preparo') this.renumberInstructions();
            });
        },

        renumberInstructions() {
            $('.acf-field[data-name="modo_preparo"] .acf-row').each((index, row) => {
                $(row).find('.step-number').text(`Passo ${index + 1}`);
            });
        },

        initColorPicker() {
            if ($.fn.wpColorPicker) $('.cozinha-color-picker').wpColorPicker();
        },

        initTooltips() {
            $('.cozinha-tooltip').each(function() {
                const text = $(this).attr('data-tooltip');
                $(this).attr('title', text);
                if ($.fn.tooltip) $(this).tooltip({ content: text });
            });
        },

        updateDashboardStats() {
            $('.cozinha-stat-number').each(function() {
                const target = parseInt($(this).text());
                const element = $(this);
                $({ count: 0 }).animate({ count: target }, {
                    duration: 1500,
                    step: function() { element.text(Math.floor(this.count)); },
                    complete: function() { element.text(target); }
                });
            });
        }
    };

    /**
     * MÓDULO: Recipe Preview & Validation
     */
    const RecipeWorkflow = {
        init() {
            this.bindEvents();
        },

        bindEvents() {
            // Preview
            $('#ci-preview-recipe').on('click', (e) => {
                e.preventDefault();
                this.openPreview();
            });

            $(document).on('click', '.ci-close-preview', () => $('#ci-preview-modal').fadeOut());

            // Validação antes de publicar
            $('#publish').on('click', (e) => {
                if (!this.validateRecipe()) e.preventDefault();
            });
        },

        openPreview() {
            const data = {
                title: $('#title').val(),
                ingredients: [],
                instructions: []
            };

            $('[data-name="ingredientes"] .acf-row').each((i, row) => {
                data.ingredients.push($(row).find('[data-name="ingrediente"]').val());
            });

            const html = `<h3>${data.title}</h3><p>Ingredientes: ${data.ingredients.length}</p>`;
            $('#ci-preview-content').html(html);
            $('#ci-preview-modal').fadeIn();
        },

        validateRecipe() {
            if (!$('#title').val().trim()) {
                alert('O título da receita é obrigatório');
                return false;
            }
            return true;
        }
    };

    /**
     * INICIALIZAÇÃO
     */
    $(document).ready(() => {
        MediaUpload.init();
        UIEnhancements.init();
        RecipeWorkflow.init();
        console.log('Cozinha Inventiva Admin: Carregado com sucesso.');
    });

})(jQuery);