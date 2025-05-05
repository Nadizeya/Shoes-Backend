<!DOCTYPE html>
<html>
<head>
    <!-- Basic Page Info -->
    <meta charset="utf-8">
    <title>SneakersBuy</title>

    <!-- Site favicon -->
    {{-- <link rel="apple-touch-icon" sizes="180x180" href="{{asset('vendors/images/apple-touch-icon.png')}}">


    <link rel="icon" type="image/png" sizes="32x32" href="{{asset('vendors/images/favicon-32x32.png')}}">


    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('vendors/images/favicon-16x16.png')}}"> --}}
    <link rel="apple-touch-icon" sizes="180x180" href="{{asset('vendors/images/logo/logo-dark.png')}}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{asset('vendors/images/logo/logo-dark.png')}}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('vendors/images/logo/logo-dark.png')}}">



    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    @yield('css')
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/styles/core.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/styles/icon-font.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/styles/style.css')}}">

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-119386393-1"></script>
    <script src="https://kit.fontawesome.com/34ce5b6af8.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">




    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'UA-119386393-1');

    </script>



</head>

<body class="login-page">

    @yield('main')
    <!-- js -->
    <script src="{{asset('vendors/scripts/core.js')}}"></script>


    <script src="{{asset('vendors/scripts/script.min.js')}}"></script>


    <script src="{{asset('vendors/scripts/process.js')}}"></script>


    <script src="{{asset('vendors/scripts/layout-settings.js')}}"></script>
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
