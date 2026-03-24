<?php
/**
 * Hero Main Section
 * 
 * slug: hero-main
 * title: Hero main Section
 * categories: blur
 */

return array(
    'title'      =>__( 'Hero Main Section', 'blur' ),
    'categories' => array( 'blur' ),
    'content'    => '<!-- wp:group {"style":{"spacing":{"padding":{"top":"var:preset|spacing|80","bottom":"0"},"margin":{"top":"0","bottom":"0"}},"border":{"bottom":{"width":"0px","style":"none"}}},"backgroundColor":"secbackground","layout":{"type":"constrained"}} -->
<div class="wp-block-group has-secbackground-background-color has-background" style="border-bottom-style:none;border-bottom-width:0px;margin-top:0;margin-bottom:0;padding-top:var(--wp--preset--spacing--80);padding-bottom:0"><!-- wp:columns {"verticalAlignment":"center","align":"wide","style":{"spacing":{"padding":{"top":"0rem","bottom":"0rem"}}}} -->
<div class="wp-block-columns alignwide are-vertically-aligned-center" style="padding-top:0rem;padding-bottom:0rem"><!-- wp:column {"verticalAlignment":"center","fontSize":"extra-small"} -->
<div class="wp-block-column is-vertically-aligned-center has-extra-small-font-size"><!-- wp:image {"align":"center","id":11,"width":317,"height":442,"sizeSlug":"full","linkDestination":"none","style":{"border":{"radius":"0px"}}} -->
<figure class="wp-block-image aligncenter size-full is-resized has-custom-border"><img src="' . esc_url( BLUR_URL . 'assets/images/').'top.png" alt="" class="wp-image-11" style="border-radius:0px" width="317" height="442"/></figure>
<!-- /wp:image --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center","style":{"spacing":{"padding":{"bottom":"var:preset|spacing|60"}}}} -->
<div class="wp-block-column is-vertically-aligned-center" style="padding-bottom:var(--wp--preset--spacing--60)"><!-- wp:paragraph {"align":"left","textColor":"accent","fontSize":"medium"} -->
<p class="has-text-align-left has-accent-color has-text-color has-medium-font-size">'.esc_html__('Spring is coming, so take a look.','blur').'</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"textAlign":"left","style":{"typography":{"fontStyle":"normal","fontWeight":"700","fontSize":"3rem"},"elements":{"link":{"color":{"text":"accent"}}}},"textColor":"primary"} -->
<h2 class="has-text-align-left has-primary-color has-text-color has-link-color" style="font-size:3rem;font-style:normal;font-weight:700">'.esc_html__('Womens Collection','blur').'</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"textColor":"tertiary"} -->
<p class="has-tertiary-color has-text-color">'.esc_html__('Venenatis urna cursus eget nunc scelerisque viverra mauris. Vel pretium lectus quam id leo in vitae. Eleifend mi in nulla posuere sollicitudin','blur').'</p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"left","orientation":"horizontal"},"style":{"spacing":{"blockGap":"var:preset|spacing|50","margin":{"top":"35px"}}}} -->
<div class="wp-block-buttons" style="margin-top:35px"><!-- wp:button {"backgroundColor":"background","textColor":"primary","style":{"border":{"radius":"0px"},"spacing":{"padding":{"top":"var:preset|spacing|40","right":"var:preset|spacing|40","bottom":"var:preset|spacing|40","left":"var:preset|spacing|40"}}}} -->
<div class="wp-block-button"><a class="wp-block-button__link has-primary-color has-background-background-color has-text-color has-background wp-element-button" style="border-radius:0px;padding-top:var(--wp--preset--spacing--40);padding-right:var(--wp--preset--spacing--40);padding-bottom:var(--wp--preset--spacing--40);padding-left:var(--wp--preset--spacing--40)">SHOP NOW</a></div>
<!-- /wp:button -->

<!-- wp:button {"backgroundColor":"accent","textColor":"background","style":{"border":{"radius":"0px"},"spacing":{"padding":{"top":"var:preset|spacing|40","right":"var:preset|spacing|40","bottom":"var:preset|spacing|40","left":"var:preset|spacing|40"}}}} -->
<div class="wp-block-button"><a class="wp-block-button__link has-background-color has-accent-background-color has-text-color has-background wp-element-button" style="border-radius:0px;padding-top:var(--wp--preset--spacing--40);padding-right:var(--wp--preset--spacing--40);padding-bottom:var(--wp--preset--spacing--40);padding-left:var(--wp--preset--spacing--40)">KNOW MORE</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->',
);
