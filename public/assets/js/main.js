var variant = [];


$('.attribute_val').change(function(){
    var value=$(this).val();

$('#att_value').val(value);
})
$('#reset').click(function(){
    $('#holder img').css('display','none');
   $('.text-close').css('display','none');
})

    $(document).ready(function(){


            var current_fs, next_fs, previous_fs; //fieldsets
            var opacity;
            var current = 1;
            var steps = $("fieldset").length;
            setProgressBar(current);
          $(document).on("click", "fieldset .next", function() {

            var current_fs = $(this).parent();

             var inputs = current_fs.find(".required2").not(".add_varianterrphoto"); // Select all elements with class 'required2'
             var inputs1 = current_fs.find(".add_varianterrphoto"); // Select all elements with class 'add_varianterrphoto'

            inputs1.removeClass('required'); // Remove 'required' class
            inputs1.removeClass('required2'); // Remove 'required2' class
            var isErr = false;

            // Iterate through each input element with class 'required2'
            inputs.each(function(i, el) {
                var val = $(el).val();
                if (val === null || val === "" || (Array.isArray(val) && val.length === 0)) { // Check if the input field is empty
                    isErr = true;

                    // Display error message next to the input field
                    var errorEl = $(el).next('.err_emptyval');
                    if (errorEl.length === 0 && $(el).closest('.input-group').length > 0) {
                        errorEl = $(el).closest('.input-group').next('.err_emptyval');
                    }
                    errorEl.css('display', 'block');
                } else {
                    // Hide error message if the field is filled
                    var errorEl = $(el).next('.err_emptyval');
                    if (errorEl.length === 0 && $(el).closest('.input-group').length > 0) {
                        errorEl = $(el).closest('.input-group').next('.err_emptyval');
                    }
                    errorEl.css('display', 'none');
                }
            });

            // If any required field is empty, prevent the form from proceeding
            if (isErr) {
                swal("Attention", 'Please fill in all required fields.', "warning");
                return false; // Prevent the form from proceeding
            }

            // Proceed with your logic for showing the next fieldset
            var next_fs = $(this).parent().next();
            $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

            next_fs.show();
            current_fs.animate({
                opacity: 0
            }, {
                step: function(now) {
                    opacity = 1 - now;
                    current_fs.css({
                        'display': 'none',
                        'position': 'relative'
                    });
                    next_fs.css({
                        'opacity': opacity
                    });
                },
                duration: 500
            });

            setProgressBar(++current); // Update progress bar
        });

            $(document).on("click", "fieldset .previous", function(){
            current_fs = $(this).parent();
            previous_fs = $(this).parent().prev();
            //Remove class active
            $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");
            //show the previous fieldset
            previous_fs.show();
            //hide the current fieldset with style
            current_fs.animate({opacity: 0}, {
            step: function(now) {
            // for making fielset appear animation
            opacity = 1 - now;
            current_fs.css({
            'display': 'none',
            'position': 'relative'
            });
            previous_fs.css({'opacity': opacity});
            },
            duration: 500
            });
            setProgressBar(--current);
            });
            function setProgressBar(curStep){
            var percent = parseFloat(100 / steps) * curStep;
            percent = percent.toFixed();
            $(".progress-bar")
            .css("width",percent+"%")
            }
            $(".submit").click(function(){
            return false;
            })
});







jQuery(document).ready(function(){
    $('.summernote').summernote({
        fontSizes: ['8', '9', '10', '11', '12', '14', '18', '24', '36', '48' , '64', '82', '150'],
        height: 80,
        width:400,                // set editor height
        minHeight: null,             // set minimum height of editor
        maxHeight: null,
        toolbar: [
            // [groupName, [list of button]]
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['strikethrough', 'superscript', 'subscript']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']]
          ]             // set maximum height of editor
    });
});


