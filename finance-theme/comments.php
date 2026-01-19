<?php
/**
 * Comments Template
 *
 * @package FairGoFinance
 */

if (!defined('ABSPATH')) {
    exit;
}

if (post_password_required()) {
    return;
}
?>

<div id="comments" class="comments-area">
    <?php if (have_comments()): ?>
        <h2 class="comments-title">
            <?php
            $comment_count = get_comments_number();
            if ($comment_count === '1') {
                printf(
                    esc_html__('One thought on "%1$s"', 'finance-theme'),
                    '<span>' . get_the_title() . '</span>'
                );
            } else {
                printf(
                    esc_html(_n('%1$s thought on "%2$s"', '%1$s thoughts on "%2$s"', $comment_count, 'finance-theme')),
                    number_format_i18n($comment_count),
                    '<span>' . get_the_title() . '</span>'
                );
            }
            ?>
        </h2>

        <ol class="comment-list">
            <?php
            wp_list_comments([
                'style' => 'ol',
                'short_ping' => true,
                'avatar_size' => 60,
            ]);
            ?>
        </ol>

        <?php
        the_comments_pagination([
            'prev_text' => '<span class="screen-reader-text">' . esc_html__('Previous', 'finance-theme') . '</span>',
            'next_text' => '<span class="screen-reader-text">' . esc_html__('Next', 'finance-theme') . '</span>',
        ]);
        ?>

    <?php endif; ?>

    <?php if (!comments_open() && get_comments_number() && post_type_supports(get_post_type(), 'comments')): ?>
        <p class="no-comments">
            <?php esc_html_e('Comments are closed.', 'finance-theme'); ?>
        </p>
    <?php endif; ?>

    <?php comment_form(); ?>
</div>