<?php
// Optional block settings
$block_classes = 'portfolio-block';
$block_classes .= !empty($block['className']) ? ' ' . esc_attr($block['className']) : '';


$block_id = '';
if (!empty($block['anchor'])) {
    $block_id = $block['anchor'];
}

// Fetch portfolio items (from CPT)
$args = array(
    'post_type' => 'portfolio',
    'posts_per_page' => -1,
    'orderby' => 'title',
    'order' => 'ASC',
);
$portfolio_query = new WP_Query($args);

if ($portfolio_query->have_posts()):
?>
<section id="<?= esc_attr($block_id); ?>" class="<?= esc_attr($block_classes); ?> py-5 bg-secondary">
    <div class="container py-0 py-md-5">
        <h2 class="text-white text-center mb-1">Recent Projects</h2>
        <p class="text-white text-center mb-3">Each project is built with performance, usability, and scalability in mind. I focus on solving real business problems — not just making things look good.</p>
        <div class="portfolio-slider">
            <?php while ($portfolio_query->have_posts()): $portfolio_query->the_post(); 
                $post_id = get_the_ID();
                $title = get_the_title();
                $screenshot = get_field('website_screenshot', $post_id);
                $description = get_field('website_description', $post_id);
                $url = get_field('website_url', $post_id);
                $tags = get_field('website_tags', $post_id);

                // Handle image
                $image_url = '';
                $image_alt = '';
                if ($screenshot) {
                    if (is_array($screenshot)) {
                        $image_url = $screenshot['url'] ?? '';
                        $image_alt = $screenshot['alt'] ?? '';
                    } elseif (is_numeric($screenshot)) {
                        $image_url = wp_get_attachment_image_url($screenshot, 'full');
                        $image_alt = get_post_meta($screenshot, '_wp_attachment_image_alt', true);
                    } else {
                        $image_url = $screenshot;
                    }
                }
            ?>
                <div class="portfolio-slide px-2">
                    <div class="card h-100 d-flex flex-column glass-card">
                        <?php if ($url && $image_url): ?>
                            <a href="<?= esc_url($url); ?>" target="_blank" rel="noopener">
                        <?php endif; ?>
                        <?php if ($image_url): ?>
                            <img src="<?= esc_url($image_url); ?>" alt="<?= esc_attr($image_alt); ?>" class="card-img-top img-fluid" loading="lazy">
                        <?php endif; ?>
                        <?php if ($url && $image_url): ?></a><?php endif; ?>
                        <div class="card-body d-flex flex-column">
                            <h3 class="card-title"><?= esc_html($title); ?></h3>
                            <?php if ($tags && is_array($tags)): ?>
                                <div class="mb-2">
                                    <?php foreach ($tags as $tag_item):
                                        $tag = $tag_item['tag'] ?? '';
                                        if (!$tag) continue;
                                    ?>
                                        <span class="badge rounded-pill bg-primary me-1 mb-1"><?= esc_html($tag); ?></span>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                            <?php if ($description): ?>
                                <small class="card-text flex-grow-1 mb-3">
                                    <?= wp_kses_post( wp_html_excerpt($description, 200) . '...' ); ?>
                                </small>
                            <?php endif; ?>
                            <?php if ($url): ?>
                                <a href="<?= esc_url($url); ?>" target="_blank" rel="noopener" class="mt-auto btn btn-outline-primary">
                                    Visit Website
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</section>

<!-- Slick Slider JS Init -->
<script type="text/javascript">
jQuery(document).ready(function($){
    $('.portfolio-slider').slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        infinite: true,
        dots: false,
        arrows: true,
        autoplay: true,
        autoplaySpeed: 4000,
        adaptiveHeight: false,
        responsive: [
            {
                breakpoint: 992, // tablet
                settings: {
                    slidesToShow: 2
                }
            },
            {
                breakpoint: 576, // mobile
                settings: {
                    slidesToShow: 1
                }
            }
        ]
    });
});
</script>

<?php endif; wp_reset_postdata(); ?>