$('#cat_id').change(function(){
    var token=$('meta[name="csrf-token"]').attr('content');
    var path=$('meta[name="base_url"]').attr('content')+'/admin/get_subproducts';
      $('#subcat_id').val('');
    $('#childcat_id').val('');
            $.ajax({
                url:path,
                type: "GET",
                data: {
                    _token: token,
                    id: $('#cat_id').val(),
                },
                success: function(response) {
                    var appenddata1 = "";
                    var subcategory=response.categories;
                    if(response.categories != ""){
                        $('#sub_cat').css('display','block');
                       $("#subcat_id").addClass("required");
                       appenddata1 +="<option value = ''>Select Subcategory</option>";
                       $("#subcat_id").empty(); // <<<<<< No more issue here
                        for (var i = 0; i < subcategory.length; i++) {
                            appenddata1 +="<option value = '" + subcategory[i].id +"'>"+subcategory[i].title+"</option>";
                        }
                        $("#subcat_id").append(appenddata1);
                    }else{
                        $('#sub_cat').css('display','none');
                        $("#subcat_id").removeClass("required");
                        appenddata1 +="<option value = ''>Select Subcategory</option>";
                        $("#subcat_id").empty(); // <<<<<< No more issue here
                        $("#subcat_id").append(appenddata1);
                    }
                }
            });

});

$('#is_parent').change(function(e){
    e.preventDefault();
    var is_checked=$('#is_parent').prop('checked');
    // alert('is_checked')
    if(is_checked){
        $('#parent_cat_div').addClass('d-none');
        $('#parent_cat_div').val('');
    }
    else{
        $('#parent_cat_div').removeClass('d-none');
    }
});



if ($('#product_attribute').length > 0) {
    $('#product_attribute').multifield();
}
// $('#chil_cat_id1').select2({
//     placeholder:"Select Value"
// });





// $.ajaxSetup({
//     headers: {
//         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//     }
// });
$('.dltBtn').click(function(e) {
    var form = $(this).closest('form');
    var dataID = $(this).data('id');
    e.preventDefault();
    swal({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover this imaginary file!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                form.submit();
                swal("Poof! Your imaginary file has been deleted!", {
                    icon: "success",
                });
            } else {
                swal("Your imaginary file is safe!");
            }
        });
});


$('input[name=toogle]').change(function() {
    var token=$('meta[name="csrf-token"]').attr('content');
    var path=$('meta[name="base_url"]').attr('content')+'/product_status';
    var mode = $(this).prop('checked');
    var id = $(this).val();
    // alert(id);
    $.ajax({
        url: path,
        type: "POST",
        data: {
            _token: token,
            mode: mode,
            id: id,
        },
        success: function(response) {
         //   console.log(response.status);
        }
    })
});


function cat1(val, j) {
    var token=$('meta[name="csrf-token"]').attr('content');
    var path=$('meta[name="base_url"]').attr('content')+'/admin/productattribute';
    var cat_id = val;
    if (cat_id != null) {
        $.ajax({
            url:path,
            type: "POST",
            data: {
                _token: token,
                id: cat_id,
            },
            success: function(response) {
                var html_option = [];
                $('#chil_cat_id' + j).select2().empty();
                if (response.data) {
                    $('#child_cat_div' + j).removeClass('d-none');
                    $.each(response.data, function(id, attribute_type) {
                        html_option.push(attribute_type);
                    });
                } else {
                    $('#child_cat_div' + j).addClass('d-none');
                }
                $('#chil_cat_id' + j).select2({
                    placeholder: 'Select Value',
                    data: html_option
                });
            }
        });
    }
}
$('#btnAdd-1').click(function() {
});


