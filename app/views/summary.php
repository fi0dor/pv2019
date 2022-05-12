<?php

    $promoCodeTemplate = $this->renderToString("promoCode", [
        'promo_code'  => $data["promo_code"], 
        'promo_value' => $data["promo_value"]
    ]);

?>

<div class="demo_shopping-cart-wrapper">
    <div class="container">
        <div class="demo_listing-title">
            <h2>CART SUMMARY</h2>
        </div>

        <div class="row">
            <div class="col-md-4 order-md-2 mb-4">
                <h4 class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-muted">Order recap</span>
                    <span class="badge badge-secondary badge-pill"><?= count($data["all_cart_products"]) ?></span>
                </h4>

                <ul class="list-group mb-3 demo_cart-summary">
                    <?php foreach ($data["all_cart_products"] as $cart): ?>
                        <li class="list-group-item d-flex justify-content-between lh-condensed demo_cart-summary-product" id="cart-<?= $cart["id"]; ?>">
                            <div>
                                <h6 class="my-0"><?= $cart["name"] . " ({$data["all_cart_quantity"][$cart["id"]]}&times;)"; ?></h6>
                                <small class="text-muted"><?= $cart["caption"] ?></small>
                            </div>
                            <span class="text-muted"><?= (float) $cart["price"] * $data["all_cart_quantity"][$cart["id"]] . '&nbsp;' . EURO ?></span>
                        </li>
                    <?php endforeach; ?>

                    <?php $promo  ?>

                    <li class="list-group-item d-flex justify-content-between bg-light demo_cart-summary-promo-code"><?= $promoCodeTemplate ?></li>

                    <li class="list-group-item d-flex justify-content-between">
                        <span>Total Price (<?= EURO ?>)</span>
                        <strong><span class="demo_checkout-gross-total"><?= $data["cart_cost"] ?></span> <?= EURO ?></strong>
                    </li>
                </ul>

                <form class="card p-2 demo_cart-promo-code">
                    <div class="input-group">
                        <input type="text" class="form-control" value="" placeholder="Promo code">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-secondary">Redeem</button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="col-md-8 order-md-1">
                <h4 class="mb-3">Billing address</h4>
                
                <form class="needs-validation" novalidate>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="firstName"><b>First name *</b></label>
                            <input type="text" class="form-control" id="firstName" placeholder="" value="" required>
                            <div class="invalid-feedback">
                                Valid first name is required.
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="lastName"><b>Last name *</b></label>
                            <input type="text" class="form-control" id="lastName" placeholder="" value="" required>
                            <div class="invalid-feedback">
                                Valid last name is required.
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="phoneNumber"><b>Phone number *</b></label>
                            <input name="phoneNumber" type="tel" class="form-control" id="phoneNumber" placeholder="123-456-7890" value="" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" required>
                            <div class="invalid-feedback">
                                Valid phone number is required.
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="email"><b>Email address</b></label>
                            <input type="email" class="form-control" id="email" placeholder="you@example.com">
                            <div class="invalid-feedback">
                                Please enter a valid email address for shipping updates.
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="address"><b>Address *</b></label>
                        <input type="text" class="form-control" id="address" placeholder="1234 Main St" required>
                        <div class="invalid-feedback">
                            Please enter your shipping address.
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="address2"><b>Address 2</b></label>
                        <input type="text" class="form-control" id="address2" placeholder="Apartment or suite">
                    </div>

                    <div class="row">
                        <div class="col-md-5 mb-3">
                            <label for="country"><b>Country *</b></label>
                            <select class="custom-select d-block w-100" id="country" required>
                                <option value="" disabled selected hidden>Please select the country</option>
                                <option>United Kingdom</option>
                                <option>United States</option>
                            </select>
                            <div class="invalid-feedback">
                                Please select a valid country.
                            </div>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label for="zip"><b>Zip *</b></label>
                            <input type="text" class="form-control" id="zip" placeholder="" required>
                            <div class="invalid-feedback">
                                Zip code required.
                            </div>
                        </div>
                    </div>
                    
                    <hr class="mb-4">
                    
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="same-address">
                        <label class="custom-control-label" for="same-address">Shipping address is the same as my billing address</label>
                    </div>

                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="save-info">
                        <label class="custom-control-label" for="save-info">Save this information for next time</label>
                    </div>
                    
                    <hr class="mb-4">

                    <h4 class="mb-3">Shipping</h4>

                    <div class="d-block my-3">
                        <div class="custom-control custom-radio">
                            <input id="pick-up" name="shippingType" value="PickUp" type="radio" class="demo_shipping-type custom-control-input" checked required>
                            <label class="custom-control-label" for="pick-up">Pick Up (<?= PICK_UP_COST . ' ' . EURO ?>)</label>
                        </div>

                        <div class="custom-control custom-radio">
                            <input id="ups" name="shippingType" value="UPS" type="radio" class="demo_shipping-type custom-control-input" required>
                            <label class="custom-control-label" for="ups">UPS (<?= UPS_SHIPPING_COST . ' ' . EURO ?>)</label>
                        </div>
                    </div>

                    <hr class="mb-4">

                    <h4 class="mb-3">Payment</h4>

                    <div class="d-block my-3">
                        <div class="custom-control custom-radio">
                            <input id="credit" name="paymentMethod" type="radio" class="custom-control-input" checked required>
                            <label class="custom-control-label" for="credit">Credit card</label>
                        </div>

                        <div class="custom-control custom-radio">
                            <input id="debit" name="paymentMethod" type="radio" class="custom-control-input" required>
                            <label class="custom-control-label" for="debit">Debit card</label>
                        </div>

                        <div class="custom-control custom-radio">
                            <input id="paypal" name="paymentMethod" type="radio" class="custom-control-input" required>
                            <label class="custom-control-label" for="paypal">PayPal</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="cc-name"><b>Name on card *</b></label>
                            <input type="text" class="form-control" id="cc-name" placeholder="" required>
                            <small class="text-muted">Full name as displayed on card</small>
                            <div class="invalid-feedback">
                                Name on card is required
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="cc-number"><b>Credit card number *</b></label>
                            <input type="text" class="form-control" id="cc-number" placeholder="" required>
                            <div class="invalid-feedback">
                                Credit card number is required
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label for="cc-expiration"><b>Expiration *</b></label>
                            <input type="text" class="form-control" id="cc-expiration" placeholder="" required>
                            <div class="invalid-feedback">
                                Expiration date required
                            </div>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label for="cc-cvv"><b>CVV *</b></label>
                            <input type="text" class="form-control" id="cc-cvv" placeholder="" required>
                            <div class="invalid-feedback">
                                Security code required
                            </div>
                        </div>
                    </div>

                    <hr class="mb-4">

                    <button class="btn btn-primary btn-lg btn-block" type="submit">Place the Order</button>
                </form>
            </div>
        </div>

        <style>
            .lh-condensed {
                line-height: 1.25;
            }
        </style>

        <script>
            // Disable form submissions if there are invalid fields
            (function () {
              'use strict'

              window.addEventListener('load', function () {
                // Fetch all the forms we want to apply custom Bootstrap validation styles to
                var forms = document.getElementsByClassName('needs-validation')

                // Loop over them and prevent submission
                Array.prototype.filter.call(forms, function (form) {
                  form.addEventListener('submit', function (event) {
                    if (form.checkValidity() === false) {
                      event.preventDefault()
                      event.stopPropagation()
                    }
                    
                    form.classList.add('was-validated')
                  }, false)
                })
              }, false)
            }())
        </script>

        <!--  
        <div class="row">
            <div class="col-md-7 col-lg-7">
                <h4>Shipping details</h4> 
                
                <div class="form-group">
                    <select class="form-control demo_shipping-type" >
                        <option value="" disabled selected hidden>Please select an option</option>
                        <option value="PickUp">Pick Up (<?= PICK_UP_COST . ' ' . EURO ?>)</option>
                        <option value="UPS">UPS (<?= UPS_SHIPPING_COST . ' ' . EURO ?>) </option> 
                    </select>
                </div> 
            </div>

            <div class="col-md-5 col-lg-5">
                <h4 class="float-left">Cart Review</h4>
                <button type="button" class="btn btn-primary float-right">
                    Wallet Balance 
                   
                    <span class="badge badge-light"> 
                       <span class="demo_checkout-wallet-balance"><?= $data["user_wallet_balance"]; ?></span> <?= EURO ?>
                   </span> 
                </button>

                <div class="clearfix"></div>
                
                <table class="table table-striped demo_cart-summary">
                    <tr>
                        <td>Cost of Products</td> 
                        <td> 
                            <span class="demo_checkout-product-cost"><?= $data["cart_cost"]; ?></span> <?= EURO ?>
                        </td>
                    </tr>

                    <tr>
                        <td>Shipping Cost</td>
                        <td>
                            <span class="demo_checkout-shipping-cost"></span> <?= EURO ?>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <b>Gross Total</b>
                        </td>
                        
                        <td> 
                            <span class="demo_checkout-gross-total"></span> <?= EURO ?>
                        </td>
                    </tr>
                </table>

                <button type="submit" class="btn btn-primary demo_checkout-btn">Checkout Now</button>
            </div>
        </div> 
        -->
    </div>
</div>