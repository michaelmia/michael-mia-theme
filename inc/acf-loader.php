<?php
if (!class_exists('ACF')) {
    define('PORTABLE_ACF_PATH', get_stylesheet_directory() . '/acf/');
    define('PORTABLE_ACF_URL', get_stylesheet_directory_uri() . '/acf/');

    include_once PORTABLE_ACF_PATH . 'acf.php';

    add_filter('acf/settings/url', function () {
        return PORTABLE_ACF_URL;
    });

    // Show only for admins
    add_filter('acf/settings/show_admin', function () {
        return current_user_can('manage_options');
    });
}
