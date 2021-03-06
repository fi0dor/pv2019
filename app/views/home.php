<?php ob_start(); ?>
    <script>
        $('#demo_list-categories li:first-child a').tab('show');
    </script>
<?php $javascript_Content = ob_get_clean(); ?>

<section class="demo_banner"> 
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-lg-4">
                <div class="demo_banner-image-left">
                    <img src="public/img/banner.png" alt="<?= SITE_NAME; ?> Banner" />
                </div>
            </div>
            <div class="col-md-8 col-lg-8"> 
                <div class="demo_banner-text-right">
                    <h2>WELCOME TO A LIFE OF POSSIBILITIES</h2>
                    <p>No limits to what you can achieve</p>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="container"> 
    <div class="demo_listing-title">
        <h2>PRODUCT LISTINGS</h2>
    </div>

    <div class="demo_listings">
        <ul class="nav nav-tabs" id="demo_list-categories" role="tablist">
            <?php foreach ($data["categories"] as $category): ?>
                <?php $category_Name = wordwrap(strtolower($category["name"]), 1, '-', 0); ?>

                <li class="nav-item">
                    <a class="nav-link" id="<?= $category_Name ?>-tab" data-toggle="tab" href="#<?= $category_Name ?>" role="tab" aria-controls="<?= $category_Name ?>"><?= ucfirst($category["name"]); ?></a>
                </li>
            <?php endforeach; ?> 
        </ul>
        
        <div class="tab-content" id="demo_list-products">
            <?php foreach ($data["categories"] as $category): ?>
                <?php $category_Name = wordwrap(strtolower($category["name"]), 1, '-', 0); ?>

                <div class="tab-pane row fade" id="<?= $category_Name ?>" role="tabpanel" aria-labelledby="<?= $category_Name ?>-tab">
                    <?php foreach ($data["products"] as $product): ?>
                        <?php if ($product["id_category"] !== $category["id"]) { continue; } ?>

                        <div class="col-md-3">
                            <div class="demo_list" id="demo_list-<?= $product["id"] ?>"> 
                                <div class="demo_list-container">
                                    <div class="demo_list-image">
                                        <a title="Show details about <?= ucfirst($product["name"]); ?>" href="product/detail/<?= $product["id"] ?>">
                                            <img src="public/img/<?= $product["image"] ?>" />
                                        </a>
                                    </div>
                                    
                                    <div class="demo_list-content"> 
                                        <h6 class="float-left"><?= ucfirst($product["name"]); ?></h6>  
                                        <h6 class="float-right demo_list-price"><?= $product["price"] . ' ' . EURO; ?></h6>
                                        <p class="clearfix"></p>
                                        <p><?= $product["caption"] ?></p>
                                        
                                        <hr />

                                        <div class="demo_list-buttons">
                                            <span class="demo_list-rating-info">
                                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                                    <i class="fa fa-star demo_rating-<?= ($i <= (int) $product["average_rating"]) ? '' : 'un'; ?>rated" title="<?= $i; ?>"></i>
                                                <?php endfor; ?>

                                                <br />Average Rating <number>(<?= $product["average_rating"]; ?>)</number>
                                            </span>
                                            
                                            <span class="demo_list-add-cart"> 
                                                <a class="btn btn-secondary demo_cart-detail-btn" id="demo_cart-detail-btn-<?= $product["id"] ?>" title="Show details about <?= ucfirst($product["name"]); ?>" href="product/detail/<?= $product["id"] ?>">Show Detail</a> 
                                                <button class="btn btn-primary demo_cart-add-btn" id="demo_cart-add-btn-<?= $product["id"] ?>">Add to Cart</button> 
                                            </span>
                                        </div>

                                        <div class="demo_list-my-ratings" id="demo_list-my-ratings-<?= $product["id"] ?>">
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
                                            
                                            <span class="float-right demo_product-add-cart"><label> <i class="fa fa-check"></i>Thank you!</label></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<div class="demo_bottom-ad">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                    <h2>ENJOY THE DEMO EXPERIENCE</h2> 
                    <h5>WITH THE DEMO STORE</h5>
                    <p> 
                        <a href="cart" class="btn btn-warning btn-lg">View Cart</a>
                    </p>
            </div>
        </div>
    </div>
</div>