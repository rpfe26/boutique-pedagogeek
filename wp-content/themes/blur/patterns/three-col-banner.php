<?php
/**
 * Three Col Banner Section
 * 
 * slug: three-col-banner
 * title: Three Col Banner
 * categories: blur
 */

return array(
    'title'      =>__( 'Three Col Banner', 'blur' ),
    'categories' => array( 'blur' ),
    'content'    => '<!-- wp:group {"style":{"spacing":{"padding":{"top":"var:preset|spacing|40","bottom":"var:preset|spacing|40"},"margin":{"top":"0","bottom":"0"}},"border":{"bottom":{"width":"0px","style":"none"}}},"backgroundColor":"background","layout":{"type":"constrained"}} -->
<div class="wp-block-group has-background-background-color has-background" style="border-bottom-style:none;border-bottom-width:0px;margin-top:0;margin-bottom:0;padding-top:var(--wp--preset--spacing--40);padding-bottom:var(--wp--preset--spacing--40)"><!-- wp:columns {"verticalAlignment":"center","align":"wide","style":{"spacing":{"padding":{"top":"2rem","bottom":"2rem"}}},"className":"blur-theme-col"} -->
<div class="wp-block-columns alignwide are-vertically-aligned-center blur-theme-col" style="padding-top:2rem;padding-bottom:2rem"><!-- wp:column {"verticalAlignment":"center"} -->
<div class="wp-block-column is-vertically-aligned-center"><!-- wp:image {"align":"center","id":26,"sizeSlug":"full","linkDestination":"none","style":{"border":{"radius":"0px"}}} -->
<figure class="wp-block-image aligncenter size-full has-custom-border"><img src="' . esc_url( BLUR_URL . 'assets/images/').'banneron.png" alt="" class="wp-image-26" style="border-radius:0px"/></figure>
<!-- /wp:image --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center"} -->
<div class="wp-block-column is-vertically-aligned-center"><!-- wp:image {"align":"center","id":23,"sizeSlug":"full","linkDestination":"none","style":{"border":{"radius":"0px"}}} -->
<figure class="wp-block-image aligncenter size-full has-custom-border"><img src="' . esc_url( BLUR_URL . 'assets/images/').'bannertwo.png" alt="" class="wp-image-23" style="border-radius:0px"/></figure>
<!-- /wp:image --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center"} -->
<div class="wp-block-column is-vertically-aligned-center"><!-- wp:image {"align":"center","id":25,"sizeSlug":"full","linkDestination":"none","style":{"border":{"radius":"0px"}}} -->
<figure class="wp-block-image aligncenter size-full has-custom-border"><img src="' . esc_url( BLUR_URL . 'assets/images/').'bannerthree.png" alt="" class="wp-image-25" style="border-radius:0px"/></figure>
<!-- /wp:image --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->',
);



