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
                                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Profile</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 mb-30">
                    <div class="pd-20 card-box height-100-p">
                        <div class="profile-info card-box">
                            <h5 class="mb-20 h4 text-blue text-center">Edit Profile</h5>
                        </div>

                        <br>

                        <form action="{{ route('user.settings.update') }}" method="POST">
                            @csrf
                            <ul class="profile-edit-list row">
                                <li class="weight-500 col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Full Name</label>
                                        <input name="name" class="form-control form-control-lg" type="text" value="{{ old('name', Auth::user()->name) }}">
                                    </div>

                                    <div class="form-group">
                                        <label>Email</label>
                                        <input name="email" class="form-control form-control-lg" type="email" value="{{ old('email', Auth::user()->email) }}">
                                    </div>

                                    <div class="form-group">
                                        <label>Date of Birth</label>
                                        <input name="dob" class="form-control form-control-lg date-picker" type="text" value="{{ old('dob', Auth::user()->dob) }}">
                                    </div>

                                    <div class="form-group">
                                        <label>Gender</label>
                                        <div class="d-flex">
                                            <div class="custom-control custom-radio mb-5 mr-20">
                                                <input type="radio" id="genderMale" name="gender" class="custom-control-input" value="male" {{ old('gender', Auth::user()->gender) == 'male' ? 'checked' : '' }}>
                                                <label class="custom-control-label weight-400" for="genderMale">Male</label>
                                            </div>
                                            <div class="custom-control custom-radio mb-5">
                                                <input type="radio" id="genderFemale" name="gender" class="custom-control-input" value="female" {{ old('gender', Auth::user()->gender) == 'female' ? 'checked' : '' }}>
                                                <label class="custom-control-label weight-400" for="genderFemale">Female</label>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="form-group">
                                        <label>Date of Birth</label>
                                        <input name="dob" class="form-control form-control-lg date-picker" type="text" value="{{ old('dob', Auth::user()->dob) }}">
                                    </div>

                                    <div class="form-group">
                                        <label>Address</label>
                                        <textarea name="address" class="form-control">{{ old('address', Auth::user()->address) }}</textarea>
                                    </div>

                                </li>
                                <li class="weight-500 col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Phone Number</label>
                                        <input name="phone" class="form-control form-control-lg" type="text" value="{{ old('phone', Auth::user()->phone) }}">
                                    </div>

                                    <div class="form-group">
                                        <label>Country</label>
                                        <input name="country" class="form-control form-control-lg" type="text" value="{{ old('Country', Auth::user()->Country) }}" placeholder="Paste your link here" readonly>
                                    </div>

                                    <div class="form-group">
                                        <label>State/Province/Region</label>
                                        <input name="state" class="form-control form-control-lg" type="text" value="{{ old('state', Auth::user()->state) }}">
                                    </div>

                                    <div class="form-group">
                                        <label>Postal Code</label>
                                        <input name="postal_code" class="form-control form-control-lg" type="text" value="{{ old('postal_code', Auth::user()->postal_code) }}">
                                    </div>

                                    <div class="form-group">
                                        <label>Facebook URL :</label>
                                        <input name="facebook_url" class="form-control form-control-lg" type="text" value="{{ old('facebook_url', Auth::user()->facebook_url) }}" placeholder="Paste your facebook link here">
                                    </div>
                                    <div class="form-group">
                                        <label class="fn-18">Viber URL :</label>
                                        <input name="viber" class="form-control form-control-lg" type="text" value="{{ old('viber', Auth::user()->viber) }}" placeholder="Paste your viber link here">
                                    </div>
                                    <div class="form-group">
                                        <label>Telegram URL :</label>
                                        <input name="telegram" class="form-control form-control-lg" type="text" value="{{ old('telegram', Auth::user()->telegram) }}" placeholder="Paste your telegram link here">
                                    </div>







                                </li>

                            </ul>
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
@endsection
