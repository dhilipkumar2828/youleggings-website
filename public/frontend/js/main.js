(function ($) {
  "use strict";
  var varWindow = $(window);
  // Css Function Js
  const bgSelector = $("[data-bg-img]");
  bgSelector.each(function (index, elem) {
    let element = $(elem),
      bgSource = element.data('bg-img');
    element.css('background-image', 'url(' + bgSource + ')');
  });
  const Bgcolorcl = $("[data-bg-color]");
  Bgcolorcl.each(function (index, elem) {
    let element = $(elem),
      Bgcolor = element.data('bg-color');
    element.css('background-color', Bgcolor);
  });
  // Menu Activeion Js
  var cururl = window.location.pathname;
  var curpage = cururl.substr(cururl.lastIndexOf('/') + 1);
  var hash = window.location.hash.substr(1);
  if ((curpage === "" || curpage === "/" || curpage === "admin") && hash === "") {
  } else {
    $(".header-navigation li").each(function () {
      $(this).removeClass("active");
    });
    if (hash != "")
      $(".header-navigation li a[href='" + hash + "']").parents("li").addClass("active");
    else
      $(".header-navigation li a[href='" + curpage + "']").parents("li").addClass("active");
  }
  // Offcanvas Nav Js
  var $offcanvasNav = $("#offcanvasNav a");
  $offcanvasNav.on("click", function () {
    var link = $(this);
    var closestUl = link.closest("ul");
    var activeLinks = closestUl.find(".active");
    var closestLi = link.closest("li");
    var linkStatus = closestLi.hasClass("active");
    var count = 0;
    closestUl.find("ul").slideUp(function () {
      if (++count == closestUl.find("ul").length)
        activeLinks.removeClass("active");
    });
    if (!linkStatus) {
      closestLi.children("ul").slideDown();
      closestLi.addClass("active");
    }
  });
  // Swiper Default Slider JS
  var mainlSlider = new Swiper('.hero-slider-container', {
    slidesPerView: 1,
    slidesPerGroup: 1,
    loop: true,
    speed: 700,
    spaceBetween: 0,
    effect: 'fade',
    autoHeight: true, //enable auto height
    fadeEffect: {
      crossFade: true,
    },
    pagination: {
      el: '.hero-slider-pagination',
      type: 'fraction',
      formatFractionCurrent: function (number) {
        return '0' + number;
      },
      formatFractionTotal: function (number) {
        return '0' + number;
      }
    },
  });
  // Swiper Default Slider JS
  var mainlSlider2 = new Swiper('.hero-two-slider-container', {
    slidesPerView: 1,
    slidesPerGroup: 1,
    loop: true,
    speed: 700,
    spaceBetween: 0,
    effect: 'fade',
    autoHeight: true, //enable auto height
    fadeEffect: {
      crossFade: true,
    },
    pagination: {
      el: ".hero-two-slider-pagination",
      clickable: true,
    },
  });
  // Brand Logo Slider Js
  var brandLogoSlider = new Swiper('.brand-logo-slider-container', {
    autoplay: {
      delay: 5000,
    },
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
    },
    loop: true,
    slidesPerView: 4,
    slidesPerGroup: 1,
    spaceBetween: 62,
    speed: 500,
    breakpoints: {
      1200: {
        slidesPerView: 4,
      },
      768: {
        slidesPerView: 4,
      },
      576: {
        slidesPerView: 3,
      },
      480: {
        slidesPerView: 2,
      },
      0: {
        slidesPerView: 1,
      },
    }
  });
  // Related Product Slider Js
  var productSliderCol4 = new Swiper('.related-product-slide-container', {
    slidesPerView: 3,
    slidesPerGroup: 1,
    allowTouchMove: false,
    spaceBetween: 30,
    speed: 600,
    breakpoints: {
      1200: {
        slidesPerView: 3,
        allowTouchMove: true,
        autoplay: {
          delay: 5000,
        },
      },
      992: {
        slidesPerView: 3,
        allowTouchMove: true,
        autoplay: {
          delay: 5000,
        },
      },
      576: {
        slidesPerView: 2,
        allowTouchMove: true,
        autoplay: {
          delay: 5000,
        },
      },
      0: {
        slidesPerView: 1,
        allowTouchMove: true,
        autoplay: {
          delay: 5000,
        },
      },
    }
  });


  // scrollToTop Js
  function scrollToTop() {
    var $scrollUp = $('#scroll-to-top'),
      $lastScrollTop = 0,
      $window = $(window);
    $window.on('scroll', function () {
      var st = $(this).scrollTop();
      if (st > $lastScrollTop) {
        $scrollUp.removeClass('show');
        $('.sticky-header').removeClass('sticky-show');
      } else {
        if ($window.scrollTop() > 250) {
          $scrollUp.addClass('show');
          $('.sticky-header').addClass('sticky-show');
        } else {
          $scrollUp.removeClass('show');
          $('.sticky-header').removeClass('sticky-show');
        }
      }
      $lastScrollTop = st;
    });
    $scrollUp.on('click', function (evt) {
      $('html, body').animate({ scrollTop: 0 }, 50);
      evt.preventDefault();
    });
  }
  scrollToTop();
  varWindow.on('scroll', function () {
    if ($('.sticky-header').length) {
      var windowpos = $(this).scrollTop();
      if (windowpos >= 250) {
        $('.sticky-header').addClass('sticky');
      } else {
        $('.sticky-header').removeClass('sticky');
      }
    }
  });
})(window.jQuery);
var CustomerSlider = new Swiper('.customer-reviews', {
  autoplay: {
    delay: 5000,
  },
  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev",
  },
  loop: true,
  slidesPerView: 4,
  slidesPerGroup: 1,
  spaceBetween: 62,
  speed: 500,
  breakpoints: {
    1200: {
      slidesPerView: 2,
    },
    1023: {
      slidesPerView: 2,
    },
    768: {
      slidesPerView: 1,
    },
    576: {
      slidesPerView: 3,
    },
    480: {
      slidesPerView: 2,
    },
    0: {
      slidesPerView: 1,
    },
  }
});

