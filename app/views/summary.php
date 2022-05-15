<?php

    $promoCodeTemplate = $this->renderToString("promoCode", [
        'promo_code'  => $data["promo_code"], 
        'promo_value' => $data["promo_value"]
    ]);

?>

<div class="demo_shopping-cart-wrapper">
    <div class="container">
        <div class="demo_listing-title">
            <h2>CHECK OUT</h2>
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
                <div class="stepwizard">
                    <div class="stepwizard-row setup-panel">
                        <div class="stepwizard-step col-xs-3"> 
                            <a href="#step-1" role="button" class="btn btn-success btn-circle">1</a>
                            <p><small>Billing address</small></p>
                        </div>
                        <div class="stepwizard-step col-xs-3"> 
                            <a href="#step-2" role="button" class="btn btn-secondary btn-circle disabled" aria-disabled="true" tabindex="-1">2</a>
                            <p><small>Shipping</small></p>
                        </div>
                        <div class="stepwizard-step col-xs-3"> 
                            <a href="#step-3" role="button" class="btn btn-secondary btn-circle disabled" aria-disabled="true" tabindex="-1">3</a>
                            <p><small>Payment</small></p>
                        </div>
                    </div>
                </div>

                <form class="demo_cart-order needs-validation" novalidate>
                    <div class="panel panel-primary setup-content" id="step-1">
                        <div class="panel-heading">
                            <h3 class="panel-title">Billing address</h3>
                        </div>
                        
                        <div class="panel-body">
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
                                    <label for="email"><b>Email address *</b></label>
                                    <input type="email" class="form-control" id="email" placeholder="name.surname@gmail.com" required>
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

                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="same-address">
                                <label class="custom-control-label" for="same-address">Shipping address is the same as my billing address</label>
                            </div>

                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="save-info">
                                <label class="custom-control-label" for="save-info">Save this information for next time</label>
                            </div>
                        </div>

                        <button class="btn btn-primary nextBtn float-right" type="button">Proceed to Shipping</button>
                    </div>

                    <div class="panel panel-primary setup-content" id="step-2">
                        <div class="panel-heading">
                            <h3 class="panel-title">Shipping</h3>
                        </div>
                        
                        <div class="panel-body">
                            <div class="custom-control custom-radio">
                                <input id="pick-up" name="shippingType" value="PickUp" type="radio" class="demo_shipping-type custom-control-input" checked required>
                                <label class="custom-control-label" for="pick-up">Pick Up (<?= PICK_UP_COST . ' ' . EURO ?>)</label>
                            </div>

                            <div class="custom-control custom-radio">
                                <input id="ups" name="shippingType" value="UPS" type="radio" class="demo_shipping-type custom-control-input" required>
                                <label class="custom-control-label" for="ups">UPS (<?= UPS_SHIPPING_COST . ' ' . EURO ?>)</label>
                            </div>
                        </div>

                        <button class="btn btn-primary nextBtn float-right" type="button">Proceed to Payment</button>
                    </div>

                    <div class="panel panel-primary setup-content" id="step-3">
                        <div class="panel-heading">
                            <h3 class="panel-title">Payment</h3>
                        </div>
                        
                        <div class="panel-body">
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
                                        Expiration date is required
                                    </div>
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label for="cc-cvv"><b>CVV *</b></label>
                                    <input type="text" class="form-control" id="cc-cvv" placeholder="" required>
                                    <div class="invalid-feedback">
                                        Security code is required
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button class="btn btn-primary btn-lg float-right demo_checkout-btn" type="submit">Place the Order</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>