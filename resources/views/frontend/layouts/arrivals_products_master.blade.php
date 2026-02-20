<!DOCTYPE html>
<html>

<head>

    @include('frontend.layouts.arrivals_products_head')

    <style>
        h2,
        h3,
        h4,
        h5,
        h6 {
            margin-top: 10px;
            margin-bottom: 10px;
        }
    </style>

    <script src="https://cdn-in.pagesense.io/js/prrayashacollections/ecbfa283296f4c0ead43e9ddf0ba4302.js"></script>

</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                @include('backend.layouts.notification')
            </div>
        </div>
    </div>

    @include('frontend.layouts.arrivals_products_header')

    </section>

    @yield('content')

    @include('frontend.layouts.footer')

    @include('frontend.layouts.script')
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {

            // Clear the search input field when the page is fully loaded
            document.getElementById('SearchInput').value = '';
        });
        $(document).ready(function() {
            // Clear the search input field when the page is ready
            document.getElementById('SearchInput').value = '';
        });

        function isNumber(evt) {
            evt = (evt) ? evt : window.event;
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                return false;
            }
            return true;
        }
        // Function to clear the search input field and replace the URL to home page
        function clearSearchInput() {
            // Clear the search input field
            document.getElementById('SearchInput').value = '';
            // Replace the URL with the home page, so the query parameter is not visible in the URL
            history.replaceState(null, '', '/');
        }

        // Call this function on page load
        document.addEventListener('DOMContentLoaded', function() {
            // Check if product_name is in the URL
            if (window.location.search.indexOf('product_name') !== -1) {
                clearSearchInput(); // Clear the input and URL when loading the page
            }
        });

        // Optional: Check and clear search input when the back button is clicked
        window.onpopstate = function(event) {
            history.replaceState(null, '', '/');
            window.location.href = '/';
            // If there is a 'product_name' in the URL, clear the input
            if (window.location.search.indexOf('product_name') !== -1) {
                clearSearchInput(); // Clear the input field and reset the URL
            }
        };
    </script>

</body>

</html>