$(document).ready(function () {

  //$('.mobile-product-filter').css('display','none');
})

//Open view modal
$(document).on("click", ".action-btn-quick-view", function () {
  var type = $('#type').val();
  var product_id = $(this).data('product_id');




  var slug = $(this).data('slug');
  var token = $('meta[name="csrf-token"]').attr('content');
  var path = $('meta[name="base_url"]').attr('content') + '/get_modalvalues';
  var redirecturl = $('meta[name="base_url"]').attr('content') + '/product_details/' + slug;
  var redirect_compareurl = $('meta[name="base_url"]').attr('content') + '/compare_products/' + slug;
  $.ajax({
    url: path,
    type: "GET",
    data: {
      _token: token,
      product_id: product_id,
    },
    success: function (response) {
      var reg_price = (response.saleprice['tax_price'] + Number(response.productvariant.regular_price));
      $('#action-QuickViewModal').modal('show');
      $('.product_name').html(response.product.name);
      $('.description').html((response.product.description));
      $('.product_rating').html(response.rating + " Ratings");
      $('.product_saleprice').html((Math.round(response.saleprice['sale_price'])).toFixed(2));
      if (response.product.discount_type != "no_discount") {
        $('.product_regularprice').html("₹" + (Math.round(reg_price)).toFixed(2));
      } else {
        $('.product_regularprice').html("");
      }
      $('.product_desciption').html((response.product.description));
      $('.viewdetails_redirect').html('<small><a href=+"' + redirecturl + '">View Details</a></small>');
      $(".product_img").attr("src", response.product_img);
      $('.add_towishlist_modal').attr('data-product_id', product_id);
      // $('.multiple_carts ').attr('data-product_id',product_id);
      $('#product-id').val(product_id);
      // $('.rating').attr('style','--value:'+response.rating);
      $('.count_reviews').text((response.productreviews + " reviews"));

      //modal increment and decrement

      $('.modal_d').addClass('modal_decrement' + product_id);
      $('.modal_i').addClass('modal_increment' + product_id);
      $('.modal_decrement' + product_id).attr('data-product_id', product_id);
      $('.modal_increment' + product_id).attr('data-product_id', product_id);

      $('.modalcount_prod_qty').addClass('modal_count_prod_qty' + product_id);

      $('.hiddenmodalcount_prod_qty').addClass('hidden_modalcount' + product_id);
      $('.hidden_modalcount' + product_id).attr('id', 'count_prod_qty' + product_id);


      $('.modal_count_prod_qty' + product_id).attr('id', 'count_prod_qty' + product_id);
      $('#count_prod_qty' + product_id).attr('data-product_id', product_id);

      $('.modal_count_prod_qty' + product_id).attr('id', 'quantity' + product_id);
      $('#quantity' + product_id).attr('data-product_id', product_id);

      //review
      $('.product_rating').html(response.relatedreviewval + " Ratings");
      $('.modalrating').addClass('rating_product' + product_id);
      $('.rating_product' + product_id).attr('style', '--value:' + response.relatedreview);

      $('.modal_count_prod_qty' + product_id).val(response.cart_qty);
      $('.hidden_modalcount' + product_id).val(response.cart_qty);

      if (type == "product_list") {
        if (response.subcategory.length > 1) {
          $('.compare').css('display', 'block');
          $('.compare').attr('href', redirect_compareurl);
        } else {
          $('.compare').css('display', 'none');
        }
      }
    }
  });
});


//cart add modal

$(document).on("click", ".add_tobuy_modal", function () {

  $('#product_common_error').html('');
  var redirect = $('meta[name="base_url"]').attr('content') + '/cart';
  var product_size = $("#product_size").val();
  if (product_size) {
    $("#product_size_message").css('display', 'none');
    var prod_id = $(this).data('product_id');
    var product_varients_id = $('#product_varients_id').val();

    var product_color = $('#product_color').val();
    if (prod_id == undefined) {
      var product_id = $('#product-id').val();
    } else {
      var product_id = $(this).data('product_id');
    }


    var type = $(this).data('type');

    if (type == "multi_cart") {
      var product_qty = $('.count_prod_qty').val();
      //  alert(product_qty);
    } else {
      var product_qty = 1;
    }

    if (product_qty < 1) {
      $('#product_common_error').html('Please select the Quantity');
      return;
    }

    var token = $('meta[name="csrf-token"]').attr('content');
    var path = $('meta[name="base_url"]').attr('content') + '/cart_save';
    $.ajax({
      url: path,
      type: "POST",
      data: {
        _token: token,
        product_id: product_id,
        product_qty: product_qty,
        product_varients_id: product_varients_id,
        product_color: product_color,
        type: type
      },
      success: function (data) {
        if (data.hasOwnProperty('allow_add_to_card')) {
          $('#product_common_error').html(data.message);
        } else {
          $('.cart_modal').modal('show');
          $('.cart_productname').html(data.product.name);
          $(".cart_productimg").attr("src", data.A_related_prodimg);
          $('.cart_render').html(data.cart_header_render);
          $('.cart_tablerender').html(data.cart_table_render);
          ////cart_open();
          toastr.options.timeOut = 1000;
          toastr.success('Added to cart');
          window.location.href = redirect;
        }
      }
    });

  } else {
    $("#product_size_message").css('display', 'block');
  }

});

