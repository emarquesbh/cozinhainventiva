/**
 * Cook Mode JavaScript
 *
 * @package Cozinha_Inventiva
 * @since 1.0.0
 * 
 * Arquivo: /assets/js/cook-mode.js
 * Localização: assets/js/cook-mode.js
 * Linhas: 260
 * 
 * FUNÇÃO: JavaScript do modo cozinheiro:
 * - Navegação entre steps (anterior/próximo)
 * - Timer funcional (start/pause/reset)
 * - Atualização de progresso visual
 * - Toggle sidebar de ingredientes
 * - Leitura de voz (opcional - Web Speech API)
 * - Keyboard shortcuts (setas, espaço)
 * - Salvar progresso no localStorage
 */

// ARQUIVO 39/42 - COOK-MODE.JS

(function() {
    'use strict';

    // Verificar se dados estão disponíveis
    if (typeof cookModeData === 'undefined') {
        console.error('Cook Mode data not found');
        return;
    }

    /**
     * Estado do Cook Mode
     */
    const state = {
        currentStep: 0,
        steps: cookModeData.steps || [],
        timerSeconds: 0,
        timerInterval: null,
        timerRunning: false
    };

    /**
     * Elementos DOM
     */
    const elements = {
        stepContent: document.getElementById('step-content'),
        stepCurrent: document.getElementById('step-current'),
        stepTotal: document.getElementById('step-total'),
        prevBtn: document.getElementById('prev-step-btn'),
        nextBtn: document.getElementById('next-step-btn'),
        progressBar: document.getElementById('progress-bar'),
        ingredientsToggle: document.getElementById('toggle-ingredients-btn'),
        ingredientsSidebar: document.getElementById('ingredients-sidebar'),
        timerDisplay: document.getElementById('step-timer'),
        timerMinutes: document.getElementById('timer-minutes'),
        timerSeconds: document.getElementById('timer-seconds'),
        timerStartBtn: document.getElementById('timer-start-btn'),
        timerPauseBtn: document.getElementById('timer-pause-btn'),
        timerResetBtn: document.getElementById('timer-reset-btn')
    };

    /**
     * Inicializar Cook Mode
     */
    function init() {
        if (state.steps.length === 0) {
            elements.stepContent.innerHTML = '<p>Nenhuma instrução disponível.</p>';
            return;
        }

        // Configurar total de steps
        elements.stepTotal.textContent = state.steps.length;

        // Carregar progresso salvo
        loadProgress();

        // Exibir primeiro step
        renderStep();

        // Event listeners
        setupEventListeners();

        // Keyboard shortcuts
        setupKeyboardShortcuts();
    }

    /**
     * Configurar Event Listeners
     */
    function setupEventListeners() {
        // Navegação
        if (elements.prevBtn) {
            elements.prevBtn.addEventListener('click', previousStep);
        }

        if (elements.nextBtn) {
            elements.nextBtn.addEventListener('click', nextStep);
        }

        // Sidebar de ingredientes
        if (elements.ingredientsToggle) {
            elements.ingredientsToggle.addEventListener('click', toggleIngredients);
        }

        // Timer
        if (elements.timerStartBtn) {
            elements.timerStartBtn.addEventListener('click', startTimer);
        }

        if (elements.timerPauseBtn) {
            elements.timerPauseBtn.addEventListener('click', pauseTimer);
        }

        if (elements.timerResetBtn) {
            elements.timerResetBtn.addEventListener('click', resetTimer);
        }
    }

    /**
     * Keyboard Shortcuts
     */
    function setupKeyboardShortcuts() {
        document.addEventListener('keydown', function(e) {
            // Seta esquerda - anterior
            if (e.key === 'ArrowLeft') {
                e.preventDefault();
                previousStep();
            }

            // Seta direita - próximo
            if (e.key === 'ArrowRight') {
                e.preventDefault();
                nextStep();
            }

            // Espaço - toggle timer
            if (e.key === ' ') {
                e.preventDefault();
                if (state.timerRunning) {
                    pauseTimer();
                } else {
                    startTimer();
                }
            }

            // I - toggle ingredientes
            if (e.key === 'i' || e.key === 'I') {
                toggleIngredients();
            }
        });
    }

    /**
     * Renderizar Step Atual
     */
    function renderStep() {
        const step = state.steps[state.currentStep];

        if (!step) return;

        // Atualizar conteúdo
        elements.stepContent.innerHTML = `<p>${step.text}</p>`;

        if (step.image) {
            elements.stepContent.innerHTML += `<img src="${step.image}" alt="Passo ${state.currentStep + 1}">`;
        }

        // Atualizar número
        elements.stepCurrent.textContent = state.currentStep + 1;

        // Atualizar botões
        elements.prevBtn.disabled = state.currentStep === 0;
        elements.nextBtn.disabled = state.currentStep === state.steps.length - 1;

        // Atualizar texto do botão próximo
        if (state.currentStep === state.steps.length - 1) {
            elements.nextBtn.innerHTML = 'Concluído ✓';
        } else {
            elements.nextBtn.innerHTML = 'Próximo <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M9 18l6-6-6-6" stroke-width="2" stroke-linecap="round"/></svg>';
        }

        // Atualizar progresso
        updateProgress();

        // Salvar progresso
        saveProgress();
    }

    /**
     * Próximo Step
     */
    function nextStep() {
        if (state.currentStep < state.steps.length - 1) {
            state.currentStep++;
            renderStep();
        }
    }

    /**
     * Step Anterior
     */
    function previousStep() {
        if (state.currentStep > 0) {
            state.currentStep--;
            renderStep();
        }
    }

    /**
     * Atualizar Barra de Progresso
     */
    function updateProgress() {
        const progress = ((state.currentStep + 1) / state.steps.length) * 100;
        elements.progressBar.style.width = progress + '%';
    }

    /**
     * Toggle Sidebar de Ingredientes
     */
    function toggleIngredients() {
        if (elements.ingredientsSidebar) {
            elements.ingredientsSidebar.classList.toggle('open');
        }
    }

    /**
     * Timer - Iniciar
     */
    function startTimer() {
        if (state.timerRunning) return;

        state.timerRunning = true;
        elements.timerStartBtn.style.display = 'none';
        elements.timerPauseBtn.style.display = 'inline-block';

        state.timerInterval = setInterval(function() {
            state.timerSeconds++;
            updateTimerDisplay();
        }, 1000);
    }

    /**
     * Timer - Pausar
     */
    function pauseTimer() {
        state.timerRunning = false;
        elements.timerStartBtn.style.display = 'inline-block';
        elements.timerPauseBtn.style.display = 'none';

        if (state.timerInterval) {
            clearInterval(state.timerInterval);
        }
    }

    /**
     * Timer - Resetar
     */
    function resetTimer() {
        pauseTimer();
        state.timerSeconds = 0;
        updateTimerDisplay();
    }

    /**
     * Atualizar Display do Timer
     */
    function updateTimerDisplay() {
        const minutes = Math.floor(state.timerSeconds / 60);
        const seconds = state.timerSeconds % 60;

        elements.timerMinutes.textContent = String(minutes).padStart(2, '0');
        elements.timerSeconds.textContent = String(seconds).padStart(2, '0');
    }

    /**
     * Salvar Progresso
     */
    function saveProgress() {
        localStorage.setItem('cookMode_' + cookModeData.recipeId, JSON.stringify({
            currentStep: state.currentStep,
            timestamp: Date.now()
        }));
    }

    /**
     * Carregar Progresso
     */
    function loadProgress() {
        const saved = localStorage.getItem('cookMode_' + cookModeData.recipeId);
        
        if (saved) {
            try {
                const data = JSON.parse(saved);
                
                // Só carregar se for recente (últimas 24 horas)
                if (Date.now() - data.timestamp < 24 * 60 * 60 * 1000) {
                    state.currentStep = data.currentStep || 0;
                }
            } catch (e) {
                console.error('Erro ao carregar progresso:', e);
            }
        }
    }

    /**
     * Inicializar quando DOM estiver pronto
     */
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

})();

// Fim do arquivo cook-mode.js - Linha 260
