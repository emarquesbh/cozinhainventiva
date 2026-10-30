<?php
/**
 * Widgets
 *
 * @package Cozinha_Inventiva
 * @since 1.0.0
 * 
 * Arquivo: /inc/widgets.php
 * Localização: inc/widgets.php
 * Linhas: 165
 * 
 * FUNÇÃO: Cria widget customizado "Receitas Recentes" que exibe lista de receitas mais
 * recentes com thumbnails, título e link. Permite configurar número de receitas via admin.
 * Registra widget no WordPress e estiliza com CSS inline. Pode ser adicionado em qualquer
 * sidebar.
 */

// ARQUIVO 25/42 - WIDGETS.PHP
// Localização: /inc/widgets.php
// Linhas: 165

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Widget: Receitas Recentes
 */
class Cozinha_Inventiva_Recent_Recipes_Widget extends WP_Widget {

    /**
     * Construtor
     */
    public function __construct() {
        parent::__construct(
            'ci_recent_recipes',
            __('Receitas Recentes', 'cozinha-inventiva'),
            array(
                'description' => __('Exibe as receitas mais recentes', 'cozinha-inventiva'),
            )
        );
    }

    /**
     * Front-end do widget
     */
    public function widget($args, $instance) {
        $title = !empty($instance['title']) ? $instance['title'] : __('Receitas Recentes', 'cozinha-inventiva');
        $number = !empty($instance['number']) ? absint($instance['number']) : 5;

        echo $args['before_widget'];

        if (!empty($title)) {
            echo $args['before_title'] . apply_filters('widget_title', $title) . $args['after_title'];
        }

        // Query de receitas
        $query = new WP_Query(array(
            'post_type'      => 'wprm_recipe',
            'posts_per_page' => $number,
            'orderby'        => 'date',
            'order'          => 'DESC',
        ));

        if ($query->have_posts()) :
            echo '<ul class="ci-recent-recipes-widget">';
            
            while ($query->have_posts()) : $query->the_post();
                ?>
                <li class="ci-recent-recipe-item">
                    <?php if (has_post_thumbnail()) : ?>
                        <a href="<?php the_permalink(); ?>" class="recipe-thumb">
                            <?php the_post_thumbnail('thumbnail'); ?>
                        </a>
                    <?php endif; ?>
                    
                    <div class="recipe-info">
                        <h4 class="recipe-title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h4>
                        <span class="recipe-date"><?php echo get_the_date(); ?></span>
                    </div>
                </li>
                <?php
            endwhile;
            
            echo '</ul>';
            wp_reset_postdata();
        else :
            echo '<p>' . __('Nenhuma receita encontrada.', 'cozinha-inventiva') . '</p>';
        endif;

        echo $args['after_widget'];
    }

    /**
     * Formulário do admin
     */
    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : __('Receitas Recentes', 'cozinha-inventiva');
        $number = !empty($instance['number']) ? absint($instance['number']) : 5;
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>">
                <?php esc_html_e('Título:', 'cozinha-inventiva'); ?>
            </label>
            <input 
                class="widefat" 
                id="<?php echo esc_attr($this->get_field_id('title')); ?>" 
                name="<?php echo esc_attr($this->get_field_name('title')); ?>" 
                type="text" 
                value="<?php echo esc_attr($title); ?>"
            >
        </p>
        
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('number')); ?>">
                <?php esc_html_e('Número de receitas:', 'cozinha-inventiva'); ?>
            </label>
            <input 
                class="tiny-text" 
                id="<?php echo esc_attr($this->get_field_id('number')); ?>" 
                name="<?php echo esc_attr($this->get_field_name('number')); ?>" 
                type="number" 
                step="1" 
                min="1" 
                value="<?php echo esc_attr($number); ?>" 
                size="3"
            >
        </p>
        <?php
    }

    /**
     * Atualizar widget
     */
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? sanitize_text_field($new_instance['title']) : '';
        $instance['number'] = (!empty($new_instance['number'])) ? absint($new_instance['number']) : 5;
        return $instance;
    }
}

/**
 * Registrar widgets
 */
function cozinha_inventiva_register_widgets() {
    register_widget('Cozinha_Inventiva_Recent_Recipes_Widget');
}
add_action('widgets_init', 'cozinha_inventiva_register_widgets');

/**
 * CSS do widget
 */
function cozinha_inventiva_widget_styles() {
    ?>
    <style>
    .ci-recent-recipes-widget {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    
    .ci-recent-recipe-item {
        display: flex;
        gap: 1rem;
        margin-bottom: 1rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #e2e8f0;
    }
    
    .ci-recent-recipe-item:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }
    
    .ci-recent-recipe-item .recipe-thumb {
        flex-shrink: 0;
        width: 60px;
        height: 60px;
        border-radius: 8px;
        overflow: hidden;
    }
    
    .ci-recent-recipe-item .recipe-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .ci-recent-recipe-item .recipe-info {
        flex: 1;
    }
    
    .ci-recent-recipe-item .recipe-title {
        font-size: 0.9375rem;
        margin: 0 0 0.25rem;
        line-height: 1.4;
    }
    
    .ci-recent-recipe-item .recipe-title a {
        color: #1a202c;
        transition: color 0.3s ease;
    }
    
    .ci-recent-recipe-item .recipe-title a:hover {
        color: #48bb78;
    }
    
    .ci-recent-recipe-item .recipe-date {
        font-size: 0.8125rem;
        color: #a0aec0;
    }
    </style>
    <?php
}
add_action('wp_head', 'cozinha_inventiva_widget_styles');

// Fim do arquivo widgets.php - Linha 165
