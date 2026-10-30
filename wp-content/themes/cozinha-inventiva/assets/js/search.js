/**
 * Cozinha Inventiva - Search Module
 * 
 * Funcionalidades de busca avançada:
 * - Busca por ingredientes
 * - Autocomplete
 * - Filtros dinâmicos
 * - Busca AJAX
 * - Resultados em tempo real
 * 
 * @package Cozinha_Inventiva
 * @since 1.0.0
 */

(function($) {
    'use strict';

    /**
     * MÓDULO: Header Search Toggle
     */
    const HeaderSearch = {
        init() {
            this.cacheDom();
            this.bindEvents();
        },

        cacheDom() {
            this.$searchToggle = $('.search-toggle');
            this.$searchClose = $('.search-close');
            this.$headerSearch = $('.header-search');
            this.$searchInput = $('#header-search-input');
        },

        bindEvents() {
            this.$searchToggle.on('click', () => this.openSearch());
            this.$searchClose.on('click', () => this.closeSearch());
            
            // Fechar com ESC
            $(document).on('keydown', (e) => {
                if (e.key === 'Escape' && this.$headerSearch.hasClass('is-active')) {
                    this.closeSearch();
                }
            });
        },

        openSearch() {
            this.$headerSearch.addClass('is-active');
            this.$searchToggle.attr('aria-expanded', 'true');
            setTimeout(() => {
                this.$searchInput.focus();
            }, 100);
        },

        closeSearch() {
            this.$headerSearch.removeClass('is-active');
            this.$searchToggle.attr('aria-expanded', 'false');
        }
    };

    /**
     * MÓDULO: Advanced Search Filters
     */
    const AdvancedSearch = {
        init() {
            this.cacheDom();
            this.bindEvents();
            this.initAutocomplete();
        },

        cacheDom() {
            this.$form = $('.ci-search-404, .advanced-search-form form');
            this.$searchInput = this.$form.find('input[name="s"]');
            this.$filters = this.$form.find('select');
            this.$results = $('#search-results');
        },

        bindEvents() {
            // Live search (com debounce)
            let searchTimeout;
            this.$searchInput.on('input', () => {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    this.liveSearch();
                }, 500);
            });

            // Mudança nos filtros
            this.$filters.on('change', () => {
                this.liveSearch();
            });
        },

        initAutocomplete() {
            if (typeof $.fn.autocomplete === 'undefined') return;

            this.$searchInput.autocomplete({
                source: (request, response) => {
                    $.ajax({
                        url: ciVars.ajaxUrl,
                        type: 'POST',
                        data: {
                            action: 'ci_search_autocomplete',
                            nonce: ciVars.nonce,
                            term: request.term
                        },
                        success: (data) => {
                            if (data.success) {
                                response(data.data);
                            }
                        }
                    });
                },
                minLength: 2,
                select: (event, ui) => {
                    this.$searchInput.val(ui.item.label);
                    this.$form.submit();
                    return false;
                }
            });
        },

        liveSearch() {
            if (!this.$results.length) return;

            const searchTerm = this.$searchInput.val();
            const filters = this.getFilters();

            if (searchTerm.length < 2) {
                this.$results.html('');
                return;
            }

            this.$results.html('<div class="search-loading">Buscando...</div>');

            $.ajax({
                url: ciVars.ajaxUrl,
                type: 'POST',
                data: {
                    action: 'ci_live_search',
                    nonce: ciVars.nonce,
                    search: searchTerm,
                    filters: filters
                },
                success: (response) => {
                    if (response.success) {
                        this.$results.html(response.data.html);
                    } else {
                        this.$results.html('<p>Nenhum resultado encontrado.</p>');
                    }
                },
                error: () => {
                    this.$results.html('<p>Erro na busca. Tente novamente.</p>');
                }
            });
        },

        getFilters() {
            const filters = {};
            this.$filters.each(function() {
                const $select = $(this);
                const value = $select.val();
                if (value) {
                    filters[$select.attr('name')] = value;
                }
            });
            return filters;
        }
    };

    /**
     * MÓDULO: Ingredient Search (Minha Geladeira)
     */
    const IngredientSearch = {
        ingredients: [],
        maxIngredients: 10,

        init() {
            this.cacheDom();
            this.bindEvents();
        },

        cacheDom() {
            this.$container = $('.ci-ingredient-search');
            if (!this.$container.length) return;

            this.$input = $('#ci-ingredient-input');
            this.$addBtn = $('#ci-add-ingredient');
            this.$tagsContainer = $('#ci-ingredient-tags');
            this.$searchBtn = $('#ci-search-recipes');
            this.$resultsContainer = $('#ci-search-results');
            this.$exactMatch = $('#ci-exact-match');
        },

        bindEvents() {
            if (!this.$container.length) return;

            this.$addBtn.on('click', () => this.addIngredient());
            
            this.$input.on('keypress', (e) => {
                if (e.which === 13) {
                    e.preventDefault();
                    this.addIngredient();
                }
            });

            this.$searchBtn.on('click', () => this.searchRecipes());

            this.$tagsContainer.on('click', '.ci-ingredient-tag__remove', (e) => {
                const ingredient = $(e.currentTarget).data('ingredient');
                this.removeIngredient(ingredient);
            });

            // Autocomplete de ingredientes
            this.initIngredientAutocomplete();
        },

        initIngredientAutocomplete() {
            if (typeof $.fn.autocomplete === 'undefined') return;

            this.$input.autocomplete({
                source: (request, response) => {
                    $.ajax({
                        url: ciVars.ajaxUrl,
                        type: 'POST',
                        data: {
                            action: 'ci_ingredient_autocomplete',
                            nonce: ciVars.nonce,
                            term: request.term
                        },
                        success: (data) => {
                            if (data.success) {
                                response(data.data);
                            }
                        }
                    });
                },
                minLength: 2,
                select: (event, ui) => {
                    this.$input.val(ui.item.label);
                    this.addIngredient();
                    return false;
                }
            });
        },

        addIngredient() {
            const ingredient = this.$input.val().trim();

            if (!ingredient) {
                this.showMessage('Digite um ingrediente', 'warning');
                return;
            }

            if (this.ingredients.length >= this.maxIngredients) {
                this.showMessage(`Máximo de ${this.maxIngredients} ingredientes`, 'warning');
                return;
            }

            if (this.ingredients.includes(ingredient.toLowerCase())) {
                this.showMessage('Ingrediente já adicionado', 'warning');
                return;
            }

            this.ingredients.push(ingredient.toLowerCase());
            this.renderTags();
            this.$input.val('').focus();
            this.updateSearchButton();
        },

        removeIngredient(ingredient) {
            this.ingredients = this.ingredients.filter(item => item !== ingredient);
            this.renderTags();
            this.updateSearchButton();
        },

        renderTags() {
            const tagsHtml = this.ingredients.map(ingredient => `
                <span class="ci-ingredient-tag">
                    ${this.escapeHtml(ingredient)}
                    <button type="button" 
                            class="ci-ingredient-tag__remove" 
                            data-ingredient="${this.escapeHtml(ingredient)}"
                            aria-label="Remover ${this.escapeHtml(ingredient)}">
                        ×
                    </button>
                </span>
            `).join('');

            this.$tagsContainer.html(tagsHtml);
        },

        updateSearchButton() {
            const count = this.ingredients.length;
            const minReached = count >= 3;

            this.$searchBtn.prop('disabled', !minReached);
            
            if (minReached) {
                this.$searchBtn.text(`Buscar Receitas (${count} ingredientes)`);
            } else {
                this.$searchBtn.text(`Adicione pelo menos 3 ingredientes (${count}/3)`);
            }
        },

        searchRecipes() {
            if (this.ingredients.length < 3) {
                this.showMessage('Adicione pelo menos 3 ingredientes', 'warning');
                return;
            }

            this.$resultsContainer.html('<div class="search-loading">Buscando receitas...</div>');
            this.$searchBtn.prop('disabled', true).text('Buscando...');

            $.ajax({
                url: ciVars.ajaxUrl,
                type: 'POST',
                data: {
                    action: 'ci_search_by_ingredients',
                    nonce: ciVars.nonce,
                    ingredients: this.ingredients,
                    exact_match: this.$exactMatch.is(':checked')
                },
                success: (response) => {
                    this.$searchBtn.prop('disabled', false);
                    this.updateSearchButton();

                    if (response.success) {
                        this.$resultsContainer.html(response.data.html);
                        
                        // Scroll suave para resultados
                        $('html, body').animate({
                            scrollTop: this.$resultsContainer.offset().top - 100
                        }, 500);

                        this.showMessage(
                            `${response.data.count} receita(s) encontrada(s)`,
                            'success'
                        );
                    } else {
                        this.$resultsContainer.html(
                            '<p class="no-results">Nenhuma receita encontrada com esses ingredientes.</p>'
                        );
                        this.showMessage('Nenhuma receita encontrada', 'info');
                    }
                },
                error: () => {
                    this.$searchBtn.prop('disabled', false);
                    this.updateSearchButton();
                    this.$resultsContainer.html(
                        '<p class="error-message">Erro ao buscar receitas. Tente novamente.</p>'
                    );
                    this.showMessage('Erro ao buscar receitas', 'error');
                }
            });
        },

        showMessage(text, type = 'info') {
            const $message = $(`
                <div class="ci-message ci-message--${type}">
                    ${this.escapeHtml(text)}
                </div>
            `);

            this.$container.find('.ci-message').remove();
            this.$container.prepend($message);

            setTimeout(() => {
                $message.fadeOut(() => $message.remove());
            }, 3000);
        },

        escapeHtml(text) {
            const map = {
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            };
            return text.replace(/[&<>"']/g, m => map[m]);
        }
    };

    /**
     * MÓDULO: Search Results Filters
     */
    const SearchFilters = {
        init() {
            this.cacheDom();
            this.bindEvents();
        },

        cacheDom() {
            this.$filterToggles = $('.filter-toggle');
            this.$sortSelect = $('#search-sort');
            this.$viewToggle = $('.view-toggle');
        },

        bindEvents() {
            // Toggle de filtros
            this.$filterToggles.on('click', (e) => {
                const $toggle = $(e.currentTarget);
                const target = $toggle.data('filter');
                $(`.filter-group[data-filter="${target}"]`).slideToggle();
                $toggle.toggleClass('is-active');
            });

            // Ordenação
            this.$sortSelect.on('change', () => {
                this.updateResults();
            });

            // Toggle de visualização (grid/list)
            this.$viewToggle.on('click', (e) => {
                const $btn = $(e.currentTarget);
                const view = $btn.data('view');
                
                this.$viewToggle.removeClass('is-active');
                $btn.addClass('is-active');
                
                $('.search-results').removeClass('view-grid view-list').addClass(`view-${view}`);
                
                localStorage.setItem('ci_search_view', view);
            });

            // Restaurar visualização salva
            const savedView = localStorage.getItem('ci_search_view');
            if (savedView) {
                $(`.view-toggle[data-view="${savedView}"]`).click();
            }
        },

        updateResults() {
            const sortBy = this.$sortSelect.val();
            const $results = $('.search-results');
            
            $results.addClass('is-loading');
            
            // Aqui você implementaria a lógica de atualização via AJAX
            // Por enquanto, apenas remove o loading
            setTimeout(() => {
                $results.removeClass('is-loading');
            }, 500);
        }
    };

    /**
     * INICIALIZAÇÃO
     */
    $(document).ready(() => {
        HeaderSearch.init();
        AdvancedSearch.init();
        IngredientSearch.init();
        SearchFilters.init();
    });

})(jQuery);
