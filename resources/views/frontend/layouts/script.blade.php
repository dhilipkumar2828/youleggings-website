<!-- Vendors JS -->

<!-- Plugins JS -->

<script src="{{ asset('frontend/js/swiper-bundle.min.js') }}"></script>

<script src="{{ asset('frontend/js/fancybox.min.js') }}"></script>

<script src="{{ asset('frontend/js/jquery.nice-select.min.js') }}"></script>

<script src="{{ asset('frontend/js/range-slider.js') }}"></script>

<script src="{{ asset('frontend/js/function-select-custom.js') }}"></script>

<!-- Custom Main JS -->

<script src="{{ asset('frontend/js/main.js') }}?v=1"></script>

<!--<script src="{{ asset('frontend/js/jquery.countdown.js') }}"></script>-->

<script src="{{ asset('frontend/js/jquery-3.5.1.min.js') }}"></script>

<script src="{{ asset('frontend/js/bootstrap-4.5.0.min.js') }}"></script>

<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>

<!-- Required datatable js -->

<script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>

<script src="{{ asset('assets/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>

<!-- Buttons examples -->

<script src="{{ asset('assets/plugins/datatables/dataTables.buttons.min.js') }}"></script>

<script src="{{ asset('assets/plugins/datatables/buttons.bootstrap4.min.js') }}"></script>

<script src="{{ asset('assets/plugins/datatables/jszip.min.js') }}"></script>

<script src="{{ asset('assets/plugins/datatables/pdfmake.min.js') }}"></script>

<script src="{{ asset('assets/plugins/datatables/vfs_fonts.js') }}"></script>

<script src="{{ asset('assets/plugins/datatables/buttons.html5.min.js') }}"></script>

<script src="{{ asset('assets/plugins/datatables/buttons.print.min.js') }}"></script>

<script src="{{ asset('assets/plugins/datatables/buttons.colVis.min.js') }}"></script>

<!-- Responsive examples -->

<script src="{{ asset('assets/plugins/datatables/dataTables.responsive.min.js') }}"></script>

<script src="{{ asset('assets/plugins/datatables/responsive.bootstrap4.min.js') }}"></script>

<script src="{{ asset('frontend/js/owl.carousel.js') }}"></script>

<script src="{{ asset('frontend/js/theme.js') }}"></script>

<!-- Datatable init js -->

<script src="{{ asset('assets/pages/datatables.init.js') }}"></script>

<script src="{{ asset('assets/plugins/RWD-Table-Patterns/dist/js/rwd-table.min.js') }}"></script>

<!--<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js'></script>-->

<script src='https://unpkg.com/swiper@6.5.4/swiper-bundle.min.js'></script>

<script>
    $('#owl-one').owlCarousel({
        loop: true,
        margin: 35,
        nav: false,
        dots: false,
        autoplay: true,
        autoplayTimeout: 2000,
        autoplayHoverPause: true,
        responsive: {
            0: {
                items: 4 // Set to 4 items on mobile (screen width 0px to 600px)
            },
            600: {
                items: 4 // Set to 4 items for screens 600px and up
            },
            1000: {
                items: 4 // Keep 5 items for larger screens (1000px and up)
            }
        }
    });
</script>

<script>
    $('#owl-two').owlCarousel({
        loop: true,
        margin: 35,
        nav: true,
        dots: true,
        autoplay: true,
        autoplayTimeout: 2000,
        autoplayHoverPause: true,
        responsive: {
            0: {
                items: 1 // For mobile view, display 1 item
            },
            600: {
                items: 1 // For smaller screens, you still want 1 item
            },
            1000: {
                items: 2 // For larger screens (web view), display 2 items
            }
        }
    });

    $('#owl-five-product').owlCarousel({
        loop: true,
        margin: 35,
        nav: false,
        dots: true,
        autoplay: false,
        autoplayTimeout: 2000,
        autoplayHoverPause: true,
        responsive: {
            0: {
                items: 1 // For mobile view, display 1 item
            },
            600: {
                items: 1 // For smaller screens, you still want 1 item
            },
            1000: {
                items: 4 // For larger screens (web view), display 2 items
            }
        }
    });
</script>

<script>
    setTimeout(function() {

        $('#alert').slideUp();

    }, 2000)
</script>

<!-- js file -->

<!-- boostrap & jquery -->

<script>
    /* product left start */

    if ($(".product-left").length) {

        var productSlider = new Swiper('.product-slider', {

            spaceBetween: 0,

            centeredSlides: false,

            loop: true,

            direction: 'horizontal',

            loopedSlides: 5,

            navigation: {

                nextEl: ".swiper-button-next",

                prevEl: ".swiper-button-prev",

            },

            resizeObserver: true,

        });

        var productThumbs = new Swiper('.product-thumbs', {

            spaceBetween: 0,

            centeredSlides: true,

            loop: true,

            slideToClickedSlide: true,

            direction: 'horizontal',

            slidesPerView: 5,

            loopedSlides: 5,

        });

        productSlider.controller.control = productThumbs;

        productThumbs.controller.control = productSlider;

    }

    /* 	product left end */
