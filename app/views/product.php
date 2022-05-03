<?php

    $product   = $data["product"];
    $category  = $data["category"];
    $comments  = $data["comments"];

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
                                <button class="btn btn-lg btn-primary demo_cart-add-btn" id="demo_cart-add-btn-<?= $product["id"] ?>">Add to Cart</button> 
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

        <div class="clearfix"></div>


        <div class="col-md-12">
            <h4>Comments</h4>

            <?php foreach ($comments as $comment): ?>
                <article class="border rounded mb-3 p-3">
                    <h6><b><?= $comment['name'] ?></b> <?= !empty($comment['email']) ? ' (' . $comment['email'] . ')' : '' ?></h6>
                    <p class="m-0"><?= $comment['text'] ?></p>
                </article>
            <?php endforeach; ?> 

            <h5>Add your comment</h5>

            <form class="border border-info rounded p-3" method="post" action="product/saveComment/<?= $product["id"] ?>">
                <div class="form-row">
                    <div class="form-group col-md-6 mb-3">
                        <label for="demo_comment-name"><b>Full name *</b></label>
                        <input type="text" name="full-name" class="form-control" id="demo_comment-name" placeholder="Enter full name" required>
                    </div>

                    <div class="form-group col-md-6 mb-3">
                        <label for="demo_comment_email"><b>Email address</b></label>
                        <input type="email" name="email" class="form-control" id="demo_comment-email" aria-describedby="demo_comment-email-help" placeholder="Enter email">
                        <small id="demo_comment-email-help" class="form-text text-muted">We'll never share your email with anyone else.</small>
                    </div>
                </div>
              
                <div class="form-group">
                    <label for="demo_comment-text"><b>Your comment *</b></label>
                    <textarea name="comment" class="form-control" id="demo_comment-text" rows="5" required></textarea>
                </div>

                <div class="form-group form-check">
                    <input type="checkbox" name="conditions" class="form-check-input" id="demo_comment-conditions">
                    <label class="form-check-label" for="demo_comment-conditions">I agree to terms and conditions.</label>
                </div>
                
                <button type="submit" class="btn btn-info demo_comment-submit" disabled>Submit comment</button>
            </form>
        </div>
    </div>
</div>