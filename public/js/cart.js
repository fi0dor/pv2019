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
        const nextStepWizard = $('.stepwizard a[href="' + btnElem.data('jump-to') + '"]');
    
        let isValid = true;

        $(':input:visible:not([type=button]):not([type=submit]):not([type=reset])', curStep).each(function(index, item) {
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

            $('.demo_cart-summary-promo-code').html(response.html);
            $('.demo_checkout-gross-total span')
                .html(response.new_Total_Cart_Cost).parent()
                .data('value', response.new_Total_Cart_Cost);
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
        const formElem = $(event.currentTarget);
        const walletBalance = parseFloat($('.demo_wallet-balance-display').data('value'));
        const grossTotal = parseFloat($('.demo_checkout-gross-total').data('value'));

        let isValid = true;

        if (formElem[0].checkValidity() === false) {
            isValid = false;
        };

        if (grossTotal > walletBalance) {
            isValid = false;
            
            $('#demo_modal').modal();
            $('#demo_modal .modal-body').html('You do not have enough cash left in your wallet for this transaction!');
        }

        formElem.addClass('was-validated');

        if (isValid) {
            $('button[type="submit"]', formElem).html('processing&hellip;').attr('disabled', true);
        } else {
            event.preventDefault();
            event.stopImmediatePropagation();
        }
    },
 
    checkout: function(currWrap, currElem, param3, action) { 
        this.theTransporter(currWrap, currElem, param3, action);
    },

    updateShippingType: function(event) {
        const shippingType = $(event.currentTarget).val();

        $.getJSON('cart/updateShippingType/' + shippingType).done(function(response) {
            if (!response.message) {
                $('#demo_modal').modal(); 
                $('#demo_modal .modal-body').html(`Please select your preferred mode of shipping.`);

                return;
            }

            if (response.message === 'Failed') {
                $('#demo_modal').modal(); 
                $('#demo_modal .modal-body').html(`Such shipping type was not found.`);

                return;
            }

            $('.demo_cart-summary-shipping-type').html(response.html);
            $('.demo_checkout-gross-total span')
                .html(response.new_Total_Cart_Cost).parent()
                .data('value', response.new_Total_Cart_Cost);
        }).fail(function() {
            console.error('Request Failed: Shipping type unknown');
        });
    },

    updateShippingAddress: function(currElem) {
        const isSameAddress = $(currElem).val();

        $('.demo_cart-shipping-address').toggleClass('d-none d-block', isSameAddress);
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
    
    $('.demo_shipping-type').change(cart.updateShippingType); 
    
    $('.demo_cart-promo-code').submit(cart.redeemPromoCode);
    $('.demo_cart-order').submit(cart.submitOrder);

    // Disable form submissions if there are invalid fields
    $('.setup-panel div a').click(cart.handleCheckoutStep);
    $('.nextBtn').click(cart.jumpToNextCheckoutStep);

    // Same 'Billing' and 'Shipping' address?
    $('#sameAddress').change(function(){cart.updateShippingAddress(this)}); 
});