</script>

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<script>
    //  $('.paymethod').click(function(){

    //     var payment_method = $('input[name="payment_id"]:checked').val();

    //     if(payment_method == "Razar"){

    //         $('.placeorder').attr('id','check_out');

    //     }

    //     else if(payment_method == "cod"){

    //         $('.placeorder').attr('id','');

    //     }

    //  })

    function multi_cartsave() {

        $('.multicart_save').click(function() {

            var token = "{{ csrf_token() }}";

            var path = "{{ url('cart/store') }}";

            var arrtibute_name = $(this).data('arrtibute');

            var product_id = $(this).data('product-id');

            var product_qty = $('.count_prod_qty' + product_id).val();

            $.ajax({

                url: path,

                type: "POST",

                dataType: "JSON",

                data: {

                    product_id: product_id,

                    product_qty: product_qty,

                    arrtibute_name: arrtibute_name,

                    _token: token,

                },

                success: function(data) {

                    if (data['success'] == true) {

                        $('.cart_title_' + product_id).html(
                            '<i class="fa fa-check-square-o"></i> Added to Cart successfully!');

                        // $("#action-CartAddModal1_"+product_id).modal('show');

                        $('.add_to_cartid' + product_id).css('display', 'block');

                        $('.buynowid' + product_id).css('display', 'block');

                    } else if (data['failure'] == true) {

                        $('.product_rate_' + product_id).html("Out of stock");

                        $('.add_to_cartid' + product_id).css('display', 'none');

                        $('.buynowid' + product_id).css('display', 'none');

                    } else if (data['success'] == false) {

                        $('.cart_title_' + product_id).html(
                            '<i class="fa fa-check-square-o"></i>Item added ' + data[
                                'product_count'] + ' times');

                        // $("#action-CartAddModal1_"+product_id).modal('show');

                        $('.add_to_cartid' + product_id).css('display', 'block');

                        $('.buynowid' + product_id).css('display', 'block');

                    }

                    // $('.count_prod_qty'+product_id).val(product_qty ++);

                    $('.rendered_headerwish').html(data['rendered_headerwish']);

                    $('.rendered_headercart').html(data['rendered_headercart']);

                    $('.footer_cartlist').html(data['rendered_footercartlist']);

                },

            });

        });

    }

    function option_set() {

        $('.default_set').each(function() { //addto cart class

            var product_id = $(this).data('product-id');

            $('.add_to_cartid' + product_id + ',.buynowid' + product_id).attr('data-arrtibute', 'default');

        })

        $('.quantity').keyup(function(e) {

            var $button = $(this);

            e.preventDefault();

            var keyup_value = this.value;

            var oldValue = $('#count_prod_qty').val();

            var product_price = $(this).data('product_price');

            var product_id = $(this).data('product_id');

            var newprice = Number(keyup_value) * Number(product_price);

            var newVal = Number(keyup_value);

            $('.product_rate_' + product_id).html(newprice.toFixed(2));

            $('.count_prod_qty' + product_id).val(keyup_value);

            $button.parent().find('input').val(keyup_value);

        });

        $('.nice-select').each(function() { //addto cart class

            var s = $(this);

            var n = s.closest(".nice-select");

            var arr = [];

            n.parents('.detail').find('.product_variant_select').each(function(e) {

                //alert($(this).next('.nice-select').find('.selected').html());

                var selected_val = $(this).find('option:selected').text();

                arr.push(selected_val);

                var prod_id = $(this).data('id');

                //console.log(prod_id);

                $('.add_to_cartid' + prod_id).attr('data-arrtibute', (arr));

                $('.buynowid' + prod_id).attr('data-arrtibute', (arr));

                var increment = $('.count_prod_qty' + prod_id).val();

                //   console.log(arr);

                //   console.log(prod_id);

            })

        })

    }

    $(document).ready(function() {

        option_set();

    });

    function increment() {

        // Product Quantity JS

        var proQty = $(".pro-qty");

        proQty.append('<div class= "dec qty-btn">-</div>');

        proQty.append('<div class="inc qty-btn">+</div>');

        $('.qty-btn').on('click', function(e) {

            e.preventDefault();

            var $button = $(this);

            var oldValue = $button.parent().find('input').val();

            var product_price = $button.parent().find('input').data('product_price');

            var product_id = $button.parent().find('input').data('product_id');

            if ($button.hasClass('inc')) {

                var newVal = parseFloat(oldValue) + 1;

                var newprice = parseFloat(product_price) * newVal;

            } else {

                // Don't allow decrementing below zero

                if (oldValue > 1) {

                    var newVal = parseFloat(oldValue) - 1;

                    var newprice = parseFloat(product_price) * newVal;

                } else {

                    newVal = 1;

                    newprice = product_price;

                }

            }

            $button.parent().find('input').val(newVal);

            updateCart(product_id, newVal);

            $('.product_rate_' + product_id).html(newprice.toFixed(2));

            // $('.count_prod_qty'+product_id).val(newVal);

        });

    }

    $('#check_out').on('click', function(e) {

        e.preventDefault();

        var payment_id = $('input[name="payment_id"]:checked').val();

        var total = $('input[name=total]').val();

        //.replace(/,/g, '');

        var tttotal = total;

        var ttotal = tttotal;

        var name = $('#name').val();

        var last_name = $('#last_name').val();

        var email = $('#email').val();

        var phone = $('#phone').val();

        var address = $('#address').val();

        var city = $('#city').val();

        var state = $('#state').val();

        var postcode = $('#postcode').val();

        var sfirst_name = $('#sname').val();

        var slast_name = $('#slast_name').val();

        var sphone = $('#sphone').val();

        var saddress = $('#saddress').val();

        var scity = $('#scity').val();

        var sstate = $('#sstate').val();

        var spostcode = $('#spostcode').val();

        // 'snote'=>$request->snote,

        // 'quantity'=>$request->quantity,

        var sub_total = $('input[name=sub_total]').val();

        //var total=$('#total').val();

        //var ttotal=1000;

        var customer_id = '<?php echo @auth()->guard('customer')->user()->id; ?>';

        if (name != "" && last_name != "" && email != "" && phone != "" && address != "" && city != "" &&
            state != "" && postcode != "") {

            if (payment_id == "Cash_On_Delivery") {

                $.ajaxSetup({

                        headers: {

                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

                        }

                    }),

                    $.ajax({

                        type: 'get',

                        url: "{{ route('checkout.store') }}",

                        data: {

                            name: name,

                            last_name: last_name,

                            email: email,

                            phone: phone,

                            address: address,

                            city: city,

                            state: state,

                            postcode: postcode,

                            sfirst_name: sfirst_name,

                            slast_name: slast_name,

                            sphone: sphone,

                            saddress: saddress,

                            scity: scity,

                            sstate: sstate,

                            spostcode: spostcode,

                            payment_id: payment_id,

                            sub_total: sub_total,

                            pmethod: "cod",

                            total: tttotal,

                            //total : 6000,

                        },

                        success: function(data) {

                            window.location.href = "/complete/" + data.oid;

                        }

                    });

            } else if (payment_id == "RazorPay") {

                var pmethod = "Online";

                $.ajaxSetup({

                        headers: {

                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

                        }

                    }),

                    $.ajax({

                        type: 'get',

                        url: "{{ route('checkout.store') }}",

                        data: {

                            name: name,

                            last_name: last_name,

                            email: email,

                            phone: phone,

                            address: address,

                            city: city,

                            state: state,

                            postcode: postcode,

                            sfirst_name: sfirst_name,

                            slast_name: slast_name,

                            sphone: sphone,

                            saddress: saddress,

                            scity: scity,

                            sstate: sstate,

                            spostcode: spostcode,

                            payment_id: payment_id,

                            sub_total: sub_total,

                            pmethod: "Online",

                            total: tttotal

                            //total : 6000,

                        },

                        success: function(data) {

                            //var order_id = data;

                            //alert("Hello");

                            var data = JSON.parse(data);

                            var pay_id = data[0];

                            var oid = data[1];

                            ttotal = tttotal.replace(/\,/g,
                                ''); // 1125, but a string, so convert it to number

                            ttotal = parseInt(ttotal, 10);

                            ttotal = ttotal.toFixed(2);

                            var options = {

                                "key": "{{ env('RAZOR_KEY') }}", // Enter the Key ID generated from the Dashboard

                                "amount": ttotal *
                                    100, // Amount is in currency subunits. Default currency is INR. Hence, 10 refers to 1000 paise

                                "currency": "INR",

                                "name": "Tulia Transaction",

                                "description": "Transaction",

                                "image": "https://www.nicesnippets.com/image/imgpsh_fullsize.png",

                                "order_id": "", //This is a sample Order ID. Pass the `id` obtained in the response of Step 1

                                "handler": function(response) {

                                    var payy_id = pay_id;

                                    $.ajaxSetup({

                                        headers: {

                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]')
                                                .attr('content')

                                        }

                                    });

                                    $.ajax({

                                        type: 'POST',

                                        url: "{{ route('payment') }}",

                                        data: {
                                            razorpay_payment_id: response
                                                .razorpay_payment_id,
                                            amount: total,
                                            payy_id: payy_id,
                                            oid: oid
                                        },

                                        success: function(data) {

                                            // alert("Hii");

                                            $('.success-message').text(data
                                                .success);

                                            $('.success-alert').fadeIn('slow',
                                                function() {

                                                    $('.success-alert').delay(
                                                        5000).fadeOut();

                                                });

                                            if (data.oid) {

                                                window.location.href =
                                                    "/complete/" + data.oid;

                                            }

                                            $('.amount').val('');

                                        }

                                    });

                                },

                                "prefill": {

                                    "name": name,

                                    "email": email,

                                    "contact": phone,

                                },

                                "notes": {

                                    "address": "test test"

                                },

                                "theme": {

                                    "color": "#F37254"

                                }

                            };

                            var rzp1 = new Razorpay(options);

                            rzp1.open();

                            return false;

                        }

                    });

            }

        } else if (name == "") {

            $('#name_error').text('This field is required');

            $('#lastname_error').text('')

            $('#email_error').text('')

            $('#phone_error').text('')

            $('#address_error').text('')

            $('#state_error').text('')

            $('#city_error').text('')

            $('#postcode_error').text('')

        } else if (last_name == "") {

            $('#lastname_error').text('This field is required');

            $('#name_error').text('')

            $('#email_error').text('')

            $('#phone_error').text('')

            $('#address_error').text('')

            $('#state_error').text('')

            $('#city_error').text('')

            $('#postcode_error').text('')

        } else if (email == "") {

            $('#email_error').text('This field is required');

            $('#name_error').text('')

            $('#lastname_error').text('')

            $('#phone_error').text('')

            $('#address_error').text('')

            $('#state_error').text('')

            $('#city_error').text('')

            $('#postcode_error').text('')

        } else if (phone == "") {

            $('#phone_error').text('This field is required')

            $('#name_error').text('')

            $('#lastname_error').text('')

            $('#email_error').text('')

            $('#address_error').text('')

            $('#state_error').text('')

            $('#city_error').text('')

            $('#postcode_error').text('')

        } else if (address == "") {

            $('#address_error').text('This field is required')

            $('#name_error').text('')

            $('#lastname_error').text('')

            $('#email_error').text('')

            $('#phone_error').text('')

            $('#state_error').text('')

            $('#city_error').text('')

            $('#postcode_error').text('')

        } else if (city == "") {

            $('#city_error').text('This field is required')

            $('#name_error').text('')

            $('#lastname_error').text('')

            $('#email_error').text('')

            $('#phone_error').text('')

            $('#address_error').text('')

            $('#state_error').text('')

            $('#postcode_error').text('')

        } else if (state == "") {

            $('#state_error').text('This field is required')

            $('#name_error').text('')

            $('#lastname_error').text('')

            $('#email_error').text('')

            $('#phone_error').text('')

            $('#address_error').text('')

            $('#city_error').text('')

            $('#postcode_error').text('')

        } else if (postcode == "") {

            $('#postcode_error').text('This field is required')

            $('#name_error').text('')

            $('#lastname_error').text('')

            $('#email_error').text('')

            $('#phone_error').text('')

            $('#address_error').text('')

            $('#state_error').text('')

            $('#city_error').text('')

        }

    });
