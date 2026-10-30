    </div><!-- #content -->

    <footer id="colophon" class="site-footer">
        
        <!-- Newsletter Section -->
        <?php if (is_active_sidebar('footer-newsletter') || get_theme_mod('ci_show_newsletter', true)) : ?>
        <div class="footer-newsletter">
            <div class="container">
                <div class="newsletter-content">
                    <div class="newsletter-info">
                        <h3 class="newsletter-title">
                            <?php echo get_theme_mod('ci_newsletter_title', '📬 Receba Receitas Semanais'); ?>
                        </h3>
                        <p class="newsletter-description">
                            <?php echo get_theme_mod('ci_newsletter_description', 'Assine nossa newsletter e receba receitas criativas de aproveitamento direto no seu e-mail!'); ?>
                        </p>
                    </div>
                    
                    <div class="newsletter-form">
                        <?php
                        // Se houver widget de newsletter, usar ele
                        if (is_active_sidebar('footer-newsletter')) {
                            dynamic_sidebar('footer-newsletter');
                        } else {
                            // Form padrão (pode ser integrado com Mailchimp, etc)
                            ?>
                            <form class="ci-newsletter-form" method="post" action="#" data-newsletter="true">
                                <div class="form-group">
                                    <label for="newsletter-email" class="screen-reader-text">
                                        Seu melhor e-mail
                                    </label>
                                    <input 
                                        type="email" 
                                        id="newsletter-email"
                                        name="email" 
                                        placeholder="seu@email.com"
                                        required
                                        class="newsletter-input"
                                    >
                                    <button type="submit" class="newsletter-submit">
                                        Assinar
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <line x1="5" y1="12" x2="19" y2="12"></line>
                                            <polyline points="12 5 19 12 12 19"></polyline>
                                        </svg>
                                    </button>
                                </div>
                                <p class="newsletter-privacy">
                                    Respeitamos sua privacidade. Cancele quando quiser.
                                </p>
                            </form>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <!-- Footer Widgets -->
        <?php if (is_active_sidebar('footer-1') || is_active_sidebar('footer-2') || is_active_sidebar('footer-3') || is_active_sidebar('footer-4')) : ?>
        <div class="footer-widgets">
            <div class="container">
                <div class="footer-widgets__grid">
                    
                    <?php if (is_active_sidebar('footer-1')) : ?>
                    <div class="footer-widget footer-widget-1">
                        <?php dynamic_sidebar('footer-1'); ?>
                    </div>
                    <?php endif; ?>

                    <?php if (is_active_sidebar('footer-2')) : ?>
                    <div class="footer-widget footer-widget-2">
                        <?php dynamic_sidebar('footer-2'); ?>
                    </div>
                    <?php endif; ?>

                    <?php if (is_active_sidebar('footer-3')) : ?>
                    <div class="footer-widget footer-widget-3">
                        <?php dynamic_sidebar('footer-3'); ?>
                    </div>
                    <?php endif; ?>

                    <?php if (is_active_sidebar('footer-4')) : ?>
                    <div class="footer-widget footer-widget-4">
                        <?php dynamic_sidebar('footer-4'); ?>
                    </div>
                    <?php endif; ?>

                </div>
            </div>
        </div>
        <?php endif; ?>

        <!-- Footer Main (links padrão se não houver widgets) -->
        <div class="footer-main">
            <div class="container">
                <div class="footer-main__grid">
                    
                    <!-- Sobre o Projeto -->
                    <div class="footer-column footer-column--about">
                        <h4 class="footer-title">Sobre o Cozinha Inventiva</h4>
                        <p class="footer-description">
                            <?php
                            $about_text = get_theme_mod('ci_footer_about', 'Transformando sobras em receitas deliciosas. Aprenda a reaproveitar alimentos e reduzir o desperdício de forma criativa e sustentável.');
                            echo esc_html($about_text);
                            ?>
                        </p>
                        
                        <!-- Redes Sociais no Footer -->
                        <div class="footer-social">
                            <?php
                            $social_links = [
                                'facebook' => get_theme_mod('ci_facebook_url', ''),
                                'instagram' => get_theme_mod('ci_instagram_url', ''),
                                'youtube' => get_theme_mod('ci_youtube_url', ''),
                                'pinterest' => get_theme_mod('ci_pinterest_url', '')
                            ];
                            
                            foreach ($social_links as $network => $url) :
                                if (!empty($url)) :
                            ?>
                                <a href="<?php echo esc_url($url); ?>" 
                                   target="_blank" 
                                   rel="noopener noreferrer"
                                   class="footer-social__link footer-social__link--<?php echo esc_attr($network); ?>"
                                   aria-label="<?php echo esc_attr(ucfirst($network)); ?>">
                                    <?php
                                    $icons = [
                                        'facebook' => '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>',
                                        'instagram' => '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>',
                                        'youtube' => '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>',
                                        'pinterest' => '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 5.079 3.158 9.417 7.618 11.162-.105-.949-.199-2.403.041-3.439.219-.937 1.406-5.957 1.406-5.957s-.359-.72-.359-1.781c0-1.663.967-2.911 2.168-2.911 1.024 0 1.518.769 1.518 1.688 0 1.029-.653 2.567-.992 3.992-.285 1.193.6 2.165 1.775 2.165 2.128 0 3.768-2.245 3.768-5.487 0-2.861-2.063-4.869-5.008-4.869-3.41 0-5.409 2.562-5.409 5.199 0 1.033.394 2.143.889 2.741.099.12.112.225.085.345-.09.375-.293 1.199-.334 1.363-.053.225-.172.271-.401.165-1.495-.69-2.433-2.878-2.433-4.646 0-3.776 2.748-7.252 7.92-7.252 4.158 0 7.392 2.967 7.392 6.923 0 4.135-2.607 7.462-6.233 7.462-1.214 0-2.354-.629-2.758-1.379l-.749 2.848c-.269 1.045-1.004 2.352-1.498 3.146 1.123.345 2.306.535 3.55.535 6.607 0 11.985-5.365 11.985-11.987C23.97 5.39 18.592.026 11.985.026L12.017 0z"/></svg>'
                                    ];
                                    echo $icons[$network];
                                    ?>
                                </a>
                            <?php
                                endif;
                            endforeach;
                            ?>
                        </div>
                    </div>

                    <!-- Links Rápidos -->
                    <div class="footer-column footer-column--links">
                        <h4 class="footer-title">Links Rápidos</h4>
                        <ul class="footer-menu">
                            <li><a href="<?php echo home_url('/'); ?>">Início</a></li>
                            <li><a href="<?php echo get_post_type_archive_link('wprm_recipe'); ?>">Receitas</a></li>
                            <li><a href="<?php echo get_post_type_archive_link('ci_guia'); ?>">Guias de Aproveitamento</a></li>
                            <li><a href="<?php echo get_post_type_archive_link('ci_tecnica'); ?>">Técnicas Culinárias</a></li>
                            <?php
                            $sobre = get_page_by_path('sobre');
                            if ($sobre) :
                            ?>
                            <li><a href="<?php echo get_permalink($sobre); ?>">Sobre</a></li>
                            <?php endif; ?>
                            <?php
                            $contato = get_page_by_path('contato');
                            if ($contato) :
                            ?>
                            <li><a href="<?php echo get_permalink($contato); ?>">Contato</a></li>
                            <?php endif; ?>
                        </ul>
                    </div>

                    <!-- Categorias Populares -->
                    <div class="footer-column footer-column--categories">
                        <h4 class="footer-title">Categorias Populares</h4>
                        <?php
                        $popular_terms = get_terms([
                            'taxonomy' => 'tipo_aproveitamento',
                            'orderby' => 'count',
                            'order' => 'DESC',
                            'number' => 6,
                            'hide_empty' => true
                        ]);
                        
                        if (!is_wp_error($popular_terms) && !empty($popular_terms)) :
                        ?>
                            <ul class="footer-menu">
                                <?php foreach ($popular_terms as $term) : ?>
                                <li>
                                    <a href="<?php echo get_term_link($term); ?>">
                                        <?php echo esc_html($term->name); ?>
                                        <span class="count">(<?php echo $term->count; ?>)</span>
                                    </a>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </div>

                    <!-- Informações de Contato -->
                    <div class="footer-column footer-column--contact">
                        <h4 class="footer-title">Contato</h4>
                        <ul class="footer-contact">
                            <?php
                            $email = get_theme_mod('ci_contact_email', get_bloginfo('admin_email'));
                            if ($email) :
                            ?>
                            <li class="contact-item contact-item--email">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                    <polyline points="22,6 12,13 2,6"></polyline>
                                </svg>
                                <a href="mailto:<?php echo esc_attr($email); ?>">
                                    <?php echo esc_html($email); ?>
                                </a>
                            </li>
                            <?php endif; ?>
                            
                            <?php
                            $phone = get_theme_mod('ci_contact_phone', '');
                            if ($phone) :
                            ?>
                            <li class="contact-item contact-item--phone">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                                </svg>
                                <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $phone)); ?>">
                                    <?php echo esc_html($phone); ?>
                                </a>
                            </li>
                            <?php endif; ?>
                        </ul>
                    </div>

                </div>
            </div>
        </div>

        <!-- Footer Bottom (Copyright) -->
        <div class="footer-bottom">
            <div class="container">
                <div class="footer-bottom__content">
                    <div class="footer-copyright">
                        <p>
                            &copy; <?php echo date('Y'); ?> 
                            <strong><?php bloginfo('name'); ?></strong>. 
                            Todos os direitos reservados.
                            <?php if (get_theme_mod('ci_show_credits', true)) : ?>
                            | Tema desenvolvido com 
                            <span class="heart" aria-label="amor">♥</span> 
                            para um mundo mais sustentável
                            <?php endif; ?>
                        </p>
                    </div>
                    
                    <?php
                    // Menu de rodapé (Privacidade, Termos, etc)
                    if (has_nav_menu('footer')) :
                        wp_nav_menu([
                            'theme_location' => 'footer',
                            'menu_class'     => 'footer-bottom-menu',
                            'container'      => 'nav',
                            'container_class'=> 'footer-bottom-nav',
                            'depth'          => 1
                        ]);
                    else :
                    ?>
                        <nav class="footer-bottom-nav">
                            <ul class="footer-bottom-menu">
                                <?php
                                $privacy = get_page_by_path('privacidade');
                                if ($privacy) :
                                ?>
                                <li><a href="<?php echo get_permalink($privacy); ?>">Privacidade</a></li>
                                <?php endif; ?>
                                
                                <?php
                                $terms = get_page_by_path('termos-de-uso');
                                if ($terms) :
                                ?>
                                <li><a href="<?php echo get_permalink($terms); ?>">Termos de Uso</a></li>
                                <?php endif; ?>
                            </ul>
                        </nav>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Botão Voltar ao Topo -->
        <button id="back-to-top" class="back-to-top" aria-label="Voltar ao topo">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <polyline points="18 15 12 9 6 15"></polyline>
            </svg>
        </button>

    </footer><!-- #colophon -->

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