$(document).on("click", ".add_tocart_modal", function () {
  $('#product_common_error').html('');
  console.log($('#product_size').val());
  if ($('#product_size').val() != "") {
    var product_size = $("#product_size").val();
    console.log(product_size);
    if (product_size) {
      $("#product_size_message").css('display', 'none');
      var prod_id = $(this).data('product_id');
      var product_varients_id = $('#product_varients_id').val();

      var product_color = $('#product_color').val();
      console.log("product_color", product_color);
      if (prod_id == undefined) {
        var product_id = $('#product-id').val();
      } else {
        var product_id = $(this).data('product_id');
      }


      var type = $(this).data('type');

      if (type == "multi_cart") {
        var product_qty = $('.count_prod_qty').val();
        //  alert(product_qty);
      } else {
        var product_qty = 1;
      }

      var token = $('meta[name="csrf-token"]').attr('content');
      var path = $('meta[name="base_url"]').attr('content') + '/cart_save';
      $.ajax({
        url: path,
        type: "POST",
        data: {
          _token: token,
          product_id: product_id,
          product_qty: product_qty,
          product_varients_id: product_varients_id,
          product_color: product_color,
          type: type
        },
        success: function (data) {
          $('.cart_modal').modal('show');
          $('.cart_productname').html(data.product.name);
          $(".cart_productimg").attr("src", data.A_related_prodimg);
          $('.cart_render').html(data.cart_header_render);
          $('.cart_tablerender').html(data.cart_table_render);
          ////cart_open();
          toastr.options.timeOut = 1000; // 1.5s
          toastr.success('Added to cart');

        }
      });

    } else {
      $("#product_size_message").css('display', 'block');
    }
  } else {
    $("#product_size_message").css('display', 'none');
    var prod_id = $(this).data('product_id');
    var product_varients_id = $('#product_varients_id').val();

    var product_color = $('#product_color').val();
    if (prod_id == undefined) {
      var product_id = $('#product-id').val();
    } else {
      var product_id = $(this).data('product_id');
    }


    var type = $(this).data('type');

    if (type == "multi_cart") {
      var product_qty = $('.count_prod_qty').val();
      //  alert(product_qty);
    } else {
      var product_qty = 1;
    }

    var token = $('meta[name="csrf-token"]').attr('content');
    var path = $('meta[name="base_url"]').attr('content') + '/cart_save';
    $.ajax({
      url: path,
      type: "POST",
      data: {
        _token: token,
        product_id: product_id,
        product_qty: product_qty,
        product_varients_id: product_varients_id,
        product_color: product_color,
        type: type
      },
      success: function (data) {
        $('.cart_modal').modal('show');
        $('.cart_productname').html(data.product.name);
        $(".cart_productimg").attr("src", data.A_related_prodimg);
        $('.cart_render').html(data.cart_header_render);
        $('.cart_tablerender').html(data.cart_table_render);
        ////cart_open();
        toastr.options.timeOut = 1000; // 1.5s
        toastr.success('Added to cart');

      }
    });
  }

});

//wishlist add modal
$(document).on("click", ".add_towishlist_modal", function () {
  var product_id = $(this).data('product_id');
  var token = $('meta[name="csrf-token"]').attr('content');
  var path = $('meta[name="base_url"]').attr('content') + '/wishlist_save';
  var redirect = $('meta[name="base_url"]').attr('content') + '/user/auth';
  var productSize = $("#product_size").val();
  var postVarient = '';
  if (productSize != '') {
    postVarient = $("#product_varients_id").val();
  }

  $.ajax({
    url: path,
    type: "POST",
    data: {
      _token: token,
      product_id: product_id,
      product_varients_id: postVarient,
    },
    success: function (data) {
      if (data.redirect == true) {

        window.location.href = redirect;
      } else {
        $('.wishlist_modal').modal('show');
        $('.wishlist_productname').html(data.product.name);
        $(".wishlist_productimg").attr("src", data.A_related_prodimg);
        $('.wishlist_msg').html(data.message);
        $('.wishlist_render').html(data.wishlist_render);
      }
      toastr.options.timeOut = 1000; // 1.5s
      if (data.message == "Successfully removed from your Wishlist") {

        $('.wishlist' + product_id).attr('style', 'font-weight:500');
        $('.heart_icon' + product_id).attr('style', '');
        $('.heart_icon' + product_id).addClass('fa-heart-o');
        $('.heart_icon' + product_id).removeClass('fa-heart');
        toastr.success('Removed from wishlist');
        setTimeout(() => {
          window.location.reload();
        }, 200)
        // $('.wishlist'+product_id).attr('style','color:""');
      } else if (data.message == "Successfully added to your Wishlist") {
        toastr.success('Added to wishlist');
        $('.heart_icon' + product_id).attr('style', 'color:red;');
        $('.heart_icon' + product_id).removeClass('fa-heart-o');
        $('.heart_icon' + product_id).addClass('fa-heart');
        $('.wishlist' + product_id).attr('style', 'font-weight:900;color:red;');
        setTimeout(() => {
          window.location.reload();
        }, 200)
      }
    }
  });
});

