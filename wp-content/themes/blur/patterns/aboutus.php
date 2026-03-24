<?php
/**
 * Aboutus Section
 * 
 * slug: about-us
 * title: Aboutus
 * categories: blur
 */

return array(
    'title'      =>__( 'Aboutus', 'blur' ),
    'categories' => array( 'blur' ),
    'content'    => '<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|80","right":"var:preset|spacing|70","bottom":"var:preset|spacing|80","left":"var:preset|spacing|70"},"blockGap":"0"}},"backgroundColor":"fourground","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull has-fourground-background-color has-background" style="padding-top:var(--wp--preset--spacing--80);padding-right:var(--wp--preset--spacing--70);padding-bottom:var(--wp--preset--spacing--80);padding-left:var(--wp--preset--spacing--70)"><!-- wp:columns {"align":"wide"} -->
<div class="wp-block-columns alignwide"><!-- wp:column {"verticalAlignment":"center"} -->
<div class="wp-block-column is-vertically-aligned-center"><!-- wp:heading {"style":{"typography":{"fontStyle":"normal","fontWeight":"400"}},"textColor":"primary","fontSize":"large"} -->
<h2 class="has-primary-color has-text-color has-large-font-size" style="font-style:normal;font-weight:400">'.esc_html__('Uniquely-Designed, Made In The UAE, And Comfortable','blur').'</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"style":{"typography":{"lineHeight":"1.6"}},"textColor":"tertiary","fontSize":"small"} -->
<p class="has-tertiary-color has-text-color has-small-font-size" style="line-height:1.6">'.esc_html__('Mauris tempus leo orci, sagittis aliquam ligula euismod ut. Vivamus laoreet eu felis ut dignissim. Nam elementum sem sed eros dapibus auctor. Etiam vulputate convallis sem eu maximus. Donec et molestie dui, vitae consequat libero. Nullam semper, tellus sed placerat placerat,','blur').'</p>
<!-- /wp:paragraph -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"textColor":"accent","style":{"spacing":{"padding":{"top":"1rem","right":"1rem","bottom":"1rem","left":"1rem"}}},"className":"is-style-outline"} -->
<div class="wp-block-button is-style-outline"><a class="wp-block-button__link has-accent-color has-text-color wp-element-button" style="padding-top:1rem;padding-right:1rem;padding-bottom:1rem;padding-left:1rem">'.esc_html__('Explore More','blur').'</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center"} -->
<div class="wp-block-column is-vertically-aligned-center"><!-- wp:image {"align":"center","id":710,"sizeSlug":"full","linkDestination":"none"} -->
<figure class="wp-block-image aligncenter size-full"><img src="' . esc_url( BLUR_URL . 'assets/images/').'ab.png" alt="" class="wp-image-710"/></figure>
<!-- /wp:image --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->',
);