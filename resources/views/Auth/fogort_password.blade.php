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
                <li><a href="{{route('admin.login')}}">Login</a></li>
            </ul>
        </div>
    </div>
</div>
<div class="login-wrap d-flex align-items-center flex-wrap justify-content-center">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <img src="{{asset('vendors/images/forgot-password.png')}}" alt="">
            </div>
            <div class="col-md-6">
                <div class="login-box bg-white box-shadow border-radius-10">
                    <div class="login-title">
                        <h2 class="text-center text-primary">Forgot Password</h2>
                    </div>
                    <h6 class="mb-20">Enter your email address to reset your password</h6>
                    <form method="POST" action="{{route('admin.sent_email')}}">
                        @csrf
                        <div class="input-group custom">
                            <input type="text" class="form-control form-control-lg" name="email" placeholder="Email">
                            <div class="input-group-append custom">
                                <span class="input-group-text"><i class="fa fa-envelope-o" aria-hidden="true"></i></span>
                            </div>
                        </div>
                        <div class="row align-items-center">
                            <div class="col-5">
                                <div class="input-group mb-0">


                                    <input class="btn btn-primary btn-lg btn-block" type="submit" value="Submit">

                                    {{-- <a class="btn btn-primary btn-lg btn-block" href="index.html">Submit</a> --}}
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="font-16 weight-600 text-center" data-color="#707373">OR</div>
                            </div>
                            <div class="col-5">
                                <div class="input-group mb-0">
                                    <a class="btn btn-outline-primary btn-lg btn-block" href="{{route('admin.login')}}">Login</a>
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
