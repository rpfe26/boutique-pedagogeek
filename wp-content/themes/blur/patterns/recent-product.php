<?php
/**
 * Recent Product Section
 * 
 * slug: recent-product
 * title: Recent Product
 * categories: blur
 */

return array(
    'title'      =>__( 'Recent Product', 'blur' ),
    'categories' => array( 'blur' ),
    'content'    => '<!-- wp:group {"style":{"spacing":{"padding":{"top":"var:preset|spacing|80","bottom":"var:preset|spacing|80"},"margin":{"top":"0","bottom":"0"},"blockGap":"0"},"border":{"bottom":{"width":"0px","style":"none"}}},"backgroundColor":"fourground","layout":{"type":"constrained"}} -->
<div class="wp-block-group has-fourground-background-color has-background" style="border-bottom-style:none;border-bottom-width:0px;margin-top:0;margin-bottom:0;padding-top:var(--wp--preset--spacing--80);padding-bottom:var(--wp--preset--spacing--80)"><!-- wp:heading {"textAlign":"center","fontSize":"large"} -->
<h2 class="has-text-align-center has-large-font-size">'.esc_html__('NEW ARRIVAL','blur').'</h2>
<!-- /wp:heading -->

<!-- wp:separator {"style":{"spacing":{"margin":{"top":"2rem","bottom":"4rem"}}}} -->
<hr class="wp-block-separator has-alpha-channel-opacity" style="margin-top:2rem;margin-bottom:4rem"/>
<!-- /wp:separator -->

<!-- wp:woocommerce/product-new {"columns":4,"rows":2,"categories":[],"stockStatus":["","","instock","outofstock","onbackorder"],"align":"wide"} /--></div>
<!-- /wp:group -->',
);