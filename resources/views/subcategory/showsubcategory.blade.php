@extends('layouts.app')
@section('title','POS')
@section('css')
<style>
    .myfoot {
        position: fixed;
        left: 0;
        bottom: 0;
    }

</style>
@endsection

@section('content')
<!--  Body Wrapper -->

<!-- Sidebar Start -->
<!--  Sidebar End -->
<!--  Header Start -->
@include('components.header')
<!--  Header End -->
@include('components.right_sidebar')
@include('components.left_sidebar')

<div class="main-container">
    <div class="pd-ltr-20 xs-pd-20-10">
        <div class="min-height-200px">
            <div class="page-header">
                <div class="row">
                    <div class="col-md-12">
                        <div class="title">
                            <h4>SubCategory</h4>
                        </div>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('subcategories.index')}}">SubCategory</a></li>

                                <li class="breadcrumb-item active" aria-current="page">Show SubCategory</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 mb-30">
                    <div class="pd-20 card-box height-100-p">
                        <div class="profile-info card-box">
                            <h5 class="mb-20 h4 text-blue text-center">Show SubCategory</h5>
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


                        <div class="container">
                            <div class="row">
                                <div class="col-md-12 col-12">
                                    <div class="input-group custom">
                                        <div class="input-group-prepend col-md-3">
                                            <span class="input-group-text">SubCategory Name</span>
                                        </div>
                                        <input type="text" class="form-control form-control-lg" placeholder="Enter Your SubCategory name" name="name" value="{{ $subcategory->name }}" readonly>
                                        <div class="input-group-append custom">
                                            <span class="input-group-text"><i class="icon-copy dw dw-user1"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-12">
                                    <div class="input-group custom">
                                        <div class="input-group-prepend col-md-3">
                                            <span class="input-group-text">Category Name</span>

                                        </div>
                                        <input type="text" class="form-control form-control-lg" placeholder="Enter Your SubCategory name" name="name" value="{{ $subcategory['category']['name'] }}" readonly>
                                        <div class="input-group-append custom">
                                            <span class="input-group-text"><i class="icon-copy dw dw-user1"></i></span>
                                        </div>





                                    </div>
                                </div>





                            </div>



                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="footer-wrap pd-20  card-box myfoot">
        Developed By Nay Oo Lwin
    </div>

    @endsection

    @section('js')

    @endsection
