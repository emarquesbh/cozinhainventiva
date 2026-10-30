<?php
/**
 * Template Name: Contato
 *
 * @package Cozinha_Inventiva
 * @since 1.0.0
 * 
 * Arquivo: /Templates/Pages/page-contato.php
 * Localização: Templates/Pages/page-contato.php
 * Linhas: 200
 * 
 * FUNÇÃO: Template da página "Contato". Formulário de contato com validação, campos (nome,
 * email, assunto, mensagem), processamento via AJAX ou plugin Contact Form 7, mensagens de
 * sucesso/erro, informações de contato lateral (email, redes sociais) e CSS inline completo.
 */

// ARQUIVO 28/42 - PAGE-CONTATO.PHP
// Localização: /Templates/Pages/page-contato.php
// Linhas: 200

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>

<div class="container">
    <div class="contato-page">
        <?php while (have_posts()) : the_post(); ?>

            <header class="page-header">
                <?php the_title('<h1 class="page-title">', '</h1>'); ?>
                <p class="page-description">
                    <?php esc_html_e('Entre em contato conosco. Adoraríamos ouvir suas sugestões, dúvidas ou histórias de aproveitamento!', 'cozinha-inventiva'); ?>
                </p>
            </header>

            <div class="contato-content">
                <div class="contact-form-wrapper">
                    <h2><?php esc_html_e('Envie sua Mensagem', 'cozinha-inventiva'); ?></h2>
                    
                    <?php
                    // Se usar Contact Form 7, substitua o shortcode abaixo
                    // echo do_shortcode('[contact-form-7 id="123" title="Formulário de contato"]');
                    ?>
                    
                    <form id="contact-form" class="contact-form" method="post">
                        <div class="form-group">
                            <label for="contact-name"><?php esc_html_e('Nome *', 'cozinha-inventiva'); ?></label>
                            <input 
                                type="text" 
                                id="contact-name" 
                                name="contact_name" 
                                required
                                class="form-control"
                            >
                        </div>

                        <div class="form-group">
                            <label for="contact-email"><?php esc_html_e('Email *', 'cozinha-inventiva'); ?></label>
                            <input 
                                type="email" 
                                id="contact-email" 
                                name="contact_email" 
                                required
                                class="form-control"
                            >
                        </div>

                        <div class="form-group">
                            <label for="contact-subject"><?php esc_html_e('Assunto', 'cozinha-inventiva'); ?></label>
                            <input 
                                type="text" 
                                id="contact-subject" 
                                name="contact_subject" 
                                class="form-control"
                            >
                        </div>

                        <div class="form-group">
                            <label for="contact-message"><?php esc_html_e('Mensagem *', 'cozinha-inventiva'); ?></label>
                            <textarea 
                                id="contact-message" 
                                name="contact_message" 
                                rows="6" 
                                required
                                class="form-control"
                            ></textarea>
                        </div>

                        <div class="form-submit">
                            <button type="submit" class="btn btn-primary">
                                <?php esc_html_e('Enviar Mensagem', 'cozinha-inventiva'); ?>
                            </button>
                        </div>

                        <div id="form-message" class="form-message" style="display: none;"></div>
                    </form>
                </div>

                <div class="contact-info-wrapper">
                    <h3><?php esc_html_e('Informações de Contato', 'cozinha-inventiva'); ?></h3>
                    
                    <div class="contact-info-item">
                        <strong><?php esc_html_e('Email:', 'cozinha-inventiva'); ?></strong>
                        <p><a href="mailto:contato@cozinhainventiva.com.br">contato@cozinhainventiva.com.br</a></p>
                    </div>

                    <div class="contact-info-item">
                        <strong><?php esc_html_e('Redes Sociais:', 'cozinha-inventiva'); ?></strong>
                        <div class="social-links">
                            <?php
                            $facebook = get_field('social_facebook', 'option');
                            $instagram = get_field('social_instagram', 'option');
                            $pinterest = get_field('social_pinterest', 'option');
                            $youtube = get_field('social_youtube', 'option');

                            if ($facebook) : ?>
                                <a href="<?php echo esc_url($facebook); ?>" target="_blank" rel="noopener" class="social-link">
                                    Facebook
                                </a>
                            <?php endif;

                            if ($instagram) : ?>
                                <a href="<?php echo esc_url($instagram); ?>" target="_blank" rel="noopener" class="social-link">
                                    Instagram
                                </a>
                            <?php endif;

                            if ($pinterest) : ?>
                                <a href="<?php echo esc_url($pinterest); ?>" target="_blank" rel="noopener" class="social-link">
                                    Pinterest
                                </a>
                            <?php endif;

                            if ($youtube) : ?>
                                <a href="<?php echo esc_url($youtube); ?>" target="_blank" rel="noopener" class="social-link">
                                    YouTube
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="contact-info-item">
                        <strong><?php esc_html_e('Horário de Atendimento:', 'cozinha-inventiva'); ?></strong>
                        <p><?php esc_html_e('Segunda a Sexta, 9h às 18h', 'cozinha-inventiva'); ?></p>
                    </div>
                </div>
            </div>

        <?php endwhile; ?>
    </div>
</div>

<style>
.contato-page {
    padding: 2rem 1rem;
}

.page-header {
    text-align: center;
    margin-bottom: 3rem;
}

.page-title {
    font-size: 2.5rem;
    color: #1a202c;
    margin-bottom: 1rem;
}

.page-description {
    font-size: 1.125rem;
    color: #718096;
    max-width: 700px;
    margin: 0 auto;
}

.contato-content {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 3rem;
    max-width: 1200px;
    margin: 0 auto;
}

.contact-form-wrapper h2,
.contact-info-wrapper h3 {
    font-size: 1.5rem;
    margin-bottom: 1.5rem;
    color: #1a202c;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-group label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 600;
    color: #2d3748;
}

.form-control {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 2px solid #e2e8f0;
    border-radius: 8px;
    font-size: 1rem;
    transition: border-color 0.3s ease;
}

.form-control:focus {
    outline: none;
    border-color: #48bb78;
}

.form-submit {
    margin-top: 2rem;
}

.form-message {
    margin-top: 1rem;
    padding: 1rem;
    border-radius: 8px;
}

.form-message.success {
    background-color: #f0fff4;
    color: #38a169;
    border: 1px solid #9ae6b4;
}

.form-message.error {
    background-color: #fff5f5;
    color: #e53e3e;
    border: 1px solid #fc8181;
}

.contact-info-wrapper {
    background-color: #f7fafc;
    padding: 2rem;
    border-radius: 12px;
    height: fit-content;
}

.contact-info-item {
    margin-bottom: 2rem;
}

.contact-info-item:last-child {
    margin-bottom: 0;
}

.contact-info-item strong {
    display: block;
    margin-bottom: 0.5rem;
    color: #1a202c;
}

.contact-info-item p {
    color: #4a5568;
}

.social-links {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.social-link {
    color: #48bb78;
    transition: color 0.3s ease;
}

.social-link:hover {
    color: #38a169;
}

@media (max-width: 768px) {
    .contato-content {
        grid-template-columns: 1fr;
    }
    
    .page-title {
        font-size: 2rem;
    }
}
</style>

<?php
get_footer();