</script>

<script>
    $('.move-to-cart').on('click', function(e) {

        var rowId = $(this).data('id');

        //alert(rowId);

        var token = "{{ csrf_token() }}";

        var path = "{{ route('wishlist.move.cart') }}"

        $.ajax({

            url: path,

            type: "POST",

            data: {

                _token: token,

                rowId: rowId,

            },

            beforeSend: function() {

                $(this).html('<i class="fas fa-spinner fa-spin"></i> Moving to Cart......');

            },

            success: function(data) {

                if (data['status']) {

                    $('body .header-ajax').html(data['header'])

                    $('body #cart_counter').html(data['cart_count']);

                    $('body #wishlist_list').html(data['wishlist_list']);

                    swal({

                        title: "success!",

                        text: data['message'],

                        icon: "success",

                        button: "OK",

                    });

                } else {

                    swal({

                        title: "opps!",

                        text: data['message'],

                        icon: "Something went wrong",

                        button: "OK",

                    });

                }

            },

            error: function(err) {

                swal({

                    title: "Error!",

                    text: "Some error",

                    icon: "error",

                    button: "OK",

                });

            }

        })

    })
</script>

<script>
    $('.delete_wishlist').on('click', function(e) {

        var rowId = $(this).data('id');

        //alert(rowId);

        var token = "{{ csrf_token() }}";

        var path = "{{ route('wishlist.delete') }}"

        $.ajax({

            url: path,

            type: "POST",

            data: {

                _token: token,

                rowId: rowId,

            },

            // beforeSend:function(){

            //     $(this).html('<i class="fas fa-spinner fa-spin"></i> Moving to Cart......');

            // },

            success: function(data) {

                if (data['status']) {

                    $('body .header-ajax').html(data['header'])

                    $('body #cart_counter').html(data['cart_count']);

                    $('body #wishlist_list').html(data['wishlist_list']);

                    swal({

                        title: "success!",

                        text: data['message'],

                        icon: "success",

                        button: "OK",

                    });

                } else {

                    swal({

                        title: "opps!",

                        text: data['message'],

                        icon: "Something went wrong",

                        button: "OK",

                    });

                }

            },

            error: function(err) {

                swal({

                    title: "Error!",

                    text: "Some error",

                    icon: "error",

                    button: "OK",

                });

            }

        })

    })
</script>

<script>
    $('.add_to_wishlist').click(function(e) {

        var product_id = $(this).attr('data-id');

        var product_qty = $(this).attr('data-quantity');

        //  var arrtibute_name=$(this).data('arrtibute');

        var arrtibute_name = $(this).attr('data-arrtibute');

        var product_option = $(this).attr('data-option');

        var token = "{{ csrf_token() }}"

        var path = "{{ route('Wishlist.store') }}";

        $.ajax({

            url: path,

            type: "POST",

            dataType: "JSON",

            data: {

                product_id: product_id,

                product_qty: product_qty,

                arrtibute_name: arrtibute_name,

                product_option: JSON.parse(product_option),

                _token: token,

            },

            beforeSend: function() {

                $('#add_to_wishlist_' + product_id).html;

            },

            //   complete:function(){

            //       $('#add_to_wishlist_'+product_id).html('<i class="fa fa-heart whats_new_icon_'+product_id+'" style="color:red" ></i>');

            //   },

            success: function(data) {

                $('body #header-ajax').html(data['header']);

                $('body #wishlist_counter').html(data['wishlist_count']);

                if (data['status']) {

                    $('#add_to_wishlist_' + product_id).html(
                        '<i class="fa fa-heart whats_new_icon_' + product_id +
                        '" style="color:red" ></i>');

                } else if (data['present']) {

                    $('body #header-ajax').html(data['header']);

                    $('body #wishlist_counter').html(data['wishlist_count']);

                    $('#add_to_wishlist_' + product_id).html(
                        '<i class="fa fa-heart whats_new_icon_' + product_id +
                        '" style="color:none" ></i>');

                    //   swal({

                    //       title: "opps!",

                    //       text:data['message'],

                    //       icon: "warning",

                    //       button: "OK"

                    //     });

                } else {

                    //   swal({

                    //       title: "Sorry!",

                    //       text:"you can't add that product",

                    //       icon: "error",

                    //       button: "OK"

                    //     });

                }

            }

        });

    });
</script>

<script>
    $('.add_to_wishlist2').click(function(e) {

        var product_id = $(this).attr('data-id');

        var product_qty = $(this).attr('data-quantity');

        var arrtibute_name = $(this).attr('data-arrtibute');

        var product_option = $(this).attr('data-option');

        var token = "{{ csrf_token() }}"

        var path = "{{ route('Wishlist.store') }}";

        $.ajax({

            url: path,

            type: "POST",

            dataType: "JSON",

            data: {

                product_id: product_id,

                product_qty: product_qty,

                arrtibute_name: arrtibute_name,

                product_option: JSON.parse(product_option),

                _token: token,

            },

            beforeSend: function() {

                $('#add_to_wishlist_' + product_id).html;

            },

            complete: function() {

                //    $('#add_to_wishlist_'+product_id).html('<i class="fa fa-heart" style="color:red;"></i>');

            },

            success: function(data) {

                if (data['status']) {

                    $('.wish_1' + product_id).html('<i class="fa fa-heart icon1_' + product_id +
                        '" style="color:red" ></i>');

                    $('.wish2' + product_id).html('<i class="fa fa-heart icon2_' + product_id +
                        '" style="color:red" ></i>');

                    //     });

                } else if (data['present']) {

                    $('body #header-ajax').html(data['header']);

                    $('body #wishlist_counter').html(data['wishlist_count']);

                    $('.wish_1' + product_id).html('<i class="fa fa-heart icon1_' + product_id +
                        '" style="color:none" ></i>');

                    $('.wish2' + product_id).html('<i class="fa fa-heart icon2_' + product_id +
                        '" style="color:none" ></i>');

                }

            }

        });

    });
