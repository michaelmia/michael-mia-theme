<?php
/**
 * FAQs Block Template
 */

$block_id = !empty($block['anchor'])
    ? esc_attr($block['anchor'])
    : 'faqs-' . esc_attr($block['id']);

$classes = 'block-faqs';
$classes .= !empty($block['className']) ? ' ' . esc_attr($block['className']) : '';
?>

<?php if (have_rows('faqs')): ?>
<section id="<?= $block_id; ?>" class="<?= esc_attr($classes); ?> py-5">
    <div class="container">
        <h2 class="text-center mb-4">Frequently Asked Questions</h2>
        <div class="accordion" id="<?= $block_id; ?>-accordion">
            <?php
            $i = 0;
            while (have_rows('faqs')): the_row();
                $question = get_sub_field('question');
                $answer   = get_sub_field('answer');
                if (!$question || !$answer) continue;

                $item_id = $block_id . '-item-' . $i;
            ?>
                <div class="accordion-item">
                    <div class="accordion-header" id="<?= esc_attr($item_id); ?>-heading">
                        <button
                            class="accordion-button <?= $i !== 0 ? 'collapsed' : ''; ?>"
                            type="button"
                            data-bs-toggle="collapse"
                            data-bs-target="#<?= esc_attr($item_id); ?>"
                            aria-expanded="<?= $i === 0 ? 'true' : 'false'; ?>"
                            aria-controls="<?= esc_attr($item_id); ?>">
                            <h4 class="mb-0"><?= esc_html($question); ?></h4>
                        </button>
                    </div>

                    <div
                        id="<?= esc_attr($item_id); ?>"
                        class="accordion-collapse collapse <?= $i === 0 ? 'show' : ''; ?>"
                        aria-labelledby="<?= esc_attr($item_id); ?>-heading"
                        data-bs-parent="#<?= $block_id; ?>-accordion">

                        <div class="accordion-body p-4">
                            <?= wp_kses_post($answer); ?>
                        </div>
                    </div>
                </div>
            <?php $i++; endwhile; ?>
        </div>

    </div>
</section>
<?php endif; ?>
