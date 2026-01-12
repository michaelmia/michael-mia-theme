<?php
$logos = get_field('logos'); // ACF repeater
if ($logos):
?>
<section class="py-2 bg-secondary logo-slider-slick">
    <div class="container-fluid px-0">
        <div class="slick-logos">

            <?php foreach ($logos as $row):
                $logo = $row['logo_image'];
                $link = $row['logo_link'];
                if (!$logo) continue;
            ?>
                <div class="logo-item d-flex justify-content-center align-items-center p-3">
                    <?php if ($link): ?>
                        <a href="<?= esc_url($link); ?>" target="_blank" rel="noopener">
                    <?php endif; ?>
                        <img
                            src="<?= esc_url($logo['url']); ?>"
                            alt="<?= esc_attr($logo['alt'] ?: 'Client logo'); ?>"
                            class="img-fluid"
                            style="max-height: 70px;"
                            loading="lazy"
                        >
                    <?php if ($link): ?></a><?php endif; ?>
                </div>
            <?php endforeach; ?>

        </div>
    </div>
</section>
<?php endif; ?>
<script>
jQuery(document).ready(function($){
    $('.slick-logos').slick({
        slidesToShow: 7,      // Number of logos per slide
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 0,      // 0 = continuous scroll
        speed: 5000,           // higher number = slower scroll
        cssEase: 'linear',     // continuous scroll effect
        infinite: true,
        arrows: false,
        dots: false,
        pauseOnHover: true,
        responsive: [
            {
                breakpoint: 1200,
                settings: {
                    slidesToShow: 6
                }
            },
            {
                breakpoint: 992,
                settings: {
                    slidesToShow: 5
                }
            },
            {
                breakpoint: 576,
                settings: {
                    slidesToShow: 3
                }
            }
        ]
    });
});
</script>
