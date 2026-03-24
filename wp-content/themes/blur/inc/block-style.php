<?php
/**
 * Block Styles
 *
 * @link https://developer.wordpress.org/reference/functions/register_block_style/
 *
 * @package WordPress
 * @subpackage blur
 * @since blur 1.0
 */

if ( function_exists( 'register_block_style' ) ) {
	/**
	 * Register block styles.
	 *
	 * @since blur 1.0
	 *
	 * @return void
	 */
	function blur_register_block_styles() {
		

		// Image: Borders.
		register_block_style(
			'core/image',
			array(
				'name'  => 'blur-border',
				'label' => esc_html__( 'Borders', 'blur' ),
			)
		);

		
	}
	add_action( 'init', 'blur_register_block_styles' );
}