//cart remove
$(document).on('click', '.cartremove', function () {
  $("#state").val('');

  var product_id = $(this).data('product_id');
  var product_varient = $(this).data('product_varient_id');
  var token = $('meta[name="csrf-token"]').attr('content');
  var path = $('meta[name="base_url"]').attr('content') + '/cartdelete';
  $.ajax({
    url: path,
    type: "POST",
    data: {
      _token: token,
      shipping_id: ($('#shipping_idvalue').val() != undefined ? $('#shipping_idvalue').val() : 31),
      product_id: product_id,
      product_varient: product_varient,
    },
    success: function (data) {
      $('.cart_render').html(data.cart_header_render);
      $('.cart_tablerender').html(data.cart_table_render);
      $('.cartproduct_render').html(data.cart_productlist_render);
      $('.ajaxupdate_render').html(data.ajaxupdate_render);
      $('.wishlisttable_render').html(data.wishlisttable_render);
      $('.wishlist_render').html(data.wishlist_header_render);
      $('#render_checkoutproduct_table').html(data.render_checkoutproduct_table);
      $('.render_payment_info').html(data.payment_info);
      //cart_open();
      $('.canvas_static').attr('style', 'visibility:visible');
      $('.canvas_static').addClass('show');
      $('body').removeAttr("style").removeClass('modal-open');
      $('.ltn__utilize-overlay').css('display', 'none');
    }
  });
});

//login
$(document).on("click", "#login_submit", function () {

  if ($('#inputemail').val() != "" && $('#inputpass').val() != "") {
    $('.email_err').html("");
    $('.password_err').html("");
    $('.login_err').html("")
    var token = $('meta[name="csrf-token"]').attr('content');
    var path = $('meta[name="base_url"]').attr('content') + '/user/login';
    var redirect = $('meta[name="base_url"]').attr('content') + '/index';
    $.ajax({
      url: path,
      type: 'POST',
      data: {
        _token: token,
        email: $('#inputemail').val(),
        password: $('#inputpass').val(),
      },
      success: function (data) {
        if (data.review == true) {
          window.location.href = $('meta[name="base_url"]').attr('content') + "/product_details" + "/" + data.slug.slug;;
        } else if (data.error == "Invalid Email Address") {
          $('.email_err').html("Incorrect email address");
        } else if (data.error == "Incorrect password") {
          $('.password_err').html("Incorrect password");
        }
        else if (data.success == "Successfully login") {
          window.location.href = redirect;
        }
      }
    });
  } else if ($('#inputemail').val() == "" && $('#inputpass').val() == "") {
    $('.email_err').html("This field is required");
    $('.password_err').html("This field is required");
  } else if ($('#inputemail').val() == "" && $('#inputpass').val() != "") {
    $('.email_err').html("This field is required");
    $('.password_err').html("");
  } else if ($('#inputemail').val() != "" && $('#inputpass').val() == "") {
    $('.email_err').html("");
    $('.password_err').html("This field is required");
  }
})


//register
$('#register_submit').click(function () {
  var input = $('#register_email').val();
  function validateEmail(email) {
    var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return regex.test(email);
  }
  var isemail_valid = validateEmail(input)

  //  var isemail_valid=false;
  // if (/@gmail\.com$/.test(input)) {
  // isemail_valid=true;
  // }else{
  // isemail_valid=false;
  //}
  var token = $('meta[name="csrf-token"]').attr('content');
  var path = $('meta[name="base_url"]').attr('content') + '/user/register';
  var redirect = $('meta[name="base_url"]').attr('content') + '/index';
  if ($('#register_username').val() != "" && $('#register_phone_number').val() != "" && $('#register_pwsd').val() != "" && $('#register_pwsd').val().length >= 4) {
    //$('.regname_err').text('');
    $('.regphone_err').text('');
    $('.regemail_err').text('');
    $('.regpassword_err').text('');

    $.ajax({
      url: path,
      type: 'POST',
      data: {
        _token: token,
        name: $('#register_username').val(),
        email: $('#register_email').val(),
        phone_number: $('#register_phone_number').val(),
        password: $('#register_pwsd').val()
      },
      success: function (data) {
        if (data.error == false) {
          $('.regphone_err').text('Phone number already taken');
        } else {
          $('.regemail_err').text('');
          $('input').val('');
          window.location.href = redirect;
        }
      }
    });
  }
  /*
 if($('#register_username').val() == ""){
 $('.regname_err').text('This field is required');
 }
 */
  if ($('#register_phone_number').val() == "") {
    $('.regphone_err').text('This field is required');
  }
  /*
  if($('#register_email').val() == ""){
  $('.regemail_err').text('This field is required');
  }
  */
  if ($('#register_username').val() != "") {
    $('.regname_err').text('');
  }

  if ($('#register_phone_number').val() != "") {
    $('.regphone_err').text('');
  }
  /*
  if($('#register_email').val() != ""){
  $('.regemail_err').text('');
  }
  */

  if ($('#register_pwsd').val() == "") {
    $('.regpassword_err').text('This field is required');
  }

  if ($('#register_pwsd').val().length <= 4 && $('#register_pwsd').val() != "") {
    $('.regpassword_err').text('Password must greater than 4 characters');
  }
  if ($('#register_pwsd').val().length >= 4 && $('#register_pwsd').val() != "") {
    $('.regpassword_err').text('');
  }

  isemail_valid = true;
  if (isemail_valid == false) {
    $('.regemail_err').text('Enter valid email');
  }



})



//wishlist_tocart
$(document).on("click", ".wishlist_tocart", function () {
  var product_id = $(this).data('product_id');
  var token = $('meta[name="csrf-token"]').attr('content');
  var path = $('meta[name="base_url"]').attr('content') + '/wishlist_to_cart';
  $.ajax({
    url: path,
    type: "POST",
    data: {
      _token: token,
      product_id: product_id,
      product_varient_id: $("#product_varient_id").val(),
    },
    success: function (data) {
      console.log(data.cart_table_render);
      $('.cart_render').html(data.cart_header_render);
      $('.cart_tablerender').html(data.cart_table_render);
      $('.cartproduct_render').html(data.cart_productlist_render);
      $('.ajaxupdate_render').html(data.ajaxupdate_render);
      $('.wishlisttable_render').html(data.wishlisttable_render);
      $('.wishlist_render').html(data.wishlist_header_render);
      //  cart_open();
      window.location.reload();
      $('.ltn__utilize-overlay').css('display', 'none');
    }
  });
})

