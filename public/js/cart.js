var cart = { 
    handleCheckoutStep: function(event) {
        const curStepBtn = $(event.currentTarget);
        const curStep = $(curStepBtn.attr('href'));

        if (curStepBtn.hasClass('disabled')) {
            return;
        }

        $('.stepwizard-step a[href^="#step-"]')
            .removeClass('btn-success')
            .addClass('btn-secondary');

        curStepBtn.addClass('btn-success');
        
        if (!curStep.is(':visible')) {
            $('.setup-content:visible').hide();
            curStep.show();
        }

        curStep.find(':input:eq(0)').focus();
        
        event.preventDefault();
    },

    jumpToNextCheckoutStep: function(event) {
        const btnElem = $(event.currentTarget);
        const curStep = btnElem.closest('.setup-content');
        const curStepBtn = curStep.attr('id');
        const nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').closest('.stepwizard-step').next().children('a');
        
        let isValid = true;

        $(':input:not([type=button]):not([type=submit]):not([type=reset])', curStep).each(function(index, item) {
            if (item.checkValidity() === false) {
                isValid = false;
            }
        });

        $('.demo_cart-order').addClass('was-validated');

        if (isValid) {
            $('.demo_cart-order').removeClass('was-validated');
            
            nextStepWizard
                .removeClass('disabled')
                .removeAttr('aria-disabled tabindex')
                .trigger('click');
        }

        event.preventDefault();
    },

    redeemPromoCode: function(event) {
        const formElem = $(event.currentTarget);
        const promoCode = $('input', formElem).val();

        $.getJSON('cart/updatePromoCode/' + promoCode).done(function(response) {
            if (!response.message) {
                return;
            }

            switch (response.message) {
                case 'Failed' : var action = 'not found'; break;
                case 'Success': var action = 'added'; break;
                case 'Removed': var action = 'removed'; break;
            }

            $('#demo_modal').modal(); 
            $('#demo_modal .modal-body').html(`The promo code ${response.promo_Code} was ${action}.`);

            $('.demo_checkout-gross-total').html(response.new_Total_Cart_Cost)
            $('.demo_cart-summary-promo-code').html(response.html);
        }).fail(function() {
            console.error('Request Failed: Promo code unknown');
        });

        event.preventDefault();
    },

    update: function(currElem) { 
        const [self, currWrap] = [this, $(currElem).parent()];

        self.productID = parseInt($(currElem).attr('id').replace(/\D/g, '')); 

        const updateQty = parseInt($('#input-' + self.productID).val().replace(/\D/g, '')); 
        
        if (updateQty < 1 || updateQty === '' || isNaN(updateQty)) {
            $('#demo_modal').modal();  
            $('#demo_modal .modal-body').html('Quantity must not be less than 1 and must be a number.');
            $('#input-' + self.productID).val(1); 
            
            return false;
        }

        $(currElem).html('processing&hellip;').attr('disabled', true);
        
        self.theTransporter(currWrap, currElem, updateQty, 'updateCart');
    },

    remove: function(currElem) { 
        const [self, currWrap] = [this, $(currElem).parent()];

        self.productID = parseInt($(currElem).attr('id').replace(/\D/g, '')); 
        
        const conf = confirm('Are you sure you wish to proceed?');
        
        if (!conf) {
            return false;
        }

        $(currElem).html('processing&hellip;').attr('disabled', true);
        
        self.theTransporter(currWrap, currElem, '', 'removeCart');
    },

    productID: 0,

    asyncFileExt: function(type) { 
        return type === 1 ? '.php' : '';
    },

    submitOrder: function(event) { 
        const currElem = $(event.currentTarget);
        const currWrap = currElem.parent();
        
        const shippingType = $('.demo_shipping-type').val();
        const productCost = parseFloat($('.demo_checkout-product-cost').html());
        const walletBalance = parseFloat($('.demo_checkout-wallet-balance').html());
        const shippingCost = parseFloat($('.demo_checkout-shipping-cost').html());
        const grossTotal = parseFloat($('.demo_checkout-gross-total').html());

        let isValid = true;

        $('.demo_cart-order :input:not([type=button]):not([type=submit]):not([type=reset])').each(function(index, item) {
            if (item.checkValidity() === false) {
                isValid = false;
            }
        });

        $('.demo_cart-order').addClass('was-validated');

        if (shippingType === '') {
            isValid = false;
            
            $('#demo_modal').modal();
            $('#demo_modal .modal-body').html('Please select your preferred mode of shipping.');
        } else if (grossTotal > walletBalance) {
            isValid = false;
            
            $('#demo_modal').modal();
            $('#demo_modal .modal-body').html('You do not have enough cash left in your wallet for this transaction!');
        }

        if (isValid) {
            currElem.html('processing&hellip;').attr('disabled', true);
            window.location.href = 'cart/checkout/2/0/' + shippingType;
        }

        event.preventDefault();
        event.stopPropagation();
    },
 
    checkout: function(currWrap, currElem, param3, action) { 
        this.theTransporter(currWrap, currElem, param3, action);
    },

    updateShippingCost: function(currElem) {
        var newGross = 0;
        const shippingType = $(currElem).val();
        const productCost = parseFloat($('.demo_checkout-product-cost').html()); 

        switch (shippingType) {
            case '':
                $('#demo_modal').modal();
                $('.demo_checkout-shipping-cost, .demo_checkout-gross-total').html('')
                $('#demo_modal .modal-body').html('Please select your preferred mode of shipping.'); 
                
                break;
            
            case 'PickUp':
                newGross = parseFloat(productCost + 0);
                $('.demo_checkout-shipping-cost').html(0)
                $('.demo_checkout-gross-total').html(newGross)
                
                break;
            
            default:
                newGross = parseFloat(productCost + 5);
                $('.demo_checkout-shipping-cost').html(5)
                $('.demo_checkout-gross-total').html(newGross)
                
                break;
        } 
    },

    theTransporter: function(currWrap, currElem, param3, action) {
        const self = this; 

        $.ajax({ 
            dataType: 'json',
            type: 'POST',  
            url: 'cart/' + action + '/2/' + self.productID + '/' + param3,
            contentType: 'application/x-www-form-urlencoded',
            success: function(response, status, xhr) { 

                switch (action) {
                    case 'updateCart':
                        $(currElem).html('Update').attr('disabled', false); 
                        
                        if (response.message === 'Success') { 
                            $('.demo_cart-counter').html(response.new_Total_Count);
                            
                            const unit_Cost = $('#demo_cart-unit-cost-'+self.productID).html();
                            const new_Uniqe_Cost = parseFloat(unit_Cost * response.new_Unique_Count).toFixed(2);
                            
                            $('#demo_cart-single-total-cost-'+self.productID).html(new_Uniqe_Cost);
                            $('.demo_cart-total-cost').html(response.new_Total_Cart_Cost);
                        }

                        break;

                    case 'removeCart':
                        if (response.message === 'Success') {     
                            $(currElem).html('Remove Product').attr('disabled', false); 
                            $('#cart-' + self.productID).fadeOut(1000);
                            $('.demo_cart-counter').html(response.new_Total_Count);
                            
                            const unit_Cost = $('#demo_cart-unit-cost-' + self.productID).html();
                            const new_Uniqe_Cost = parseFloat(unit_Cost * response.new_Unique_Count).toFixed(2);
                            
                            $('#demo_cart-single-total-cost-' + self.productID).html(new_Uniqe_Cost);
                            $('.demo_cart-total-cost').html(response.new_Total_Cart_Cost);
                        }
                        
                        break;
                    
                    default:
                        break;
                }
                
            },
            error: function(xhr, status, error) { 
                alert(error); return false;
            }
        });
    }
}

$(document).ready(function() {
    $('.demo_cart-update-btn').click(function(){cart.update(this)});
    $('.demo_cart-remove').click(function(){cart.remove(this)}); 
    
    $('.demo_shipping-type').change(function(){cart.updateShippingCost(this)}); 
    
    $('.demo_cart-promo-code').submit(cart.redeemPromoCode);
    $('.demo_cart-order').submit(cart.submitOrder);

    // Disable form submissions if there are invalid fields
    $('div.setup-panel div a').click(cart.handleCheckoutStep);
    $('.nextBtn').click(cart.jumpToNextCheckoutStep);
});