</script>

<script>
    $('.add_to_wishlist3').click(function(e) {

        var product_id = $(this).attr('data-id');

        var product_qty = $(this).attr('data-quantity');

        var arrtibute_name = $(this).attr('data-arrtibute');

        var product_option = $(this).attr('data-option');

        var token = "{{ csrf_token() }}"

        var path = "{{ route('Wishlist.store') }}";

        $.ajax({

            url: path,

            type: "POST",

            dataType: "JSON",

            data: {

                product_id: product_id,

                product_qty: product_qty,

                arrtibute_name: arrtibute_name,

                product_option: JSON.parse(product_option),

                _token: token,

            },

            beforeSend: function() {

                $('#add_to_wishlist_' + product_id).html;

            },

            //   complete:function(){

            //       $('#add_to_wishlist_'+product_id).html('<i class="fa fa-heart" style="color:red;"></i>');

            //   },

            success: function(data) {

                $('body #header-ajax').html(data['header']);

                $('body #wishlist_counter').html(data['wishlist_count']);

                if (data['status']) {

                    $('#add_to_wishlist_' + product_id).html(
                        '<i class="fa fa-heart whats_new_icon_' + product_id +
                        '" style="color:red" ></i>');

                    //   swal({

                    //       title: "Good job!",

                    //       text:data['message'],

                    //       icon: "success",

                    //       button: "OK",

                    //     });

                } else if (data['present']) {

                    $('body #header-ajax').html(data['header']);

                    $('body #wishlist_counter').html(data['wishlist_count']);

                    $('#add_to_wishlist_' + product_id).html(
                        '<i class="fa fa-heart whats_new_icon_' + product_id +
                        '" style="color:none" ></i>');

                    //   swal({

                    //       title: "opps!",

                    //       text:data['message'],

                    //       icon: "warning",

                    //       button: "OK",

                    //     });

                } else {

                    swal({

                        title: "Sorry!",

                        text: "you can't add that product",

                        icon: "error",

                        button: "OK",

                    });

                }

            }

        });

    });
</script>

<script>
    $('.add_to_wishlist4').click(function(e) {

        var product_id = $(this).attr('data-id');

        var product_qty = $(this).attr('data-quantity');

        var arrtibute_name = $(this).attr('data-arrtibute');

        var product_option = $(this).attr('data-option');

        //

        var token = "{{ csrf_token() }}"

        var path = "{{ route('Wishlist.store') }}";

        $.ajax({

            url: path,

            type: "POST",

            dataType: "JSON",

            data: {

                product_id: product_id,

                product_qty: product_qty,

                arrtibute_name: arrtibute_name,

                product_option: JSON.parse(product_option),

                _token: token,

            },

            beforeSend: function() {

                $('#add_to_wishlist_' + product_id).html;

            },

            //   complete:function(){

            //       $('#add_to_wishlist_'+product_id).html('<i class="fa fa-heart" style="color:red;"></i>');

            //   },

            success: function(data) {

                $('body #header-ajax').html(data['header']);

                $('body #wishlist_counter').html(data['wishlist_count']);

                if (data['status']) {

                    $('.wish_1' + product_id).html('<i class="fa fa-heart icon1_' + product_id +
                        '" style="color:red" ></i>');

                    $('.wish_2' + product_id).html('<i class="fa fa-heart icon1_' + product_id +
                        '" style="color:red" ></i>');

                    //     });

                } else if (data['present']) {

                    $('body #header-ajax').html(data['header']);

                    $('body #wishlist_counter').html(data['wishlist_count']);

                    $('.wish_1' + product_id).html('<i class="fa fa-heart icon1_' + product_id +
                        '" style="color:none" ></i>');

                    $('.wish_2' + product_id).html('<i class="fa fa-heart icon1_' + product_id +
                        '" style="color:none" ></i>');

                }

                //   else{

                //       swal({

                //           title: "Sorry!",

                //           text:"you can't add that product",

                //           icon: "error",

                //           button: "OK",

                //         });

                //   }

            }

        });

    });
</script>

<script>
    $('.category_check').click(function() {

        // alert($(this).data('val'));

    })
</script>

<script>
    $('.add_to_wishlist1').click(function(e) {

        var product_id = $(this).attr('data-id');

        var product_qty = $(this).attr('data-quantity');

        //var arrtibute_name_val=$(this).data('arrtibute');

        var arrtibute_name = $(this).attr('data-arrtibute');

        var product_option = $(this).attr('data-option');

        //   if(arrtibute_name ==""){

        //    var selected_color=$("#attrib_color_"+product_id+" option:selected").text();

        //   var selected_size=$("#attrib_size_"+product_id+" option:selected").text();

        //   if(selected_color!="" && selected_size !=""){

        //     var product_option={"color":selected_color,"size":selected_size};

        //     var arrtibute_name=selected_color+","+selected_size;

        //   }else{

        //     var product_option={"color":selected_color};

        //     var arrtibute_name=selected_color;

        //   }

        // }else{

        //     var split_arrtibute=arrtibute_name_val.split(',');

        //     if(split_arrtibute.length > 1 ){

        //     var product_option={"color":split_arrtibute[0],"size":split_arrtibute[1]};

        //     var arrtibute_name=split_arrtibute[0]+","+split_arrtibute[1];

        //   }else{

        //     var product_option={"color":split_arrtibute[0]};

        //     var arrtibute_name=split_arrtibute[0];

        //   }

        // }

        var token = "{{ csrf_token() }}"

        var path = "{{ route('Wishlist.store') }}";

        $.ajax({

            url: path,

            type: "POST",

            dataType: "JSON",

            data: {

                product_id: product_id,

                product_qty: product_qty,

                arrtibute_name: arrtibute_name,

                product_option: JSON.parse(product_option),

                _token: token,

            },

            beforeSend: function() {

                $('#add_to_wishlist_' + product_id).html;

            },

            //   complete:function(){

            //       $('#add_to_wishlist_'+product_id).html('<i class="fa fa-heart" style="color:red;"></i>');

            //   },

            success: function(data) {

                $('body #header-ajax').html(data['header']);

                $('body #wishlist_counter').html(data['wishlist_count']);

                if (data['status']) {

                    $('.wish_1' + product_id).html('<i class="fa fa-heart icon1_' + product_id +
                        '" style="color:red" ></i>');

                    $('.wish_2' + product_id).html('<i class="fa fa-heart icon1_' + product_id +
                        '" style="color:red" ></i>');

                    //   swal({

                    //       title: "Good job!",

                    //       text:data['message'],

                    //       icon: "success",

                    //       button: "OK",

                    //     });

                } else if (data['present']) {

                    $('body #header-ajax').html(data['header']);

                    $('body #wishlist_counter').html(data['wishlist_count']);

                    $('.wish_1' + product_id).html('<i class="fa fa-heart icon1_' + product_id +
                        '" style="color:none" ></i>');

                    $('.wish_2' + product_id).html('<i class="fa fa-heart icon1_' + product_id +
                        '" style="color:none" ></i>');

                    //   swal({

                    //       title: "opps!",

                    //       text:data['message'],

                    //       icon: "warning",

                    //       button: "OK",

                    //     });

                } else {

                    swal({

                        title: "Sorry!",

                        text: "you can't add that product",

                        icon: "error",

                        button: "OK",

                    });

                }

            }

        });

    });
</script>

