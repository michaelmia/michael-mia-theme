<?php
add_action('acf/init', 'portable_register_acf_blocks');

function portable_register_acf_blocks() {
    if (!function_exists('acf_register_block_type')) return;

    foreach (glob(get_theme_file_path('/blocks/*'), GLOB_ONLYDIR) as $dir) {
        $slug = basename($dir);

        acf_register_block_type([
            'name'            => $slug,
            'title'           => ucfirst(str_replace('-', ' ', $slug)),
            'category'        => 'layout',
            'icon'            => 'block-default',
            'render_callback' => 'portable_block_renderer',
            'supports'        => ['align'=>true,'anchor'=>true],
        ]);
    }
}

function portable_block_renderer($block, $content = '', $is_preview = false) {
    $slug = str_replace('acf/', '', $block['name']);
    $path = get_theme_file_path("/blocks/{$slug}/{$slug}.php");

    if (file_exists($path)) include $path;
}
