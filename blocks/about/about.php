<?php
// Fetch fields
$title      = get_field('about_title');
$text       = get_field('about_text');
$image      = get_field('about_background');
$video      = get_field('about_background_video');
$poster     = get_field('about_background_poster');

// Block classes
$classes = 'block-about';
$classes .= !empty($block['className']) ? ' ' . esc_attr($block['className']) : '';

// Inline fallback image
$style = '';
if (!$video && $image && isset($image['url'])) {
    $style = 'style="background-image: url(' . esc_url($image['url']) . ');"';
}

$block_id = '';
if (!empty($block['anchor'])) {
    $block_id = $block['anchor'];
}
?>

<section id="<?= esc_attr($block_id); ?>" class="<?= esc_attr($classes); ?>" <?= $style; ?>>
    <?php if ($video): ?>
        <video class="block-about__video"
            autoplay muted loop playsinline preload="none" aria-hidden="true"
            <?php if ($poster && isset($poster['url'])): ?>
                poster="<?= esc_url($poster['url']); ?>"
            <?php endif; ?>>
            <source src="<?= esc_url($video['url']); ?>" type="video/mp4">
        </video>
    <?php endif; ?>

    <div class="container">
        <?php if ($title): ?>
            <h2><?= esc_html($title); ?></h2>
        <?php endif; ?>

        <?php if ($text): ?>
            <div class="block-about__text">
                <?= wp_kses_post($text); ?>
            </div>
        <?php endif; ?>
    </div>
</section>
