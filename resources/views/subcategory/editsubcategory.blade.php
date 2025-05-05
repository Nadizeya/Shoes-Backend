@extends('layouts.app')
@section('title','POS')
@section('css')

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

                                <li class="breadcrumb-item active" aria-current="page">Edit SubCategory</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 mb-30">
                    <div class="pd-20 card-box height-100-p">
                        <div class="profile-info card-box">
                            <h5 class="mb-20 h4 text-blue text-center">Edit SubCategory</h5>
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

                        <form action="{{ route('subcategories.update',$subcategory->id) }}" method="POST">

                            @method('PUT')


                            @csrf
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-12 col-12">
                                        <div class="input-group custom">
                                            <div class="input-group-prepend col-md-3">
                                                <span class="input-group-text">SubCategory Name</span>
                                            </div>
                                            <input type="text" class="form-control form-control-lg" placeholder="Enter Your SubCategory name" name="name" value="{{ $subcategory->name }}">
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


                                            <select name="category_id" class="form-select form-control form-control-lg" aria-label="Default select example">
                                                <option selected="">Open this select menu</option>
                                                @foreach($categories as $cat)
                                                <option value="{{ $cat->id }}" {{ $cat->id == $subcategory->category_id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                                @endforeach



                                            </select>


                                        </div>
                                    </div>





                                </div>

                                <div class="row">
                                    <div class="col-md-4 col-sm-12 mb-30"></div>
                                    <div class="col-md-4 col-sm-12 mb-30">
                                        <button type="submit" class="btn btn-primary m0">Update</button>
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
    Developed By Voom
</div>

@endsection

@section('js')

@endsection
