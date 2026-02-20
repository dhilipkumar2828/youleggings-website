// Product Quantity JS
var proQty = $(".pro-qty");
proQty.append('<div class= "dec qty-btn">-</div>');
proQty.append('<div class="inc qty-btn">+</div>');
$('.qty-btn').on('click', function (e) {

    e.preventDefault();
    
    var $button = $(this);
    var oldValue = $button.parent().find('input').val();
    var product_price=$button.parent().find('input').data('product_price');
    var product_id=$button.parent().find('input').data('product_id');
    var mode = ($button.hasClass('inc')) ? 'inc' : 'dec';

    var token=$('meta[name="csrf-token"]').attr('content');
    var path=$('meta[name="base_url"]').attr('content')+'/changecartquantity';
    $.ajax({
        url:path,
        type:"POST",
        dataType:"JSON",
        data:{
            product_id:product_id,
            mode:mode,
            _token:token,
        },
        success:function(data){
            if(data['success']==true){
                $('.rendered_headerwish').html(data['rendered_headerwish']);
                $('.rendered_headercart').html(data['rendered_headercart']);
                $('.footer_cartlist').html(data['rendered_footercartlist']);
                $('.main-content').html(data['cart_ajax_index']);
            }
        }
    });

    //  if ($button.hasClass('inc')) {
    //     var newVal = parseFloat(oldValue) + 1;

    //     var newprice=parseFloat(product_price) * newVal;
    //  } else {
    //    // Don't allow decrementing below zero
    //    if (oldValue > 1) {
    //      var newVal = parseFloat(oldValue) - 1;
    //      var newprice=parseFloat(product_price) * newVal;
    //    } else {
    //      newVal = 1;
    //      newprice = product_price;
    //    }
    //  }
    //  $button.parent().find('input').val(newVal);  
    // //  updateCart(product_id,newVal);
    //  $('.product_rate_'+product_id).html(newprice.toFixed(2));
    //  $('#count_prod_qty').val(newVal);
});