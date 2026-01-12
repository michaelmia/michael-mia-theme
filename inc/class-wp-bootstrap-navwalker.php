<?php
/**
 * WP Bootstrap Navwalker
 *
 * @package WP_Bootstrap_Navwalker
 */

/**
 * Class WP_Bootstrap_Navwalker
 *
 * A custom WordPress nav walker class to fully implement the Bootstrap 4
 * navigation style in a custom theme using the WordPress built‑in menu manager.
 *
 * Original: https://github.com/wp‑bootstrap/wp‑bootstrap‑navwalker
 */
if ( ! class_exists( 'WP_Bootstrap_Navwalker' ) ) :

class WP_Bootstrap_Navwalker extends Walker_Nav_Menu {

    /**
     * Starts the list before the elements are added.
     *
     * @see Walker::start_lvl()
     * @since 3.0.0
     *
     * @param string   &$output Used to append additional content (passed by reference).
     * @param int      $depth   Depth of menu item. Used for padding.
     * @param stdClass $args    An object of wp_nav_menu() arguments.
     */
    public function start_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = str_repeat( "\t", $depth );
        $output .= "\n$indent<ul class=\"dropdown-menu\" aria-labelledby=\"navbarDropdown\">\n";
    }

    /**
     * Starts the element output.
     *
     * @see Walker::start_el()
     * @since 3.0.0
     *
     * @param string   &$output Used to append additional content (passed by reference).
     * @param WP_Post  $item    Menu item data object.
     * @param int      $depth   Depth of menu item. Used for padding.
     * @param stdClass $args    An object of wp_nav_menu() arguments.
     * @param int      $id      Current item ID.
     */
    public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

        $classes = empty( $item->classes ) ? array() : (array) $item->classes;

        $classes[] = 'nav-item';

        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
        $class_names = ' class="' . esc_attr( $class_names ) . '"';

        $output .= $indent . '<li' . $class_names . '>';

        $atts = array();
        $atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
        $atts['target'] = ! empty( $item->target )     ? $item->target     : '';
        $atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
        $atts['href']   = ! empty( $item->url )        ? $item->url        : '';

        $atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );

        $attributes = '';
        foreach ( $atts as $attr => $value ) {
            if ( ! empty( $value ) ) {
                $value       = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }

        $item_output  = $args->before;
        $item_output .= '<a class="nav-link"' . $attributes . '>';
        $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
        $item_output .= '</a>';
        $item_output .= $args->after;

        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }

    /**
     * Traverse elements to create list from elements.
     *
     * @see Walker::walk()
     * @since 3.0.0
     *
     * @param array   $elements Menu elements to traverse.
     * @param int     $max_depth Maximum depth to traverse.
     * @param mixed   ...$args Additional arguments.
     * @return string
     */
    public function walk( $elements, $max_depth, ...$args ) {
        return parent::walk( $elements, $max_depth, ...$args );
    }
}

endif;
