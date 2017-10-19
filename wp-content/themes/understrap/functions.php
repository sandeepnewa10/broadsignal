<?php
/**
 * Understrap functions and definitions
 *
 * @package understrap
 */

/**
 * Theme setup and custom theme supports.
 */
require get_template_directory() . '/inc/setup.php';

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
require get_template_directory() . '/inc/widgets.php';

/**
 * Load functions to secure your WP install.
 */
require get_template_directory() . '/inc/security.php';

/**
 * Enqueue scripts and styles.
 */
require get_template_directory() . '/inc/enqueue.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/pagination.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/custom-comments.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Load custom WordPress nav walker.
 */
require get_template_directory() . '/inc/bootstrap-wp-navwalker.php';

/**
 * Load WooCommerce functions.
 */
require get_template_directory() . '/inc/woocommerce.php';

/**
 * Load Editor functions.
 */
require get_template_directory() . '/inc/editor.php';





//remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );

/*********
Woocommerce composite product
************/

/* Display 4 column */
add_filter( 'woocommerce_composite_component_loop_columns', 'wc_cp_component_loop_columns', 10, 3 );
function wc_cp_component_loop_columns( $cols, $component_id, $composite ) {
	$cols = 4;
	return $cols;
}

/* Display total number in product page */
add_filter( 'woocommerce_component_options_per_page', 'wc_cp_component_options_per_page', 10, 3 );
function wc_cp_component_options_per_page( $results_count, $component_id, $composite ) {
	$results_count = 12;
	return $results_count;
}