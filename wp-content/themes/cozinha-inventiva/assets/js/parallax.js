/**
 * Cozinha Inventiva - Parallax Effects Module
 * 
 * Efeitos parallax otimizados para:
 * - Hero sections
 * - Imagens de background
 * - Elementos decorativos
 * - Performance com requestAnimationFrame
 * 
 * @package Cozinha_Inventiva
 * @since 1.0.0
 */

(function($) {
    'use strict';

    /**
     * MÓDULO: Parallax Manager
     */
    const ParallaxManager = {
        elements: [],
        ticking: false,
        scrollPosition: 0,

        init() {
            this.cacheDom();
            this.setupElements();
            this.bindEvents();
            this.update();
        },

        cacheDom() {
            this.$window = $(window);
            this.$parallaxElements = $('[data-parallax]');
        },

        setupElements() {
            this.$parallaxElements.each((index, element) => {
                const $element = $(element);
                const speed = parseFloat($element.data('parallax-speed') || 0.5);
                const direction = $element.data('parallax-direction') || 'vertical';
                const offset = parseInt($element.data('parallax-offset') || 0);

                this.elements.push({
                    $element: $element,
                    speed: speed,
                    direction: direction,
                    offset: offset,
                    originalPosition: this.getElementPosition($element)
                });
            });
        },

        bindEvents() {
            this.$window.on('scroll', () => {
                this.scrollPosition = this.$window.scrollTop();
                this.requestTick();
            });

            this.$window.on('resize', () => {
                this.elements.forEach(item => {
                    item.originalPosition = this.getElementPosition(item.$element);
                });
                this.update();
            });
        },

        getElementPosition($element) {
            const offset = $element.offset();
            return {
                top: offset.top,
                left: offset.left
            };
        },

        requestTick() {
            if (!this.ticking) {
                window.requestAnimationFrame(() => this.update());
                this.ticking = true;
            }
        },

        update() {
            this.ticking = false;

            const windowHeight = this.$window.height();
            const scrollTop = this.scrollPosition;

            this.elements.forEach(item => {
                const elementTop = item.originalPosition.top;
                const elementVisible = (
                    elementTop < (scrollTop + windowHeight) &&
                    (elementTop + item.$element.height()) > scrollTop
                );

                if (elementVisible) {
                    const yPos = (scrollTop - elementTop) * item.speed + item.offset;
                    this.applyTransform(item, yPos);
                }
            });
        },

        applyTransform(item, yPos) {
            let transform = '';

            if (item.direction === 'vertical') {
                transform = `translate3d(0, ${yPos}px, 0)`;
            } else if (item.direction === 'horizontal') {
                transform = `translate3d(${yPos}px, 0, 0)`;
            }

            item.$element.css({
                'transform': transform,
                'will-change': 'transform'
            });
        },

        destroy() {
            this.$window.off('scroll resize');
            this.elements.forEach(item => {
                item.$element.css({
                    'transform': '',
                    'will-change': ''
                });
            });
            this.elements = [];
        }
    };

    /**
     * MÓDULO: Background Parallax
     */
    const BackgroundParallax = {
        init() {
            this.cacheDom();
            this.bindEvents();
            this.update();
        },

        cacheDom() {
            this.$window = $(window);
            this.$elements = $('.parallax-bg');
        },

        bindEvents() {
            this.$window.on('scroll', () => {
                this.requestUpdate();
            });

            this.$window.on('resize', () => {
                this.requestUpdate();
            });
        },

        requestUpdate() {
            if (!this.ticking) {
                window.requestAnimationFrame(() => this.update());
                this.ticking = true;
            }
        },

        update() {
            this.ticking = false;

            const scrollTop = this.$window.scrollTop();
            const windowHeight = this.$window.height();

            this.$elements.each((index, element) => {
                const $element = $(element);
                const elementTop = $element.offset().top;
                const elementHeight = $element.outerHeight();
                const speed = parseFloat($element.data('parallax-speed') || 0.5);

                // Verifica se elemento está visível
                if (elementTop + elementHeight > scrollTop && 
                    elementTop < scrollTop + windowHeight) {
                    
                    const yPos = (scrollTop - elementTop) * speed;
                    const bgPosition = `50% ${yPos}px`;

                    $element.css({
                        'background-position': bgPosition
                    });
                }
            });
        }
    };

    /**
     * MÓDULO: Mouse Parallax (Efeito de profundidade com mouse)
     */
    const MouseParallax = {
        init() {
            this.cacheDom();
            this.bindEvents();
        },

        cacheDom() {
            this.$containers = $('[data-mouse-parallax]');
        },

        bindEvents() {
            this.$containers.each((index, container) => {
                const $container = $(container);
                const $layers = $container.find('[data-layer-depth]');

                $container.on('mousemove', (e) => {
                    this.handleMouseMove(e, $container, $layers);
                });

                $container.on('mouseleave', () => {
                    this.resetLayers($layers);
                });
            });
        },

        handleMouseMove(e, $container, $layers) {
            const containerOffset = $container.offset();
            const containerWidth = $container.width();
            const containerHeight = $container.height();

            const mouseX = e.pageX - containerOffset.left;
            const mouseY = e.pageY - containerOffset.top;

            const percentX = (mouseX / containerWidth) - 0.5;
            const percentY = (mouseY / containerHeight) - 0.5;

            $layers.each((index, layer) => {
                const $layer = $(layer);
                const depth = parseFloat($layer.data('layer-depth') || 1);

                const moveX = percentX * depth * 50;
                const moveY = percentY * depth * 50;

                $layer.css({
                    'transform': `translate3d(${moveX}px, ${moveY}px, 0)`,
                    'transition': 'transform 0.2s ease-out'
                });
            });
        },

        resetLayers($layers) {
            $layers.css({
                'transform': 'translate3d(0, 0, 0)',
                'transition': 'transform 0.3s ease-out'
            });
        }
    };

    /**
     * MÓDULO: Scroll Reveal (Animações no scroll)
     */
    const ScrollReveal = {
        init() {
            this.cacheDom();
            this.bindEvents();
            this.reveal();
        },

        cacheDom() {
            this.$window = $(window);
            this.$elements = $('[data-reveal]');
        },

        bindEvents() {
            this.$window.on('scroll', () => {
                this.requestReveal();
            });

            this.$window.on('resize', () => {
                this.requestReveal();
            });
        },

        requestReveal() {
            if (!this.ticking) {
                window.requestAnimationFrame(() => this.reveal());
                this.ticking = true;
            }
        },

        reveal() {
            this.ticking = false;

            const scrollTop = this.$window.scrollTop();
            const windowHeight = this.$window.height();

            this.$elements.each((index, element) => {
                const $element = $(element);
                
                if ($element.hasClass('is-revealed')) {
                    return;
                }

                const elementTop = $element.offset().top;
                const revealPoint = scrollTop + windowHeight * 0.85;

                if (elementTop < revealPoint) {
                    const delay = parseInt($element.data('reveal-delay') || 0);
                    
                    setTimeout(() => {
                        $element.addClass('is-revealed');
                    }, delay);
                }
            });
        }
    };

    /**
     * MÓDULO: Parallax Image Zoom
     */
    const ParallaxZoom = {
        init() {
            this.cacheDom();
            this.bindEvents();
            this.update();
        },

        cacheDom() {
            this.$window = $(window);
            this.$elements = $('[data-parallax-zoom]');
        },

        bindEvents() {
            this.$window.on('scroll', () => {
                this.requestUpdate();
            });
        },

        requestUpdate() {
            if (!this.ticking) {
                window.requestAnimationFrame(() => this.update());
                this.ticking = true;
            }
        },

        update() {
            this.ticking = false;

            const scrollTop = this.$window.scrollTop();
            const windowHeight = this.$window.height();

            this.$elements.each((index, element) => {
                const $element = $(element);
                const elementTop = $element.offset().top;
                const elementHeight = $element.outerHeight();

                if (elementTop + elementHeight > scrollTop && 
                    elementTop < scrollTop + windowHeight) {
                    
                    const scrollPercent = (scrollTop - elementTop + windowHeight) / 
                                        (windowHeight + elementHeight);
                    const scale = 1 + (scrollPercent * 0.2); // Zoom de 1 a 1.2

                    $element.css({
                        'transform': `scale(${scale})`,
                        'transition': 'transform 0.1s ease-out'
                    });
                }
            });
        }
    };

    /**
     * UTILITÁRIO: Detecção de dispositivo móvel
     */
    const isMobile = () => {
        return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ||
               window.innerWidth < 768;
    };

    /**
     * UTILITÁRIO: Detecção de suporte a IntersectionObserver
     */
    const supportsIntersectionObserver = () => {
        return 'IntersectionObserver' in window;
    };

    /**
     * INICIALIZAÇÃO
     */
    $(document).ready(() => {
        // Desabilitar parallax em dispositivos móveis para melhor performance
        if (isMobile()) {
            console.log('Parallax desabilitado em dispositivo móvel');
            return;
        }

        // Inicializar módulos
        ParallaxManager.init();
        BackgroundParallax.init();
        MouseParallax.init();
        ScrollReveal.init();
        ParallaxZoom.init();

        console.log('Módulos parallax inicializados');
    });

    /**
     * CLEANUP: Limpar event listeners quando necessário
     */
    $(window).on('beforeunload', () => {
        ParallaxManager.destroy();
    });

})(jQuery);
