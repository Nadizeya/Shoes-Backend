{{-- <!DOCTYPE html>
<html>
<head>
    <!-- Basic Page Info -->
    <meta charset="utf-8">
    <title>DeskApp - Bootstrap Admin Dashboard HTML Template</title>

    <!-- Site favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="vendors/images/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="vendors/images/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="vendors/images/favicon-16x16.png">

    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="vendors/styles/core.css">
    <link rel="stylesheet" type="text/css" href="vendors/styles/icon-font.min.css">
    <link rel="stylesheet" type="text/css" href="vendors/styles/style.css">

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
    <div class="login-header box-shadow">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <div class="brand-logo">
                <a href="login.html">
                    <img src="vendors/images/deskapp-logo.svg" alt="">
                </a>
            </div>
            <div class="login-menu">
                <ul>
                    <li><a href="login.html">Login</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="login-wrap d-flex align-items-center flex-wrap justify-content-center">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <img src="vendors/images/forgot-password.png" alt="">
                </div>
                <div class="col-md-6">
                    <div class="login-box bg-white box-shadow border-radius-10">
                        <div class="login-title">
                            <h2 class="text-center text-primary">Reset Password</h2>
                        </div>
                        <h6 class="mb-20">Enter your new password, confirm and submit</h6>
                        <form>
                            <div class="input-group custom">
                                <input type="text" class="form-control form-control-lg" placeholder="New Password">
                                <div class="input-group-append custom">
                                    <span class="input-group-text"><i class="dw dw-padlock1"></i></span>
                                </div>
                            </div>
                            <div class="input-group custom">
                                <input type="text" class="form-control form-control-lg" placeholder="Confirm New Password">
                                <div class="input-group-append custom">
                                    <span class="input-group-text"><i class="dw dw-padlock1"></i></span>
                                </div>
                            </div>
                            <div class="row align-items-center">
                                <div class="col-5">
                                    <div class="input-group mb-0">
                                        <!--
											use code for form submit
											<input class="btn btn-primary btn-lg btn-block" type="submit" value="Submit">
										-->
                                        <a class="btn btn-primary btn-lg btn-block" href="index.html">Submit</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- js -->
    <script src="vendors/scripts/core.js"></script>
    <script src="vendors/scripts/script.min.js"></script>
    <script src="vendors/scripts/process.js"></script>
    <script src="vendors/scripts/layout-settings.js"></script>
</body>
</html> --}}
@extends('layouts.app')
@section('title', 'POS')
@section('css')
<link rel="stylesheet" href="{{ asset('src/plugins/cropperjs/dist/cropper.css') }}">
<style>
    .image-preview {
        height: 200px !important;
        border-radius: 20%;
        margin: 0 auto;
    }

</style>
@endsection

@section('content')
@include('components.header')
@include('components.right_sidebar')
@include('components.left_sidebar')

<div class="main-container">
    <div class="pd-ltr-20 xs-pd-20-10">
        <div class="min-height-200px">
            <div class="page-header">
                <div class="row">
                    <div class="col-md-12">
                        <div class="title">
                            <h4>Profile</h4>
                        </div>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Change Password</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 mb-30">
                    <div class="pd-20 card-box height-100-p">
                        <div class="profile-info card-box">
                            <h5 class="mb-20 h4 text-blue text-center">Change password</h5>
                        </div>

                        <br>
                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif


                        <form action="{{ route('password.update') }}" method="POST">

                            @csrf
                            <div class="container">
                                <div class="row">
                                    <!-- Old Password Input Field -->
                                    <div class="col-md-12 col-12">
                                        <div class="input-group custom">
                                            <div class="input-group-prepend col-md-3">
                                                <span class="input-group-text">Old Password</span>
                                            </div>
                                            <input type="password" class="form-control form-control-lg" id="oldPassword" placeholder="**********" name="oldPassword" value="{{ old('oldPassword') }}">

                                            <div class="input-group-append custom">
                                                <span class="input-group-text">
                                                    <i class="fas fa-eye-slash" id="toggleOldPassword" style="cursor: pointer;"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- New Password Input Field -->
                                    <div class="col-md-12 col-12">
                                        <div class="input-group custom">
                                            <div class="input-group-prepend col-md-3">
                                                <span class="input-group-text">New Password</span>
                                            </div>
                                            <input type="password" class="form-control form-control-lg" id="newPassword" placeholder="**********" name="newPassword" value="{{ old('newPassword') }}">


                                            <div class="input-group-append custom">
                                                <span class="input-group-text">
                                                    <i class="fas fa-eye-slash" id="toggleNewPassword" style="cursor: pointer;"></i>
                                                </span>
                                            </div>

                                        </div>
                                    </div>

                                    <!-- Confirm New Password Input Field -->
                                    {{-- <div class="col-md-12 col-12">
                                        <div class="input-group custom">
                                            <div class="input-group-prepend col-md-3">
                                                <span class="input-group-text">Confirm New Password</span>
                                            </div>
                                            <input type="password" class="form-control form-control-lg" id="confirmNewPassword" placeholder="**********" name="password_confirmation" value="{{ old('password_confirmation') }}">



                                    <div class="input-group-append custom">
                                        <span class="input-group-text">
                                            <i class="fas fa-eye-slash" id="toggleConfirmNewPassword" style="cursor: pointer;"></i>
                                        </span>
                                    </div>
                                </div>
                            </div> --}}
                    </div>

                </div>



                <div class="row">
                    <div class="col-md-4 col-sm-12 mb-30">

                    </div>


                    <div class="col-md-4 col-sm-12 mb-30 ">
                        <button type="submit" class="btn btn-primary m0">Save</button>


                    </div>


                    <div class="col-md-4 col-sm-12 mb-30">
                        {{-- <button type="button" class="btn btn-danger text-primary text-right"> <a href="{{redirect()->back()}}"> Cancel <i class="fas fa-close"></i></a>

                        </button> --}}
                        <h2 class="card-title text-primary text-right text-decoration">
                            <a href="{{route('admin.profile')}}" class="badge badge-danger"> Cancel <i class="fas fa-close"></i></a>

                        </h2>







                    </div>



                </div>











                </form>
            </div>
        </div>
    </div>
</div>
</div>
</div>

<div class="footer-wrap pd-20 mb-20 card-box">
    Developed By Nay Oo Lwin
</div>
@endsection

@section('js')
<script src="{{ asset('src/plugins/cropperjs/dist/cropper.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        function setupPasswordToggle(toggleId, passwordId) {
            const togglePassword = document.getElementById(toggleId);
            const passwordInput = document.getElementById(passwordId);

            togglePassword.addEventListener('click', function() {
                // Toggle the type attribute
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);

                // Toggle the eye slash icon
                this.classList.toggle('fa-eye-slash');
                this.classList.toggle('fa-eye');
            });
        }

        // Setup toggles for each password input
        setupPasswordToggle('toggleOldPassword', 'oldPassword');
        setupPasswordToggle('toggleNewPassword', 'newPassword');
        setupPasswordToggle('toggleConfirmNewPassword', 'confirmNewPassword');
    });

</script>

@endsection
