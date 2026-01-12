<?php
get_header(); 
?>

<main class="py-5">
    <div class="container">
        <?php
        if ( have_posts() ):
            while ( have_posts() ): the_post(); 
                $title = get_the_title();
                $content = get_the_content();
                $featured_image = get_the_post_thumbnail_url(get_the_ID(), 'large');
            ?>

            <article class="post-single">
                
                <?php if ($title): ?>
                    <h1 class="mb-3"><?= esc_html($title); ?></h1>
                <?php endif; ?>

                <?php if ($featured_image): ?>
                    <div class="mb-4 text-center">
                        <img src="<?= esc_url($featured_image); ?>" alt="<?= esc_attr($title); ?>" class="img-fluid rounded shadow-sm">
                    </div>
                <?php endif; ?>

                <div class="post-content">
                    <?= wp_kses_post($content); ?>
                </div>

            </article>

        <?php
            endwhile;
        endif;
        ?>
    </div>
</main>

<?php get_footer(); ?>
