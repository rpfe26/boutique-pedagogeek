<?php
/**
 * Top Rated Product Section
 * 
 * slug: top-rated-product
 * title: Top Rated Product
 * categories: blur
 */

return array(
    'title'      =>__( 'Top Rated Product', 'blur' ),
    'categories' => array( 'blur' ),
    'content'    => '<!-- wp:group {"style":{"spacing":{"padding":{"top":"var:preset|spacing|80","bottom":"var:preset|spacing|80"},"margin":{"top":"0","bottom":"0"},"blockGap":"0"},"border":{"bottom":{"width":"0px","style":"none"}}},"backgroundColor":"background","layout":{"type":"constrained"}} -->
<div class="wp-block-group has-background-background-color has-background" style="border-bottom-style:none;border-bottom-width:0px;margin-top:0;margin-bottom:0;padding-top:var(--wp--preset--spacing--80);padding-bottom:var(--wp--preset--spacing--80)"><!-- wp:heading {"textAlign":"center","textColor":"primary","fontSize":"large"} -->
<h2 class="has-text-align-center has-primary-color has-text-color has-large-font-size">TOP RATED PRODUCT</h2>
<!-- /wp:heading -->

<!-- wp:separator {"style":{"spacing":{"margin":{"top":"2rem","bottom":"4rem"}}}} -->
<hr class="wp-block-separator has-alpha-channel-opacity" style="margin-top:2rem;margin-bottom:4rem"/>
<!-- /wp:separator -->

<!-- wp:woocommerce/product-top-rated {"columns":4,"rows":1,"alignButtons":true,"stockStatus":["","instock","outofstock","onbackorder"],"align":"wide"} /--></div>
<!-- /wp:group -->',
);