var i = 2;
var data = [];
var attr = [];
function variants(cat_id,option="",attrid){

    var token=$('meta[name="csrf-token"]').attr('content');
   var base_url = window.location.pathname ;
    var path=$('meta[name="base_url"]').attr('content')+'/admin/productattribute';
$('.variant1').removeClass('d-none');
        if (attr.indexOf(cat_id) == -1) {
            attr.push(cat_id);
            $.ajax({
                url: path,
                type: "POST",
                data: {
                    id: cat_id,
                    _token: token,
                },
                success: function(response) {
                    let details = ' <div class="row border1" id="child' + i + '">' +
                '<div class="col-md-3">' +
                '<div class="form-group">' +
                '<label for="example-text-input" class="col-sm-12 col-form-label">Attribute Type :</label>' +
                '<label for="example-text-input" class="col-sm-12 col-form-label">' + cat_id + '</label>' +
                '<input type="hidden"  class="form-control" name="attribute_name[]" value="'+cat_id+'" style="width:100%;" >' +
                '<input type="hidden"  class="form-control" name="attribute_id[]" value="'+attrid+'" style="width:100%;" >' +
                '</div>' +
                '</div>' +
                '<div  id="child_cat_div' + i + '">' +
                '<div class="col-md-12">' +
                '<label for="example-text-input" class="col-sm-12 col-form-label">Attribute Value :</label>' +
                '<select class="chil_cat_id required attribute_values"  name="attribute_value_'+cat_id+'[]" id="chil_cat_id' + i +
                '"  placeholder="Add Attribute" style="width:100%;" multiple="multiple" required></select>'+
                '<span class="error"></span>' +
                '</div>' +
                '</div>' +
                '<div class="col-md-2">' +
                '<label for="example-text-input" class="col-sm-12 col-form-label"></label>' +
                '<button type="button" class="mt-3 btn btn-sm my-2 btn-danger" id="' + i + '|' + cat_id +
                '" onclick="removeproduct(this)">Remove</button>' +
                '</div>' +
                '</div>';
            $('.product').append(details);
                    var html_option = [];
                    $('#chil_cat_id' + (i)).select2().empty();
                    if (response.data) {
                        //$('#child_cat_div'+i).removeClass('d-none');
                        $.each(response.data, function(id, attribute_type) {
                            html_option.push(attribute_type);
                        });
                    } else {
                        //$('#child_cat_div'+i).addClass('d-none');
                    }
                    $('#chil_cat_id' + (i)).select2({
                        placeholder: 'Select Value',
                        data: html_option
                    });
                    if(option){
                        let opt=JSON.parse(option).split(',');
                   $('#chil_cat_id' + (i)).val(opt).trigger("change");
                    }
                    i++;
                }
            });
        }
}
$('.addproduct').click(function() {
    let cat_id = $('#attr_type_select').val();
    if (cat_id != '') {
        variants(cat_id);
    }
});
$('.addvariant').click(function() {
    var allSelects = $('.chil_cat_id');

    if (allSelects.length === 0) {
        return;
    }

    // Check that all attribute selects have values
    var hasEmpty = false;
    allSelects.each(function() {
        if (!$(this).val() || $(this).val().length === 0) {
            hasEmpty = true;
        }
    });
    if (hasEmpty) {
        alert("Please select attribute values for all attribute types.");
        return;
    }

    // Collect all attribute value arrays
    var attributeArrays = [];
    allSelects.each(function() {
        attributeArrays.push($(this).val());
    });

    // Generate all combinations (cartesian product)
    function cartesian(arrays) {
        if (arrays.length === 0) return [[]];
        return arrays.reduce(function(acc, arr) {
            var result = [];
            acc.forEach(function(combo) {
                arr.forEach(function(val) {
                    result.push(combo.concat([val]));
                });
            });
            return result;
        }, [[]]);
    }

    var combinations = cartesian(attributeArrays);

    combinations.forEach(function(combo) {
        var comboKey = combo.join(',');

        // Check if this combination already exists (by comboKey in variant array)
        var alreadyExists = false;
        for (var v = 0; v < variant.length; v++) {
            if ($('#vchild' + variant[v]).find('input[name="attribute_value[]"]').val() === comboKey) {
                alreadyExists = true;
                break;
            }
        }
        if (alreadyExists) {
            return; // skip duplicate
        }

        var rand = 1 + Math.floor(Math.random() * 10000);
        var vid = rand;
        variant.push(vid);

        var labelText = '#' + vid + ' ' + combo.join(' / ');

        var details = '<div class="card border1" id="vchild' + vid + '"><div class="row">' +
            '<div class="col-md-4">' +
            '<div class="form-group">' +
            '<label for="example-text-input" class="col-sm-12 col-form-label">' + labelText + '</label>' +
            '</div>' +
            '</div>' +
            '<div class="col-md-6">' +
            '<label for="example-text-input" ></label>' +
            '<button type="button" class="btn btn-sm my-2 btn-danger pull-right mr-1" id="' +
            vid + '|' + comboKey +
            '" onclick="removevariant(this)"><i class="fa fa-trash-o"></i></button>' +
            '<button type="button" class="btn btn-sm my-2 btn-primary pull-right mr-1"  onclick="exvariant(\'vo' +
            vid + '\')"><i class="fa fa-expand"></i></button>' +
            '</div>' +
            '<div class="col-md-12" style="display:block;" id="vo' + vid + '">' +
            '<div class="row" style="padding: 10px 15px;">' +
            // SKU
            '<div class="col-md-3" style="padding: 0 8px;">' +
            '<div class="form-group">' +
            '<label class="col-form-label">SKU</label>' +
            '<input type="text" class="form-control required2 add_varianterrsku add_varianterrsku' + vid + '" name="sku[]" placeholder="SKU" required>' +
            '<div class="err_emptyval" style="color:red;display:none">This field is required</div>' +
            '<input type="hidden" name="variant_id[]" value="' + vid + '">' +
            '<input type="hidden" name="attribute_value[]" value="' + comboKey + '">' +
            '</div>' +
            '</div>' +
            // Color Mapping Field
            '<div class="col-md-3" style="padding: 0 8px;">' +
            '<div class="form-group">' +
            '<label class="col-form-label">Color (Hex Code)</label>' +
            '<div class="input-group">' +
            '<input type="color" class="form-control" style="width: 40px; padding: 2px; height: 38px; flex: 0 0 40px; border-radius: 4px 0 0 4px;" oninput="this.nextElementSibling.value = this.value; this.nextElementSibling.dispatchEvent(new Event(\'change\'))" value="#000000">' +
            '<input type="text" class="form-control" name="colors_' + vid + '[]" placeholder="eg. #0000FF" oninput="this.previousElementSibling.value = this.value">' +
            '</div>' +
            '<small class="text-muted">Pick color or enter hex.</small>' +
            '</div>' +
            '</div>' +
            // Image
            '<div class="col-md-3" style="padding: 0 8px;">' +
            '<div class="form-group">' +
            '<label class="col-form-label">Image</label>' +
            '<div class="input-group d-flex align-items-center" style="border: 1px dashed #ced4da; border-radius: 8px; padding: 0 5px; background: #fff; height: 38px;">' +
            '<span class="input-group-btn" style="margin-right:0;">' +
            '<a id="lfm' + vid + '" data-input="thumbnail' + vid + '" data-preview="holder' + vid + '" class="btn btn-primary ripple lfm-variant" style="border-radius: 6px; padding: 4px 10px; font-size: 13px;">' +
            '<i class="fa fa-picture-o"></i> Choose' +
            '</a>' +
            '</span>' +
            '<input id="thumbnail' + vid + '" class="form-control add_varianterrphoto" type="text" name="photo[]" style="border: none !important; box-shadow: none !important; background: transparent !important; margin-left: 10px; height: 100% !important; padding: 0; font-size: 13px;" placeholder="Select an image...">' +
            '</div>' +
            '<div class="err_emptyval" style="color:red;display:none">This field is required</div>' +
            '<div id="holder' + vid + '" style="margin-top:10px;max-height:80px;"></div>' +
            '</div>' +
            '</div>' +
            // Regular Price
            '<div class="col-md-3" style="padding: 0 8px;">' +
            '<div class="form-group">' +
            '<label class="col-form-label">Regular Price</label>' +
            '<input type="text" class="form-control required2 add_varianterrprice add_varianterrprice' + vid + '" name="regular_price[]" placeholder="Regular Price" required>' +
            '<div class="err_emptyval" style="color:red;display:none">This field is required</div>' +
            '</div>' +
            '</div>' +
            // Stock
            '<div class="col-md-3" style="padding: 0 8px;">' +
            '<div class="form-group">' +
            '<label class="col-form-label">Stock</label>' +
            '<input type="text" class="form-control required2 add_varianterrstock add_varianterrstock' + vid + '" name="stock[]" placeholder="Stock" required>' +
            '<div class="err_emptyval" style="color:red;display:none">This field is required</div>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '</div></div>';
        $('.variant').append(details);
        // Initialize file manager for this specific variant image button only
        var lfm_route = (typeof route_prefix !== 'undefined') ? route_prefix : ($('meta[name="route_prefix"]').attr('content') || '/laravel-filemanager');
        $('#lfm' + vid).filemanager('image', {prefix: lfm_route});
    }
    );
});
function removeproduct(d) {
    var id = d.id.split('|')[0];
    let dval = d.id.split('|')[1];
    //   var pid=d.id.split('|')[1];
    //   data=jQuery.grep(data, function(value) {
    //   return value != pid;
    // });
    attr.splice(attr.indexOf(dval), 1);
    $('#child' + id).remove();
    if (id == 1) {
        $('.variant1').addClass('d-none');
    }
    i--;
}
function removevariant(d) {
    //var id=d.id;
    var id = d.id.split('|')[0];
    let dval = d.id.split('|')[1];
    //   data=jQuery.grep(data, function(value) {
    //   return value != pid;
    // });
    //   attr.splice(attr.indexOf(dval),1);
    variant.splice(variant.indexOf(id), 1);
    $('#vchild' + id).remove();
}
function exvariant(d) {
// console.log(d);
//var id=d.id;
var id = d;
$('#'+ id).toggle();
}

