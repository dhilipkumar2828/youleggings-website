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

          $(".next").click(function() {



            var current_fs = $(this).parent();



            var inputs = current_fs.find(".required2"); // Select all elements with class 'required2'

             var inputs1 = current_fs.find(".add_varianterrphoto.required2"); // Select all elements with class 'add_varianterrphoto' and 'required2'



            inputs1.removeClass('required'); // Remove 'required' class

            inputs1.removeClass('required2'); // Remove 'required2' class

            var isErr = false;



            // Iterate through each input element with class 'required2'

            inputs.each(function(i, el) {

                if ($(el).val().trim() === "") { // Check if the input field is empty

                    isErr = true;



                    // Display error message next to the input field

                    $(el).next('.err_emptyval').css('display', 'block');

                } else {

                    // Hide error message if the field is filled

                    $(el).next('.err_emptyval').css('display', 'none');

                }

            });



            // If any required field is empty, prevent the form from proceeding

            if (isErr) {

                alert('Please fill in all required fields.');

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



            $(".previous").click(function(){

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

     var path=$('meta[name="base_url"]').attr('content')+'/get_subproducts';

      $('#subcat_id').val('');

       $('#child_cat').css('display','none');

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







$('#product_attribute').multifield();

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

    var path=$('meta[name="base_url"]').attr('content')+'/productattribute';

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

    var path=$('meta[name="base_url"]').attr('content')+'/productattribute';

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

    let cat_id = $('.cat_id').val();

    if (cat_id != '') {

        variants(cat_id);

    }

});

//var variant = [];

$('.addvariant').click(function() {

//  for(let k=2;k<=($('.chil_cat_id').length+1);k++){

if ($('.chil_cat_id').length > 1) {

for (let k1 = 0; k1 < ($('#chil_cat_id2').val().length); k1++) {

    for (let k2 = 0; k2 < ($('#chil_cat_id3').val().length); k2++) {

        // if (variant[$('#chil_cat_id2').val()[k1]] == undefined) {

        //     variant[$('#chil_cat_id2').val()[k1]]=[];

        // }

        let rand = 1 + Math.floor(Math.random() * 10000);

            let vid = (k2.length == 1) ?  rand :

                rand;

        if (variant.indexOf(vid) == -1) {

            //variant.push($('#chil_cat_id3').val()[k2]);

            variant.push(vid);

            var tempsku = Math.floor(100000 + Math.random() * 900000);

            let details = '<div class="card border1" id="vchild' + vid +

                '" > <div class="row" >' +

                '<div class="col-md-3">' +

                '<div class="form-group">' +

                '<label for="example-text-input" class="col-sm-12 col-form-label">#' + vid + ' ' + $(

                    '#chil_cat_id2').val()[k1] + '</label>' +

                '</div>' +

                '</div>' +

                '<div class="col-md-3">' +

                '<div class="form-group">' +

                '<label for="example-text-input" class="col-sm-12 col-form-label">' + $(

                    '#chil_cat_id3').val()[k2] + '</label>' +

                '</div>' +

                '</div>' +

                '<div class="col-md-6">' +

                '<label for="example-text-input" ></label>' +

                '<button type="button" class="tn btn-sm my-2 btn-danger pull-right mr-1" id="' +

                vid + '|' + $('#chil_cat_id3').val()[k2] +

                '" onclick="removevariant(this)"><i class="fa fa-trash-o"></i></button>' +

                '<button type="button" class="tn btn-sm my-2 btn-primary pull-right mr-1"  onclick=exvariant("vo'+

                vid + '")><i class="fa fa-expand"></i></button>' +

                '</div>' +

                '<div class="col-md-12"  id="vo' + vid +'">' +

                '<div class="row" >' +

                '<div class="col-md-3 ml-3">' +

                '<div class="form-group">' +

                '<label for="example-text-input" class="col-form-label">SKU:</label>' +

                '<input type="text"  class="form-control required2 add_varianterrsku add_varianterrsku'+vid+'" value="'+tempsku+'" name="sku[]"  placeholder="SKU" style="width:100%;" required>' +

                '<div class="err_emptyval" style="color:red;display:none">This field is required</div>'+

                '<input type="hidden"  class="form-control" name="variant_id[]" value="'+vid+'" style="width:100%;" >' +

                '<input type="hidden"  class="form-control" name="attribute_value[]" value="'+$(

                    '#chil_cat_id2').val()[k1]+','+$(

                    '#chil_cat_id3').val()[k2]+'" style="width:100%;" >' +

                 '    <span class="error"></span>'+

                '</div>' +

                '</div>' +

                '<div class="col-md-3">' +

                '<label for="example-text-input" class="col-form-label">Image</label>' +

                '<div class="input-group">' +

                '<span class="input-group-btn">' +

                '<a id="lfm" data-input="thumbnail' + vid + '" data-preview="holder' + vid + '" class="btn btn-primary lfm">' +

                '<i class="fa fa-picture-o"></i> Choose' +

                '</a>' +

                '</span>' +

                '<input id="thumbnail' + vid +

                '"  class="form-control add_varianterrphoto add_varianterrphoto'+vid+'  " type="text" name="photo[]" >' +

                '<div class="err_emptyval" style="color:red;display:none">This field is required</div>'+

                '</div>' +

                '    <span class="error"></span>'+

                '<div id="holder' + vid +

                '" style="margin-top:15px;max-height:100px;"></div>' +

                '</div>' +

                '<div class="col-md-3 ml-3">' +

                '<div class="form-group">' +

                '<label for="example-text-input" class="col-form-label">Regular Price:</label>' +

                '<input type="text"  class="form-control required2 add_varianterrprice add_varianterrprice'+vid+'" name="regular_price[]"  placeholder="Regular Price" style="width:100%;" required>' +

                '    <span class="error"></span>'+

                '<div class="err_emptyval" style="color:red;display:none">This field is required</div>'+

                '</div>' +

                '</div>' +

                '<div class="col-md-6 ml-6" style="padding: 0px 35px;" style="display:none;">' +

                 '<div class="form-group">' +

                 '<p>Product Colors</p>' +

                '<label style="padding: 5px;border-radius: 5px;color: white; background-color: red;"><input type="checkbox" value="Red" name="colors_'+vid+'[]" data-color="Red" style="width: 15px;height: 14px;"> Red</label>&nbsp;' +

                '<label style="padding: 5px;border-radius: 5px;color: white; background-color: Green;"><input type="checkbox" value="Green" name="colors_'+vid+'[]" data-color="Green" style="width: 15px;height: 14px;"> Green</label>&nbsp;' +

                '<label style="padding: 5px;border-radius: 5px;color: white; background-color: Blue;"><input type="checkbox" value="Blue" name="colors_'+vid+'[]" data-color="Blue" style="width: 15px;height: 14px;"> Blue</label>&nbsp;' +

                '<label style="padding: 5px;border-radius: 5px;color: white; background-color: Indigo;"><input type="checkbox" value="Indigo" name="colors_'+vid+'[]" data-color="Indigo" style="width: 15px;height: 14px;"> Indigo</label>&nbsp;' +

                '<label style="padding: 5px;border-radius: 5px;color: white; background-color: Orange;"><input type="checkbox" value="Orange" name="colors_'+vid+'[]" data-color="Orange" style="width: 15px;height: 14px;"> Orange</label>&nbsp;' +

                '<label style="padding: 5px;border-radius: 5px;color: white; background-color: Yellow;"><input type="checkbox" value="Yellow" name="colors_'+vid+'[]" data-color="Yellow" style="width: 15px;height: 14px;"> Yellow</label>&nbsp;' +

                '<label style="padding: 5px;border-radius: 5px;color: white; background-color: Violet;"><input type="checkbox" value="Violet" name="colors_'+vid+'[]" data-color="Violet" style="width: 15px;height: 14px;"> Violet</label>&nbsp;' +

                '<label style="padding: 5px;border-radius: 5px;color: white; background-color: Grey;"><input type="checkbox" value="Grey" name="colors_'+vid+'[]" data-color="Grey" style="width: 15px;height: 14px;"> Grey</label>&nbsp;' +

                '<label style="padding: 5px;border-radius: 5px;color: white; background-color: Maroon;"><input type="checkbox" value="Maroon" name="colors_'+vid+'[]" data-color="Maroon" style="width: 15px;height: 14px;"> Maroon</label>&nbsp;' +

                '<label style="padding: 5px;border-radius: 5px;color: white; background-color: Black;"><input type="checkbox" value="Black" name="colors_'+vid+'[]" data-color="Black" style="width: 15px;height: 14px;"> Black</label>&nbsp;' +

                '<label style="padding: 5px;border-radius: 5px;color: white; background-color: Olive;"><input type="checkbox" value="Olive" name="colors_'+vid+'[]" data-color="Olive" style="width: 15px;height: 14px;"> Olive</label>&nbsp;' +

                '<label style="padding: 5px;border-radius: 5px;color: white; background-color: Cyan;"><input type="checkbox" value="Cyan" name="colors_'+vid+'[]" data-color="Cyan" style="width: 15px;height: 14px;"> Cyan</label>&nbsp;' +

                '<label style="padding: 5px;border-radius: 5px;color: white; background-color: Pink;"><input type="checkbox" value="Pink" name="colors_'+vid+'[]" data-color="Pink" style="width: 15px;height: 14px;"> Pink</label>&nbsp;' +

                '<label style="padding: 5px;border-radius: 5px;color: white; background-color: Magenta;"><input type="checkbox" value="Magenta" name="colors_'+vid+'[]" data-color="Magenta" style="width: 15px;height: 14px;"> Magenta</label>&nbsp;' +

                '<label style="padding: 5px;border-radius: 5px;color: white; background-color: Tan;"><input type="checkbox" value="Tan" name="colors_'+vid+'[]" data-color="Tan" style="width: 15px;height: 14px;"> Tan</label>&nbsp;' +

                '<label style="padding: 5px;border-radius: 5px;color: white; background-color: Teal;"><input type="checkbox" value="Teal" name="colors_'+vid+'[]" data-color="Teal" style="width: 15px;height: 14px;"> Teal</label>' +

                 '</div>' +

                 '</div>' +

                '<div class="col-md-3 ml-3">' +

                '<div class="form-group">' +

                '<label  for="example-text-input" class="col-form-label">Stock:</label>' +

                '<input type="text"  class="form-control required2 add_varianterrstock add_varianterrstock'+vid+'" name="stock[]" placeholder="Stock" style="width:100%;" value="0" required>' +

                '<div class="err_emptyval" style="color:red;display:none">This field is required</div>'+

                '<span class="error"></span>'+

                '</div>' +

                '</div>' +

                '</div>' +

                '</div>' +

                '</div></div>';

            $('.variant').append(details);

            $('.lfm').filemanager('image');

                    }

    }

    //  console.log($('#chil_cat_id2').val());

}

} else {

for (let k1 = 0; k1 < ($('#chil_cat_id2').val().length); k1++) {

    let rand = 1 + Math.floor(Math.random() * 10000);

            let vid = (k1.length == 1) ?  rand :

                rand;

    if (variant.indexOf(vid) == -1) {

            //variant.push($('#chil_cat_id3').val()[k2]);

            variant.push(vid);

            var tempsku = Math.floor(100000 + Math.random() * 900000);

        let details = '<div class="card border1"  id="vchild' + vid + '"><div class="row">' +

            '<div class="col-md-3">' +

            '<div class="form-group">' +

            '<label for="example-text-input" class="col-sm-12 col-form-label">#' + vid + ' ' + $(

                    '#chil_cat_id2').val()[k1] + '</label>' +

            '</div>' +

            '</div>' +

            '<div class="col-md-6">' +

            '<label for="example-text-input" ></label>' +

            '<button type="button" class="tn btn-sm my-2 btn-danger pull-right mr-1" id="' + vid +

            '|' + $('#chil_cat_id2').val()[k1] +

            '" onclick="removevariant(this)"><i class="fa fa-trash-o"></i></button>' +

            '<button type="button" class="tn btn-sm my-2 btn-primary pull-right mr-1"  onclick=exvariant("vo' +

            vid + '")><i class="fa fa-expand"></i></button>' +

            '</div>' +

            '<div class="col-md-12"  id="vo'+vid+'">' +

                '<div class="row" >' +

                '<div class="col-md-3 ml-3">' +

                '<div class="form-group">' +

                '<label for="example-text-input" class="col-form-label">SKU:</label>' +

                '<input type="text"  class="form-control required2 add_varianterrsku  add_varianterrsku'+vid+'" value="'+tempsku+'" name="sku[]"  placeholder="SKU" style="width:100%;" required>' +

                '<div class="err_emptyval" style="color:red;display:none">This field is required</div>'+

                '<input type="hidden"  class="form-control" name="variant_id[]" value="'+vid+'" style="width:100%;" >' +

                '<input type="hidden"  class="form-control" name="attribute_value[]" value="'+$(

                    '#chil_cat_id2').val()[k1]+'" style="width:100%;" >' +

                '    <span class="error"></span>'+

                '</div>' +

                '</div>' +

                '<div class="col-md-3">' +

                '<label for="example-text-input" class="col-form-label">Image</label>' +

                '<div class="input-group">' +

                '<span class="input-group-btn">' +

                '<a id="lfm" data-input="thumbnail' + vid + '" data-preview="holder' + vid + '" class="btn btn-primary lfm">' +

                '<i class="fa fa-picture-o"></i> Choose' +

                '</a>' +

                '</span>' +

                '<input id="thumbnail' + vid +

                '"  class="form-control  add_varianterrphoto add_varianterrphoto'+vid+'  " type="text" name="photo[]" >' +

                '<div class="err_emptyval" style="color:red;display:none">This field is required</div>'+

                '</div>' +

                '    <span class="error"></span>'+

                '<div id="holder' + vid +

                '" style="margin-top:15px;max-height:100px;"></div>' +

                '</div>' +

                '<div class="col-md-3 ml-3">' +

                '<div class="form-group">' +

                '<label for="example-text-input" class="col-form-label">Regular Price:</label>' +

                '<input type="text"  class="form-control required2 add_varianterrprice add_varianterrprice'+vid+'" name="regular_price[]"  placeholder="Regular Price" style="width:100%;" required>' +

                '<div class="err_emptyval" style="color:red;display:none">This field is required</div>'+

                '    <span class="error"></span>'+

                '</div>' +

                '</div>' +

                 '<div class="col-md-6 ml-6" style="display:none;" style="padding: 0px 35px;">' +

                 '<div class="form-group">' +

                 '<p>Product Colors:</p>' +

                 '<label style="padding: 5px;border-radius: 5px;color: white; background-color: red;"><input type="checkbox" value="Red" name="colors_'+vid+'[]" data-color="Red" style="width: 15px;height: 14px;"> Red</label>&nbsp;' +

                '<label style="padding: 5px;border-radius: 5px;color: white; background-color: Green;"><input type="checkbox" value="Green" name="colors_'+vid+'[]" data-color="Green" style="width: 15px;height: 14px;"> Green</label>&nbsp;' +

                '<label style="padding: 5px;border-radius: 5px;color: white; background-color: Blue;"><input type="checkbox" value="Blue" name="colors_'+vid+'[]" data-color="Blue" style="width: 15px;height: 14px;"> Blue</label>&nbsp;' +

                '<label style="padding: 5px;border-radius: 5px;color: white; background-color: Indigo;"><input type="checkbox" value="Indigo" name="colors_'+vid+'[]" data-color="Indigo" style="width: 15px;height: 14px;"> Indigo</label>&nbsp;' +

                '<label style="padding: 5px;border-radius: 5px;color: white; background-color: Orange;"><input type="checkbox" value="Orange" name="colors_'+vid+'[]" data-color="Orange" style="width: 15px;height: 14px;"> Orange</label>&nbsp;' +

                '<label style="padding: 5px;border-radius: 5px;color: white; background-color: Yellow;"><input type="checkbox" value="Yellow" name="colors_'+vid+'[]" data-color="Yellow" style="width: 15px;height: 14px;"> Yellow</label>&nbsp;' +

                '<label style="padding: 5px;border-radius: 5px;color: white; background-color: Violet;"><input type="checkbox" value="Violet" name="colors_'+vid+'[]" data-color="Violet" style="width: 15px;height: 14px;"> Violet</label>&nbsp;' +

                '<label style="padding: 5px;border-radius: 5px;color: white; background-color: Grey;"><input type="checkbox" value="Grey" name="colors_'+vid+'[]" data-color="Grey" style="width: 15px;height: 14px;"> Grey</label>&nbsp;' +

                '<label style="padding: 5px;border-radius: 5px;color: white; background-color: Maroon;"><input type="checkbox" value="Maroon" name="colors_'+vid+'[]" data-color="Maroon" style="width: 15px;height: 14px;"> Maroon</label>&nbsp;' +

                '<label style="padding: 5px;border-radius: 5px;color: white; background-color: Black;"><input type="checkbox" value="Black" name="colors_'+vid+'[]" data-color="Black" style="width: 15px;height: 14px;"> Black</label>&nbsp;' +

                '<label style="padding: 5px;border-radius: 5px;color: white; background-color: Olive;"><input type="checkbox" value="Olive" name="colors_'+vid+'[]" data-color="Olive" style="width: 15px;height: 14px;"> Olive</label>&nbsp;' +

                '<label style="padding: 5px;border-radius: 5px;color: white; background-color: Cyan;"><input type="checkbox" value="Cyan" name="colors_'+vid+'[]" data-color="Cyan" style="width: 15px;height: 14px;"> Cyan</label>&nbsp;' +

                '<label style="padding: 5px;border-radius: 5px;color: white; background-color: Pink;"><input type="checkbox" value="Pink" name="colors_'+vid+'[]" data-color="Pink" style="width: 15px;height: 14px;"> Pink</label>&nbsp;' +

                '<label style="padding: 5px;border-radius: 5px;color: white; background-color: Magenta;"><input type="checkbox" value="Magenta" name="colors_'+vid+'[]" data-color="Magenta" style="width: 15px;height: 14px;"> Magenta</label>&nbsp;' +

                '<label style="padding: 5px;border-radius: 5px;color: white; background-color: Tan;"><input type="checkbox" value="Tan" name="colors_'+vid+'[]" data-color="Tan" style="width: 15px;height: 14px;"> Tan</label>&nbsp;' +

                '<label style="padding: 5px;border-radius: 5px;color: white; background-color: Teal;"><input type="checkbox" value="Teal" name="colors_'+vid+'[]" data-color="Teal" style="width: 15px;height: 14px;"> Teal</label>' +

                 '</div>' +

                 '</div>' +

                '<div class="col-md-3 ml-3">' +

                '<div class="form-group">' +

                '<label for="example-text-input" class="col-form-label">Stock:</label>' +

                '<input type="text"  class="form-control required2 add_varianterrstock add_varianterrstock'+vid+'" name="stock[]" value="0" placeholder="Stock" style="width:100%;" required>' +

                '<div class="err_emptyval" style="color:red;display:none">This field is required</div>'+

                '    <span class="error"></span>'+

                '</div>' +

                '</div>' +

                '</div>' +

                '</div>' +

            '</div></div>';

        $('.variant').append(details);

            $('.lfm').filemanager('image');

        //  console.log($('#chil_cat_id2').val());

    }

}

}

//   console.log($('#chil_cat_id'+k).val());

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

     var path=$('meta[name="base_url"]').attr('content')+'/get_subproducts';

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