<script>
    $(document).on('click', '.add_to_cart', function(e) { //Home page

        var product_id = $(this).attr('data-product-id');

        var product_qty = $(this).attr('data-quantity');

        var product_val = $(this).attr('data-option');

        //

        if (product_val != undefined) {

            var arrtibute_name = Object.values(JSON.parse(product_val)).join(",");

            var product_option = $(this).attr('data-option');

        } else {

            var arrtibute_name = "default";

            var product_option = {
                color: 'default'
            };

        }

        var token = "{{ csrf_token() }}";

        let product_price = $('.total-prince_' + product_id).html();

        $.ajax({

            url: path,

            type: "POST",

            dataType: "JSON",

            data: {

                product_id: product_id,

                product_qty: product_qty,

                product_option: JSON.parse(product_option),

                price: product_price,

                arrtibute_name: (arrtibute_name),

                _token: token,

            },

            beforeSend: function() {

                $('#add_to_cart' + product_id).html(
                    '<i class="fa fa-spinner fa-spin"></i> Loading....');

            },

            complete: function() {

                $('#add_to_cart' + product_id).html('<i class="fa fa-cart-plus"></i> Add to cart');

            },

            success: function(data) {

                $('body .header-ajax').html(data['header'])

                $('body #cart_counter').html(data['cart_count']);

                if (data['status']) {

                    product_val = "";

                    product_id = "";

                    product_qty = "";

                    // 				swal({

                    //   title: "Good job!",

                    //   text: data['message'],

                    //   icon: "success",

                    //   button: "Ok",

                    // });

                }

            },

            error: function(err) {

            }

        });

    });

    $(document).on('click', '.add_to_cart1', function(e) {

        var product_id = $(this).data('product-id');

        var product_qty = $(this).data('quantity');

        var token = "{{ csrf_token() }}";

        $.ajax({

            url: path,

            type: "POST",

            dataType: "JSON",

            data: {

                product_id: product_id,

                product_qty: product_qty,

                _token: token,

            },

            beforeSend: function() {

                $(this).html('<i class="fa fa-spinner fa-spin"></i>');

            },

            complete: function() {

                $(this).html('<i class="fas fa-shopping-basket"></i>');

            },

            success: function(data) {

                //     console.log(data);

                $('body .header-ajax').html(data['header'])

                $('body #cart_counter').html(data['cart_count']);

                $('body .amt_val').html("₹" + data['total']);

            }

        });

    });
</script>

@yield('scripts')

</script>

<script type="text/javascript">
    function showshipaddress() {

        if (document.getElementById('check-1').checked == true) {

            document.getElementById('shipaddress').style.display = 'block';

        } else {

            document.getElementById('shipaddress').style.display = 'none';

        }

    }
</script>

<script>
    setTimeout(() => {

        var optiondata = {};

        $(".attrib_colrs ul li").click(function(e) {

            // $('#id').attr('src', 'newImage.jpg');

            //var elmId = $this.attr("data");

            //var span_id=document.getElementById('span_id').innerHTML;

            var id = $(this).attr('rel');

            var val = JSON.parse(id.split("|")[0]);

            var product_id = $('#products' + id.split("|")[1] + '').val();

            var optionvalue = id.split("|")[2];

            // if(optiondata)

            $.each(val, function(k, v) {

                //$( "#attrib_"+k+"_"+product_id+" option:selected").text())

                let datt1 = $("#attribs_" + k + "_" + product_id).val().split('|');

                optiondata[k] = datt1[datt1.length - 1];

            });

            let option = optiondata;

            var arrtibute_val = Object.values(option).join(",")

            $('.wishlist' + product_id).attr('data-arrtibute', (arrtibute_val));

            $('.wishlist' + product_id).attr('data-option', JSON.stringify(optiondata));

            $('.add_to_cartid' + product_id + ',.buynowid' + product_id).attr('data-option', JSON
                .stringify(optiondata));

            $('.wishlist_sub' + product_id).attr('data-arrtibute', (arrtibute_val));

            $('.wishlist_sub' + product_id).attr('data-option', JSON.stringify(optiondata));

            $('.add_to_cartid_sub' + product_id).attr('data-option', JSON.stringify(optiondata));

            //alert(color);

            $.ajax({

                url: "{{ url('view_product_details') }}",

                method: 'post',

                data: {

                    option: option,
                    product_id: product_id,
                    _token: '{{ csrf_token() }}'

                },

                success: function(result) {

                    optiondata = {};

                    optionvalue = "";

                    option = {};

                    val = "";

                    id = "";

                    if (result['offer_price'] == 0 && result['offer_price'] != null) {

                        var img_val = result['image_values'][0]['photo'];

                        $("#offer_prices" + product_id).html(result['original_price']);

                        $("#original_price").html(result['original_price']);

                        //$('#buynow'+product_id).show();

                        $('.add_to_cartid' + product_id).show();

                        $('.total-prince_' + product_id).html((result['offer_price']) ? (
                            result['offer_price'] * $('.input-numbers' + product_id)
                            .val()) : (result['original_price'] * $(
                            '.input-numberssub_' + product_id).val()));

                        $('.total-prince_' + product_id).attr('data-price', (result[
                            'offer_price']) ? (result['offer_price'] * $(
                            '.input-numbers' + product_id).val()) : (result[
                            'original_price'] * $('.input-numberssub_' +
                            product_id).val()));

                        $('#product_img' + product_id).attr('src', '');

                        $('#product_img' + product_id).attr('src', img_val);

                    } else if (result['original_price'] != 0 && result['original_price'] !=
                        null) {

                        var img_val = result['image_values'][0]['photo'];

                        $("#offer_prices" + product_id).html(result['offer_price']);

                        $("#original_price").html(result['original_price']);

                        // $('#buynow'+product_id).show();

                        $('.add_to_cartid' + product_id).show();

                        $('.total-prince_' + product_id).html((result['offer_price']) ? (
                            result['offer_price'] * $('.input-numbers' + product_id)
                            .val()) : (result['original_price'] * $(
                            '.input-numberssub_' + product_id).val()));

                        $('.total-prince_' + product_id).attr('data-price', (result[
                            'offer_price']) ? (result['offer_price'] * $(
                            '.input-numbers' + product_id).val()) : (result[
                            'original_price'] * $('.input-numberssub_' +
                            product_id).val()));

                        $('#product_img' + product_id).attr('src', '');

                        $('#product_img' + product_id).attr('src', img_val);

                    } else if (result['original_price'] == null && result[
                            'original_price'] == null && selectedSize != "") {

                        $("#offer_price" + product_id).html("Out of Stock");

                        $("#original_price").html("Out of Stock");

                        $("#strike" + product_id).html("0");

                        $('.total-prince_' + product_id).html("Out of Stock");

                        //$('#buynow'+product_id).hide();

                        $('.add_to_cartid' + product_id).hide();

                    }

                }

            });

        });

        $(".sort_price ul li").click(function(e) {

            var sort_price = $(this).attr('rel');

            // alert(sort_price);

            $.ajax({

                url: "{{ url('whatisnew') }}",

                method: 'get',

                data: {

                    sort_price: sort_price,
                    _token: '{{ csrf_token() }}'

                },

                success: function(result) {

                    // alert("Hii");

                    $("#Products").html(result);

                }

            });

        });

    }, 1000);
</script>