$(document).on("change","#parent_category",function(){
    if( $('#parent_category').val() != ""){
         $('#category_title').text("Sub Category");
         $('#title').attr('placeholder','Enter Subcategory');
    }else{
        $('#title').attr('placeholder','Enter Category');
        $('#category_title').text("Category");
    }

    $(document).on("change","#cat_id",function(){
     var token=$('meta[name="csrf-token"]').attr('content');
    var path=$('meta[name="base_url"]').attr('content')+'/admin/get_subproducts';
            $.ajax({
                url:path,
                type: "GET",
                data: {
                    _token: token,
                    id: $('#cat_id').val(),
                },
                success: function(response) {
                    console.log(response);
                }
            });
    })



})
$(document).on("click","#user_save",function(){
    if($('#name').val() !="" && $('#email').val() !=""  && $('#phone').val() !=""  && $('#password').val() !="" && $('.role').val() !="" ){
        $('.name_err').html("");
        $('.email_err').html("");
        $('.phone_err').html("");
        $('.password_err').html("");
        $('.status_err').html("");
        var token=$('meta[name="csrf-token"]').attr('content');
        var path=$('meta[name="base_url"]').attr('content')+'/user_save';
        var redirect=$('meta[name="base_url"]').attr('content')+'/user_view';
        $.ajax({
            url:path,
            type: "POST",
            data: {
                _token: token,
                name: $('#name').val(),
                email: $('#email').val(),
                password: $('#password').val(),
                phone: $('#phone').val(),
                role: $('.role').val(),
            },
            success: function(response) {
                if(response.resval ==false){
                    $('.email_err').html(response.error);
                }else{
                   window.location.href=redirect;
                }
            }
        });
    }


    else if($('#name').val() == ""){
        $('.name_err').html("This field is required");
    }
    else if($('#email').val() == ""){
        $('.name_err').html("");
        $('.email_err').html("This field is required");
    }
    else if($('#phone').val() == ""){
        $('.name_err').html("");
        $('.email_err').html("");
        $('.phone_err').html("This field is required");
    }
    else if($('#password').val() == ""){
        $('.name_err').html("");
        $('.email_err').html("");
        $('.phone_err').html("");
        $('.password_err').html("This field is required");
    }
    else if($('.role').val() == ""){
        $('.name_err').html("");
        $('.email_err').html("");
        $('.phone_err').html("");
        $('.password_err').html("");
        $('.status_err').html("This field is required");
    }
})
