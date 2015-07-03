<?php
/**
 * Jetpack Compatibility File
 * See: http://jetpack.me/
 *
 * @package flux
 */

/**
 * Add theme support for Infinite Scroll.
 * See: http://jetpack.me/support/infinite-scroll/
 */
add_action( 'after_setup_theme', 'flux_jetpack_setup' );
function flux_jetpack_setup() {
	add_theme_support( 'infinite-scroll', array(
		'container' => 'main',
		'footer'    => 'page',
	) );
}