<script>
    setTimeout(() => {

        var optiondata = {};

        $(".attrib_colr ul li").click(function(e) {

            // $('#product_img1').attr('src', '');

            //  $('#product_img2').attr('src', '/storage/photos/1/2048px-Unofficial_JavaScript_logo_2.svg.png');

            var id = $(this).attr('rel');

            //  console.log(id);

            var val = JSON.parse(id.split("|")[0]);

            var title = $(this).data('title');

            var product_id = $('#product' + id.split("|")[1] + '').val();

            var optionvalue = id.split("|")[2];

            $.each(val, function(k, v) {

                let datt1 = $("#attrib_" + k + "_" + product_id).val().split('|');

                optiondata[k] = datt1[datt1.length - 1];

            });

            // const result = array.color_size.slice(0, -1);

            let option = optiondata;

            var arrtibute_val = Object.values(option).join(",")

            $('#setarrtibute_val').val(arrtibute_val);

            //var arrtibute_value=option.color+","+option.size);

            const propertyNames = Object.values(optiondata);

            var selectedSize = propertyNames[1];

            $('.wishlist' + product_id).attr('data-arrtibute', (arrtibute_val));

            $('.wishlist' + product_id).attr('data-option', JSON.stringify(optiondata));

            $('.add_to_cartid' + product_id + ',.buynowid' + product_id).attr('data-option', JSON
                .stringify(optiondata));

            //alert(color);

            $.ajax({

                url: "{{ url('view_product_details') }}",

                method: 'post',

                data: {

                    option: option,
                    product_id: product_id,
                    _token: '{{ csrf_token() }}'

                },

                success: function(result) {

                    optiondata = {};

                    optionvalue = "";

                    option = {};

                    val = "";

                    id = "";

                    if (result['offer_price'] == 0 && result['offer_price'] != null) {

                        var img_val = result['image_values'][0]['photo'];

                        $("#offer_price" + product_id).html(result['original_price']);

                        $("#original_price").html(result['original_price']);

                        $('.total-prince_' + product_id).html((result['offer_price']) ? (
                            result['offer_price'] * $('.input-numbersnewarrivals_' +
                                product_id).val()) : (result['original_price'] * $(
                            '.input-numbers' + product_id).val()));

                        $('.total-prince_' + product_id).attr('data-price', (result[
                            'offer_price']) ? (result['offer_price'] * $(
                            '.input-numbersnewarrivals_' + product_id).val()) : (
                            result['original_price'] * $('.input-numbers' +
                                product_id).val()));

                        $('.buynowid' + product_id).show()

                        $('.add_to_cartid' + product_id).show();

                        $('#product_img' + product_id).attr('src', '');

                        $('#product_img' + product_id).attr('src', img_val);

                    } else if (result['original_price'] != 0 && result['original_price'] !=
                        null) {

                        var img_val = result['image_values'][0]['photo'];

                        $("#offer_price" + product_id).html(result['offer_price']);

                        $("#original_price").html(result['original_price']);

                        $('.total-prince_' + product_id).html((result['offer_price']) ? (
                            result['offer_price'] * $('.input-numbersnewarrivals_' +
                                product_id).val()) : (result['original_price'] * $(
                            '.input-numbers' + product_id).val()));

                        $('.total-prince_' + product_id).attr('data-price', (result[
                            'offer_price']) ? (result['offer_price'] * $(
                            '.input-numbersnewarrivals_' + product_id).val()) : (
                            result['original_price'] * $('.input-numbers' +
                                product_id).val()));

                        $('.buynowid' + product_id).show();

                        $('.add_to_cartid' + product_id).show();

                        $('#product_img' + product_id).attr('src', '');

                        $('#product_img' + product_id).attr('src', img_val);

                    } else if (result['original_price'] == null && result[
                            'original_price'] == null && selectedSize != "") {

                        $("#offer_price" + product_id).html("Out of Stock");

                        $("#original_price").html("Out of Stock");

                        $('.total-prince_' + product_id).html("Out of Stock");

                        $('.buynowid' + product_id).hide();

                        $('.add_to_cartid' + product_id).hide();

                    }

                }

            });

        });

        $(".sort_price ul li").click(function(e) {

            var sort_price = $(this).attr('rel');

            // alert(sort_price);

            $.ajax({

                url: "{{ url('whatisnew') }}",

                method: 'get',

                data: {

                    sort_price: sort_price,
                    _token: '{{ csrf_token() }}'

                },

                success: function(result) {

                    // alert("Hii");

                    $("#Products").html(result);

                }

            });

        });

    }, 1000);
</script>