$(document).on("click", "#apply_coupon", function () {

  var coupon_code = $('#coupon_code').val();
  var coupontotal = $('#coupantotal').val();

  var token = $('meta[name="csrf-token"]').attr('content');
  var path = $('meta[name="base_url"]').attr('content') + '/apply_coupon';
  // var redirect=$('meta[name="base_url"]').attr('content')+'/index';
  if ($('#coupon_code').val() != "") {
    $('.coupon_err').html("");
    $('.coupon_success').html("");
    $.ajax({
      url: path,
      type: 'POST',
      data: {
        _token: token,
        coupon_code: $('#coupon_code').val(),
        amount: coupontotal,
      },
      success: function (data) {

        if (data.resval == false) {
          $('.coupon_err').html(data.msg);
        } else {

          $('.coupon_success').html("Coupon applied successfully");
          setTimeout(() => {
            window.location.reload();
          }, 200)
        }


      }
    });
  } else {
    $('.coupon_err').html("This field is required");
  }
})

//wishlistremove
$(document).on('click', '.wishlistremove', function () {
  var product_id = $(this).data('product_id');
  var token = $('meta[name="csrf-token"]').attr('content');
  var path = $('meta[name="base_url"]').attr('content') + '/wishlistdelete';
  $.ajax({
    url: path,
    type: "POST",
    data: {
      _token: token,
      product_id: product_id,
    },
    success: function (data) {
      $('.cart_render').html(data.cart_header_render);
      $('.cart_tablerender').html(data.cart_table_render);
      $('.cartproduct_render').html(data.cart_productlist_render);
      $('.ajaxupdate_render').html(data.ajaxupdate_render);
      $('.wishlist_render').html(data.wishlist_header_render);
      $('.wishlisttable_render').html(data.wishlisttable_render);
      //  cart_open();
      window.location.reload()
      $('.ltn__utilize-overlay').css('display', 'none');
    }
  });
});

// Product Quantity JS

// function updatecart(product_id,product_qty){

//     var token=$('meta[name="csrf-token"]').attr('content');
//     var path=$('meta[name="base_url"]').attr('content')+'/updatecart';
//         $.ajax({
//             url:path,
//             type:"POST",
//             data:{
//                 _token:token,
//                 shipping_id:$('#shipping_idvalue').val(),
//                 product_id:product_id,
//                 product_qty:product_qty,
//             },
//             success:function(data){
//                 $('.cart_render').html(data.cart_header_render);
//                 $('.cart_tablerender').html(data.cart_table_render);
//                 $('.cartproduct_render').html(data.cart_productlist_render);
//                 $('.ajaxupdate_render').html(data.ajaxupdate_render);
//                 cart_open();
//                 $('.ltn__utilize-overlay').css('display','none');
//             }
//         });


// }


$(document).on("change", ".quantity", function () {
  var product_id = $(this).data('product_id');
  var sale_price = $(this).data('sale_price');
  var product_qty = $('.productqty_val' + product_id).val();
  $('.product_rate' + product_id).html((product_qty * sale_price).toFixed(2));
  //updatecart(product_id,product_qty);
})
$(document).on("keyup", ".quantity", function () {
  var product_id = $(this).data('product_id');
  var sale_price = $(this).data('sale_price');
  var product_qty = $('.productqty_val' + product_id).val();
  $('.product_rate' + product_id).html((product_qty * sale_price).toFixed(2));
  //updatecart(product_id,product_qty);
})



