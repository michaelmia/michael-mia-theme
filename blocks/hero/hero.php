<?php
// Fetch fields
$title      = get_field('hero_title');
$text       = get_field('hero_blurb');
$button     = get_field('hero_button');
$bg_image   = get_field('hero_background');
$video      = get_field('hero_background_video');
$poster     = get_field('hero_background_poster'); // optional fallback image for video

// Block classes
$classes = 'block-hero';
$classes .= !empty($block['className']) ? ' ' . esc_attr($block['className']) : '';

// Inline style for fallback image (if no video)
$style = '';
if (!$video && $bg_image && isset($bg_image['url'])) {
    $style = 'style="background-image: url(' . esc_url($bg_image['url']) . ');"';
}
?>

<section class="<?= esc_attr($classes) ?>" <?= $style; ?>>
    <?php if ($video): ?>
        <video class="block-hero__video" autoplay muted loop playsinline 
            <?php if ($poster && isset($poster['url'])): ?>poster="<?= esc_url($poster['url']) ?>"<?php endif; ?>>
            <source src="<?= esc_url($video['url']) ?>" type="video/mp4">
            Your browser does not support the video tag.
        </video>
    <?php endif; ?>

    <div class="block-hero__content">
        <?php if ($title): ?>
            <h1><?= esc_html($title) ?></h1>
        <?php endif; ?>

        <?php if ($text): ?>
            <?= wp_kses_post($text); ?>
        <?php endif; ?>

        <?php if (!empty($button) && !empty($button['url'])): 
            $btn_url    = esc_url($button['url']);
            $btn_title  = !empty($button['title']) ? esc_html($button['title']) : 'Learn More';
            $btn_target = !empty($button['target']) ? esc_attr($button['target']) : '_self';
        ?>
            <a href="<?= $btn_url; ?>" target="<?= $btn_target; ?>" class="btn btn-primary">
                <?= $btn_title; ?>
            </a>
        <?php endif; ?>
    </div>
</section>

<style>
.block-hero {
    position: relative;
    overflow: hidden;
    background-size: cover;
    background-position: center;
    height: 100vh;
    min-height: 600px;
}

.block-hero__video {
    position: absolute;
    top: 50%;
    left: 50%;
    width: 100%;
    height: 100%;
    object-fit: cover;
    transform: translate(-50%, -50%);
    z-index: 0;
}

.block-hero__content {
    position: relative;
    z-index: 1;
    color: #fff;
    padding: 2rem;
    text-align: center;
    max-width: 1024px;
}
</style>
