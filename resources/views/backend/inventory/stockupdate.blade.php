@extends('backend.layouts.master')

@section('content')

    <style>
        .border1 {

            border: 1px solid #508aeb;

            border-radius: 10px;

            margin-bottom: 1%;

            margin-left: 0%;

            margin-right: 0%;

        }
    </style>

    <div class="page-content-wrapper ">

        <div class="container-fluid">

            <div class="row">

                <div class="col-sm-12">

                    <div class="float-right page-breadcrumb">

                        <ol class="breadcrumb">

                            <li class="breadcrumb-item"><a href="{{ route('product.index') }}"> Product</a></li>

                            <li class="breadcrumb-item active">Update Product Stock</li>

                        </ol>

                    </div>

                </div>

            </div>

            <!-- end row -->

            <div class="card m-b-30 card-body">

                <h4 class="card-title font-20 mt-0">

                    <strong> {{ $Product->name }}</strong>

                </h4>

                <a href="{{ route('product.index') }}" id="add-btn" style="color: #ffffff;"><i class="fa fa-angle-left"
                        aria-hidden="true"></i> Back</a>

            </div>

            <div class="row">

                <div class="col-lg-12">

                    @if ($errors->any())
                        <div class="alert alert-danger">

                            <ul>

                                @foreach ($errors->all() as $error)
                                    <li>

                                        {{ $error }}

                                    </li>
                                @endforeach

                            </ul>

                        </div>
                    @endif

                    @include('backend.layouts.notification')

                </div>

                <div class="col-sm-12 col-md-6">

                    <div id="datatable-buttons_filter" class="dataTables_filter">

                    </div>

                </div>

            </div>

            <!-- <div>

                            <h4> Total Product Attribute : {{ \App\Models\ProductAttribute::count() }}</h4>

                        </div> -->

            <div class="row">

                <div class="col-12">

                    <div class="card m-b-30">

                        <form action="{{ route('updatestockstore') }}" method="POST">

                            @csrf

                            <input type="hidden" name="id" value="{{ $Product->id }}">

                            <div id="product_attribute" class="content"
                                data-mfield-options='{"section": ".group","btnAdd":"#btnAdd-1","btnRemove":".btnRemove"}'>

                                <div class=" container-fluid ">

                                    <div class="row">

                                        <div class="col-md-12">

                                            <div class="row">

                                                <div class="col-md-3">

                                                    Varient

                                                </div>

                                                <div class="col-md-2">

                                                    Current Available Stocks

                                                </div>

                                                <div class="col-md-3">

                                                    #

                                                </div>

                                            </div>

                                            <div class="col-md-12">

                                                <hr />

                                            </div>

                                            <?php

                                   for($i=0;$i<count($productvariant);$i++){?>

                                            <div class="row">

                                                <div class="col-md-3">

                                                    {{ $productvariant[$i]->variants }} - {{ $productvariant[$i]->sku }}

                                                </div>

                                                <div class="col-md-2 tac" style="text-align:center;">

                                                    {{ $productvariant[$i]->in_stock }}

                                                </div>

                                                <div class="col-md-3"> <a
                                                        href="{{ route('viewstocklogs', $productvariant[$i]->id) }}"
                                                        target="_blank">View Stock Logs</a>

                                                </div>

                                            </div>

                                            <?php }

                                   ?>

                                            <div class="col-md-12">

                                                <hr />

                                            </div>

                                        </div>

                                        <div class="col-md-12 tac">

                                            <div class="row">

                                                <div class="col-md-3">

                                                    Select Varient

                                                </div>

                                                <div class="col-md-6 tac">

                                                    <select class="form-control" name="v_id" id="v_id">

                                                        <option value="">Select Varient</option>

                                                        <?php

                                   for($i=0;$i<count($productvariant);$i++){?>

                                                        <option value="{{ $productvariant[$i]->id }}"
                                                            data-stock="{{ $productvariant[$i]->in_stock }}">
                                                            {{ $productvariant[$i]->variants }} -
                                                            {{ $productvariant[$i]->sku }}</option>

                                                        <?php }

                                   ?>

                                                    </select>

                                                </div>

                                            </div>

                                        </div>

                                        <div class="col-md-12 tac">

                                            <div class="row">

                                                <div class="col-md-3">

                                                    Select Add Stocks/ Reduce Stocks

                                                </div>

                                                <div class="col-md-6 tac">

                                                    <select class="form-control" name="opr" id="opr">

                                                        <option value="">Select Option</option>

                                                        <option value="add">Add Stocks</option>

                                                        <option value="minus">Reduce Stocks</option>

                                                    </select>

                                                </div>

                                            </div>

                                        </div>

                                        <div class="col-md-12">

                                            <div class="row">

                                                <div class="col-md-3">

                                                    Select Varient

                                                </div>

                                                <div class="col-md-6">

                                                    <input type="number" min="1" class="form-control"
                                                        name="stockvalue" id="stockvalue"
                                                        placeholder="Enter the Stock value which you want to add or reduce">

                                                </div>

                                            </div>

                                        </div>

                                        <div class=" col-md-12 variant">

                                        </div>

                                    </div>

                                </div>

                            </div>

                            <div class="col-md-1">

                                <div class="form-group pull-right">

                                    <button type="button" id="checkstockupdate" class="btn btn btn-info "
                                        style="margin-top:.8em;">Save</button>

                                </div>

                            </div>

                        </form>

                    </div>

                </div> <!-- end col -->

            </div>

        </div> <!-- end row -->

    @endsection

    @section('scripts')
        <script src="{{ asset('assets/js/jquery.multifield.min.js') }}"></script>

        <script src="{{ asset('public/vendor/laravel-filemanager/js/stand-alone-button.js') }}"></script>

        <script>
            $('#product_attribute').multifield();

            // $('#chil_cat_id1').select2({

            //     placeholder:"Select Value"

            // });
        </script>

        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

        <script>
            $.ajaxSetup({

                headers: {

                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

                }

            });

            $('#checkstockupdate').click(function(e) {

                e.preventDefault();

                var form = $(this).closest('form');

                var currentStock = +($('#v_id').find(":selected").attr('data-stock'));

                var stockOpr = $('#opr').val();

                var stockval = +$('#stockvalue').val();

                if ($('#v_id').val() == "") {

                    swal("Atleast one Varient should select");

                    return false;

                }

                if (stockOpr == "") {

                    swal("Should select atleast one option Add Stocks or Reduce Stocks");

                    return false;

                }

                if (stockval < 1) {

                    swal("Stock input value should be more than 0");

                    return false;

                }

                if (stockOpr == "add") {

                    var newstock = (+currentStock) + stockval;

                } else {

                    if (stockval > currentStock) {

                        $('#stockvalue').val('0');

                        swal("Current Stock is " + currentStock + ", but trying to reduce " + stockval +
                            " is not possible.");

                        return false;

                    }

                    var newstock = (+currentStock) - stockval;

                }

                swal({

                        title: "Are you sure to want " + stockOpr + " " + stockval + " to this varient ?" +
                            "New Stock will be " + newstock,

                        text: 'Confirmation',

                        icon: "warning",

                        buttons: true,

                        dangerMode: true,

                    })

                    .then((willDelete) => {

                        if (willDelete) {

                            form.submit();

                            swal("Stock Updated!!", {

                                icon: "success",

                            });

                        } else {

                            swal("Please check once and update!");

                        }

                    });

            });

            $('.dltBtn').click(function(e) {

                var form = $(this).closest('form');

                var dataID = $(this).data('id');

                e.preventDefault();

                swal({

                        title: "Are you sure?",

                        text: "Once deleted, you will not be able to recover",

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
        </script>

        <script>
            $('input[name=toogle]').change(function() {

                var mode = $(this).prop('checked');

                var id = $(this).val();

                // alert(id);

                $.ajax({

                    url: "{{ route('product.status') }}",

                    type: "POST",

                    data: {

                        _token: '{{ csrf_token() }}',

                        mode: mode,

                        id: id,

                    },

                    success: function(response) {

                        //   console.log(response.status);

                    }

                })

            });
        </script>

        <script>
            function cat1(val, j) {

                var cat_id = val;

                if (cat_id != null) {

                    $.ajax({

                        url: "{{ route('product.attribute') }}",

                        type: "POST",

                        data: {

                            _token: "{{ csrf_token() }}",

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
        </script>

        <script>
            var i = 2;

            var data = [];

            var attr = [];

            function variants(cat_id, option = "", attrid) {

                $('.variant1').removeClass('d-none');

                if (attr.indexOf(cat_id) == -1) {

                    attr.push(cat_id);

                    $.ajax({

                        url: "{{ route('product.attribute') }}",

                        type: "POST",

                        data: {

                            _token: "{{ csrf_token() }}",

                            id: cat_id,

                        },

                        success: function(response) {

                            let details = ' <div class="row border1" id="child' + i + '">' +

                                '<div class="col-md-3">' +

                                '<div class="form-group">' +

                                '<label for="example-text-input" class="col-sm-12 col-form-label">Attribute Type :</label>' +

                                '<label for="example-text-input" class="col-sm-12 col-form-label">' + cat_id +
                                '</label>' +

                                '<input type="hidden"  class="form-control" name="attribute_name[]" value="' +
                                cat_id + '" style="width:100%;" >' +

                                '<input type="hidden"  class="form-control" name="attribute_id[]" value="' +
                                attrid + '" style="width:100%;" >' +

                                '</div>' +

                                '</div>' +

                                '<div  id="child_cat_div' + i + '">' +

                                '<div class="col-md-12">' +

                                '<label for="example-text-input" class="col-sm-12 col-form-label">Attribute Value :</label>' +

                                '<select class="chil_cat_id"  name="attribute_value_' + cat_id +
                                '[]" id="chil_cat_id' + i +

                                '" required placeholder="Add Attribute" style="width:100%;" multiple="multiple" ></select>' +

                                '</div>' +

                                '</div>' +

                                '<div class="col-md-2">' +

                                '<label for="example-text-input" class="col-sm-12 col-form-label"></label>' +

                                '<button type="button" class="mt-3 btn btn-sm my-2 btn-danger" id="' + i + '|' +
                                cat_id +

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

                            if (option) {

                                let opt = JSON.parse(option).split(',');

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

            var variant = [];

            $('.addvariant').click(function() {

                //  for(let k=2;k<=($('.chil_cat_id').length+1);k++){

                if ($('.chil_cat_id').length > 1) {

                    for (let k1 = 0; k1 < ($('#chil_cat_id2').val().length); k1++) {

                        for (let k2 = 0; k2 < ($('#chil_cat_id3').val().length); k2++) {

                            // if (variant[$('#chil_cat_id2').val()[k1]] == undefined) {

                            //     variant[$('#chil_cat_id2').val()[k1]]=[];

                            // }

                            let rand = 1 + Math.floor(Math.random() * 10000);

                            let vid = (k2.length == 1) ? '{{ $Product->id }}' + rand : '{{ $Product->id }}' +

                                rand;

                            if (variant.indexOf(vid) == -1) {

                                //variant.push($('#chil_cat_id3').val()[k2]);

                                variant.push(vid);

                                let details = '<div class="card border1" id="vchild' + vid +

                                    '" > <div class="row" >' +

                                    '<div class="col-md-3">' +

                                    '<div class="form-group">' +

                                    '<label for="example-text-input" class="col-sm-12 col-form-label">#' + vid + ' ' +
                                    $(

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

                                    '<button type="button" class="tn btn-sm my-2 btn-primary pull-right mr-1"  onclick=exvariant("vo' +

                                    vid + '")><i class="fa fa-expand"></i></button>' +

                                    '</div>' +

                                    '<div class="col-md-12" style="display:none;" id="vo' + vid + '">' +

                                    '<div class="row" >' +

                                    '<div class="col-md-3 ml-3">' +

                                    '<div class="form-group">' +

                                    '<label for="example-text-input" class="col-form-label">SKU:</label>' +

                                    '<input type="text"  class="form-control" name="sku[]" required placeholder="SKU" style="width:100%;" >' +

                                    '<input type="hidden"  class="form-control" name="variant_id[]" value="' + vid +
                                    '" style="width:100%;" >' +

                                    '<input type="hidden"  class="form-control" name="attribute_value[]" value="' + $(

                                        '#chil_cat_id2').val()[k1] + ',' + $(

                                        '#chil_cat_id3').val()[k2] + '" style="width:100%;" >' +

                                    '</div>' +

                                    '</div>' +

                                    '<div class="col-md-3">' +

                                    '<label for="example-text-input" class="col-form-label">Image</label>' +

                                    '<div class="input-group">' +

                                    '<span class="input-group-btn">' +

                                    '<a id="lfm" data-input="thumbnail' + vid + '" data-preview="holder' + vid +
                                    '" class="btn btn-primary lfm">' +

                                    '<i class="fa fa-picture-o"></i> Choose' +

                                    '</a>' +

                                    '</span>' +

                                    '<input id="thumbnail' + vid +

                                    '" required class="form-control" type="text" name="photo[]">' +

                                    '</div>' +

                                    '<div id="holder' + vid +

                                    '" style="margin-top:15px;max-height:100px;"></div>' +

                                    '</div>' +

                                    '<div class="col-md-3 ml-3">' +

                                    '<div class="form-group">' +

                                    '<label for="example-text-input" class="col-form-label">Regular Price:</label>' +

                                    '<input type="text"  class="form-control" name="regular_price[]" required placeholder="Regular Price" style="width:100%;" >' +

                                    '</div>' +

                                    '</div>' +

                                    '<div class="col-md-3 ml-3">' +

                                    '<div class="form-group">' +

                                    '<label for="example-text-input" class="col-form-label">Sale Price:</label>' +

                                    '<input type="text"  class="form-control" name="sale_price[]" required placeholder="Sale Price" style="width:100%;" >' +

                                    '</div>' +

                                    '</div>' +

                                    '<div class="col-md-3">' +

                                    '<div class="form-group">' +

                                    '<label for="example-text-input" class="col-form-label">Stock:</label>' +

                                    '<input type="text"  class="form-control" name="stock[]" placeholder="Stock" style="width:100%;" >' +

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

                        let vid = (k1.length == 1) ? '{{ $Product->id }}' + rand : '{{ $Product->id }}' +

                            rand;

                        if (variant.indexOf(vid) == -1) {

                            //variant.push($('#chil_cat_id3').val()[k2]);

                            variant.push(vid);

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

                                '<div class="col-md-12" style="display:none;" id="vo' + vid + '">' +

                                '<div class="row" >' +

                                '<div class="col-md-3 ml-3">' +

                                '<div class="form-group">' +

                                '<label for="example-text-input" class="col-form-label">SKU:</label>' +

                                '<input type="text"  class="form-control" name="sku[]" required placeholder="SKU" style="width:100%;" >' +

                                '<input type="hidden"  class="form-control" name="variant_id[]" value="' + vid +
                                '" style="width:100%;" >' +

                                '<input type="hidden"  class="form-control" name="attribute_value[]" value="' + $(

                                    '#chil_cat_id2').val()[k1] + '" style="width:100%;" >' +

                                '</div>' +

                                '</div>' +

                                '<div class="col-md-3">' +

                                '<label for="example-text-input" class="col-form-label">Image</label>' +

                                '<div class="input-group">' +

                                '<span class="input-group-btn">' +

                                '<a id="lfm" data-input="thumbnail' + vid + '" data-preview="holder' + vid +
                                '" class="btn btn-primary lfm">' +

                                '<i class="fa fa-picture-o"></i> Choose' +

                                '</a>' +

                                '</span>' +

                                '<input id="thumbnail' + vid +

                                '" required class="form-control" type="text" name="photo[]">' +

                                '</div>' +

                                '<div id="holder' + vid +

                                '" style="margin-top:15px;max-height:100px;"></div>' +

                                '</div>' +

                                '<div class="col-md-3 ml-3">' +

                                '<div class="form-group">' +

                                '<label for="example-text-input" class="col-form-label">Regular Price:</label>' +

                                '<input type="text"  class="form-control" name="regular_price[]" required placeholder="Regular Price" style="width:100%;" >' +

                                '</div>' +

                                '</div>' +

                                '<div class="col-md-3 ml-3">' +

                                '<div class="form-group">' +

                                '<label for="example-text-input" class="col-form-label">Sale Price:</label>' +

                                '<input type="text"  class="form-control" name="sale_price[]" required placeholder="Sale Price" style="width:100%;" >' +

                                '</div>' +

                                '</div>' +

                                '<div class="col-md-3">' +

                                '<div class="form-group">' +

                                '<label for="example-text-input" class="col-form-label">Stock:</label>' +

                                '<input type="text"  class="form-control" name="stock[]" placeholder="Stock" style="width:100%;" >' +

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

                $('#' + id).toggle();

            }

            function product_attribute(id) {

                $.ajax({

                    url: "{{ route('product.variant') }}",

                    type: "POST",

                    data: {

                        _token: "{{ csrf_token() }}",

                        id: id,

                    },

                    success: function(response) {

                        let productattribute = response.productattribute;

                        let productvariant = response.productvariant;

                        $.each(productattribute, function(key, data) {

                            let arrtibute_value = JSON.stringify(data.arrtibute_value).split(',');

                            variants(data.arrtibute_name, arrtibute_value, data.id);

                        });

                        $.each(productvariant, function(key, data) {

                            let arrtibute_name = JSON.stringify(data.arrtibute_name).split(',');

                            if (arrtibute_name.length > 1) {

                                let arrtibute_name_len0 = arrtibute_name[0].replace('"', '');

                                let arrtibute_name_len1 = arrtibute_name[1].replace('"', '');

                                //     if (variant[arrtibute_name_len0] == undefined) {

                                //     variant[arrtibute_name_len0]=[];

                                // }

                                if (variant.indexOf(data.variant_id) == -1) {

                                    variant.push(data.variant_id);

                                    let details = '<div class="card border1" id="vchild' + data.variant_id +

                                        '" > <div class="row" >' +

                                        '<div class="col-md-3">' +

                                        '<div class="form-group">' +

                                        '<label for="example-text-input" class="col-sm-12 col-form-label">#' +
                                        data.variant_id + ' ' + arrtibute_name[0].replace('"', '') +
                                        '</label>' +

                                        '</div>' +

                                        '</div>' +

                                        '<div class="col-md-3">' +

                                        '<div class="form-group">' +

                                        '<label for="example-text-input" class="col-sm-12 col-form-label">' +
                                        arrtibute_name[1].replace('"', '') + '</label>' +

                                        '</div>' +

                                        '</div>' +

                                        '<div class="col-md-6">' +

                                        '<label for="example-text-input" ></label>' +

                                        '<button type="button" class="tn btn-sm my-2 btn-danger pull-right mr-1" id="' +

                                        data.variant_id + '|' + arrtibute_name[1].replace('"', '') +

                                        '" onclick="removevariant(this)"><i class="fa fa-trash-o"></i></button>' +

                                        '<button type="button" class="tn btn-sm my-2 btn-primary pull-right mr-1"  onclick=exvariant("vo' +

                                        data.variant_id + '")><i class="fa fa-expand"></i></button>' +

                                        '</div>' +

                                        '<div class="col-md-12" style="display:none;" id="vo' + data
                                        .variant_id + '">' +

                                        '<div class="row" >' +

                                        '<div class="col-md-3 ml-3">' +

                                        '<div class="form-group">' +

                                        '<label for="example-text-input" class="col-form-label">SKU:</label>' +

                                        '<input type="text"  class="form-control" name="sku[]" required placeholder="SKU" value="' +
                                        data.sku + '" style="width:100%;" >' +

                                        '<input type="hidden"  class="form-control" name="variant_id[]" value="' +
                                        data.variant_id + '" style="width:100%;" >' +

                                        '<input type="hidden"  class="form-control" name="attribute_value[]" value="' +
                                        arrtibute_name[0].replace('"', '') + ',' + arrtibute_name[1]
                                        .replace('"', '') + '" style="width:100%;" >' +

                                        '</div>' +

                                        '</div>' +

                                        '<div class="col-md-3">' +

                                        '<label for="example-text-input" class="col-form-label">Image</label>' +

                                        '<div class="input-group">' +

                                        '<span class="input-group-btn">' +

                                        '<a id="lfm" data-input="thumbnail' + data.variant_id +
                                        '" data-preview="holder' + data.variant_id +
                                        '" class="btn btn-primary lfm">' +

                                        '<i class="fa fa-picture-o"></i> Choose' +

                                        '</a>' +

                                        '</span>' +

                                        '<input id="thumbnail' + data.variant_id +

                                        '" required value="' + data.photo +
                                        '" class="form-control" type="text" name="photo[]">' +

                                        '</div>' +

                                        '<div id="holder' + data.variant_id +

                                        '" style="margin-top:15px;max-height:100px;"><img src="' + data
                                        .photo +
                                        '" alt="promo image"style="max-height: 90px;max-width:120px"></div>' +

                                        '</div>' +

                                        '<div class="col-md-3 ml-3">' +

                                        '<div class="form-group">' +

                                        '<label for="example-text-input" class="col-form-label">Regular Price:</label>' +

                                        '<input type="text"  class="form-control" value="' + data
                                        .regular_price +
                                        '" name="regular_price[]" required placeholder="Regular Price" style="width:100%;" >' +

                                        '</div>' +

                                        '</div>' +

                                        '<div class="col-md-3 ml-3">' +

                                        '<div class="form-group">' +

                                        '<label for="example-text-input" class="col-form-label">Sale Price:</label>' +

                                        '<input type="text"  class="form-control" name="sale_price[]" value="' +
                                        data.sale_price +
                                        '" required placeholder="Sale Price" style="width:100%;" >' +

                                        '</div>' +

                                        '</div>' +

                                        '<div class="col-md-3">' +

                                        '<div class="form-group">' +

                                        '<label for="example-text-input" class="col-form-label">Stock:</label>' +

                                        '<input type="text"  class="form-control" name="stock[]" value="' +
                                        data.stock + '" placeholder="Stock" style="width:100%;" >' +

                                        '</div>' +

                                        '</div>' +

                                        '</div>' +

                                        '</div>' +

                                        '</div></div>';

                                    $('.variant').append(details);

                                    $('.lfm').filemanager('image');

                                } else {

                                    // variant.push(arrtibute_name_len0);

                                    if (variant.indexOf(data.variant_id) == -1) {

                                        variant.push(data.variant_id);

                                        let details = '<div class="card border1"  id="vchild' + data
                                            .variant_id + '"><div class="row">' +

                                            '<div class="col-md-3">' +

                                            '<div class="form-group">' +

                                            '<label for="example-text-input" class="col-sm-12 col-form-label">#' +
                                            data.variant_id + ' ' + arrtibute_name[0].replace('"', '') +
                                            '</label>' +

                                            '</div>' +

                                            '</div>' +

                                            '<div class="col-md-6">' +

                                            '<label for="example-text-input" ></label>' +

                                            '<button type="button" class="tn btn-sm my-2 btn-danger pull-right mr-1" id="' +
                                            data.variant_id +

                                            '|' + arrtibute_name[0].replace('"', '') +

                                            '" onclick="removevariant(this)"><i class="fa fa-trash-o"></i></button>' +

                                            '<button type="button" class="tn btn-sm my-2 btn-primary pull-right mr-1"  onclick=exvariant("vo' +

                                            data.variant_id + '")><i class="fa fa-expand"></i></button>' +

                                            '</div>' +

                                            '<div class="col-md-12" style="display:none;" id="vo' + data
                                            .variant_id + '">' +

                                            '<div class="row" >' +

                                            '<div class="col-md-3 ml-3">' +

                                            '<div class="form-group">' +

                                            '<label for="example-text-input" class="col-form-label">SKU:</label>' +

                                            '<input type="text"  class="form-control" name="sku[]" required placeholder="SKU" value="' +
                                            data.sku + '" style="width:100%;" >' +

                                            '<input type="hidden" class="form-control" name="variant_id[]" value="' +
                                            data.variant_id + '" style="width:100%;" >' +

                                            '<input type="hidden" class="form-control" name="attribute_value[]" value="' +
                                            arrtibute_name[0].replace('"', '') + ',' + arrtibute_name[1]
                                            .replace('"', '') + '" style="width:100%;" >' +

                                            '</div>' +

                                            '</div>' +

                                            '<div class="col-md-3">' +

                                            '<label for="example-text-input" class="col-form-label">Image</label>' +

                                            '<div class="input-group">' +

                                            '<span class="input-group-btn">' +

                                            '<a id="lfm" data-input="thumbnail' + data.variant_id +
                                            '" data-preview="holder' + data.variant_id +
                                            '" class="btn btn-primary lfm">' +

                                            '<i class="fa fa-picture-o"></i> Choose' +

                                            '</a>' +

                                            '</span>' +

                                            '<input id="thumbnail' + data.variant_id +

                                            '" required value="' + data.photo +
                                            '" class="form-control" type="text" name="photo[]">' +

                                            '</div>' +

                                            '<div id="holder' + data.variant_id +

                                            '" style="margin-top:15px;max-height:100px;"><img src="' + data
                                            .photo +
                                            '" alt="promo image"style="max-height: 90px;max-width:120px"></div>' +

                                            '</div>' +

                                            '<div class="col-md-3 ml-3">' +

                                            '<div class="form-group">' +

                                            '<label for="example-text-input" class="col-form-label">Regular Price:</label>' +

                                            '<input type="text"  class="form-control" value="' + data
                                            .regular_price +
                                            '" name="regular_price[]" required placeholder="Regular Price" style="width:100%;" >' +

                                            '</div>' +

                                            '</div>' +

                                            '<div class="col-md-3 ml-3">' +

                                            '<div class="form-group">' +

                                            '<label for="example-text-input" class="col-form-label">Sale Price:</label>' +

                                            '<input type="text"  class="form-control" name="sale_price[]" value="' +
                                            data.sale_price +
                                            '" required placeholder="Sale Price" style="width:100%;" >' +

                                            '</div>' +

                                            '</div>' +

                                            '<div class="col-md-3">' +

                                            '<div class="form-group">' +

                                            '<label for="example-text-input" class="col-form-label">Stock:</label>' +

                                            '<input type="text"  class="form-control" name="stock[]" value="' +
                                            data.stock + '" placeholder="Stock" style="width:100%;" >' +

                                            '</div>' +

                                            '</div>' +

                                            '</div>' +

                                            '</div>' +

                                            '</div></div>';

                                        $('.variant').append(details);

                                        $('.lfm').filemanager('image');

                                        //  console.log($('#chil_cat_id2').val());

                                    }

                                    // console.log(variant);

                                }

                            }

                        });

                        //

                    }

                });

            }

            product_attribute('{{ $Product->id }}');
        </script>
    @endsection
