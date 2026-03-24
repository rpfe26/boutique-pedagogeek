<?php
/**
 * Banner Section
 * 
 * slug: banner
 * title: Banner
 * categories: blur
 */

return array(
    'title'      =>__( 'Banner', 'blur' ),
    'categories' => array( 'blur' ),
    'content'    => '<!-- wp:group {"style":{"spacing":{"padding":{"top":"0","bottom":"0"},"margin":{"top":"0","bottom":"0"},"blockGap":"0"},"border":{"bottom":{"width":"0px","style":"none"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" style="border-bottom-style:none;border-bottom-width:0px;margin-top:0;margin-bottom:0;padding-top:0;padding-bottom:0"><!-- wp:cover {"url":"' . esc_url( BLUR_URL . 'assets/images/').'bg.png","id":708,"hasParallax":true,"isRepeated":true,"dimRatio":90,"overlayColor":"primary","align":"full"} -->
<div class="wp-block-cover alignfull has-parallax is-repeated"><span aria-hidden="true" class="wp-block-cover__background has-primary-background-color has-background-dim-90 has-background-dim"></span><div role="img" class="wp-block-cover__image-background wp-image-708 has-parallax is-repeated" style="background-position:50% 50%;background-image:url(' . esc_url( BLUR_URL . 'assets/images/').'bg.png)"></div><div class="wp-block-cover__inner-container"><!-- wp:heading {"textAlign":"center","style":{"spacing":{"padding":{"top":"0","right":"0","bottom":"0","left":"0"},"margin":{"top":"0","right":"0","bottom":"0","left":"0"}}},"textColor":"background","fontSize":"extra-large"} -->
<h2 class="has-text-align-center has-background-color has-text-color has-extra-large-font-size" style="margin-top:0;margin-right:0;margin-bottom:0;margin-left:0;padding-top:0;padding-right:0;padding-bottom:0;padding-left:0">'.esc_html__('Get Flat 30% off on','blur').' </h2>
<!-- /wp:heading -->

<!-- wp:heading {"textAlign":"center","style":{"spacing":{"padding":{"top":"0","right":"0","bottom":"0","left":"0"},"margin":{"top":"0","right":"0","bottom":"0","left":"0"}}},"textColor":"background","fontSize":"extra-large"} -->
<h2 class="has-text-align-center has-background-color has-text-color has-extra-large-font-size" style="margin-top:0;margin-right:0;margin-bottom:0;margin-left:0;padding-top:0;padding-right:0;padding-bottom:0;padding-left:0">your first purchase<br></h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center","textColor":"background","fontSize":"upper-heading"} -->
<p class="has-text-align-center has-background-color has-text-color has-upper-heading-font-size">'.esc_html__('Bags, Shoes and womens wear','blur').'</p>
<!-- /wp:paragraph -->

<!-- wp:separator {"style":{"spacing":{"margin":{"top":"2rem","bottom":"2rem"}}},"backgroundColor":"secondary"} -->
<hr class="wp-block-separator has-alpha-channel-opacity" style="margin-top:2rem;margin-bottom:2rem"/>
<!-- /wp:separator -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"backgroundColor":"background","textColor":"primary","align":"center"} -->
<div class="wp-block-button aligncenter"><a class="wp-block-button__link has-primary-color has-background-background-color has-text-color has-background wp-element-button">'.esc_html__('SHOP NOW','blur').'</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div></div>
<!-- /wp:cover --></div>
<!-- /wp:group -->',
);