$(document).on("click", ".proceed_to_checkout", function (e) {
  //var base_url = "https://taslim.oceansoftwares.in/prrayasha";
  const err_addressmissing = $('.err_addressmissing');
  err_addressmissing.hide();
  var token = $('meta[name="csrf-token"]').attr('content');
  var path = $('meta[name="base_url"]').attr('content') + '/checkout_store';
  console.log(path);
   var payment_method = $('input[name="payment-method"]:checked').val();
  var billing_address = {
    first_name: $('#f_name').val(),
    // last_name:$('#l_name').val(),
    phone_number: $('#phone').val(),
    // email : $('#email').val(),
    street_1: $('#street-address').val(),
    street_2: $('#street-address2').val(),
    town: $('#town').val(),
    state: $('#state').val(),
    pincode: $('#pin-code').val(),
  };
  //   var payment_status = $('.payment_mode[aria-expanded="true"]').data('mode');
  var payment_status = $('input[name="payment-method"]:checked').data('mode')
  console.log("ddd",payment_status)
  var isbillingempty = false;
  var isshippingempty = false;
  if (document.getElementById('ship-to-different-address').checked) {


    var shipping_address = {
      first_name: $('#sfirst_name').val(),
      last_name: $('#slast_name').val(),
      phone_number: $('#s-phone').val(),
      // email : $('#semail').val(),
      street_1: $('#s-address').val(),
      street_2: $('#s-address2').val(),
      town: $('#stown').val(),
      state: $('#sstate').val(),
      pincode: $('#spin-code').val(),
    };
    if ($('#sf_name').val() == "" || $('#sphone').val() == "" || ($('#phone').val()).length != 10 || $('#semail').val() == "" || $('#sstreet-address').val() == "" || $('#stown').val() == "" || $('#spin-code').val() == "") {
      isshippingempty = true;
    } else {
      isshippingempty = false;
    }
  } else {
    shipping_address = billing_address;
  }
  if ($('#f_name').val() == "" || $('#phone').val() == "" || ($('#phone').val()).length != 10 || $('#email').val() == "" || $('#street-address').val() == "" || $('#town').val() == "" || $('#pin-code').val() == "" || $('#state').val() == "") {
    isbillingempty = true;
  } else {
    isbillingempty = false;
  }

  // alert(isshippingempty);
  // alert(payment_status);
  // alert(isbillingempty);
  //alert($('#privacy').is(':checked') );

  if (isbillingempty == true) {
    err_addressmissing.show();
  }


  if (isshippingempty == false && payment_status != undefined && isbillingempty == false && $('#privacy').is(':checked') == true) {
    $('.err_terms_conditions').css('display', 'none');
    $('.err_paymentstatus').css('display', 'none');
    $.ajax({
      url: path,
      type: 'POST',
      data: {
        _token: token,
        billing_address: billing_address,
        shipping_address: shipping_address,
        payment_status: payment_status,
        deliver_charge: $('#deliver_charge').val(),
        ship_discount_amount: $('#ship_discount_amount').val(),
      },
      success: function (data) {

        if (data.response.success != true) {
          alert(data.response.msg);
          return false;
        }
       if (payment_method == "cod" || payment_status == "cod") {
          var redirect = $('meta[name="base_url"]').attr('content') + '/payment_success/' + data.order_id;
          window.location.href = redirect;
          return;
        }
        
        var tempPayment = $('input[name="payment-method"]:checked').val();
        if (tempPayment == "Phonepe") {
          window.location.href = '/processphonepe/' + data.order_id;
          return false;
        }
        var options = {
          "key": $('#hidRazorKey').val(), // Enter the Key ID generated from the Dashboard
          "amount": data.totalAmount * 100,
          "currency": "INR",
          "prefill":
          {
            "email": data.email,
            "contact": '+91' + $('#phone').val(),
          },
          "handler": function (response) {
            // alert(response.razorpay_payment_id, response.razorpay_order_id, response.razorpay_signature);
            //console.log(data);
            $('body').html('Loading Please wait..., Kindly don\'t refresh the page. Please wait for redirecting');

            $.ajax({
              url: $('meta[name="base_url"]').attr('content') + '/checkout_store_payment',
              type: 'POST',
              data: {
                _token: token,
                razorpay_payment_id: response.razorpay_payment_id,
                order_id: data.order_id,
              },
              success: function (fdata) {
                // console.log('fdata', fdata);
                var redirect = $('meta[name="base_url"]').attr('content') + '/payment_success' + '/' + data.order_id;
                window.location.href = redirect;

              }
            });
          },
        };
        var rzp1 = new Razorpay(options);
        rzp1.open();
      }
    });
  }
  //Billing err msg
  else if (isbillingempty == true) {

    if ($('#f_name').val() == "") {
      $("html, body").animate({ scrollTop: 200 }, "fast");
      $('.f_nameerr').css('display', 'block');
    }

    else if ($('#phone').val() == "" || ($('#phone').val()).length != 10) {
      $("html, body").animate({ scrollTop: 200 }, "fast");
      $('.l_nameerr').css('display', 'none');
      $('.phoneerr').css('display', 'block');
    }

    else if ($('#street-address').val() == "") {
      $("html, body").animate({ scrollTop: 300 }, "fast");
      $('.emailerr').css('display', 'none');
      $('.addresserr').css('display', 'block');
    }
    else if ($('#town').val() == "") {
      $("html, body").animate({ scrollTop: 400 }, "fast");
      $('.addresserr').css('display', 'none');
      $('.cityerr').css('display', 'block');
    }
    else if ($('#state').val() == "") {
      $("html, body").animate({ scrollTop: 500 }, "fast");
      $('.cityerr').css('display', 'none');
      $('.stateerr').css('display', 'block');
    }
    else if ($('#pin-code').val() == "") {
      $("html, body").animate({ scrollTop: 600 }, "fast");
      $('.stateerr').css('display', 'none');
      $('.pincodeerr').css('display', 'block');
    }
  }
  //shipping error msg
  else if (isshippingempty == true) {

    if ($('#sf_name').val() == "") {
      $("html, body").animate({ scrollTop: 700 }, "fast");
      $('.sf_nameerr').css('display', 'block');
    }

    else if ($('#sphone').val() == "" || ($('#phone').val()).length != 10) {
      $("html, body").animate({ scrollTop: 800 }, "fast");
      $('.sl_nameerr').css('display', 'none');
      $('.s_phoneerr').css('display', 'block');
    }
    else if ($('#semail').val() == "") {
      $("html, body").animate({ scrollTop: 900 }, "fast");
      $('.s_phoneerr').css('display', 'none');
      $('.s_emailerr').css('display', 'block');
    }
    else if ($('#s-address').val() == "") {
      $("html, body").animate({ scrollTop: 1000 }, "fast");
      $('.s_emailerr').css('display', 'none');
      $('.s_addresserr').css('display', 'block');
    }
    else if ($('#stown').val() == "") {
      $("html, body").animate({ scrollTop: 1100 }, "fast");
      $('.s_addresserr').css('display', 'none');
      $('.s_cityerr').css('display', 'block');
    }
    else if ($('#state').val() == "") {
      $("html, body").animate({ scrollTop: 1200 }, "fast");
      $('.s_cityerr').css('display', 'none');
      $('.s_stateerr').css('display', 'block');
    }
    else if ($('#spin-code').val() == "") {
      $("html, body").animate({ scrollTop: 1400 }, "fast");
      $('.s_stateerr').css('display', 'none');
      $('.s_pincodeerr').css('display', 'block');
    }
  }
  else if (payment_status == undefined) {
    $('#err_terms_conditions').css('display', 'none');
    $('.err_paymentstatus').css('display', 'block');
  }
  else if ($('#terms_conditions').is(':checked') == false) {
    $('#err_terms_conditions').css('display', 'block');
    $('.err_paymentstatus').css('display', 'none');
  }

})

