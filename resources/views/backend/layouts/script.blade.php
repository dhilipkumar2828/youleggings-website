<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/js/modernizr.min.js') }}"></script>
<script src="{{ asset('assets/js/detect.js') }}"></script>
<script src="{{ asset('assets/js/fastclick.js') }}"></script>
<script src="{{ asset('assets/js/jquery.slimscroll.js') }}"></script>
<script src="{{ asset('assets/js/jquery.blockUI.js') }}"></script>
<script src="{{ asset('assets/js/waves.js') }}"></script>
<script src="{{ asset('assets/js/jquery.nicescroll.js') }}"></script>
<script src="{{ asset('assets/js/jquery.scrollTo.min.js') }}"></script>

<!-- skycons -->
<script src="{{ asset('assets/plugins/skycons/skycons.min.js') }}"></script>

<!-- skycons -->
<script src="{{ asset('assets/plugins/peity/jquery.peity.min.js') }}"></script>

<script src="{{ asset('assets/plugins/parsleyjs/parsley.min.js') }}"></script>

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

<!-- Datatable init js -->
<script src="{{ asset('assets/pages/datatables.init.js') }}"></script>

<script src="{{ asset('assets/plugins/RWD-Table-Patterns/dist/js/rwd-table.min.js') }}"></script>

<!-- App js -->
<script src="{{ asset('assets/js/app.js') }}"></script>

<!--Morris Chart-->
<script src="{{ asset('assets/plugins/morris/morris.min.js') }}"></script>
<script src="{{ asset('assets/plugins/raphael/raphael-min.js') }}"></script>

<!-- dashboard -->
<script src="{{ asset('assets/pages/dashboard.js') }}"></script>

<script src="{{ asset('assets/plugins/tinymce/tinymce.min.js') }}"></script>

<script src="{{ asset('assets/plugins/summernote/summernote-bs4.min.js') }}"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="{{ asset('assets/js/jquery.multifield.min.js') }}"></script>

<script>
    var route_prefix = "{{ url('admin/laravel-filemanager') }}";
</script>
<script src="{{ asset('assets/js/main.js?v=2.2') }}"></script>

<script src="{{ asset('assets/switch-button-bootstrap/src/bootstrap-switch-button.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script src="{{ asset('/vendor/laravel-filemanager/js/stand-alone-button.js') }}"></script>
@yield('scripts')
<script>
    // setInterval(function(){
    //   var xhttp = new XMLHttpRequest();
    //   xhttp.onreadystatechange = function() {
    //     if (this.readyState == 4 && this.status == 200) {
    //       let data=JSON.parse(this.responseText);

    //      document.getElementById("notify_count").innerHTML = data.notifi_count;
    //      let list='';
    //      $.each(data.new_order,function(k,v){
    //       list +='<a href="/view_detail/'+v.id+'" class="dropdown-item notify-item">'+
    //                         '<div class="notify-icon"><img src="assets/images/users/user-2.jpg" alt="user-img" class="img-fluid rounded-circle"> </div>'+
    //                         '<p class="notify-details">'+v.order_id+'<br>Your Order is Placed<br><b>'+v.title+' - ₹'+v.total+'</b><span class="text-muted text-warning">'+v.status+'</span></p>'+
    //                     '</a>';
    //      });
    //      document.getElementById("notification_list").innerHTML = list;
    //     }
    //   };
    //   xhttp.open("GET", "/notifications", true);
    //   xhttp.send();

    // },5000
    // );

    // 
</script>

<script>
    $(document).ready(function() {
        // Initialize Parsley with custom options for better styling
        // Exclude summernote textareas and multi-step forms to prevent infinite change-event loop
        try {
            var $forms = $('form').not('.no-parsley');
            if ($forms.length > 0) {
                // Add custom Indian phone validator to Parsley
                window.Parsley.addValidator('phoneindia', {
                    validateString: function(value) {
                        return /^[6-9]\d{9}$/.test(value.replace(/\s+/g, ""));
                    },
                    messages: {
                        en: 'Please enter a valid 10-digit Indian phone number.'
                    }
                });

                // Add custom Indian pincode validator to Parsley
                window.Parsley.addValidator('pincodeindia', {
                    validateString: function(value) {
                        return /^\d{6}$/.test(value);
                    },
                    messages: {
                        en: 'Please enter a valid 6-digit pincode.'
                    }
                });

                // Add custom alphabets only validator to Parsley
                window.Parsley.addValidator('alphabetsOnly', {
                    validateString: function(value) {
                        return /^[a-zA-Z\s]+$/.test(value);
                    },
                    messages: {
                        en: 'Only alphabets are allowed.'
                    }
                });

                $forms.parsley({
                    errorClass: 'parsley-error',
                    successClass: 'parsley-success',
                    errorsWrapper: '<ul class="parsley-errors-list filled"></ul>',
                    errorTemplate: '<li></li>',
                    excluded: 'input[type=hidden], .summernote, [data-parsley-excluded]',
                    errorsContainer: function(ParsleyField) {
                        var $element = ParsleyField.$element;
                        if ($element.closest('.input-group').length) {
                            return $element.closest('.input-group').parent();
                        }
                        if ($element.is('select') && $element.hasClass('select2-hidden-accessible')) {
                            return $element.parent();
                        }
                        return $element.parent();
                    }
                });
            }
        } catch (e) {
            console.warn('Parsley init skipped:', e.message);
        }

        setTimeout(function() {
            $('#alert').slideUp(500);
        }, 4000);
    });

    $(function() {
        $('.table-responsive').responsiveTable({
            addDisplayAllBtn: true,
            addFocusBtn: false
        });
    });

    $('.has_sub ul li a').click(function() {
        $(this).parent().toggleClass('active')
    })
</script>

<script>
    $('#lfm').filemanager('image', {
        prefix: route_prefix
    });
    $('#lfm1').filemanager('image', {
        prefix: route_prefix
    });
    $('#lfm2').filemanager('image', {
        prefix: route_prefix
    });
</script>
<script>
    $(document).ready(function() {
        if ($("#elm1").length > 0) {
            tinymce.init({
                selector: "textarea#elm1",
                theme: "modern",
                height: 300,
                plugins: [
                    "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
                    "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                    "save table contextmenu directionality emoticons template paste textcolor"
                ],
                toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor emoticons",
                style_formats: [{
                        title: 'Bold text',
                        inline: 'b'
                    },
                    {
                        title: 'Red text',
                        inline: 'span',
                        styles: {
                            color: '#ff0000'
                        }
                    },
                    {
                        title: 'Red header',
                        block: 'h1',
                        styles: {
                            color: '#ff0000'
                        }
                    },
                    {
                        title: 'Example 1',
                        inline: 'span',
                        classes: 'example1'
                    },
                    {
                        title: 'Example 2',
                        inline: 'span',
                        classes: 'example2'
                    },
                    {
                        title: 'Table styles'
                    },
                    {
                        title: 'Table row 1',
                        selector: 'tr',
                        classes: 'tablerow1'
                    }
                ]
            });
        }
    });
</script>
