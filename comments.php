<?php
/**
 * ARQUIVO 31/32
 * PASTA: /wp-content/themes/cozinha-inventiva/
 * NOME: comments.php
 */

if ( post_password_required() ) {
    return;
}
?>

<div id="comments" class="comments-area">
    <?php if ( have_comments() ) : ?>
        <h2 class="comments-title">
            <?php
            $comments_number = get_comments_number();
            if ( '1' === $comments_number ) {
                printf( _x( 'Um comentário em &ldquo;%s&rdquo;', 'comments title', 'cozinha-inventiva' ), get_the_title() );
            } else {
                printf(
                    _nx(
                        '%1$s comentário em &ldquo;%2$s&rdquo;',
                        '%1$s comentários em &ldquo;%2$s&rdquo;',
                        $comments_number,
                        'comments title',
                        'cozinha-inventiva'
                    ),
                    number_format_i18n( $comments_number ),
                    get_the_title()
                );
            }
            ?>
        </h2>

        <ol class="comment-list">
            <?php
            wp_list_comments( array(
                'style'       => 'ol',
                'short_ping'  => true,
                'avatar_size' => 50,
            ) );
            ?>
        </ol>

        <?php
        the_comments_navigation();

        if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
            ?>
            <p class="no-comments">Os comentários estão fechados.</p>
        <?php endif; ?>

    <?php endif; ?>

    <?php comment_form(); ?>
</div>
