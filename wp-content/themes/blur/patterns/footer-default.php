<?php
/**
 * Footer Default
 * 
 * slug: footer-default
 * title: Footer Default
 * categories: blur
 */

return array(
    'title'      =>__( 'Footer Default', 'blur' ),
    'categories' => array( 'blur' ),
    'content'    => '<!-- wp:group {"style":{"elements":{"link":{"color":{"text":"var:preset|color|fourground"}}}},"backgroundColor":"accent","textColor":"background","layout":{"type":"constrained"}} -->
<div class="wp-block-group has-background-color has-accent-background-color has-text-color has-background has-link-color"><!-- wp:columns {"style":{"spacing":{"padding":{"top":"50px","bottom":"50px","right":"20px","left":"20px"}}},"className":"alignwide"} -->
<div class="wp-block-columns alignwide" style="padding-top:50px;padding-right:20px;padding-bottom:50px;padding-left:20px"><!-- wp:column {"style":{"spacing":{"blockGap":"20px"}}} -->
<div class="wp-block-column"><!-- wp:heading -->
<h2>'.esc_html__('About US','blur').'</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>'.esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor ut labore et dolore magna aliqua.','blur').'</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column {"style":{"spacing":{"blockGap":"20px"}}} -->
<div class="wp-block-column"><!-- wp:heading -->
<h2>Contact US</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"left"} -->
<p class="has-text-align-left"><span class="dashicons dashicons-email-alt"></span>  '.esc_html__('info@company.com','blur').'</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><span class="dashicons dashicons-phone"></span>  '.esc_html__('+123 456 789','blur').'</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><span class="dashicons dashicons-admin-home"></span>  '.esc_html__('2080 Peaceful Lane, Chicago,IL, USA','blur').'</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column {"style":{"spacing":{"blockGap":"20px"}}} -->
<div class="wp-block-column"><!-- wp:heading -->
<h2>'.esc_html__('Product Category','blur').'</h2>
<!-- /wp:heading -->

<!-- wp:woocommerce/product-categories /--></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->

<!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center">Proudly powered by  <a href="https://themehunk.com/" data-type="URL" data-id="https://themehunk.com/" target="_blank" rel="noreferrer noopener">'.esc_html__('Themehunk','blur').'</a></p>
<!-- /wp:paragraph -->',
);