$(document).on('click', '.single_product_render_count', function () {
  var product_varient = $(this).data('product_id');
  var product_id = $("#product_id").val();
  var val = $('#quantity' + product_varient).val();
  console.log(val);

  var minqty = Number(0);
  var maxqty = Number("100000");

  console.log(maxqty);

  if ($(this).data('type') == "inc") {

    if (val < maxqty) {


      $('#quantity' + product_varient).val(Number(val) + 1);
      $('#count_prod_qty' + product_varient).val(Number(val) + 1);
    }

  } else {
    if (val > minqty) {

      $('#quantity' + product_varient).val(Number(val) - 1);
      $('#count_prod_qty' + product_varient).val(Number(val) - 1);
    }

  }
}
)


$(document).on("click", "#review_submit", function () {
  var input = $('#review_customeremail').val();
  function validateEmail(email) {
    var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return regex.test(email);
  }
  var isemail_valid = validateEmail(input)
  // var isemail_valid=false;
  // if (/@gmail\.com$/.test(input)) {
  // isemail_valid=true;
  // }else{
  // isemail_valid=false;
  // }
  var token = $('meta[name="csrf-token"]').attr('content');
  var path = $('meta[name="base_url"]').attr('content') + '/product-review';
  var redirect = $('meta[name="base_url"]').attr('content') + '/user/auth';
  if ($('#review_comment').val() != "" && $('#review_customerphone').val() != "" && $('#product_rating').val() != 0 && $('#review_customername').val() != "" && isemail_valid == true && $('#review_customeremail').val()) {
    $('#comment_err').css("display", "none");
    $('#customer_err').css("display", "none");
    $('#email_err').css("display", "none");
    $('#phone_err').css("display", "none");
    $('#rate_err').css("display", "none");
    $('.review_success').css("display", "none");
    $('#invalidemail_err').css("display", "none");
    $.ajax({
      url: path,
      type: 'POST',
      data: {
        _token: token,
        product_id: $(this).data('product_id'),
        review: $('#review_comment').val(),
        rate: $('#product_rating').val(),
        name: $('#review_customername').val(),
        phone_number: $('#review_customerphone').val(),
        email: $('#review_customeremail').val(),
      },
      success: function (data) {
        if (data.success == true) {
          $('.stars span, .stars a').removeClass('active');
          $('#product_rating').val(0);
          $('.review_success').css("display", "block");
          $('.review_stardetail').css('display', 'none');
          toastr.success('Review added successfully');
          //    $('.add-a-review').css('display','none');
          $('.ratings-box:has(.ratings-box__item label input:checked) .ratings-box__item span.rating-star::after').css('transform', '');
          setTimeout(() => {
            $('.review_success').css("display", "none");
          }, 3000)
          $('.rendered_reviews').html(data.rendered_reviews);
          $('.render_star').html(data.star_rating);
          $('.input').val('');
          $('.textarea').val('');
          $('#product_rating').val(1);
        } else {
          window.location.href = redirect;
        }
        //  $('.filter_product').html(data.rendered_products);
      }
    });
  }
  else if ($('#product_rating').val() == 0) {
    // $("html, body").animate({ scrollTop: 1400 }, "slow");
    $('#rate_err').css("display", "block");
    $('#comment_err').css("display", "none");
    $('#customer_err').css("display", "none");
    $('#email_err').css("display", "none");
  }
  else if ($('#review_comment').val() == "") {
    //  $("html, body").animate({ scrollTop: 1500 }, "slow");
    $('#comment_err').css("display", "block");
    $('#rate_err').css("display", "none");
    $('#customer_err').css("display", "none");
    $('#email_err').css("display", "none");
  }
  else if ($('#review_customername').val() == "") {
    // $("html, body").animate({ scrollTop: 1500 }, "slow");
    $('#customer_err').css("display", "block");
    $('#email_err').css("display", "none");
    $('#rate_err').css("display", "none");
    $('#comment_err').css("display", "none");
  }
  else if ($('#review_customerphone').val() == "") {
    // $("html, body").animate({ scrollTop: 1550 }, "slow");
    $('#phone_err').css("display", "block");
    $('#customer_err').css("display", "none");
    $('#email_err').css("display", "none");
    $('#rate_err').css("display", "none");
    $('#comment_err').css("display", "none");
  }
  else if ($('#review_customeremail').val() == "") {
    // $("html, body").animate({ scrollTop: 1600 }, "slow");
    $('#email_err').css("display", "block");
    $('#phone_err').css("display", "none");
    $('#rate_err').css("display", "none");
    $('#comment_err').css("display", "none");
    $('#customer_err').css("display", "none");
  }
  else if (isemail_valid == false && $('#review_customeremail').val() != "") {
    $('#invalidemail_err').css("display", "block");
    $('#email_err').css("display", "none");
    $('#phone_err').css("display", "none");
    $('#rate_err').css("display", "none");
    $('#comment_err').css("display", "none");
    $('#customer_err').css("display", "none");
  }
});


