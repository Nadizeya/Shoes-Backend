@extends('layouts.auth')

@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('vendors/styles/core.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('vendors/styles/icon-font.min.css') }}">
@endsection

@section('main')
<div class="login-wrap d-flex align-items-center flex-wrap justify-content-center">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6 col-lg-7">
                <img src="{{ asset('vendors/images/login-page-img.png') }}" alt="">
            </div>
            <div class="col-md-6 col-lg-5">
                <div class="login-box bg-white box-shadow border-radius-10">
                    <div class="login-title">
                        <h2 class="text-center text-primary">Register To SneakersBuy</h2>
                    </div>
                    <form method="POST" action="{{ route('admin.register') }}">
                        @csrf
                        <div class="form-group">
                            <label for="username" class="col-form-label pr-2">Username:</label>
                            <div class="input-group custom">
                                <input type="text" class="form-control form-control-lg" id="username" name="name" placeholder="Username" required>
                                <div class="input-group-append custom">
                                    <span class="input-group-text"><i class="icon-copy dw dw-user1"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email" class="col-form-label pr-2">Email:</label>
                            <div class="input-group custom">
                                <input type="text" class="form-control form-control-lg" id="email" name="email" placeholder="Email" required>
                                <div class="input-group-append custom">
                                    <span class="input-group-text"><i class="icon-copy dw dw-user1"></i></span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="phone" class="col-form-label pr-2">Phone Number:</label>
                            <div class="input-group custom">
                                <input type="text" class="form-control form-control-lg" id="phone" name="phone" placeholder="09********" required>
                                <div class="input-group-append custom">
                                    <span class="input-group-text"><i class="icon-copy dw dw-phone"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="password" class="col-form-label pr-2">Password:</label>
                            <div class="input-group custom">
                                <input type="password" class="form-control form-control-lg" id="password" name="password" placeholder="**********" required>
                                <div class="input-group-append custom">
                                    <span class="input-group-text"><i class="dw dw-padlock1"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation" class="col-form-label pr-2">Confirm Password:</label>
                            <div class="input-group custom">
                                <input type="password" class="form-control form-control-lg" id="password_confirmation" name="password_confirmation" placeholder="**********" required>
                                <div class="input-group-append custom">
                                    <span class="input-group-text"><i class="dw dw-padlock1"></i></span>
                                </div>
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
                                <div class="forgot-password"><a href="#">Forgot Password</a></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="input-group mb-0">
                                    <input class="btn btn-primary btn-lg btn-block" type="submit" value="Register">
                                </div>
                                <div class="font-16 weight-600 pt-10 pb-10 text-center" data-color="#707373">OR</div>
                                <div class="input-group mb-0">
                                    <a class="btn btn-outline-primary btn-lg btn-block" href="{{ route('admin.login') }}">Login To Your Account</a>
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
<script src="{{ asset('src/plugins/jquery-steps/jquery.steps.js') }}"></script>
<script src="{{ asset('vendors/scripts/steps-setting.js') }}"></script>
@endsection
