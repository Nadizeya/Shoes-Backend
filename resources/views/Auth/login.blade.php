@extends('layouts.auth')
@section('main')

<div class="login-header box-shadow">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <div class="brand-logo">
            <a href="{{route('admin.login')}}" style="color: #323232;text-transform: capitalize">
                {{-- <img src="{{ asset('vendors/images/deskapp-logo.svg') }}" alt=""> --}}
                 <img src="{{asset('vendors/images/logo/logo-dark.png')}}" alt="" class="light-logo mr-2" width="50px" height="50px" >

                <span style="text-transform: capitalize">SneakersBuy</span>


            </a>


        </div>
        <div class="login-menu">
            <ul>
                <li><a href="{{ route('admin.register') }}">Register</a></li>
            </ul>
        </div>
    </div>
</div>

<div class="login-wrap d-flex align-items-center flex-wrap justify-content-center">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6 col-lg-7">
                <img src="{{ asset('vendors/images/login-page-img.png') }}" alt="">
            </div>
            <div class="col-md-6 col-lg-5">
                <div class="login-box bg-white box-shadow border-radius-10">
                    <div class="login-title">
                        <h2 class="text-center text-primary">Login To <span style="">Admin Dashboard</span></h2>
                    </div>

                    <!-- Display Validation Errors -->
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form method="POST" action="{{ route('admin.login') }}">
                        @csrf
                        <div class="input-group custom">
                            <input type="text" class="form-control form-control-lg" placeholder="Email" name="email" value="{{ old('email') }}">
                            <div class="input-group-append custom">
                                <span class="input-group-text"><i class="icon-copy dw dw-user1"></i></span>
                            </div>
                        </div>
                        <div class="input-group custom">
                            <input type="password" class="form-control form-control-lg" id="password" placeholder="**********" name="password">
                            <div class="input-group-append custom">
                                <span class="input-group-text">
                                    <i class="fas fa-eye-slash" id="togglePassword" style="cursor: pointer;"></i>
                                    {{-- <i class="fas fa-eye-slash" onclick="togglePassword()"></i> --}}



                                </span>
                            </div>
                        </div>
                        <div class="row pb-30">
                            <div class="col-6">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="customCheck1">
                                    <label class="custom-control-label" for="customCheck1">Remember</label>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="forgot-password"><a href="{{route('admin.forgot_password')}}">Forgot Password</a></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="input-group mb-0">
                                    <input class="btn btn-primary btn-lg btn-block" type="submit" value="Sign In">
                                </div>
                                <div class="font-16 weight-600 pt-10 pb-10 text-center" data-color="#707373">OR</div>
                                <div class="input-group mb-0">
                                    <a class="btn btn-outline-primary btn-lg btn-block" href="{{ route('admin.register') }}">Register To Create Account</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
{{-- <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script> --}}
<script>
    // function togglePassword() {
    //     var passwordField = document.getElementById("password");
    //     if (passwordField.type === "password") {
    //         passwordField.type = "text";
    //     } else {
    //         passwordField.type = "password";
    //     }
    // }
    document.addEventListener("DOMContentLoaded", function() {
        const togglePassword = document.querySelector("#togglePassword");
        const password = document.querySelector("#password");

        togglePassword.addEventListener("click", function() {
            // Toggle the type attribute of the password input field
            const type = password.getAttribute("type") === "password" ? "text" : "password";
            password.setAttribute("type", type);

            // Toggle the icon class to switch between eye and eye-slash
            this.classList.toggle("fa-eye");
            this.classList.toggle("fa-eye-slash");
        });
    });

</script>
@endsection
