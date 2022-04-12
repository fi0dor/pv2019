<div class="demo_shopping-cart-wrapper">
    <div class="container">
        <div class="demo_listing-title">
            <h2>MY SHOPPING CART</h2>
        </div>
        
        <?php if ($data["count_carts"] > 0): ?>
            <table class="table demo_cart-table">
                <thead>
                    <tr>
                        <th scope="col"></th>
                        <th scope="col">Product</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Price Per Unit (<?= EURO; ?>)</th>
                        <th scope="col">Total Price (<?= EURO; ?>)</th>
                    </tr>
                </thead>
            
                <tbody>
                    <?php foreach ($data["all_cart_products"] as $cart): ?>
                        <tr id="cart-<?= $cart["id"]; ?>">
                            <th scope="row"><img src="public/img/<?= $cart["image"]; ?>" alt="<?= $cart["name"]; ?>"></th>
                            
                            <td><?= $cart["name"]; ?></td>
                            
                            <td>  
                                <div class="demo_cart-qty-wrapper">    
                                    <div class="input-group">
                                        <input class="form-control" type="text" value="<?= $data["all_cart_quantity"][$cart["id"]]; ?>" id="input-<?= $cart["id"]; ?>">
                                        
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary demo_cart-update-btn" id="demo_cart-update-btn-<?= $cart["id"]; ?>">Update</button>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            
                            <td><span id="demo_cart-unit-cost-<?= $cart["id"]; ?>"><?= $cart["price"]; ?></td>
                            
                            <td>
                                <span id="demo_cart-single-total-cost-<?= $cart["id"]; ?>"><?= (float) $cart["price"] * $data["all_cart_quantity"][$cart["id"]]; ?></span>
                                <br/>
                                <span class="badge badge-danger demo_cart-remove" id="demo_cart-remove<?= $cart["id"]; ?>">Remove Product</span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

        <?php else: ?>

            <div class="demo_list-cart-empty">
                <div class="alert alert-warning"> 
                    Your cart is empty.
                </div>
            </div>
        <?php endif; ?>

        <?php if ($data["count_carts"] > 0): ?>
            <div class="float-right"> 
                <a href="<?= URL_ROOT; ?>cart/summary" class="btn btn-primary btn-lg active" role="button" aria-pressed="true">
                    Check Out (<span class="demo_cart-total-cost"><?= $data["cart_cost"] . ' ' . EURO; ?></span>)</a> 
            </div>
        <?php endif; ?>
        
        <div class="clearfix"></div>
    </div>
</div>
