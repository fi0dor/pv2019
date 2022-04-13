<?php

    $product  = $data["product"];
    $category = $data["category"];

?>

<div class="demo_shopping-product-wrapper">
    <div class="container">
        <div class="demo_listing-title">
            <h2>DETAIL OF: <?= ucfirst($product["name"]); ?></h2>
        </div>

        <div class="col-md-12">
            <div class="demo_product" id="demo_product-<?= $product["id"] ?>"> 
                <div class="demo_product-container">
                    <div class="demo_product-image">
                        <img src="public/img/<?= $product["image"] ?>" />
                    </div>
                    
                    <div class="demo_product-content"> 
                        <h6 class="float-left"><?= ucfirst($product["name"]); ?> &ndash; <?= ucfirst($category["name"]); ?></h6>
                        <h6 class="float-right demo_product-price"><?= $product["price"] . ' ' . EURO; ?></h6>
                        <p class="clearfix"></p>
                        <p><?= $product["caption"] ?></p>
                        
                        <hr />

                        <div class="demo_product-buttons">
                            <span class="demo_product-rating-info">
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <i class="fa fa-star demo_rating-<?= ($i <= (int) $product["average_rating"]) ? '' : 'un'; ?>rated" title="<?= $i; ?>"></i>
                                <?php endfor; ?>

                                <br />Average Rating <number>(<?= $product["average_rating"]; ?>)</number>
                            </span>
                            
                            <span class="demo_product-add-cart float-right"> 
                                <button class="btn btn-primary demo_cart-add-btn" id="demo_cart-add-btn-<?= $product["id"] ?>">Add to Cart</button> 
                            </span>
                        </div>

                        <div class="demo_product-my-ratings" id="demo_product-my-ratings-<?= $product["id"] ?>">
                            <span class="float-left demo_product-rating-info2">
                                <?php if (count($data["prev_rated"]) > 0 && array_key_exists($product["id"], $data["prev_rated"])): ?>
                                    <?php for ($i = 1; $i <= $data["prev_rated"][$product["id"]]; $i++): ?>
                                        <i class="fa fa-star demo_rating-<?= ($i <= (int) $product["average_rating"]) ? '' : 'un'; ?>rated" title="<?= $i; ?>"></i>
                                    <?php endfor; ?>

                                    <br />Your Rating <number>(<?= $data["prev_rated"][$product["id"]]; ?>)</number>
                                
                                <?php else: ?>
                                
                                    <br />Your Rating <number>(<?= $product["average_rating"]; ?>)</number>
                                <?php endif; ?> 
                            </span>
                            
                            <span class="demo_product-add-cart float-right"><label><i class="fa fa-check"></i> Thank you!</label></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>