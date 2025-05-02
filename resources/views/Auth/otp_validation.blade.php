@extends('layouts.auth')
@section('main')
<div class="login-header box-shadow">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <div class="brand-logo">
            <div class="brand-logo">
                <a href="{{route('admin.login')}}" style="color: #323232;text-transform: capitalize">
                    {{-- <img src="{{ asset('vendors/images/deskapp-logo.svg') }}" alt=""> --}}
                    <img src="{{asset('vendors/images/logo/logo-dark.svg')}}" alt="" class="light-logo mr-2" width="50px" height="50px" >

                    <span style="text-transform: capitalize">Nadi Yoon Htike</span>
                </a>
            </div>
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
                        <h2 class="text-center text-primary">OTP Validation</h2>
                    </div>
                    <h6 class="mb-20">Enter your OTP code from your email address</h6>
                    <form method="POST" action="{{route('admin.otp-validate')}}">

                        @csrf
                        <div class="input-group custom">
                            <input type="text" class="form-control form-control-lg" name="email" placeholder="Email" value="{{$email}}" readonly>
                            <div class="input-group-append custom">
                                <span class="input-group-text"><i class="fa fa-envelope-o" aria-hidden="true"></i></span>
                            </div>
                        </div>
                        <div class="input-group custom">
                            <input type="number" class="form-control form-control-lg" name="otp_code" placeholder="Enter Your OTP">
                            <div class="input-group-append custom">
                                <span class="input-group-text"><i class="fas fa-key" aria-hidden="true"></i></span>
                            </div>
                        </div>

                        <div class="row align-items-center">
                            <div class="col-12 text-center">
                                <div class="input-group mb-0 ">


                                    <input class="btn btn-primary btn-lg btn-block" type="submit" value="Submit">




                                </div>
                            </div>


                        </div>
                    </form>
                    <div class="row mt-3">
                        <form method="POST" action="{{route('admin.sent_email')}}">

                            @csrf

                            <input type="hidden" name="email" value="{{ $email }}">


                            <div class="col-12 ">
                                <button type="submit"  class="btn btn-link btn-lg btn-block text-center" id="resendOtpLink" >  Resend OTP (60s)</button>

                            </div>
                        </form>



                    </div>

                </div>
            </div>
        </div>
    </div>
    @endsection

    @section('js')

    <script>
        let countdown = 10; // 60 seconds countdown
        let timer;

        function startTimer() {
            document.getElementById('resendOtpLink').innerText = `Resend OTP (${countdown}s)`;
            timer = setInterval(function() {
                countdown--;
                if (countdown <= 0) {
                    clearInterval(timer);
                    document.getElementById('resendOtpLink').innerText = 'Resend OTP';
                    document.getElementById('resendOtpLink').style.pointerEvents = 'auto';
                } else {
                    document.getElementById('resendOtpLink').innerText = `Resend OTP (${countdown}s)`;
                }
            }, 1000);
        }



        document.addEventListener('DOMContentLoaded', (event) => {
            startTimer();
        });

    </script>

    @endsection
