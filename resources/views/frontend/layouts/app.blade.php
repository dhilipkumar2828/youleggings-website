<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'You Leggings | Premium Comfort')</title>
  <meta name="description" content="@yield('meta_description', 'Discover premium comfort with You Leggings. Luxury made affordable.')">
  
  <link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}?v={{ time() }}">
  <style>
    .invalid-feedback {
      color: #e53935 !important;
      display: block;
      font-size: 13px;
      font-weight: 600;
      margin-top: 5px;
      text-transform: uppercase;
    }
    input.is-invalid, select.is-invalid, textarea.is-invalid {
      border-color: #e53935 !important;
      background-color: #fff8f8 !important;
    }
  </style>
  
  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <!-- jQuery Validation -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
  <!-- SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <!-- Lucide Icons -->
  <script src="https://unpkg.com/lucide@latest"></script>
  
  @yield('styles')
</head>

<body class="@php
    $routeName = request()->route() ? request()->route()->getName() : '';
    if ($routeName === 'index' || !$routeName) {
        echo '';
    } else {
        $baseName = str_replace(['_detail'], [''], $routeName);
        echo $baseName . '-page-active';
    }
@endphp">

  @include('frontend.partials.header')

  <main>
    @yield('content')
  </main>

  @include('frontend.partials.footer')

  @if(session('success'))
    <script>
      Swal.fire({
        icon: 'success',
        title: 'Success!',
        text: "{{ session('success') }}",
        timer: 3000,
        showConfirmButton: false,
        background: '#fff',
        iconColor: '#ec407a',
        customClass: {
          title: 'swal-title-premium',
          popup: 'swal-popup-premium'
        }
      });
    </script>
  @endif

  @if(session('error'))
    <script>
      Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: "{{ session('error') }}",
        background: '#fff',
        iconColor: '#ff5e5e'
      });
    </script>
  @endif

  <script src="{{ asset('frontend/js/main.js') }}"></script>
  <script>
    lucide.createIcons();

    // Global jQuery Validation Defaults
    if (typeof $.validator !== 'undefined') {
        $.validator.setDefaults({
            errorClass: 'invalid-feedback',
            highlight: function(element) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element) {
                $(element).removeClass('is-invalid');
            },
            errorPlacement: function(error, element) {
                if (element.parent('.input-group').length) {
                    error.insertAfter(element.parent());
                } else if (element.attr("type") == "checkbox" || element.attr("type") == "radio") {
                    error.insertAfter(element.closest('.form-group'));
                } else {
                    error.insertAfter(element);
                }
            }
        });

        // Custom validation for Indian phone numbers (exactly 10 digits)
        $.validator.addMethod("phoneIndia", function(phone_number, element) {
            phone_number = phone_number.replace(/\s+/g, "");
            return this.optional(element) || (phone_number.length === 10 && phone_number.match(/^[6-9]\d{9}$/));
        }, "Please enter a valid 10-digit Indian phone number starting with 6-9.");

        // Custom validation for Indian pincodes (exactly 6 digits)
        $.validator.addMethod("pincodeIndia", function(pincode, element) {
            return this.optional(element) || /^\d{6}$/.test(pincode);
        }, "Please enter a valid 6-digit pincode.");

        // Custom validation for alphabets only
        $.validator.addMethod("alphabetsOnly", function(value, element) {
            return this.optional(element) || /^[a-zA-Z\s]+$/.test(value);
        }, "Only alphabets are allowed.");
    }

    $(document).ready(function() {
        $('form.validate').validate();
    });
  </script>
  @yield('scripts')

</body>

</html>
