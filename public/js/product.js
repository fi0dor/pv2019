var product = { 
    toggleSubmit: function(currElem) { 
        $(".demo_comment-submit").attr("disabled", !$(currElem).is(":checked"));
    }
}

$(document).ready(function() {
    $("#demo_comment-conditions").change(function(){product.toggleSubmit(this)});
});