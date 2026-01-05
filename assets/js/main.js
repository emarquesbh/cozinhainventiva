/**
 * Cozinha Inventiva - Main JavaScript
 * 
 * @package Cozinha_Inventiva
 * @since 1.0.0
 */

(function($) {
    'use strict';

    /**
     * MÓDULO: Busca por Ingredientes
     */
    const IngredientSearch = {
        ingredients: [],
        maxIngredients: 10,
        minIngredients: 3,

        init() {
            this.cacheDom();
            this.bindEvents();
        },

        cacheDom() {
            this.$container = $('.ci-ingredient-search');
            this.$input = $('#ci-ingredient-input');
            this.$addBtn = $('#ci-add-ingredient');
            this.$tagsContainer = $('#ci-ingredient-tags');
            this.$searchBtn = $('#ci-search-recipes');
            this.$resultsContainer = $('#ci-search-results');
            this.$exactMatch = $('#ci-exact-match');
        },

        bindEvents() {
            this.$addBtn.on('click', () => this.addIngredient());
            this.$input.on('keypress', (e) => {
                if (e.which === 13) {
                    e.preventDefault();
                    this.addIngredient();
                }
            });
            this.$searchBtn.on('click', () => this.searchRecipes());
            this.$tagsContainer.on('click', '.ci-ingredient-tag__remove', (e) => {
                this.removeIngredient($(e.target).data('ingredient'));
            });

            // Autocomplete
            if (typeof $.fn.autocomplete !== 'undefined') {
                this.$input.autocomplete({
                    source: (request, response) => {
                        $.ajax({
                            url: ciAjax.ajaxurl,
                            dataType: 'json',
                            data: {
                                action: 'ci_autocomplete_ingredients',
                                term: request.term,
                                nonce: ciAjax.nonce
                            },
                            success: (data) => response(data)
                        });
                    },
                    minLength: 2
                });
            }
        },

        addIngredient() {
            const ingredient = this.$input.val().trim().toLowerCase();

            if (!ingredient) {
                this.showMessage('Digite um ingrediente', 'warning');
                return;
            }

            if (this.ingredients.includes(ingredient)) {
                this.showMessage('Ingrediente já adicionado', 'warning');
                return;
            }

            if (this.ingredients.length >= this.maxIngredients) {
                this.showMessage(`Máximo de ${this.maxIngredients} ingredientes`, 'warning');
                return;
            }

            this.ingredients.push(ingredient);
            this.renderTag(ingredient);
            this.$input.val('').focus();
            this.updateSearchButton();
        },

        removeIngredient(ingredient) {
            this.ingredients = this.ingredients.filter(item => item !== ingredient);
            this.renderTags();
            this.updateSearchButton();
        },

        renderTag(ingredient) {
            const tag = `
                <div class="ci-ingredient-tag" data-ingredient="${ingredient}">
                    <span>${ingredient}</span>
                    <button class="ci-ingredient-tag__remove" data-ingredient="${ingredient}" aria-label="Remover ${ingredient}">
                        ×
                    </button>
                </div>
            `;
            this.$tagsContainer.append(tag);
        },

        renderTags() {
            this.$tagsContainer.empty();
            this.ingredients.forEach(ingredient => this.renderTag(ingredient));
        },

        updateSearchButton() {
            if (this.ingredients.length >= this.minIngredients) {
                this.$searchBtn.prop('disabled', false)
                    .text(`Buscar Receitas (${this.ingredients.length} ingredientes)`);
            } else {
                this.$searchBtn.prop('disabled', true)
                    .text(`Adicione pelo menos ${this.minIngredients} ingredientes`);
            }
        },

        searchRecipes() {
            if (this.ingredients.length < this.minIngredients) {
                return;
            }

            this.$resultsContainer.html('<div class="ci-loading">Buscando receitas...</div>');

            $.ajax({
                url: ciAjax.ajaxurl,
                type: 'POST',
                dataType: 'json',
                data: {
                    action: 'ci_search_by_ingredients',
                    ingredients: this.ingredients,
                    exact_match: this.$exactMatch.is(':checked'),
                    nonce: ciAjax.nonce
                },
                success: (response) => {
                    if (response.success) {
                        this.renderResults(response.data);
                    } else {
                        this.showMessage(response.data || 'Erro ao buscar receitas', 'error');
                    }
                },
                error: () => {
                    this.showMessage('Erro de conexão. Tente novamente.', 'error');
                }
            });
        },

        renderResults(data) {
            if (!data.recipes || data.recipes.length === 0) {
                this.$resultsContainer.html(`
                    <div class="ci-no-results">
                        <p>Nenhuma receita encontrada com esses ingredientes.</p>
                        <p>Tente remover alguns ingredientes ou desmarcar "buscar apenas com esses".</p>
                    </div>
                `);
                return;
            }

            let html = `<h3>Encontramos ${data.recipes.length} receita(s)!</h3><div class="ci-recipe-grid">`;

            data.recipes.forEach(recipe => {
                html += `
                    <article class="ci-recipe-card">
                        <a href="${recipe.url}">
                            <img src="${recipe.image}" alt="${recipe.title}" class="ci-recipe-card__image" loading="lazy">
                        </a>
                        <div class="ci-recipe-card__content">
                            <h4 class="ci-recipe-card__title">
                                <a href="${recipe.url}">${recipe.title}</a>
                            </h4>
                            <div class="ci-recipe-card__meta">
                                ${recipe.time ? `<span class="ci-badge ci-badge-time">⏱️ ${recipe.time}</span>` : ''}
                                ${recipe.difficulty ? `<span class="ci-badge ci-badge-difficulty">${recipe.difficulty}</span>` : ''}
                                ${recipe.is_upcycling ? '<span class="ci-badge ci-badge-upcycling">♻️ Upcycling</span>' : ''}
                            </div>
                            ${recipe.excerpt ? `<p class="ci-recipe-card__description">${recipe.excerpt}</p>` : ''}
                            ${recipe.match_percentage ? `<div class="ci-match">Compatibilidade: ${recipe.match_percentage}%</div>` : ''}
                        </div>
                    </article>
                `;
            });

            html += '</div>';
            this.$resultsContainer.html(html);
        },

        showMessage(message, type = 'info') {
            // Implementar sistema de notificações
            console.log(`[${type.toUpperCase()}] ${message}`);
        }
    };

    /**
     * MÓDULO: Modo Cozinha
     */
    const CookMode = {
        init() {
            this.cacheDom();
            this.bindEvents();
            this.checkCookMode();
        },

        cacheDom() {
            this.$toggleBtn = $('#ci-toggle-cook-mode');
            this.$body = $('body');
        },

        bindEvents() {
            this.$toggleBtn.on('click', () => this.toggle());
            
            // Atalho de teclado: Ctrl + K
            $(document).on('keydown', (e) => {
                if (e.ctrlKey && e.key === 'k') {
                    e.preventDefault();
                    this.toggle();
                }
            });
        },

        checkCookMode() {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('cook-mode') === '1') {
                this.enable();
            }
        },

        toggle() {
            if (this.$body.hasClass('cook-mode')) {
                this.disable();
            } else {
                this.enable();
            }
        },

        enable() {
            this.$body.addClass('cook-mode');
            this.requestWakeLock();
            this.updateUrl(true);
            this.$toggleBtn.text('Sair do Modo Cozinha');
        },

        disable() {
            this.$body.removeClass('cook-mode');
            this.releaseWakeLock();
            this.updateUrl(false);
            this.$toggleBtn.text('Modo Cozinha');
        },

        updateUrl(enable) {
            const url = new URL(window.location);
            if (enable) {
                url.searchParams.set('cook-mode', '1');
            } else {
                url.searchParams.delete('cook-mode');
            }
            window.history.replaceState({}, '', url);
        },

        async requestWakeLock() {
            if ('wakeLock' in navigator) {
                try {
                    this.wakeLock = await navigator.wakeLock.request('screen');
                    console.log('Wake Lock ativado');
                } catch (err) {
                    console.error('Erro ao ativar Wake Lock:', err);
                }
            }
        },

        releaseWakeLock() {
            if (this.wakeLock) {
                this.wakeLock.release();
                this.wakeLock = null;
                console.log('Wake Lock desativado');
            }
        }
    };

    /**
     * MÓDULO: Checklist de Ingredientes/Passos
     */
    const Checklist = {
        init() {
            this.bindEvents();
            this.loadState();
        },

        bindEvents() {
            $(document).on('change', '.ci-checklist-item input[type="checkbox"]', (e) => {
                this.toggleItem($(e.target));
                this.saveState();
            });

            // Botão de resetar checklist
            $('.ci-reset-checklist').on('click', () => {
                this.reset();
            });
        },

        toggleItem($checkbox) {
            const $item = $checkbox.closest('.ci-checklist-item');
            $item.toggleClass('checked', $checkbox.is(':checked'));
        },

        saveState() {
            const recipeId = $('article').data('recipe-id');
            if (!recipeId) return;

            const state = {};
            $('.ci-checklist-item input[type="checkbox"]').each(function() {
                state[$(this).attr('id')] = $(this).is(':checked');
            });

            localStorage.setItem(`ci_checklist_${recipeId}`, JSON.stringify(state));
        },

        loadState() {
            const recipeId = $('article').data('recipe-id');
            if (!recipeId) return;

            const savedState = localStorage.getItem(`ci_checklist_${recipeId}`);
            if (!savedState) return;

            const state = JSON.parse(savedState);
            Object.keys(state).forEach(id => {
                const $checkbox = $(`#${id}`);
                if ($checkbox.length) {
                    $checkbox.prop('checked', state[id]);
                    this.toggleItem($checkbox);
                }
            });
        },

        reset() {
            const recipeId = $('article').data('recipe-id');
            $('.ci-checklist-item input[type="checkbox"]').prop('checked', false)
                .each(function() {
                    Checklist.toggleItem($(this));
                });
            localStorage.removeItem(`ci_checklist_${recipeId}`);
        }
    };

    /**
     * MÓDULO: Timers
     */
    const Timers = {
        activeTimers: {},

        init() {
            this.bindEvents();
        },

        bindEvents() {
            $(document).on('click', '.ci-timer-start', (e) => {
                const $btn = $(e.target);
                const minutes = parseInt($btn.data('minutes'));
                const timerId = $btn.data('timer-id');
                this.start(timerId, minutes);
            });

            $(document).on('click', '.ci-timer-stop', (e) => {
                const timerId = $(e.target).data('timer-id');
                this.stop(timerId);
            });
        },

        start(timerId, minutes) {
            const endTime = Date.now() + (minutes * 60 * 1000);
            const $display = $(`#ci-timer-${timerId}`);

            this.activeTimers[timerId] = setInterval(() => {
                const remaining = endTime - Date.now();

                if (remaining <= 0) {
                    this.complete(timerId);
                    return;
                }

                const mins = Math.floor(remaining / 60000);
                const secs = Math.floor((remaining % 60000) / 1000);
                $display.text(`${mins}:${secs.toString().padStart(2, '0')}`);
            }, 1000);

            $(`[data-timer-id="${timerId}"].ci-timer-start`).hide();
            $(`[data-timer-id="${timerId}"].ci-timer-stop`).show();
        },

        stop(timerId) {
            clearInterval(this.activeTimers[timerId]);
            delete this.activeTimers[timerId];
            $(`#ci-timer-${timerId}`).text('--:--');
            $(`[data-timer-id="${timerId}"].ci-timer-start`).show();
            $(`[data-timer-id="${timerId}"].ci-timer-stop`).hide();
        },

        complete(timerId) {
            this.stop(timerId);
            $(`#ci-timer-${timerId}`).text('00:00').addClass('timer-complete');

            // Notificação
            if ('Notification' in window && Notification.permission === 'granted') {
                new Notification('Timer Concluído!', {
                    body: 'Verifique sua receita.',
                    icon: '/wp-content/themes/cozinha-inventiva/assets/images/logo-icon.png'
                });
            }

            // Áudio
            const audio = new Audio('/wp-content/themes/cozinha-inventiva/assets/audio/timer.mp3');
            audio.play().catch(e => console.log('Áudio não pôde ser reproduzido'));
        }
    };

    /**
     * MÓDULO: Calculadora de Porções
     */
    const PortionCalculator = {
        originalServings: 0,
        originalIngredients: [],

        init() {
            this.cacheDom();
            this.bindEvents();
            this.saveOriginal();
        },

        cacheDom() {
            this.$servingsInput = $('#ci-servings-input');
            this.$ingredientsList = $('.wprm-recipe-ingredients');
        },

        bindEvents() {
            this.$servingsInput.on('input', () => this.calculate());
        },

        saveOriginal() {
            this.originalServings = parseInt(this.$servingsInput.val()) || 1;
            this.originalIngredients = [];

            this.$ingredientsList.find('.wprm-recipe-ingredient-amount').each((i, el) => {
                const amount = $(el).text().trim();
                this.originalIngredients.push({
                    element: el,
                    amount: this.parseAmount(amount)
                });
            });
        },

        calculate() {
            const newServings = parseInt(this.$servingsInput.val()) || 1;
            const multiplier = newServings / this.originalServings;

            this.originalIngredients.forEach(ingredient => {
                if (ingredient.amount !== null) {
                    const newAmount = this.formatAmount(ingredient.amount * multiplier);
                    $(ingredient.element).text(newAmount);
                }
            });
        },

        parseAmount(text) {
            // Remove espaços e converte para número
            const cleaned = text.replace(/\s+/g, '').replace(',', '.');
            const match = cleaned.match(/[\d.\/]+/);
            return match ? eval(match[0]) : null;
        },

        formatAmount(num) {
            // Arredondar para 2 casas decimais
            const rounded = Math.round(num * 100) / 100;
            return rounded.toString().replace('.', ',');
        }
    };

    /**
     * Inicialização dos módulos
     */
    $(document).ready(() => {
        if ($('.ci-ingredient-search').length) {
            IngredientSearch.init();
        }

        if ($('#ci-toggle-cook-mode').length) {
            CookMode.init();
        }

        if ($('.ci-checklist-item').length) {
            Checklist.init();
        }

        if ($('.ci-timer-start').length) {
            Timers.init();
        }

        if ($('#ci-servings-input').length) {
            PortionCalculator.init();
        }

        // Solicitar permissão para notificações
        if ('Notification' in window && Notification.permission === 'default') {
            Notification.requestPermission();
        }
    });

})(jQuery);
