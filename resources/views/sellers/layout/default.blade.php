<!doctype html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="theme-color" content="#s000000">
    <title>Baby Daily | @yield('title', $page_title ?? '')</title>
    <meta name="description" content="@yield('page_description', $page_description ?? '')">
    <!-- <meta name="keywords" content="bootstrap 5, mobile template, cordova, phonegap, mobile, html" /> -->
    <link rel="icon" type="image/png" href="{{ URL::asset('assets/img/logo-babydaily.png') }}" sizes="32x32">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ URL::asset('assets/img/logo-babydaily.png') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/css/style.css') }}">
    <link rel="manifest" href="__manifest.json">
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/uicons-regular-rounded/css/uicons-regular-rounded.css'>
    <link rel="stylesheet" href="assets/css/custom-style.css">
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    
    @yield('extention')
    @yield('style')

</head>

<body class="windowsphone-detection android-detection ios-detection">

    <!-- loader -->
    <div id="loader">
        <div class="spinner-border text-primary" role="status"></div>
    </div>
    <!-- * loader -->

    <!-- App Header -->
    @if($header == 'seller_profile' && $roles == 5)
    @include('sellers.elements.header-profile')
    @elseif($header == 'seller_product' && $roles == 5)
    @include('sellers.elements.header-produk')
    @elseif($header == 'auth' && $roles == 5)
    @include('sellers.elements.header-auth')
    @endif
    <!-- * App Header -->

    <!-- Search Component -->
    @if($search == true)
    @include('sellers.elements.search')
    @elseif($search == 'seller_product')
    @include('sellers.elements.search-produk')
    @endif
    <!-- * Search Component -->

    <!-- Extra Header -->
    @if($extraHeader == true)
    @include('sellers.elements.extraHeader')
    @endif
    <!-- * Extra Header -->

    <!-- App Capsule -->
    <div id="appCapsule" class="{{ $extraHeader==true ? 'extra-header-active full-height' : '' }}">

        @yield('content')

        <!-- app footer -->
        @if($footer == true)
        @include('sellers.elements.footer')
        @endif
        <!-- * app footer -->

    </div>
    <!-- * App Capsule -->


    <!-- App Bottom Menu -->
    @if($bottom == true)
    @include('sellers.elements.bottomMenu')
    @endif
    <!-- * App Bottom Menu -->

    <!-- App Sidebar -->
    @if($sidebar == true && $roles != 5)
    @include('sellers.elements.sidebar')
    @elseif($sidebar == true && $roles == 5)
    @include('sellers.elements.sidebar')
    @endif
    <!-- * App Sidebar -->

    <!-- ============== Js Files ==============  -->
    <!-- Bootstrap -->
    <!-- jquery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <script src="{{ URL::asset('assets/js/lib/bootstrap.min.js') }}"></script>
    <!-- Ionicons -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <!-- Splide -->
    <script src="{{ URL::asset('assets/js/plugins/splide/splide.min.js') }}"></script>
    <!-- ProgressBar js -->
    <script src="{{ URL::asset('assets/js/plugins/progressbar-js/progressbar.min.js') }}"></script>
    <!-- Base Js File -->
    <script src="{{ URL::asset('assets/js/base.js') }}"></script>
    <!-- select2 -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    
    

    @stack('javascript-internal')

    <script type="text/javascript">
        CKEDITOR.replace('deskripsi');
    </script>

    <script>
        // Trigger welcome notification after 5 seconds
        setTimeout(() => {
            notification('notification-welcome', 5000);
        }, 2000);
    </script>

    @if($extraHeader == true)
    <script>
        function myFunction() {
            var input, filter, ul, li, a, i, txtValue;
            input = document.getElementById("myInput");
            filter = input.value.toUpperCase();
            ul = document.getElementById("myUL");
            li = ul.getElementsByTagName("li");
            for (i = 0; i < li.length; i++) {
                a = li[i].getElementsByTagName("a")[0];
                txtValue = a.textContent || a.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    li[i].style.display = "";
                } else {
                    li[i].style.display = "none";
                }
            }
        }
    </script>
    @endif

    @if($header == 'index')
    <script>
        filterSelection("all")

        function filterSelection(c) {
            var x, i;
            x = document.getElementsByClassName("filterDiv");
            if (c == "all") c = "";
            for (i = 0; i < x.length; i++) {
                w3RemoveClass(x[i], "show");
                if (x[i].className.indexOf(c) > -1) w3AddClass(x[i], "show");
            }
        }

        function w3AddClass(element, name) {
            var i, arr1, arr2;
            arr1 = element.className.split(" ");
            arr2 = name.split(" ");
            for (i = 0; i < arr2.length; i++) {
                if (arr1.indexOf(arr2[i]) == -1) {
                    element.className += " " + arr2[i];
                }
            }
        }

        function w3RemoveClass(element, name) {
            var i, arr1, arr2;
            arr1 = element.className.split(" ");
            arr2 = name.split(" ");
            for (i = 0; i < arr2.length; i++) {
                while (arr1.indexOf(arr2[i]) > -1) {
                    arr1.splice(arr1.indexOf(arr2[i]), 1);
                }
            }
            element.className = arr1.join(" ");
        }

        // Add active class to the current button (highlight it)
        var btnContainer = document.getElementById("myBtnContainer");
        var btns = btnContainer.getElementsByClassName("btn");
        for (var i = 0; i < btns.length; i++) {
            btns[i].addEventListener("click", function() {
                var current = document.getElementsByClassName("active");
                current[0].className = current[0].className.replace(" active", "");
                this.className += " active";
            });
        }
    </script>
    @endif

</body>

</html>