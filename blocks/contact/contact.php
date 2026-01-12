<?php
/**
 * Contact Block Template
 */

$title = get_field('contact_title');
$text  = get_field('contact_text');
$form  = get_field('contact_form'); // Post Object

$classes = 'block-contact';
$classes .= !empty($block['className']) ? ' ' . esc_attr($block['className']) : '';

$block_id = !empty($block['anchor']) ? esc_attr($block['anchor']) : '';
?>

<section id="<?= $block_id; ?>" class="<?= esc_attr($classes); ?> py-5">
    <div class="container">

        <?php if ($title): ?>
            <h2 class="mb-3"><?= esc_html($title); ?></h2>
        <?php endif; ?>

        <?php if ($text): ?>
            <div class="block-contact__text mb-4">
                <?= wp_kses_post($text); ?>
            </div>
        <?php endif; ?>

        <?php if ($form && is_object($form)): ?>
            <div class="block-contact__form">
                <?= do_shortcode('[contact-form-7 id="' . esc_attr($form->ID) . '"]'); ?>
            </div>
        <?php endif; ?>

    </div>
</section>
