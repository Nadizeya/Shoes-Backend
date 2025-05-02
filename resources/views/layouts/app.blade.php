<!DOCTYPE html>
<html>
<head>
    <!-- Basic Page Info -->
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Nadi Yoon Htike</title>
    <!-- Site favicon -->
    {{-- <link rel="apple-touch-icon" sizes="180x180" href="vendors/images/apple-touch-icon.png"> --}}
    <link rel="apple-touch-icon" sizes="180x180" href="{{asset('vendors/images/logo/logo-dark.svg')}}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{asset('vendors/images/logo/logo-dark.svg')}}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('vendors/images/logo/logo-dark.svg')}}">

    {{-- <link rel="icon" type="image/png" sizes="32x32" href="vendors/images/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="vendors/images/favicon-16x16.png"> --}}

    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/styles/core.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/styles/icon-font.min.css')}}">


    <link rel="stylesheet" type="text/css" href="{{asset('src/plugins/datatables/css/dataTables.bootstrap4.min.css')}}">


    <link rel="stylesheet" type="text/css" href="{{asset('src/plugins/datatables/css/responsive.bootstrap4.min.css')}}">


    <link rel="stylesheet" type="text/css" href="{{asset('vendors/styles/style.css')}}">
    <script src="https://kit.fontawesome.com/34ce5b6af8.js" crossorigin="anonymous"></script>
    {{-- <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script> --}}
<script src="{{asset('/assets/tinymce/tinymce.min.js')}}" referrerpolicy="origin"></script>





    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    @yield('css')



    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-119386393-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'UA-119386393-1');

    </script>




</head>
<body>
    {{-- <div class="pre-loader">
        <div class="pre-loader-box">
            <div class="loader-logo"><img src="vendors/images/deskapp-logo.svg" alt=""></div>
            <div class='loader-progress' id="progress_div">
                <div class='bar' id='bar1'></div>
            </div>
            <div class='percent' id='percent1'>0%</div>
            <div class="loading-text">
                Loading...
            </div>
        </div>
    </div> --}}
    @yield('content')
    <!-- js -->
    <script src="{{asset('vendors/scripts/core.js')}}"></script>


    <script src="{{asset('vendors/scripts/script.min.js')}}"></script>


    <script src="{{asset('vendors/scripts/process.js')}}"></script>


    <script src="{{asset('vendors/scripts/layout-settings.js')}}"></script>


    <script src="{{asset('src/plugins/apexcharts/apexcharts.min.js')}}"></script>


    <script src="{{asset('src/plugins/datatables/js/jquery.dataTables.min.js')}}"></script>


    <script src="{{asset('src/plugins/datatables/js/dataTables.bootstrap4.min.js')}}"></script>


    <script src="{{asset('src/plugins/datatables/js/dataTables.responsive.min.js')}}"></script>


    <script src="{{asset('src/plugins/datatables/js/responsive.bootstrap4.min.js')}}"></script>


    <script src="{{asset('vendors/scripts/dashboard.js')}}"></script>
    {{-- <script src="{{asset('vendors/scripts/datatable-setting.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> --}}



    <link href="
https://cdn.jsdelivr.net/npm/@mdi/font@7.4.47/css/materialdesignicons.min.css
" rel="stylesheet">






    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        @if(Session::has('message'))
        var type = "{{ Session::get('alert-type','info') }}"
        switch (type) {
            case 'info':
                toastr.info(" {{ Session::get('message') }} ");
                break;

            case 'success':
                toastr.success(" {{ Session::get('message') }} ");
                break;

            case 'warning':
                toastr.warning(" {{ Session::get('message') }} ");
                break;

            case 'error':
                toastr.error(" {{ Session::get('message') }} ");
                break;
        }
        @endif

    </script>

    @yield('js')



</body>
</html>
