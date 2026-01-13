<footer class="site-footer">
    <div class="container">
        &copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. All rights reserved.
    </div>
</footer>

<?php wp_footer(); ?>

<div class="offcanvas offcanvas-end p-3 bg-dark" tabindex="-1" id="mobileMenu" aria-labelledby="mobileMenuLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="mobileMenuLabel">
            <?php if (has_custom_logo()) : ?>
                <?php the_custom_logo(); ?>
            <?php else : ?>
                <a class="navbar-brand" href="<?php echo esc_url(home_url('/')); ?>">
                    <?php bloginfo('name'); ?>
                </a>
            <?php endif; ?>
        </h5>
        <button type="button" class="btn-close bg-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>

    <div class="offcanvas-body">
        <?php
        wp_nav_menu(array(
            'theme_location' => 'primary',
            'depth'          => 2,
            'menu_class'     => 'navbar-nav flex-column',
            'fallback_cb'    => 'WP_Bootstrap_Navwalker::fallback',
            'walker'         => new WP_Bootstrap_Navwalker(),
        ));
        ?>
        <hr class="text-white">
        <a href="mailto:info@michaelmia.me" class="nav-link mt-3">info@michaelmia.me</a>
    </div>
</div>

</body>
</html>