$(document).on("click", '.cart_rendercount', function () {


  var product_id = $(this).data('product_id');
  var product_varient = $(this).data("product_varient_id");
  var price = $(this).data('product_price');
  var maxqty = $(this).data('quantity');
  var minqty = 0;
  var val = $('#quantity' + product_varient).val();
  //console.log(val, maxqty);
  if ($(this).data('type') == "inc") {
    if (val < maxqty) {
      val = Number(val) + 1;
      $('#quantity' + product_varient).val(Number(val));
      $('#count_prod_qty' + product_varient).val(Number(val));
      $('.product_rate_' + product_varient).html(Number(val) + " x " + Number(price));
      render_cartlist(product_varient, product_id, val);
    }
  } else {

    if (val > minqty) {
      val = Number(val) - 1;

      $('#quantity' + product_varient).val(Number(val));
      $('#count_prod_qty' + product_varient).val(Number(val));
      $('.product_rate_' + product_varient).html(Number(val) + " x " + Number(price));
      render_cartlist(product_varient, product_id, val);
    }

  }

})
$(document).on("click", ".close_canvas", function () {
  $('.canvas_static').attr('style', 'visibility:hidden');
  $('.canvas_static').removeClass('show');
})
function render_cartlist(product_varient, product_id, val) {
  var token = $('meta[name="csrf-token"]').attr('content');
  var path = $('meta[name="base_url"]').attr('content') + '/render_carttable';
  var redirect = $('meta[name="base_url"]').attr('content') + '/user/auth';

  $.ajax({
    url: path,
    type: 'POST',
    data: {
      _token: token,
      product_varient: product_varient,
      product_id: product_id,
      product_qty: val,
    },
    success: function (data) {
      $('.cartproduct_render').html(data.cart_productlist_render);
      $('.cart_render').html(data.cart_header_render);
      $('.cart_tablerender').html(data.cart_table_render);
      $('.ajaxupdate_render').html(data.ajaxupdate_render);
      $('.checkouttablle').html(data.payment_info);
      $('.canvas_static').attr('style', 'visibility:visible');
      $('.canvas_static').addClass('show');
      $('body').removeAttr("style").removeClass('modal-open');
    }
  });
}

$(document).on("keypress", ".quantity", function () {

  var regex = new RegExp("^[0-9]+$");
  var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
  if (!regex.test(key)) {
    event.preventDefault();
    return false;
  }
});
$(document).on("click", "#update_userdetails", function () {
  var token = $('meta[name="csrf-token"]').attr('content');
  var path = $('meta[name="base_url"]').attr('content') + '/update_userdetails';
  var redirect = $('meta[name="base_url"]').attr('content') + '/customer/my_account';
  if ($('#user_name').val() != "" && $('#user_email').val() != "" && $('#user_previouspassword').val() != "" && $('#user_new_password').val() != "" && $('#user_confirm_newpassword').val() != "" && ($('#user_new_password').val() == $('#user_confirm_newpassword').val())) {
    $('#err_name').css('display', 'none');
    $('#err_email').css('display', 'none');
    $('#err_prevpassword').css('display', 'none');
    $('#err_newpassword').css('display', 'none');
    $('#err_confirmnewpassword').css('display', 'none');
    $('#err_passwordmatch').css('display', 'none');
    $('#err_msg').css('display', 'none')
    $.ajax({
      url: path,
      type: 'POST',
      data: {
        _token: token,
        name: $('#user_name').val(),
        email: $('#user_email').val(),
        previous_password: $('#user_previouspassword').val(),
        new_password: $('#user_new_password').val()
      },
      success: function (data) {
        if (data.success == true) {
          $('#success_msg').css('display', 'block');
          setTimeout(() => {
            window.location.href = redirect;
          }, 2000)
        } else {
          $('#err_msg').css('display', 'block');
        }
      }
    });
  }
  if ($('#user_name').val() == "") {
    $('#err_name').css('display', 'block');
  }
  if ($('#user_email').val() == "") {
    $('#err_email').css('display', 'block');
  }
  if ($('#user_previouspassword').val() == "") {
    $('#err_prevpassword').css('display', 'block');
  }
  if ($('#user_new_password').val() == "") {
    $('#err_newpassword').css('display', 'block');
  }
  if ($('#user_confirm_newpassword').val() == "" && $('#user_previouspassword').val() != "" && $('#user_new_password').val() != "") {
    $('#err_confirmnewpassword').css('display', 'block');
  }
  if ($('#user_new_password').val() != $('#user_confirm_newpassword').val()) {
    $('#err_confirmnewpassword').css('display', 'none');
    $('#err_passwordmatch').css('display', 'block');
  }
})
$(document).on("click", "#remove_coupon", function () {
  var token = $('meta[name="csrf-token"]').attr('content');
  var path = $('meta[name="base_url"]').attr('content') + '/remove_coupon';
  // var redirect=$('meta[name="base_url"]').attr('content')+'/index';
  $.ajax({
    url: path,
    type: 'POST',
    data: {
      _token: token,
    },
    success: function (data) {
      if (data.resval == true) {
        window.location.reload();
      }
    }
  });
})
$(document).on("click", "#submit_email", function () {
  var token = $('meta[name="csrf-token"]').attr('content');
  var path = $('meta[name="base_url"]').attr('content') + '/reset_password';
  if ($('#forget_email').val() != "") {
    $('.forget_email_err').css('display', 'none');
    $.ajax({
      url: path,
      type: 'POST',
      data: {
        _token: token,
        email: $('#forget_email').val(),
        role: 'customer',
      },
      success: function (data) {
        //  if(data.success == true){
        $('#hide_email').css('display', 'none');
        $('#hide_code').css('display', 'block');
      }
    });
  } else if ($('#forget_email').val() == "") {
    $('.forget_email_err').css('display', 'block');
  }
})
$(document).on("click", ".mobile-product-filter-btn", function () {
  $('.mobile-product-filter').css('display', 'block');
})

$(document).on("click", ".mobile-product-filter-btn-close", function () {
  $('.mobile-product-filter').css('display', 'none');
})