<script>
    $(document).on('click', '.buynow', function(e) {

        var product_id = $(this).attr('data-product-id');

        var product_qty = $(this).attr('data-quantity');

        var product_option = $(this).attr('data-option');

        var arrtibute_value = Object.values(JSON.parse(product_option)).join(",");

        var token = "{{ csrf_token() }}";

        var path = "{{ route('cart.bynow') }}";

        let product_price = $('.total-prince_' + product_id).html();

        $.ajax({

            url: path,

            type: "POST",

            dataType: "JSON",

            data: {

                product_id: product_id,

                product_qty: product_qty,

                product_option: JSON.parse(product_option),

                price: product_price,

                arrtibute_value: arrtibute_value,

                _token: token,

            },

            beforeSend: function() {

                $('#buynow' + product_id).html('<i class="fa fa-spinner fa-spin"></i> Loading....');

            },

            complete: function() {

                $('#buynow' + product_id).html('<i class="fa fa-cart-plus"></i> Buy Now');

            },

            success: function(data) {

                $('body .header-ajax').html(data['header'])

                $('body #cart_counter').html(data['cart_count']);

                if (data['status']) {

                    window.location = "/checkout1";

                }

            },

            error: function(err) {

                //		console.log(err);

            }

        });

    });

    //new scripts

    $(document).on('click', '.wishlist_save', function() {

        var token = "{{ csrf_token() }}";

        var path = "{{ url('Wishlist/store') }}";

        var product_id = $(this).data('product-id');

        $.ajax({

            url: path,

            type: "POST",

            dataType: "JSON",

            data: {

                product_id: product_id,

                // arrtibute_value:arrtibute_value,

                _token: token,

            },

            success: function(data) {

                if (data['success'] == true) {

                    $('.icon_' + product_id).html('<i class="fa fa-heart" style="color: red"></i>');

                    $('.wishlist_title_' + product_id).html(
                        '<i class="fa fa-check-square-o"></i> Added to wishlist successfully!');

                    //   $("#action-WishlistModal_"+product_id).modal('show');

                } else if (data['success'] == false) {

                    $('.icon_' + product_id).html(' <i class="fa fa-heart-o"></i>');

                    $('.wishlist_title_' + product_id).html(
                        '<i class="fa fa-check-square-o"></i>Removed from wishlist successfully!'
                    );

                } else if (data['redirect'] == true) {

                    window.location.href = "{{ url('user/auth') }}";

                }

                $('.rendered_headerwish').html(data['rendered_headerwish']);

                // $('.rendered_headercart').html(data['rendered_headercart']);

            },

        });

    })

    //wishlist cart save it will delete wishlist

    function wishlist_to_cart(product_id) {

        var token = "{{ csrf_token() }}";

        var path = "{{ url('wishlist_to_cart') }}";

        var product_id = product_id;

        $.ajax({

            url: path,

            type: "POST",

            dataType: "JSON",

            data: {

                product_id: product_id,

                product_qty: 1,

                _token: token,

            },

            success: function(data) {

                if (data['success'] == true) {

                    $('.cart_title_' + product_id).html(
                        '<i class="fa fa-check-square-o"></i> Added to Cart successfully!');

                    {{-- $("#action-CartAddModal1_"+product_id).modal('show'); --}}

                    $('.rendered_wishlist').html(data['wishlist']);

                    $('.rendered_headerwish').html(data['rendered_headerwish']);

                    $('.rendered_headercart').html(data['rendered_headercart']);

                    $('.footer_cartlist').html(data['rendered_footercartlist']);

                }

            },

        });

    }

    //delete cart table

    function cart_delete(product_id) {

        var token = "{{ csrf_token() }}";

        var path = "{{ url('cart/delete') }}";

        $.ajax({

            url: path,

            type: "POST",

            dataType: "JSON",

            data: {

                product_id: product_id,

                _token: token,

            },

            success: function(data) {

                if (data['success'] == true) {

                    $('.rendered_headerwish').html(data['rendered_headerwish']);

                    $('.rendered_headercart').html(data['rendered_headercart']);

                    $('.footer_cartlist').html(data['rendered_footercartlist']);

                    $('.main-content').html(data['cart_ajax_index']);

                }

            },

        });

    }

    //add to cart for single qty

    // $(document).on('click','.cart_save',function(){

    //     var token=$('meta[name="csrf-token"]').attr('content');//"{{ csrf_token() }}";

    //     var path="{{ url('singlecartstore') }}";

    //    var product_id=$(this).data('product-id');

    //    var sale_price=$(this).data('sale_price');

    //    //var product_qty=Number($('.count_prod_qty'+product_id).val());

    //    //var quantity=(product_qty == 1)?product_qty: product_qty + 1;

    //    $.ajax({

    //          url:path,

    //         type:"POST",

    //         dataType:"JSON",

    //         data:{

    //             product_id:product_id,

    //             //product_qty:1,

    //             _token:token,

    //         },

    //         success:function(data){

    //             // console.log(Number(data['sale_price']) * Number(data['product_count']));

    //       if(data['success']==true){

    //           $('.product_rate_'+product_id).html(Number(data['sale_price']) * Number(data['product_count']));

    //     $('.cart_title_'+product_id).html('<i class="fa fa-check-square-o"></i> Added to Cart successfully!');

    //    // $("#action-CartAddModal1_"+product_id).modal('show');

    //     $('.count_prod_qty'+product_id).val(data['product_count']);

    //   //  $('.product_rate_'+product_id).html(Number(sale_price));

    // }else{

    //     $('.cart_title_'+product_id).html('<i class="fa fa-check-square-o"></i>Item added '+data['product_count'] +' times');

    //     $('.count_prod_qty'+product_id).val(data['product_count']);

    //     $('.product_rate_'+product_id).html(data['product_count'] * Number(sale_price));

    //    // $("#action-CartAddModal1_"+product_id).modal('show');

    // }

    //   var increment_quantity=$('.count_prod_qty'+product_id).val();

    //   //alert(increment_quantity ++);

    //   $('.rendered_headerwish').html(data['rendered_headerwish']);

    //     $('.rendered_headercart').html(data['rendered_headercart']);

    //       $('.footer_cartlist').html(data['rendered_footercartlist']);

    //         },

    //     });

    // })

    $('#product_review').click(function() {

        var rate = $(".select-ratings ").val();

        var token = "{{ csrf_token() }}";

        var path = "{{ url('product-review') }}";

        var product_id = $(this).data('product-id');

        var customer_id = $(this).data('customer_id');

        if (customer_id != 0) {

            if ($('textarea#review').val() != "" && $('#name').val() != "" && $('#email').val() != "") {

                $('#reply_err').css('display', 'none');

                $('#name_err').css('display', 'none');

                $('#email_err').css('display', 'none');

                $.ajax({

                    url: path,

                    type: "POST",

                    dataType: "JSON",

                    data: {

                        product_id: product_id,

                        rate: rate,

                        customer_id: customer_id,

                        review: $('textarea#review').val(),

                        name: $('#name').val(),

                        email: $('#email').val(),

                        _token: token,

                    },

                    success: function(data) {

                        if (data['success'] == true) {

                            $('.new_review').html(data['review']);

                            $('#success_review').css('display', 'block');

                            setTimeout(function() {

                                $('#success_review').css('display', 'none');

                            }, 2000);

                            $('input').val('');

                            $('textarea').val('');

                        }

                    },

                });

            } else if ($('textarea#review').val() == "") {

                $('#reply_err').css('display', 'block');

                $('#name_err').css('display', 'none');

                $('#email_err').css('display', 'none');

            } else if ($('#name').val() == "") {

                $('#name_err').css('display', 'block');

                $('#reply_err').css('display', 'none');

                $('#email_err').css('display', 'none');

            } else if ($('#email').val() == "") {

                $('#name_err').css('display', 'none');

                $('#reply_err').css('display', 'none');

                $('#email_err').css('display', 'block');

            }

        } else {

            window.location = "{{ url('user/auth') }}";

        }

    })

    //buy now page

    $('.buy_now').click(function() {

        var token = "{{ csrf_token() }}";

        var path = "{{ url('cart/store') }}";

        var arrtibute_name = $(this).data('arrtibute');

        var product_id = $(this).data('product-id');

        var product_qty = $('.count_prod_qty' + product_id).val();

        $.ajax({

            url: path,

            type: "POST",

            dataType: "JSON",

            data: {

                product_id: product_id,

                product_qty: product_qty,

                arrtibute_name: arrtibute_name,

                _token: token,

            },

            success: function(data) {

                window.location.href = "{{ url('cart') }}";

            },

        });

    })

    //add_to_cart for multi quantity

    $('.multicart_save').click(function() {

        var token = "{{ csrf_token() }}";

        var path = "{{ url('cart/store') }}";

        var arrtibute_name = $(this).data('arrtibute');

        var product_id = $(this).data('product-id');

        var product_qty = $('.count_prod_qty' + product_id).val();

        $.ajax({

            url: path,

            type: "POST",

            dataType: "JSON",

            data: {

                product_id: product_id,

                product_qty: product_qty,

                arrtibute_name: arrtibute_name,

                _token: token,

            },

            success: function(data) {

                if (data['success'] == true) {

                    $('.cart_title_' + product_id).html(
                        '<i class="fa fa-check-square-o"></i> Added to Cart successfully!');

                    // $("#action-CartAddModal1_"+product_id).modal('show');

                    $('.add_to_cartid' + product_id).css('display', 'block');

                    $('.buynowid' + product_id).css('display', 'block');

                } else if (data['failure'] == true) {

                    $('.product_rate_' + product_id).html("Out of stock");

                    $('.add_to_cartid' + product_id).css('display', 'none');

                    $('.buynowid' + product_id).css('display', 'none');

                } else if (data['success'] == false) {

                    $('.cart_title_' + product_id).html(
                        '<i class="fa fa-check-square-o"></i>Item added ' + data[
                            'product_count'] + ' times');

                    //$("#action-CartAddModal1_"+product_id).modal('show');

                    $('.add_to_cartid' + product_id).css('display', 'block');

                    $('.buynowid' + product_id).css('display', 'block');

                }

                // $('.count_prod_qty'+product_id).val(product_qty ++);

                $('.rendered_headerwish').html(data['rendered_headerwish']);

                $('.rendered_headercart').html(data['rendered_headercart']);

                $('.footer_cartlist').html(data['rendered_footercartlist']);

            },

        });

    })

    //main cart list qty update

    function updateCart(product_id, product_qty) {

        var token = "{{ csrf_token() }}";

        var path = "{{ url('cart/update') }}";

        $.ajax({

            //  url:path,

            type: "POST",

            dataType: "JSON",

            data: {

                product_id: product_id,

                product_qty: product_qty,

                _token: token,

            },

            success: function(data) {

                $('.rendered_headerwish').html(data['rendered_headerwish']);

                $('.rendered_headercart').html(data['rendered_headercart']);

                $('.footer_cartlist').html(data['rendered_footercartlist']);

                $('.maincart_list').html(data['maincart_list']);

                var proQty = $(".pro-qty");

                proQty.append('<div class= "dec qty-btn">-</div>');

                proQty.append('<div class="inc qty-btn">+</div>');

                // Product Quantity JS

                var proQty = $(".pro-qty");

                proQty.append('<div class= "dec qty-btn">-</div>');

                proQty.append('<div class="inc qty-btn">+</div>');

                $('.qty-btn').on('click', function(e) {

                    e.preventDefault();

                    var $button = $(this);

                    var oldValue = $button.parent().find('input').val();

                    var product_price = $button.parent().find('input').data('product_price');

                    var product_id = $button.parent().find('input').data('product_id');

                    if ($button.hasClass('inc')) {

                        var newVal = parseFloat(oldValue) + 1;

                        var newprice = parseFloat(product_price) * newVal;

                    } else {

                        // Don't allow decrementing below zero

                        if (oldValue > 1) {

                            var newVal = parseFloat(oldValue) - 1;

                            var newprice = parseFloat(product_price) * newVal;

                        } else {

                            newVal = 1;

                            newprice = product_price;

                        }

                    }

                    $button.parent().find('input').val(newVal);

                    updateCart(product_id, newVal);

                    $('.product_rate_' + product_id).html(newprice.toFixed(2));

                    $('#count_prod_qty').val(newVal);

                });

            },

        });

    }

    function call(min, max) {

        //$('.product_rate_'+product_id).html(newprice.toFixed(2));

        // var token="{{ csrf_token() }}";

        // var path="{{ url('product_filter') }}";

        // var cats = $(".product-widget-category input:checkbox:checked").map(function(){

        //   return $(this).val();

        // }).get();

        // $.ajax({

        //     url:path,

        //     type:"POST",

        //     dataType:"json",

        //     data:{

        //         min:min,

        //         max:max,

        //         cats:cats,

        //         _token:token,

        //     },

        //     success:function(data){

        //         //console.log(data.resval.success);

        //         if(data.resval.success==true){

        //             $('.filtered_products').html((data.resval['rendered_products']));

        //         }

        //     }

        // });

        multi_cartsave();

        var cats = $(".product-widget-category input:checkbox:checked").map(function() {

            return $(this).val();

        }).get();

        // var min=document.getElementsByName('min-value').value;

        // var max=document.getElementsByName('max-value').value;

        var discount = $('#discount')[0].checked;

        var price_sort = $('#checkprice')[0].checked;

        var in_stock = $('#in_stock:checked').val();

        var size = [];
        $('input[name="size"]:checked').each(function() {
            size.push($(this).val());
        });

        var token = "{{ csrf_token() }}";

        var path = "{{ url('product_filter') }}";

        $.ajax({

            url: path,

            // async: false,

            type: "POST",

            dataType: "json",

            data: {

                min: min,

                max: max,

                cats: cats,

                discount: discount,

                price_sort: price_sort,

                in_stock: in_stock,

                size: size,

                category_slug: $('#slug').val(),

                _token: token,

            },

            beforeSend: function() {

                $('.filtered_products').html('<i class="fas fa-spinner fa-spin"></i>Loading......');

            },

            success: function(data) {

                //console.log(data.resval.success);

                if (data.resval.success == true) {

                    $('.filtered_products').html((data.resval['rendered_products']));

                    increment();

                    option_set();

                    multi_cartsave();

                    $.getScript("{{ asset('frontend/js/jquery.nice-select.min.js') }}");

                    //     $('.multicart_save').click(function(){

                    //     var token="{{ csrf_token() }}";

                    //     var path="{{ url('cart/store') }}";

                    //     var arrtibute_name=$(this).data('arrtibute');

                    //     var product_id=$(this).data('product-id');

                    //     var product_qty=$('.count_prod_qty'+product_id).val();

                    //    $.ajax({

                    //          url:path,

                    //         type:"POST",

                    //         dataType:"JSON",

                    //         data:{

                    //             product_id:product_id,

                    //             product_qty:product_qty,

                    //             arrtibute_name:arrtibute_name,

                    //             _token:token,

                    //         },

                    //         success:function(data){

                    //       if(data['success']==true){

                    //     $('.cart_title_'+product_id).html('<i class="fa fa-check-square-o"></i> Added to Cart successfully!');

                    //     $("#action-CartAddModal1_"+product_id).modal('show');

                    //    $('.add_to_cartid'+product_id).css('display','block');

                    // $('.buynowid'+product_id).css('display','block');

                    // }

                    // else if(data['failure']==true){

                    //  $('.product_rate_'+product_id).html("Out of stock");

                    // $('.add_to_cartid'+product_id).css('display','none');

                    // $('.buynowid'+product_id).css('display','none');

                    // }

                    // else if(data['success']==false){

                    //     $('.cart_title_'+product_id).html('<i class="fa fa-check-square-o"></i>Item added '+data['product_count'] +' times');

                    //     $("#action-CartAddModal1_"+product_id).modal('show');

                    //     $('.add_to_cartid'+product_id).css('display','block');

                    // $('.buynowid'+product_id).css('display','block');

                    // }

                    // // $('.count_prod_qty'+product_id).val(product_qty ++);

                    //    $('.rendered_headerwish').html(data['rendered_headerwish']);

                    //     $('.rendered_headercart').html(data['rendered_headercart']);

                    //       $('.footer_cartlist').html(data['rendered_footercartlist']);

                    //         },

                    //     });

                    // })

                }

            }

        });

    }

    $(document).on("click", ".cat, #discount, #radio-1, #radio-2,#checkprice,#in_stock,#size", function(e) {

        var min = document.getElementsByName('min-value').value;

        var max = document.getElementsByName('max-value').value;

        call(min, max);

    })

    $(document).on("click", ".nice-select .option:not(.disabled)", function(t) {

        var s = $(this);

        var n = s.closest(".nice-select");

        var arr = [];

        var prodid = [];

        n.parents('.detail').find('.product_variant_select').each(function(e) {

            //alert($(this).next('.nice-select').find('.selected').html());

            var selected_val = $(this).find('option:selected').text();

            arr.push(selected_val);

            var prod_id = $(this).data('id');

            //console.log(prod_id);

            prodid.push(prod_id);

            $('.add_to_cartid' + prod_id).attr('data-arrtibute', (arr));

        })

        var token = $('meta[name="csrf-token"]').attr('content');

        $.ajax({

            type: 'POST',

            url: "{{ url('product_check') }}",

            data: {
                product_id: prodid[0],
                arrtibute_name: (arr),
                _token: token
            },

            success: function(data) {

                if (data.resval.success == true) {

                    var increment = $('.count_prod_qty' + prodid[0]).val();

                    $('.product_rate_' + prodid[0]).html((data['saleprice']).toFixed(2) * Number(
                        increment));

                    $('.add_to_cartid' + prodid[0]).css('display', 'block');

                    $('.buynowid' + prodid[0]).css('display', 'block');

                } else if (data.resval.success == false) {

                    $('.product_rate_' + prodid[0]).html("Out of stock");

                    $('.add_to_cartid' + prodid[0]).css('display', 'none');

                    $('.buynowid' + prodid[0]).css('display', 'none');

                }

            }

        });

    })

    var testEmail = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;

    $('#subscribe_submit').click(function() {

        var token = "{{ csrf_token() }}";

        var path = "{{ url('subscribe_send') }}";

        if (testEmail.test($('#subscriber_email').val())) {

            $('#email_err').css('display', 'none');

            $.ajax({

                url: path,

                type: "POST",

                dataType: "JSON",

                data: {

                    email: $('#subscriber_email').val(),

                    _token: token,

                },

                success: function(data) {

                    if (data.resval.success == true) {

                        $('#myModal').modal('hide');

                    }

                },

            });

        } else {

            $('#email_err').css('display', 'block');

        }

    })
</script>
