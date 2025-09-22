 <?php
    global $post;
    $post_id = $post->ID;
    $post_meta = get_post_meta($post_id);

    $title = $post->post_title;
    $sale_price = $post_meta['_sale_price'][0] ?? false;
    $regular_prise = $post_meta['_regular_price'][0] ?? false;
    $img_url = wp_get_attachment_url( $post_meta['_thumbnail_id'][0] ?? false)
 ?>
 
<div class="card-product">
    <div class="card-product__img">
        <img
            src="<?php echo $img_url; ?>"
            alt="img"
        />
    </div>

    <h3 class="title-card card-product__title"><?php echo $title;?></h3>
    <div class="card-product__price">
        <?php if($sale_price):?>
            <p class="card-product__price--old off"><?php echo  $regular_prise;?> BUN</p>
            <p class="card-product__price--new"><?php echo  $sale_price;?> BUN</p>
        <?php else:?>
            <p class="card-product__price--old"><?php echo  $regular_prise;?> BUN</p>
        <?php endif;?>
    </div>
    <a href="page-full-card.html"></a>
</div>