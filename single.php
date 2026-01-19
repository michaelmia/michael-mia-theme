<?php
get_header(); 
?>

<main>
        <?php
        if ( have_posts() ):
            while ( have_posts() ): the_post(); 
                $title = get_the_title();
                $content = get_the_content();
                $featured_image = get_the_post_thumbnail_url(get_the_ID(), 'large');
            ?>

            <article class="post-single">
                
                <div class="blog-header text-center py-5">
                    <div class="container">
                        <?php if ($title): ?>
                            <h1 class="mb-3 text-white"><?= esc_html($title); ?></h1>
                        <?php endif; ?>
                    </div>
                    <?php if ($featured_image): ?>
                        <img src="<?= esc_url($featured_image); ?>" alt="<?= esc_attr($title); ?>" class="bg-image">
                    <?php endif; ?>
                </div>

                
                
                <div class="blog-content post-content py-5">
                    <div class="container">
                        <?= wp_kses_post($content); ?>
                    </div>
                </div>

            </article>

        <?php
            endwhile;
        endif;
        ?>
</main>

<?php get_footer(); ?>
